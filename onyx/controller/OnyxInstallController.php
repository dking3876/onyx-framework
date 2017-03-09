<?php 
class OnyxInstallController extends OnyxController {
    
    protected $installationStage;
    
    protected $authKey;
    
    public function main(){
        $this->installationStage = isset($_GET['installer']) && ($_GET['installer'] != '' || $_GET['installer'] != null)? $_GET['installer'] : 'StartInstaller';
        $this->authKey = isset($_GET['auth']) ? $_GET['auth'] : '';
        $this->action = $method = "Onyx{$this->installationStage}";
        //$this->model = $this->model();
        $this->LoadDependancies();
        /*$this->model->styles();
        $this->model->footerScripts();
        */
        $this->pageTitle = "OnyxInstaller";
        $this->$method();
    }
    protected function LoadDependancies(){
        $adminCSS = array(
            "OnyxAdmin",
            "bootstrap"
            );
        $path = 'onyx';
        $this->model->styles($adminCSS, $path);
        $installerjs = array(
            array(
                'name'  => 'OnyxMaster',
                'type'  => 'external',
                'file'  => 'Onyx.js'
            ),
            array(
                'name'  => 'OnyxInstallation',
                'type'  => 'external',
                'file'  => 'installation.js'
            ),
            array(
                'name'  => 'OnyxModal',
                'type'  => 'external',
                'file'  => 'modal.js'
            )
        );
        $this->model->headerScripts('jquery', $path);
        $this->model->headerScripts($installerjs, $path);
    }
    protected function OnyxStartInstaller(){
        $auth = uniqid();
        $this->Onyx->viewData(array(
            'auth' => $auth,
            'authorized' => false
            ));
        $this->model->CheckSystemHealth();
        
        $this->renderPage('welcome.install');
        
    }
    protected function OnyxDatabaseSetup(){
        if($this->Onyx->query['OnyxAuth'] != $_GET['auth']){
            die('You do not have permission to Access this page');
        }
        $this->Onyx->viewData(array(
            "OnyxAuth" => $this->Onyx->query['OnyxAuth'],
            "authorized"    => false
            ));
        $this->renderPage($this->action);
    }
    protected function OnyxAppSetup(){
        //echo '<pre>'; var_dump($_POST);
        if($this->Onyx->query['OnyxAuth'] != $_GET['auth']){
            die('You do not have permission to Access this page');
        }
        $this->model->GenerateSalt();
        $this->model->GenerateCreds();
        $this->Onyx->viewData(array(
            "OnyxAuth" => $this->Onyx->query['OnyxAuth'],
            "authorized"    => false));
        $this->renderPage($this->action);
    }
    protected function OnyxInstallDatabase(){
        if($this->Onyx->query['OnyxAuth'] != $_GET['auth']){
            die('You do not have permission to Access this page');
        }
        $this->Onyx->viewData(array(
            "OnyxAuth" => $this->Onyx->query['OnyxAuth'],
            "authorized"    => false));
    }
    protected function OnyxInstallerProgress(){
        
        $this->model->Onyx->OnyxAuthenticate->login();
        header("LOCATION: " . BASE_URL . "onyx/admin");
    }
    public function requirementCheck(){
        echo "Checking System requirments";
        $check = $this->Onyx->query['requirement'];
        var_dump($check);;
    }
}
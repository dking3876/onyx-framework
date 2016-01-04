<?php 
class OnyxInstallController extends OnyxController {
    
    protected $installationStage;
    
    protected $authKey;
    
    public function main(){
        $this->installationStage = isset($_GET['installer']) && ($_GET['installer'] != '' || $_GET['installer'] != null)? $_GET['installer'] : 'StartInstaller';
        $this->authKey = isset($_GET['auth']) ? $_GET['auth'] : '';
        $this->action = $method = "Onyx{$this->installationStage}";
        $this->model = $this->model();
        $adminCSS = array(
            'type'  => 'external',
            'title' => 'OnyxMasterCSS',
            'file'  => 'OnyxAdmin.css'
            );
        $path = 'Onyx';
        $this->model->styles($adminCSS, $path);
        $installerjs = array(
            'type'  => 'external',
            'file'  => 'installation.js'
            );
        $this->model->headerScripts('jquery');
        $this->model->headerScripts($installerjs, $path);
        /*$this->model->styles();
        $this->model->styles();
        $this->model->styles();
        $this->model->styles();
        $this->model->headerScripts();
        $this->model->headerScripts();
        $this->model->headerScripts();
        $this->model->footerScripts();
        */

        $this->$method();
    }
    
    protected function OnyxStartInstaller(){
        $auth = uniqid();
        $this->Onyx->viewData(array('auth' => $auth));
        $this->model->CheckSystemHealth();
        $this->renderPage('welcome.install');
        
    }
    protected function OnyxDatabaseSetup(){
        if($this->Onyx->query['OnyxAuth'] != $_GET['auth']){
            die('You do not have permission to Access this page');
        }
        $this->Onyx->viewData(array("OnyxAuth" => $this->Onyx->query['OnyxAuth']));
        $this->renderPage($this->action);
    }
    protected function OnyxAppSetup(){
        //echo '<pre>'; var_dump($_POST);
        if($this->Onyx->query['OnyxAuth'] != $_GET['auth']){
            die('You do not have permission to Access this page');
        }
        $this->model->GenerateSalt();
        $this->model->GenerateCreds();
        $this->Onyx->viewData(array("OnyxAuth" => $this->Onyx->query['OnyxAuth']));
        $this->renderPage($this->action);
    }
    protected function OnyxInstallDatabase(){
        if($this->Onyx->query['OnyxAuth'] != $_GET['auth']){
            die('You do not have permission to Access this page');
        }
        $this->Onyx->viewData(array("OnyxAuth" => $this->Onyx->query['OnyxAuth']));
    }
    protected function OnyxInstallerProgress(){
        
    }
}
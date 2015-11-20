<?php 
class OnyxInstallController extends OnyxController {
    
    protected $installationStage;
    
    protected $authKey;
    
    public function main(){
        $this->installationStage = isset($_GET['installer']) && ($_GET['installer'] != '' || $_GET['installer'] != null)? $_GET['installer'] : 'StartInstaller';
        $this->authKey = isset($_GET['auth']) ? $_GET['auth'] : '';
        $this->action = $method = "Onyx{$this->installationStage}";
        $this->model = $this->model();
        $this->$method();
    }
    
    protected function OnyxStartInstaller(){
        
        $this->model->styles(array('file'=>'testing.css'), 'Onyx');
        $auth = $this->model->GenerateSalt();
        $this->Onyx->viewData(array('auth' => $auth));
        //Get install authorization here with method call
        $this->renderPage('welcome.install');
    }
    protected function OnyxDatabaseSetup(){
        $this->renderPage($this->action);
    }
    
    protected function OnyxInstallDatabase(){
        if(!isset($_POST[''])){
            return false;   
        }
    }
    protected function OnyxAppSetup(){
        $this->renderPage($this->action);
    }
}
<?php 
class WelcomeController extends OnyxController {

    public function main(){
        
         $this->renderPage('welcome');
    }
    public function test($myvar, $testing){
        var_dump($myvar, $testing);
        echo 'test';   
    }

}
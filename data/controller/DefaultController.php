<?php 
/**
 * Default Controller for loading when no controller found
 *
 * Onyx Provides a default controller for loading when $args[0] is not found or is empty
 * @package Onyx Controllers
 * @author Deryk W. King
 * @version 1
 * @Extended
 */

class DefaultController extends OnyxController{
    /**
     * [[Description]]
     */
    public function main(){
        //echo $this->setting("first_setting");
        $this->model->headerScripts('jquery');
        $this->model->headerScripts('bootstrap');
        $this->model->headerScripts(array(
            'name'  => 'testingscript',
            'file'  => 'test.js',
            'type'  => 'external'
            ));
        $this->renderPage('default');
    }
}
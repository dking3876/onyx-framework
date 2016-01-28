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
        $this->model->headerScripts('jquery', 'onyx');
        $this->model->headerScripts('bootstrap', 'onyx');
        //$this->model->headerScripts(array(
            'name'  => 'testingscript',
            'file'  => 'test.js',
            'type'  => 'external'
            ));
        //$this->model->styles(array(
            'name'  => 'welcome',
            'file'  => 'welcome.css',
            'type'  => 'external'
            ));
        $this->model->styles(array(
            'name'  => 'reset',
            'file'  => 'html5reset.css',
            'type'  => 'external'
            ), 'onyx');
        $this->renderPage('default');
    }
}
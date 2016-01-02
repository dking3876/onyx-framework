<?php

class OnyxErrorHandler{
    
    static $instance = null;
    
    public $handles = array();
    
    private function __construct(){
        
    }
    
    static function GetInstance(){
        if(self::$instance == null){
            self::$instance = new OnyxErrorHandler();
        }
        return self::$instance;
    }
    
    public function OnyxError(Exception $e){
        
    }
    
    public function LogError($e, $handle){
        
    }
    
    public function RecordError($e, $handle){
        
    }
    
    public function NewLog($handle){
        
    }
    
}
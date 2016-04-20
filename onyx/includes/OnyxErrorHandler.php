<?php

class OnyxErrorHandler{
    
    static $instance = null;
    
    public $handles = array();
    
    private function __construct(){
        set_exception_handler(array($this, 'OnyxError'));
    }
    
    static function GetInstance(){
        if(self::$instance == null){
            self::$instance = new OnyxErrorHandler();
        }
        return self::$instance;
    }
    
    public static function OnyxError(Exception $e){
        self::LogException($e, 'Onyx');
    }
    
    public static function LogError($e, $handle){
        $onyx = self::$instance;
    }
    
    public static function LogException($e, $handle){
        $onyx = self::$instance;
    }
    
    public static function RecordError($e, $handle){
        $onyx = self::$instance;
    }
    
    public static function NewLog($handle){
        $onyx = self::$instance;
        if(!array_search($instance, $this->handles)){
            $this->handles[] = $instance; 
        }
    }
    
}

class OnyxError{

    private $handler;
    
    public $errors = array();
    
    public $errorCodes = array();
    
    public function __construct($handle, $message = null, $code = null){
        $this->handler = OnyxErrorHandler::GetInstance();
       
    }
    
    public function getLast(){
        return $this->errors;   
    }

}
<?php
final class OnyxCredentialsService implements IOnyxCreds{
    
    static $instance = null;
    private function __construct(){
        
    }
    
    static function getInstance(){
        if(self::$instance == null){
            self::$instance = new self();
            return self::$instance;
        }
        return null;
    }
    public function getCreds(){
        $host =  IOnyxCreds::HOST;
        $user = IOnyxCreds::USER;
        $pass = IOnyxCreds::PASS;
        $db = IOnyxCreds::DB;
        $connect = IOnyxCreds::CONNECTION;
        
        return array(
            'host'  => $host,
            'user'  => $user,
            'pass'  => $pass,
            'db'    => $db,
            'connect'   => $connect
            );
    }
}
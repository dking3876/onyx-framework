<?php

interface IOnyxConnection{

    public function insertData($table, $args);
    
    public function retrieveData($table, $data, $conditions = NULL);
        
    public function updateData($table, $args, $condition=null);
    
    public function deleteData($table, $args, $condition=null);
    
    static function GetInstance($args);
        
    public function getDb();
    
    public function getUser();
            
        
}
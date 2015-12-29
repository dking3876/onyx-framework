<?php 
class OnyxConnectionService implements IOnyxCreds {
    
    static $instance = null;
    
    protected $connection;
    
    private $type = null;
    
    public $ENV;
    
    public $errorDisplay = false;
    
    private $connect;
    
    final protected function __construct(OnyxUtilities $onyxUtilities ){
       //Get from setup onyx file under supported connections
        $connectionTypes = $onyxUtilities->ReadOnyxFile('connections', 'supportedType');
        $this->ENV = IOnyxCreds::ENV;
        if($this->ENV != 'LIVE'){
            $this->errorDisplay = true;
        }
        $host =  IOnyxCreds::HOST;
        $user = IOnyxCreds::USER;
        $pass = IOnyxCreds::PASS;
        $db = IOnyxCreds::DB;
        $this->connect = $connect = IOnyxCreds::CONNECTION;
        if($connectionTypes == null){
             echo '<h1>Database Connection Error No valid connection type found</h1>';
            die();
        }
        foreach($connectionTypes as $connect){
            //check if onyx supports connection type by checking for the existance of the {connection}Connect.php file and ensure that 
            if(file_exists(ONYX_PATH . 'setting/database/'.$connect.'DBConnect.php') && ($this->connect == $connect) ){
                require_once ONYX_PATH . 'setting/database/'.$connect.'DBConnect.php';
                //Build connection string
                $dbConnect = $connect.'DBConnect';
                
                $this->connection = $dbConnect::GetInstance( array(
                    $host,
                    $user,
                    $pass,
                    $db,
                    $this->ENV,
                    $this->errorDisplay
                ));
                //loader the dataloader.php
                //gonna need to pass this->connection to access the connection 
                $this->type = $connect;
            }
        }
        if($this->type === null){
            echo '<h1>Database Connection Error</h1>';
            die();
        }
        
    }
    
    static function GetInstance(){
        if(self::$instance == null){
            self::$instance = new OnyxConnectionService(new OnyxUtilities());
        }
        return self::$instance;
    }
    
    public function save($args = array()){
        $result = $this->connection->insertData($args['table'], $args['keyvaluepairs']);
        return $result;
    }
    
    public function delete($args = array()){
        $result = $this->connection->deleteData($args['table'], $args['data'], $args['conditions']);
        return $result;
    }
    
    public function addTable($args = array()){
        $result = $this->connection->createTable($args['table'], $args['fields']);
        return $result;
    }
    
    public function update($args = array()){
        $result = $this->connection->updateData($args['table'], $args['keyvaluepairs'], $args['conditions']);
        return $result;
    }
    
    public function addUser($args = array()){
        $result = $this->connection->save();
        return $result;
    }
    
    public function updateUser($args = array()){
        $result = $this->connection->save();
    }
    public function deleteUser($args = array()){
        $result = $this->connection->deleteData();
    }
    
    public function addSetting($args = array()){
        $result = $this->connection->insertData();
    }
    
    public function editSettings($args = array()){
        $result = $this->connection->updateData();
    }
    
    public function deleteSettings($args = array()){
        $result = $this->connection->deleteData();
    }
}
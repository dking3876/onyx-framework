<?php 
class OnyxConnection  {
    
    static $instance = null;
    
    protected $connection;
    
    private $type = null;
    
    final protected function __construct(){
       
        $connectionTypes = array(
            'MySQL',
            'PDO',
            'MongoDB',
            'PostgreSQL',
            'SQLite',
            'SQLite3'
            );
        foreach($connectionTypes as $connect){
            do{
                if(file_exists(ONYX_PATH . 'settings/database/'.$connect.'Connect.php')){
                    require_once ONYX_PATH . 'settings/database/'.$connect.'Connect.php';
                    $this->connection = DBConnect::GetInstance();
                    $this->type = $connect;
                }
            }while($this->type == null);
        }
        
    }
    
    static function GetInstance(){
        if(OnyxConnection::$instance == null){
            OnyxConneciton::$instance = new OnyxConnection();
        }
        return OnyxConnection::$instance;
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
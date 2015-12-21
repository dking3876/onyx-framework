<?php 
//require_once(BASE_PATH . 'settings/IOnyxCreds.php');
/*
*
* DBConnect class for use with the Brafton Update API for plugins and modules
*
*/
class MySQLDBConnect implements IOnyxConnection{
    private $host;
    private $user;
    private $pass;
    private $db;
    protected $connection;    
    static $instance = null;
    
    //constuct the db connection
    public function __construct($args){
        $this->host = $args[0];
        $this->user = $args[1];
        $this->pass = $args[2];
        $this->db = $args[3];
        $this->connection = $this->hook();
    }
    static function GetInstance($args){
        if(self::$instance == null){
          self::$instance = new self($args);
        }
        return self::$instance;
    }
    //make the database connection
    private function hook(){
        $hook = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
        if(!$hook){
            die('Error Connecting to the Database'.mysqli_connect_errno().PHP_EOL);
        }
        return $hook;
    }
    public function idle_query($sql){
        $result = $this->connection->query($sql);
        //echo mysqli_errno($this->connection);
        return $result;
    }
    //data retrieval statment $conditions must be an array of conditions.
    /* $conditons format 
    * array("WHERE/ORDER BY ECT" => array("condtion", "condition", ect)
    *
    */
    public function retrieveData($table, $data, $conditions = NULL){
        $table = strtolower($table);
        $statement = '';
        $array = array();
        if($conditions){
            if(!is_array($conditions)){
                echo 'DBConnect Error: Your statement is malformed--> for retrieveData($table,$data,$conditions)';
                exit;
            }
            foreach($conditions as $condition => $vals){
            $statement .= $condition;
            $i = 0;
            foreach($vals as $key => $value){
                
                if($i>0){ $statement .= " AND ";}
                $statement .=  ' '.$value;
                $i++;
            }
            }
        }
        $sql = "SELECT $data FROM `$table` $statement";
        //echo $sql;
        $result = $this->connection->query($sql);
        if(!$result){ return $result; }
        while($addto = mysqli_fetch_assoc($result)){
            $array[] = $addto;
        }
        return $array;
    }
    //updateData statement $conditions must be an array
    public function updateData($table, $data, $conditions=NULL){
        $table = strtolower($table);
        if(!is_array($data)){
            echo 'DBConnect Error: Your statement is malformed--> for updateData($table, $data, $conditions)';
            exit;
        }
        if(!$conditions){
            echo 'DBConnect Error: Your statement is malformed--> for updateData($table, $data, $conditions)';
            exit;
        }
        $statement = '';
        $i=0;
        foreach($data as $key => $val){
            $val = $this->connection->real_escape_string($val);
            if($i>0){ $statement .= ','; }
            $statement .= " $key = '$val'";
            ++$i;
        }
        foreach($conditions as $condition => $vals){
            $statement .= ' '.$condition;
            $i = 0;
            foreach($vals as $key => $value){
                if($i>0){ $statement .= " AND ";}
                $statement .=  ' '.$value;
                $i++;
            }
        }
        $sql = "UPDATE $table set $statement ";
        //echo $sql;
        $result = $this->connection->query($sql);
        //echo mysqli_errno($this->connection);
        return $result;
    }
    //insert statement
    public function insertData($table, $data){
        $table = strtolower($table);
        if(!is_array($data)){
            echo 'DBConnect Error: Your statement is malformed--> for insertData($table, $data)';
        }
        $statement = '';
        $i=0;
        foreach($data as $key => $val){
            $val = $this->connection->real_escape_string($val);
            if($i>0){ $statement .= ','; }
            $statement .= " $key = '$val'";
            ++$i;
        }
        $sql = "INSERT INTO `$table` set $statement";
        
        echo $sql;
        $result = $this->connection->query($sql);
        //echo mysqli_errno($this->connection);
        return $result;
    }
    //delete data $conditions must be an array
    public function deleteData($table, $data, $conditions){
        
    }
    //create table $fields must be array
    /*Standard fields are Vid, version, description, name, requires, tested, last_updated, download_link, code_name, features, {array $fields list of required fields for use with the prorietry cms update system} */
    public function createTable($table, $fields = NULL){
        if(!is_array($fields)){
            echo 'DBConnect Error: Your statement is malformed--> for createTable($table, $fields)';
            return;
        }
    }
    public function schema_connection($table){
        $result = $this->connection->query("SELECT * FROM $table LIMIT 0");
        return $result->fetch_fields();
        
    }
    public function customQuery($sql){
        $result = $this->connection->query($sql);
        return $result;
    }
    public function mysqli_error(){
        return $this->connection->error;
    }
    public function describe($table){
        return $this->connection->query("DESCRIBE `$table`");   
    }
    public function connection_method($method){
        return $this->connection->$method;
        
        
    }
    public function getDBName(){
        return $this->db;   
    }
}
//$con = new DBConnect();
?>
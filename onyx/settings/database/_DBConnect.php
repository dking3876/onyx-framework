<?php 
//require_once(BASE_PATH . 'settings/IOnyxCreds.php');
/*
*
* DBConnect class for use with the Brafton Update API for plugins and modules
*
*/
abstract class _DBConnect {
    private $db;
    protected $connection;    
    static $instance = null;
    private $errorDisplay = true;
    
    //constuct the db connection
    final protected function __construct($args){
        $this->db = $args[3];
        $this->connection = $this->hook($args);
    }
    abstract static function GetInstance($args);
    //make the database connection
    abstract protected function hook($args);
    
    abstract public function idle_query($sql);
    abstract public function customQuery($sql);
    //data retrieval statment $conditions must be an array of conditions.
    /* $conditons format 
    * array("WHERE/ORDER BY ECT" => array("condtion", "condition", ect)
    *
    */
    abstract public function retrieveData($table, $data, $conditions = NULL);
    //updateData statement $conditions must be an array
    abstract public function updateData($table, $data, $conditions=NULL);
    //insert statement
    abstract public function insertData($table, $data);
    //delete data $conditions must be an array
    abstract public function deleteData($table, $data, $condition = null);

    abstract public function schema_connection($table);
    abstract public function describe($table);
    abstract public function connection_method($method);
    abstract public function getDBName();
    abstract public function getDB();
    abstract public function getUser();
    abstract public function createTable($table, $columns, $key);
    abstract public function tableDetails($table);
    
    abstract public function columnInfo($table, $column_name);
    
    abstract public function addNewColumn($table, $columns, $column);
}
//$con = new DBConnect();
?>
<?php

class onyx_users_table extends DataStructure{
    
    public function set_table(){
        $this->table = "onyx_users";
    }
    public function get_table(){
        return $this->table;
    }
    public function set_primary_key(){
        $this->primaryKey = "OUID";
    }
    public function set_columns(){
        $column[] = (object) array(
                    'column_name'    => "OUID",
                        'type'      => "int(10)",
                        'default'   => "AUTO_INCREMENT NOT NULL"
        );
        $column[] = (object) array(
                    'column_name'    => "UserName",
                        'type'      => "varchar(100)",
                        'default'   => "NOT NULL"
        );
        $column[] = (object) array(
                    'column_name'   => "FirstName",
                        'type'      => "varchar(100)",
                        'default'   => "NULL"
        );
        $column[] = (object) array(
                    'column_name'   => "LastName",
                        'type'      => "varchar(100)",
                        'default'   => "NULL"
        );
        $column[] = (object) array(
                    'column_name'    => "Email",
                        'type'      => "varchar(250)",
                        'default'   => "NOT NULL"
        );
        $column[] = (object) array(
                    'column_name'    => "Password",
                        'type'      => "varchar(32)",
                        'default'   => "NOT NULL"
        );
        return $column;
    }
    
    //{hook}_update is optional for columns that require data updates form existing data in a data set.
    /*
    protected function {column-name}_update(){
        $total = $this->connection->retrieveData($this->table,'*');
        foreach($total as $record){
            $data = array(
            
            );
            $cond = 
            if(){
                $this->connection->updateData($this->table, $data, array('WHERE' => array($cond)));
            }
        }
    }
    */
}

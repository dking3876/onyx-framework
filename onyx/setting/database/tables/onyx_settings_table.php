<?php

class onyx_settings_table extends DataStructure{
    
    public function set_table(){
        $this->table = "onyx_settings";
    }
    public function get_table(){
        return $this->table;
    }
    public function set_primary_key(){
        $this->primaryKey = "id";
    }
    public function set_columns(){
        $column[] = (object) array(
                    'column_name'    => "id",
                        'type'      => "varchar(100)",
                        'default'   => "AUTO_INCREMENT NOT NULL"
        );
        $column[] = (object) array(
                    'column_name'    => "setting",
                        'type'      => "varchar(100)",
                        'default'   => "NOT NULL"
        );
        $column[] = (object) array(
                    'column_name'    => "value",
                        'type'      => "blob",
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

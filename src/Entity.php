<?php

class Entity {
    
    protected $tableName;
    protected $fields;
    protected $dbc;

    public function findBy($fieldName, $fieldValue){

        $sql = "SELECT * FROM " . $this->tableName . " WHERE " . $fieldName . " = :value ";
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute(['value'=> $fieldValue]);
        $data = $stmt->fetch();
        $this->setValues($data);
    }

    public function setValues($values){
        
        if($values){
            foreach($this->fields as $fieldName){
                $this->$fieldName = $values[$fieldName];
            } 
        } else {
            echo "Warning: Entity.php, setValues(): values not set, or set as false within an Entity instance. <br>" ;
        }
    }
}
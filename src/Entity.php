<?php

class Entity {
    
    protected $tableName;
    protected $fields;
    protected $dbc;

    public function findBy($fieldName, $fieldValue){

        $sql = "SELECT * FROM " . $this->tableName . " WHERE " . $fieldName . " = :value";
        $statement = $this->dbc->prepare($sql);
        $statement->execute(['value' => $fieldValue]);
        $data = $statement->fetch();
        $this->setValues($data);
    }

    public function setValues($values){

        foreach($this->fields as $fieldName){
            $this->$fieldName = $values[$fieldName];
        }
    }
}
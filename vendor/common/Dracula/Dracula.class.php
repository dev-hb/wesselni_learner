<?php

class Dracula {

    private $id;
    private $connection;
    private $blueprint;

    public function __construct($blueprint){
        // create connection instance
        $orm = new ORM();
        $this->connection = $orm->getConnection();
        $this->blueprint = $blueprint;
    }

    public function findAll(){
        $fields = get_class_vars($this->blueprint);
        die($fields);
        $sql = "SELECT ".implode(', ', $fields)." FROM ".strtolower($this->blueprint);
        $rows = $this->query($sql, null);
        $result = [];
        foreach($rows as $row){
            $obj = new $this->blueprint();
            foreach($fields as $field){
                $method = "get".(ucfirst($field));
                $obj->$method($row[$field]);
            }
            array_push($result, $obj);
        }
    }

    public function query($sql, $params){
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

}
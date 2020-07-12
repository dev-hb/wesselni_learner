<?php

class Template
{
    private $fields;

    public function __construct($fields = null)
    {
        $this->fields = $fields;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function getOne(){
        $row = [];
        foreach ($this->fields as $field){
            switch ($field['type']){
                case 'number':
                    $row[] = rand($field['min'], $field['max']);
                break;
                case 'date':
                    $start_date = new DateTime($field['min']);
                    $end_date = new DateTime($field['max']);
                    $interval = $start_date->diff($end_date)->d;
                    do{
                        $rnd = rand(0, 31);
                    }while(in_array($rnd, [14, 15, 16, 21]));
                    $row[] = (new DateTime($field['min']))->add(new DateInterval("P$rnd"."D"))->format("Y-m-d");
                break;
            }
        }
        return $row;
    }

    /**
     * @return null
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param null $fields
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

}

class Generators
{
    private $template;
    private $generated;

    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * @return mixed
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @return $this
     */
    public function generate($nb){
        $data = [];
        for ($i=0;$i<$nb;$i++){
            $data[] = $this->template->getOne();
        }
        $this->generated = $data;
        return $this;
    }

    public function commit($hostname, $username, $password, $dbname, $table){
        $conn = new mysqli($hostname, $username, $password, $dbname);
        $fields = [];
        foreach ($this->template->getFields() as $field) $fields[] = $field['field'];
        $params = [];
        foreach ($fields as $field) $params[] = "?";
        $fields = implode(', ', $fields);
        $params = implode(", ", $params);
        $sql = "INSERT INTO $table ($fields) VALUES ($params)";
        $stmt = $conn->prepare($sql);
        $keys = [];
        foreach ($this->template->getFields() as $field){
            switch ($field['type']){
                case 'number': $keys[] = "i"; break;
                case 'date' : $keys[] = "s"; break;
            }
        }
        $keys = implode("", $keys);
        foreach ($this->generated as $k=>$row){
            if(gettype($row) == "array") $stmt->bind_param("$keys", ...$row);
            else $stmt->bind_param("$keys", $row);
            $res = $stmt->execute();
            if($res) echo "Row $k has been inserted !\n";
            else echo "Error inserting row $k !";
        }
        echo "\nDone!\n";
    }

    /**
     * @param $min
     * @param $days
     * @return $this
     * @throws Exception
     */
    public function generateDates($min, $days){
        $data = [];
        $start_date = new DateTime($min);
        for($i=0;$i<$days; $i++){
            $data[] = (new DateTime($min))->add(new DateInterval("P$i"."D"))->format("Y-m-d");
        }
        $this->setGenerated($data);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGenerated()
    {
        return $this->generated;
    }

    /**
     * @param mixed $generated
     */
    public function setGenerated($generated)
    {
        $this->generated = $generated;
    }

}


$gen = new Generators(
    new Template(
        [
            ["field" => 'startcity', "type" => 'number', "min" => 1, "max" => 10],
            ["field" => 'targetcity', "type" => 'number', "min" => 1, "max" => 10],
            ["field" => 'dateTime', "type" => 'date', "min" => "2019-01-01", "max" => "2019-01-31"]
        ]
    )
);

$gen->generate(5000)->commit("localhost", "root", "hba7222000", "generator", "offres");


//$gen = new Generators(
//    new Template(
//        [
//            ["field" => "date", "type" => "date"]
//        ]
//    )
//);
//$gen->generateDates("2019-01-01", 365);
//$gen->commit("localhost", "root", "hba7222000", "generator", "dates");


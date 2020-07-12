<?php


class Splitter
{
    private $data;
    private $generated;
    private $mapped_trainset;
    private $target_trainset;

    public function __construct($data)
    {
        $this->data = $data;
        $this->generated = null;
        $this->mapped_trainset = [];
    }

    /**
     * @return $this
     */
    public function generate()
    {
        $data = $this->data;
        $train_set = $test_set = [];
        $tr = count($data); // tr train set count (90% of dataset)
        $ts = $tr * 0.1; // ts test set count which is 10% of dataset
        $tr -= $ts;

        foreach ($data as $k => $row) {
            if ($k < $tr) array_push($train_set, $row);
            else array_push($test_set, $row);
        }

        $this->generated = ['train_set' => ['count' => count($train_set), 'data' => $train_set], 'test_set' => ['count' => $ts, 'data' => $test_set]];
        return $this;
    }

    /**
     * @param array $fields
     * @return array
     * @throws Exception
     */
    public function splitTrainFields($fields){
        $data = [];
        foreach ($this->generated['train_set']['data'] as $row){
            $data[] = [
                'startcity' => $row['startcity'],
                'targetcity' => $row['targetcity'],
                'dateTime' => $this->dateToIntTransformer($row['dateTime']),
                'Y' => $row['Y']
            ];
        }
        return $data;
    }

    /**
     * Pushes a row of mapped data to training result
     * @param $data
     */
    private function pushToMappedTrainset($data){
        $this->mapped_trainset[] = $data;
    }

    /**
     * @return array
     */
    public function getMappedTrainset()
    {
        print_r($this->target_trainset);
        exit;
        foreach ($this->mapped_trainset as $key=>$mp){
            $this->mapped_trainset[$key]['Y'] = $this->target_trainset[$key];
        }
        return $this->mapped_trainset;
    }


    /**
     * @param string $grouped
     * @param array $fields
     * @return array
     * @throws Exception
     */
    public function splitTestFields($fields, $grouped = null)
    {
        $data = [];
        foreach ($fields as $field) $data[$field] = [];
        if ($grouped == null) {
            foreach ($this->generated['test_set']['data'] as $row) {
                foreach ($fields as $field)
                    array_push($data[$field], $row[$field]);
            }
        } else {
            $data['Y'] = [];
            foreach ($this->generated['test_set']['data'] as $row) {
                $criteria = (new DateTime($row[$grouped]))->format("Y-m-d");

                if (key_exists($criteria, $data[array_key_first($data)])) {
                    $data['Y'][$criteria] += 1;
                } else {
                    foreach ($fields as $field)
                        $data[$field][$criteria] = $row[$field];
                    $data['Y'][$criteria] = 1;
                }

            }
        }
        return $data;
    }

    /**
     * @param $date
     * @return float|int
     * @throws Exception
     */
    public function dateToIntTransformer($date){
        $nb = 0;
        $date = (new DateTime($date));
        $nb = ($date->format("m")-1) * 30 + $date->format("d");
        return $nb;
    }

    /**
     * @return array
     */
    public function getGenerated(){
        return $this->generated;
    }

}
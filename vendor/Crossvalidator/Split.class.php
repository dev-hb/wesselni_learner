<?php


class Split
{

    private $data;
    private $length;
    private $train_set;
    private $test_set;

    public function __construct($data, $length)
    {
        $this->data = $data;
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function crossvalidate(){

        return $this;
    }

}
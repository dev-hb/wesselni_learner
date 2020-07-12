<?php

use Phpml\Classification\MLPClassifier;

class OffersClassifier  extends Classifier
{
    /**
     * @var $trainset
     */
    private $trainset;
    /**
     * @var $testset
     */
    private $testset;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->classifier = new \Phpml\Regression\LeastSquares();

    }

    /**
     * @return $this
     */
    public function bindData(){
        $data = $this->getDracula()->findAll();
        $this->setData($data);
        return $this;
    }

    /**
     * @param $params parameters to predict
     * @return $this
     */
    public function predict($params){
        // nothing to predict for this class
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrainset()
    {
        return $this->trainset;
    }

    /**
     * @param mixed $trainset
     */
    public function setTrainset($trainset)
    {
        $this->trainset = $trainset;
    }

    /**
     * @return mixed
     */
    public function getTestset()
    {
        return $this->testset;
    }

    /**
     * @param mixed $testset
     */
    public function setTestset($testset)
    {
        $this->testset = $testset;
    }



}
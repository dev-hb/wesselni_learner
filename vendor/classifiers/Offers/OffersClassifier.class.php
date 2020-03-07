<?php


class OffersClassifier  extends Classifier
{

    protected $data;
    protected $regression;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->regression = new \Phpml\Regression\LeastSquares();
        $this->dracula = new Dracula("offres");
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
     * @return $this
     */
    public function predict(){
        // predict data

        return $this;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

}
<?php


abstract class Classifier {

    protected $id;
    protected $dracula;
    protected $prediction;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDracula()
    {
        return $this->dracula;
    }

    /**
     * @param mixed $dracula
     */
    public function setDracula($dracula)
    {
        $this->dracula = $dracula;
    }

    /**
     * @return mixed
     */
    public function getPrediction()
    {
        return $this->prediction;
    }

    /**
     * @param mixed $prediction
     */
    public function setPrediction($prediction)
    {
        $this->prediction = $prediction;
    }

}
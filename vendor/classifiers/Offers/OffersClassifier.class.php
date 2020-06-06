<?php

use Phpml\Classification\MLPClassifier;

class OffersClassifier  extends Classifier
{

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->classifier = new MLPClassifier(3, 7, ['a', 'b', 'c']);
        $this->dracula = new Dracula("offres");
        $this->cities = (new Dracula("cities"))->findAll();
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


}
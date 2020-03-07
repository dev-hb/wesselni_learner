<?php


class OffersPerDayClassifer extends OffersClassifier {

    public function __construct($id = null){
        parent::__construct($id);
    }

    /**
     * @return $this
     */
    public function predict(){
        // predict data
        $dataset = $this->getData();
        $targets = [];
        foreach ($dataset as $sample) array_push($targets, true);
        $this->regression->train($dataset, $targets);
        return $this;
        return $this;
    }

}
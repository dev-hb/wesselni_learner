<?php


class OffersPerDayClassifer extends OffersClassifier {

    public function __construct($id = null){
        parent::__construct($id);
    }

    /**
     * @return $this
     */
    public function predict($params){
        // predict data
        $vars = [];
        $target = [];
        foreach ($this->getTrainset() as $tr) $vars[] = [$tr['startcity'], $tr['targetcity'], $tr['dateTime']];
        foreach ($this->getTrainset() as $tr) $target[] = [$tr['Y']];

        $this->classifier->train($vars, $target);
        $this->prediction = $this->classifier->predict($params);
        return $this;
    }

    public function hah(){
        $offersPerDayClassifier = new OffersPerDayClassifer();
        $offersPerDayClassifier->getDracula()->setFields([
            'startcity', 'targetcity', 'DATE(datetime)'
        ]);

        $offersPerDayClassifier->bindData();

        $offersPerDayClassifier->predict(['Rabat', 'Agadir', '']);

        echo "Total data trained : " . count($offersPerDayClassifier->getData());
        echo "<br />The predicted label is : " . $offersPerDayClassifier->getPrediction();
    }


}
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
        $dataset = $this->getData();
        $targets = [];
        foreach ($dataset as $sample) array_push($targets, 'true');
        $this->classifier->train($dataset, $targets);
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
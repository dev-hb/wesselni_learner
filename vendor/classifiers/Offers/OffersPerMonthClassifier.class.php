<?php


class OffersPerMonthClassifier extends OffersClassifier {

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
    * Override predict
    */
    public function predict($params)
    {
        $predicted = [];
        for($i=1;$i<31;$i++){
            $predicted[] = parent::predict([
                $params[0],
                $params[1],
                $i
            ]);
        }
        $this->setPrediction($predicted);
        return $this;
    }

}
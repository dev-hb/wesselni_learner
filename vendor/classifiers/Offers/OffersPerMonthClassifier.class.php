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
        $temp = null;
        for($i=1;$i<31;$i++){
            $temp = new OffersPerDayClassifer($i);
            $temp->setTestset($this->getTrainset());
            $temp->setTestset($this->getTestset());
            $temp->setDracula($this->getDracula());
            $temp->setData($this->getData());
            $predicted[] = $temp->predict([
                $params[0],
                $params[1],
                $i
            ]);
        }
        $this->setPrediction($predicted);
        return $this;
    }

}
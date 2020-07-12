<?php

class OffersClassifiers extends PreferredHandler
{

    public function handle()
    {
        // TODO add actions to take here (Handle both GET and POST methods)
        // Create Dracula instance and execute the query method
        switch ($this->getAction()) {

            case 'offersperday':

                $split = new Splitter(
                    (new Dracula('Offres'))->query(
                        "SELECT startcity, targetcity, dateTime, count(*) Y FROM offres GROUP BY dateTime, targetcity, startcity"
                    )
                );

                $train_set = $split->generate()->splitTrainFields(['startcity', 'targetcity', 'dateTime']);
                $classifier = new OffersPerDayClassifer(1);
                $classifier->setTrainset($train_set);

                (new Logger())->json(
                    [
                        "Predicted number of travels" => ($classifier->predict([1, 9, 31])->getPrediction())
                    ]
                );
                break;

            case 'offerspermonth':
                $split = new Splitter(
                    (new Dracula('Offres'))->query(
                        "SELECT startcity, targetcity, dateTime, count(*) Y FROM offres GROUP BY dateTime, targetcity, startcity"
                    )
                );

                $train_set = $split->generate()->splitTrainFields(['startcity', 'targetcity', 'dateTime']);
                $classifier = new OffersPerMonthClassifier(1);
                $classifier->setTrainset($train_set);

                (new Logger())->json(
                    [
                        "Predicted number of travels" => ($classifier->predict([1, 9, 0])->getPrediction())
                    ]
                );
                break;
        }
    }

}
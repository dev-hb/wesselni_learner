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

            case 'offersperduration':
                $start = $this->getParams()['startdate'];
                $end = $this->getParams()['enddate'];
                $split = new Splitter(
                    (new Dracula('Offres'))->query(
                        "SELECT startcity, targetcity, dateTime, count(*) Y FROM offres  GROUP BY dateTime, targetcity, startcity"
                    )
                );

                $train_set = $split->generate()->splitTrainFields(['startcity', 'targetcity', 'dateTime']);
                $classifier = new OffersPerDayClassifer(1);
                $classifier->setTrainset($train_set);

                $data = [];

                $nb_days = (new DateTime($this->getParams()['startdate']))
                    ->diff(new DateTime($this->getParams()['enddate']))->days;

                $starting_from = $split->dateToIntTransformer($this->getParams()['startdate']);

                for($i=0; $i<$nb_days; $i++){
                    $the_day = $starting_from + $i;
                    $data[] = ceil(($classifier->predict([
                            $this->getParams()['startcity'],
                            $this->getParams()['targetcity'],
                            $the_day
                        ])->getPrediction()-2)*10);
                }

                (new Logger())->json($data);
                break;
        }
    }

}
<?php

class OffersClassifier extends PreferredHandler {

	public function handle(){
		// TODO add actions to take here (Handle both GET and POST methods)
		// Create Dracula instance and execute the query method
		 switch ($this->getAction()){

             case 'offersperday':
                 $cross = new Crossover((new Dracula('Offres'))->query("SELECT * FROM offres"));

                 (new Logger())->json(["res"=> $cross->generate()]);
             break;

		}
	}

}
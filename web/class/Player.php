<?php
class Player { //faire heriter de Person
	private $id_person;
	private $score;
	private $tutorialFinished;
	private $activationCode;

	public function id_person() {
		return $this->id_person;
	}
	public function score() {
		return $this->score;
	}
	public function tutorialFinished() {
		return $this->tutorialFinished;
	}
	public function activationCode() {
		return $this->activationCode;
	}

	public function setId_personcore($id_person) {
		$this->id_person = $id_person;
	}
	public function setScore($score) {
		$this->score = $score;
	}
	public function setTutorialFinished($tutorialFinished) {
		$this->tutorialFinished = $tutorialFinished;
	}
	public function setActivationCode($activationCode) {
		$this->activationCode = $activationCode;
	}

	/* $this function take an array as parmeter.
	 * It affect values to variables.
	 *
	*/
	public function hydrate(array $data){
  		foreach ($data as $key => $value){
   			$method = 'set'.ucfirst($key);   
   			if (method_exists($this, $method)){
   	  	      	$this->$method($value);
   			}
   		}
   	}

    function __construct(array $data){
   		$personData = array_slice($data, 0, 5);
    	$playerData = array_slice($data, 5);
   		parent::__construct($personData);
   		$this->hydrate($playerData);
	}
}
?>
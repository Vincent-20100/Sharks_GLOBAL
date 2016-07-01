<?php
$_SPECIES_PHP = true;

class Species {
	private $id;
	private $image;
	private $length;
	private $distribution;
	private $food;
	private $commercialImportance;
	private $stateOfEndangerment;
	private $attacksOnHumans;
	private $swimmingDeep;
	private $uniqueIdentifyingFeature;

	public function id() {
		return $this->id;
	}
	public function image() {
		return $this->image;
	}
	public function length() {
		return $this->length;
	}
	public function distribution() {
		return $this->distribution;
	}
	public function food() {
		return $this->food;
	}
	public function commercialImportance() {
		return $this->commercialImportance;
	}
	public function stateOfEndangerment() {
		return $this->stateOfEndangerment;
	}
	public function attacksOnHumans() {
		return $this->attacksOnHumans;
	}
	public function swimmingDeep() {
		return $this->swimmingDeep;
	}
	public function uniqueIdentifyingFeature() {
		return $this->uniqueIdentifyingFeature;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setImage($image) {
		$this->image = $image;
	}
	public function setLength($length) {
		$this->length = $length;
	}
	public function setDistribution($distribution) {
		$this->distribution = $distribution;
	}
	public function setFood($food) {
		$this->food = $food;
	}
	public function setCommercialImportance($commercialImportance) {
		$this->commercialImportance = $commercialImportance;
	}
	public function setStateOfEndangerment($stateOfEndangerment) {
		$this->stateOfEndangerment = $stateOfEndangerment;
	}
	public function setAttacksOnHumans($attacksOnHumans) {
		$this->attacksOnHumans = $attacksOnHumans;
	}
	public function setSwimmingDeep($swimmingDeep) {
		$this->swimmingDeep = $swimmingDeep;
	}
	public function setUniqueIdentifyingFeature($uniqueIdentifyingFeature) {
		$this->uniqueIdentifyingFeature = $uniqueIdentifyingFeature;
	}
	
	/* This function takes an array as parmeter.
	 * It affect values to variables using the setters.
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
   		$this->hydrate($data);
	}
}
?>
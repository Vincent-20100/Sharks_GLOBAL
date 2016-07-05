<?php
$_SPECIES_PHP = true;

class Species {
	private $id;
	private $name;
	private $otherNames;
	private $image;
	private $length;
	private $distributation;
	private $distributationImage;
	private $food;
	private $commercialImportance;
	private $stateOfEndangerment;
	private $attacksOnHumans;
	private $swimmingDeep;
	private $uniqueIdentifyingFeature;

	public function id() {
		return $this->id;
	}
	public function name() {
		return $this->name;
	}
	public function otherNames() {
		return $this->otherNames;
	}
	public function image() {
		return $this->image;
	}
	public function length() {
		return $this->length;
	}
	public function distributation() {
		return $this->distributation;
	}
	public function distributationImage() {
		return $this->distributationImage;
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
	public function setName($name) {
		$this->name = $name;
	}
	public function setOtherNames($otherNames) {
		$this->otherNames = $otherNames;
	}
	public function setImage($image) {
		$this->image = $image;
	}
	public function setLength($length) {
		$this->length = $length;
	}
	public function setDistributation($distributation) {
		$this->distributation = $distributation;
	}
	public function setDistributationImage($distributationImage) {
		$this->distributationImage = $distributationImage;
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
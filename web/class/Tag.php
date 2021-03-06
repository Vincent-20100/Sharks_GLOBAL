<?php
$_TAG_PHP = true;

class Tag {
	private $id;
	private $id_taggedImage;
	private $id_species;
	private $x1;
	private $y1;
	private $x2;
	private $y2;
	private $isReference;

	public function id() {
		return $this->id;
	}
	public function id_taggedImage() {
		return $this->id_taggedImage;
	}
	public function id_species() {
		return $this->id_species;
	}
	public function x1() {
		return $this->x1;
	}
	public function y1() {
		return $this->y1;
	}
	public function x2() {
		return $this->x2;
	}
	public function y2() {
		return $this->y2;
	}
	public function isReference() {
		return $this->isReference;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setId_taggedImage($id_taggedImage) {
		$this->id_taggedImage = $id_taggedImage;
	}
	public function setId_species($id_species) {
		$this->id_species = $id_species;
	}
	public function setX1($x1) {
		$this->x1 = $x1;
	}
	public function setY1($y1) {
		$this->y1 = $y1;
	}
	public function setX2($x2) {
		$this->x2 = $x2;
	}
	public function setY2($y2) {
		$this->y2 = $y2;
	}
	public function setIsReference($isReference) {
		$this->isReference = $isReference;
	}

	public function size() {
		return abs(x1 - x2) * abs(y1 - y2);
	}

	function dst($x1, $y1, $x2, $y2) {
		return sqrt( ($x1-$x2)*($x1-$x2) + ($y1-$y2)*($y1-$y2) );
	}

	public function overlap(Tag $other, $threshold = 50) {
		if(dst($this->x1, $this->y1, $other->x1, $other->y1) <= $threshold 
			&& dst($this->x2, $this->y2, $other->x2, $other->y2) <= $threshold){
			return true;
		}
		else{
			return false;
		}
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

function dst($x1, $y1, $x2, $y2) {
	return sqrt( ($x1-$x2)*($x1-$x2) + ($y1-$y2)*($y1-$y2) );
}

?>

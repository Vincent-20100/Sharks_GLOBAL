<?php
class Tag {
	private $id;
	private $x1;
	private $y1;
	private $x2;
	private $y2;

	public function id() {
		return $this->id;
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

	public function setId($id) {
		$this->id = $id;
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
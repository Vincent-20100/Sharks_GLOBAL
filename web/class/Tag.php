<?php
class Tag {
	private $id;
	private $posX;
	private $posY;
	private $width;
	private $height;

	public function id() {
		return $this->id;
	}
	public function posX() {
		return $this->posX;
	}
	public function posY() {
		return $this->posY;
	}
	public function width() {
		return $this->width;
	}
	public function height() {
		return $this->height;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setPosX($posX) {
		$this->posX = $posX;
	}
	public function setPosY($posY) {
		$this->posY = $posY;
	}
	public function setWidth($width) {
		$this->width = $width;
	}
	public function setHeight($height) {
		$this->height = $height;
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
   		$this->hydrate($data);
	}
}
?>
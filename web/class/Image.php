<?php
$_IMAGE_PHP = true;

class Image {
	private $id;
	private $name;
	private $hdDir;
	private $ldDir;
	private $width;
	private $height;
	private $test;
	private $analysed;

	public function id() {
		return $this->id;
	}
	public function name() {
		return $this->name;
	}
	public function hdDir() {
		return $this->hdDir;
	}
	public function ldDir() {
		return $this->ldDir;
	}
	public function width() {
		return $this->width;
	}
	public function height() {
		return $this->height;
	}
	public function test() {
		return $this->test;
	}
	public function analysed() {
		return $this->analysed;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function setHdDir($hdDir) {
		$this->hdDir = $hdDir;
	}
	public function setLdDir($ldDir) {
		$this->ldDir = $ldDir;
	}
	public function setWidth($width) {
		$this->width = $width;
	}
	public function setHeight($height) {
		$this->height = $height;
	}
	public function setTest($test) {
		$this->test = $test;
	}
	public function setAnalysed($analysed) {
		$this->analysed = $analysed;
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
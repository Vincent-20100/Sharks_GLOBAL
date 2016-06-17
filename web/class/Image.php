<?php
class Image {
	private $id;
	private $name;
	private $hdDir;
	private $ldDir;
	private $test;

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
	public function test() {
		return $this->test;
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
	public function setTest($test) {
		$this->test = $test;
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
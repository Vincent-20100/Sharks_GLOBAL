<?php
class TaggedImage {
	private $id;
	private $id_image;
	private $id_session;

	public function id() {
		return $this->id;
	}
	public function id_image() {
		return $this->id_image;
	}
	public function id_session() {
		return $this->id_session;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setId_image($id_image) {
		$this->id_image = $id_image;
	}
	public function setId_session($id_session) {
		$this->id_session = $id_session;
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
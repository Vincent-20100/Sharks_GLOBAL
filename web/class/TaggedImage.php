<?php
class TaggedImage {
	private $id;

	public function id() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
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
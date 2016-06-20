<?php
class Session {
	private $id; // not only numbers
	private $ipv4;
	private $date;
	private $os;
	private $device;
	private $browser;

	public function id() {
		return $this->id;
	}
	public function ipv4() {
		return $this->ipv4;
	}
	public function date() {
		return $this->date;
	}
	public function os() {
		return $this->os;
	}
	public function device() {
		return $this->device;
	}
	public function browser() {
		return $this->browser;
	}

	public function setId($id) {
		$this->id = $id;
	}
	public function setIpv4($ipv4) {
		$this->ipv4 = $ipv4;
	}
	public function setDate($date) {
		$this->date = $date;
	}
	public function setOs($os) {
		$this->os = $os;
	}
	public function setDevice($device) {
		$this->device = $device;
	}
	public function setBrowser($browser) {
		$this->browser = $browser;
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
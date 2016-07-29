<?php
$_SESSION_PHP = true;

class Session {
	private $id;
	private $name; // not only numbers /^[a-zA-Z0-9]*$/
	private $id_person;
	private $ipv4;
	private $date;
	private $os;
	private $device;
	private $browser;

	public function id() {
		return $this->id;
	}
	public function name() {
		return $this->name;
	}
	public function idid_person() {
		return $this->id_person;
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
	public function setName($name) {
		$this->name = $name;
	}
	public function setId_person($id_person) {
		$this->id_person = $id_person;
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
<?php
$_BARYCENTER_PHP = true;

class Barycenter {
    private $vecteurArray = null; // Array of vectors
    private $nbrVectors   = 0;    // Number of vectors
    private $nbrCoord     = 0;    // Number of coordinates
    private $coord = 0;           // Sum of vectors Coordinate
    private $weights = 0;         // Array of weights
    private $G = null;            // Result vector
    
    /*

     Init vars
	 
     @param Array $vectors
	 
     @param Array $weights
	 
    */

/* Class Tag
	private $id;
	private $id_taggedImage;
	private $id_species;
	private $x1;
	private $y1;
	private $x2;
	private $y2;
	private $isReference;
*/

    function __construct($vectors, $weights) {
		$this->vecteurArray = $vectors;
		$this->nbrVectors = count($vectors);
		$this->nbrCoord = count($vectors[0]);
		$this->weights = $weights;
    }
    
    /**

	 
     Calculate the Barycentre of a list of vectors
	 
     
	 
     @return array $G
	 
    **/


    public function getBarycenter(){
	
	for($c=0; $c<$this->nbrCoord; $c++){
	    $this->coord = 0;
	            
	    for($v = 0; $v < $this->nbrVectors; $v++){
	        $this->coord = $this->calcul($v,$c);
	    }
	    
	    $this->G[$c] = $this->coord / array_sum($this->weights);
	}
	return $this->G;
    
    }
    
    /**

	 
     Calculte the sum of coordinates
	 
     
	 
     @param int $v
	 
     @param int $c
	 
     @return int
	 
    **/


    private function calcul($v,$c){
	return ($this->coord+($this->vecteurArray[$v][$c]*$this->weights[$v]));
    }

}

?>

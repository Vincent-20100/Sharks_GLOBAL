<?php

	include_once 'Image.php';

class ImageManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Image $image)
	{
		$q = $this->_db->prepare("INSERT INTO Image(name, hdDir, ldDir, width, height) VALUES(:name, :hdDir, :ldDir, :width, :height)");
		
		$q->bindValue(':name', $image->name());
		$q->bindValue(':hdDir', $image->hdDir());
		$q->bindValue(':ldDir', $image->ldDir());
		$q->bindValue(':width', $image->width());
		$q->bindValue(':height', $image->height());

		$q->execute();
	}

	public function delete(Image $image)
	{
		$this->_db->exec('DELETE FROM Image WHERE id = '.$image->id());
	}

	public function getById($id)
	{
		try {
			$id = (int) $id;

			$q = $this->_db->query('SELECT * FROM Image WHERE id = '.$id);
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Image($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getByName($name)
	{
		try {
			$q = $this->_db->query("SELECT * FROM Image WHERE name = '$name'");
			if($q === false){ return null; }
			
			$data = $q->fetch(PDO::FETCH_ASSOC);

			if(!$data){
				$image = new Image(array(
				  	'name' => $name,
				  	'hdDir' => "",
				  	'ldDir' => ""
				));
				
				$this->add($image);
				return $this->getByName($name);
			}
	    	return new Image($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getByNameOrCreate($name, $width, $height)
	{
		try {
			$q = $this->_db->query("SELECT * FROM Image WHERE name = '$name'");
			if($q === false){ return null; }
			
			$data = $q->fetch(PDO::FETCH_ASSOC);
			if(!$data){
				$image = new Image(array(
				  	'name' => $name,
				  	'hdDir' => "",
				  	'ldDir' => "",
				  	'width' => $width,
				  	'height' => $height
				));
				
				$this->add($image);
				return $this->getByName($name);
			}
    		return new Image($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$images = array();
			$q = $this->_db->query('SELECT * FROM Image ORDER BY id');
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$images[] = new Image($data);
			}
			return $images;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Image $image)
	{
		$q = $this->_db->prepare('UPDATE Image SET name = :name, hdDir = :hdDir, ldDir = :ldDir, width = :width, height = :height, test = :test, analysed = :analysed WHERE id = :id');
		
		$q->bindValue(':id', $image->id());
		$q->bindValue(':name', $image->name());
		$q->bindValue(':hdDir', $image->hdDir());
		$q->bindValue(':ldDir', $image->ldDir());
		$q->bindValue(':width', $image->width());
		$q->bindValue(':height', $image->height());
		$q->bindValue(':test', $image->test());
		$q->bindValue(':analysed', $image->analysed());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new image in the DB see the example bellow

		$image = new Image([
		  	'name' => '...',
		  	'hdDir' => ...,
		  	'ldDir' => ...,
		  	'test' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new ImageManager($db);
		$manager->add($image);
		$db = null;
	 */
}

?>

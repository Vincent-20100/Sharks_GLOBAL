<?php
if(!isset($_IMAGE_PHP)){
	include 'Image.php';
}

class ImageManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Image $image)
	{
		$q = $this->_db->prepare("INSERT INTO Image(name, hdDir, ldDir) VALUES(:name, :hdDir, :ldDir)");
		
		$q->bindValue(':name', $image->name());
		$q->bindValue(':hdDir', $image->hdDir());
		$q->bindValue(':ldDir', $image->ldDir());

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

			$q = $this->_db->query('SELECT id, name, hdDir, ldDir FROM Image WHERE id = '.$id);
			if($q === false){ return null; }
			$donnees = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Image($donnees);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getByName($name)
	{
		try {
			$q = $this->_db->query("SELECT * FROM Image WHERE name = '$name'");
			
			if($q === false){ return null; }
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			if(! $donnees){
				$image = new Image([
				  	'name' => $name,
				  	'hdDir' => "",
				  	'ldDir' => ""
				]);
				
				$this->add($image);
				return $this->getByName($name);
			}
	    		return new Image($donnees);
	    	} catch(PDOException $e) {
				exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$images = [];
			$q = $this->_db->query('SELECT id, name, hdDir, ldDir, test FROM Image ORDER BY id');
			if($q === false){ return null; }
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
			{
				$images[] = new Image($donnees);
			}
			return $images;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Image $image)
	{
		$q = $this->_db->prepare('UPDATE Image SET name = :name, hdDir = :hdDir, ldDir = :ldDir, test = :test WHERE id = :id');
		
		$q->bindValue(':id', $image->id());
		$q->bindValue(':name', $image->name());
		$q->bindValue(':hdDir', $image->hdDir());
		$q->bindValue(':ldDir', $image->ldDir());
		$q->bindValue(':test', $image->test());

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

<?php
include 'TaggedImage.php';

class TaggedImageManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(TaggedImage $taggedImage)
	{
		$q = $this->_db->prepare('INSERT INTO TaggedImage(id_image, id_session) VALUES(:id_image, :id_session)');
		
		$q->bindValue(':id_image', $taggedImage->id_image());
		$q->bindValue(':id_session', $taggedImage->id_session());

		$q->execute();
	}

	public function delete(TaggedImage $taggedImage)
	{
		$this->_db->exec('DELETE FROM TaggedImage WHERE id = '.$taggedImage->id());
	}

	public function getById($id)
	{
		try {
			$id = (int) $id;

			$q = $this->_db->query('SELECT id, id_image, id_session FROM TaggedImage WHERE id = '.$id);
			if($q === false){ return null; }
			$donnees = $q->fetch(PDO::FETCH_ASSOC);

	    	return new TaggedImage($donnees);
    	} catch(Exception $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$taggedImages = [];
			$q = $this->_db->query('SELECT id, id_image, id_session FROM TaggedImage ORDER BY id');
			if($q === false){ return null; }
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
			{
				$taggedImages[] = new TaggedImage($donnees);
			}
			return $taggedImages;
		} catch(Exception $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(TaggedImage $taggedImage)
	{
		$q = $this->_db->prepare('UPDATE TaggedImage SET id_image = :id_image, id_session = :id_session WHERE id = :id');
		
		$q->bindValue(':id', $taggedImage->id());
		$q->bindValue(':id_image', $taggedImage->id_image());
		$q->bindValue(':id_session', $taggedImage->id_session());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new tag in the DB see the example bellow

		$taggedImage = new TaggedImageManager([
		  	'id_image' => '...',
		  	'id_session' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new TaggedImageManager($db);
		$manager->add($taggedImage);
		$db = null;
	 */
}
?>

<?php
	include_once 'Tag.php';

class TagManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Tag $tag)
	{
		$q = $this->_db->prepare("INSERT INTO Tag(id_taggedImage, id_species, x1, y1, x2, y2) VALUES(:id_taggedImage, :id_species, :x1, :y1, :x2, :y2)");
		$q->bindValue(':id_taggedImage', $tag->id_taggedImage());
		$q->bindValue(':id_species', $tag->id_species());
		$q->bindValue(':x1', $tag->x1());
		$q->bindValue(':y1', $tag->y1());
		$q->bindValue(':x2', $tag->x2());
		$q->bindValue(':y2', $tag->y2());

//		print("INSERT INTO Tag(id_taggedImage, id_species, x1, y1, x2, y2) VALUES(".$tag->id_taggedImage().", ".$tag->id_species().", ".$tag->x1().", ".$tag->y1().", ".$tag->x2().", ".$tag->y2().")");

		$q->execute();
	}

	public function addRef(Tag $tag, $id_taggedImage, $id_species)
	{
		$q = $this->_db->prepare('INSERT INTO Tag(id_taggedImage, id_species, x1, y1, x2, y2, isReference) VALUES(:id_taggedImage, :id_species, :x1, :y1, :x2, :y2, :isReference)');
		
		$q->bindValue(':id_taggedImage', $id_taggedImage);
		$q->bindValue(':id_species', $id_species);
		$q->bindValue(':x1', $tag->x1());
		$q->bindValue(':y1', $tag->y1());
		$q->bindValue(':x2', $tag->x2());
		$q->bindValue(':y2', $tag->y2());
		$q->bindValue(':isReference', $tag->isReference());

		$q->execute();
	}

	public function delete(Tag $tag)
	{
		$this->_db->exec('DELETE FROM Tag WHERE id = '.$tag->id());
	}

	public function getById($id)
	{
		try {
			$id = (int) $id;

			$q = $this->_db->query('SELECT id, id_taggedImage, id_species, x1, y1, x2, y2, isReference FROM Tag WHERE id = '.$id);
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Tag($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$tags = array();
			$q = $this->_db->query('SELECT id, id_taggedImage, id_species, x1, y1, x2, y2, isReference FROM Tag ORDER BY id');
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$tags[] = new Tag($data);
			}
			return $tags;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getListByIdTaggedImage($idTaggedImage)
	{
		try {
			$tags = array();
			$q = $this->_db->query("SELECT * FROM Tag WHERE id_taggedImage = $idTaggedImage AND isReference = 0");
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$tags[] = new Tag($data);
			}
			return $tags;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Tag $tag)
	{
		$q = $this->_db->prepare('UPDATE Tag SET x1 = :x1, y1 = :y1, x2 = :x2, y2 = :y2, isReference = :isReference WHERE id = :id');
		
		$q->bindValue(':id', $tag->id());
		$q->bindValue(':x1', $tag->x1());
		$q->bindValue(':y1', $tag->y1());
		$q->bindValue(':x2', $tag->x2());
		$q->bindValue(':y2', $tag->y2());
		$q->bindValue(':isReference', $tag->isReference());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new tag in the DB see the example bellow

		$tag = new Tag([
		  	'x1' => '...',
		  	'y1' => '...',
		  	'x2' => '...',
		  	'y2' => '...',
		  	'isReference' => '...'
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new TagManager($db);
		$manager->add($tag);
		$db = null;
	 */
}
?>

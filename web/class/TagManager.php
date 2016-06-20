<?php
include 'Tag.php';

class TagManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Tag $tag)
	{
		$q = $this->_db->prepare('INSERT INTO Tag(x1, y1, x2, y2) VALUES(:x1, :y1, :x2, :y2)');
		
		$q->bindValue(':x1', $tag->x1());
		$q->bindValue(':y1', $tag->y1());
		$q->bindValue(':x2', $tag->x2());
		$q->bindValue(':y2', $tag->y2());

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

			$q = $this->_db->query('SELECT id, x1, y1, x2, y2 FROM Tag WHERE id = '.$id);
			if($q === false){ return null; }
			$donnees = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Tag($donnees);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$tags = [];
			$q = $this->_db->query('SELECT id, x1, y1, x2, y2 FROM Tag ORDER BY id');
			if($q === false){ return null; }
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
			{
				$tags[] = new Tag($donnees);
			}
			return $tags;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Tag $tag)
	{
		$q = $this->_db->prepare('UPDATE Tag SET x1 = :x1, y1 = :y1, x2 = :x2, y2 = :y2 WHERE id = :id');
		
		$q->bindValue(':id', $tag->id());
		$q->bindValue(':x1', $tag->x1());
		$q->bindValue(':y1', $tag->y1());
		$q->bindValue(':x2', $tag->x2());
		$q->bindValue(':y2', $tag->y2());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new tag in the DB see the example bellow

		$tag = new TagManager([
		  	'x1' => '...',
		  	'y1' => ...,
		  	'x2' => ...,
		  	'y2' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new TagManager($db);
		$manager->add($tag);
		$db = null;
	 */
}
?>

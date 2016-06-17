<?php
include 'Person.php';

class PersonManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Person $person)
	{
		$q = $this->_db->prepare('INSERT INTO Person(id_sessionCurrent, username, email, password, salt) VALUES(:id_sessionCurrent, :username, :email, :password, :salt)');
		
		$q->bindValue(':id_sessionCurrent', $person->id_sessionCurrent());
		$q->bindValue(':username', $person->username());
		$q->bindValue(':email', $person->email());
		$q->bindValue(':password', $person->password());
		$q->bindValue(':salt', $person->salt());

		$q->execute();
	}

	public function delete(Person $person)
	{
		$this->_db->exec('DELETE FROM Person WHERE id = '.$person->id());
	}

	public function getById($id)
	{
		try {
			$id = (int) $id;

			$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt FROM Person WHERE id = '.$id);
			if($q === false){ return null; }
			$donnees = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Person($donnees);
    	} catch(Exception $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}
	
	public function getBySession($session)
	{
		try {
			$q = $this->_db->query("SELECT id, id_sessionCurrent, username, email, password, salt FROM Person WHERE id_sessionCurrent = '" . $session . "'");
			if($q === false){ return null; }
			$donnees = $q->fetch(PDO::FETCH_ASSOC);
			if ($donnees['username'] == 'admin' ) {
				return new Administrator($donnees);
			}
			else {
				return new Player($donnees);
			}
		} catch(Exception $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$persons = [];
			$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt FROM Person ORDER BY id');
			if($q === false){ return null; }
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
			{
				$persons[] = new Person($donnees);
			}
			return $persons;
		} catch(Exception $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Person $person)
	{
		$q = $this->_db->prepare('UPDATE Person SET id_sessionCurrent = :id_sessionCurrent, username = :username, email = :email, password = :password, salt = :salt WHERE id = :id');
		
		$q->bindValue(':id_sessionCurrent', $person->id_sessionCurrent());
		$q->bindValue(':username', $person->username());
		$q->bindValue(':email', $person->email());
		$q->bindValue(':password', $person->password());
		$q->bindValue(':salt', $person->salt());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new person in the DB see the example bellow

		$person = new Personnage([
		  	'id_sessionCurrent' => '...',
		  	'username' => ...,
		  	'email' => ...,
		  	'password' => ...,
		  	'salt' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new PersonManager($db);
		$manager->add($person);
		$db = null;
	 */
}
?>

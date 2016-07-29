<?php
	include_once 'Person.php';

class AdministratorManager // please use the PersonManager for now because the Administrator need other atributes
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Player $admin)
	{
		$q = $this->_db->prepare('	INSERT INTO Person(id_sessionCurrent, username, email, password, salt, activationCode)
									VALUES(:id_sessionCurrent, :username, :email, :password, :salt, :activationCode)');
		
		$q->bindValue(':id_sessionCurrent', $admin->id_sessionCurrent());
		$q->bindValue(':username', $admin->username());
		$q->bindValue(':email', $admin->email());
		$q->bindValue(':password', $admin->password());
		$q->bindValue(':salt', $admin->salt());
		$q->bindValue(':activationCode', $admin->activationCode());

		$q->execute();


		// no atribute to set in Administrator for now
		/*
		$q2 = $this->_db->prepare('INSERT INTO Administrator() VALUES()');
		$q2->bindValue('', $admin->());

		$q2->execute();
		*/
	}


	public function delete(Administrator $admin)
	{
		$this->_db->exec('DELETE FROM Administrator WHERE id = '.$admin->id());
		$this->_db->exec('DELETE FROM Person WHERE id = '.$admin->id());
	}

	public function get($id)
	{
		try {
			$q = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode
									FROM Person per, Administrator admin
									WHERE per.id = $id
									AND admin.id_person = $id");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Administrator($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}
	
	public function getBySession($session)
	{
		try {
			$q = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode
									FROM Person P, Administrator A
									WHERE P.id = A.id_person
									AND P.id_sessionCurrent = $session");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

			if($data) { return new Administrator($data); }
			else { return null; }
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getBySessionName($session)
	{
		try {
			$q = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode
									FROM Person P, Administrator A, Session S
									WHERE P.id = A.id_person
									AND P.id_sessionCurrent = S.id
									AND S.name = '$session'
									ORDER BY S.id DESC");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

			if($data) { return new Administrator($data); }
			else { return null; }
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}
	
	public function getList()
	{
		try{
			$admins = array();
			$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt, activationCode FROM Person P, Administrator A WHERE P.id = '.$id.' AND A.id_person = '.$id.' ORDER BY P.id');
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$admins[] = new Administrator($data);
			}
			return $admins;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Administrator $admin)
	{
		$q = $this->_db->prepare('UPDATE Person SET name = :name, id_sessionCurrent = :id_sessionCurrent, username = :username, email = :email, password = :password, salt = :salt, activationCode = :activationCode WHERE id = :id');
		
		$q->bindValue(':id', $admin->id());
		$q->bindValue(':name', $admin->name());
		$q->bindValue(':id_sessionCurrent', $admin->id_sessionCurrent());
		$q->bindValue(':username', $admin->username());
		$q->bindValue(':email', $admin->email());
		$q->bindValue(':password', $admin->password());
		$q->bindValue(':salt', $admin->salt());
		$q->bindValue(':activationCode', $admin->activationCode());

		$q->execute();

		// no atribute to set in Administrator for now
		/*
		$q1 = $this->_db->prepare('UPDATE Administrator SET  WHERE id_person = :id_person');

		$q1->bindValue(':id_person', $admin->id_person());

		$q1->execute();
		*/
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new Administrator in the DB see the example bellow

		$admin = new Administrator([
		  	'id_sessionCurrent' => '...',
		  	'username' => ...,
		  	'email' => ...,
		  	'password' => ...,
		  	'salt' => ...,
		  	'activationCode' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new AdministatorManager($db);
		$manager->add($admin);
		$db = null;
	 */
}
?>

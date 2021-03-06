<?php
	include_once 'Person.php';


class PersonManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Person $person)
	{
		$q = $this->_db->prepare('INSERT INTO Person(id_sessionCurrent, username, email, password, salt, activationCode) VALUES(:id_sessionCurrent, :username, :email, :password, :salt, :activationCode)');
		
		$q->bindValue(':id_sessionCurrent', $person->id_sessionCurrent());
		$q->bindValue(':username', $person->username());
		$q->bindValue(':email', $person->email());
		$q->bindValue(':password', $person->password());
		$q->bindValue(':salt', $person->salt());
		$q->bindValue(':activationCode', $person->activationCode());
		
		$q->execute();
		
		// get the id of the inserted line
		
		$q2 = $this->_db->query("SELECT id FROM Person WHERE username = '" . $person->username() . "'");
		$data = $q2->fetch(PDO::FETCH_ASSOC);
		$person->setId($data['id']);
		
	}

	public function delete(Person $person)
	{
		$this->_db->exec('DELETE FROM Person WHERE id = '.$person->id());
	}

	//return a person
	public function getById($id)
	{
		try {
			$id = (int) $id;

			$q = $this->_db->query("SELECT id, id_sessionCurrent, username, email, password, salt, activationCode
									FROM Person
									WHERE id = $id");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Person($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getByRecoveryCode($recoverycode)
	{
		try {

			$q = $this->_db->query("SELECT *
									FROM Person
									WHERE recoverycode = '$recoverycode'");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);
			if($data) return new Person($data);
			else return null;
			
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}
	
	//return a player or an administrator
	public function getBySession($session)
	{
		try {
			$getPlayer = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode, Pl.score, Pl.tutorialFinished
									FROM Person P, Player Pl, Session S
									WHERE P.id = Pl.id_person
									AND P.id = S.id_person
									AND S.id = $session");

			if($getPlayer === false){ return null; }
			$dataPlayer = $getPlayer->fetch(PDO::FETCH_ASSOC);

			$getAdmin = $this->_db->query("	SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode
										FROM Person P, Administrator A, Session S
										WHERE P.id = A.id_person
										AND P.id = S.id_person
										AND S.id = $session");
			if($getAdmin === false){ return null; }
			$dataAdmin = $getAdmin->fetch(PDO::FETCH_ASSOC);

			if($dataAdmin) {
				return new Administrator($dataAdmin);
			}
			else if ($dataPlayer){
				return new Player($dataPlayer);
			}
			else { return null; }
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getBySessionName($session)
	{
		try {
			$getPlayer = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode, Pl.score, Pl.tutorialFinished
									FROM Person P, Player Pl, Session S
									WHERE P.id = Pl.id_person
									AND P.id = S.id_person
									AND S.name = '$session'");

			if($getPlayer === false){ return null; }
			$dataPlayer = $getPlayer->fetch(PDO::FETCH_ASSOC);

			$getAdmin = $this->_db->query("SELECT *
									FROM Person P, Administrator A, Session S
									WHERE P.id = A.id_person
									AND P.id = S.id_person
									AND S.name = '$session'");

			if($getAdmin === false){ return null; }
			$dataAdmin = $getAdmin->fetch(PDO::FETCH_ASSOC);

			if($dataAdmin) {
				return new Administrator($dataAdmin);
			}
			else if ($dataPlayer){
				return new Player($dataPlayer);
			}
			else { return null; }
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	// return a player or an administrator
	public function getByUserNameOrEmail($usernameOrEmail)
	{
		try {
			$q = $this->_db->query("SELECT * FROM Person WHERE username = '" . $usernameOrEmail . "' OR email = '" . $usernameOrEmail . "'");

			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);
			if( ! $data ){ return null; }

			$q2 = $this->_db->query("SELECT * FROM Person P, Administrator A WHERE P.id = A.id_person AND P.username = '" . $usernameOrEmail . "' OR P.email = '" . $usernameOrEmail . "'");
			if($q2 === false){ return null; }
			$data2 = $q2->fetch(PDO::FETCH_ASSOC);

			if($data2) {
				return new Administrator($data);
			}
			else if ($data){
				return new Player($data);
			}
			else { return null; }
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function printSaltByUsername($username)
	{
		try {
			$q = $this->_db->$query("SELECT salt FROM Person WHERE username = :username");
			$q->bindValue(':username', $username);
			if ($result = $mysqli->query($query)) {
				if ($result->num_rows === 1) {
					$row = $result->fetch_row();
					print $row[0];
				}
				else {
					echo "Failed";
				}
				$result->close();
			}
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try {
			$persons = array();
			$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt, activationCode FROM Person ORDER BY id');
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$persons[] = new Person($data);
			}
			return $persons;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Person $person)
	{
		$q = $this->_db->prepare('UPDATE Person SET id_sessionCurrent = :id_sessionCurrent, username = :username, email = :email, password = :password, salt = :salt, activationCode = :activationCode, recoveryCode = :recoveryCode WHERE id = :id');
		
		$q->bindValue(':id', $person->id());
		$q->bindValue(':id_sessionCurrent', $person->id_sessionCurrent());
		$q->bindValue(':username', $person->username());
		$q->bindValue(':email', $person->email());
		$q->bindValue(':password', $person->password());
		$q->bindValue(':salt', $person->salt());
		$q->bindValue(':activationCode', $person->activationCode());
		$q->bindValue(':recoveryCode', $person->recoveryCode());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new person in the DB see the example bellow

		$person = new Person([
		  	'id_sessionCurrent' => '...',
		  	'username' => ...,
		  	'email' => ...,
		  	'password' => ...,
		  	'salt' => ...,
		  	'activationCode' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new PersonManager($db);
		$manager->add($person);
		$db = null;
	 */
}
?>

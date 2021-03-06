<?php
	include_once 'Person.php';

class PlayerManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Player $player)
	{
		$q = $this->_db->prepare('INSERT INTO Person(id_sessionCurrent, username, email, password, salt, activationCode) VALUES(:id_sessionCurrent, :username, :email, :password, :salt, :activationCode)');
		
		$q->bindValue(':id_sessionCurrent', $player->id_sessionCurrent());
		$q->bindValue(':username', $player->username());
		$q->bindValue(':email', $player->email());
		$q->bindValue(':password', $player->password());
		$q->bindValue(':salt', $player->salt());
		$q->bindValue(':activationCode', $player->activationCode());

		$q->execute();



		$q2 = $this->_db->prepare('INSERT INTO Player(id_person, score, tutorialFinished) VALUES(:id_pers, :score, :tutorialFinished)');

		$q2->bindValue(':id_person', $player->id());
		$q2->bindValue(':score', $player->score());
		$q2->bindValue(':tutorialFinished', $player->tutorialFinished());

		$q2->execute();
		
		$q2 = $this->_db->query("SELECT id FROM Person WHERE username = '" . $person->username() . "'");
		$data = $q2->fetch(PDO::FETCH_ASSOC);
		$person->setId($data['id']);
	}


	public function delete(Player $player)
	{
		$this->_db->exec('DELETE FROM Player WHERE id = '.$player->id());
		$this->_db->exec('DELETE FROM Person WHERE id = '.$player->id());
	}

	public function get($id)
	{
		try {
			$id = (int) $id;

			$q = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode, Pl.score, Pl.tutorialFinished
									FROM Person P, Player Pl
									WHERE P.id = $id
									AND Pl.id_person = $id");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

			return new Player($data);
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}
	
	public function getBySession($session)
	{
		try {
			$q = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode, Pl.score, Pl.tutorialFinished
									FROM Person P, Player Pl
									WHERE P.id = Pl.id_person
									AND P.id_sessionCurrent = $session");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

			if($data) { return new Player($data); }
			else { return null; }
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getBySessionName($session)
	{
		try {
			$q = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode, Pl.score, Pl.tutorialFinished
									FROM Person P, Player Pl, Session S
									WHERE P.id = Pl.id_person
									AND P.id_sessionCurrent = S.id
									AND S.name = '$session'");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

			if($data) { return new Player($data); }
			else { return null; }
    	} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try{
			$players = array();
			$q = $this->_db->query("SELECT P.id, P.id_sessionCurrent, P.username, P.email, P.password, P.salt, P.activationCode, Pl.score, Pl.tutorialFinished
									FROM Person P, Player Pl
									WHERE P.id = Pl.id_person
									ORDER BY P.id");
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$players[] = new Player($data);
			}
			return $players;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Player $player)
	{
		$q = $this->_db->prepare('UPDATE Person SET id_sessionCurrent = :id_sessionCurrent, username = :username, email = :email, password = :password, salt = :salt, activationCode = :activationCode WHERE id = :id');

		
		$q->bindValue(':id', $player->id());
		$q->bindValue(':id_sessionCurrent', $player->id_sessionCurrent());
		$q->bindValue(':username', $player->username());
		$q->bindValue(':email', $player->email());
		$q->bindValue(':password', $player->password());
		$q->bindValue(':salt', $player->salt());
		$q->bindValue(':activationCode', $player->activationCode());

		$q->execute();


		$q1 = $this->_db->prepare('UPDATE Player SET score = :score, tutorialFinished = :tutorialFinished WHERE id_person = :id_person');

		$q1->bindValue(':id_person', $player->id_person());
		$q1->bindValue(':score', $player->score());
		$q1->bindValue(':tutorialFinished', $player->tutorialFinished());

		$q1->execute();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

	/* To add a new player in the DB see the example bellow

		$player = new Player([
		  	'id_sessionCurrent' => '...',
		  	'username' => ...,
		  	'email' => ...,
		  	'password' => ...,
		  	'salt' => ...,
		  	'score' => ...,
		  	'tutorialFinished' => ...,
		  	'activationCode' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new PlayerManager($db);
		$manager->add($player);
		$db = null;
	 */
}
?>

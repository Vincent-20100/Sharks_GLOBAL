<?php
class PlayerManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Player $player)
	{
		$q = $this->_db->prepare('INSERT INTO Person(id_sessionCurrent, username, email, password, salt) VALUES(:id_sessionCurrent, :username, :email, :password, :salt)');
		
		$q->bindValue(':id_sessionCurrent', $player->id_sessionCurrent());
		$q->bindValue(':username', $player->username());
		$q->bindValue(':email', $player->email());
		$q->bindValue(':password', $player->password());
		$q->bindValue(':salt', $player->salt());

		$q->execute();



		$q2 = $this->_db->prepare('INSERT INTO Player(score, tutorialFinished, activationCode) VALUES(:score, :tutorialFinished, :activationCode)');

		$q2->bindValue(':score', $player->score());
		$q2->bindValue(':tutorialFinished', $player->tutorialFinished());
		$q2->bindValue(':activationCode', $player->activationCode());

		$q2->execute();
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

			$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt, score, tutorialFinished, activationCode FROM Person per, Player pla  WHERE per.id = '.$id.' AND pla.id_person = '.$id);
			$donnees = $q->fetch(PDO::FETCH_ASSOC);

			return new Player($donnees);
    	} catch(Exception $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try{
			$players = [];
			$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt, score, tutorialFinished, activationCode FROM Person, Player WHERE Person.id = Player.id_person ORDER BY Person.id');
			while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
			{
				$players[] = new Player($donnees);
			}
			return $players;
		} catch(Exception $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Player $player)
	{
		$q = $this->_db->prepare('UPDATE Person SET id_sessionCurrent = :id_sessionCurrent, username = :username, email = :email, password = :password, salt = :salt WHERE id = :id');
		
		$q->bindValue(':id', $player->id());
		$q->bindValue(':id_sessionCurrent', $player->id_sessionCurrent());
		$q->bindValue(':username', $player->username());
		$q->bindValue(':email', $player->email());
		$q->bindValue(':password', $player->password());
		$q->bindValue(':salt', $player->salt());

		$q->execute();


		$q1 = $this->_db->prepare('UPDATE Player SET score = :score, tutorialFinished = :tutorialFinished, activationCode = :activationCode WHERE id_person = :id_person');

		$q1->bindValue(':id_person', $player->id_person());
		$q1->bindValue(':score', $player->score());
		$q1->bindValue(':tutorialFinished', $player->tutorialFinished());
		$q1->bindValue(':activationCode', $player->activationCode());

		$q1->execute();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

	/* To add a new peron in the DB see the example bellow

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
?>
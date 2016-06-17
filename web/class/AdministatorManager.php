<?php
class AdministatorManager // please use the PersonManager for now because the Administrator need other atributes
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Player $admin)
	{
		$q = $this->_db->prepare('INSERT INTO Person(id_sessionCurrent, username, email, password, salt) VALUES(:id_sessionCurrent, :username, :email, :password, :salt)');
		
		$q->bindValue(':id_sessionCurrent', $admin->id_sessionCurrent());
		$q->bindValue(':username', $admin->username());
		$q->bindValue(':email', $admin->email());
		$q->bindValue(':password', $admin->password());
		$q->bindValue(':salt', $admin->salt());

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
		$id = (int) $id;

		$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt FROM Person per, Administrator admin  WHERE per.id = '.$id.' AND admin.id_person = '.$id);
		$donnees = $q->fetch(PDO::FETCH_ASSOC);

    	return new Administrator($donnees);
	}

	public function getList()
	{
		$admins = [];
		$q = $this->_db->query('SELECT id, id_sessionCurrent, username, email, password, salt, score, tutorialFinished, activationCode FROM Person, Administrator WHERE per.id = '.$id.' AND pla.id_person = '.$id.' ORDER BY Person.id');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$admins[] = new Administrator($donnees);
		}
		return $admins;
	}

	public function update(Administrator $admin)
	{
		$q = $this->_db->prepare('UPDATE Person SET id_sessionCurrent = :id_sessionCurrent, username = :username, email = :email, password = :password, salt = :salt WHERE id = :id');
		
		$q->bindValue(':id', $admin->id());
		$q->bindValue(':id_sessionCurrent', $admin->id_sessionCurrent());
		$q->bindValue(':username', $admin->username());
		$q->bindValue(':email', $admin->email());
		$q->bindValue(':password', $admin->password());
		$q->bindValue(':salt', $admin->salt());

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
		$this->_db = $db;
	}

	/* To add a new peron in the DB see the example bellow

		$admin = new Administrator([
		  	'id_sessionCurrent' => '...',
		  	'username' => ...,
		  	'email' => ...,
		  	'password' => ...,
		  	'salt' => ...
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new AdministatorManager($db);
		$manager->add($admin);
		$db = null;
	 */
?>
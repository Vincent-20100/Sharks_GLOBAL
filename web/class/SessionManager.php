<?php
class SessionManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Session $session)
	{
		$q = $this->_db->prepare('INSERT INTO Person(id, id_person, ipv4, date, os, device, browser) VALUES(:id, :id_person, :ipv4, :date, :os, :device, :browser)');
		
		$q->bindValue(':id', $session->id());
		$q->bindValue(':id_person', $session->id_person());
		$q->bindValue(':ipv4', $session->ipv4());
		$q->bindValue(':date', $session->date());
		$q->bindValue(':os', $session->os());
		$q->bindValue(':device', $session->device());
		$q->bindValue(':browser', $session->browser());

		$q->execute();
	}


	public function delete(Session $session)
	{
		$this->_db->exec('DELETE FROM Session WHERE id = '.$session->id());
	}

	public function get($id)
	{
		$q = $this->_db->query('SELECT id, id_person, ipv4, date, os, device, browser  FROM Session  WHERE id = '.$id);
		$donnees = $q->fetch(PDO::FETCH_ASSOC);

    	return new Session($donnees);
	}

	public function getList()
	{
		$sessions = [];
		$q = $this->_db->query('SELECT id, id_person, ipv4, date, os, device, browser ORDER BY id_person');
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
		{
			$sessions[] = new Session($donnees);
		}
		return $sessions;
	}

	public function update(Session $session)
	{
		$q = $this->_db->prepare('UPDATE Session SET id = :id, id_person = :id_person, ipv4 = :ipv4, date = :date, os = :os, device = :device, browser = :browser WHERE id = :id');
		
		$q->bindValue(':id', $session->id());
		$q->bindValue(':id_person', $session->id_person());
		$q->bindValue(':ipv4', $session->ipv4());
		$q->bindValue(':date', $session->date());
		$q->bindValue(':os', $session->os());
		$q->bindValue(':device', $session->device());
		$q->bindValue(':browser', $session->browser());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

	/* To add a new peron in the DB see the example bellow

		$session = new Session([
		  	'id' => '...',
		  	'id_person' => ...,
		  	'ipv4' => ...,
		  	'date' => ...,
		  	'os' => ...,
		  	'device' => ...,
		  	'browser' => ...,
		]);
  	 
		$db = new PDO('mysql:host=localhost;dbname=sharksTaggingGame', 'root', '');
		$manager = new SessionManager($db);
		$manager->add($session);
		$db = null;
	 */
?>
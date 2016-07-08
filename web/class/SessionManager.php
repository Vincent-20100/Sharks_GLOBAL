<?php
$_SESSION_MANAGER_PHP = true;

class SessionManager
{
	private $_db; // instance of PDO

	public function __construct($db)
	{
	    $this->setDb($db);
	}

	public function add(Session $session)
	{
		$q = $this->_db->prepare('INSERT INTO Session(id, name, id_person, ipv4, date, os, device, browser) VALUES(:id, :id_person, :ipv4, :date, :os, :device, :browser)');
		
		$q->bindValue(':id', $session->id());
		$q->bindValue(':name', $session->name());
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
		try{
			$q = $this->_db->query("SELECT id, name, id_person, ipv4, date, os, device, browser
									FROM Session
									WHERE id = $id");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Session($data);
	    } catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getByName($name)
	{
		try{
			$q = $this->_db->query("SELECT id, name, id_person, ipv4, date, os, device, browser
									FROM Session
									WHERE name = '$id'");
			if($q === false){ return null; }
			$data = $q->fetch(PDO::FETCH_ASSOC);

	    	return new Session($data);
	    } catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function getList()
	{
		try{
			$sessions = [];
			$q = $this->_db->query("SELECT id, name, id_person, ipv4, date, os, device, browser
									FROM Session
									ORDER BY id_person");
			if($q === false){ return null; }
			while ($data = $q->fetch(PDO::FETCH_ASSOC))
			{
				$sessions[] = new Session($data);
			}
			return $sessions;
		} catch(PDOException $e) {
			exit ('<b>Catched exception at line '. $e->getLine() .' :</b> '. $e->getMessage());
		}
	}

	public function update(Session $session)
	{
		$q = $this->_db->prepare("UPDATE Session
									SET id = :id, id_person = :id_person, ipv4 = :ipv4, os = :os, device = :device, browser = :browser
									WHERE id = :id");
		
		$q->bindValue(':id', $session->id());
		$q->bindValue(':id_person', $session->id_person());
		$q->bindValue(':ipv4', $session->ipv4());
		$q->bindValue(':os', $session->os());
		$q->bindValue(':device', $session->device());
		$q->bindValue(':browser', $session->browser());

		$q->execute();
	}

	public function setDb(PDO $db)
	{
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		$this->_db = $db;
	}

	/* To add a new session in the DB see the example bellow

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
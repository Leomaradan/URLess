<?php

class PdoDriver implements AccessDriver {

	private $pdo;
	private $table;
	
	function __construct() {
		global $config;
		
		try {
			$this->pdo = new PDO($config['pdo']['dsn'], $config['pdo']['user'], $config['pdo']['passwd']);
		
		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}	
		
		$this->table = $config['pdo']['table'];
	}

	function openId($id, $create = false) {

		$sth = $this->pdo->prepare('SELECT Url FROM '.$this->table.' WHERE Id = ? LIMIT 1');
		
		$sth->execute(array($id));
		
		$result = $sth->fetch();
		
		if(count($result) > 0) {
			return $result['Url'];
		}
		
		return false;
	}

	function appendToId($id,$url) {
		
		$sth = $this->pdo->prepare('INSERT INTO '.$this->table.' (Id, Url) VALUES (?, ?)');
		
		return $sth->execute(array($id, $url));
	}
	
	function getId($url) {
		$sth = $this->pdo->prepare('SELECT SQL_CACHE Id FROM '.$this->table.' WHERE Url = ? LIMIT 1');
		
		$sth->execute(array($url));
		
		$result = $sth->fetch();
		
		if(count($result) > 0) {
			return $result['Id'];
		}
		
		return false;
	}

}

?>
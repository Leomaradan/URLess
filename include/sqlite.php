<?php

class SqliteDriver implements AccessDriver {

	private $sql;
	private $table;
	
	function __construct() {
		global $config;
		
		$this->sql = sqlite_open($config['sqlite']['db'], 0666, $error);
		
		if (!$this->sql) die ($error);
		
		$this->table = $config['sqlite']['table'];
	}

	function openId($id, $create = false) {

	
		$query = "SELECT Url FROM ".$this->table." WHERE Id = '$id' LIMIT 1";
		$result = sqlite_query($dbhandle, $query);	
		$row = sqlite_fetch_array($result, SQLITE_ASSOC); 	
			
		if(count($row) > 0) {
			return $result['Url'];
		}
		
		return false;
	}

	function appendToId($id,$url) {
		
		$stm = "INSERT INTO '.$this->table.' (Id, Url) VALUES ('$id', '$url')";
	
		return sqlite_exec($this->sql, $stm);
		
	}
	
	function getId($url) {
	
		$query = "SELECT Id FROM ".$this->table." WHERE Url = '$url' LIMIT 1";
		$result = sqlite_query($dbhandle, $query);	
		$row = sqlite_fetch_array($result, SQLITE_ASSOC); 
		
		if(count($row) > 0) {
			return $result['Id'];
		}
		
		return false;
	}

}

?>
<?php
class redalert_db {

function _construct($dbprefix) {
	 $this->dbpath = $dbprefix . "/db/data.db";
}

function create() {
	 if ( !file_exists($this->dbpath)) {
	    	$db = new PDO("sqlite:" . $this->dbpath);
		$sql = <<<SQL
		CREATE TABLE units
		(
		ACTOR_ID INTEGER PRIMARY KEY AUTOINCREMENT,
		NAME TEXT,
		COST INTEGER,
		HP INTEGER,
		);
		
	     	$db->prepare($sql);
		$db->execute();
		$db = null
		return 1;
	 }

	 else {
	      return 0;
	 }
}

function start() {
	 $this->pdo_conn = null;
	 $this->pdo_conn = new PDO("sqlite:" . $this->dbpath);
}

function close() {
	 $this->pdo_conn = null;
}

function insert_record($name, $cost, $hp) {
	 if (!isset($this->pdo_conn)) {
	    return null;
	 }
	 else {
	      $sql = <<<SQL
	      INSERT INTO units
	      (NAME, COST, HP)
	      VALUES
	      ( :name , :cost , :hp );
	      SQL;

	      $st = $this->pdo_conn->prepare($sql);
	      $st->bindValue(":name", $name);
	      $st->bindValue(":cost", $cost);
	      $st->bindValue(":hp", $hp);
	      $st->execute();
	      
	 }
}

function read_table() {
	 $sql = 'SELECT * FROM units';
	 $st = $this->pdo_conn->prepare($sql);
	 $st->execute();
	 return $st->fetchAll(PDO::FETCH_ASSOC);
}

}
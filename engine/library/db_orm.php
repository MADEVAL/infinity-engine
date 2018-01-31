<?php

class DatabaseTableStructure{
	function __construct($table, $connection, $generate = true) {
		$this->connection = $connection;
		$this->table = $table;
		$this->generated = false;
		$this->structure = null;
		if($generate == true){
			$this->generate();
		}
	}
	function generate(){
		$db = $this->connection;
		$query =  $db->query("SHOW COLUMNS FROM `" . $this->table . "`") or die($db->error);
		$columns = [];
		while($row = $query->fetch_assoc()){
			array_push($columns, $row);
		}
		$this->generated = true;
		$this->structure = $columns;
	}
	function query(){
		return $this->connection->query($x);
	}
}

class DatabaseStructure{
	function __construct(){
		$this->connection = db();
		$this->structure = [];
		$this->table = [];
		$this->generated = false;
		$this->builded = false;
		$this->released = false;
	}
	function generate(){
		$query = $this->connection->query("SHOW TABLES");
		$tables = [];
		while($row = $query->fetch_array()){
			$tables[] = $row[0];
		}
		$this->generated = true;
		$this->structure = $tables;
	}
	function build(){
		if(!$this->generated) {$this->generate();}
		foreach ($this->structure as $table) {
			$this->table[$table] = new DatabaseTableStructure($table, $this->connection);
			$this->table[$table]->generate();
		}
		$this->builded = true;
	}
	function release(){
		$this->connection->close();
		$this->released = true;
	}
	function __destruct(){
		if(!$this->released) $this->release();
	}
}
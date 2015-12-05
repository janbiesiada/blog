<?php
abstract class Model {
	protected $conn;


	public function __construct()
	{
		foreach(array_keys($this->tableFields) as $field)
		{
			$this->{$field} = '';
		}
		try {
			$this->conn = new PDO("mysql:host=".DB_SERVER.";",DB_USER, DB_PASSWORD);
	    	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    	$this->createDatabase();
	    	$this->createTable();
	    }
    	catch(PDOException $e)
	    {
	    	echo "Connection failed: " . $e->getMessage();
	    }
	}
	public function execSql($sql)
	{
		try {
			$this->conn->exec($sql);		
		} catch (Exception $e) {
    		echo $e->getMessage();				
		}
	}
	private function createDatabase()
	{
		if($this->conn)
		{
			$sql = 'CREATE DATABASE IF NOT EXISTS '.DB_DATABASE.' DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci';
			$this->execSql($sql);		
		}
	}
	public function createTable()
	{
		$sql = "CREATE TABLE IF NOT EXISTS ";
		$sql.= "`".DB_DATABASE."`".".`".$this->tableName."` (";
		$join = "";
		foreach ($this->tableFields as $field => $type) {
			$sql.= $join."`".$field."` ".$type;
			$join = ", ";
		}
		$sql.= ") ENGINE = InnoDB;";
		$this->execSql($sql);	

	}

	public function find($tableKey)
	{
		return $this->findByField($this->tableKey,$tableKey);
	}

	public function findByField($fieldName,$fieldValue)
	{
		$q = $this->conn->prepare("SELECT * FROM `".DB_DATABASE."`".".`".$this->tableName."` WHERE ".$fieldName." = :field LIMIT 1");
		$q->bindValue(':field', $fieldValue);
		$q->execute();
		$element = null;
		if ($q->rowCount() > 0){
			$element = new $this();
		    $check = $q->fetch(PDO::FETCH_ASSOC);
		    foreach(array_keys($this->tableFields) as $field)
			{
				$element->{$field} = $check[$field];
			}
		}
		return $element;
	}
	public function all()
	{
		$q = $this->conn->prepare("SELECT * FROM `".DB_DATABASE."`".".`".$this->tableName."`");
		$q->execute();
		$array=[];
		if ($q->rowCount() > 0){
		    $checks = $q->fetchAll(PDO::FETCH_ASSOC);
		    foreach($checks as $check)
		    {
				$element = new $this();
			    foreach(array_keys($this->tableFields) as $field)
				{
					$element->{$field} = $check[$field];
				}		    	
				$array[] = $element;
		    }
		}
		return $array;
		
	}

	public function insert($input)
	{
		$sql = "INSERT INTO `".DB_DATABASE."`".".`".$this->tableName."` (";
		$join = "";
		foreach(array_keys($this->tableFields) as $field)
		{
			$sql.=$join."`".$field."`";
			$join = ", ";
		}
		$sql.=") VALUES (";
		$join = "";
		foreach(array_keys($this->tableFields) as $field)
		{
			if($field == $this->tableKey)
				$sql.=$join."NULL";
			elseif(isset($input[$field]))				
				$sql.=$join."'".$input[$field]."'";
			else
				return null;
			$join = ", ";
		}
		$sql.=");";
		$this->execSql($sql);
	}

}
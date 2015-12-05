<?php

class Post extends model{
	protected $tableKey = 'id';
	protected $tableName = 'posts';
	protected $tableFields = [
		'id'	=>	'INT NOT NULL AUTO_INCREMENT PRIMARY KEY',
		'title'	=>	'VARCHAR(255) NOT NULL',
		'body'	=>	'TEXT NOT NULL ',
		'userid'=>	'INT NOT NULL',
	];


	public function store($input)
	{
		$this->insert($input);
		return true;
	}
			

}
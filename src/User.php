<?php

class User extends model{
	protected $tableKey = 'id';
	protected $tableName = 'users';
	protected $tableFields = [
		'id'	=>	'INT NOT NULL AUTO_INCREMENT PRIMARY KEY',
		'email'	=>	'VARCHAR(255) NOT NULL',
		'password'	=>	' VARCHAR(255) NOT NULL',
		'level'	=>	'INT NOT NULL',
	];
	public function auth($input)
	{
		$user = $this->findByField('email',$input['email']);
		if($user && $input['password'] == $user->password)
		{
			session_start();
			$_SESSION['user'] = $user->id;
			return $user;
		}
		return null;
	}
	public function logedIn()
	{
		try {
		session_start();
			
		} catch (Exception $e) {
			
		}
		if(!empty($_SESSION['user']))
			return $this->find($_SESSION['user']);
		return null;
	}
	public function logOut()
	{
		session_start();
		unset($_SESSION['user']);		
	}

	public function register($input)
	{
		if($input['password'] == $input['password_rep'])
		{
			unset($input['password_rep']);
			$input['level'] = 1;
			$this->insert($input);
			return true;
		}
		return false;


	}

			

}
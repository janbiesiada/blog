<?php

class Controller {
	protected $users;
	protected $posts;

	public function __construct($users, $posts)
	{
		$this->users = $users;
		$this->posts = $posts;
	}

	
	public function submitLogin($input)
	{
		$user = $this->users->auth($input);
		if($user->logedIn())
			Redirect(get_main()."posts");
		Redirect(get_main()."login");

	}
	public function submitRegister($input)
	{
		$check = $this->users->register($input);
		if($check){
			$user = $this->users->auth($input);
			if($user->logedIn())
				Redirect(get_main()."posts");
			Redirect(get_main()."login");
		}
		Redirect(get_main()."register");
		
	}
	public function submitPost($input)
	{
		if($user = $this->users->logedIn())
		{
			$input['userid'] = $user->id;
			$this->posts->store($input);
			Redirect(get_main()."posts");
		}
		Redirect(get_main()."login");
	}

	public function listing()
	{
		$user = $this->users->logedIn();
		$posts = $this->posts->all();
		include("view/listing.php");
	}
}
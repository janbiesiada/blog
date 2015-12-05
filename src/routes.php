<?php
$users = new User();
$posts = new Post();
$controller = new Controller($users,$posts);

function get_routes()
{
	$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	return explode(" ",trim(str_replace("/"," ",explode('index.php', $actual_link)[1])));
}
function get_main()
{	
	$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	return explode('index.php', $actual_link)[0]."index.php/";
}
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}
switch(get_routes()[0]){
	case "":
		Redirect(get_main()."posts");
	break;

	case "login":
		if($users->logedIn())
			Redirect(get_main()."posts");
		include ('view/loginform.php');
	break;

	case "register":
		if($users->logedIn())
			Redirect(get_main()."posts");
		include ('view/registerform.php');
	break;
	case "submitlogin":
		$controller->submitLogin($_POST);
	break;
	case "submitregister":
		$controller->submitRegister($_POST);
	break;
	case "logout":
		$users->logOut();
		Redirect(get_main()."login");
	break;

	case "submitpost":
		if($users->logedIn())
			$controller->submitPost($_POST);
		else
			Redirect(get_main()."login");
	break;

	case "posts":
		if($users->logedIn())
			$controller->listing();
		else
			Redirect(get_main()."login");
	break;

	default:
	 echo "not found";
	break;
}
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
<form action="<?= get_main()?>submitlogin" method="POST">
	<input type="email" name="email">
	<input type="password" name="password">
	<input type="submit">
</form>
<a href="<?= get_main()?>register">Zarejestruj</a>
</body>
</html>
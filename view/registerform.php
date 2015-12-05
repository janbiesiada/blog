<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
<form action="<?= get_main()?>submitregister" method="POST">
	<p>Email: <input type="email" name="email"></p>
	<p>Password:<input type="password" name="password"></p>
	<p>Password repeat:<input type="password" name="password_rep"></p>
	<input type="submit">
</form>

</body>
</html>
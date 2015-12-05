<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<h1>zalogowany: <?=$user->email?> <a href="<?= get_main()?>logout">Wyloguj</a></h1>
<h1>Posty:</h1>
<div>
<?php
foreach($posts as $post)
{
?>
<p>
<h2>
<?=$post->title?>
</h2>
<body>
<?=$post->body?>
</body>
	
</p>
<?php
}
?>
</div>

<form action="<?= get_main()?>submitpost" method="POST">
	<h1>Napisz post:</h1>
	<p>tytuł<input type="text" name="title"></p>
	<p>treść<textarea name="body"></textarea></p>
	<p><input type="submit"></p>
</form>

</body>
</html>
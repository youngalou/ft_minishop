<?php

if ($_POST['submit'] === 'Register' && $_POST['login'] && $_POST['passwd'])
{
	$tab['login'] = $_POST['login'];
	$tab['passwd'] = hash('whirlpool', $_POST['passwd']);
	$tab['admin'] = NULL;
	if (file_exists("database/users"))
	{
		$contents = file_get_contents("database/users");
		$arr = unserialize($contents);
	}
	if (!$arr[$_POST['login']])
	{
		$arr[$_POST['login']] = $tab;
		$serial = serialize($arr);
		file_put_contents("database/users", $serial);
		//echo "Success!\n";
		header('Location: http://localhost:8080/ft_minishop/homepage.php');
	}
	else if ($arr[$_POST['login']]['login'])
		echo "Error:\nUsername already taken.";
	else
		echo "ERROR\n";
}
else if ($_POST['passwd'] === "")
	echo "Error:\nInvalid password.";

?>

<html>
	<title>Register</title>
	<head>
	<style>
		.form
		{
			background-color: #909090;
			border: solid 2px black;
			border-radius: 5px;
			width: 300px;
			height: 75px;
		}
	</style>
	</head>
	<body>
		<div class='form'>
			<form action="register.php" method="post">
				Username: <input type='text' name='login'><br />
				Password: <input type='password' name='passwd'><br />
				<input type='submit' name='submit' value='Register'>
			</form>
		</div>
	</body>
</html>

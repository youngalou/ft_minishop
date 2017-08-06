<?php

function authenticate($login, $passwd)
{
    if (!$login || !$passwd || !file_exists("database/users"))
        return (0);
    $hash = hash('whirlpool', $passwd);
    $contents = file_get_contents("database/users");
    $arr = unserialize($contents);
	if ($arr[$login] && $hash === $arr[$login]['passwd'])
	{
		if ($arr[$login]['admin'] === "admin")
			return (2);
		return (1);
	}
    else
        return (0);
}

session_start();
$access = authenticate($_POST['login'], $_POST['passwd']);
if ($access)
{
	if ($_SESSION['logged_on_user'] === $_POST['login'])
		echo "Already logged in!\n";
	else
	{
		$_SESSION['logged_on_user'] = $_POST['login'];
		if ($access === 2)
		{
			$_SESSION['admin'] = "admin";
			echo "Welcome, administrator!\n";
		}
		else
			echo "Welcome, you are logged in!\n";
	}
}
else
{
	$_SESSION['logged_on_user'] = NULL;
	echo "Error:\nInvalid username/password.";
}

?>

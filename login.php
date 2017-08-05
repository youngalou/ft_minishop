<?php

function authenticate($login, $passwd)
{
    if (!$login || !$passwd)
        return (false);
    $hash = hash('whirlpool', $passwd);
    if(!($contents = file_get_contents("private/passwd")))
        return (false);
    $arr = unserialize($contents);
    if ($arr[$login] && $hash === $arr[$login]['passwd'])
        return (true);
    else
        return (false);
}

session_start();
if (authenticate($_POST['login'], $_POST['passwd']))
{
	if ($_SESSION['logged_on_user'] === $_POST['login'])
		echo "Already logged in!\n";
	else
	{
		$_SESSION['logged_on_user'] = $_POST['login'];
		echo "Welcome, you are logged in!\n";
	}
}
else
{
	$_SESSION['logged_on_user'] = NULL;
	echo "Error:\nInvalid username/password.";
}

?>

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
		echo "Success!\n";
	}
	else if ($arr[$_POST['login']]['login'])
		echo "Error:\nUsername already taken.";
	else
		echo "ERROR\n";
}
else if ($_POST['passwd'] === "")
	echo "Error:\nInvalid password.";
else
	echo "ERROR\n";

?>

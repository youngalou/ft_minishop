<?php

if ($_POST['submit'] === 'Change Password' && $_POST['login'] && $_POST['oldpw'] && $_POST['newpw'])
{
	$tab['login'] = $_POST['login'];
	$tab['oldpw'] = hash('whirlpool', $_POST['oldpw']);
	$tab['newpw'] = hash('whirlpool', $_POST['newpw']);
	$contents = file_get_contents("database/users");
	$arr = unserialize($contents);
	if ($_POST['oldpw'] === $_POST['newpw'])
		echo "Error: Passwords are the same.";
	else if ($contents && $tab['login'] === $arr[$_POST['login']]['login'] && $tab['oldpw'] === $arr[$_POST['login']]['passwd'])
	{
		$arr[$_POST['login']]['passwd'] = $tab['newpw'];
		$serial = serialize($arr);
		file_put_contents("database/users", $serial);
		echo "Password has been changed.\n";
	}
	else
		echo "Error: Invalid username/password.\n";
}

?>

<html>
	<title>Change Password</title>
	<head>
	<style>
		.form
		{
			background-color: #909090;
			border: solid 2px black;
			border-radius: 5px;
			width: 300px;
			height: 200px;
		}
	</style>
	</head>
	<body>
		<div class='form'>
			<form action="change_pw.php" method="post">
				<h3>Change Password</h3>
				Username: <input type='text' name='login'><br />
				Old Password: <input type='password' name='oldpw'><br />
				New Password: <input type='password' name='newpw'><br />
				<input type='submit' name='submit' value='Change Password'>
			</form>
		</div>
	</body>
</html>

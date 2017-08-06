<?php

session_start();
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

if ($_POST['submit'] === "Log-in")
{
	$access = authenticate($_POST['login'], $_POST['passwd']);
	if ($access)
	{
        $_SESSION['logged_on_user'] = $_POST['login'];
        $basket_db = fopen("database/basket.csv", 'r');
        while (($basket = fgetcsv($basket_db)) !== FALSE)
        {
            // echo $basket[0];
            if ($basket[0] == $_SESSION['logged_on_user'])
            {
                if (!$_SESSION['basket'])
                    $_SESSION['basket'] = array();
                array_push($_SESSION['basket'], $basket);
            }
        }
		if ($access === 2)
			$_SESSION['admin'] = "admin";
		header('Location: homepage.php');
	}
    else
{
//  $_SESSION['logged_on_user'] = NULL;
    echo "Error:\nInvalid username/password.";
}
}


?>

<html>
	<title>Log-in</title>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>
		<div class="content">
			<div class='form'>
				<form action="login.php" method="post">
					Username: <input type='text' name='login'><br />
					Password: <input type='password' name='passwd'><br />
					<input type='submit' name='submit' value='Log-in'><br />
					Don't have an account? <a href="register.php"><b>Register</b></a><br />
				</form>
			</div>
		</div>
	</body>
</html>

<?php

session_start();
if ($_SESSION['logged_on_user'] === NULL)
	echo "Error:\nNot logged in!";
else
{
	$_SESSION['logged_on_user'] = NULL;
	$_SESSION['admin'] = NULL;
	$_SESSION['basket'] = array();
	echo "Logout successful!";
}

?>
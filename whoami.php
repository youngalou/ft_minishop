<?php

session_start();
if ($_SESSION['logged_on_user'])
{
	echo "Logged in as: ".$_SESSION['logged_on_user']."\n";
	if ($_SESSION['admin'] === "admin")
		echo "You are an administrator!\n";
}
else
	echo "Not logged in.";

?>

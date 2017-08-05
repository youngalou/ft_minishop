<?php

session_start();
if ($_SESSION['logged_on_user'])
	echo "Logged in as: ".$_SESSION['logged_on_user']."\n";
else
	echo "Not logged in.";

?>

<?php

session_start();
if ($_SESSION['logged_on_user'] === NULL)
	echo "Error:\nNot logged in!";
else
{
	foreach ($_SESSION['basket'] as $key => $basket_item) {
		echo $basket_item[0];
		$basket_item[0] = $_SESSION['logged_on_user'];
		$basket_db = fopen("database/basket.csv", 'a+');
		fputcsv($basket_db, $basket_item);
	}
	$_SESSION['basket'] = array();
	$_SESSION['logged_on_user'] = NULL;
	$_SESSION['admin'] = NULL;
	// add save to basket csv

	echo "Logout successful!";
}

?>

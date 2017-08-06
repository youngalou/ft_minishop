<?php

session_start();
if ($_POST['submit'] === 'Add Item' && $_SESSION['logged_on_user'] === 'admin' && file_exists("database/item.csv"))
{
	$item_db = fopen("database/item_db.csv", 'a+');
	echo "Item successfully added!\n";
}
else
	echo "ERROR\n";

?>

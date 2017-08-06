<?php

session_start();
if ($_POST['submit'] === 'Add Item' && $_SESSION['logged_on_user'] === 'admin')
{
	$tab[0] = $_POST['itemID'];
	$tab[1] = $_POST['make'];
	$tab[2] = $_POST['model'];
	$tab[3] = $_POST['year'];
	$tab[4] = $_POST['style'];
	$tab[5] = $_POST['color'];
	$tab[6] = $_POST['condition'];
	$tab[7] = $_POST['price'];
	if (!file_exists("database/item_db.csv"))
		mkdir("database", 0777);
	$item_db = fopen("database/item_db.csv", 'a+');
	fputcsv($item_db, $tab);
	echo "Item successfully added!\n";
}
else
	echo "ERROR\n";

?>

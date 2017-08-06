<?php

session_start();
if ($_POST['submit'] === 'Remove Item' && $_SESSION['logged_on_user'] && file_exists("database/item_db.csv"))
{
	$item_db = fopen("database/item_db.csv", 'a+');
	while ($arr = fgetcsv($item_db))
	{
		if ($arr[0] === $_POST['itemID'])
		{
			$line = $arr[0].','.$arr[1].','.$arr[2].",".$arr[3].",".$arr[4].",".$arr[5].",".$arr[6].",".$arr[7]."\n";
			$contents = file_get_contents("database/item_db.csv");
			$contents = str_replace($line, NULL, $contents);
			file_put_contents("database/item_db.csv", $contents);
			echo "Item successfully removed!\n";
		}
	}
}
else
	echo "ERROR\n";

?>

<?php

session_start();
if ($_POST['submit'] === 'Add Item')
{
    $tab[0] = $_POST['itemID'];
    $tab[1] = $_POST['make'];
    $tab[2] = $_POST['model'];
    $tab[3] = $_POST['year'];
    $tab[4] = $_POST['style'];
    $tab[5] = $_POST['color'];
    $tab[6] = $_POST['condition'];
    $tab[7] = $_POST['price'];
    $tab[8] = $_POST['img_url'];
    if (!file_exists("database/item_db.csv"))
        mkdir("database", 0777);
    $item_db = fopen("database/item_db.csv", 'a+');
    fputcsv($item_db, $tab);
    echo "Item successfully added!\n";
}
else if ($_POST['submit'] === 'Remove Item' && file_exists("database/item_db.csv"))
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
else if ($_POST['submit'] === "Remove User")
{
	if (file_exists("database/users"))
	{
		$contents = file_get_contents("database/users");
		$arr = unserialize($contents);
	}
	if ($arr[$_POST['login']] != NULL)
	{
		$arr[$_POST['login']] = NULL;
		$serial = serialize($arr);
		file_put_contents("database/users", $serial);
		echo "User ".$_POST['login']." successfully removed.";
	}
	else
		echo "User does not exist.";
}
else if ($_POST['submit'] === 'Add Admin' && file_exists("database/users"))
{
	$contents = file_get_contents("database/users");
	$arr = unserialize($contents);
	$arr[$_POST['login']]['admin'] = "admin";
	$serial = serialize($arr);
	file_put_contents("database/users", $serial);
	echo $_POST['login']." is now an administrator!\n";
}

?>

<html>
	<title>Admin</title>
	<head>
		<style>
			.form
			{
				background-color: #909090;
				border: solid 2px black;
				border-radius: 5px;
				width: 300px;
				height: 175px;
			}
		</style>
	</head>
	<body>
		<div class='form'>
			<form action="admin.php" method="post">
				ItemID: <input type='text' name='itemID'><br />
				Make: <input type='text' name='make'><br />
				Model: <input type='text' name='model'><br />
				Year: <input type='text' name='year'><br />
				Style: <input type='text' name='style'><br />
				Color: <input type='text' name='color'><br />
				Condition: <input type='text' name='condition'><br />
				Price: <input type='text' name='price'><br />
				IMG URL: <input type='text' name='img_url'><br />
				<input type='submit' name='submit' value='Add Item'>
			</form>
		</div>
		<div class='form'>
			<form action="admin.php" method="post">
				ItemID: <input type='text' name='itemID'><br />
				<input type='submit' name='submit' value='Remove Item'>
			</form>
		</div>
		<div class='form'>
			<form action="admin.php" method="post">
				Username: <input type='text' name='login'><br />
				<input type='submit' name='submit' value='Remove User'>
			</form>
		</div>
		<div class='form'>
			<form action="admin.php" method="post">
				Username: <input type='text' name='login'><br />
				<input type='submit' name='submit' value='Add Admin'>
			</form>
		</div>
	</body>
</html>

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
            $line = $arr[0].','.$arr[1].','.$arr[2].",".$arr[3].",".$arr[4].",".$arr[5].",".$arr[6].",".$arr[7].",".$arr[8]."\n";
            $contents = file_get_contents("database/item_db.csv");
            $contents = str_replace($line, NULL, $contents);
            file_put_contents("database/item_db.csv", $contents);
            echo "Item successfully removed!\n";
        }
    }
}
else if ($_POST['submit'] === 'Modify Item' && file_exists("database/item_db.csv"))
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
	$item_db = fopen("database/item_db.csv", 'a+');
    while ($arr = fgetcsv($item_db))
    {
        if ($arr[0] === $tab[0])
		{
			$i = 0;
			while ($i < 9)
			{
				if ($tab[$i] === "")
					$tab[$i] = $arr[$i];
				$i++;
			}
            $old = $arr[0].','.$arr[1].','.$arr[2].",".$arr[3].",".$arr[4].",".$arr[5].",".$arr[6].",".$arr[7].",".$arr[8]."\n";
            $new = $tab[0].','.$tab[1].','.$tab[2].",".$tab[3].",".$tab[4].",".$tab[5].",".$tab[6].",".$tab[7].",".$tab[8]."\n";
            $contents = file_get_contents("database/item_db.csv");
            $contents = str_replace($old, $new, $contents);
            file_put_contents("database/item_db.csv", $contents);
            echo "Item successfully modified!\n";
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
else if ($_POST['submit'] === 'Add Admin' && file_exists("database/users") && $_POST['login'] != "")
{
	$contents = file_get_contents("database/users");
	$arr = unserialize($contents);
	if ($arr[$_POST['login']]['admin'] === NULL)
		echo $_POST['login']." is now an administrator!\n";
	else if ($arr[$_POST['login']]['admin'] === "admin")
		echo $_POST['login']." is already an administrator!\n";
	$arr[$_POST['login']]['admin'] = "admin";
	$serial = serialize($arr);
	file_put_contents("database/users", $serial);	
	if ($_POST['login'] === $arr[$_POST['login']]['login'])
		$_SESSION['admin'] = "admin";
}
else if ($_POST['submit'] === 'Remove Admin' && file_exists("database/users") && $_POST['login'] != "")
{
	$contents = file_get_contents("database/users");
	$arr = unserialize($contents);
	if ($arr[$_POST['login']]['admin'] === NULL)
		echo $_POST['login']." was not an administrator.\n";
	else if ($arr[$_POST['login']]['admin'] === "admin")
		echo $_POST['login']." has lost administrator privilege.\n";
	$arr[$_POST['login']]['admin'] = NULL;
	$serial = serialize($arr);
	file_put_contents("database/users", $serial);
	if ($_POST['login'] === $arr[$_POST['login']]['login'])
		$_SESSION['admin'] = NULL;	
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
				height: 100px;
			}
			.item
			{
				background-color: #909090;
				border: solid 2px black;
				border-radius: 5px;
				width: 300px;
				height: 250px;
			}
		</style>
	</head>
	<body>
		<div class='item'>
			<h3>Add Item</h3>
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
			<h3>Remove Item</h3>
			<form action="admin.php" method="post">
				ItemID: <input type='text' name='itemID'><br />
				<input type='submit' name='submit' value='Remove Item'>
			</form>
		</div>
		<div class='item'>
			<h3>Modify Item</h3>
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
				<input type='submit' name='submit' value='Modify Item'>
			</form>
		</div>
		<div class='form'>
			<h3>Remove User</h3>
			<form action="admin.php" method="post">
				Username: <input type='text' name='login'><br />
				<input type='submit' name='submit' value='Remove User'>
			</form>
		</div>
		<div class='form'>
			<h3>Add Admin</h3>
			<form action="admin.php" method="post">
				Username: <input type='text' name='login'><br />
				<input type='submit' name='submit' value='Add Admin'>
			</form>
		</div>
		<div class='form'>
			<h3>Remove Admin</h3>
			<form action="admin.php" method="post">
				Username: <input type='text' name='login'><br />
				<input type='submit' name='submit' value='Remove Admin'>
			</form>
		</div>
	</body>
</html>

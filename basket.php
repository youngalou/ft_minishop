<?php
	session_start();
	echo $_SESSION['logged_on_user']
		."<br>";
	$item_db = fopen("database/basket.csv", 'a+');
	$total = 0;
	echo "Item successfully added!<br>";
	while (($basket = fgetcsv($item_db)) !== FALSE)
	{
		if ($basket[0] == $_SESSION['logged_on_user'])
		{
			echo "Here are your items<br>";
			$total += $basket[3] * $basket[4];
			foreach ($basket as $key => $value) {
				echo $value
					."\t";
			}
		}
		
		echo "<br>"
			."Total: "
			.$total
			."<br>";
	}
	rewind($item_db);
	if ($_POST['submit'] == "Submit")
	{
		echo "It worked!<br>";
		$orders = fopen("database/orders.csv", 'a+');
		while (($basket = fgetcsv($item_db)) !== FALSE)
		{
			if ($basket[0] == $_SESSION['logged_on_user'])
			{
				echo "Splicing order ID<br>";
				array_splice($basket, 1, 0, "345");
				fputcsv($orders, $basket);
			}
		}
		
	}
	else if ($_POST['submit'] == "Disable")
		echo "Disabled!<br>";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="basket.php" method="post">
		<input type='submit' name='submit' value='Submit'>
		<input type='submit' name='submit' value='Disable'>				
	</form>
</body>
</html>

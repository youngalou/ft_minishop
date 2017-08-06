<?php
	session_start();
	if (!$_SESSION['logged_on_user'])
	{
		$welcome = "<h1>Login to view your basket!</h1>"
			."<a href='login.html'>Login Here</a>"
			."<h3> Your cart is empty<h3>";
		$total = 0;

		if ($_POST['order1'] == 'Order')
		{
			echo "Ordered<br>";
			$order1 = array("anonuser", 02, "Charger", 17000, 1);
			array_push($_SESSION['basket'], $order1);
		}
		if ($_SESSION['basket'])
		{
			echo "Something is in your cart!<br>";
			foreach ($_SESSION['basket'] as $key => $basket_item) {
				foreach ($basket_item as $key => $value) {
					if ($key == 2 || $key == 3 || $key == 4)
					{
						echo $value."\t";
						
					}
				}
				echo "<br>";
			}
		}
	}
	else
	{
		$welcome = "<h1>Welcome "
		.ucfirst($_SESSION['logged_on_user'])
		.", here's what is in your basket"
		."</h1><br>";
		$basket_db = fopen("database/basket.csv", 'a+');
		$total = 0;
		// $basket_collection = array();
		$basket_collection = $_SESSION['basket'];
		// while (($basket = fgetcsv($basket_db)) !== FALSE)
		// {
		// 	if ($basket[0] == $_SESSION['logged_on_user'])
		// 	{
		// 		array_push($basket_collection, $basket);
		// 		$total += $basket[3] * $basket[4];
		// 	}
		// }
		// rewind($basket_db);
		foreach ($basket_collection as $key => $basket_item) {
			$total += $key[3] * $key[4];
		}
		if ($_POST['submit'] == "Confirm Order")
		{
			$orders_db = fopen("database/orders.csv", 'a+');
			$maxOrder = 0;
			while (($orders = fgetcsv($orders_db)) !== FALSE)
			{
				if ($orders[1] > $maxOrder)
					$maxOrder = $orders[1];
			}
			rewind($orders_db);
			while (($basket = fgetcsv($basket_db)) !== FALSE)
			{

				if ($basket[0] == $_SESSION['logged_on_user'])
				{
					array_splice($basket, 1, 0, $maxOrder + 1);
					fputcsv($orders_db, $basket);
				}
			}
		}
	}


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
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?=$welcome?>
	<?php 
		if ($_SESSION['logged_on_user'])
		{
			$itemId = array();
			$itemQuant = array();
			foreach ($basket_collection as $key => $basket_item) {
				foreach ($basket_item as $key => $value) {
					if ($key == 2 || $key == 3 || $key == 4)
					{
						echo $value."\t";
						
					}
						
				}
				echo "<form action='rm_item.php' method='post'>
										ItemID: <input type='text' name='itemID'><br />
										<input type='submit' name='submit' value='Remove Item'>
									</form>	";
				echo "<br>";
			}
			$basket_collection[0][2];
		}
		?>
	<h3>Your total comes out to: $<?=$total?></h3>
	<form action="basket.php" method="post">
		<input type='submit' name='submit' value='Confirm Order'>
	</form>
	<div class='form'>
			<form action="rm_item.php" method="post">
				ItemID: <input type='text' name='itemID'><br />
				<input type='submit' name='submit' value='Remove Item'>
			</form>
		</div>
</body>
</html>

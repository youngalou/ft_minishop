<?php
	session_start();
	if (!$_SESSION['logged_on_user'])
	{
		$welcome = "<h1>Login to view your basket!</h1>";
	}
	else
	{
		$welcome = "<h1>Welcome "
		.ucfirst($_SESSION['logged_on_user'])
		.", here's what is in your basket"
		."</h1><br>";
		$basket_db = fopen("database/basket.csv", 'a+');
		$total = 0;
		$basket_collection = array();
		while (($basket = fgetcsv($basket_db)) !== FALSE)
		{
			if ($basket[0] == $_SESSION['logged_on_user'])
			{
				// echo "Here are your items<br>";
				array_push($basket_collection, $basket);
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
		rewind($basket_db);
		if ($_POST['submit'] == "Submit")
		{
			echo "It worked!<br>";
			$orders = fopen("database/orders.csv", 'a+');
			while (($basket = fgetcsv($basket_db)) !== FALSE)
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
	}	
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?=$welcome?>
	<?php 
		foreach ($basket_collection as $key => $basket_item) {
			foreach ($basket_item as $key => $value) {
				if ($key == )
				echo $value."<br>";	
			}
		}
	$basket_collection[0][2]?>
	<h3>Your total comes out to: $<?=$total?></h3>
	<form action="basket.php" method="post">
		<input type='submit' name='submit' value='Submit'>
		<input type='submit' name='submit' value='Disable'>				
	</form>
</body>
</html>

<?php

	session_start();
	if ($_SESSION['logged_on_user'] === NULL)
	{
		$topNav = "<li><a href='login.php'><b>Log-in</b></a></li>"
			."<li><a href='register.php'><b>Sign-Up!</b></a></li>";
	}
	else
	{
		$topNav	= "<form action='homepage.php' method='post'><input type='submit' name='submit' value='Log-out'></form>";
		if ($_SESSION['admin'] === "admin")
			$topNav .= "<li><a href='admin.php'><b>Admin</b></a></li>";
	}
	if ($_POST['submit'] === "Log-out")
	{
		if ($_SESSION['logged_on_user'] === NULL)
			echo "Error:\nNot logged in!";
		else
		{
			$basket_db = fopen("database/basket.csv", 'a+');
			foreach ($_SESSION['basket'] as $key => $basket_item) {
				$basket_item[0] = $_SESSION['logged_on_user'];
				fputcsv($basket_db, $basket_item);
			}
			$_SESSION['basket'] = array();
			$_SESSION['logged_on_user'] = NULL;
			$_SESSION['admin'] = NULL;
			$logout = "Logout successful!";
			echo "<script type='text/javascript'>alert('$logout');</script>";
		}
	}
	else if ($_POST['submit'] === "Check User")
	{
		if ($_SESSION['logged_on_user'])
		{
			echo "Logged in as: ".$_SESSION['logged_on_user']."\n";
			if ($_SESSION['admin'] === "admin")
				echo "You are an administrator!\n";
		}
		else
			echo "Not logged in.";
	}
	$item_db = fopen("database/item_db.csv", 'r');
	$item = fgetcsv($item_db);
?>

<html>
	<title>ft_minishop</title>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/homepage.css">
	</head>
	<body>
		<div class="header col-12">
			<div class="topNav">
				<div class="row">
					<div class="col-12">
						<ul>
							<li><a href="basket.php"><b>Basket</b></a></li>
							<!-- <li><a href="login.php"><b>Log-in</b></a></li>
							<li><a href="admin.php"><b>Admin</b></a></li>
							<form action="homepage.php" method="post"><input type='submit' name='submit' value='Log-out'></form> -->
							<?=$topNav?>
							<form action="homepage.php" method="post"><input type='submit' name='submit' value='Check User'></form>
						</ul>
					</div>
				</div>
			</div>
			<div class="logo">
				<h1>Scooter's Catch-A-Ride</h1>
			</div>
			<div class="navBar">
				<ul>
					<div class="col-2">
						<li><form action="sort_by_type.php" method="post"><input type='submit' name='submit' value='Sedan'></form></li>
					</div>
					<div class="col-2">
						<li>Mini Van</li>
					</div>
					<div class="col-2">
						<li>SUV</li>
					</div>
					<div class="col-2">
						<li>Hatchback</li>
					</div>
					<div class="col-2">
						<li>Truck</li>
					</div>
					<div class="col-2">
						<li>Motorcycle</li>
					</div>
				</ul>
			</div>
		</div>
		<div class="content">
			<div class="row">
				<div class="jumbotron col-12">
					<img src="img/cars.jpg">
					<?php
						$item = fgetcsv($item_db);
						echo $item[0];
					?>
					<form action="addToBasket.php" method="post">
						<input type="submit" name="<?=$item[0]?>" value="Order">
					</form>
				</div>
			</div>
			<!-- </div> -->
			<div class="row">
				<div class="jumbotron col-12">
					<img src="img/chev.jpg">
				</div>
			</div>
			<div class="row">
				<div class="moreInfo col-6">
					<img src="img/sale.jpg">
				</div>
				<div class="moreInfo col-6">
					<img src="img/sale.jpg">
				</div>
			</div>
		</div>
		<div class="footer col-12">
			<div class="bottomNav">
				<div class="col-4">
					Next Door
				</div>
				<div class="col-8">
					<div class="col-4">
						Test
					</div>
					<div class="col-4">
						Test
					</div>
					<div class="col-4">
						Test
					</div>
				</div>
			</div>
		</div>
		<div>
		</div>
<br />
	</body>
</html>
<?php
	session_start();
	if ($_SESSION['logged_on_user'] === NULL)
	{
		$topNav = "<li><a href='login.php'><b>Log-in</b></a></li>"
			."<li><a href='register.php'><b>Sign-Up!</b></a></li>";
	}
	else
	{
		$topNav	= "<li><form action='homepage.php' method='post'><input type='submit' name='submit' value='Log-out'></form></li>"
			."<li><a href='modify.php'>Change Password</a></li>";
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
			rewind($basket_db);
			while (($basket = fgetcsv($basket_db)) !== FALSE)
			{
				if ($basket[5] > $entry)
					$entry = $basket[5];
			}
			$entry += 1;
			foreach ($_SESSION['basket'] as $key => $basket_item) {
				rewind($basket_db);
				$match = FALSE;
				// echo "USER "
				// 	.$basket_item[0]
				// 	."<br>";
				$basket_item[0] = $_SESSION['logged_on_user'];
				while (($basket = fgetcsv($basket_db)) !== FALSE)
				{
					// echo "CSV UID "
					// 	.$basket[0]
					// 	."<br>";
					if ($basket[0] == $_SESSION['logged_on_user'])
					{
						// echo "DID "
						// 	.$basket[1]
						// 	."SID "
						// 	.$basket_item[1]
						// 	.
						// 	"<br>";
						if ($basket[1] == $basket_item[1])
						{
							// echo "Matched<br>";
							if (($basket[5] == $basket_item[5] && $basket[4] != $basket_item[4]) || ($basket[5] != $basket_item[5]))
							{
								$basket_item[4] += $basket[4];
							}
							$contents = file_get_contents("database/basket.csv");
							// print_r($basket);
							// echo "Contents"
							// 	.$contents;
							$contents = str_replace(implode(",", $basket)."\n", NULL, $contents);
							file_put_contents("database/basket.csv", $contents);
							if (!$basket_item[5])
								array_push($basket_item, $entry);
							fputcsv($basket_db, ($basket_item));
							$match = TRUE;
							break;
						}
					}
				}
				if ($match === FALSE)
				{
					if (!$basket_item[5])
						array_push($basket_item, $entry);
					fputcsv($basket_db, $basket_item);
				}
			}
			$_SESSION['basket'] = array();
			$_SESSION['logged_on_user'] = NULL;
			$_SESSION['admin'] = NULL;
			$logout = "Logout successful!";
			header("Refresh:0");
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
	$item = fgetcsv($item_db);
	$desc = $item[6]." ".$item[3]." ".$item[1]." ".$item[2]." ".$item[5]." for: $".$item[7];
	$img = $item[8];
	$itemID = $item[0];
	$html = "<div class='row'><div class='jumbotron col-12'><h3 class='jumbotron'>Featured Car</h3><p>$desc</p><img src='$img'><form action='addToBasket.php' method='post'><input type='submit' name=$itemID value=    'Order'></form></div></div>";
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
					</div>
					<div class="col-2">
						<li><form action="sort_by_type.php" method="post"><input type='submit' name='submit' value='Sedan'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_type.php" method="post"><input type='submit' name='submit' value='SUV'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_type.php" method="post"><input type='submit' name='submit' value='Minivan'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_type.php" method="post"><input type='submit' name='submit' value='Sport'></form></li>
					</div>
					<div class="col-2">
					</div>
				</ul>
			</div>
			<div class="navBar">
				<ul>
					<div class="col-2">
						<li><form action="sort_by_color.php" method="post"><input type='submit' name='submit' value='Black'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_color.php" method="post"><input type='submit' name='submit' value='White'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_color.php" method="post"><input type='submit' name='submit' value='Grey'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_color.php" method="post"><input type='submit' name='submit' value='Red'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_color.php" method="post"><input type='submit' name='submit' value='Blue'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_color.php" method="post"><input type='submit' name='submit' value='Silver'></form></li>
					</div>
				</ul>
			</div>
			<div class="navBar">
				<ul>
					<div class="col-2">
					</div>
					<div class="col-2">
					</div>
					<div class="col-2">
						<li><form action="sort_by_condition.php" method="post"><input type='submit' name='submit' value='New'></form></li>
					</div>
					<div class="col-2">
						<li><form action="sort_by_condition.php" method="post"><input type='submit' name='submit' value='Used'></form></li>
					</div>
					<div class="col-2">
					</div>
					<div class="col-2">
					</div>
				</ul>
			</div>	
		</div>
		<center><img src="https://static.giantbomb.com/uploads/original/12/129913/2335126-2012_09_18_00012.jpg"></center>
		<?php echo $html;?>
	</body>
</html>

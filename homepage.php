<?php
	session_start();
	if ($_SESSION['logged_on_user'] === NULL)
	{
		$topNav = "<li><a href='login.php'><b>Log-in</b></a></li>"
			."<li><a href='register.php'><b>Sign-Up!</b></a></li>";
	}
	else
	{
		$topNav	= "<form action='homepage.php' method='post'><input type='submit' name='submit' value='Log-out'></form>"
			."<li><a href='modify.php'><b>Change Password</b></a></li>";
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
				rewind($basket_db);
				$match = FALSE;
				echo "USER "
					.$basket_item[0]
					."<br>";
				$basket_item[0] = $_SESSION['logged_on_user'];
				while (($basket = fgetcsv($basket_db)) !== FALSE)
				{
					echo "CSV UID "
						.$basket[0]
						."<br>";
					if ($basket[0] == $_SESSION['logged_on_user'])
					{
						echo "DID "
							.$basket[1]
							."SID "
							.$basket_item[1]
							.
							"<br>";
						if ($basket[1] == $basket_item[1])
						{
							echo "Matched<br>";
							$basket_item[4] += $basket[4];
							$contents = file_get_contents("database/basket.csv");
							// print_r($basket);
							// echo "Contents"
							// 	.$contents;
							$contents = str_replace(implode(",", $basket)."\n", NULL, $contents);
							file_put_contents("database/basket.csv", $contents);
							fputcsv($basket_db, $basket_item);
							$match = TRUE;
							break;
						}
					}
				}
				if ($match === FALSE)
					fputcsv($basket_db, $basket_item);
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
	</body>
</html>

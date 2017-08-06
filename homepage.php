<?php
	if ($_POST['order1'] == 'Order')
		echo "It worked";
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
							<li><a href="login.php"><b>Log-in</b></a></li>
							<li><a href="logout.php"><b>Log-out</b></a></li>
							<li><a href="admin.php"><b>Admin</b></a></li>
							<li><a href="whoami.php"><b>Check login</b></a></li>
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
						<li>Car</li>
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
					<input type="submit" name="order1" value="Order">
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

<?php

session_start();
$item_db = fopen("database/item_db.csv", r);
$arr = array();
$i = 0;
while ($item = fgetcsv($item_db))
{
	if ($item[5] === $_POST['submit'])
	{
		$arr[$i] = $item;
		$i++;
	}
}
$count = $i;
$i = 0;
while ($i < $count)
{
	$desc = $arr[$i][3]." ".$arr[$i][1]." ".$arr[$i][2]." ".$arr[$i][5]." for: $".$arr[$i][7];
	$img = $arr[$i][8];
	$html[$i] = "<div class='row'><div class='jumbotron col-12'><p>$desc</p><img src='$img'><form action='basket.php' method='post'><input type='submit' name='order1' value='Order'></form></div></div>";
	$i++;
}

?>












<?php

if ($_POST['submit'] === "Log-out")
{
	if ($_SESSION['logged_on_user'] === NULL)
		echo "Error:\nNot logged in!";
	else
	{
		$_SESSION['logged_on_user'] = NULL;
		$_SESSION['admin'] = NULL;
		echo "Logout successful!";
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
							<li><a href="admin.php"><b>Admin</b></a></li>
							<form action="homepage.php" method="post"><input type='submit' name='submit' value='Log-out'></form>
							<form action="homepage.php" method="post"><input type='submit' name='submit' value='Check User'></form>
						</ul>
					</div>
				</div>
		</div>
		<div class="content">
			<div class="row">
			<?php
			foreach ($html as $val)
				echo $val;
			?>
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

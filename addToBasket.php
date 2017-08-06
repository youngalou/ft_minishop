<?php
	session_start();
	if ($_POST['order1'] == 'Order')
	{
		$user = ($_SESSION['logged_on_user']) ? $_SESSION['logged_on_user'] : "anonhuman";
		$order1 = array($user, 02, "Charger", 17000, 1);
		if (!$_SESSION['basket'])
			$_SESSION['basket'] = array();
		array_push($_SESSION['basket'], $order1);
		header('Location: homepage.php');
	}
?>
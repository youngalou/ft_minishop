<?php
	session_start();
		foreach ($_SESSION['basket'] as $key => $basket_item) {
			if ($_POST[(string)$basket_item[1]] == 'Remove Item')
			{
				$_SESSION['basket'][$key][4] -= 1;
			}

		}
			header('Location: basket.php');	
?>
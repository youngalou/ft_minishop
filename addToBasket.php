<?php
	session_start();
	$item_db = fopen("database/item_db.csv", 'r');
	while (($item = fgetcsv($item_db)) !== FALSE)
	{
		if ($_POST[(string)$item[0]] == 'Order')
		{
 			$user = ($_SESSION['logged_on_user']) ? $_SESSION['logged_on_user'] : "anonhuman";
			$order = array($user, $item[0], $item[2], $item[7], 1);
			if (!$_SESSION['basket'])
				$_SESSION['basket'] = array();
			$match = FALSE;
			foreach ($_SESSION['basket'] as $key => $basket_item) {
				if ($basket_item[1] == $order[1])
				{
					$_SESSION['basket'][$key][4] += $order[4];
					$match = TRUE;
					break;
				}
			}
			if ($match === FALSE)
				array_push($_SESSION['basket'], $order);
			header('Location: '.$_SERVER['HTTP_REFERER']);
		}
	}
	
?>

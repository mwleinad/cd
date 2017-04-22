<?php
	
	$plan = $_GET['plan'];
	$smarty->assign("plan", $plan);
	
	$productos = $main->ListProductos();
	$smarty->assign("productos", $productos);
	
	$socios = $main->ListSocios();
	$smarty->assign("socios", $socios);

?>
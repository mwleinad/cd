<?php

$productos = $main->ListProductos();
$smarty->assign("productos", $productos);

$socios = $main->ListSocios();
$smarty->assign("socios", $socios);

?>
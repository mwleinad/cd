<?php
//echo "<pre>";print_r($_SESSION); exit;
$impuestos->SetPage($_GET["p"]);
$resVentas = $impuestos->Enumerate();

$smarty->assign("resVentas", $resVentas);
?>
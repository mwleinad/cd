<?php
//echo "<pre>";print_r($_SESSION); exit;
$ventas->SetPage($_GET["p"]);
$resVentas = $ventas->Enumerate();

$smarty->assign("resVentas", $resVentas);
?>
<?php
//echo "<pre>";print_r($_SESSION); exit;
$nominas->SetPage($_GET["p"]);
$resVentas = $nominas->Enumerate();

$smarty->assign("resVentas", $resVentas);
?>
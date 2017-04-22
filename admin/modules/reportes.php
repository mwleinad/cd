<?php

$ventas->SetPage($_GET["p"]);
$resVentas = $ventas->Enumerate();
$smarty->assign("resVentas", $resVentas);
?>
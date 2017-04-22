<?php

$reporte->SetPage($_GET["p"]);
$resReporte = $reporte->Division();
$smarty->assign("resReporte", $resReporte);
?>
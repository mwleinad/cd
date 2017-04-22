<?php

$reporte->SetPage($_GET["p"]);
$resReporte = $reporte->Enumerate();
$smarty->assign("resReporte", $resReporte);
?>
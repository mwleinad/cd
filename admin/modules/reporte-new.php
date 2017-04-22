<?php

$reporte->SetPage($_GET["p"]);
$resReporte = $reporte->NewReport();
$smarty->assign("resReporte", $resReporte);
?>
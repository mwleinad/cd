<?php
$cliente->AuthCliente();

$rfcId = $rfc->getRfcActive();
$rfc->setRfcId($rfcId);
$nodoEmisorRfc = $rfc->InfoRfc();

$smarty->assign("nodoEmisorRfc", $nodoEmisorRfc);		
?>
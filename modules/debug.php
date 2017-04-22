<?php
	
	include_once('../init.php');
	include_once('../config.php');
	include_once(DOC_ROOT.'/libraries.php');
		
	$comprobanteId = 3449;
	exit;
	$sql = 'SELECT timbreFiscal FROM comprobante WHERE comprobanteId = '.$comprobanteId;
	$util->DBSelect($_SESSION["empresaId"])->setQuery($sql);
	$timbreFiscal = $util->DBSelect($_SESSION["empresaId"])->GetSingle();
	
	$timbreFiscal = unserialize($timbreFiscal);
	echo $uuid = $timbreFiscal["UUID"];
	exit;
	exit;
	$motivo_cancelacion = 'Folios Duplicados';

	$date = date("Y-m-d");
	$sql = 'UPDATE comprobante SET motivoCancelacion = "'.$motivo_cancelacion.'", status = "0", fechaPedimento = "'.$date.'" WHERE comprobanteId = '.$comprobanteId;
	$util->DBSelect($_SESSION["empresaId"])->setQuery($sql);		
	$util->DBSelect($_SESSION["empresaId"])->UpdateData();
	
	$sql = 'SELECT data, conceptos, userId FROM comprobante WHERE comprobanteId = '.$comprobanteId;
	$util->DBSelect($_SESSION["empresaId"])->setQuery($sql);		
	$row = $util->DBSelect($_SESSION["empresaId"])->GetRow();
	
	$data = unserialize(urldecode($row['data']));
	$conceptos = unserialize(urldecode($row['conceptos']));
	
	$_SESSION["conceptos"] = array();
	$_SESSION["conceptos"] = $conceptos;
		
	$comprobante->CancelarComprobanteUUID($data, $comprobanteId, false, $row["userId"], $uuid);
	
	echo $comprobanteId;
	echo '<br>';
	echo $uuid;
	echo '<br>';
	echo 'CANCELADO';
	
	exit;
	
?>
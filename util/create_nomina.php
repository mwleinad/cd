<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa ORDER BY empresaId ASC");
$result = $db->GetResult();

foreach($result as $key => $res)
{
	if($res["empresaId"] == 22 || $res["empresaId"] == 25)
	{
		continue;
	}
	$util->DBSelect($res["empresaId"])->setQuery(
	"REPLACE INTO confactura_".$res["empresaId"].".tiposComprobante (
		`tiposComprobanteId` ,
		`nombre` ,
		`tipoDeComprobante`
		)
		VALUES (
		'8',  
		'Recibo De Nomina',  
		'egreso')"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();



}

?>
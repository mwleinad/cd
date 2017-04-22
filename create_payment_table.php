<?php

include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa ORDER BY empresaId ASC");
$result = $db->GetResult();

foreach($result as $key => $res)
{
	if($res["empresaId"] == 15)
	{
		continue;
	}
	
	$util->DBSelect($res["empresaId"])->setQuery("
		UPDATE confactura_".$res["empresaId"].".tiposComprobante SET tipoDeComprobante = 'egreso' WHERE nombre = 'Nota de Credito';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();


}

?>
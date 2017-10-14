<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa");

$result = $db->GetResult();
echo "test";
foreach($result as $key => $res)
{
	$util->DBSelect($res["empresaId"])->setQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'pascacio_".$res["empresaId"]."' AND TABLE_NAME = 'rfc';");
	$columns = $util->DBSelect($res["empresaId"])->GetResult();
	$hasCurp = false;
	foreach($columns as $column)
	{
		if($column["COLUMN_NAME"] == 'curp')
		{
			echo "hascurp";
			$hasCurp = true;
		}
	}

	if(!$hasCurp)
	{
		echo "jere";
		$util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE  `rfc` ADD  `curp` VARCHAR( 255 ) ;");
		$util->DBSelect($res["empresaId"])->executeQuery();
		$util->DBSelect($res["empresaId"])->CleanQuery();
	}
}

?>
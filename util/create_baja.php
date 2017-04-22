<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa ORDER BY empresaId ASC");
echo $db->query;
$result = $db->GetResult();

foreach($result as $key => $res)
{
	print_r($res);
	if($res["empresaId"] == 15)
	{
//		continue;
	}
	
	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `cliente` ADD  `baja` enum('0','1') NOT NULL DEFAULT '0';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();

	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `producto` ADD  `baja` enum('0','1') NOT NULL DEFAULT '0';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();

	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `rfc` ADD `iva` int(11) NOT NULL;"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();
	
	$util->DBSelect($res["empresaId"])->CleanQuery();



	

}

?>
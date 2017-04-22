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
		ALTER TABLE  `cliente` ADD `ciudad` varchar(255) NOT NULL;"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();
	
	$util->DBSelect($res["empresaId"])->CleanQuery();



	

}

?>
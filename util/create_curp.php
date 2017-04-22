<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa WHERE empresaId > 1223");

$result = $db->GetResult();

foreach($result as $key => $res)
{
	
	$util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE  `rfc` ADD  `curp` VARCHAR( 255 ) ;");
	$util->DBSelect($res["empresaId"])->executeQuery();
	$util->DBSelect($res["empresaId"])->CleanQuery();

}

?>
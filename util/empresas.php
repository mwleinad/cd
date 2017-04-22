<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa");
$result = $db->GetResult();

echo "<pre>";

foreach($result as $res)
{
	echo $res["empresaId"];
	echo "<br>";
}
//print_r($result);
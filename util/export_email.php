<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT emailPer, nombrePer FROM empresa 
ORDER BY empresaId ASC");
$result = $db->GetResult();

$count = 0;
foreach($result as $key => $res)
{
	if(!$res["emailPer"])
	{
		continue;
	}
	$count++;
	$cadena .= $res["emailPer"].",".$res["nombrePer"];
	$cadena .= "<br>";

}
echo $count;
echo "<br>";
echo $cadena;
?>
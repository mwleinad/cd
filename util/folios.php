<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId, version FROM empresa ORDER BY empresaId ASC");
$result = $db->GetResult();

$total = 0;
$month = $_GET["month"];
$year = $_GET["year"];

foreach($result as $key => $res)
{
	if($res["empresaId"] == 15 || $res["version"] == "auto" || $res["version"] == "2")
	{
		unset($result[$key]);
		continue;
	}
	
	$util->DBSelect($res["empresaId"])->setQuery("SELECT COUNT(*) FROM ".DB_PREFIX.$res["empresaId"].".comprobante WHERE MONTH(fecha) = ".$month." && YEAR(fecha) = ".$year." AND empresaId = ".$res["empresaId"]." LIMIT 1");			
	$result[$key]["expedidos"] = $util->DBSelect($res["empresaId"])->GetSingle();

	$util->DBSelect($res["empresaId"])->setQuery("SELECT COUNT(*) FROM ".DB_PREFIX.$res["empresaId"].".comprobante WHERE MONTH(fecha) = ".$month." && YEAR(fecha) = ".$year." AND empresaId = ".$res["empresaId"]." AND status = '0' LIMIT 1");			
	$result[$key]["cancelaciones"] = $util->DBSelect($res["empresaId"])->GetSingle();

	$total += $result[$key]["expedidos"] + $result[$key]["cancelaciones"];
	$result[$key]["expedidos"] = $result[$key]["expedidos"] + $result[$key]["cancelaciones"];
	$util->DBSelect($res["empresaId"])->setQuery("SELECT * FROM ".DB_PREFIX.$res["empresaId"].".rfc LIMIT 1");
	$rfc = $util->DBSelect($res["empresaId"])->GetRow();
	$result[$key]["rfc"] = $rfc["rfc"];
	$result[$key]["razonSocial"] = urldecode($rfc["razonSocial"]);
	
	if($result[$key]["expedidos"] == 0)
	{
		unset($result[$key]);
		continue;
	}

}
echo $total;
//print_r($result);


?>
<table width="600" border="1">
<?php foreach($result as $res){ ?>
<tr>
	<td width="100"><?php echo $res["empresaId"]  ?></td>
	<td width="100"><?php echo $res["rfc"]  ?></td>
	<td width="200"><?php echo $res["razonSocial"]  ?></td>
	<td width="100"><?php echo $res["expedidos"]  ?></td>
</tr>
<?php } ?>
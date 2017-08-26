<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa");

$result = $db->GetResult();
echo "test";
foreach($result as $key => $res)
{
        $util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE  `payment` ADD  `comprobantePagoId` INT( 11 ) ;");
        $util->DBSelect($res["empresaId"])->executeQuery();
        $util->DBSelect($res["empresaId"])->CleanQuery();
}

?>
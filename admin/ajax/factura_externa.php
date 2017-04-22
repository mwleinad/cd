<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

session_start();
switch($_POST["type"])
{
    case 'filtro_busqueda':
		$ptoyecto = array();
		$sqlHost = 'localhost';
		$sqlDB = 'ilusion_15';
		$sqlUser = 'da_admin';
		$sqlPass = 'lacimadel2000';
		//$db = new DB;
		$db->setSqlHost($sqlHost);
		$db->setSqlDatabase($sqlDB);
		$db->setSqlUser($sqlUser);
		$db->setSqlPassword($sqlPass);
		$db->setQuery("SELECT COUNT(*) FROM comprobante");
		
		$numFact = $db->GetSingle();
		$proyecto[0]['nombre'] = "Vickyform";
		$proyecto[0]['numero_comprobantes'] = $numFact;
		
		$proyecto = $util->DecodeResult($proyecto);
	
	echo "ok|";
		$smarty->assign("proyecto",$proyecto);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT."/templates/lists/factura_externa.tpl");
	   
	break;						
}
?>
<?php

include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

$pages = array(
	'homepage',
	'simulador',
	'config',
	'contacto',
	'ordenes',
	'orden',
	'ventas',
	'contacto_lista',
	'reporte',
	'usuario',
	'comisionista',
	'paqFolios',
	'factura_externa',
	'ordenesSimple',
	'nominas',
	'impuestos',
	'reporte-new',
	'division',
);
if(!in_array($_GET['page'], $pages))
{
	$_GET['page'] = "homepage";
}
//print_r($_GET);
include_once(DOC_ROOT.'/modules/user.php');
include_once(DOC_ROOT.'/modules/'.$_GET['page'].'.php');



$smarty->assign('page', $_GET['page']);
$smarty->assign('section', $_GET['section']);

$includedTpl =  $_GET['page'];
if($_GET['section'])
{
	$includedTpl =  $_GET['page']."_".$_GET['section'];
}
$smarty->assign('includedTpl', $includedTpl);

$smarty->assign('lang', $lang);
$smarty->display(DOC_ROOT.'/templates/index.tpl');

?>
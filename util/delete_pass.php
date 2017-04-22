<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa WHERE empresaId = 1000");
$result = $db->GetResult();

foreach($result as $key => $res)
{
	$util->DBSelect($res["empresaId"])->setQuery("DROP TABLE impuestos");
	$util->DBSelect($res["empresaId"])->executeQuery();

	$util->DBSelect($res["empresaId"])->setQuery("DROP TABLE nominas");
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	$util->DBSelect($res["empresaId"])->setQuery("CREATE TABLE IF NOT EXISTS `conceptoCompra` (
		`compraId` int(11) NOT NULL,
		`cantidad` float(20,2) NOT NULL,
		`unidad` varchar(255) DEFAULT NULL,
		`noIdentificacion` varchar(255) DEFAULT NULL,
		`descripcion` text NOT NULL,
		`valorUnitario` float(20,2) NOT NULL,
		`excentoIva` enum('no','si') NOT NULL DEFAULT 'no',
		`importe` float(20,2) NOT NULL,
		`userId` int(11) NOT NULL,
		`empresaId` int(11) NOT NULL,
		`conceptoId` int(11) NOT NULL AUTO_INCREMENT,
		`notaVentaId` int(11) NOT NULL,
		PRIMARY KEY (`conceptoId`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
	");
	
	$util->DBSelect($res["empresaId"])->executeQuery();	
	
	$util->DBSelect($res["empresaId"])->CleanQuery();

}

?>
<?php

include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

/*$empresas = array(63, 697, 276, 93,153,174,187,190,203,258,259,301,312,82,171,175,222,237,250,252,254,
255,256,257,262,263,264,265,279,280,284,285,286,288,290,291,292,298,304,305,310,314,318,321,324,326,327,330,331,333,336,337,
338,339,340,341,342,347,349,350,352,365,366,367,369,376,379,380,381,382,389,397,400,406,411,414,416,422,423,427,428,429,433,435,
437,438,440,441,443,445,446,449,450,452,455,457,458,460,463,464,466,467,468,469,472,474,478,484,485,489,499,501,502,504,507,512,
517,519,520,521,523,526,527,528,531,533,537,540,545,546,548,549,550,555,560,561,562,563,564,565,567,568,571,572,575,576,577,578,
579,581,582,583,584,585,590,593,596,597,598,599,600,604,605,607,609,610,611,618,619,621,622,637,638,639,643,646,649,650,651,652,
658,665,666,667,673,674,675,677,678,679,683,686,687,689,690,695,699,701,702);
*/

$empresas = array(315,316);
$implode = implode(",", $empresas);

$db->setQuery("SELECT empresaId FROM empresa WHERE empresaId IN (".$implode.")");

$result = $db->GetResult();

foreach($result as $key => $res)
{
	
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
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;
	");
	
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	$util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE  `producto` ADD  `disponible` FLOAT( 20, 2 ) NOT NULL DEFAULT  '0';");
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	$util->DBSelect($res["empresaId"])->setQuery("CREATE TABLE IF NOT EXISTS `compra` (
		`compraId` int(11) NOT NULL AUTO_INCREMENT,
		`uuid` varchar(255) NOT NULL,
		`subtotal` float(20,2) NOT NULL,
		`descuento` float(20,2) NOT NULL,
		`iva` float(20,2) NOT NULL,
		`total` float(20,2) NOT NULL,
		`tasaIva` float(20,2) NOT NULL,
		`serie` varchar(255) NOT NULL,
		`folio` varchar(255) NOT NULL,
		`fecha` datetime NOT NULL,
		`tipoDeComprobante` varchar(255) NOT NULL,
		`retIva` float(20,2) NOT NULL,
		`retIsr` float(20,2) NOT NULL,
		`ieps` float(20,2) NOT NULL,
		`rfc` varchar(255) NOT NULL,
		PRIMARY KEY (`compraId`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;");
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	
	
	$util->DBSelect($res["empresaId"])->setQuery("CREATE TABLE IF NOT EXISTS `paymentCompra` (
		`paymentId` int(11) NOT NULL AUTO_INCREMENT,
		`compraId` int(11) NOT NULL,
		`amount` float(20,6) NOT NULL,
		`paymentDate` date NOT NULL,
		PRIMARY KEY (`paymentId`)
	) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33;");
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	$util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE  `producto` ADD  `precioCompra` FLOAT( 20, 2 ) NOT NULL DEFAULT  '0';");
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	$util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE  `cliente` ADD  `emailAdmin` VARCHAR( 255 ) NOT NULL ,
	ADD  `emailDirector` VARCHAR( 255 ) NOT NULL ;");
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	$util->DBSelect($res["empresaId"])->setQuery("ALTER TABLE  `payment` ADD  `metodoPago` VARCHAR( 255 ) NOT NULL ,
	ADD  `fecha` DATE NOT NULL ;");
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	
	$util->DBSelect($res["empresaId"])->setQuery("CREATE TABLE IF NOT EXISTS `proveedor` (
		`proveedorId` int(11) NOT NULL AUTO_INCREMENT,
		`rfc` varchar(255) NOT NULL,
		`razonSocial` varchar(255) NOT NULL,
		PRIMARY KEY (`proveedorId`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;");
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->executeQuery();
	
	
	$util->DBSelect($res["empresaId"])->CleanQuery();

}

?>
<?php

include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

$db->setQuery("SELECT empresaId FROM empresa ORDER BY empresaId ASC");
$result = $db->GetResult();

foreach($result as $key => $res)
{
	if($res["empresaId"] == 15)
	{
		continue;
	}
	
	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `cliente` ADD  `version` VARCHAR( 255 ) NOT NULL DEFAULT  'construc';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();

	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `concepto` ADD  `notaVentaId` INT( 11 ) NOT NULL DEFAULT  '0';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();
	

	$util->DBSelect($res["empresaId"])->setQuery("
		CREATE TABLE IF NOT EXISTS  `notaVenta` (
 `notaVentaId` INT( 11 ) NOT NULL AUTO_INCREMENT ,
 `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
 `usuarioId` INT( 11 ) NOT NULL ,
 `sucursalId` INT( 11 ) NOT NULL ,
 `formaDePago` VARCHAR( 255 ) NOT NULL ,
 `subtotal` FLOAT NOT NULL ,
 `iva` FLOAT NOT NULL ,
 `total` FLOAT NOT NULL ,
 `status` ENUM(  '1',  '0' ) NOT NULL DEFAULT  '1',
 `facturado` ENUM(  '0',  '1' ) NOT NULL DEFAULT  '0',
 `comprobanteId` INT( 11 ) NOT NULL ,
PRIMARY KEY (  `notaVentaId` )
) ENGINE = MYISAM DEFAULT CHARSET = latin1 AUTO_INCREMENT =1;"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();
	
	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `payment` ADD  `notaVentaId` INT( 11 ) NOT NULL DEFAULT  '0';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();

	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `rfc` ADD  `permisoFacturar` ENUM(  'Si',  'No' ) NOT NULL DEFAULT  'No',
ADD  `diasFacturar` INT( 2 ) NOT NULL DEFAULT  '0';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();

	$util->DBSelect($res["empresaId"])->setQuery("
		ALTER TABLE  `serie` ADD  `sucursalAsignada` INT( 11 ) NOT NULL DEFAULT  '0';"
	);
	echo $util->DBSelect($res["empresaId"])->query;
	$util->DBSelect($res["empresaId"])->ExecuteQuery();
	
	

	

}

?>
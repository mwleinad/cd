<?php

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `certificado` (
  `certificadoId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `noCertificado` varchar(255) NOT NULL,
  PRIMARY KEY  (`certificadoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `impuesto` (
  `impuestoId` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `tasa` float(20,6) NOT NULL,
  `tipo` enum('impuesto','retencion','deduccion','amortizacion') NOT NULL,
  `iva` float(20,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`impuestoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `payment` (
  `paymentId` int(11) NOT NULL AUTO_INCREMENT,
  `comprobanteId` int(11) NOT NULL,
  `amount` float(20,6) NOT NULL,
  `paymentDate` date NOT NULL,
  `notaVentaId` int(11) NOT NULL,
  `comprobantePagoId` int(11) NOT NULL,
  PRIMARY KEY (`paymentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();
		
$newDb->setQuery("CREATE TABLE IF NOT EXISTS `cliente` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `empresaId` int(11) NOT NULL,
  `rfcId` int(11) NOT NULL,
  `rfc` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `noExt` varchar(255) DEFAULT NULL,
  `noInt` varchar(255) DEFAULT NULL,
  `colonia` varchar(255) DEFAULT NULL,
  `municipio` varchar(255) DEFAULT NULL,
  `ciudad` varchar(255) NOT NULL,
  `cp` varchar(5) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  `localidad` varchar(255) DEFAULT NULL,
  `referencia` varchar(255) DEFAULT NULL,
  `pais` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL DEFAULT 'construc',
  `baja` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `complementoConcepto` (
  `complementoConceptoId` int(11) NOT NULL auto_increment,
  `conceptoId` int(11) NOT NULL,
  `any` text NOT NULL,
  PRIMARY KEY  (`complementoConceptoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `complementoConceptoParte` (
  `complementoConceptoParteId` int(11) NOT NULL auto_increment,
  `conceptoId` int(11) NOT NULL,
  `any` text NOT NULL,
  PRIMARY KEY  (`complementoConceptoParteId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `comprobante` (
  `comprobanteId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `formaDePago` varchar(255) NOT NULL DEFAULT 'Pago En Una Sola Exhibicion',
  `condicionesDePago` varchar(255) NOT NULL,
  `metodoDePago` varchar(255) NOT NULL,
  `tasaIva` enum('16','11','0','1') NOT NULL DEFAULT '16',
  `tipoDeMoneda` enum('peso','dolar','euro') NOT NULL DEFAULT 'peso',
  `tipoDeCambio` float(20,2) NOT NULL DEFAULT '1.00',
  `porcentajeRetIva` enum('0','4','10','10.666666') NOT NULL DEFAULT '0',
  `porcentajeRetIsr` enum('0','10','10.666666') NOT NULL DEFAULT '0',
  `tiposComprobanteId` int(11) NOT NULL DEFAULT '1',
  `porcentajeIEPS` int(3) NOT NULL DEFAULT '0',
  `porcentajeDescuento` int(3) NOT NULL DEFAULT '0',
  `empresaId` int(11) NOT NULL,
  `sucursalId` int(11) NOT NULL,
  `observaciones` text,
  `version` varchar(10) NOT NULL DEFAULT '2.0',
  `serie` varchar(10) NOT NULL,
  `folio` bigint(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `sello` text NOT NULL,
  `noAprobacion` int(11) NOT NULL,
  `anoAprobacion` int(4) NOT NULL,
  `noCertificado` varchar(20) NOT NULL,
  `certificado` text,
  `subTotal` float(20,6) NOT NULL,
  `descuento` float(20,6) DEFAULT NULL,
  `motivoDescuento` text,
  `total` float(20,6) NOT NULL,
  `tipoDeComprobante` enum('ingreso','egreso','traslado') NOT NULL,
  `cadenaOriginal` text NOT NULL,
  `xml` text,
  `rfcId` int(11) NOT NULL DEFAULT '1',
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `ivaTotal` float(20,6) NOT NULL,
  `efectoComprobante` enum('I','E','T') NOT NULL DEFAULT 'I',
  `pedimento` varchar(300) DEFAULT NULL,
  `fechaPedimento` date DEFAULT NULL,
  `aduana` varchar(600) DEFAULT NULL,
  `data` text,
  `motivoCancelacion` text,
  `motivoNotaCredito` text,
  `conceptos` text,
  `impuestos` text,
  `timbreFiscal` text,
  PRIMARY KEY (`comprobanteId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `concepto` (
  `comprobanteId` int(11) NOT NULL,
  `cantidad` float(20,2) NOT NULL,
  `unidad` varchar(255) default NULL,
  `noIdentificacion` varchar(255) default NULL,
  `descripcion` text NOT NULL,
  `valorUnitario` float(20,2) NOT NULL,
  `excentoIva` enum('no','si') NOT NULL default 'no',
  `importe` float(20,2) NOT NULL,
  `userId` int(11) NOT NULL,
  `empresaId` int(11) NOT NULL,
  `conceptoId` int(11) NOT NULL auto_increment,
	`notaVentaId` int(11) NOT NULL,	
  PRIMARY KEY  (`conceptoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `cuentaPredialConcepto` (
  `conceptoId` int(11) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `cuentaPredialConceptoId` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`cuentaPredialConceptoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `cuentaPredialParte` (
  `conceptoId` int(11) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `cuentaPredialParteId` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`cuentaPredialParteId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();


$newDb->setQuery("CREATE TABLE IF NOT EXISTS `informacionAduaneraConcepto` (
  `conceptoId` int(11) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `aduana` varchar(255) NOT NULL,
  `informacionAduaneraConceptoId` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`informacionAduaneraConceptoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `informacionAduaneraParte` (
  `conceptoId` int(11) NOT NULL,
  `numero` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `aduana` varchar(255) NOT NULL,
  `informacionAduaneraParteId` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`informacionAduaneraParteId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `notaVenta` (
  `notaVentaId` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuarioId` int(11) NOT NULL,
  `sucursalId` int(11) NOT NULL,
  `formaDePago` varchar(255) NOT NULL,
  `subtotal` float NOT NULL,
  `iva` float NOT NULL,
  `total` float NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `facturado` enum('0','1') NOT NULL DEFAULT '0',
  `comprobanteId` int(11) NOT NULL,
  PRIMARY KEY (`notaVentaId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `parte` (
  `conceptoId` int(11) NOT NULL,
  `cantidad` float(20,2) NOT NULL,
  `unidad` varchar(255) default NULL,
  `noIdentificacion` varchar(255) default NULL,
  `descripcion` text NOT NULL,
  `valorUnitario` float(20,2) NOT NULL,
  `excentoIva` tinyint(1) NOT NULL default '0',
  `importe` float(20,2) NOT NULL,
  `userId` int(11) NOT NULL,
  `empresaId` int(11) NOT NULL,
  `parteId` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`parteId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `product` (
  `productId` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `price` float(15,2) NOT NULL,
  `description` text NOT NULL,
  `inventory` int(11) NOT NULL,
  `catId` int(11) NOT NULL,
  `created` date NOT NULL,
  `sold` int(11) NOT NULL,
  `updated` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `details` text,
  `discount` int(3) NOT NULL default '0',
  `type` enum('domain','facturas','mantenimiento') NOT NULL default 'domain',
  PRIMARY KEY  (`productId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `producto` (
  `productoId` int(11) NOT NULL AUTO_INCREMENT,
  `empresaId` int(11) NOT NULL,
  `noIdentificacion` varchar(255) NOT NULL,
  `unidad` varchar(255) NOT NULL,
  `valorUnitario` float(10,2) NOT NULL,
  `descripcion` text NOT NULL,
  `rfcId` int(11) NOT NULL,
  `descuento` float(10,6) NOT NULL,
  `tasaIva` float(10,6) NOT NULL,
  `medida` varchar(255) NOT NULL DEFAULT 'mts',
  `monto` float(20,6) NOT NULL DEFAULT '0.000000',
  `baja` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`productoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `serie` (
  `serieId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `sucursalId` int(11) NOT NULL,
  `serie` varchar(16) NOT NULL,
  `folioInicial` int(11) NOT NULL,
  `folioFinal` int(11) NOT NULL,
  `noAprobacion` varchar(255) NOT NULL,
  `anoAprobacion` int(11) NOT NULL,
  `tiposComprobanteId` int(11) NOT NULL,
  `lugarDeExpedicion` varchar(255) NOT NULL,
  `noCertificado` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `consecutivo` int(11) NOT NULL,
	`rfcId` int(11) NOT NULL,
  `sucursalAsignada` int(11) NOT NULL,
  PRIMARY KEY  (`serieId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `rfc` (
  `rfcId` int(11) NOT NULL AUTO_INCREMENT,
  `empresaId` int(11) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `curp` varchar(30) NOT NULL,
  `razonSocial` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `noExt` varchar(255) NOT NULL,
  `noInt` varchar(255) NOT NULL,
  `colonia` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `municipio` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `activo` enum('si','no') NOT NULL DEFAULT 'no',
  `main` enum('no','si') NOT NULL,
  `regimenFiscal` varchar(255) NOT NULL,
  `permisoFacturar` enum('Si','No') NOT NULL DEFAULT 'No',
  `diasFacturar` int(2) NOT NULL DEFAULT '0',
  `iva` int(11) NOT NULL,
  PRIMARY KEY (`rfcId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `sucursal` (
  `sucursalId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `rfcId` int(11) NOT NULL,
  `identificador` varchar(255) NOT NULL,
  `sucursalActiva` enum('no','si') NOT NULL default 'no',
  `razonSocial` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `noExt` varchar(255) NOT NULL,
  `noInt` varchar(255) NOT NULL,
  `colonia` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `municipio` varchar(255) NOT NULL,
  `ciudad` varchar(255) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cp` varchar(255) NOT NULL,
  PRIMARY KEY  (`sucursalId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `tiposComprobante` (
  `tiposComprobanteId` int(11) NOT NULL auto_increment,
  `nombre` varchar(255) NOT NULL,
  `tipoDeComprobante` enum('ingreso','egreso','traslado') NOT NULL default 'ingreso',
  PRIMARY KEY  (`tiposComprobanteId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;");
$newDb->executeQuery();

$newDb->setQuery("INSERT INTO `tiposComprobante` (`tiposComprobanteId`, `nombre`, `tipoDeComprobante`) VALUES
(1, 'Factura', 'ingreso'),
(2, 'Nota de Credito', 'egreso'),
(3, 'Nota de Debito', 'ingreso'),
(4, 'Honorarios', 'ingreso'),
(5, 'Arrendamiento', 'ingreso'),
(6, 'Cotizacion', 'ingreso'),
(7, 'Remision', 'ingreso'),
(8, 'Recibo De Nomina', 'egreso'),
(9, 'Recibo De Donacion', 'ingreso');");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `conceptoCompra` (
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

$newDb->executeQuery();

$newDb->setQuery("ALTER TABLE  `producto` ADD  `disponible` FLOAT( 20, 2 ) NOT NULL DEFAULT  '0';");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `compra` (
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
$newDb->executeQuery();



$newDb->setQuery("CREATE TABLE IF NOT EXISTS `paymentCompra` (
  `paymentId` int(11) NOT NULL AUTO_INCREMENT,
  `compraId` int(11) NOT NULL,
  `amount` float(20,6) NOT NULL,
  `paymentDate` date NOT NULL,
  PRIMARY KEY (`paymentId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33;");
$newDb->executeQuery();

$newDb->setQuery("ALTER TABLE  `producto` ADD  `precioCompra` FLOAT( 20, 2 ) NOT NULL DEFAULT  '0';");
$newDb->executeQuery();

$newDb->setQuery("ALTER TABLE  `cliente` ADD  `emailAdmin` VARCHAR( 255 ) NOT NULL ,
ADD  `emailDirector` VARCHAR( 255 ) NOT NULL ;");
$newDb->executeQuery();

$newDb->setQuery("ALTER TABLE  `payment` ADD  `metodoPago` VARCHAR( 255 ) NOT NULL ,
ADD  `fecha` DATE NOT NULL ;");
$newDb->executeQuery();


$newDb->setQuery("CREATE TABLE IF NOT EXISTS `proveedor` (
  `proveedorId` int(11) NOT NULL AUTO_INCREMENT,
  `rfc` varchar(255) NOT NULL,
  `razonSocial` varchar(255) NOT NULL,
  PRIMARY KEY (`proveedorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;");
$newDb->executeQuery();







?>
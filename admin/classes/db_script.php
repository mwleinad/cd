<?php

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `certificado` (
  `certificadoId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `noCertificado` varchar(255) NOT NULL,
  PRIMARY KEY  (`certificadoId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `cliente` (
  `userId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `rfcId` int(11) NOT NULL,
  `rfc` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `noExt` int(11) default NULL,
  `noInt` int(11) default NULL,
  `colonia` varchar(255) default NULL,
  `municipio` varchar(255) default NULL,
  `cp` int(5) default NULL,
  `estado` varchar(255) default NULL,
  `localidad` varchar(255) default NULL,
  `referencia` varchar(255) default NULL,
  `pais` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefono` varchar(255) default NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY  (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
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
  `comprobanteId` int(11) NOT NULL auto_increment,
  `userId` int(11) NOT NULL,
  `formaDePago` varchar(255) NOT NULL default 'Pago En Una Sola Exhibicion',
  `condicionesDePago` varchar(255) NOT NULL,
  `metodoDePago` varchar(255) NOT NULL,
  `tasaIva` enum('16','11','0','1') NOT NULL default '16',
  `tipoDeMoneda` enum('peso','dolar','euro') NOT NULL default 'peso',
  `tipoDeCambio` float(10,2) NOT NULL default '1.00',
  `porcentajeRetIva` enum('0','4','10','10.666666') NOT NULL default '0',
  `porcentajeRetIsr` enum('0','10','10.666666') NOT NULL default '0',
  `tiposComprobanteId` int(11) NOT NULL default '1',
  `porcentajeIEPS` int(3) NOT NULL default '0',
  `porcentajeDescuento` int(3) NOT NULL default '0',
  `empresaId` int(11) NOT NULL,
  `sucursalId` int(11) NOT NULL,
  `observaciones` text,
  `version` varchar(10) NOT NULL default '2.0',
  `serie` varchar(10) NOT NULL,
  `folio` bigint(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `sello` text NOT NULL,
  `noAprobacion` int(11) NOT NULL,
  `anoAprobacion` int(4) NOT NULL,
  `noCertificado` varchar(20) NOT NULL,
  `certificado` text,
  `subTotal` float(10,6) NOT NULL,
  `descuento` float(10,6) default NULL,
  `motivoDescuento` text,
  `total` float(10,6) NOT NULL,
  `tipoDeComprobante` enum('ingreso','egreso','traslado') NOT NULL,
  `cadenaOriginal` text NOT NULL,
  `xml` text,
  `rfcId` int(11) NOT NULL default '1',
  `status` enum('1','0') NOT NULL default '1',
  `ivaTotal` float(11,6) NOT NULL,
  `efectoComprobante` enum('I','E','T') NOT NULL default 'I',
  `pedimento` varchar(300) default NULL,
  `fechaPedimento` date default NULL,
  `aduana` varchar(600) default NULL,
  `data` text,
  `motivoCancelacion` text,
  `motivoNotaCredito` text,
  `conceptos` text,
  PRIMARY KEY  (`comprobanteId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `concepto` (
  `comprobanteId` int(11) NOT NULL,
  `cantidad` float(10,2) NOT NULL,
  `unidad` varchar(255) default NULL,
  `noIdentificacion` varchar(255) default NULL,
  `descripcion` text NOT NULL,
  `valorUnitario` float(10,2) NOT NULL,
  `excentoIva` enum('no','si') NOT NULL default 'no',
  `importe` float(10,2) NOT NULL,
  `userId` int(11) NOT NULL,
  `empresaId` int(11) NOT NULL,
  `conceptoId` int(11) NOT NULL auto_increment,
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

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `parte` (
  `conceptoId` int(11) NOT NULL,
  `cantidad` float(10,2) NOT NULL,
  `unidad` varchar(255) default NULL,
  `noIdentificacion` varchar(255) default NULL,
  `descripcion` text NOT NULL,
  `valorUnitario` float(10,2) NOT NULL,
  `excentoIva` tinyint(1) NOT NULL default '0',
  `importe` float(10,2) NOT NULL,
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
  `productoId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `noIdentificacion` varchar(255) NOT NULL,
  `unidad` varchar(255) NOT NULL,
  `valorUnitario` float(10,2) NOT NULL,
  `descripcion` text NOT NULL,
  `rfcId` int(11) NOT NULL,
  PRIMARY KEY  (`productoId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;");
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
  PRIMARY KEY  (`serieId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;");
$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `rfc` (
  `rfcId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `rfc` varchar(13) NOT NULL,
  `razonSocial` varchar(255) NOT NULL,
  `pais` varchar(255) NOT NULL,
  `calle` varchar(255) NOT NULL,
  `noExt` int(11) NOT NULL,
  `noInt` int(11) NOT NULL,
  `colonia` varchar(255) NOT NULL,
  `localidad` varchar(255) NOT NULL,
  `municipio` varchar(255) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL,
  `cp` int(5) NOT NULL,
  `activo` enum('si','no') NOT NULL default 'no',
  `main` enum('no','si') NOT NULL,
  PRIMARY KEY  (`rfcId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

$newDb->executeQuery();

$newDb->setQuery("CREATE TABLE IF NOT EXISTS `sucursal` (
  `sucursalId` int(11) NOT NULL auto_increment,
  `empresaId` int(11) NOT NULL,
  `rfcId` int(11) NOT NULL,
  `identificador` varchar(255) NOT NULL,
  `sucursalActiva` enum('no','si') NOT NULL default 'no',
  PRIMARY KEY  (`sucursalId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
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
(2, 'Nota de Credito', 'ingreso'),
(3, 'Nota de Debito', 'ingreso'),
(4, 'Honorarios', 'ingreso'),
(5, 'Arrendamiento', 'ingreso'),
(6, 'Cotizacion', 'ingreso'),
(7, 'Remision', 'ingreso');");
$newDb->executeQuery();








?>
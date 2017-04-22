<?php

/*
//language
include_once(DOC_ROOT."/api.abstract.class.php");
include_once(DOC_ROOT."/api.class.php");

$APIFacturacion = new APIFacturacion;
*/

include_once(DOC_ROOT."/libs/qr/qrlib.php");

include_once(DOC_ROOT."/classes/db.class.php");
include_once(DOC_ROOT."/classes/error.class.php");
include_once(DOC_ROOT."/classes/util.class.php");
include_once(DOC_ROOT."/classes/main.class.php");
include_once(DOC_ROOT."/classes/empresa.class.php");
include_once(DOC_ROOT."/classes/rfc.class.php");
include_once(DOC_ROOT."/classes/sucursal.class.php");
include_once(DOC_ROOT."/classes/producto.class.php");
include_once(DOC_ROOT."/classes/comprobante.class.php");
include_once(DOC_ROOT."/classes/comprobante_API.class.php");
include_once(DOC_ROOT."/classes/vista_previa_API.class.php");

include_once(DOC_ROOT."/classes/impuesto.class.php");
include_once(DOC_ROOT."/classes/user.class.php");
include_once(DOC_ROOT."/classes/folios.class.php");
include_once(DOC_ROOT."/classes/usuario.class.php");
include_once(DOC_ROOT.'/classes/class.phpmailer.php');
include_once(DOC_ROOT.'/classes/class.smtp.php');
include_once(DOC_ROOT."/classes/pac.class.php");
include_once(DOC_ROOT."/classes/CNumeroaLetra.class.php");


$db = new DB;
$error = new Error;
$util = new Util;
$main = new Main;
$empresa = new Empresa;
$rfc = new Rfc;
$comprobante = new ComprobanteAPI;
$vistaPrevia = new VistaPrevia;
$sucursal = new Sucursal;
$producto = new Producto;
$impuesto = new Impuesto;
$user = new User;
$folios = new Folios;


?>
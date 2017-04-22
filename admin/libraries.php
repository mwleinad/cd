<?php

//language
if(!$_SESSION['lang'])
{
	include_once(DOC_ROOT."/properties/language.es.php");
	include_once(DOC_ROOT."/properties/errors.es.php");
}
elseif($_SESSION['lang'] == "es")
{
	include_once(DOC_ROOT."/properties/language.es.php");
	include_once(DOC_ROOT."/properties/errors.es.php");
}
else
{
	include_once(DOC_ROOT."/properties/language.en.php");
	include_once(DOC_ROOT."/properties/errors.es.php");
}

include_once(DOC_ROOT."/constants.php");
include_once(DOC_ROOT."/properties/config.php");
require(DOC_ROOT.'/libs/Smarty.class.php');

include_once(DOC_ROOT."/classes/db.class.php");
include_once(DOC_ROOT."/classes/error.class.php");
include_once(DOC_ROOT."/classes/util.class.php");


include_once(DOC_ROOT."/classes/main.class.php");
include_once(DOC_ROOT."/classes/user.class.php");
include_once(DOC_ROOT."/classes/usuario.class.php");
include_once(DOC_ROOT."/classes/ordenes.class.php");
include_once(DOC_ROOT."/classes/orden.class.php");
include_once(DOC_ROOT."/classes/ventas.class.php");
include_once(DOC_ROOT."/classes/vencimiento.class.php");
include_once(DOC_ROOT."/classes/nominas.class.php");
include_once(DOC_ROOT."/classes/impuestos.class.php");

include_once(DOC_ROOT."/classes/simulador.class.php");
include_once(DOC_ROOT."/classes/config.class.php");
include_once(DOC_ROOT."/classes/contacto.class.php");
include_once(DOC_ROOT."/classes/reporte.class.php");
include_once(DOC_ROOT."/classes/comisionista.class.php");
include_once(DOC_ROOT."/classes/paqFolios.class.php");
include_once(DOC_ROOT."/classes/compraFolios.class.php");

include_once(DOC_ROOT.'/classes/class.phpmailer.php');
include_once(DOC_ROOT.'/classes/class.smtp.php');
include_once(DOC_ROOT.'/classes/sendmail.class.php');

$db = new DB;
$error = new Error;
$util = new Util;

$main = new Main;

$usuario = new Usuario;
$ordenes = new Ordenes;
$orden = new Orden;
$ventas = new Ventas;
$nominas = new Nominas;
$impuestos = new Impuestos;
$vencimiento = new Vencimiento;
$user = new User;

$simulador = new Simulador;
$config = new Config;
$contacto = new Contacto;
$reporte = new Reporte;
$comisionista = new Comisionista;
$paqs = new PaqFolios;
$compra = new CompraFolios;

$smarty = new Smarty;

$mail = new PHPMailer(true);
$sendMail = new SendMail();

$util->wwwRedirect();

$smarty->assign('DOC_ROOT',DOC_ROOT);
$smarty->assign('WEB_ROOT',WEB_ROOT);

$smarty->assign('property', $property);

$lang = $util->ReturnLang();
?>
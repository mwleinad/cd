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
require(DOC_ROOT.'/libs/nusoap.php');
include_once(DOC_ROOT."/libs/qr/qrlib.php");

require(DOC_ROOT.'/classes/json.class.php');

include_once(DOC_ROOT."/classes/db.class.php");
include_once(DOC_ROOT."/classes/error.class.php");
include_once(DOC_ROOT."/classes/util.class.php");


include_once(DOC_ROOT."/classes/main.class.php");
include_once(DOC_ROOT."/classes/empresa.class.php");
include_once(DOC_ROOT."/classes/rfc.class.php");
include_once(DOC_ROOT."/classes/sucursal.class.php");
include_once(DOC_ROOT."/classes/cliente.class.php");
include_once(DOC_ROOT."/classes/producto.class.php");

		switch($_SESSION["version"])
		{
			default: 
				include_once(DOC_ROOT."/classes/comprobante.class.php");
				include_once(DOC_ROOT."/classes/comprobante_forma.class.php");
				include_once(DOC_ROOT."/classes/comprobante_cliente.class.php");
				include_once(DOC_ROOT."/classes/vista_previa.class.php");
				break;
		}
include_once(DOC_ROOT."/classes/complemento_nomina_12.class.php");

include_once(DOC_ROOT."/classes/impuesto.class.php");
include_once(DOC_ROOT."/classes/user.class.php");
include_once(DOC_ROOT."/classes/folios.class.php");
include_once(DOC_ROOT."/classes/usuario.class.php");
include_once(DOC_ROOT."/classes/reporte.class.php");
include_once(DOC_ROOT.'/classes/class.phpmailer.php');
include_once(DOC_ROOT.'/classes/class.smtp.php');
include_once(DOC_ROOT.'/classes/sendmail.class.php');
include_once(DOC_ROOT."/classes/pac.class.php");
include_once(DOC_ROOT."/classes/pacold.class.php");
include_once(DOC_ROOT."/classes/CNumeroaLetra.class.php");

include_once(DOC_ROOT."/classes/payment.class.php");
include_once(DOC_ROOT."/classes/venta.class.php");

include_once(DOC_ROOT."/classes/nomina.class.php");
include_once(DOC_ROOT."/classes/xmlTransform.class.php");
include_once(DOC_ROOT."/classes/xmlTransformCompra.class.php");
include_once(DOC_ROOT."/classes/compra.class.php");
include_once(DOC_ROOT."/classes/proveedor.class.php");
include_once(DOC_ROOT."/classes/paymentCompra.class.php");

$db = new DB;
$error = new Error;
$util = new Util;
$main = new Main;
$empresa = new Empresa;
$rfc = new Rfc;
$sucursal = new Sucursal;
$reporte = new Reporte;
$folios = new Folios;
$cliente = new Cliente;
$usuario = new Usuario;
$producto = new Producto;
$comprobante = new Comprobante;
$comprobanteForma = new ComprobanteForma;
$comprobanteCliente = new ComprobanteCliente;
$vistaPrevia = new VistaPrevia;
$complementoNomina = new ComplementoNomina;
$impuesto = new Impuesto;
$user = new User;
$pac = new Pac;
$pacOld = new PacOld;
$payment = new Payment;
$json = new Services_JSON;
$smarty = new Smarty;
$venta = new Venta;
$nomina = new Nomina;
$xmlTransform = new XmlTransform;
$xmlTransformCompra = new XmlTransformCompra;
$compra = new Compra;
$proveedor = new Proveedor;
$paymentCompra = new PaymentCompra;
$mail = new PHPMailer(true);

//cfdi33
include_once(DOC_ROOT."/services/Cfdi.php");
include_once(DOC_ROOT."/services/Catalogo.php");
include_once(DOC_ROOT."/services/Sello.php");
include_once(DOC_ROOT."/services/Totales.php");
include_once(DOC_ROOT."/services/ComprobantePago.php");

$cfdi = new Cfdi;
$catalogo = new Catalogo;
$sello = new Sello;
$totales = new Totales;
$comprobantePago = new ComprobantePago;

//$util->wwwRedirect();

$smarty->assign('DOC_ROOT',DOC_ROOT);
$smarty->assign('WEB_ROOT',WEB_ROOT);
$smarty->assign('NEW_WEB_ROOT',WEB_ROOT);
$smarty->assign('ADMINISTRACION_NAME',ADMINISTRACION_NAME);
$smarty->assign('ADMINISTRACION_URL',ADMINISTRACION_URL);


$smarty->assign('property', $property);

$lang = $util->ReturnLang();

$newDesignExclude = $main->NewDesignExclude();
$smarty->assign('newDesignExclude', $newDesignExclude);
//empresas a las que NO se les cambiara el formato

?>
<?php
include_once('init.php');
include_once('config.php');
include_once(DOC_ROOT.'/libraries.php');

//echo "Error en servidor, por favor sea paciente ya estamos encargandonos del problema<br> Disculpe los inconvenientes, favor de tratar mas tarde. Probablemente tarde 1 o 2 horas en corregirse.<br>";

$pages = array(
	'homepage',
	'register',
	'register-manual',
	'sistema',
		'admin-folios',
		'datos-generales',
		'admin-productos',
		'cliente',
		'reporte-sat',
		'usuarios',
		'impuesto',
		'cliente-factura',
		'cliente-consulta',
		'acceso-cliente',
		'facturas-cliente',
		'datos-cliente',
		'registro-cliente',
		'cliente-sistema',
	'portfolio',
	'producto',
	'contacto',
	'requisitos',
	'frecuentes',
	'videotutoriales',
	'activar',

	//new
	'login',
	'nuevo',	
	'develop',
	'beneficios',
	'negocio',
	'cbb',
	'cfdi',
	'servicio',
	'faq',
	'privacidad',
	'servicios',
	'terminos',
	'reportes',
	'nueva-venta',
	'reporte-ventas',
	'ventas-ticket',
	'nueva-factura-ish',
	'nueva-factura-agrario',
	'xml-pdf',

	//nominasno
	'nomina',

	//adddendas
	'addendaPepsico',
	'addendaZepto',
	'addendaContinental',
	
	//otros modulos
	'nueva-factura-escuela',
	'nueva-factura-transporte',
	'nueva-factura-ieps',
	'donatarias',
	
	//mantenimiento
	'cancelar-uuid',
	'actualizar',

	'reportePago',	
	'vencimientos',
	
	//compras
	'compras',
	'nueva-compra',
	'proveedores',
	'soporte',
//	'timbres',
	'videos',

	//cfdi 3.3
	'cfdi33-generate',
	'cfdi33-generate-nomina',
	'cfdi33-generate-pdf',
);

$smarty->assign("SITENAME",SITENAME);

if($_SESSION["tipoUsuario"] != "cliente")
{
	if(isset($_SESSION['empresaId']))
	{	
		
//		$certificadosRestantes = $empresa->GetCertificadosRestantes();
		
//		if($certificadosRestantes <= ALERT_CERT)
//		{
//			$smarty->assign("minCertificados", "yes");
//			$smarty->assign("certificadosRestantes", $certificadosRestantes);
//		}
		
		$_SESSION['permisos2'] = unserialize(urldecode($_SESSION["keyP"]));
		$_SESSION['nuevosPermisos2'] = unserialize(urldecode($_SESSION["keyNP"]));
		
		
		foreach($_SESSION['nuevosPermisos2'] as $key => $value)
		{
			if(!is_array($value))
			{
				$_SESSION['nuevosPermisos2'][$key] = array();
			}
		}
		$smarty->assign("permisos",$_SESSION['permisos2']);
		$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
	}
}
if(!in_array($_GET['page'], $pages))
{
	$_GET['page'] = "homepage";
}

if($_SESSION["tipoUsuario"] && $_SESSION["tipoUsuario"] != "cliente")
{
	include_once(DOC_ROOT.'/modules/user.php');
}else
{
	$info['email'] = $_SESSION['loginKey'];
	$smarty->assign("info", $info);
}

if($info["version"] == "2" && SITENAME != "CONFACTURA")
{
	echo "Esta version esta descontinuada, favor de actualizar su esquema de facturacion. Contactanos.";
	echo "<a href='".WEB_ROOT."' >Volver</a>";
	session_destroy();
	exit();
}
include_once(DOC_ROOT.'/modules/'.$_GET['page'].'.php');

$smarty->assign('page', $_GET['page']);
$smarty->assign('section', $_GET['section']);

$includedTpl =  $_GET['page'];
if($_GET['section'])
{
	$includedTpl =  $_GET['page']."_".$_GET['section'];
}

$smarty->assign('includedTpl', $includedTpl);
$smarty->assign('version', $_SESSION["version"]);

$smarty->assign('TASA_ISH', TASA_ISH);

$smarty->assign('lang', $lang);

$smarty->display(DOC_ROOT.'/templates/index.tpl'); 

?>
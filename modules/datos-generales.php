<?php
$empresa->AuthUser();
$empresa->hasPermission($_GET['page']);

$info = $empresa->Info();
$smarty->assign("info", $info);

$empresa->Util()->DB()->setQuery("SELECT * FROM usuario");
$result = $empresa->Util()->DB->GetResult();

$rfc->setEmpresaId($_SESSION["empresaId"], 1);
$result2 = $rfc->GetRfcsByEmpresa();
$result3 = $util->DecodeUrlResult($result2);
$empresasRfcs = $util->DecodeResult($result3);
$smarty->assign("empresaRfcs", $empresasRfcs);

switch($_GET["section"])
{
	case "nueva-factura":
		$producto->CleanConceptos();
		$ivas = $main->ListIvas();
		$smarty->assign("ivas", $ivas);
		$retIsrs = $main->ListRetIsr();
		$smarty->assign("retIsrs", $retIsrs);
		$retIvas = $main->ListRetIva();
		$smarty->assign("retIvas", $retIvas);
		$tiposDeMoneda = $main->ListTipoDeMoneda();
		$smarty->assign("tiposDeMoneda", $tiposDeMoneda);
		$comprobantes = $main->ListTiposDeComprobantes();
		$smarty->assign("comprobantes", $comprobantes);		
/*		$info = $empresa->Info();
		$empresa->setEmpresaId($info["empresaId"], 1);
		$sucursales = $empresa->ListSucursales();
		$smarty->assign("sucursales", $sucursales);		
		$excentoIva = $main->ListExcentoIva();
		$smarty->assign("excentoIva", $excentoIva);		
*/		break;

}
?>
<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
switch($_POST["type"])
{
	case "generarReporte":
	//	print_r($_POST);
		$reporte->setMes($_POST["mes"]);
		$reporte->setAnio($_POST["anio"]);
		$comprobante = $reporte->GenerarReporteSat();
		
		if($comprobante)
		{
			$smarty->assign("comprobante", $comprobante);
			$smarty->display(DOC_ROOT.'/templates/boxes/reporte-sat-descarga.tpl');
		}

		break;
		

}

?>

<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

switch($_POST["type"])
{
	case "agregarConcepto": 
		$values = explode("&", $_POST["form"]);
		foreach($values as $key => $val)
		{
			$values[$key] = explode("=", $values[$key]);
		}
		$producto->setCantidad($values[0][1]);
		$producto->setNoIdentificacion($values[1][1]);
		$producto->setUnidad($values[2][1]);
		$producto->setDescripcion($values[3][1]);
		$producto->setValorUnitario($values[4][1]);
		$producto->setExcentoIva($values[5][1]);
		$producto->setImporte();
		if(!$producto->AgregarConcepto())
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok|ok";
		}
		echo "|";
		$smarty->assign("conceptos", $_SESSION["conceptos"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/conceptos.tpl');
	
		break;
	case "borrarConcepto": 
		$producto->BorrarConcepto($_POST["id"]);
		$smarty->assign("conceptos", $_SESSION["conceptos"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/conceptos.tpl');
	
		break;
	case "updateTotalesDesglosados": 
		$totalDesglosado = $producto->GetTotalDesglosado();
		foreach($totalDesglosado as $key => $total)
		{
			$totalDesglosado[$key] = number_format($totalDesglosado[$key], 2);
		}
		$smarty->assign("totalDesglosado", $totalDesglosado);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/boxes/total-desglosado.tpl');
	
		break;
	case "generarComprobante":
		$data["datosFacturacion"] = $_POST["nuevaFactura"];
		$data["observaciones"] = $_POST["observaciones"];
		if(!$comprobante->GenerarComprobante($data))
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok|";
			$comprobante = $comprobante->GetLastComprobante();
			$smarty->assign("comprobante", $comprobante);
			$smarty->display(DOC_ROOT.'/templates/boxes/export-factura.tpl');
		}
	
		break;
	case "cambiarRfcActivo":
		$rfc->setRfcId($_POST["rfcId"]);
		$rfc->SetAsActive();
		break;
}

?>

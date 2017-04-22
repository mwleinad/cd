<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

switch($_POST["type"])
{
	case "saveAddPayment":
	
		if($venta->setImporteVenta($_POST['importe']) == false)
		{
			echo "fail[#]";
			$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
		}
		else
		{
			
			if($venta->checarPago($_POST['importe'],$_POST['totalVenta']) == false){
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}else{			
				echo "ok[#]";
			}
		}
	break;
	case "addPagos":
		if (count ($_SESSION["conceptos"])==0)
		{
			echo "fail[#]";
			echo "Debes de tener por lo menos un concepto";
		exit();}//Sin pagos.
		
		$totalDesglosado = $producto->GetTotalDesglosado2(16);
		$smarty->assign("impuestos", $totalDesglosado["impuestos"]);
		unset($totalDesglosado["impuestos"]);
		
		$totalImporteVenta = $totalDesglosado["afterImpuestos"];
		if($totalDesglosado){
			foreach($totalDesglosado as $key => $total)
			{
				$totalDesglosado[$key] = number_format($totalDesglosado[$key], 2);
			}
		}
		//print_r($totalDesglosado);
		$smarty->assign("totalImporteVenta", $totalImporteVenta);
		$smarty->assign("totalDesglosado", $totalDesglosado);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/boxes/add-pago-popup.tpl');
	break;
	
	case "agregarConcepto": 
	
		$producto->setCantidad($_POST["cantidad"]);
		$producto->setNoIdentificacion($_POST["noIdentificacion"]);
		$producto->setUnidad($_POST["unidad"]);
		$producto->setDescripcion($_POST["descripcion"]);
		$producto->setValorUnitario($_POST["valorUnitario"]);
		$producto->setExcentoIva($_POST["excentoIva"]);
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
		//print_r($_SESSION["conceptos"]);
		$smarty->assign("conceptos", $_SESSION["conceptos"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/conceptos_venta.tpl');
	
		break;
	case "borrarConcepto": 
		$producto->BorrarConcepto($_POST["id"]);
		$smarty->assign("conceptos", $_SESSION["conceptos"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/conceptos.tpl');
	
		break;
	case "updateTotalesDesglosados": 
		$totalDesglosado = $producto->GetTotalDesglosado();
		$smarty->assign("impuestos", $totalDesglosado["impuestos"]);
		unset($totalDesglosado["impuestos"]);		
		if($totalDesglosado){
			foreach($totalDesglosado as $key => $total)
			{
				$totalDesglosado[$key] = number_format($totalDesglosado[$key], 2);
			}
		}
		$smarty->assign("totalDesglosado", $totalDesglosado);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/boxes/total-desglosado-venta.tpl');
	
	break;
	
	case "generarNotaVenta":
	
		$data["datosFacturacion"] = $_POST["nuevaFactura"];
		
		if(!$venta->GenerarNotaVenta($data))
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			$notaVentaId = $venta->GetVentaId();
			echo "ok|".$notaVentaId;
		}
	
	break;
}

?>

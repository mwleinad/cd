<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
//include_once(DOC_ROOT.'/classes/generate_xml_default.class.php');
switch($_POST["type"])
{
	case "agregarPercepcion": 
		$nomina->setTipoPercepcion($_POST["tipoPercepcion"]);
		$nomina->setImporteGravado($_POST["importeGravado"]);
		$nomina->setImporteExcento($_POST["importeExcento"]);

		if(!$nomina->AgregarPercepcion())
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok|ok";
		}
		echo "|";
		$smarty->assign("percepciones", $_SESSION["percepciones"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/percepciones.tpl');
	
		break;
	case "borrarPercepcion": 
		$nomina->BorrarPercepcion($_POST["id"]);
		$smarty->assign("percepciones", $_SESSION["percepciones"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/percepciones.tpl');
	
		break;
	case "agregarOtroPago": 
		$nomina->setTipoOtroPago($_POST["tipoOtroPago"]);
		$nomina->setImporte($_POST["importe"]);

		if(!$nomina->AgregarOtroPago())
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok|ok";
		}
		echo "|";
		$smarty->assign("otrosPagos", $_SESSION["otrosPagos"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/otrosPagos.tpl');
	
		break;
	case "borrarOtroPago": 
		$nomina->BorrarOtroPago($_POST["id"]);
		$smarty->assign("otrosPagos", $_SESSION["otrosPagos"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/otrosPagos.tpl');
	
		break;		
	case "agregarDeduccion": 
		$nomina->setTipoDeduccion($_POST["tipoDeduccion"]);
		$nomina->setImporteGravado($_POST["importeGravado"]);
		$nomina->setImporteExcento($_POST["importeExcento"]);

		if(!$nomina->AgregarDeduccion())
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok|ok";
		}
		echo "|";
		$smarty->assign("deducciones", $_SESSION["deducciones"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/deducciones.tpl');
	
		break;
	case "borrarDeduccion": 
		$nomina->BorrarDeduccion($_POST["id"]);
		$smarty->assign("deducciones", $_SESSION["deducciones"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/deducciones.tpl');
	
		break;
	case "agregarIncapacidad": 
		$nomina->setTipoIncapacidad($_POST["tipoIncapacidad"]);
		$nomina->setDiasIncapacidad($_POST["diasIncapacidad"]);
		$nomina->setDescuento($_POST["descuento"]);

		if(!$nomina->AgregarIncapacidad())
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok|ok";
		}
		echo "|";
		$smarty->assign("incapacidades", $_SESSION["incapacidades"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/incapacidades.tpl');
	
		break;
	case "borrarIncapacidad": 
		$nomina->BorrarIncapacidad($_POST["id"]);
		$smarty->assign("incapacidades", $_SESSION["incapacidades"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/incapacidades.tpl');
	
		break;

	case "agregarHoraExtra": 
		$nomina->setTipoHorasExtra($_POST["tipoHorasExtra"]);
		$nomina->setDias($_POST["dias"]);
		$nomina->setHorasExtra($_POST["horasExtra"]);
		$nomina->setImportePagado($_POST["importePagado"]);

		if(!$nomina->AgregarHoraExtra())
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
		}
		else
		{
			echo "ok|ok";
		}
		echo "|";
		$smarty->assign("horasExtras", $_SESSION["horasExtras"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/horasExtra.tpl');
	
		break;
	case "borrarHoraExtra": 
		$nomina->BorrarHoraExtra($_POST["id"]);
		$smarty->assign("horasExtras", $_SESSION["horasExtras"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/horasExtra.tpl');
	
		break;
	case "updateConcepto":
		$nomina->UpdateConcepto();

		$smarty->assign("conceptos", $_SESSION["conceptos"]);
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->display(DOC_ROOT.'/templates/lists/conceptos_nomina.tpl');
		
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
		$smarty->display(DOC_ROOT.'/templates/boxes/total-desglosado.tpl');
	
		break;
	case "guardarDatosNomina":
	
		$data["datosFacturacion"] = $_POST["nuevaFactura"];
		$data["observaciones"] = $_POST["observaciones"];
		
		$data["reviso"] = $_POST["reviso"];
		$data["autorizo"] = $_POST["autorizo"];
		$data["recibio"] = $_POST["recibio"];
		$data["vobo"] = $_POST["vobo"];
		$data["pago"] = $_POST["pago"];
		$data["tiempoLimite"] = $_POST["tiempoLimite"];
		$data["formatoNormal"] = $_POST["formatoNormal"];
		
		$data["spf"] = $_POST["spf"];
		$data["isn"] = $_POST["isn"];

		$values = explode("&", $data["datosFacturacion"]);
		foreach($values as $key => $val)
		{
			$array = explode("=", $values[$key]);
			$data[$array[0]] = $array[1];
		}
		
		if($data["fromAgrario"] == "Si")
		{
			$data["noRegistro"] = $_POST["idPedido"];
			$data["noGuiaTraslado"] = $_POST["idSolicitudDePago"];
			$data["uppOrigen"] = $_POST["referencia"];
			$data["patenteVendedor"] = $_POST["idProveedor"];
			$data["finalidad"] = $_POST["finalidad"];
			$data["uppDestino"] = $_POST["uppDestino"];
			$data["firmaVendedor"] = $_POST["firmaVendedor"];
		}
		
		$nomina->GuardarDatos($data, $_SESSION);
		
		echo "ok";
	
		break;				
}

?>

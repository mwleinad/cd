<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addSimulador": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-simulador-popup.tpl');
		break;	
	case "saveAddSimulador":
			$simulador->setMontoAFinanciar($_POST['montoAFinanciar']);
			$simulador->setTasa($_POST['tasa']);
			$simulador->setIvaTasa($_POST['ivaTasa']);
			$simulador->setTotalTasa($_POST['totalTasa']);
			$simulador->setCuotaApertura($_POST['cuotaApertura']);
			$simulador->setIvaCuota($_POST['ivaCuota']);
			$simulador->setTotalCoutaApertura($_POST['totalCoutaApertura']);
			$simulador->setTipoDeNomina($_POST['tipoDeNomina']);
			$simulador->setDescuento($_POST['descuento']);
			$simulador->setPago($_POST['pago']);
			$simulador->setSueldoMensual($_POST['sueldoMensual']);
			if(!$simulador->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__simulador = $simulador->Enumerate();
				$smarty->assign("__simulador", $__simulador);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/simulador.tpl');
			}
		break;
	case "deleteSimulador":
			$simulador->setIdSimulador($_POST['idSimulador']);
			if($simulador->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$__simulador = $simulador->Enumerate();
				$smarty->assign("__simulador", $__simulador);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/simulador.tpl');
			}
		break;
	case "editSimulador": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$simulador->setIdSimulador($_POST['idSimulador']);
			$mySimulador = $simulador->Info();
			$smarty->assign("post", $mySimulador);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-simulador-popup.tpl');
		break;
	case "saveEditSimulador":
			$simulador->setIdSimulador($_POST['idSimulador']);
			$simulador->setMontoAFinanciar($_POST['montoAFinanciar']);
			$simulador->setTasa($_POST['tasa']);
			$simulador->setIvaTasa($_POST['ivaTasa']);
			$simulador->setTotalTasa($_POST['totalTasa']);
			$simulador->setCuotaApertura($_POST['cuotaApertura']);
			$simulador->setIvaCuota($_POST['ivaCuota']);
			$simulador->setTotalCoutaApertura($_POST['totalCoutaApertura']);
			$simulador->setTipoDeNomina($_POST['tipoDeNomina']);
			$simulador->setDescuento($_POST['descuento']);
			$simulador->setPago($_POST['pago']);
			$simulador->setSueldoMensual($_POST['sueldoMensual']);
			if(!$simulador->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$__simulador = $simulador->Enumerate();
				$smarty->assign("__simulador", $__simulador);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/simulador.tpl');
			}
		break;
}
?>

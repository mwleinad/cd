<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addVentas":
			//$socios = $main->ListSocios();
			//$smarty->assign("socios", $socios);
             //print_r($_SESSION); exit;
			$resOrden = $ordenes->OrdenesListaT();
			$smarty->assign("resOrden", $resOrden);
			if($_SESSION['tipo']=="partner"){
			$usuario->setIdUsuario($_SESSION['loginKey']);
			$__usuario = $usuario->EnumerateUsuario();
			//echo "<pre>";print_r($__usuario); exit;
			$smarty->assign("datos",$__usuario);
	        }
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-ventas-popup.tpl');
		break;	
	case "saveAddVentas":
	         
			$ventas->setCantidad($_POST['cantidad']);
			if($_SESSION['tipo']=="partner"){
			$ventas->setDisponibles($_POST['disponibles']);
			}
			$ventas->setFecha($_POST['fecha']);
			$ventas->setIdSocio($_SESSION['loginKey']);
			$ventas->setStatus($_POST['status']);
			$ventas->setIdEmpresa($_POST['idEmpresa']);
			$ventas->setFechaPagado($_POST['fechaPagado']);
			if(!$ventas->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resVentas = $ventas->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/ventas.tpl');
			}
		break;
	case "deleteVentas":
			$ventas->setIdVenta($_POST['idVenta']);
			if($ventas->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resVentas = $ventas->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/ventas.tpl');
			}
		break;
	case "editVentas": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$ventas->setIdVenta($_POST['idVenta']);
			$myVentas = $ventas->Info();
			$smarty->assign("post", $myVentas);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-ventas-popup.tpl');
		break;
	case "saveEditVentas":
			$ventas->setIdVenta($_POST['idVenta']);
			$ventas->setCantidad($_POST['cantidad']);
			$ventas->setFecha($_POST['fecha']);
			$ventas->setIdSocio($_POST['idSocio']);
			$ventas->setStatus($_POST['status']);
			$ventas->setIdEmpresa($_POST['idEmpresa']);
			$ventas->setFechaPagado($_POST['fechaPagado']);
			if(!$ventas->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resVentas = $ventas->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/ventas.tpl');
			}
		break;
}
?>

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
			$smarty->display(DOC_ROOT.'/templates/boxes/add-impuestos-popup.tpl');
		break;	
	case "saveAddVentas":
	         
			//$ventas->setCantidad($_POST['cantidad']);
			if($_SESSION['tipo']=="partner"){
			$impuestos->setDisponibles($_POST['disponibles']);
			}
			$impuestos->setFecha($_POST['fecha']);
			$impuestos->setIdSocio($_SESSION['loginKey']);
			$impuestos->setStatus($_POST['status']);
			$impuestos->setIdEmpresa($_POST['idEmpresa']);
			$impuestos->setFechaPagado($_POST['fechaPagado']);
			if(!$impuestos->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resVentas = $impuestos->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/impuestos.tpl');
			}
		break;
	case "deleteVentas":
			$impuestos->setIdVenta($_POST['idVenta']);
			if($impuestos->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resVentas = $impuestos->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/impuestos.tpl');
			}
		break;
	case "editVentas": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$impuestos->setIdVenta($_POST['idVenta']);
			$myVentas = $impuestos->Info();
			$smarty->assign("post", $myVentas);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-impuestos-popup.tpl');
		break;
	case "saveEditVentas":
			$impuestos->setIdVenta($_POST['idVenta']);
			$impuestos->setFecha($_POST['fecha']);
			$impuestos->setIdSocio($_POST['idSocio']);
			$impuestos->setStatus($_POST['status']);
			$impuestos->setIdEmpresa($_POST['idEmpresa']);
			$impuestos->setFechaPagado($_POST['fechaPagado']);
			if(!$impuestos->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resVentas = $impuestos->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/impuestos.tpl');
			}
		break;
}
?>

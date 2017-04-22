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
			$smarty->display(DOC_ROOT.'/templates/boxes/add-nominas-popup.tpl');
		break;	
	case "saveAddVentas":
	         
			//$ventas->setCantidad($_POST['cantidad']);
			if($_SESSION['tipo']=="partner"){
			$nominas->setDisponibles($_POST['disponibles']);
			}
			$nominas->setFecha($_POST['fecha']);
			$nominas->setIdSocio($_SESSION['loginKey']);
			$nominas->setStatus($_POST['status']);
			$nominas->setIdEmpresa($_POST['idEmpresa']);
			$nominas->setFechaPagado($_POST['fechaPagado']);
			if(!$nominas->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resVentas = $nominas->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/nominas.tpl');
			}
		break;
	case "deleteVentas":
			$nominas->setIdVenta($_POST['idVenta']);
			if($nominas->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resVentas = $nominas->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/nominas.tpl');
			}
		break;
	case "editVentas": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$nominas->setIdVenta($_POST['idVenta']);
			$myVentas = $nominas->Info();
			$smarty->assign("post", $myVentas);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-nominas-popup.tpl');
		break;
	case "saveEditVentas":
			$nominas->setIdVenta($_POST['idVenta']);
			$nominas->setFecha($_POST['fecha']);
			$nominas->setIdSocio($_POST['idSocio']);
			$nominas->setStatus($_POST['status']);
			$nominas->setIdEmpresa($_POST['idEmpresa']);
			$nominas->setFechaPagado($_POST['fechaPagado']);
			if(!$nominas->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resVentas = $nominas->Enumerate();
				$smarty->assign("resVentas", $resVentas);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/nominas.tpl');
			}
		break;
}
?>

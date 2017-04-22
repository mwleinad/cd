<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

switch($_POST["type"])
{
	case "addOrden": 
	
			//$socios = $main->ListSocios();
			//$smarty->assign("socios", $socios);
              //roleId==1 admin roleId==2 partner 
			$resOrden = $ordenes->OrdenesListaT();
			//echo "<pre>";print_r($resOrden);exit;
			if($_SESSION['roleId']==1){
			    $usuarios=$usuario->Enumerate();
				$smarty->assign("usuarios",$usuarios);
			}elseif($_SESSION['roleId']==2){
			    $smarty->assign("idUsuario",$_SESSION['loginKey']);
			}
			
			$smarty->assign("roleId",$_SESSION['roleId']);
			//echo "<pre>";print_r($resOrden);
			$smarty->assign("resOrden", $resOrden);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-orden-popup.tpl');
		break;	
		
	case "saveAddOrden":
//			$orden->setFecha($_POST['fecha']);
			$orden->setIdSocio($_POST['idSocio']);
//			$orden->setStatus($_POST['status']);
			$orden->setIdEmpresa($_POST['idEmpresa']);
			if(!$orden->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resOrden = $orden->Enumerate();
				$smarty->assign("resOrden", $resOrden);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/orden.tpl');
			}
		break;
	case "deleteOrden":
			$orden->setIdOrden($_POST['idOrden']);
			if($orden->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resOrden = $orden->Enumerate();
				$smarty->assign("resOrden", $resOrden);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/orden.tpl');
			}
		break;
	case "editOrden": 
			$socios = $main->ListSocios();
			$smarty->assign("socios", $socios);

			$resOrden = $ordenes->OrdenesLista();
			$smarty->assign("resOrden", $resOrden);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			
			$orden->setIdOrden($_POST['idOrden']);
			$myOrden = $orden->Info();
			$smarty->assign("post", $myOrden);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-orden-popup.tpl');
		break;
	case "saveEditOrden":
			$orden->setIdOrden($_POST['idOrden']);
			$orden->setFecha($_POST['fecha']);
			$orden->setIdSocio($_POST['idSocio']);
			$orden->setStatus($_POST['status']);
			$orden->setIdEmpresa($_POST['idEmpresa']);
			if(!$orden->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resOrden = $orden->Enumerate();
				$smarty->assign("resOrden", $resOrden);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/orden.tpl');
			}
		break;
}
?>

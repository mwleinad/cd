<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addPaqFolios": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-paqFolios-popup.tpl');
		break;	
	case "saveAddPaqFolios":
		//print_r($_POST);
		$paqs -> setNombre($_POST['nombre']);
		$paqs -> setCantidad($_POST['cantidad']);
		$paqs -> setMonto($_POST['monto']);
		
		if(!$paqs->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$paquetes = $paqs -> Enumerate();
				$smarty->assign("paquetes",$paquetes);				
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/paqFolios.tpl');
			}
		break;
		case "editPaqFolios":
		    $paqs -> setPaqFoliosId($_POST['paqFoliosId']);
			$info = $paqs -> Info();
			$smarty->assign("info",$info);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-paqFolios-popup.tpl');
		
		break;
		case "saveEditPaqFolios":
		//print_r($_POST);
		$paqs -> setPaqFoliosId($_POST['paqFoliosId']);
		$paqs -> setNombre($_POST['nombre']);
		$paqs -> setCantidad($_POST['cantidad']);
		$paqs -> setMonto($_POST['monto']);
		
		if(!$paqs->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$paquetes = $paqs -> Enumerate();
				$smarty->assign("paquetes",$paquetes);				
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/paqFolios.tpl');
			}
		break;
}
?>
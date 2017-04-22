<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

switch($_POST["type"])
{
	case "addImpuesto": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-impuesto-popup.tpl');
		break;
		
	case "saveAddImpuesto":
	
			$impuesto->setNombre($_POST['nombre']);
			$impuesto->setTasa($_POST['tasa']);
			$impuesto->setTipo($_POST['tipo']);
			
			if(!$impuesto->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resImpuesto = $impuesto->Enumerate();
				$smarty->assign("resImpuesto", $resImpuesto);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/impuesto.tpl');
			}
		break;
	case "deleteImpuesto":
			$impuesto->setImpuestoId($_POST['impuestoId']);
			if($impuesto->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resImpuesto = $impuesto->Enumerate();
				$smarty->assign("resImpuesto", $resImpuesto);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/impuesto.tpl');
			}
		break;
	case "editImpuesto": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$impuesto->setImpuestoId($_POST['impuestoId']);
			$myImpuesto = $impuesto->Info();
			$smarty->assign("post", $myImpuesto);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-impuesto-popup.tpl');
		break;
	case "saveEditImpuesto":
			$impuesto->setImpuestoId($_POST['impuestoId']);
			$impuesto->setNombre($_POST['nombre']);
			$impuesto->setTasa($_POST['tasa']);
			$impuesto->setTipo($_POST['tipo']);
			if(!$impuesto->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resImpuesto = $impuesto->Enumerate();
				$smarty->assign("resImpuesto", $resImpuesto);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/impuesto.tpl');
			}
		break;
}
?>

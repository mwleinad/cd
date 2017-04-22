<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
switch($_POST["type"])
{
	case "addReporte": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/add-reporte-popup.tpl');
		break;	
	case "saveAddReporte":
			$reporte->setDate($_POST['date']);
			$reporte->setData($_POST['data']);
			if(!$reporte->Save())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resReporte = $reporte->Enumerate();
				$smarty->assign("resReporte", $resReporte);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/reporte.tpl');
			}
		break;
	case "deleteReporte":
			$reporte->setIdReporte($_POST['idReporte']);
			if($reporte->Delete())
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$resReporte = $reporte->Enumerate();
				$smarty->assign("resReporte", $resReporte);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/reporte.tpl');
			}
		break;
	case "editReporte": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$reporte->setIdReporte($_POST['idReporte']);
			$myReporte = $reporte->Info();
			$smarty->assign("post", $myReporte);
			$smarty->display(DOC_ROOT.'/templates/boxes/edit-reporte-popup.tpl');
		break;
	case "saveEditReporte":
			$reporte->setIdReporte($_POST['idReporte']);
			$reporte->setDate($_POST['date']);
			$reporte->setData($_POST['data']);
			if(!$reporte->Edit())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$resReporte = $reporte->Enumerate();
				$smarty->assign("resReporte", $resReporte);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/reporte.tpl');
			}
		break;
}
?>

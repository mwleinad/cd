<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
switch($_POST["type"])
{
	case "editRfc":
		
		$rfc->setRfcId($_POST['id']);
		$result = $rfc->InfoRfc();
		
		$myRfc = $util->DecodeUrlRow($result);
		
			//regimenes
			$db->setQuery("SELECT * FROM tipoRegimen ORDER BY nombreRegimen ASC");
			$regimenes = $db->GetResult();
			$smarty->assign('regimenes',$regimenes);
		
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$smarty->assign("post", $myRfc);
		$smarty->display(DOC_ROOT.'/templates/boxes/edit-rfc-popup.tpl');
		break;
		
	case "addRfc": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			
			//regimenes
			$db->setQuery("SELECT * FROM tipoRegimen ORDER BY nombreRegimen ASC");
			$regimenes = $db->GetResult();
			$smarty->assign('regimenes',$regimenes);
			
			$smarty->display(DOC_ROOT.'/templates/boxes/agregar-rfc-popup.tpl');
		break;	
	case "saveRfc": 
		$values = explode("&", $_POST["form"]);
		foreach($values as $key => $val)
		{
			$values[$key] = explode("=", $values[$key]);
		}
			$rfc->setRazonSocial($values[0][1], 0);
			$rfc->setCalle($values[1][1]);
			$rfc->setNoExt($values[2][1]);
			$rfc->setNoInt($values[3][1]);
			$rfc->setReferencia($values[4][1]);
			$rfc->setColonia($values[5][1]);
			$rfc->setLocalidad($values[6][1]);
			$rfc->setMunicipio($values[7][1]);
			$rfc->setCiudad($values[8][1]);
			$rfc->setCp($values[9][1]);
			$rfc->setEstado($values[10][1]);
			$rfc->setPais($values[11][1]);
			$rfc->setRfc($values[12][1]);
			$rfc->setCurp($values[13][1]);
			$rfc->setEmpresaId($_SESSION["empresaId"], 1);
			if(!$rfc->AddRfc())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$result = $rfc->GetRfcsByEmpresa();
				$empresaRfcs = $util->DecodeUrlResult($result);
				$smarty->assign("empresaRfcs", $empresaRfcs);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/datos_generales.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$result = $rfc->GetRfcsByEmpresa();
				$empresaRfcs = $util->DecodeUrlResult($result);
				$smarty->assign("empresaRfcs", $empresaRfcs);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/datos_generales.tpl');
			}
		break;	
	case "saveEditRfc": 
		$values = explode("&", $_POST["form"]);
		foreach($values as $key => $val)
		{
			$values[$key] = explode("=", $values[$key]);
		}
			$rfc->setRazonSocial($values[0][1], 0);
			$rfc->setCalle($values[1][1]);
			$rfc->setNoExt($values[2][1]);
			$rfc->setNoInt($values[3][1]);
			$rfc->setReferencia($values[4][1]);
			$rfc->setColonia($values[5][1]);
			$rfc->setLocalidad($values[6][1]);
			$rfc->setMunicipio($values[7][1]);
			$rfc->setCp($values[9][1]);
			$rfc->setEstado($values[10][1]);
			$rfc->setPais($values[11][1]);
			$rfc->setRfcDelete($values[12][1]);
			$rfc->setEmpresaId($_SESSION["empresaId"], 1);
			$rfc->setRegimenFiscal($values[13][1]);
			$rfc->setPermisoFacturar($values[14][1]);
			$rfc->setDiasFacturar($values[15][1]);
			$rfc->setCurp($values[16][1]);
			$rfc->setRfcId($values[17][1]);
//			print_r($values);
			if(!$rfc->EditRfc())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$result = $rfc->GetRfcsByEmpresa();
				$empresaRfcs = $util->DecodeUrlResult($result);
				$smarty->assign("empresaRfcs", $empresaRfcs);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/datos_generales.tpl');
			}
		break;	
	case "deleteRfc":
			$rfc->setRfcId($_POST['rfcId']);
			$rfc->setEmpresaId($_SESSION["empresaId"], 1);
			if($rfc->DeleteRfc())
			{
				echo "Ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$result = $rfc->GetRfcsByEmpresa();
				$empresaRfcs = $util->DecodeUrlResult($result);
				$smarty->assign("empresaRfcs", $empresaRfcs);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/datos_generales.tpl');
			}
	
}

?>

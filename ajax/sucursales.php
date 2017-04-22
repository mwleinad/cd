<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
switch($_POST["type"])
{
	case "listSucursales": 
			$sucursal->setRfcId($_POST['rfc']);
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
			$result = $sucursal->GetSucursalesByRfc();
			$result2 = $util->EncodeResult($result);
			$sucursales = $util->DecodeUrlResult($result2);
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->assign("sucursales", $sucursales);
			
			$smarty->display(DOC_ROOT.'/templates/lists/sucursales.tpl');
		break;	
	case "deleteSucursal":
			$sucursal->setSucursalId($_POST['sucursalId']);
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
			$sucursalInfo = $sucursal->SucursalInfo();
			if($sucursal->DeleteSucursal())
			{
				echo "Ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				echo $sucursalInfo["rfcId"];
			}
		break;
	case "changeStatus":
			$sucursal->setSucursalId($_POST['sucursalId']);
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
			$sucursalInfo = $sucursal->SucursalInfo();
			if($sucursal->ChangeStatus())
			{
				echo "Ok[#]";
				echo $sucursalInfo["rfcId"];
			}
		break;
	case "addSucursal": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/agregar-sucursal-popup.tpl');
		break;	
	case "saveSucursal":
			
			$values = explode('&', $_POST['form']);
			
			foreach($values as $key => $val){
				$values[$key] = explode('=', $values[$key]);
			}			
			
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
			$sucursal->setRfcId($_POST["rfcId"]);
			$sucursal->setIdentificador($values[0][1]);			
			$sucursal->setCalle($values[1][1]);
			$sucursal->setNoExt($values[2][1]);
			$sucursal->setNoInt($values[3][1]);
			$sucursal->setReferencia($values[4][1]);
			$sucursal->setColonia($values[5][1]);
			$sucursal->setLocalidad($values[6][1]);
			$sucursal->setMunicipio($values[7][1]);
			$sucursal->setCiudad($values[8][1]);
			$sucursal->setCp($values[9][1]);
			$sucursal->setEstado($values[10][1]);
			$sucursal->setPais($values[11][1]);
			if(!$sucursal->AddSucursal())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
		break;	
		
	case "editSucursal":
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$sucursal->setSucursalId($_POST['id']);
		$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
		$info = $sucursal->GetSucursalInfoById();
		$mySucursal = $util->DecodeUrlRow($info);
		$smarty->assign("post", $mySucursal);
		$smarty->display(DOC_ROOT.'/templates/boxes/edit-sucursal-popup.tpl');
		break;
		
	case "saveEditSucursal": 
			
			$values = explode('&', $_POST['form']);
			
			foreach($values as $key => $val){
				$values[$key] = explode('=', $values[$key]);
			}
			
			$sucursal->setEmpresaId($_SESSION["empresaId"], 1);
			$sucursal->setSucursalId($_POST['sucursalId']);
			$sucursal->setIdentificador($values[1][1]);		
			$sucursal->setCalle($values[2][1]);
			$sucursal->setNoExt($values[3][1]);
			$sucursal->setNoInt($values[4][1]);
			$sucursal->setReferencia($values[5][1]);
			$sucursal->setColonia($values[6][1]);
			$sucursal->setLocalidad($values[7][1]);
			$sucursal->setMunicipio($values[8][1]);
			$sucursal->setCiudad($values[9][1]);
			$sucursal->setCp($values[10][1]);
			$sucursal->setEstado($values[11][1]);
			$sucursal->setPais($values[12][1]);
			if(!$sucursal->EditSucursal())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "ok[#]";
				$mySucursal = $sucursal->SucursalInfo();
				echo $mySucursal["rfcId"];				
			}
		break;	
	
}

?>

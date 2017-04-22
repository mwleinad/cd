<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');
$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);

$info = $empresa->Info();
$smarty->assign("info", $info);

switch($_POST["type"])
{
	case "addCliente": 
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->display(DOC_ROOT.'/templates/boxes/agregar-cliente-popup.tpl');
		break;	
		
	case "search": 
			
			if($_POST["valur"] == '')
				$clientes = $cliente->GetClientesByActiveRfc();
			else
				$clientes = $cliente->Search();
						
			$smarty->assign("DOC_ROOT", DOC_ROOT);
			$smarty->assign("clientes", $clientes);			
			$smarty->display(DOC_ROOT.'/templates/lists/cliente.tpl');
			
		break;	
		
	case "saveCliente": 
	
			$cliente->setRazonSocial($_POST["razonSocial"], 0);
			$cliente->setCalleClte($_POST["calle"]);
			$cliente->setNoExt($_POST["noExt"]);
			$cliente->setNoInt($_POST["noInt"]);
			$cliente->setReferencia($_POST["referencia"]);
			$cliente->setColonia($_POST["colonia"]);
			$cliente->setLocalidad($_POST["localidad"]);
			$cliente->setMunicipio($_POST["municipio"]);
			$cliente->setCiudadClte($_POST["ciudad"]);
			$cliente->setCp($_POST["cp"]);
			$cliente->setEstado($_POST["estado"]);
			$cliente->setPais($_POST["pais"]);
			$cliente->setRfc($_POST["rfc"]);
			$cliente->setEmpresaId($_SESSION["empresaId"], 1);
			$cliente->setEmailClte($_POST["email"]);
			$cliente->setPasswordClte($_POST["password"]);
			$cliente->setTelefono($_POST["telefono"]);
			$cliente->setRfcId($cliente->getRfcActive());
			$cliente->setEMailDirector($_POST["emailDirector"]);
			$cliente->setEMailAdmin($_POST["emailAdmin"]);
			
			if($info["moduloEscuela"] == "Si")
			{
				$cliente->setNoControl($_POST["noControl"]);
				$cliente->setCarrera($_POST["carrera"]);
			}
			
			$userId = $cliente->AddCliente();
			
			if(!$userId)
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				$cliente->setUserId($userId);
				$cliente->SendInfoClte();
												
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$clientes = $cliente->GetClientesByActiveRfc();
				$smarty->assign("clientes", $clientes);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/cliente.tpl');
			}
		break;	
		
	case "deleteCliente":
			$cliente->setuserId($_POST['id']);
			
			if($cliente->DeleteCliente())
			{
				echo "Ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				echo "[#]";
				$clientes = $cliente->GetClientesByActiveRfc();
				$smarty->assign("clientes", $clientes);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/cliente.tpl');
			}
			break;
			
	case "editCliente":
		$smarty->assign("DOC_ROOT", DOC_ROOT);
		$cliente->setUserId($_POST['id']);
		$myCliente = $cliente->InfoCliente();
		$smarty->assign("post", $myCliente);
		$smarty->display(DOC_ROOT.'/templates/boxes/edit-cliente-popup.tpl');
		break;
		
	case "saveEditCliente": 
	
			$cliente->setUserId($_POST['userId']);
			$myCliente = $cliente->InfoCliente();
			$cliente->setRazonSocial($_POST["razonSocial"], 0);
			$cliente->setCalleClte($_POST["calle"]);
			$cliente->setNoExt($_POST["noExt"]);
			$cliente->setNoInt($_POST["noInt"]);
			$cliente->setReferencia($_POST["referencia"]);
			$cliente->setColonia($_POST["colonia"]);
			$cliente->setLocalidad($_POST["localidad"]);
			$cliente->setMunicipio($_POST["municipio"]);
			$cliente->setCiudadClte($_POST["ciudad"]);
			$cliente->setCp($_POST["cp"]);
			$cliente->setEstado($_POST["estado"]);
			$cliente->setPais($_POST["pais"]);
			$cliente->setEmpresaId($_SESSION["empresaId"], 1);
			$cliente->setTelefono($_POST["telefono"]);
			$cliente->setRfcId($cliente->getRfcActive());
			$cliente->setEMailDirector($_POST["emailDirector"]);
			$cliente->setEMailAdmin($_POST["emailAdmin"]);

			if($info["moduloEscuela"] == "Si")
			{
				$cliente->setNoControl($_POST["noControl"]);
				$cliente->setCarrera($_POST["carrera"]);
			}

			if($myCliente["email"] != $_POST["email"])
			{
				$cliente->setEmailClte($_POST["email"]);
			}

			if($myCliente["rfc"] != $_POST["rfc"])
			{
				$cliente->setRfc($_POST["rfc"]);
			}
			
			if($_POST["password"])
			{
				$cliente->setPasswordClte($_POST["password"]);
			}
			$cliente->setTelefono($_POST["telefono"]);
			$cliente->setRfcId($cliente->getRfcActive());
			if(!$cliente->EditCliente())
			{
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
			}
			else
			{
				echo "ok[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status_on_popup.tpl');
				echo "[#]";
				$clientes = $cliente->GetClientesByActiveRfc();
				$smarty->assign("clientes", $clientes);
				$smarty->assign("DOC_ROOT", DOC_ROOT);
				$smarty->display(DOC_ROOT.'/templates/lists/cliente.tpl');
			}
			
		break;	

}

?>

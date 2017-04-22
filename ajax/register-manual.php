<?php
include_once('../init.php');
include_once('../config.php');
include_once(DOC_ROOT.'/libraries.php');

$smarty->assign("permisos",$_SESSION['permisos2']);
$smarty->assign("nuevosPermisos",$_SESSION['nuevosPermisos2']);
 
switch($_POST['type']){

	case 'savePersonal':
			
			$empresa->setNombre($_POST['nombre']);
			$empresa->setEmailPersonal($_POST['emailPersonal']);
			$empresa->setTelPersonal($_POST['telPersonal']);
			$empresa->setCelular($_POST['celular']);
			
			if($_POST['condicionPersonal'])
				$empresa->setCondicionPersonal(1);
			else
				$empresa->setCondicionPersonal(0);
			
			if($empresa->SaveTemp())
			{
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status2.tpl');
			}else{
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status2.tpl');
			}
						
		break;
	
	case 'saveEmpresa':
			
			$empresa->setRazonSocial($_POST["razonSocial"]);
			$empresa->setCalle($_POST["calle"]);
			$empresa->setNoInt($_POST["noInt"]);
			$empresa->setNoExt($_POST["noExt"]);
			$empresa->setColonia($_POST["colonia"]);
			$empresa->setLocalidad($_POST["localidad"]);
			$empresa->setMunicipio($_POST["municipio"]);
			$empresa->setCiudad($_POST["ciudad"]);
			$empresa->setCp($_POST["cp"]);
			$empresa->setEstado($_POST["estado"]);
			$empresa->setPais($_POST["pais"]);
			$empresa->setTelefono($_POST["telefono"]);
			$empresa->setRfc($_POST["rfc"]);
			$empresa->setRegimenFiscal($_POST["regimenFiscal"]);
			
			if($_POST['condicionEmpresa'])
				$empresa->setCondicionPersonal(1);
			else
				$empresa->setCondicionPersonal(0);
			
			if($empresa->SaveTemp())
			{
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status2.tpl');
			}else{
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status2.tpl');
			}
						
		break;
	
	case 'saveCuenta':
			
			$productId = $_POST['productId'];
						
			$empresa->setEmail($_POST["email"]);
			$empresa->setPassword($_POST["password"]);
			$empresa->setProductId($productId);
			
			if($productId){
				if($productId == 'v3' || $productId == 'construc')
					$empresa->setFolios($_POST["folios"]);
			}			
			
			$empresa->setSocioId($_POST["socioId"]);
			
			if($_POST["socioId"] == "39")
			{
				$_POST["fromBraun"] = "Si";
			}
			
			if($empresa->SaveRegister2())
			{
				
				$empresa->setNombre($_POST['nombre']);
				$empresa->setEmailPersonal($_POST['emailPersonal']);
				$empresa->setTelPersonal($_POST['telPersonal']);
				$empresa->setCelular($_POST['celular']);
				$empresa->setRazonSocial($_POST["razonSocial"]);
				$empresa->setCalle($_POST["calle"]);
				$empresa->setNoInt($_POST["noInt"]);
				$empresa->setNoExt($_POST["noExt"]);
				$empresa->setColonia($_POST["colonia"]);
				$empresa->setLocalidad($_POST["localidad"]);
				$empresa->setMunicipio($_POST["municipio"]);
				$empresa->setCiudad($_POST["ciudad"]);
				$empresa->setCp($_POST["cp"]);
				$empresa->setEstado($_POST["estado"]);
				$empresa->setPais($_POST["pais"]);
				$empresa->setTelefono($_POST["telefono"]);
				$empresa->setRfc($_POST["rfc"]);
				$empresa->setRegimenFiscal($_POST["regimenFiscal"]);
				
				$empresa->Register();
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status3.tpl');
			}else{
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status3.tpl');
			}
						
		break;
		
	case 'saveCuentaNew':
			
			$productId = 'v3';
			$_POST["productId"] = 'v3';						
			$empresa->setRfc($_POST["email"]);
			$empresa->setEmail($_POST["email"]);
			$empresa->setPassword($_POST["password"]);
			$empresa->setNombre($_POST['nombre']);
			$empresa->setEmailPersonal($_POST['email']);
			$empresa->setTelPersonal($_POST['telPersonal']);
			$empresa->setCelular($_POST['celular']);
//			$empresa->setRfc($_POST["rfc"]);
			
			if($_POST['condicionPersonal'])
				$empresa->setCondicionPersonal(1);
			else
				$empresa->setCondicionPersonal(0);
			
			$_POST["socioId"] = "39";			
			$empresa->setSocioId(39);
			$_POST["interno"] = 'No';
			$_POST["fromBraun"] = 'Si';
			
			if($empresa->SaveRegister2())
			{
//				$empresa->setNombre($_POST['nombre']);
//				$empresa->setRazonSocial($_POST["razonSocial"]);
//				$empresa->setCalle($_POST["calle"]);
//				$empresa->setNoInt($_POST["noInt"]);
//				$empresa->setNoExt($_POST["noExt"]);
//				$empresa->setColonia($_POST["colonia"]);
//				$empresa->setLocalidad($_POST["localidad"]);
//				$empresa->setMunicipio($_POST["municipio"]);
//				$empresa->setCiudad($_POST["ciudad"]);
//				$empresa->setCp($_POST["cp"]);
//				$empresa->setEstado($_POST["estado"]);
//				$empresa->setPais($_POST["pais"]);
//				$empresa->setTelefono($_POST["telefono"]);
//				$empresa->setRegimenFiscal($_POST["regimenFiscal"]);
				
				$empresa->Register();
				echo 'ok[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status3.tpl');
			}else{
				echo 'fail[#]';
				$smarty->display(DOC_ROOT.'/templates/boxes/status3.tpl');
			}
						
		break;		

	case 'saveRegister':
	
		$empresa->setEmail($_POST["email"]);
		$empresa->setPassword($_POST["password"]);
		$empresa->setCalle($_POST["calle"]);
		
		$empresa->setEstado($_POST["estado"]);
		$empresa->setPais($_POST["pais"]);
		$empresa->setRazonSocial($_POST["razonSocial"], 0);
		$empresa->setNoInt($_POST["noInt"]);
		$empresa->setNoExt($_POST["noExt"]);
		$empresa->setReferencia($_POST["referencia"]);
		$empresa->setLocalidad($_POST["localidad"]);
		$empresa->setMunicipio($_POST["municipio"]);
		$empresa->setCp($_POST["cp"]);
		$empresa->setProductId($_POST["productId"]);
		$empresa->setRfc($_POST["rfc"]);
		$empresa->setFolios($_POST["folios"]);
		$empresa->setTelefono($_POST["telefono"]);
		$empresa->setRegimenFiscal($_POST["regimenFiscal"]);
		
		//print_r($_POST["proveedorId"]);
		$usuario->setEmailProveedor($_POST["proveedorId"]);
		$usuarioId = $usuario->GetUsuarioIdByEmail();
																	
		$empresa->setProveedorId($usuarioId);
		$empresa->setSocioId($_POST["socioId"]);
		
		if(!$empresa->Register())
		{
			echo "fail|";
			$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
			exit();		
		}
		else
		{
			echo "ok|";
		}
		
		echo '<!-- Google Code for Registration Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1012846898;
var google_conversion_language = "es";
var google_conversion_format = "1";
var google_conversion_color = "ffffff";
var google_conversion_label = "w8_hCP6K2gMQsqL74gM";
var google_conversion_value = 10;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1012846898/?value=10&amp;label=w8_hCP6K2gMQsqL74gM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>';

		$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
	
	break;

}

?>

<?php
		
//	$empresa->AuthUser();
	
	$info = $empresa->Info();
	$smarty->assign('info', $info);
	$smarty->assign("post", $info);
	
	$empresa->Util()->DB()->setQuery('SELECT * FROM usuarios');
	$result = $empresa->Util()->DB->GetResult();
	
	if($_POST['accion'] == 'guardar_certificado'){
		$error = array();
		if(!$_POST["nombrePer"])
		{
			$error[] = "Por favor proporcionanos un nombre de contacto";
		}

		if(!$_POST["emailPer"])
		{
			$error[] = "Por favor proporcionanos un correo de contacto";
		}

		$facturase = strpos($_POST["emailPer"], "facturase");
		if($facturase > 0)
		{
			$error[] = "Por favor utiliza un correo real, para estar en comunicacion. No puede tener la palabra Facturase";
		}


		if(!$_POST["telefono"] || strlen($_POST["telefono"]) < 10)
		{
			$error[] = "Por favor proporciona el telefono de la empresa. 10 Digitos SIN espacios (ej: 9616027650)";
		}

		if(!$_POST["telefonoPer"] || strlen($_POST["telefonoPer"]) < 10)
		{
			$error[] = "Por favor proporciona un telefono de contacto. 10 Digitos SIN espacios (ej: 9616027650)";
		}
		
		if(!$_POST["celularPer"] || strlen($_POST["celularPer"]) < 10)
		{
			$error[] = "Por favor proporciona un celular de contacto.  10 Digitos SIN espacios (ej: 9616027650)";
		}
		
		if(count($error) == 0)
		{
			$main->ActualizarDatos();
			$success[] = "Has actualizado tus datos, ahora puedes seguir utilizando el sistema. Muchas gracias";
			$info = $empresa->Info();
			$smarty->assign("info", $info);

		}
			$smarty->assign("post", $_POST);
					
	}//if Guardar Certificado

	$smarty->assign('socios', $result);
	$smarty->assign('error', $error);
	$smarty->assign('success', $success);
	
?>
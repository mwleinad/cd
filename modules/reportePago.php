<?php
		
//	$empresa->AuthUser();
	
	$info = $empresa->Info();
	$smarty->assign('info', $info);
	$smarty->assign("post", $info);
	
	$empresa->Util()->DB()->setQuery('SELECT * FROM usuarios');
	$result = $empresa->Util()->DB->GetResult();


	if($_POST['accion'] == 'guardar_certificado'){
		$error = array();

		if(count($_FILES["comprobante"]) == 0 && $info["interno"] == "No")
		{
			$error[] = "Por favor suba su ficha de pago";			
		}
	//	print_r($_SESSION);
//		exit;
		if(!$_POST["fecha"] && $_POST["interno"] == "No")
		{
			$error[] = "Por favor proporcionanos la fecha del deposito";
		}

		if(!$_POST["autorizacion"]  && $_POST["interno"] == "No")
		{
			$error[] = "Por favor proporcionanos el numero de autorizacion de su pago";
		}

		if(count($error) == 0)
		{
			$main->ReportarPago();
			$success[] = "Has reportado un pago, gracias! En un maximo de 24 horas veras reflejado los servicios correspondientes a tu pago";
			$info = $empresa->Info();
			$smarty->assign("info", $info);

		}
			$smarty->assign("post", $_POST);
					
	}//if Guardar Certificado

	$smarty->assign('socios', $result);
	$smarty->assign('error', $error);
	$smarty->assign('success', $success);
	
?>
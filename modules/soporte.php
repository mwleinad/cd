<?php

if($_POST)
{
	$subject = $_POST["asunto"];
	$body = $_POST["mensaje"];
	
	$info = $empresa->Info();
	
	$sql = "SELECT * FROM rfc";

	$util->DBSelect($_SESSION["empresaId"])->setQuery($sql);
	$empresa = $util->DBSelect($_SESSION["empresaId"])->GetRow();
	
	if(strlen($body) < 10)
	{
		$message = "Danos mas detalles acercad de tu problema, por favor";
	}
	else
	{
		$body .= "\n\nSolicitud de:\n";
		$body .= "Nombre: ".$info["nombrePer"]."\n";
		$body .= "Email: ".$info["emailPer"]."\n";
		$body .= "Telefono: ".$info["telefonoPer"]."\n";
		$body .= "Empresa: ".$empresa["razonSocial"]."\n";
		$body .= "RFC: ".$empresa["rfc"]."\n";
	
		$sendMail = new SendMail();	
		$sendMail->Prepare($subject, $body, $to = "comprobantefiscal@braunhuerin.com.mx", $toName = "Director");
		$message = "Has enviado una solicitud de soporte, Te responderemos lo mas pronto posible. Gracias";
	}
	
	$smarty->assign('errMsg', $message);
	
}

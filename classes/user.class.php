<?php

class User extends Sucursal
{
	protected $userId = NULL;
	
	public function setUserId2($value, $checkIfExists = 0, $usId = -1)
	{
		if($usId < 0)
		{
			$empresa["empresaId"] = $_SESSION['empresaId'];
		}else
		{
			$empresa = $this->Info($usId);
		}
		$this->Util()->ValidateInteger($value);
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT COUNT(*) FROM cliente WHERE userId ='".$value."' AND empresaId = ".$empresa["empresaId"]);
		if($checkIfExists)
		{
			if($this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle() <= 0)
			{
				$this->Util()->setError(10030, "error", "");
				return;
			}
		}
		else
		{
			if($this->Util()->DB()->GetSingle() > 0)
			{
				$this->Util()->setError(10030, "error", "");
				return;
			}
		}
		$this->userId = $value;
	}
	
	public function setUserId($value, $checkIfExists = 0)
	{
		$empresa = $this->Info();
		$this->Util()->ValidateInteger($value);
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT COUNT(*) FROM cliente WHERE userId ='".$value."' AND empresaId = ".$empresa["empresaId"]);
		if($checkIfExists)
		{
			if($this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle() <= 0)
			{
				$this->Util()->setError(10030, "error", "");
				return;
			}
		}
		else
		{
			if($this->Util()->DB()->GetSingle() > 0)
			{
				$this->Util()->setError(10030, "error", "");
				return;
			}
		}
		$this->userId = $value;
	}
	
	function setUserIdAPI($value){
		$this->Util()->ValidateInteger($value);
		$this->userId = $value;
	}

	public function getUserId()
	{
		return $this->userId;
	}

	//private functions
	function GetUserInfo()
	{
		if(!$this->userId){
			$this->userId = 0;
		}

		$sql = "SELECT * FROM cliente WHERE userId = ".$this->userId;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		return $row;
	}

	//private functions
	public function GetUserIdBy($value, $field = "username")
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT userId FROM cliente WHERE ".$field."='".$value."'");
		return $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
	}

	public function Suggest($value)
	{
		$this->Util()->DBSelect($this->getEmpresaId())->setQuery("SELECT userId, nombre, rfc FROM cliente WHERE rfcId = '".$this->getRfcId()."' AND (rfc LIKE '%".$value."%' OR nombre LIKE '%".$value."%') ORDER BY nombre LIMIT 15");
		$result =  $this->Util()->DBSelect($this->getEmpresaId())->GetResult();
		
		return $result;
	}
	
	public function SendComprobante($id_comprobante){
		
		global $comprobante;
		
		$compInfo = $comprobante->GetInfoComprobante($id_comprobante);
				
		$id_cliente = $compInfo['userId'];
		$this->setUserId($id_cliente, 1);
		$usrInfo = $this->GetUserInfo();
		
		$nombre = $usrInfo['nombre'];
		$email = $usrInfo['email'];
		
		$email = preg_replace('!\s+!', ' ', $email);
		$email = str_replace(";",",", $email);
		$email = str_replace(" ",",", $email);
		$emails = explode(",", $email);

		$email = $usrInfo['emailAdmin'];
		
		$email = preg_replace('!\s+!', ' ', $email);
		$email = str_replace(";",",", $email);
		$email = str_replace(" ",",", $email);
		$emailsAdmin = explode(",", $email);

		$email = $usrInfo['emailDirector'];
		
		$email = preg_replace('!\s+!', ' ', $email);
		$email = str_replace(";",",", $email);
		$email = str_replace(" ",",", $email);
		$emailsDirector = explode(",", $email);
		
		$emails = array_merge($emails, $emailsAdmin, $emailsDirector);

		/*** Archivo PDF ***/
		
		$id_rfc = $compInfo['rfcId'];
		$id_empresa = $compInfo['empresaId'];
		$serie = $compInfo['serie'];
		$folio = $compInfo['folio'];
		
		$archivo = $id_empresa.'_'.$serie.'_'.$folio.'.pdf';
				
		$enlace = DOC_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/pdf/'.$archivo; 


		if($_SESSION["version"] == "v3" || $_SESSION["version"] == "construc")
		{
			$archivo_xml = "SIGN_".$id_empresa.'_'.$serie.'_'.$folio.'.xml';
		}
		else
		{
			$archivo_xml = $id_empresa.'_'.$serie.'_'.$folio.'.xml';
		}

		$enlace_xml = DOC_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/facturas/xml/'.$archivo_xml; 
		
		/*** End Archivo PDF ***/
		//print_r($_SESSION);	
		$empresa = new Empresa;
		$info = $empresa->GetPublicEmpresaInfo();
		//print_r($info);
		$mail = new PHPMailer();
//		$mail->Host = 'localhost';
		$mail->IsSMTP(); 
		
		$mail->SMTPAuth = true; 
    //$mail->SMTPSecure = "false";

		$mail->Host = SMTP_HOST;
		$mail->Username = SMTP_USER;
		$mail->Password = SMTP_PASS;
		$mail->Port = SMTP_PORT;
		//print_r($mail);
		//$mail->SMTPSecure = "ssl";
		$mail->From = "comprobantefiscal@braunhuerin.com.mx";

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT razonSocial FROM rfc WHERE empresaId ='".$_SESSION["empresaId"]."'");
		
		$razonSocial = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		$razonSocial = urldecode($razonSocial);
		
		$mail->FromName = urldecode($info["razonSocial"]);
		$mail->Subject = 'Envio de Factura con Folio ['.$serie.$folio.']';
		
		if(strpos($_SESSION["loginKey"], "@") > 0)
		{
			$mail->addReplyTo($_SESSION["loginKey"], urldecode($info["razonSocial"]));
		}
		
		foreach($emails as $email)
		{
			if($email == "")
			{
				continue;
			}
			$mail->AddAddress($email, $nombre);
		}
		
		$body = "Favor de revisar el archivo adjunto para ver su factura.\r\n";
		$body .= "\r\n";
		$body .= "Gracias.\r\n--------------------------------------------------------------\n";
		
		$body .= "Si esta interesado en nuestro sistema de Facturacion enviar un correo a comprobantefiscal@braunhuerin.com.mx\r\n";
		$body .= "\r\n";
		$body .= "www.comprobantedigital.mx\r\n";
		$mail->Body = $body;
		//adjuntamos un archivo
		$mail->AddAttachment($enlace, 'Factura_'.$folio.'.pdf');
		$mail->AddAttachment($enlace_xml, 'XML_Factura_'.$folio.'.xml');
		$mail->Send();
				
		$this->Util()->setError(20023, 'complete');
		
		$this->Util()->PrintErrors();
	
	}//SendComprobante

}

?>

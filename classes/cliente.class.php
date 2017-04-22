<?php

class Cliente extends Sucursal
{
	private $telefono;
	private $email;
	private $userId;
	private $rfcId;
	private $password;
	private $calle;
	private $ciudad;
	private $carrera;
	private $noControl;
	private $emailDirector;
	private $emailAdmin;

	public function setNoControl($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "No Control");
		$this->noControl = $value;
	}

	public function setCarrera($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "Carrera");
		$this->carrera = $value;
	}
	
	public function setRfc($value)
	{
		$this->Util()->ValidateString($value, $max_chars=17, $minChars = 12, "RFC");
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT COUNT(*) FROM cliente WHERE rfc ='".$value."'");
		$value = str_replace("-", "", $value); 
		$value = str_replace("/", "", $value); 
		$value = str_replace(" ", "", $value); 
		$value = strtoupper($value); 
		$rfc = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		$this->rfc = $value;
	}
	
	public function setRfcLogin($value)
	{
		$this->Util()->ValidateString($value, $max_chars=17, $minChars = 12, "RFC");
		$this->rfc = $value;
	}	

	public function getRfc()
	{
		return $this->rfc;
	}

	public function setEmail($value)
	{
		$this->email = $value;
	}

	
	public function setEmailClte($value)
	{
		if(trim($value) == '')
			return;
			
		$this->email = $value;
	}
	
	public function setEMailDirector($value)
	{
		$this->emailDirector = $value;
	}

	public function setEMailAdmin($value)
	{
		$this->emailAdmin = $value;
	}
	
	
	public function setPasswordClte($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Contrase&ntilde;a");
		$this->password = $value;
	}
	
	public function setCalleClte($value)
	{
		$this->Util()->ValidateRequireField($value, 'Direcci&oacute;n');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, '');
		$this->calle = $value;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setTelefono($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Telefono");
		$this->telefono = $value;
	}
	
	public function getTelefono()
	{
		return $this->telefono;
	}	

	public function setUserId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->userId = $value;
	}
	
	public function getUserId()
	{
		return $this->userId;
	}
	
	public function setCiudadClte($value){
	
		$this->Util()->ValidateRequireField($value, 'Ciudad');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, '');
		$this->ciudad = $value;
		
	}
	
	function GetClientesByEmpresa()
	{

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM cliente WHERE empresaId ='".$this->getEmpresaId()."'");
		//echo $this->Util()->DBSelect($this->empresaId)->query;
		$empresaClientes = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
	
		return $empresaClientes;
	}

	function GetClientesByActiveRfc()
	{
		$activeRfc =  $this->getRfcActive();
		
		$sql = "SELECT COUNT(*) FROM cliente WHERE rfcId = '".$activeRfc."' AND baja = '0'";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/cliente");

		$sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];

		$sql = "SELECT * FROM cliente WHERE rfcId = '".$activeRfc."' AND baja = '0' ".$sqlAdd;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$empresaClientes = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();

		$data["items"] = $empresaClientes;
		$data["pages"] = $pages;

		return $data;
	}

	function GetCountClientesByActiveRfc()
	{
		$activeRfc =  $this->getRfcActive();

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT COUNT(*) FROM cliente WHERE rfcId ='".$activeRfc."'");
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		return $total;
	}

	function AddCliente()
	{
		global $info;
		if($this->Util()->PrintErrors()){ return false; }
		
		if($info["moduloEscuela"] == "Si")
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
				INSERT INTO `cliente` ( 
					`empresaId`, 
					`rfc`, 
					`nombre`, 
					`pais`, 
					`calle`,
					`noInt`, 
					`noExt`, 
					`referencia`, 
					`colonia`, 
					`localidad`, 
					`municipio`,
					`ciudad`,
					`estado`, 
					`cp`,
					`email`,
					`telefono`,
					`rfcId`,
					`noControl`,
					`carrera`,
					`emailAdmin`,
					`emailDirector`,
					`password`
					) 
				VALUES (
					'".$this->getEmpresaId()."',
					'".$this->rfc."',
					'".$this->getRazonSocial()."',
					'".$this->getPais()."',
					'".$this->calle."',
					'".$this->getNoInt()."',
					'".$this->getNoExt()."',
					'".$this->getReferencia()."',
					'".$this->getColonia()."',
					'".$this->getLocalidad()."',
					'".$this->getMunicipio()."',
					'".$this->ciudad."',
					'".$this->getEstado()."',
					'".$this->getCp()."',
					'".$this->getEmail()."',
					'".$this->getTelefono()."',
					'".$this->getRfcId()."',
					'".$this->noControl."',
					'".$this->carrera."',
					'".$this->emailAdmin."',
					'".$this->emailDirector."',
					'".$this->getPassword()."'
					)"
				);
		}
		else
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
				INSERT INTO `cliente` ( 
					`empresaId`, 
					`rfc`, 
					`nombre`, 
					`pais`, 
					`calle`,
					`noInt`, 
					`noExt`, 
					`referencia`, 
					`colonia`, 
					`localidad`, 
					`municipio`,
					`ciudad`,
					`estado`, 
					`cp`,
					`email`,
					`emailAdmin`,
					`emailDirector`,
					`telefono`,
					`rfcId`,
					`password`
					) 
				VALUES (
					'".$this->getEmpresaId()."',
					'".$this->rfc."',
					'".$this->getRazonSocial()."',
					'".$this->getPais()."',
					'".$this->calle."',
					'".$this->getNoInt()."',
					'".$this->getNoExt()."',
					'".$this->getReferencia()."',
					'".$this->getColonia()."',
					'".$this->getLocalidad()."',
					'".$this->getMunicipio()."',
					'".$this->ciudad."',
					'".$this->getEstado()."',
					'".$this->getCp()."',
					'".$this->getEmail()."',
					'".$this->emailAdmin."',
					'".$this->emailDirector."',
					'".$this->getTelefono()."',
					'".$this->getRfcId()."',
					'".$this->getPassword()."'
					)"
				);			
		}
		
		$clienteId = $this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
		$this->Util()->setError(20020, "complete");
		$this->Util()->PrintErrors();
		
		return $clienteId;
	}

	function DeleteCliente()
	{
		$sql = "UPDATE cliente SET baja = '1' WHERE userId = '".$this->userId."'";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		$this->Util()->setError(20021, "complete");
		$this->Util()->PrintErrors();
		
		return true;
	}
	
	function InfoCliente()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM cliente WHERE userId ='".$this->userId."'");
		$cliente = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
	
		return $cliente;
	}
	
	function EditCliente()
	{
		global $info;
		if($this->Util()->PrintErrors()){ return false; }
		
		if($this->getEmail())
		{
			$addEmail = " `email` ='".$this->getEmail()."',";
		}

		if($this->getPassword())
		{
			$addPassword = " `password` ='".$this->getPassword()."',";
		}

		if($this->getRfc())
		{
			$addRfc = " `rfc` ='".$this->getRfc()."',";
		}

		if($info["moduloEscuela"] == "Si")
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
				UPDATE `cliente` SET 
					`empresaId` = '".$this->getEmpresaId()."', 
					`nombre` = '".$this->getRazonSocial()."', 
					`pais` = '".$this->getPais()."', 
					`calle` = '".$this->calle."',
					`noInt` = '".$this->getNoInt()."', 
					`noExt` = '".$this->getNoExt()."', 
					`referencia` = '".$this->getReferencia()."', 
					`colonia` = '".$this->getColonia()."', 
					`localidad` = '".$this->getLocalidad()."', 
					`rfcId` = '".$this->getRfcId()."', 
					`telefono` = '".$this->getTelefono()."',
					".$addEmail.$addPassword.$addRfc."
					`municipio` = '".$this->getMunicipio()."', 
					`ciudad` = '".$this->ciudad."', 
					`estado` = '".$this->getEstado()."', 
					`noControl` = '".$this->noControl."', 
					`carrera` = '".$this->carrera."', 
					`emailDirector` = '".$this->emailDirector."', 
					`emailAdmin` = '".$this->emailAdmin."', 
					`cp` = '".$this->getCp()."' 
				WHERE userId = '".$this->userId."' LIMIT 1"
				);
		}
		else
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
				UPDATE `cliente` SET 
					`empresaId` = '".$this->getEmpresaId()."', 
					`nombre` = '".$this->getRazonSocial()."', 
					`pais` = '".$this->getPais()."', 
					`calle` = '".$this->calle."',
					`noInt` = '".$this->getNoInt()."', 
					`noExt` = '".$this->getNoExt()."', 
					`referencia` = '".$this->getReferencia()."', 
					`colonia` = '".$this->getColonia()."', 
					`localidad` = '".$this->getLocalidad()."', 
					`rfcId` = '".$this->getRfcId()."', 
					`telefono` = '".$this->getTelefono()."',
					".$addEmail.$addPassword.$addRfc."
					`municipio` = '".$this->getMunicipio()."', 
					`ciudad` = '".$this->ciudad."', 
					`estado` = '".$this->getEstado()."', 
					`emailDirector` = '".$this->emailDirector."', 
					`emailAdmin` = '".$this->emailAdmin."', 
					`cp` = '".$this->getCp()."' 
				WHERE userId = '".$this->userId."' LIMIT 1"
				);			
		}
		$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();

		$this->Util()->setError(20022, "complete");
		$this->Util()->PrintErrors();
		
		return true;
	}
	
	function Search()
	{
		global $util;
		
		$activeRfc =  $this->getRfcActive();
		
		$sql = "SELECT * FROM cliente 
				WHERE (nombre LIKE '%".$_POST["valur"]."%' || rfc LIKE '%".$_POST["valur"]."%') 
				AND baja = '0'
				LIMIT 20";		
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$clientes = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();		
		
		$data["items"] = $clientes;
		$data["pages"] = $pages;
		
		return $data;
	}
	
	public function setEmailLogin($value)
	{
		$this->Util()->ValidateMail($value);
		$this->email = $value;
	}
	
	public function setPassword($value)
	{
		$this->Util()->ValidateRequireField($value, "Contrase&ntilde;a");
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Contrase&ntilde;a");
		$this->password = $value;
	}

	public function getPassword()
	{
		return $this->password;
	}
	
	function DoLoginCliente()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		//checar si existe el rfc dentro de nuestros clientes
		$this->Util()->DB()->setQuery("SELECT empresaId FROM empresa");
		$empresas = $this->Util()->DB()->GetResult();
		$myEmpresa = 0;
		foreach($empresas as $empresa)
		{
			$this->Util()->DBSelect($empresa["empresaId"])->setQuery("SELECT COUNT(*) FROM rfc WHERE rfc = '".$this->rfc."'");
			$rows = $this->Util()->DBSelect($empresa["empresaId"])->GetSingle();
			
			if($rows > 0)
			{
				$myEmpresa = $empresa["empresaId"];
				break;
			}
			
		}

		if($myEmpresa == 0)
		{
			$this->Util()->setError(10006, "error", "El RFC no se encuentra registrado con nosotros");
			if($this->Util()->PrintErrors())
			{
				return false;
			}
		}
		
		$this->Util()->DBSelect($myEmpresa)->setQuery("SELECT COUNT(*) FROM cliente WHERE email = '".$this->email."' AND password = '".$this->password."'");
		$rows = $this->Util()->DBSelect($myEmpresa)->GetSingle();
		
		if($rows == 0)
		{
			unset($_SESSION["loginKey"]);
			$this->Util()->setError(10006, "error");
			if($this->Util()->PrintErrors())
			{
				return false;
			}
		}
		$this->Util()->DBSelect($myEmpresa)->setQuery("SELECT * FROM cliente WHERE email = '".$this->email."' AND password = '".$this->password."'");

		$this->Util()->DB()->setQuery("SELECT version FROM empresa WHERE empresaId = '".$myEmpresa."'");
		$version = $this->Util()->DB()->GetSingle();
		
		$login = $this->Util()->DBSelect($myEmpresa)->GetRow();		
		$_SESSION["loginKey"] = $this->email;
		$_SESSION["userId"] = $login["userId"];
		$_SESSION["tipoUsuario"] = "cliente";
		$_SESSION["empresaId"] = $myEmpresa;
		$_SESSION["version"] = $version;
		return true;
	}
	
	function DoLogout()
	{
		unset($_SESSION["loginKey"]);	
		unset($_SESSION["userId"]);
		unset($_SESSION["keyP"]);
		unset($_SESSION["keyNP"]);
		unset($_SESSION["usuarioId"]);
		unset($_SESSION["sucursalId"]);
		unset($_SESSION["version"]);
	}

	function IsLoggedIn()
	{
		if($_SESSION["loginKey"])
		{
			$GLOBALS["smarty"]->assign('user', $this->InfoCliente2());
			return true;
		}
		return false;
	}
	
	function AuthCliente()
	{
		if(!$this->IsLoggedIn())
		{
			$this->Util()->LoadPage('acceso-cliente');
			return;
		}
	}
	
	function InfoCliente2()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM cliente WHERE userId ='".$this->userId."'");
		$cliente = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
	
		return $cliente;
	}
	
	function SendInfoClte(){
		
		global $mail;
		
		$infU = $this->InfoCliente();
				
		if($infU['email'] == '')
			return false;
				
		//Configurando el servidor SMTP
	
		$mail->IsSMTP(); 
		$mail->SMTPAuth = true; 
		$mail->Host = SMTP_HOST; 
		$mail->Username = SMTP_USER; 
		$mail->Password = SMTP_PASS; 
		$mail->Port = SMTP_PORT; 
		
		//Enviamos el mensaje
		
		$email = $infU['email'];
		$subject = 'Información de Registro';
		$message .= 'Estimado Cliente<br><br>';
		$message .= 'Por medio de la presente le confirmamos que su registro fue realizado correctamente.';
		$message .= '<br>Sus datos dados de alta fueron los siguientes:';
		$message .= '<br><br><b>Nombre:</b> '.utf8_decode($infU['nombre']);
		$message .= '<br><b>Dirección:</b> '.utf8_decode($infU['calle']);
		$message .= '<br><b>No. Exterior:</b> '.utf8_decode($infU['noExt']);
		$message .= '<br><b>No. Interior:</b> '.utf8_decode($infU['noInt']);
		$message .= '<br><b>Referencia:</b> '.utf8_decode($infU['referencia']);
		$message .= '<br><b>Colonia:</b> '.utf8_decode($infU['colonia']);
		$message .= '<br><b>Localidad:</b> '.utf8_decode($infU['localidad']);
		$message .= '<br><b>Municipio o Delegación:</b> '.utf8_decode($infU['municipio']);
		$message .= '<br><b>Código Postal:</b> '.utf8_decode($infU['cp']);
		$message .= '<br><b>Estado:</b> '.utf8_decode($infU['estado']);
		$message .= '<br><b>Pais:</b> '.utf8_decode($infU['pais']);
		$message .= '<br><b>Teléfono:</b> '.utf8_decode($infU['telefono']);
		$message .= '<br><b>RFC y Homoclave:</b> '.utf8_decode($infU['rfc']);
		$message .= '<br><b>Correo electrónico:</b> '.$infU['email'];
		$message .= '<br><b>Contraseña:</b> '.$infU['password'];
		$message .= '<br><br>Por su atenci&oacute;n.';
		$message .='<br><br>Gracias.';
		
		$html = '<html>
		<body>
		'.$message.'
		</body>
		</html>';
		
		try {		 
		  $mail->AddAddress($email);

			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT razonSocial FROM rfc WHERE empresaId ='".$_SESSION["empresaId"]."'");
			$razonSocial = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			$razonSocial = urldecode($razonSocial);
			$mail->AddCustomHeader('Reply-to:'.$_SESSION["loginKey"]);

			$mail->AddReplyTo($_SESSION["loginKey"], $razonSocial);
//			$mail->SetFrom('mailbox@email.com', 'Mailbox name');
			if(SITENAME == "CONFACTURA")
			{
			  $mail->SetFrom('contacto@confactura.com.mx', $razonSocial);		  
			}
			else
			{
			  $mail->SetFrom('ventas@pascacio.com.mx', $razonSocial);		  
			}
			
			//$mail->FromName = urldecode(urldecode($razonSocial));
			
		  $mail->Subject = $subject;		 
		  $mail->MsgHTML($html);
		  $mail->Send();
		  		  
		} catch (phpmailerException $e) {
			return false;
		} catch (Exception $e) {
			return false;
		}
		
		return true;
		
	}//SendInfoClte
}


?>
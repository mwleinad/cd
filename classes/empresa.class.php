<?php

class Empresa extends Main
{
	protected $username;
	private $nombre;
	private $emailPersonal;
	private $celular;
	private $telPersonal;
	private $socioComercial;
	
	private $rfc;
	private $razonSocial;
	private $pais;
	private $calle;
	private $noInt;
	private $noExt;
	private $referencia;
	private $colonia;
	private $localidad;
	private $municipio;
	private $ciudad;
	private $estado;
	private $cp;
	private $regimenFiscal;
	private $email;
	private $password;
	private $productId;
	private $empresaId;
	private $sucursalId;
	private $proveedorId;
	private $socioId;
	private $comprobanteId;
	private $motivoCancelacion;
	private $folios;
	private $telefono;
	
	public function setNombre($value)
	{
		$this->Util()->ValidateRequireField($value, 'Nombre Completo');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, 'Nombre Completo');
		$this->nombre = $value;
	}
	
	public function setEmailPersonal($value)
	{
		if($this->Util()->ValidateRequireField($value, 'Email')){
			//if($this->Util()->ValidateEmail($value)){
				/*
				$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM usuario WHERE email ='".$value."'");
				if($this->Util()->DB()->GetSingle() > 0)
				{
					$this->Util()->setError(30002, "error", "");
				}
				*/				
				$this->emailPersonal = $value;
			//}
		}
	}
	
	public function setSocioComercial($value)
	{
		$this->Util()->ValidateRequireField($value, 'N&uacute;mero de Socio');
		$this->socioComercial = $value;
	}
	
	public function setTelefono($value)
	{
		$this->Util()->ValidateRequireField($value, 'Tel&eacute;fono de la Empresa');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "El telefono de la empresa debe de tener Al menos 10 digitos");
		$this->telefono = $value;
	}
	
	public function setTelPersonal($value)
	{
		$this->Util()->ValidateRequireField($value, 'Tel&eacute;fono 2');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Tel&eacute;fono 2");
		$this->telPersonal = $value;
	}
	
	public function setCelular($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Celular");
		$this->celular = $value;
	}
	
	public function setCondicionPersonal($value)
	{
		if($value == 0)
		{
			$this->Util()->setError(30001, "error", "");			
		}
	}
	
	public function getTelefono()
	{
		return $this->telefono;
	}

	public function setFolios($value)
	{
		//$this->Util()->ValidateRequireField($value, 'Folios');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Folios");
		$this->folios = $value;
	}
	
	public function getFolios()
	{
		return $this->folios;
	}

	public function setComprobanteId($value)
	{
		$this->Util()->ValidateString($value, $max_chars=100, $minChars = 1, "ID Comprobante");
		$this->Util()->ValidateInteger($value);
		$this->comprobanteId = $value;
	}
	
	public function getComprobanteId()
	{
		return $this->comprobanteId;
	}
	
	public function setMotivoCancelacion($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 1, "Motivo de Cancelacion");
		$this->motivoCancelacion = $value;
	}
	
	public function getMotivoCancelacion()
	{
		return $this->motivoCancelacion;
	}
	
	public function setProveedorId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->proveedorId = $value;
	}
	
	public function getProveedorId()
	{
		return $this->proveedorId;
	}

	public function setSocioId($value)
	{
		//$this->Util()->ValidateRequireField($value, 'N&uacute;mero de Socio');
		$this->Util()->ValidateInteger($value);
		$this->socioId = $value;
	}
	
	public function getSocioId()
	{
		return $this->socioId;
	}

	public function setEmpresaId($value, $checkIfExists = 0)
	{
		$this->Util()->ValidateInteger($value);
		$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM empresa WHERE empresaId ='".$value."'");
		if($checkIfExists)
		{
			if($this->Util()->DB()->GetSingle() <= 0)
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
		$this->empresaId = $value;
	}

	public function getEmpresaId()
	{
		return $this->empresaId;
	}

	public function setRazonSocial($value, $checkIfExists = 0)
	{
		$this->Util()->ValidateRequireField($value, 'Raz&oacute;n Social');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Raz&oacute;n Social");
		$this->razonSocial = $value;
	}

	public function getRazonSocial()
	{
		return $this->razonSocial;
	}
	
	public function setSucursalId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->sucursalId = $value;
	}
	
	public function getSucursalId()
	{
		return $this->sucursalId;
	}

	public function setCalle($value)
	{
		$this->Util()->ValidateRequireField($value, 'Calle');
		$this->Util()->ValidateString($value, $max_chars=200, $minChars = 0, "Calle");
		$this->calle = $value;
	}
	
	public function getCalle()
	{
		return $this->calle;
	}

	public function setColonia($value)
	{
		$this->Util()->ValidateRequireField($value, 'Colonia');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Colonia");
		$this->colonia = $value;
	}
	
	public function getColonia()
	{
		return $this->colonia;
	}

	public function setReferencia($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Referencia");
		$this->referencia = $value;
	}
	
	public function getReferencia()
	{
		return $this->referencia;
	}

	public function setMunicipio($value)
	{
		$this->Util()->ValidateRequireField($value, 'Municipio');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Municipio");
		$this->municipio = $value;
	}
	
	public function getMunicipio()
	{
		return $this->municipio;
	}
	
	public function setCiudad($value)
	{
		$this->Util()->ValidateRequireField($value, 'Ciudad');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Ciudad");
		$this->ciudad = $value;
	}
	
	public function getCiudad()
	{
		return $this->ciudad;
	}	

	public function setEstado($value)
	{
		$this->Util()->ValidateRequireField($value, 'Estado');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Estado");
		$this->estado = $value;
	}
	
	public function getEstado()
	{
		return $this->estado;
	}	

	public function setPais($value)
	{
		$this->Util()->ValidateRequireField($value, 'Pais');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Pais");
		$this->pais = $value;
	}

	public function getRegimenFiscal()
	{
		return $this->regimenFiscal;
	}	

	public function setRegimenFiscal($value)
	{
		$this->Util()->ValidateRequireField($value, 'R&eacute;gimen Fiscal');
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "R&eacute;gimen Fiscal");
		$this->regimenFiscal = $value;
	}
	
	public function getPais()
	{
		return $this->pais;
	}	

	public function setNoInt($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "No. Int.");
		$this->noInt = $value;
	}
	
	public function getNoInt()
	{
		return $this->noInt;
	}	

	public function setNoExt($value)
	{
		$this->Util()->ValidateRequireField($value, 'No. Exterior');
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "No. Ext.");
		$this->noExt = $value;
	}
	
	public function getNoExt()
	{
		return $this->noExt;
	}	

	public function setLocalidad($value)
	{
		$this->Util()->ValidateRequireField($value, 'Localidad');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Localidad");
		$this->localidad = $value;
	}
	
	public function getLocalidad()
	{
		return $this->localidad;
	}	
	
	public function setRfc($value)
	{
		$value = strtoupper($value);
		$value = str_replace("-", "", $value);
		$value = str_replace("/", "", $value);
		$value = str_replace(" ", "", $value);
		
		$this->Util()->ValidateRequireField($value, 'RFC');
		$this->Util()->ValidateString($value, $max_chars=13, $minChars = 0, "RFC");
		$this->rfc = $value;
	}
	
	public function getRfc()
	{
		return $this->rfc;
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
	
	public function setEmail($value)
	{
		if($this->Util()->ValidateRequireField($value, 'Correo de Acceso')){
			//if($this->Util()->ValidateEmail($value)){				
				$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM usuario WHERE email ='".$value."'");
				if($this->Util()->DB()->GetSingle() > 0)
				{
					$this->Util()->setError(30002, "error", "");
				}				
				$this->email = $value;
			//}
		}
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmailLogin($value)
	{
		//$this->Util()->ValidateMail($value);
		$this->email = $value;
	}

	public function getEmailLogin()
	{
		return $this->email;
	}

	public function setCp($value)
	{
		$this->Util()->ValidateRequireField($value, 'C&oacute;digo Postal');
		$this->Util()->ValidateInteger($value);
		$this->cp = $value;
	}
	
	public function getCp()
	{
		return $this->cp;
	}

	public function setProductId($value)
	{
		$this->Util()->ValidateRequireField($value, 'Producto');
		$this->Util()->ValidateInteger($value);
		$this->productId = $value;
	}
	
	public function getProductId()
	{
		return $this->productId;
	}
	
	public function SaveTemp(){
		
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		
		return true;	
	}
	
	public function SaveRegister2(){
		
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		
		$this->Util()->setError(30003, "complete", "");
		$this->Util()->PrintErrors();
		
		return true;	
	}
	
	function Register()
	{
		print_r($this->Util()->GetErrors());
	
		if($this->Util()->PrintErrors()){ return false; }
		
		//connect to general database
		$generalDb = new DB;
		$generalDb->setSqlDatabase(SQL_DATABASE);
		
		$year = date("Y");
		$month = date("m");
		
		$month = $month + 1;
		if($month == 13)
		{
			$month = 1;
			$year = $year + 1;
		}
		
		$limite = 5;
		$impuestos = "No";
		
		switch($_POST["productId"])
		{
			case "auto": $producto = "auto"; $limite = 0;break;
			case "v3": $producto = "v3";break;
			case "construc": 
				$producto = "construc";
				$impuestos = "Si";
				break;
			case "pro": $producto = "auto"; $this->folios = 50;break;
			
		}
		
		$vencimiento = date('Y-m-d', strtotime("+14 days"));;
		//inserto la empresa, esta es la principal
		
		$rfc = "";
		$razonSocial = "";
		$interno = "";
		if($_POST["fromBraun"] == "Si")
		{
			$rfc = $this->rfc;
			$razonSocial = $this->razonSocial;
			$interno = $_POST["interno"];
			$monto = 580;
			$metodoPago = "Registro Sistema";
			
			if($interno == "Si")
			{
				$monto = 100;
			}
		}
		
		$generalDb->setQuery("
			INSERT INTO `empresa` ( 
				`activo`,
				`activadoEl`,
				`vencimiento`,
				`registerDate`,
				`socioId`,
				`proveedorId`,
				`productId`,
				`limite`,
				`telefono`,
				`version`,
				`nombrePer`,
				`emailPer`,
				`telefonoPer`,
				`moduloImpuestos`,
				`celularPer`,
				`razonSocial`,
				`interno`,
				`rfc`
				) 
			VALUES (
				'1',
				'".date("Y-m-d")."',
				'".$vencimiento."',
				'".date("Y-m-d")."',
				'".$this->socioId."',
				'".$this->proveedorId."',
				'".$this->productId."',
				'".$limite."',
				'".$this->telefono."',
				'".$producto."',
				'".$this->nombre."',
				'".$this->emailPersonal."',
				'".$this->telPersonal."',
				'".$impuestos."',
				'".$this->celular."',
				'".$razonSocial."',
				'".$interno."',
				'".$rfc."'
				)"
			);
		$empresaId = $generalDb->InsertData();
		//inserto la cantidad de folios
		if($this->folios && $interno == "Si")
		{
			$generalDb->setQuery("
				INSERT INTO `ventas` (
				`cantidad` ,
				`fecha` ,
				`idSocio` ,
				`interno` ,
				`rfc` ,
				`razonSocial` ,
				`monto` ,
				`metodoPago` ,
				`idEmpresa` ,
				`status`
				) VALUES (
					'".$this->folios."',  
					'".date("Y-m-d")."',  
					'".$this->socioId."',  
					'".$interno."',  
					'".$rfc."',  
					'".$razonSocial."',  
					'".$monto."',  
					'".$metodoPago."',  
					'".$empresaId."',  
					'noPagado')");
			$idVenta = $generalDb->InsertData();
		}
		
			$generalDb->setQuery("
				INSERT INTO `orden` (
				`fecha` ,
				`idSocio` ,
				`idEmpresa` ,
				`status`
				) VALUES (
					'".date("Y-m-d")."',  
					'".$this->socioId."',  
					'".$empresaId."',  
					'noPagado')");
			$generalDb->InsertData();

$nuevosPermisos = 'a%3A11%3A%7Bs%3A8%3A%22usuarios%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A13%3A%22nueva_factura%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A15%3A%22datos_generales%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A13%3A%22nuevos_folios%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A22%3A%22actualizar_certificado%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A8%3A%22impuesto%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A16%3A%22nuevos_productos%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A18%3A%22consultar_facturas%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A7%3A%22cliente%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A11%3A%22nueva_venta%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7Ds%3A14%3A%22reporte_ventas%22%3Ba%3A4%3A%7Bi%3A0%3Bs%3A4%3A%22view%22%3Bi%3A1%3Bs%3A6%3A%22create%22%3Bi%3A2%3Bs%3A4%3A%22edit%22%3Bi%3A3%3Bs%3A6%3A%22delete%22%3B%7D%7D';
$permisos = 'a%3A11%3A%7Bi%3A0%3Bs%3A8%3A%22usuarios%22%3Bi%3A1%3Bs%3A13%3A%22nueva_factura%22%3Bi%3A2%3Bs%3A15%3A%22datos_generales%22%3Bi%3A3%3Bs%3A13%3A%22nuevos_folios%22%3Bi%3A4%3Bs%3A22%3A%22actualizar_certificado%22%3Bi%3A5%3Bs%3A8%3A%22impuesto%22%3Bi%3A6%3Bs%3A16%3A%22nuevos_productos%22%3Bi%3A7%3Bs%3A18%3A%22consultar_facturas%22%3Bi%3A8%3Bs%3A7%3A%22cliente%22%3Bi%3A9%3Bs%3A11%3A%22nueva_venta%22%3Bi%3A10%3Bs%3A14%3A%22reporte_ventas%22%3B%7D';

		//inserto el usuario por default de la empresa, con privilegios de aministrados
		$generalDb->setQuery("
			INSERT INTO `usuario` ( 
				`empresaId`,
				`email`,
				`type`,
				`main`,
				`permisos`,
				`nuevosPermisos`,
				`password`
				) 
			VALUES (
				'".$empresaId."',
				'".$this->email."',
				'admin',
				'si',
				'".$permisos."',
				'".$nuevosPermisos."',
				'".$this->password."')"
			);
		$generalDb->InsertData();

		//creamos la base de datos del usuario en base al id de la empresa generada
		$generalDb->setQuery("CREATE DATABASE IF NOT EXISTS ".DB_PREFIX.$empresaId);
		$generalDb->ExecuteQuery();

		$newDb = new DB;
		$newDb->setSqlDatabase(DB_PREFIX.$empresaId);

		//creamos las tablas necesarioas en la nueva base de datos
		include_once(DOC_ROOT."/classes/db_script.php");
		
		//insertamos el rfc principal
		$newDb->SetQuery("
			INSERT INTO `rfc` ( 
				`empresaId`, 
				`rfc`, 
				`razonSocial`, 
				`pais`, 
				`calle`,
				`noInt`, 
				`noExt`, 
				`referencia`, 
				`colonia`, 
				`localidad`, 
				`municipio`, 
				`estado`, 
				`regimenFiscal`, 
				`activo`, 
				`main`, 
				`cp`
				) 
			VALUES (
				'".$empresaId."',
				'".$this->rfc."',
				'".$this->razonSocial."',
				'".$this->pais."',
				'".$this->calle."',
				'".$this->noInt."',
				'".$this->noExt."',
				'".$this->referencia."',
				'".$this->colonia."',
				'".$this->localidad."',
				'".$this->municipio."',
				'".$this->estado."',
				'".$this->regimenFiscal."',
				'si',
				'si',
				'".$this->cp."')"
			);
		$rfcId = $newDb->InsertData();

		//insertamos la sucursal matriz principal para ese RFC
		$newDb->SetQuery("
			INSERT INTO `sucursal` ( 
				`empresaId`, 
				`rfcId`, 
				`identificador`,
				`sucursalActiva`
			) 
			VALUES (
				'".$empresaId."',
				'".$rfcId."',
				'matriz',
				'si'
				)"
			);

		$newDb->InsertData();
		
		//si es interno ponemos todo de ua vez
		if($interno == "Si")
		{
			$generalDb->setQuery("
				UPDATE `ventas` SET status = 'pagado', fechaPagado = '".date("Y-m-d")."' WHERE idVenta = '".$idVenta."'");
			$generalDb->UpdateData();			

			$date = date("Y-m-d");
			$datePost = date("Y-m-d", strtotime($date. " + 1 YEAR"));

			$generalDb->setQuery("
				UPDATE `empresa` SET limite = limite + ".$this->folios.", vencimiento = '".$datePost."' WHERE empresaId = '".$empresaId."'");
			$generalDb->UpdateData();			

		}
		$pac = new Pac;
		$pac->AddClient($this->rfc);
		//creamos el folder del usuario
		//echo DOC_ROOT."/empresas/".$empresaId;
		//echo $empresaId;
		@mkdir(DOC_ROOT."/empresas/".$empresaId, 0777);
		@mkdir(DOC_ROOT."/empresas/".$empresaId, 0777);
		
		//enviar correo
		$subject = 'Se registro una nueva empresa '.$this->razonSocial.' ';
		$body = "Folios ".$this->folios.".\r\n";
		$body .= "Correo ".$this->email.".\r\n";
		$body .= "Ciudad ".$this->municipio.".\r\n";
		$sendMail = new SendMail;
		$sendMail->prepare($subject, $body);
		
		$this->Util()->setError(30003, "complete", "");
		$this->Util()->PrintErrors();
		return true;

	}

	function DoLogin()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		$sql ="SELECT COUNT(*) FROM usuario WHERE email = '".$this->email."' AND password = '".$this->password."'";
		$generalDb = new DB;
		$generalDb->setQuery($sql);
		$rows = $generalDb->GetSingle();
		if($rows == 0)
		{
			unset($_SESSION["loginKey"]);	
			unset($_SESSION["empresaId"]);	
			unset($_SESSION["keyP"]);
			unset($_SESSION["keyNP"]);
			$this->Util()->setError(10006, "error");
			if($this->Util()->PrintErrors())
			{
				return false;
			}
		}
		$generalDb->setQuery("SELECT usuario.sucursalId, usuario.empresaId, empresa.version, empresa.socioId, usuario.permisos, usuario.nuevosPermisos, usuario.usuarioId FROM usuario
			LEFT JOIN empresa ON usuario.empresaId = empresa.empresaId WHERE email = '".$this->email."' AND password = '".$this->password."'");
		
		$login = $generalDb->GetRow();
		$empresaId = $login["empresaId"];
		
		$_SESSION["loginKey"] = $this->email;	
		$_SESSION["empresaId"] = $empresaId;	
		$_SESSION["version"] =  $login["version"];	
		$_SESSION["socioId"] =  $login["socioId"];
		$_SESSION["keyP"] = $login['permisos'];
		$_SESSION["keyNP"] = $login['nuevosPermisos'];
		$_SESSION["usuarioId"] = $login['usuarioId'];
		$_SESSION["sucursalId"] = $login['sucursalId'];
		
		return true;
	}
	
	function CancelarComprobante()
	{
		global $comprobante;
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		$id_comprobante = $this->comprobanteId;
		$motivo_cancelacion = $this->motivoCancelacion;

		
		$sqlQuery = 'SELECT data, conceptos, userId FROM comprobante WHERE comprobanteId = '.$id_comprobante;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sqlQuery);		
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		$data = unserialize(urldecode($row['data']));
		$conceptos = unserialize(urldecode($row['conceptos']));
		
		$_SESSION["conceptos"] = array();
		$_SESSION["conceptos"] = $conceptos;
		$comprobante->CancelarComprobante($data, $id_comprobante, false, $row["userId"], $motivo_cancelacion);
		
//		$this->Util()->setError(20024, "complete");
//		$this->Util()->PrintErrors();
		
		return true;
	}

	function DoLogout()
	{
		unset($_SESSION["loginKey"]);	
		unset($_SESSION["empresaId"]);
		unset($_SESSION["keyP"]);
		unset($_SESSION["keyNP"]);
		unset($_SESSION["usuarioId"]);
		unset($_SESSION["sucursalId"]);
	}

	function IsLoggedIn()
	{
		if($_SESSION["loginKey"])
		{
			$GLOBALS["smarty"]->assign('user', $this->Info());
			return true;
		}
		return false;
	}
	
	function Info($userId = 0)
	{
		$generalDb = new DB;
		
		if($userId == 0)
		{
			$sql = "SELECT *, empresa.rfc AS rfc, empresa.razonSocial AS razonSocial FROM usuario 
					LEFT JOIN empresa ON usuario.empresaId = empresa.empresaId 
					WHERE email = '".$_SESSION["loginKey"]."'";
			$generalDb->setQuery($sql);
		}	
		
		$user = $generalDb->GetRow();
		
		if(!$user)
		{
			return;
		}

		$this->Util()->DBSelect($user["empresaId"])->setQuery("SELECT COUNT(*) FROM comprobante LIMIT 1");			
		$user["expedidos"] = $this->Util()->DBSelect($user["empresaId"])->GetSingle();

		return $user;
	}
	
	function AuthUser()
	{
		if(!$this->IsLoggedIn())
		{
			$this->Util()->LoadPage('login');
			return;
		}
		
		$empresa = $this->GetEmpresaGeneralInfo($_SESSION["empresaId"]);
		if($empresa["activo"] == 0)
		{
			$this->Util()->LoadPage('activar');
			exit();
		}
		//print_r($_POST);
		//echo $_REQUEST["page"];
		//exit;
		if($empresa["actualizado"] == 'No' && (SITENAME == "FACTURASE" OR SITENAME == "PASCACIO"))
		{
			$this->Util()->LoadPage('actualizar');
			exit();
		}
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT COUNT(*) FROM comprobante WHERE empresaId =".$_SESSION["empresaId"]);
		$facturas = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		if($facturas > $empresa["limite"] && $empresa["limite"] > 0)
		{
			$this->Util()->LoadPage('activar');
		}
	}

	function AuthAdmin()
	{
		if(!$this->IsLoggedIn())
		{
			$this->Util()->LoadPage('homepage');
		}
		
		$info = $this->Info();
		if($info["type"] != "admin" && $info["type"] != "moderador")
		{
			$this->Util()->LoadPage('sistema');
		}
	}
	
	function ListSucursales()
	{
		$sql = "SELECT * FROM sucursal WHERE empresaId = ".$this->empresaId." ORDER BY identificador";
		$this->Util()->DB()->setQuery($sql);
		
		$result = $this->Util()->DB()->GetResult();
		
		foreach($result as $key => $periodo)
		{
		}
		return $result;
	}
	
	function ListSucursalesEmpresa()
	{
		$rfc = new Rfc;
		$rfcId = $rfc->getRfcActive();
		//$sql = "SELECT * FROM sucursal WHERE empresaId = ".$this->empresaId." AND sucursalActiva = 'si' ORDER BY identificador";
		$sql = "SELECT * FROM sucursal WHERE empresaId = ".$this->empresaId." and rfcId = '".$rfcId."' ORDER BY identificador";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		foreach($result as $key => $periodo)
		{
		}
		return $result;
	}

	function GetSucursalInfo()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM sucursal WHERE empresaId = ".$this->empresaId." AND sucursalId = ".$this->sucursalId);
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		return $result;
	}

	public function GetEmpresaGeneralInfo($empresaId)
	{
		$generalDb = new DB;
		$generalDb->setQuery("SELECT * FROM empresa WHERE empresaId = '".$empresaId."'");
		$row = $generalDb->GetRow();	

		return $row;
	}	

	function GetPublicEmpresaInfo()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM rfc LIMIT 1");
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		return $result;
	}
	
	function GetCertificadosRestantes()
	{
		$sql = "SELECT * FROM serie WHERE empresaId = '".$_SESSION["empresaId"]."'";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		$total = 0;
		foreach($result as $key => $resCertificado)
		{
			$total += $resCertificado['consecutivo'];
		}

		$sql = "SELECT limite FROM empresa WHERE empresaId = '".$_SESSION["empresaId"]."'";
		$this->Util()->DB()->setQuery($sql);
		$limite = $this->Util()->DB()->GetSingle();
		
		$restante = $limite - $total;
		
		if($restante < 0)
			$restante = 0;
		
		return $restante;
	}
	
	function hasPermission($value)
	{
		$value = str_replace("-","_",$value);
		
		if($value == "admin_productos")
		{
			$value = "nuevos_productos";
		}
		
		$permisos = unserialize(urldecode($_SESSION["keyP"]));

		//TODO check permissions again
/*		if(!in_array($value, $permisos))
		{
			$this->Util()->LoadPage('sistema');
			return;
		}*/
	}
	
	function Ventas()
	{
		$sql = "SELECT * FROM ventas WHERE idEmpresa = '".$_SESSION["empresaId"]."' AND fechaPagado != '' ORDER BY idVenta DESC";
		$this->Util()->DB()->setQuery($sql);
		$result = $this->Util()->DB()->GetResult();

		foreach($result as $key => $res)
		{
			$result[$key]["vigencia"] = date("Y-m-d",strtotime($res["fecha"]."+ 1 YEAR"));
		}		
		
		return $result;
	}	

}//empresa


?>
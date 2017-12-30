<?php

class Usuario extends Sucursal
{
	private $usuarioId;
	private $email;
	private $emailU;
	private $password;
	private $tipo;
	private $sucursalId;
	private $permisos;
	private $nuevosPermisos;
	
	//Nomina
	
	private $nombreCompleto;
	public function setNombreCompleto($value)
	{
		$this->Util()->ValidateRequireField($value, 'Nombre Completo');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, '');
		$this->nombreCompleto = $value;
	}

	private $registroPatronal;
	public function setRegistroPatronal($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Registro Patronal");
		$this->registroPatronal = $value;
	}

	private $numEmpleado;
	public function setNumEmpleado($value)
	{
		$this->Util()->ValidateRequireField($value, 'N&uacute;mero de Empleado');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, '');
		$this->numEmpleado = $value;
	}

	private $curp;
	public function setCurp($value)
	{
		$this->Util()->ValidateRequireField($value, 'CURP');
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, '');
		
		$value = trim($value);
		$value = strtoupper($value);
		
		$this->Util()->ValidarCurp($value);
		$this->curp = $value;
	}

	private $tipoRegimen;
	public function setTipoRegimen($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 1, "Tipo De Regimen");
		$this->tipoRegimen = $value;
	}

	private $numSeguridadSocial;
	public function setNumSeguridadSocial($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Numero de Seguridad Social");
		$this->numSeguridadSocial = $value;
	}

	private $departamento;
	public function setDepartamento($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Departamento");
		$this->departamento = $value;
	}

	private $clabe;
	public function setClabe($value)
	{
		if($value != "")
		{
		//	$this->Util()->ValidateString($value, $max_chars=18, $minChars = 18, "Clabe");
		}
		$this->clabe = $value;
	}

	private $banco;
	public function setBanco($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Banco");
		$this->banco = $value;
	}

	private $fechaInicioRelLaboral;
	public function setFechaInicioRelLaboral($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Fecha Inicio Rel Laboral");
		
		$value = $this->Util->FormatDateMySql($value);
		$this->fechaInicioRelLaboral = $value;
	}
	
	private $puesto;
	public function setPuesto($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Puesto");
		$this->puesto = $value;
	}

	private $tipoContrato;
	public function setTipoContrato($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Tipo Contrato");
		$this->tipoContrato = $value;
	}

	private $tipoJornada;
	public function setTipoJornada($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Tipo jornada");
		$this->tipoJornada = $value;
	}

	private $periodicidadPago;
	public function setPeriodicidadPago($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Periodicidad Pago");
		$this->periodicidadPago = $value;
	}

	private $riesgoPuesto;
	public function setRiesgoPuesto($value)
	{
		$this->Util()->ValidateString($value, $max_chars=300, $minChars = 0, "Riesgo Puesto");
		$this->riesgoPuesto = $value;
	}

	private $salarioBaseCotApor;
	public function setSalarioBaseCotApor($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->salarioBaseCotApor = $value;
	}

	private $salarioDiarioIntegrado;
	public function setSalarioDiarioIntegrado($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->salarioDiarioIntegrado = $value;
	}
	
	function setEmailU($value, $requerido = false){
		
		if($requerido)		{
			$this->Util()->ValidateRequireField($value, 'Email');		
			if(trim($value) == '')
				return;
		}	
		
		$this->Util()->ValidateString($value, $max_chars=100, $minChars = 0, '');
					
		$this->Util()->ValidateMail($value);
		
		$rfcActivo = $this->getRfcActive();
		
		$sql = "SELECT COUNT(*) FROM usuario 
				WHERE email = '".$value."' 
				AND empresaId = '".$_SESSION["empresaId"]."'";
		$this->Util()->DB()->setQuery($sql);
		
		if($this->Util()->DB()->getSingle() > 0)
			$this->Util()->setError(10005, "error", "");
				
		$this->emailU = $value;
	}
	
	/*-----Set Functions -----*/
	
	public function setNuevosPermisos($value)
	{
		$this->nuevosPermisos = $value;
	}
	
	public function setPermisos($value)
	{
		$this->permisos = $value;
	}
	
	public function setSucursalId($value)
	{
		//if(empty($value))
		//	$this->Util()->setError(10049, "error", "");
		$this->sucursalId = $value;
	}
	
	public function setUsuarioId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->usuarioId = $value;
	}
	
	public function setUsuarioDelete($value)
	{
		$this->Util()->DB()->setQuery("SELECT main FROM usuario WHERE usuarioId = '".$value."'");
		if( $this->Util()->DB()->GetSingle() == 'si' )	
		{	
			$this->Util()->setError(10045, "error", "");	
		}
		else	
		{	
			$this->usuarioId = $value;	
		}
	}
	
	public function setTipo($value)
	{
		$this->Util()->ValidateRequireField($value, 'Tipo');
		$this->tipo = $value;
	}
	
	public function setEmailEdition($value, $requerido = false)
	{
		if($requerido){
			$this->Util()->ValidateRequireField($value, 'Email');
			if(trim($value) == '')
				return;
			$this->Util()->ValidateMail($value);
		}
				
		$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM usuario WHERE email ='".$value."' AND usuarioId != ' ".$this->usuarioId."' AND empresaId = '".$_SESSION["empresaId"]."'");
//		echo $this->Util()->DB()->GetSingle();
		if($this->Util()->DB()->GetSingle() > 0)
		{
			$this->Util()->setError(10005, "error", "");
		}
		$this->email = $value;
	}
		
	/*-----Get Functions -----*/
	
	public function getUsuarioId()
	{
		return $this->usuarioId;
	}
	
	public function getTipo()
	{
		return $this->tipo;
	}
	
	public function getEmailEdition()
	{
		return $this->email;
	}
	
	public function GetUsuariosByEmpresa($empresaId = 0)
	{
		if ( !$empresaId )	{	$empresaId = $this->getEmpresaId();	}
		$this->Util()->DB()->setQuery("SELECT * FROM usuario 
		WHERE empresaId ='".$empresaId."'");
		$empresaUsuarios = $this->Util()->DB()->GetResult();
		
		$nomina = new Nomina;
		foreach($empresaUsuarios as $key => $val)
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT identificador FROM sucursal WHERE sucursalId = '".$val["sucursalId"]."'");
			$empresaUsuarios[$key]["sucursal"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			if(!$empresaUsuarios[$key]["sucursal"])
			{
				$empresaUsuarios[$key]["sucursal"] = "Todas";
			}
			
			//calculo de nomina
			$miNomina = unserialize(urldecode($val["nomina"]));
			$totalDesglosado = $nomina->GetTotalDesglosado($miNomina[0], $miNomina[1]);
			
			$empresaUsuarios[$key]["totalNomina"] = $totalDesglosado["total"];
		}
		
		return $empresaUsuarios;
	}
	
	public function InfoUsuario()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM usuario WHERE usuarioId ='".$this->usuarioId."'");
		$usuario = $this->Util()->DB()->GetRow();
		
		$usuario["fechaInicioRelLaboralFormat"] = $this->Util()->FormatDateMySql($usuario["fechaInicioRelLaboral"]);
		$usuario["nombre"] = $usuario["nombreCompleto"];
	
		return $usuario;
	}
	
	public function AddUsuario()
	{
		if($this->Util()->PrintErrors()){ return false; }

		$this->Util()->DB()->setQuery("
			INSERT INTO `usuario` ( 
				`empresaId`,
				`email`, 
				`password`, 
				`type`,
				`sucursalId`,
				`nombreCompleto`,
				`registroPatronal`,
				`numEmpleado`,
				`curp`,
				`tipoRegimen`,
				`numSeguridadSocial`,
				`departamento`,
				`clabe`,
				`banco`,
				`fechaInicioRelLaboral`,
				`puesto`,
				`tipoContrato`,
				`tipoJornada`,
				`periodicidadPago`,
				`salarioBaseCotApor`,
				`riesgoPuesto`,
				`salarioDiarioIntegrado`,
				`rfc`,
				`calle`,
				`noExt`,
				`noInt`,
				`colonia`,
				`municipio`,
				`cp`,
				`estado`,
				`localidad`,
				`pais`,
				`permisos`
				) 
			VALUES (
				'".$this->getEmpresaId()."',
				'".$this->emailU."',
				'".$this->getPassword()."',
				'".$this->tipo."',
				'".$this->sucursalId."',
				'".$this->nombreCompleto."',
				'".$this->registroPatronal."',
				'".$this->numEmpleado."',
				'".$this->curp."',
				'".$this->tipoRegimen."',
				'".$this->numSeguridadSocial."',
				'".$this->departamento."',
				'".$this->clabe."',
				'".$this->banco."',
				'".$this->fechaInicioRelLaboral."',
				'".$this->puesto."',
				'".$this->tipoContrato."',
				'".$this->tipoJornada."',
				'".$this->periodicidadPago."',
				'".$this->salarioBaseCotApor."',
				'".$this->riesgoPuesto."',
				'".$this->salarioDiarioIntegrado."',
				'".$this->getRfc()."',
				'".$this->getCalle()."',
				'".$this->getNoExt()."',
				'".$this->getNoInt()."',
				'".$this->getColonia()."',
				'".$this->getmunicipio()."',
				'".$this->getCp()."',
				'".$this->getEstado()."',
				'".$this->getLocalidad()."',
				'".$this->getPais()."',
				'".$this->permisos."')"
			);
		
		$usuarioId = $this->Util()->DB()->InsertData();
		
		$this->Util()->setError(20017, "complete", "Has creado un nuevo empleado");
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function EditUsuario()
	{
		if($this->Util()->PrintErrors()){ return false; }
		$this->Util()->DB()->setQuery("
			UPDATE `usuario` SET 
				`email` = '".$this->email."', 
				`password` = '".$this->getPassword()."', 
				`type` = '".$this->tipo."' ,
				`sucursalId` = '".$this->sucursalId."',
				`nombreCompleto` = '".$this->nombreCompleto."',
				`registroPatronal` = '".$this->registroPatronal."',
				`numEmpleado` = '".$this->numEmpleado."',
				`curp` = '".$this->curp."',
				`tipoRegimen` = '".$this->tipoRegimen."',
				`numSeguridadSocial` = '".$this->numSeguridadSocial."',
				`departamento` = '".$this->departamento."',
				`clabe` = '".$this->clabe."',
				`banco` = '".$this->banco."',
				`fechaInicioRelLaboral` = '".$this->fechaInicioRelLaboral."',
				`puesto` = '".$this->puesto."',
				`tipoContrato` = '".$this->tipoContrato."',
				`tipoJornada` = '".$this->tipoJornada."',
				`periodicidadPago` = '".$this->periodicidadPago."',
				`salarioBaseCotApor` = '".$this->salarioBaseCotApor."',
				`riesgoPuesto` = '".$this->riesgoPuesto."',
				`salarioDiarioIntegrado` = '".$this->salarioDiarioIntegrado."',
				`rfc` = '".$this->getRfc()."',
				`calle` = '".$this->getCalle()."',
				`noExt` = '".$this->getNoExt()."',
				`noInt` = '".$this->getNoInt()."',
				`colonia` = '".$this->getColonia()."',
				`municipio` = '".$this->getMunicipio()."',
				`cp` = '".$this->getCp()."',
				`estado` = '".$this->getEstado()."',
				`localidad` = '".$this->getLocalidad()."',
				`pais` = '".$this->getPais()."',
				`permisos` = '".$this->permisos."',
				`nuevosPermisos` = '".$this->nuevosPermisos."'
			WHERE usuarioId = '".$this->usuarioId."' LIMIT 1"
			);
		$this->Util()->DB()->UpdateData();

		$this->Util()->setError(20019, "complete");
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function DeleteUsuario()
	{
		if($this->Util()->PrintErrors()){ return false; }
		$this->Util()->DB()->setQuery("DELETE FROM usuario WHERE usuarioId = '".$this->usuarioId."'  ");
		$this->Util()->DB()->DeleteData();
		$this->Util()->setError(20018, "complete");
		$this->Util()->PrintErrors();
		return true;
	}
	
	public function GetUsuarioIdByEmail()
	{
		$this->Util()->DB()->setQuery("SELECT usuarioId FROM usuario WHERE email ='".$this->email."'");
		$usuario = $this->Util()->DB()->GetSingle();
	
		return $usuario;
	}
	
	public function setEmailProveedor($value)
	{
		$this->Util()->ValidateMail($value);
		$this->Util()->DB()->setQuery("SELECT COUNT(*) FROM usuario WHERE email ='".$value."'");
		if($this->Util()->DB()->GetSingle() > 0)
		{
			$this->email = $value;
		}
	}
	
	public function GetModulos()
	{
		$modulos = array(
				"usuarios" => "Usuarios",
				"nueva_factura" => "Nueva Factura",
				"datos_generales" => "Mi Empresa",
				"nuevos_folios" => "Lista de Folios",
				"actualizar_certificado" => "Actualizar Certificado",
				"impuesto" => "Impuesto",
				"nuevos_productos" => "Productos",
				"consultar_facturas" => "Reporte de Comprobantes",
				"cliente" => "Clientes",
				"nueva_venta" => "Nueva Venta",
				"reporte_ventas" => "Reporte de Ventas"
			);
		
		return $modulos;
	}
	
	public function Suggest($value, $empresaId)
	{
		$this->Util()->DB()->setQuery("SELECT usuarioId, nombreCompleto, curp, rfc FROM usuario WHERE empresaId = '".$empresaId."' AND (curp LIKE '%".$value."%' OR rfc LIKE '%".$value."%' OR nombreCompleto LIKE '%".$value."%') ORDER BY nombreCompleto LIMIT 10");
		$result =  $this->Util()->DB()->GetResult();
		
		return $result;
	}	
}


?>
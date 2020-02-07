<?php

class Main
{
	protected $page;


	public function setPage($value)
	{
		$this->Util()->ValidateInteger($value, 9999999999, 0);
		$this->page = $value;
	}
	
	public function getPage()
	{
		return $this->page;
	}

	function ListProductos()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM product ORDER BY productId ASC");
		
		$result = $this->Util()->DB()->GetResult();
		
		foreach($result as $key => $periodo)
		{
		}
		return $result;
	}
	
	function ListTiposDeComprobantes()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM tiposComprobante ORDER BY tiposComprobanteId");
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		return $result;
	}	

	function ListTiposDeComprobantesValidos()
	{
		$rfc = new RFC;
		$activeRfc =  $rfc->getRfcActive();
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			SELECT * FROM tiposComprobante 
			RIGHT JOIN serie ON serie.tiposComprobanteId = tiposComprobante.tiposComprobanteId
			WHERE serie.rfcId = '".$activeRfc."'
			ORDER BY tiposComprobante.tiposComprobanteId");
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		return $result;
	}
	
	function ListTiposDeComprobantesValidosBySucursal()
	{
		$rfc = new RFC;
		$activeRfc =  $rfc->getRfcActive();
		
		if($_SESSION['sucursalId'] > 0)
		{
			$add = " AND serie.sucursalAsignada = '".$_SESSION['sucursalId']."'";
		}
		
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			SELECT * FROM tiposComprobante 
			RIGHT JOIN serie ON serie.tiposComprobanteId = tiposComprobante.tiposComprobanteId
			WHERE serie.rfcId = '".$activeRfc."' ".$add." AND tiposComprobante.tiposComprobanteId != '".TIPO_COMPROBANTE_NOMINA."' AND consecutivo <= folioFinal
			ORDER BY tiposComprobante.tiposComprobanteId");
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		return $result;
	}
	
	function ListTiposDeComprobantesValidosDonatarias()
	{
		$rfc = new RFC;
		$activeRfc =  $rfc->getRfcActive();
		
		if($_SESSION['sucursalId'] > 0)
		{
			$add = " AND serie.sucursalAsignada = '".$_SESSION['sucursalId']."'";
		}
		
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			SELECT * FROM tiposComprobante 
			RIGHT JOIN serie ON serie.tiposComprobanteId = tiposComprobante.tiposComprobanteId
			WHERE serie.rfcId = '".$activeRfc."' ".$add." AND tiposComprobante.tiposComprobanteId = '".TIPO_COMPROBANTE_DONATARIA."' AND consecutivo <= folioFinal
			ORDER BY tiposComprobante.tiposComprobanteId");
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		return $result;
	}	

	function ListTiposDeComprobantesValidosBySucursalNomina()
	{
		$rfc = new RFC;
		$activeRfc =  $rfc->getRfcActive();
		
		if($_SESSION['sucursalId'] > 0)
		{
			$add = " AND serie.sucursalAsignada = '".$_SESSION['sucursalId']."'";
		}
		
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			SELECT * FROM tiposComprobante 
			RIGHT JOIN serie ON serie.tiposComprobanteId = tiposComprobante.tiposComprobanteId
			WHERE serie.rfcId = '".$activeRfc."' ".$add." AND tiposComprobante.tiposComprobanteId = '".TIPO_COMPROBANTE_NOMINA."' AND consecutivo <= folioFinal
			ORDER BY tiposComprobante.tiposComprobanteId");
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		return $result;
	}

	function InfoComprobante($id)
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM tiposComprobante WHERE tiposComprobanteId = '".$id."'");
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		return $result;
	}
	function ListIvas()
	{
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->EnumSelect("comprobante", "tasaIva");
		
		return $result;
	}

	function ListRetIsr()
	{
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->EnumSelect("comprobante", "porcentajeRetIsr");
		
		return $result;
	}

	function ListRetIva()
	{
		$result = array(
			0, 4, 6, 10, 10.666666, 16);
		return $result;
	}

	function ListTipoDeMoneda()
	{
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->EnumSelect("comprobante", "tipoDeMoneda");
		
		$monedas = array();
		foreach($result as $key => $moneda)
		{
			switch($moneda)
			{
				case "peso": 
					$monedas[$key]["tipo"] = "MXN";
					$monedas[$key]["moneda"] = "Peso";
					break;
				case "dolar": 
					$monedas[$key]["tipo"] = "USD";
					$monedas[$key]["moneda"] = "Dolar";
					break;
				case "euro": 
					$monedas[$key]["tipo"] = "EUR";
					$monedas[$key]["moneda"] = "Euro";
					break;
				case "quetzal": 
					$monedas[$key]["tipo"] = "GTQ";
					$monedas[$key]["moneda"] = "quetzal";
					break;
					
			}
		}
//		print_r($monedas);
		return $monedas;
	}

	function ListExcentoIva()
	{
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->EnumSelect("concepto", "excentoIva");
		
		return $result;
	}

	function ListSocios()
	{
		$this->Util()->DB()->setQuery("SELECT * FROM usuarios where tipo != 'admin'  ORDER BY idUsuario");
		$result = $this->Util()->DB()->GetResult();
		return $result;
	}
	
	

	function Proveedores($value)
	{
		$this->Util()->DB()->setQuery("SELECT * FROM usuario WHERE email LIKE '%".$value."%'ORDER BY email");
		$result = $this->Util()->DB()->GetResult();
		return $result;
	}

	function Regimenes($value)
	{
		$value = str_pad($value, 2, "0", STR_PAD_LEFT);
		$this->Util()->DB()->setQuery("SELECT * FROM regimenEmpleado WHERE claveRegimen = '".$value."'");
		$result = $this->Util()->DB()->GetRow();
		return $result;
	}

	function ActualizarDatos()
	{
		$this->Util()->DB()->setQuery("
			UPDATE empresa SET 
			nombrePer = '".$_POST["nombrePer"]."',
			emailPer = '".$_POST["emailPer"]."',
			telefono = '".$_POST["telefono"]."',
			telefonoPer = '".$_POST["telefonoPer"]."',
			celularPer = '".$_POST["celularPer"]."',
			socioContacto = '".$_POST["socioReferenciaPer"]."',
			actualizado = 'Si'
			WHERE empresaId = '".$_SESSION["empresaId"]."' LIMIT 1");
		$result = $this->Util()->DB()->UpdateData();
		
		return $result;
	}

	function ReportarPago()
	{
		if(!$_POST["fecha"])
		{
			$_POST["fecha"] = date("Y-m-d");
		}
		$monto = explode("-",$_POST["monto"]);
		
		if($monto[0] == "impuesto")
		{
			$this->Util()->DB()->setQuery("
				INSERT INTO  `impuestos` (
					`fecha` ,
					`factura` ,
					`status` ,
					`idEmpresa`
					)
					VALUES (
					'".$_POST["fecha"]."',  
					'".$_POST["factura"]."',  
					'noPagado',  
					'".$_SESSION["empresaId"]."'
					);");
			$result = $this->Util()->DB()->InsertData();
			

			//enviar correo
			$subject = 'Se registro una nuevo pago, empresa id '.$_SESSION["empresaId"].' ';
			$body = "Monto ".$_POST["monto"].".\r\n";
			$sendMail = new SendMail;
			$sendMail->prepare($subject, $body);
			
			return;
		}

		if($monto[0] == "nomina")
		{
			$this->Util()->DB()->setQuery("
				INSERT INTO  `nominas` (
					`fecha` ,
					`status` ,
					`factura` ,
					`idEmpresa`
					)
					VALUES (
					'".$_POST["fecha"]."',  
					'noPagado',  
					'".$_POST["factura"]."',  
					'".$_SESSION["empresaId"]."'
					);");
			$result = $this->Util()->DB()->InsertData();

			//enviar correo
			$subject = 'Se registro una nuevo pago, empresa id '.$_SESSION["empresaId"].' ';
			$body = "Monto ".$_POST["monto"].".\r\n";
			$sendMail = new SendMail;
			$sendMail->prepare($subject, $body);
			
			return;
		}

		$this->Util()->DB()->setQuery("
			INSERT INTO  `ventas` (
				`cantidad` ,
				`fecha` ,
				`status` ,
				`factura` ,
							
				`idEmpresa` ,
				`rfc` ,
				`razonSocial` ,
				`interno` ,
				`monto` ,
				`metodoPago` ,
				`banco` ,
				`autorizacion`
				)
				VALUES (
				'".$monto[0]."',  
				'".$_POST["fecha"]."',  
				'noPagado',  
				'".$_POST["factura"]."',  
				
				'".$_SESSION["empresaId"]."',  
				'".$_POST["rfc"]."',  
				'".$_POST["razonSocial"]."',  
				'".$_POST["interno"]."',  
				
				'".$monto[1]."',  
				'".$_POST["metodoPago"]."',  
				'".$_POST["banco"]."',
				'".$_POST["autorizacion"]."'
				);");
		$result = $this->Util()->DB()->InsertData();
		
			$root = DOC_ROOT."/admin/archivos/";
			$ext = explode(".", $_FILES["comprobante"]["name"]);
			
			$name = $result.".".$ext[1];
			
			@move_uploaded_file($_FILES["comprobante"]["tmp_name"], $root.$name); 
			
			$this->Util()->DB()->setQuery("
			UPDATE
				ventas
			SET comprobante = '".$name."' WHERE idVenta = ".$result);
			$this->Util()->DB()->UpdateData();
		
		//activar todo por default si es interno
		if($_POST["interno"] == "Si")
		{
			$date = date("Y-m-d");
			//activamos empresa y updateamos fecha activado y fecha de 1er vencimiento
			$datePost = date("Y-m-d", strtotime($date. " + 1 YEAR"));

			$this->Util()->DB()->setQuery("
			UPDATE
				ventas
			SET status = 'pagado', fechaPagado = '".$date."' WHERE idVenta = ".$result);
			$this->Util()->DB()->UpdateData();
			
			$this->Util()->DB()->setQuery("
			UPDATE
				empresa
			SET vencimiento = '".$datePost."', limite = limite + ".$monto[0]." WHERE empresaId = ".$_SESSION["empresaId"]);
			
			$this->Util()->DB()->UpdateData();

		}
		
		//enviar correo
		$subject = 'Se registro una nuevo pago, empresa id '.$_SESSION["empresaId"].' ';
		$body = "Monto ".$_POST["monto"].".\r\n";
		$sendMail = new SendMail;
		$sendMail->prepare($subject, $body);
		
		
		return $result;
	}


	public function Util() 
	{
		if($this->Util == null ) 
		{
			$this->Util = new Util();
		}
		return $this->Util;
	}
	
	function NewDesignExclude()
	{
		$this->Util()->DB()->setQuery("SELECT empresaId FROM empresa WHERE moduloImpuestos = 'Si' || moduloIsh = 'Si' || moduloAgrario = 'Si' || moduloEscuela = 'Si' || moduloTransporte = 'Si' || moduloIeps = 'Si'  || addendaPepsico = 'Si' || addendaZepto = 'Si' || empresaId != '15' ORDER BY empresaId");
		$result = $this->Util()->DB()->GetResult();
		
		return $result;
	}
}


?>
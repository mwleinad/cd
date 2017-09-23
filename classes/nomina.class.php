<?php

class Nomina extends Producto
{
	private $tipoOtroPago;
	private $tipoPercepcion;
	private $importeGravado;
	private $importeExcento;
	private $importe;
	private $tipoDeduccion;
	private $tipoIncapacidad;
	private $diasIncapacidad;
	private $descuento;
	private $tipoHorasExtra;
	private $dias;
	private $horasExtra;
	private $importePagado;

	public function setTipoHorasExtra($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 1, "Tipo de Horas Extra");
		$this->tipoHorasExtra = $value;
	}

	public function setDias($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->dias = $value;
	}

	public function setHorasExtra($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->horasExtra = $value;
	}

	public function setImportePagado($value)
	{
		$this->Util()->ValidateFloat($value, 6, 9999999, 0);
		$this->importePagado = $value;
	}

	public function setImporteExcento($value)
	{
		$this->Util()->ValidateFloat($value, 6, 9999999, 0);
		$this->importeExcento = $value;
	}

	public function setImporteGravado($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->importeGravado = $value;
	}

	public function setImporte($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->importe = $value;
	}

	public function setTipoPercepcion($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 1, "Tipo de Percepcion");
		$this->tipoPercepcion = $value;
	}

	public function setTipoOtroPago($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 1, "Tipo de Otro Pago");
		$this->tipoOtroPago = $value;
	}

	public function setTipoDeduccion($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 1, "Tipo de Deduccion");
		$this->tipoDeduccion = $value;
	}

	public function setTipoIncapacidad($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->tipoIncapacidad = $value;
	}
	
	public function setDiasIncapacidad($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->diasIncapacidad = $value;
	}

	public function setDescuento($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->descuento = $value;
	}
	
	function GuardarDatos($data, $session)
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		$arreglo[0] = $data;
		$arreglo[1] = $session;
		$userId = $arreglo[0]["userId"];
		$arreglo = urlencode(serialize($arreglo));
		
		$this->Util()->DB()->setQuery("UPDATE usuario SET nomina = '".$arreglo."' WHERE usuarioId ='".$userId."'");
		$this->Util()->DB()->UpdateData();
		
		return true;
	}
	
	function AgregarPercepcion()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		@end($_SESSION["percepciones"]);
		$percepciones = @key($_SESSION["percepciones"]) + 1;
		$_SESSION["percepciones"][$percepciones]["tipoPercepcion"] = $this->tipoPercepcion;
		$info = $this->PercepcionInfo($this->tipoPercepcion);

		$_SESSION["percepciones"][$percepciones]["nombrePercepcion"] = $info["nombrePercepcion"];
		$_SESSION["percepciones"][$percepciones]["importeGravado"] = $this->importeGravado;
		$_SESSION["percepciones"][$percepciones]["importeExcento"] = $this->importeExcento;
		$_SESSION["percepciones"][$percepciones]["total"] = $this->importeGravado + $this->importeExcento;
		
		return true;
	}

	function PercepcionInfo($clave)
	{
		$this->Util()->DB()->setQuery("SELECT * FROM tipoPercepcion WHERE clavePercepcion ='".$clave."'");
		$info = $this->Util()->DB()->GetRow();
		
		return $info;
	}
	
	function BorrarPercepcion($key)
	{
		unset($_SESSION["percepciones"][$key]);
		return true;
	}
	
	function CleanPercepcion()
	{
		unset($_SESSION["percepciones"]);
	}
	
	/*otros pagos */
	function AgregarOtroPago()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		@end($_SESSION["otrosPagos"]);
		$otrosPagos = @key($_SESSION["otrosPagos"]) + 1;
		$_SESSION["otrosPagos"][$otrosPagos]["tipoOtroPago"] = $this->tipoOtroPago;
		$info = $this->OtroPagoInfo($this->tipoOtroPago);

		$_SESSION["otrosPagos"][$otrosPagos]["nombreOtroPago"] = $info["nombreOtroPago"];
		$_SESSION["otrosPagos"][$otrosPagos]["importe"] = $this->importe;
		$_SESSION["otrosPagos"][$otrosPagos]["total"] = $this->importe;
		
		return true;
	}

	function OtroPagoInfo($clave)
	{
		$this->Util()->DB()->setQuery("SELECT * FROM tipoOtroPago WHERE claveOtroPago ='".$clave."'");
		$info = $this->Util()->DB()->GetRow();
		
		return $info;
	}
	
	function BorrarOtroPago($key)
	{
		unset($_SESSION["otrosPagos"][$key]);
		return true;
	}
	
	function CleanOtroPago()
	{
		unset($_SESSION["otrosPagos"]);
	}	
	
	
	function AgregarDeduccion()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		@end($_SESSION["deducciones"]);
		$deducciones = @key($_SESSION["deducciones"]) + 1;
		$_SESSION["deducciones"][$deducciones]["tipoDeduccion"] = $this->tipoDeduccion;
		$info = $this->DeduccionInfo($this->tipoDeduccion);

		$_SESSION["deducciones"][$deducciones]["nombreDeduccion"] = $info["nombreDeduccion"];
		$_SESSION["deducciones"][$deducciones]["importeGravado"] = $this->importeGravado;
		$_SESSION["deducciones"][$deducciones]["importeExcento"] = $this->importeExcento;
		$_SESSION["deducciones"][$deducciones]["total"] = $this->importeGravado + $this->importeExcento;
		
		return true;
	}

	function DeduccionInfo($clave)
	{
		$this->Util()->DB()->setQuery("SELECT * FROM tipoDeduccion WHERE claveDeduccion ='".$clave."'");
		$info = $this->Util()->DB()->GetRow();
		
		return $info;
	}
	
	function BorrarDeduccion($key)
	{
		unset($_SESSION["deducciones"][$key]);
		return true;
	}
	

	function CleanDeduccion()
	{
		unset($_SESSION["deducciones"]);
	}
	
	//incapacidades
	function AgregarIncapacidad()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		@end($_SESSION["incapacidades"]);
		$incapacidades = @key($_SESSION["incapacidades"]) + 1;
		$_SESSION["incapacidades"][$incapacidades]["tipoIncapacidad"] = $this->tipoIncapacidad;
		$info = $this->IncapacidadInfo($this->tipoIncapacidad);

		$_SESSION["incapacidades"][$incapacidades]["nombreIncapacidad"] = $info["nombreIncapacidad"];
		$_SESSION["incapacidades"][$incapacidades]["diasIncapacidad"] = $this->diasIncapacidad;
		$_SESSION["incapacidades"][$incapacidades]["descuento"] = $this->descuento;
		$_SESSION["incapacidades"][$incapacidades]["total"] = $this->descuento;
		print_r($_SESSION["incapacidades"]);
		return true;
	}

	function IncapacidadInfo($clave)
	{
		$this->Util()->DB()->setQuery("SELECT * FROM tipoIncapacidad WHERE claveIncapacidad ='".$clave."'");
		$info = $this->Util()->DB()->GetRow();
		
		return $info;
	}
	
	function BorrarIncapacidad($key)
	{
		unset($_SESSION["incapacidades"][$key]);
		return true;
	}
	

	function CleanIncapacidades()
	{
		unset($_SESSION["incapacidades"]);
	}		
	
	//tipo horas
	function AgregarHoraExtra()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		@end($_SESSION["horasExtras"]);
		$horasExtras = @key($_SESSION["horasExtras"]) + 1;
		$_SESSION["horasExtras"][$horasExtras]["dias"] = $this->dias;
		$_SESSION["horasExtras"][$horasExtras]["tipoHoras"] = $this->tipoHorasExtra;
		$_SESSION["horasExtras"][$horasExtras]["horasExtra"] = $this->horasExtra;
		$_SESSION["horasExtras"][$horasExtras]["importePagado"] = $this->importePagado;
		$_SESSION["horasExtras"][$horasExtras]["total"] = $this->importePagado;
		return true;
	}

	function BorrarHoraExtra($key)
	{
		unset($_SESSION["horasExtras"][$key]);
		return true;
	}
	

	function CleanHorasExtra()
	{
		unset($_SESSION["horasExtras"]);
	}		
	
	function UpdateConcepto()
	{
		$conceptos = 1;
		unset($_SESSION["conceptos"][$conceptos]);
		$_SESSION["conceptos"][$conceptos]["noIdentificacion"] = "";
		$_SESSION["conceptos"][$conceptos]["cantidad"] = 1;
		$_SESSION["conceptos"][$conceptos]["unidad"] = "Servicio";
		
		//calcular importe
		//sumamos percepciones
		$importe = 0;
		
		if(!is_array($_SESSION["percepciones"]))
		{
			$_SESSION["percepciones"] = array();
		}
		
		$_SESSION["conceptos"][$conceptos]["percepciones"]["totalGravado"] = 0;
		$_SESSION["conceptos"][$conceptos]["percepciones"]["totalExcento"] = 0;
		$_SESSION["conceptos"][$conceptos]["percepciones"]["total"] = 0;
		
		foreach($_SESSION["percepciones"] as $percepcion)
		{
			$_SESSION["conceptos"][$conceptos]["percepciones"]["totalGravado"] += $percepcion["importeGravado"];
			$_SESSION["conceptos"][$conceptos]["percepciones"]["totalExcento"] += $percepcion["importeExcento"];
			$_SESSION["conceptos"][$conceptos]["percepciones"]["total"] += $percepcion["importeExcento"] + $percepcion["importeGravado"];
		}
		$importe = $_SESSION["conceptos"][$conceptos]["percepciones"]["total"];

		if(!is_array($_SESSION["deducciones"]))
		{
			$_SESSION["deducciones"] = array();
		}

		$_SESSION["conceptos"][$conceptos]["deducciones"]["totalGravado"] = 0;
		$_SESSION["conceptos"][$conceptos]["deducciones"]["totalExcento"] = 0;
		$_SESSION["conceptos"][$conceptos]["deducciones"]["total"] = 0;

		foreach($_SESSION["deducciones"] as $deduccion)
		{
			$_SESSION["conceptos"][$conceptos]["deducciones"]["totalGravado"] += $deduccion["importeGravado"];
			$_SESSION["conceptos"][$conceptos]["deducciones"]["totalExcento"] += $deduccion["importeExcento"];
			$_SESSION["conceptos"][$conceptos]["deducciones"]["total"] += $deduccion["importeExcento"] + $deduccion["importeGravado"];
		}
		$importe -= $_SESSION["conceptos"][$conceptos]["deducciones"]["total"];

		if(!is_array($_SESSION["incapacidades"]))
		{
			$_SESSION["incapacidades"] = array();
		}

		$_SESSION["conceptos"][$conceptos]["incapacidades"]["descuento"] = 0;
		$_SESSION["conceptos"][$conceptos]["incapacidades"]["total"] = 0;

		foreach($_SESSION["incapacidades"] as $incapacidad)
		{
			$_SESSION["conceptos"][$conceptos]["incapacidades"]["descuento"] += $incapacidad["descuento"];
			$_SESSION["conceptos"][$conceptos]["incapacidades"]["total"] += $incapacidad["descuento"];
		}
		$importe -= $_SESSION["conceptos"][$conceptos]["incapacidades"]["total"];

		if(!is_array($_SESSION["horasExtras"]))
		{
			$_SESSION["horasExtras"] = array();
		}

		$_SESSION["conceptos"][$conceptos]["horasExtras"]["importePagado"] = 0;
		$_SESSION["conceptos"][$conceptos]["horasExtras"]["total"] = 0;

		foreach($_SESSION["horasExtras"] as $horaExtra)
		{
			$_SESSION["conceptos"][$conceptos]["horasExtras"]["importePagado"] += $horaExtra["importePagado"];
			$_SESSION["conceptos"][$conceptos]["horasExtras"]["total"] += $horaExtra["importePagado"];
		}
		
		$importe += $_SESSION["conceptos"][$conceptos]["horasExtras"]["total"];

		if(!is_array($_SESSION["otrosPagos"]))
		{
			$_SESSION["otrosPagos"] = array();
		}
		
		foreach($_SESSION["otrosPagos"] as $otroPago)	{
			$importe += $otroPago["importe"];
		}		

		$_SESSION["conceptos"][$conceptos]["valorUnitario"] = $importe;
		$_SESSION["conceptos"][$conceptos]["importe"] = $importe;
		$_SESSION["conceptos"][$conceptos]["excentoIva"] = "No";

		if($_SESSION["empresaId"] == 698 || $_SESSION["empresaId"] == 397)
		{
			if($_POST["serie"] == "8-3")
			{
				$_SESSION["conceptos"][$conceptos]["descripcion"] = "RECIBO DE NOMINA ".date("d-m-Y");
			}
			elseif($_POST["serie"] == "8-4")
			{
				$_SESSION["conceptos"][$conceptos]["descripcion"] = "RECIBO DE PAGO DE ASIMILADOS A SALARIOS ".date("d-m-Y");
			}
			else
			{
				$_SESSION["conceptos"][$conceptos]["descripcion"] = "RECIBO DE NOMINA ".date("d-m-Y");
			}
		}
		else
		{
			$_SESSION["conceptos"][$conceptos]["descripcion"] = "RECIBO DE NOMINA ".date("d-m-Y");
		}

		$_SESSION["conceptos"][$conceptos]["excentoIsh"] = "Si";		
		
//		print_r($_SESSION["conceptos"]);
	}

	function GetTotalDesglosado($data, $session)
	{ 

		$data["subtotal"] = 0;
		$data["descuento"] = 0;
		$data["iva"] = 0;
		$data["ieps"] = 0;
		$data["ish"] = 0;
		$data["retIva"] = 0;
		$data["retIsr"] = 0;
		$data["total"] = 0;

		foreach($data as $key => $value)
		{
			$data[$key] = $this->Util()->RoundNumber($data[$key]);
		}

//echo "<pre>";
		if(is_array($session["conceptos"]))
		{
			foreach($session["conceptos"] as $key => $concepto)
			{
				$data["ieps"] += $concepto["totalIeps"];
				$data["ish"] += $concepto["totalIsh"];
			}
		}

		if(is_array($session["conceptos"]))
		{
			foreach($session["conceptos"] as $key => $concepto)
			{
				//cada concepto correrle los impuestos extra.
				$totalImpuesto = 0;
				if($session["impuestos"])
				{
					$importe = $concepto["importe"];
					foreach($session["impuestos"] as $keyImpuesto => $impuesto)
					{
						
				//		print_r($impuesto);
						//impuesto extra, suma
						if($session["impuestos"][$keyImpuesto]["importe"] != 0)
						{
	//						echo $_SESSION["impuestos"][$keyImpuesto]["importe"];													 
							if($impuesto["tipo"] == "impuesto")
							{
								$concepto["importe"] = $concepto["importe"] + $session["impuestos"][$keyImpuesto]["importe"];
								$totalImpuesto += $session["impuestos"][$keyImpuesto]["importe"];
							}
							elseif($impuesto["tipo"] == "retencion")
							{
								$concepto["importe"] = $concepto["importe"] - $session["impuestos"][$keyImpuesto]["importe"];
								$totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
							}
							elseif($impuesto["tipo"] == "deduccion")
							{
								$concepto["importe"] = $concepto["importe"] - $session["impuestos"][$keyImpuesto]["importe"];
								$totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
							}
							elseif($impuesto["tipo"] == "amortizacion")
							{
								$concepto["importe"] = $concepto["importe"] - $session["impuestos"][$keyImpuesto]["importe"];
								$totalImpuesto -= $session["impuestos"][$keyImpuesto]["importe"];
							}
							continue;
						}
						
						if($impuesto["tipo"] == "impuesto")
						{
							$concepto["importe"] = $concepto["importe"] + ($importe * ($impuesto["tasa"] / 100));
							$session["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
						}
						elseif($impuesto["tipo"] == "retencion")
						{
							$concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
							$session["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
						}
						elseif($impuesto["tipo"] == "deduccion")
						{
							$concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
							$session["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
						}
		
					}//foreach
				}
				$data["subtotalOriginal"] = $this->Util()->RoundNumber($data["subtotalOriginal"] + $importe);
				$data["subtotal"] = $this->Util()->RoundNumber($data["subtotal"] + $concepto["importe"]);
				if($concepto["excentoIva"] == "si")
				{
					$session["conceptos"][$key]["tasaIva"] = 0;
				}
				else
				{
					$session["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
				}
	
				//porcentaje de descuento
				if($data["porcentajeDescuento"])
				{
					$data["porcentajeDescuento"];
				}
				
				$data["descuentoThis"] = $this->Util()->RoundNumber($session["conceptos"][$key]["importe"] * ($data["porcentajeDescuento"] / 100));
				$data["descuento"] += $data["descuentoThis"]; 
				
				$afterDescuento = $session["conceptos"][$key]["importe"] - $data["descuentoThis"];
				if($concepto["excentoIva"] == "si")
				{
					$session["conceptos"][$key]["tasaIva"] = 0;
				}
				else
				{
					$session["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
				}
	
				$data["ivaThis"] = $this->Util()->RoundNumber($afterDescuento * ($session["conceptos"][$key]["tasaIva"] / 100));
				$data["iva"] += $data["ivaThis"];
	
				//$data["ishThis"] = $this->Util()->RoundNumber($afterDescuento * ($_SESSION["conceptos"][$key]["tasaIsh"] / 100));
				//$data["ish"] += $data["ishThis"];
	
			}//conceptos
		}
		$data["impuestos"] = $session["impuestos"];
		$afterDescuento = $data["subtotal"] - $data["descuento"];
		$data["afterDescuento"] = $afterDescuento;
		
//		echo $data["afterDescuento"];
		//aplicar otros impuestos y retenciones aplican despues del descuento
//		$afterDescuento = $data["afterDescuento"];
		
		$data["afterIva"] = $afterDescuento + $data["iva"];
		//ieps de descuento
		if(!$data["porcentajeIEPS"])
		{
			$data["porcentajeIEPS"] = 0;
		}

		if($data["ish"] > 0)
		{
			$data["porcentajeISH"] = TASA_ISH;
		}
		
		//si la factura tiene descuento, descontar al ieps
		if($data["porcentajeDescuento"] > 0)
		{
			$data["ieps"] = $this->Util()->RoundNumber($data["ieps"] - ($data["ieps"] * ($data["porcentajeDescuento"] / 100)));
			$data["ish"] = $this->Util()->RoundNumber($data["ish"] - ($data["ish"] * ($data["porcentajeDescuento"] / 100)));
		}
		else
		{
			$data["ieps"] = $this->Util()->RoundNumber($data["ieps"]);			
			$data["ish"] = $this->Util()->RoundNumber($data["ish"]);			
		}

		//ish
		$afterImpuestos = $afterDescuento + $data["iva"] + $data["ieps"] + $data["ish"];
		$data["afterImpuestos"] = $afterImpuestos;
		if($session["empresaId"] == "416")
		{
			$data["retIva"] = $this->Util()->RoundNumber(($data["afterDescuento"] - $totalImpuesto) * ($data["porcentajeRetIva"] / 100));
		}
		else
		{
			$data["retIva"] = $this->Util()->RoundNumber($data["afterDescuento"] * ($data["porcentajeRetIva"] / 100));
		}
		
		$data["retIsr"] = $this->Util()->RoundNumber($data["afterDescuento"] * ($data["porcentajeRetIsr"] / 100));
		$data["total"] = $this->Util()->RoundNumber($data["subtotal"] - $data["descuento"] + $data["iva"] + $data["ieps"] + $data["ish"] - $data["retIva"] - $data["retIsr"]);

//echo "</pre>";

//		echo "<pre>";		print_r($data);		echo "</pre>";
		return $data;
	}
		
	function GetTotalDesglosado2($value)
	{
	}	
	
	function GetUserInfo($id)
	{
		$this->Util()->DB()->setQuery("SELECT nombreCompleto AS nombre, rfc, email FROM usuario WHERE usuarioId = '".$id."'");
		$row = $this->Util()->DB()->GetRow();
		return $row;
		
	}
	function GetNominaByRfc(){
	
		global $user;
				
		$id_rfc = $this->getRfcActive();

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery('SELECT COUNT(*) FROM comprobante WHERE tiposComprobanteId = 8 AND rfcId = '.$id_rfc.' ORDER BY fecha DESC');
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/sistema/consultar-nominas");

		$sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];

		$sqlQuery = 'SELECT * FROM comprobante WHERE tiposComprobanteId = 8 AND rfcId = '.$id_rfc.' ORDER BY fecha DESC '.$sqlAdd;
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val){
			
			//$user->setUserId($val['userId'],1);
			
			//$errores = $user->Util()->getErrors();
			//$user->Util()->cleanErrors();
			
			$usr = $this->GetUserInfo($val['userId']);
				
			if(!$usr)
			{
				$usr['nombre'] = "Empleado fue Borrado";
				$usr['rfc'] = "Borrado";
			}
				
			$card['rfc'] = $usr['rfc'];
			$card['nombre'] = $usr['nombre'];
			$card['fecha'] = date('d-m-Y',strtotime($val['fecha']));
			
			$cadenaOriginal = explode("|", $val["cadenaOriginal"]);
			$card['subTotal'] = $val["subTotal"];
			$card['total'] = $val["total"];
			$card['version'] = $val["version"];
			$card['xml'] = $val["xml"];

			foreach($cadenaOriginal as $keyCadena => $cadena)
			{
				if($cadena == "IVA")
				{
					if($countIvas == 1)
					{
						$card['ivaTotal'] = $cadenaOriginal[$keyCadena + 2];
						$countIvas = 0;
					}
					$countIvas++;
				}

				//print_r($cadena);
				if($cadena == "ISR")
				{
					$card['isrRet'] = $cadenaOriginal[$keyCadena + 1];
				}

			}

			$card['total_formato'] = number_format($card['total'],2,'.',',');
			$card['serie'] = $val['serie'];
			$card['folio'] = $val['folio'];
			$card['comprobanteId'] = $val['comprobanteId'];
			$card['status'] = $val['status'];
			$card['tipoDeComprobante'] = $val['tipoDeComprobante'];

			$timbreFiscal = unserialize($val['timbreFiscal']);
			$card["uuid"] = $timbreFiscal["UUID"];
			
			//get payments
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM payment WHERE comprobanteId = '".$val['comprobanteId']."'");

			$card["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			$card["payments"] = number_format($card["payments_noformat"],2,'.',',');
			
			$card["statusPayment"] = "Debe";
			if($card["payments_noformat"] >= $card['total'])
			{
				$card["statusPayment"] = "Pagada";
			}

			$info[$key] = $card;
			
		}//foreach

		$data["items"] = $info;
		$data["pages"] = $pages;

		return $data;
		
	}//GetComprobantesByRfc
	
	
	function SearchNominaByRfc($values){
	
		global $user;
		
		$sqlSearch = '';
		
		if($values['rfc']){
			$sqlSearch .= ' AND '.SQL_DATABASE.'.usuario.rfc LIKE "%'.$values['rfc'].'%"';
		}//if
		
		if($values['nombre']){
			$sqlSearch .= ' AND '.SQL_DATABASE.'.usuario.nombreCompleto LIKE "%'.$values['nombre'].'%"';
		}//if
				
		if($values['mes']){
			$sqlSearch .= ' AND EXTRACT(MONTH FROM comprobante.fecha) = '.$values['mes'];
		}//if
		
		if($values['anio'])
			$sqlSearch .= ' AND EXTRACT(YEAR FROM comprobante.fecha) = '.intval($values['anio']);		
		
		if($values['status_activo'] != '')		
			$sqlSearch .= ' AND comprobante.status = "'.$values['status_activo'].'"';
		
		if($values['comprobante'])
			$sqlSearch .= ' AND comprobante.tiposComprobanteId = '.$values['comprobante'];
		
		if($values['sucursal'])
			$sqlSearch .= ' AND comprobante.sucursalId = '.$values['sucursal'];
		
		
		$id_rfc = $this->getRfcActive();
		
		$sqlQuery = 'SELECT 
					comprobante.*
					FROM 
						comprobante
					LEFT JOIN '.SQL_DATABASE.'.usuario ON '.SQL_DATABASE.'.usuario.usuarioId = comprobante.userId 
					WHERE 
							tiposComprobanteId = 8 AND comprobante.rfcId = '.$id_rfc.$sqlSearch.'							 
					ORDER BY 
							comprobante.fecha DESC';
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val){
			
			$usr = $this->GetUserInfo($val['userId']);
				
			if(!$usr)
			{
				$usr['nombre'] = "Empleado fue Borrado";
				$usr['rfc'] = "Borrado";
			}
			
			$card = array();
			$card['serie'] = $val['serie'];
			$card['folio'] = $val['folio'];
			$card['rfc'] = $usr['rfc'];
			$card['nombre'] = $usr['nombre'];
			$card['fecha'] = date('d/m/Y',strtotime($val['fecha']));
			$card['subTotal'] = $val['subTotal'];
			$card['porcentajeDescuento'] = $val['porcentajeDescuento'];
			$card['descuento'] = $val['descuento'];
			$card['ivaTotal'] = $val['ivaTotal'];
			$card['total'] = $val['total'];
			$card['total_formato'] = number_format($val['total'],2,'.',',');
			$card['tipoDeMoneda'] = $val['tipoDeMoneda'];
			$card['tipoDeCambio'] = $val['tipoDeCambio'];
			$card['porcentajeRetIva'] = $val['porcentajeRetIva'];
			$card['porcentajeRetIsr'] = $val['porcentajeRetIsr'];
			$card['porcentajeIEPS'] = $val['porcentajeIEPS'];
			$card['comprobanteId'] = $val['comprobanteId'];
			$card['status'] = $val['status'];
			$card['tipoDeComprobante'] = $val['tipoDeComprobante'];
			$card['observaciones'] = $val['observaciones'];
			$card['xml'] = $val['xml'];
			$card['version'] = $val['version'];


			//get payments
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM payment WHERE comprobanteId = '".$val['comprobanteId']."'");

			$card["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			$card["payments"] = number_format($card["payments_noformat"],2,'.',',');
			
			$card["statusPayment"] = "Debe";
			if($card["payments_noformat"] >= $card['total'])
			{
				$card["statusPayment"] = "Pagada";
			}
			
			$info[$key] = $card;
			
		}//foreach

		$data["items"] = $info;
		$data["pages"] = $pages;

		return $data;
		
	}//SearchComprobantesByRfc	
	
	public function SendComprobante($id_comprobante){
		
		global $comprobante;
		
		$compInfo = $comprobante->GetInfoComprobante($id_comprobante);
				
		$id_cliente = $compInfo['userId'];
		$usrInfo = $this->GetUserInfo($id_cliente);
		
		$nombre = $usrInfo['nombre'];
		$email = $usrInfo['email'];
		
		$email = preg_replace('!\s+!', ' ', $email);
		$email = str_replace(";",",", $email);
		$email = str_replace(" ",",", $email);
		$emails = explode(",", $email);
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
		$mail->Host = 'localhost';
		$mail->From = $_SESSION["loginKey"];
		$mail->FromName = urldecode($info["razonSocial"]);
		$mail->Subject = 'Envio de Nomina con Folio No. '.$folio;
		foreach($emails as $email)
		{
			if($email == "")
			{
				continue;
			}
			$mail->AddAddress($email, 'Estimado Usuario');
		}
		$body = "Favor de revisar el archivo adjunto para ver nomina.\r\n";
		$body .= "\r\n";
		$body .= "Gracias.\r\n";
		
		if(SITENAME == "CONFACTURA")
		{
			$body .= "Si esta interesado en nuestro sistema de Facturacion enviar un correo a cesar@avantika.com.mx.\r\n";
			$body .= "\r\n";
			$body .= "www.".SITENAME.".com.mx\r\n";
		}
		else
		{
			$body .= "Si esta interesado en nuestro sistema de Facturacion enviar un correo a info@facturase.com.\r\n";
			$body .= "\r\n";
			$body .= "www.".SITENAME.".com\r\n";
		}
		$mail->Body = $body;
		//adjuntamos un archivo
		$mail->AddAttachment($enlace, 'Factura_'.$folio.'.pdf');
		$mail->AddAttachment($enlace_xml, 'XML_Factura_'.$folio.'.xml');
		$mail->Send();
				
		$this->Util()->setError(20023, 'complete');
		
		$this->Util()->PrintErrors();
	
	}//SendComprobante
	
}//Producto


?>
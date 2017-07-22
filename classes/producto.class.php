<?php

class Producto extends Sucursal
{
	private $noIdentificacion;

	private $cantidad;
	private $unidad;
	private $descripcion;
	private $valorUnitario;
	private $precioCompra;
	private $importe;
	private $excentoIva;
	private $porcentajeIeps;
	private $porcentajeIsh;
	private $excentoIsh;
	private $idRecepcion;
	private $item;
	private $ordenCompra;
	private $id_producto;
	private $tasa;
	private $impuesto;
	private $tipo;
	private $tasaIva;
	private $importeImpuesto;
	private $setCategoriaConcepto;
	
	private $tipoGanado;
	private $peso;
	private $from;

	public function setTipoGanado($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "Tipo Ganado");
		$this->tipoGanado = $value;
	}

	public function setPeso($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "Peso");
		$this->peso = $value;
	}

	public function setFrom($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "From");
		$this->from = $value;
	}


	public function setPorcentajeIsh($value)
	{
		$this->Util()->ValidateFloat($value, 6, 100, 0);
		$this->porcentajeIsh = $value;
	}
	
	public function getPorcentajeIsh()
	{
		return $this->porcentajeIsh;
	}

	public function setPorcentajeIeps($value)
	{
		$this->Util()->ValidateFloat($value, 6, 100, 0);
		$this->porcentajeIeps = $value;
	}
	
	public function getPorcentajeIeps()
	{
		return $this->porcentajeIeps;
	}

	public function setTasaIva($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->tasaIva = $value;
	}
	
	public function getTasaIva()
	{
		return $this->tasaIva;
	}

	public function setImpuesto($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 1, "Impuesto");
		$this->impuesto = $value;
	}
	
	public function getImpuesto()
	{
		return $this->impuesto;
	}

	public function setCategoriaConcepto($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 0, "Categoria Concepto");
		$this->categoriaConcepto = $value;
	}
	
	public function getCategoriaConcepto()
	{
		return $this->categoriaConcepto;
	}

	public function setTipo($value)
	{
		$this->Util()->ValidateString($value, $max_chars=255, $minChars = 1, "Tipo");
		$this->tipo = $value;
	}
	
	public function getTipo()
	{
		return $this->tipo;
	}

	public function setTasa($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->tasa = $value;
	}
	
	public function getTasa()
	{
		return $this->tasa;
	}

	public function setNoIdentificacion($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "No. Identificacion");
		$this->noIdentificacion = $value;
	}
	
	public function getNoIdentificacion()
	{
		return $this->noIdentificacion;
	}

	public function setExcentoIva($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Excento Iva");
		$this->excentoIva = $value;
	}
	
	public function getExcentoIva()
	{
		return $this->excentoIva;
	}

	public function setExcentoIsh($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Excento Ish");
		$this->excentoIsh = $value;
	}

	public function setIdRecepcion($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Id Recepcion");
		$this->idRecepcion = $value;
	}

	public function getIdRecepcion()
	{
		return $this->idRecepcion;
	}

	public function setItem($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 1, "Item");
		$this->item = $value;
	}

	private $cuentaPredial;
	public function setCuentaPredial($value)
	{
		$this->Util()->ValidateString($value, $max_chars=200, $minChars = 0, "Cuenta Predial");
		$this->cuentaPredial = $value;
	}

	private $claveProdServ;
	public function setClaveProdServ($value)
	{
		$this->Util()->ValidateString($value, $max_chars=200, $minChars = 0, "Clave Prod Serv");
		$this->claveProdServ = $value;
	}

	private $claveUnidad;
	public function setClaveUnidad($value)
	{
		$this->Util()->ValidateString($value, $max_chars=200, $minChars = 0, "Clave Unidad");
		$this->claveUnidad = $value;
	}

	private $iepsTasaOCuota;
	public function setIepsTasaOCuota($value)
	{
		$this->Util()->ValidateString($value, $max_chars=200, $minChars = 0, "IEPS Tasa o Cuota");
		$this->iepsTasaOCuota = $value;
	}

	public function getItem()
	{
		return $this->item;
	}

	public function setOrdenCompra($value)
	{
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 1, "Orden de Compra");
		$this->ordenCompra = $value;
	}

	public function getOrdenCompra()
	{
		return $this->ordenCompra;
	}

	
	public function getExcentoIsh()
	{
		return $this->excentoIsh;
	}

	public function setUnidad($value)
	{
		$this->Util()->ValidateRequireField($value, 'Unidad');
		$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Unidad");
		$this->unidad = $value;
	}
	
	public function getUnidad()
	{
		return $this->unidad;
	}

	public function setCantidad($value)
	{		
		$this->Util()->ValidateRequireField($value, 'Cantidad');
		
		if($value == '')
			return;
		
		if(!is_numeric($value))
			$this->Util()->setError(0,'error','Ingrese un valor v&aacute;lido. Campo : Cantidad');
		elseif($value <= 0)
			$this->Util()->setError(0,'error','Ingrese un valor positivo v&aacute;lido. Campo : Cantidad');
				
		$this->Util()->ValidateFloat($value, 6);
		$this->cantidad = $value;
	}
	
	public function getCantidad()
	{
		return $this->cantidad;
	}

	public function setValorUnitario($value)
	{		
		if($this->Util()->ValidateRequireField($value, 'Valor Unitario')){
			if(!is_numeric($value)){
				$this->Util()->setError(0,'error','Ingrese un valor v&aacute;lido. Campo : Valor Unitario');
				return false;
			}
			
//			if($value > 0){
				$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Valor Unitario");
				$this->Util()->ValidateFloat($value, 6);
				$this->valorUnitario = $value;
//			}else{
//				$this->Util()->setError(0,'error','Ingrese un valor positivo. Campo : Valor Unitario.');
//				return false;
//			}		
		}
	}

	public function setPrecioCompra($value)
	{		
		if($this->Util()->ValidateRequireField($value, 'Precio Compra')){
			if(!is_numeric($value)){
				$this->Util()->setError(0,'error','Ingrese un valor v&aacute;lido. Campo : PrecioCompra');
				return false;
			}
			
				$this->Util()->ValidateString($value, $max_chars=50, $minChars = 0, "Precio Compra");
				$this->Util()->ValidateFloat($value, 6);
				$this->precioCompra = $value;
		}
	}
	
	public function getValorUnitario()
	{
		return $this->valorUnitario;
	}

	public function setImporteImpuesto($value)
	{
		$this->Util()->ValidateFloat($value, 6);
		$this->importeImpuesto = $value;
	}
	
	public function getImporteImpuesto()
	{
		return $this->importeImpuesto;
	}

	public function setImporte()
	{
		$value = $this->valorUnitario * $this->cantidad;
		$this->Util()->ValidateFloat($value, 6);
		$this->importe = $value;
	}
	
	public function getImporte()
	{
		return $this->importe;
	}

	public function setDescripcion($value)
	{		
		$this->Util()->ValidateRequireField($value, 'Descripci&oacute;n');
		$this->Util()->ValidateString($value, $max_chars=1000000, $minChars = 0, "Descripci&oacute;n");
		$this->descripcion = $value;
	}
	
	public function getDescripcion()
	{
		return $this->descripcion;
	}

	function Suggest($value)
	{
		$empresa = $this->Info();
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM producto WHERE noIdentificacion LIKE '%".$value."%' AND empresaId = ".$empresa["empresaId"]." AND baja = '0' ORDER BY noIdentificacion LIMIT 25");
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		foreach($result as $key => $periodo)
		{
		}
		return $result;
	}
	
	function GetProductosByRfc()
	{
		$sql = "SELECT COUNT(*) FROM producto 
				WHERE rfcId = ".$this->getRfcActive()." 
				AND baja = '0'
				ORDER BY noIdentificacion";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/admin-productos/nuevos-productos");

		$sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
		
		$sql = "SELECT * FROM producto 
				WHERE rfcId = ".$this->getRfcActive()." 
				AND baja = '0'
				ORDER BY noIdentificacion ".$sqlAdd;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		
		$data["items"] = $result;
		$data["pages"] = $pages;

		return $data;
	}

	function GetProductoInfo()
	{
		$empresa = $this->Info();
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM producto WHERE noIdentificacion = '".$this->noIdentificacion."' AND baja = '0'  AND empresaId = ".$empresa["empresaId"]);
		
		$result = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		return $result;
		
	}
	
	function AgregarConcepto()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		@end($_SESSION["conceptos"]);
		
		$totalIeps = $this->importe * ($this->porcentajeIeps / 100);
		if($this->from == "nueva-factura-ieps" || $this->iepsTasaOCuota == 'Cuota')
		{
			//calcular porcentaje de ieps //cada litro es $1
			$litrosTotales = $this->porcentajeIeps * $this->cantidad;
			$totalIeps = $litrosTotales;
			
			//echo $tasaIeps100 = $this->importe + $totalIeps;
			$tasaIeps100 = $this->importe;
			$this->porcentajeIeps = ($totalIeps * 100) / $tasaIeps100;
		}
		//
		$conceptos = @key($_SESSION["conceptos"]) + 1;
		$_SESSION["conceptos"][$conceptos]["noIdentificacion"] = $this->noIdentificacion;
		$_SESSION["conceptos"][$conceptos]["cantidad"] = $this->cantidad;
		$_SESSION["conceptos"][$conceptos]["unidad"] = $this->unidad;
		$_SESSION["conceptos"][$conceptos]["valorUnitario"] = $this->valorUnitario;
		$_SESSION["conceptos"][$conceptos]["importe"] = $this->importe;
		$_SESSION["conceptos"][$conceptos]["descripcion"] = urldecode($this->descripcion);
		$_SESSION["conceptos"][$conceptos]["categoriaConcepto"] = urldecode($this->categoriaConcepto);
		$_SESSION["conceptos"][$conceptos]["idRecepcion"] = $this->idRecepcion;
		$_SESSION["conceptos"][$conceptos]["item"] = $this->item;
		$_SESSION["conceptos"][$conceptos]["ordenCompra"] = $this->ordenCompra;
		$_SESSION["conceptos"][$conceptos]["tipoGanado"] = $this->tipoGanado;
		$_SESSION["conceptos"][$conceptos]["peso"] = $this->peso;
		$_SESSION["conceptos"][$conceptos]["cuentaPredial"] = $this->cuentaPredial;
		$_SESSION["conceptos"][$conceptos]["claveProdServ"] = $this->claveProdServ;
		$_SESSION["conceptos"][$conceptos]["claveUnidad"] = $this->claveUnidad;

		//ieps
		$_SESSION["conceptos"][$conceptos]["iepsTasaOCuota"] = $this->iepsTasaOCuota;
		$_SESSION["conceptos"][$conceptos]["porcentajeIeps"] = $this->porcentajeIeps;
		$_SESSION["conceptos"][$conceptos]["totalIeps"] = $totalIeps;

		//ish
		$_SESSION["conceptos"][$conceptos]["porcentajeIsh"] = $this->porcentajeIsh;
		$_SESSION["conceptos"][$conceptos]["totalIsh"] = $this->importe * ($this->porcentajeIsh / 100);
		$_SESSION["conceptos"][$conceptos]["excentoIsh"] = $this->excentoIsh;

		//iva
		$_SESSION["conceptos"][$conceptos]["excentoIva"] = $this->excentoIva;
		return true;
	}

	function AgregarImpuesto()
	{
		if($this->Util()->PrintErrors())
		{
			return false;
		}
		
		end($_SESSION["impuestos"]);
		$impuestos = key($_SESSION["impuestos"]) + 1;
		$_SESSION["impuestos"][$impuestos]["tasa"] = $this->tasa;
		$_SESSION["impuestos"][$impuestos]["impuesto"] = urldecode($this->impuesto);
		$_SESSION["impuestos"][$impuestos]["tipo"] = $this->tipo;
		$_SESSION["impuestos"][$impuestos]["importe"] = $this->importeImpuesto;
		$_SESSION["impuestos"][$impuestos]["parent"] = 0;
		$_SESSION["impuestos"][$impuestos]["tasaIva"] = $this->tasaIva;
		
		//desglosar otro para el iva
		if($this->tasaIva)
		{
			end($_SESSION["impuestos"]);
			$impuestos = key($_SESSION["impuestos"]) + 1;
			$_SESSION["impuestos"][$impuestos]["tasa"] = $this->tasa * ($this->tasaIva / 100);
			$_SESSION["impuestos"][$impuestos]["impuesto"] = urldecode($this->tasaIva."% IVA ".$this->impuesto);
			$_SESSION["impuestos"][$impuestos]["tipo"] = $this->tipo;
			$_SESSION["impuestos"][$impuestos]["importe"] = $this->importeImpuesto * ($this->tasaIva / 100);
			$_SESSION["impuestos"][$impuestos]["tasaIva"] = $this->tasaIva;
			
		}
		return true;
	}

	function BorrarImpuesto($key)
	{
		unset($_SESSION["impuestos"][$key]);
		return true;
	}

	function BorrarConcepto($key)
	{
		unset($_SESSION["conceptos"][$key]);
		return true;
	}

	function CleanImpuestos()
	{
		unset($_SESSION["impuestos"]);
	}

	function CleanConceptos()
	{
		unset($_SESSION["conceptos"]);
	}
	
	function GetTotalDesglosado()
	{
		$values = explode("&", $_POST["form"]);
		foreach($values as $key => $val)
		{
			$array = explode("=", $values[$key]);
			$data[$array[0]] = $array[1];
		}

		if(!$_SESSION["conceptos"])
		{
			return false;
		}

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
		foreach($_SESSION["conceptos"] as $key => $concepto)
		{
			$data["ish"] += $concepto["totalIsh"];
		} 

		$paraRetencionIva = 0;
		foreach($_SESSION["conceptos"] as $key => $concepto)
		{
			//cada concepto correrle los impuestos extra.
			$totalImpuesto = 0;
			if($_SESSION["impuestos"])
			{
				$importe = $concepto["importe"];
				foreach($_SESSION["impuestos"] as $keyImpuesto => $impuesto)
				{
					
					//impuesto extra, suma
					if($_SESSION["impuestos"][$keyImpuesto]["importe"] != 0)
					{
//						echo $_SESSION["impuestos"][$keyImpuesto]["importe"];													 
						if($impuesto["tipo"] == "impuesto")
						{
							$concepto["importe"] = $concepto["importe"] + $_SESSION["impuestos"][$keyImpuesto]["importe"];
							$totalImpuesto += $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						elseif($impuesto["tipo"] == "retencion")
						{
							$concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
							$totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						elseif($impuesto["tipo"] == "deduccion")
						{
							$concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
							$totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						elseif($impuesto["tipo"] == "amortizacion")
						{
							$concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
							$totalImpuesto -= $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						continue;
					}
					
					if($impuesto["tipo"] == "impuesto")
					{
						$concepto["importe"] = $concepto["importe"] + ($importe * ($impuesto["tasa"] / 100));
						$_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
					}
					elseif($impuesto["tipo"] == "retencion")
					{
						$concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
						$_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
					}
					elseif($impuesto["tipo"] == "deduccion")
					{
						$concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
						$_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
					}
	
				}//foreach
			}
			$data["subtotalOriginal"] = $this->Util()->RoundNumber($data["subtotalOriginal"] + $importe);
			$data["subtotal"] = $this->Util()->RoundNumber($data["subtotal"] + $concepto["importe"]);
			if($concepto["excentoIva"] == "si")
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = 0;
			}
			else
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
			}

			//porcentaje de descuento
			if($data["porcentajeDescuento"])
			{
				$data["porcentajeDescuento"];
			}

			$data["descuentoThis"] = $this->Util()->RoundNumber($_SESSION["conceptos"][$key]["importe"] * ($data["porcentajeDescuento"] / 100));
			$data["descuento"] += $data["descuentoThis"];
			
			$afterDescuento = $_SESSION["conceptos"][$key]["importe"] - $data["descuentoThis"];
			if($concepto["excentoIva"] == "si")
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = 0;
			}
			else
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
			}

			$data["ivaThis"] = $this->Util()->RoundNumber($afterDescuento * ($_SESSION["conceptos"][$key]["tasaIva"] / 100));
			$data["iva"] += $data["ivaThis"];
			
			//para retencion de iva
			if($concepto["excentoIva"] == "no")
			{
				$paraRetencionIva += $concepto["importe"] - $data["descuentoThis"];
			}

			$_SESSION["conceptos"][$key]["descuento"] = $data["descuentoThis"];
			$_SESSION["conceptos"][$key]["importeTotal"] = $concepto["importe"] - $data["descuentoThis"];
			$_SESSION["conceptos"][$key]["totalIva"] = $_SESSION["conceptos"][$key]["importeTotal"] * (round($_SESSION["conceptos"][$key]["tasaIva"] / 100, 6));
			$_SESSION["conceptos"][$key]["totalIeps"] = $_SESSION["conceptos"][$key]["importeTotal"] * (round($_SESSION["conceptos"][$key]["porcentajeIeps"] / 100, 6));

			$_SESSION["conceptos"][$key]["totalRetencionIva"] = $_SESSION["conceptos"][$key]["importeTotal"] * (round($data["porcentajeRetIva"] / 100, 6));
			$_SESSION["conceptos"][$key]["totalRetencionIsr"] = $_SESSION["conceptos"][$key]["importeTotal"] * (round($data["porcentajeRetIsr"] / 100, 6));

			$data["ieps"] += $this->Util()->RoundNumber($_SESSION["conceptos"][$key]["totalIeps"]);

		}//conceptos
		$data["impuestos"] = $_SESSION["impuestos"];
		$afterDescuento = $data["subtotal"] - $data["descuento"];
		$data["afterDescuento"] = $afterDescuento;
		
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
			$data["ish"] = $this->Util()->RoundNumber($data["ish"] - ($data["ish"] * ($data["porcentajeDescuento"] / 100)));
		}
		else
		{
			$data["ish"] = $this->Util()->RoundNumber($data["ish"]);
		}

		//ish
		$afterImpuestos = $afterDescuento + $data["iva"] + $data["ieps"] + $data["ish"];
		$data["afterImpuestos"] = $afterImpuestos;
		if($_SESSION["empresaId"] == "416")
		{
			$data["retIva"] = $this->Util()->RoundNumber(($data["afterDescuento"] - $totalImpuesto) * ($data["porcentajeRetIva"] / 100));
		}
		else
		{
			$data["retIva"] = $this->Util()->RoundNumber(($paraRetencionIva) * ($data["porcentajeRetIva"] / 100));
		}
		
		$data["retIsr"] = $this->Util()->RoundNumber($data["afterDescuento"] * ($data["porcentajeRetIsr"] / 100));
		$data["total"] = $this->Util()->RoundNumber($data["subtotal"] - $data["descuento"] + $data["iva"] + $data["ieps"] + $data["ish"] - $data["retIva"] - $data["retIsr"]);

		//print_r($data);
		return $data;
	}
	
	function GetTotalDesglosado2($value)
	{
		$values = explode("&", $_POST["form"]);
		foreach($values as $key => $val)
		{
			$array = explode("=", $values[$key]);
			$data[$array[0]] = $array[1];
		}
		
		$data['tasaIva'] = $value;

		if(!$_SESSION["conceptos"])
		{
			return false;
		}

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
		foreach($_SESSION["conceptos"] as $key => $concepto)
		{
			//cada concepto correrle los impuestos extra.
			if($_SESSION["impuestos"])
			{
				$importe = $concepto["importe"];
				foreach($_SESSION["impuestos"] as $keyImpuesto => $impuesto)
				{
					
					//impuesto extra, suma
					if($_SESSION["impuestos"][$keyImpuesto]["importe"] != 0)
					{
//						echo $_SESSION["impuestos"][$keyImpuesto]["importe"];													 
						if($impuesto["tipo"] == "impuesto")
						{
							$concepto["importe"] = $concepto["importe"] + $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						elseif($impuesto["tipo"] == "retencion")
						{
							$concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						elseif($impuesto["tipo"] == "deduccion")
						{
							$concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						elseif($impuesto["tipo"] == "amortizacion")
						{
							$concepto["importe"] = $concepto["importe"] - $_SESSION["impuestos"][$keyImpuesto]["importe"];
						}
						continue;
					}
					
					if($impuesto["tipo"] == "impuesto")
					{
						$concepto["importe"] = $concepto["importe"] + ($importe * ($impuesto["tasa"] / 100));
						$_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
					}
					elseif($impuesto["tipo"] == "retencion")
					{
						$concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
						$_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
					}
					elseif($impuesto["tipo"] == "deduccion")
					{
						$concepto["importe"] = $concepto["importe"] - ($importe * ($impuesto["tasa"] / 100));
						$_SESSION["impuestos"][$keyImpuesto]["importe"] = $importe * ($impuesto["tasa"] / 100);
					}
	
				}//foreach
			}
			$data["subtotalOriginal"] = $this->Util()->RoundNumber($data["subtotalOriginal"] + $importe);
			$data["subtotal"] = $this->Util()->RoundNumber($data["subtotal"] + $concepto["importe"]);
			if($concepto["excentoIva"] == "si")
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = 0;
			}
			else
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
			}

			if($concepto["excentoIsh"] == "si")
			{
				$_SESSION["conceptos"][$key]["tasaIsh"] = 0;
			}
			else
			{
				$_SESSION["conceptos"][$key]["tasaIsh"] = $data["porcentajeISH"];
			}
			//porcentaje de descuento
			if($data["porcentajeDescuento"])
			{
				$data["porcentajeDescuento"];
			}
			
			$data["descuentoThis"] = $this->Util()->RoundNumber($_SESSION["conceptos"][$key]["importe"] * ($data["porcentajeDescuento"] / 100));

			//agregamos aqui lo restante de los conceptos
			$data["descuento"] += $data["descuentoThis"];
			
			$afterDescuento = $_SESSION["conceptos"][$key]["importe"] - $data["descuentoThis"];
			if($concepto["excentoIva"] == "si")
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = 0;
			}
			else
			{
				$_SESSION["conceptos"][$key]["tasaIva"] = $data["tasaIva"];
			}

			if($concepto["excentoIsh"] == "si")
			{
				$_SESSION["conceptos"][$key]["tasaIsh"] = 0;
			}
			else
			{
				$_SESSION["conceptos"][$key]["tasaIsh"] = $data["porcentajeISH"];
			}



			$data["ivaThis"] = $this->Util()->RoundNumber($afterDescuento * ($_SESSION["conceptos"][$key]["tasaIva"] / 100));
			$data["iva"] += $data["ivaThis"];

			$_SESSION["conceptos"][$key]["descuento"] = $data["descuentoThis"];
			$_SESSION["conceptos"][$key]["importeTotal"] = $concepto["importe"] - $data["descuentoThis"];
			$_SESSION["conceptos"][$key]["totalIva"] = $_SESSION["conceptos"][$key]["importeTotal"] * ($_SESSION["conceptos"][$key]["tasaIva"] / 100);
			$_SESSION["conceptos"][$key]["totalIeps"] = $_SESSION["conceptos"][$key]["importeTotal"] * ($_SESSION["conceptos"][$key]["porcentajeIeps"] / 100);
			$data["ieps"] += $this->Util()->RoundNumber($_SESSION["conceptos"][$key]["totalIeps"]);

		}
		$data["impuestos"] = $_SESSION["impuestos"];
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

		//ish
		if(!$data["porcentajeIsh"])
		{
			$data["porcentajeIsh"] = TASA_ISH;
		}
		$data["ish"] = $this->Util()->RoundNumber($data["afterDescuento"] * ($data["porcentajeISH"] / 100));
		
		$afterImpuestos = $afterDescuento + $data["iva"] + $data["ieps"] + $data["ish"];
		
		$data["afterImpuestos"] = $afterImpuestos;

		$data["retIva"] = $this->Util()->RoundNumber($data["afterDescuento"] * ($data["porcentajeRetIva"] / 100));
		$data["retIsr"] = $this->Util()->RoundNumber($data["afterDescuento"] * ($data["porcentajeRetIsr"] / 100));
		$data["total"] = $this->Util()->RoundNumber($data["subtotal"] - $data["descuento"] + $data["iva"] + $data["ieps"] + $data["ish"] - $data["retIva"] - $data["retIsr"]);
		return $data;
	}
	
	function AddProducto(){
	
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		
		$this->Util()->DBSelect($_SESSION['empresaId'])->setQuery("
			INSERT INTO `producto` (
				`empresaId`,
				`noIdentificacion`,
				`unidad`, 
				`valorUnitario`, 
				`precioCompra`, 
				`descripcion`, 
				`rfcId`		
				) 
			VALUES (
				'".$this->getEmpresaId()."',
				'".$this->getNoIdentificacion()."',				
				'".$this->getUnidad()."',
				'".$this->getValorUnitario()."',
				'".$this->precioCompra."',
				'".$this->getDescripcion()."',
				'".$this->getRfcId()."')"
			);
		
		$id_producto = $this->Util()->DBSelect($_SESSION['empresaId'])->InsertData();
		
		$this->Util()->setError(20014, 'complete');
		
		$this->Util()->PrintErrors();
		
		return true;
		
	}//AddProducto
	
	function EditProducto(){
	
		if($this->Util()->PrintErrors()){ 
			return false; 
		}
		$this->Util()->DBSelect($_SESSION['empresaId'])->setQuery("
			UPDATE `producto` SET 
				`empresaId` = '".$this->getEmpresaId()."',
				`noIdentificacion` = '".$this->getNoIdentificacion()."', 
				`unidad` = '".$this->getUnidad()."', 
				`valorUnitario` = '".$this->getValorUnitario()."', 
				`precioCompra` = '".$this->precioCompra."', 
				`descripcion` = '".$this->getDescripcion()."', 
				`rfcId` = '".$this->getRfcId()."'				
			WHERE productoId = '".$this->id_producto."'"
			);
		$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();

		$this->Util()->setError(20016, "complete");
		$this->Util()->PrintErrors();
		
		return true;
		
	}//EditProducto
	
	public function setProductoDelete($value){
		$this->Util()->ValidateString($value, $max_chars=13, $minChars = 1, "ID Producto");
		$this->id_producto = $value;
	}
	
	function DeleteProducto(){
	
		$sql = "UPDATE producto SET baja = '1' 
				WHERE productoId = '".$this->id_producto."'";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		
		$this->Util()->setError(20015, "complete");
		$this->Util()->PrintErrors();
		
		return true;
	}
	
	function getInfoProducto(){
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM producto WHERE productoId ='".$this->id_producto."'");
		$info = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
	
		return $info;
	}
	
}//Producto


?>
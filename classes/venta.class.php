<?php

class Venta extends Producto
{
	private $notaVentaId;
	private $sucursalId;
	private $usuarioId;
	private $fecha;
	private $status;
	
	public function setStatus($value)
	{
		$this->status=$value;
	}//setStatus
	public function setMotivoCancelar($value)
	{
		$this->Util()->ValidateRequireField($value, 'Motivo');
		
		}
	public function setImporteVenta($value)
	{
		$this->Util()->ValidateRequireField($value, 'importedepago');
		if(!is_numeric($value))
			$this->Util()->setError(0,'error','Ingrese un valor v&aacute;lido. Campo : Importe');
		elseif($value <= 0)
			$this->Util()->setError(0,'error','Ingrese un valor positivo v&aacute;lido. Campo : Importe');
		$this->Util()->ValidateFloat($value,7);
		$_SESSION['importe'] = $value;
		if($this->Util()->PrintErrors()){
			return false;
		}else{
			return true;
		}
	}
	public function setUsuarioId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->usuarioId = $value;
	}
	public function setFecha($value)
	{
		$this->fecha = substr($value,0,4)."-".substr($value,4,2)."-".substr($value,6,2)." ".substr($value,8,2).":".substr($value,10,2).":".substr($value,12,2);
	}
	public function setVentaId($value)
	{	
		$this->Util()->ValidateInteger($value);
		$this->notaVentaId = $value;
	}
	public function setSucursalId($value)
	{
		$this->Util()->ValidateInteger($value);
		$this->sucursalId = $value;
	}
	
	public function GetVentaId()
	{
		return $this->notaVentaId;
	}
	
	function UpdateConceptos($conceptos)
	{
		foreach($conceptos as $key => $importe)
		{
			$sql = "SELECT * FROM concepto WHERE conceptoId = '".$key."'";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$producto = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
			
			$cantidad = $producto["cantidad"];
			$valorUnitarioConIva = $importe / $cantidad;
			$valorUnitarioSinIva = $valorUnitarioConIva / (1 + IVA);
			
			$sql = "UPDATE concepto SET valorUnitario = '".$valorUnitarioSinIva."', excentoIva = 'No', importe = '".$importe."' WHERE conceptoId = '".$key."'";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
			
			$subtotal += $valorUnitarioSinIva;
			$iva += $valorUnitarioConIva - $valorUnitarioSinIva;
			
		}
			$total = $iva + $subtotal;
		//update venta
			$sql = "UPDATE notaVenta SET subtotal = '".$subtotal."', iva = '".$iva."', total = '".$total."' WHERE notaVentaId = '".$producto["notaVentaId"]."'";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
			$this->Util()->setError(20010, "complete","Edicion Exitosa");
			$this->Util()->PrintErrors();
		
		return true;
	}
	
	function GetProductos()
	{
		$sql = "SELECT * FROM concepto WHERE notaVentaId = ".$this->notaVentaId;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$productos = $this->Util()->DBSelect($_SESSION["empresaId"])->GetResult();
		return $productos;
	}
	
	function Info()
	{
		$sql = "SELECT * FROM notaVenta WHERE notaVentaId = ".$this->notaVentaId;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$infoVenta = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		return $infoVenta;
	}
	
	function GetInfoVenta($id_venta){
	
		$sqlQuery = 'SELECT notaVenta.*, comprobante.version FROM notaVenta
		LEFT JOIN comprobante ON comprobante.comprobanteId = notaVenta.comprobanteId
		WHERE notaVentaId = '.$id_venta;
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sqlQuery);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		$card['total_formato'] = number_format($row['total'],2,'.',',');
			
		//get payments
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM payment WHERE notaVentaId = '".$id_venta."'");

		$row["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		$row["payments"] = number_format($row["payments_noformat"],2,'.',',');
			
		$row["statusPayment"] = "Debe";
		if($row["payments_noformat"] >= $row['total'])
		{
			$row["statusPayment"] = "Pagada";
		}

		$row["debt"] = number_format($row["total"] - $row["payments_noformat"],2,'.',',');
		$row["debt_noformat"] = $row["total"] - $row["payments_noformat"];
		return $row;
	}//GetInfoVenta
	
	function GetNotasVenta($pagination = true){
	
		global $user;
				
		$id_rfc = $this->getRfcActive();
		
				if($_POST["sucursal"])
				{
					$add .= " AND notaVenta.sucursalId = '".$_POST["sucursal"]."'";
				}

				if($_POST["mes"])
				{
					$add .= " AND MONTH(notaVenta.fecha) = '".$_POST["mes"]."'";
				}

				if($_POST["anio"])
				{
					$add .= " AND YEAR(notaVenta.fecha) = '".$_POST["anio"]."'";
				}

				if($_POST["status_activo"])
				{
					$add .= " AND notaVenta.status = '".$_POST["status_activo"]."'";
				}

				if($_POST["rfc"])
				{
					$add .= " AND cliente.rfc LIKE '%".$_POST["rfc"]."%'";
				}

				if($_POST["razonSocial"])
				{
					$add .= " AND cliente.nombre LIKE '%".$_POST["razonSocial"]."%'";
				}
		
		
    if($pagination) {
      $this->Util()->DBSelect($_SESSION["empresaId"])->setQuery('SELECT COUNT(*) FROM notaVenta 
					LEFT JOIN sucursal ON sucursal.sucursalId = notaVenta.sucursalId
					LEFT JOIN comprobante ON comprobante.comprobanteId = notaVenta.comprobanteId
					LEFT JOIN cliente ON cliente.userId = comprobante.userId
			WHERE 1 '.$add.' ORDER BY notaVenta.fecha DESC');
      $total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

      $pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/reporte-ventas");
      $sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];
    }
    
		$sqlQuery = 'SELECT notaVenta.*, sucursal.identificador, comprobante.serie, comprobante.folio, comprobante.status AS fStatus , cliente.rfc, cliente.nombre FROM notaVenta 
		LEFT JOIN sucursal ON sucursal.sucursalId = notaVenta.sucursalId
		LEFT JOIN comprobante ON comprobante.comprobanteId = notaVenta.comprobanteId
		LEFT JOIN cliente ON cliente.userId = comprobante.userId
		WHERE 1 '.$add.' ORDER BY notaVenta.fecha DESC '.$sqlAdd;
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val)
		{
			$card["rfc"] = $val["rfc"];
			$card["razonSocial"] = $val["nombre"];
			$card["notaVentaId"] = $val["notaVentaId"];
			$card["total"] = $val['total'];
			$card["identificador"] = $val['identificador'];
			$card["serie"] = $val['serie'];
			$card["folio"] = $val['folio'];
			$card["fStatus"] = $val['fStatus'];
			$card['fecha'] = date('d-m-Y',strtotime($val['fecha']));
			$card["status"] = $val["status"];
			$card["subtotal"] = $val["subtotal"];
			$card["iva"] = $val["iva"];
			$card["facturado"] = $val["facturado"];
			
			//get payments
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM payment WHERE notaVentaId = '".$val['notaVentaId']."'");

			$card["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			$card["payments"] = number_format($card["payments_noformat"],2,'.',',');
			
      $card['saldo'] = $card['total'] -$card["payments_noformat"];
      
			$card["statusPayment"] = "Debe";
      
      $rango = 0;
      if($card['saldo'] < 1)
      $rango = 1;
      
      //se le agrego 1 a los pagos para evitar problemas con redondeos
			if(($card["payments_noformat"] + $rango) >= $card['total'])
			{
				$card["statusPayment"] = "Pagada";
			}

			$info[$key] = $card;
			
		}//foreach

		$data["items"] = $info;
		$data["pages"] = $pages;

		return $data;
		
	}//GetComprobantesByRfc
	
	function GenerarNotaVenta($data)
	{
			if(count($_SESSION["conceptos"]) == 0)
				$this->Util()->setError(10041, "error", "Debe agregar al menus un concepto");
			
			if($this->Util()->PrintErrors()){ return false; }
			
			$fecha = $this->Util()->FormatDateAndTime(time());

			$values = explode("&", $data["datosFacturacion"]);
			unset($data["datosFacturacion"]);
			foreach($values as $key => $val)
			{
				$array = explode("=", $values[$key]);
				$data[$array[0]] = $array[1];
			}
			$totales = $this->GetTotalDesglosado($data);

			$sql = "SELECT * FROM usuario WHERE usuarioId = ".$_SESSION["usuarioId"];
			$this->Util()->DB()->setQuery($sql);
			$infoUsuario = $this->Util()->DB()->GetRow();
			
			$descuento = $totales["subtotal"] * ($data["porcentajeDescuento"] / 100);
			$descuentoIva = $totales["subtotal"] * ($data["porcentajeDescuento"] / 100);
			
			$subtotal = $totales["subtotal"] - $descuento;
			$iva = $totales["iva"] - $descuentoIva;
			
			$sql = "
			INSERT INTO `notaVenta` (
				`usuarioId`, 
				`formaDePago`,  
				`sucursalId`,
				`fecha`,
				`subtotal`,
				`iva`,
				`total`
			) VALUES 
			(
				'".$_SESSION["usuarioId"]."', 
				'".$data["formaDePago"]."', 
				'".$data["sucursalId"]."',
				'".$fecha."',
				'".$subtotal."',
				'".$iva."',
				'".$totales["total"]."'
			)";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT notaVentaId FROM notaVenta ORDER BY notaVentaId DESC LIMIT 1");
			$notaVentaId = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		//Insert Conceptos
		
		foreach($_SESSION["conceptos"] as $concepto)
		{
			
			$descuento = $concepto["valorUnitario"] * ($data["porcentajeDescuento"] / 100);
			$valorUnitario = $concepto["valorUnitario"] - $descuento;
			$importe = $valorUnitario * $concepto["cantidad"];

			$sql = "
				INSERT INTO `concepto` (
					`notaVentaId`, 
					`cantidad`, 
					`unidad`, 
					`noIdentificacion`, 
					`descripcion`, 
					`valorUnitario`, 
					`excentoIva`, 
					`importe`, 
					`userId`, 
					`empresaId`
				) VALUES (
					".$notaVentaId.", 
					".$concepto["cantidad"].", 
					'".$concepto["unidad"]."', 
					'".$concepto["noIdentificacion"]."', 
					'".$concepto["descripcion"]."', 
					".$valorUnitario.", 
					'".$concepto["excentoIva"]."', 
					".$importe.", 
					".$_SESSION["usuarioId"].", 
					".$_SESSION["empresaId"]."
					)";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();

			$sql = "UPDATE producto SET disponible = disponible - '".$concepto["cantidad"]."' WHERE noIdentificacion = '".$concepto["noIdentificacion"]."'";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();

		}

		$sql = "INSERT INTO payment(`notaVentaId`,`amount`,`paymentDate`) 
				VALUES(".$notaVentaId.",".$_SESSION["importe"].",'".date("Y-m-d")."')";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
			
		unset($_SESSION["conceptos"]);
		unset($_SESSION["importe"]);
		
		$this->notaVentaId = $notaVentaId;
		
		return true;
		
	}//GenerarNotaVenta
	
	function GetTotalDesglosado($data)
	{
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

		foreach($_SESSION["conceptos"] as $key => $concepto)
		{
			
			//cada concepto correrle los impuestos extra.
			if($_SESSION["impuestos"])
			{
				$importe = $concepto["importe"];
				foreach($_SESSION["impuestos"] as $keyImpuesto => $impuesto)
				{
//					print_r($impuesto);
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
			}//impuestos

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
			//print_r($_SESSION["conceptos"]);

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
			
			$data["ishThis"] = $this->Util()->RoundNumber($afterDescuento * ($_SESSION["conceptos"][$key]["tasaIsh"] / 100));
			$data["ish"] += $data["ishThis"];
			
			$data["valorUnitario"] = $concepto["valorUnitario"];
			$concepto["importe"] = $importe;

		}
		//print_r($data);
		$afterDescuento = $data["subtotal"] - $data["descuento"];

		//ieps de descuento
		if(!$data["porcentajeIEPS"])
		{
			$data["porcentajeIEPS"] = 0;
		}
		$data["ieps"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeIEPS"] / 100));

		//ish de descuento
		if(!$data["porcentajeISH"])
		{
			$data["porcentajeISH"] = 0;
		}
		//$data["ish"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeISH"] / 100));

		$afterImpuestos = $afterDescuento + $data["iva"] + $data["ieps"] + $data["ish"];

		$data["retIva"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeRetIva"] / 100));
		$data["retIsr"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeRetIsr"] / 100));
		$data["total"] = $this->Util()->RoundNumber($data["subtotal"] - $data["descuento"] + $data["iva"] + $data["ieps"] + $data["ish"] - $data["retIva"] - $data["retIsr"]);
		
		return $data;
	}
	
	function notaVentaExist()
	{
		$val = false;
		
		$sql = "SELECT COUNT(*) FROM notaVenta WHERE notaVentaId = ".$this->GetVentaId()." AND usuarioId = ".$this->usuarioId." AND fecha LIKE '".$this->fecha."' AND sucursalId = ".$this->sucursalId." AND facturado = '0'";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		if($row >= 1)
		{
			$val = true;
		}
		
		return $val;
	}
	
	function notaVentaFacturada()
	{
		$val = false;
		
		$sql = "SELECT COUNT(*) FROM notaVenta WHERE notaVentaId = ".$this->GetVentaId()." AND usuarioId = ".$this->usuarioId." AND fecha LIKE '".$this->fecha."' AND sucursalId = ".$this->sucursalId." AND facturado = '1'";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		if($row >= 1)
		{
			$val = true;
		}
		
		return $val;
	}

	function TiempoFacturar()
	{
		$myVenta = $this->Info();
		$dateVenta = strtotime($myVenta["fecha"]);

		$rfc = new Rfc;
		$rfcId = $rfc->getRfcActive();
		$rfc->setRfcId($rfcId);
		
		$nodoEmisorRfc = $rfc->InfoRfc();
		$timeSpan = time() - ($nodoEmisorRfc["diasFacturar"] * 24 * 3600);
		
		if($dateVenta < $timeSpan)
		{
			return false;
		}
		
		return true;
	}

    public function cancelarVenta(){
		 
		if($this->Util()->PrintErrors()){ return false; }
      $sql="update notaVenta  set status='".$this->status."' where notaVentaId='".$this->notaVentaId."' ";
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		$this->Util()->setError(20010, "complete","cancelacion exitosa");
		$this->Util()->PrintErrors();
		return true;
		}//Cancelar Venta

	public function checarPago($importe,$totalVenta)
	{	
		if($importe>$totalVenta)
		{
		$this->Util()->setError(30005,'error','');
		}
		if($this->Util()->PrintErrors()){
			return false;
		}else{
			return true;
		}
	}




} 


?>
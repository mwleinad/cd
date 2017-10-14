<?php

class ComprobanteForma extends Comprobante
{
	
	function Generar($data, $notaCredito = false)
	{
		$myData = urlencode(serialize($data));
		$empresa = $this->Info();
		$values = explode("&", $data["datosFacturacion"]);
		unset($data["datosFacturacion"]);
		foreach($values as $key => $val)
		{
			$array = explode("=", $values[$key]);
			$data[$array[0]] = $array[1];
		}
		
		$tipoSerie = explode("-", $data["tiposComprobanteId"]);
		$data["tiposComprobanteId"] = $tipoSerie[0];
		$data["tiposSerieId"] = $tipoSerie[1];
		
		$vs = new User;
		
		include_once(DOC_ROOT."/addendas/addenda_campos.php");
		
		if($vs->Util()->PrintErrors()){ return false; }
		
		if(!is_numeric($data["numDiasPagados"]) && $data["fromNomina"])
		{
			$vs->Util()->setError(10041, "error", "El numero de dias pagados debe de ser un numero");
		}
		
		$vs->setRFC($data["rfc"]);
		$vs->setCalle($data["calle"]);
		$vs->setPais($data["pais"]);

		if(strlen($data["formaDePago"]) <= 0)
		{
			$vs->Util()->setError(10041, "error", "");
		}

		if(count($_SESSION["conceptos"]) < 1)
		{
			$vs->Util()->setError(10040, "error", "");
		}
		
		if($data["fechaSobre"] != "")
		{
			$vs->Util()->ValidateString($data["fechaSobre"], 10, 10, "Fecha Factura");
		}

		if($data["folioSobre"] != "")
		{
			$vs->Util()->ValidateInteger($data["folioSobre"], 1000000000, 1);
		}
		
		$sobreescribirFecha = false;
		$data["sobreescribirFecha"] = false;
		if($data["fechaSobre"] != "" && $data["folioSobre"] > 0)
		{
			$sobreescribirFecha = true;
			$data["sobreescribirFecha"] = true;
		}
		
		if($vs->Util()->PrintErrors()){ return false; }
		
		$myConceptos = urlencode(serialize($_SESSION["conceptos"]));
		$myImpuestos = urlencode(serialize($_SESSION["impuestos"]));
		
		$userId = $data["userId"];
		
		$totales = $this->GetTotalDesglosado($data);
		if($vs->Util()->PrintErrors()){ return false; }
		
		if(!$data["tipoDeCambio"])
		{
			$data["tipoDeCambio"] = "1.00";
		}

		if(!$data["porcentajeDescuento"])
		{
			$data["porcentajeDescuento"] = "0";
		}

		if(!$data["porcentajeIEPS"])
		{
			$data["porcentajeIEPS"] = "0";
		}
		
		//get active rfc
		$activeRfc =  $vs->getRfcActive();
		//get datos serie de acuerdo al tipo de comprobabte expedido.
		
		if(!$data["metodoDePago"])
		{
			$vs->Util()->setError(10047, "error", "El metodo de pago no puede ser vacio");
		}

		if($data["NumCtaPago"])
		{
			if(strlen($data["NumCtaPago"]) < 4)
			{
				$vs->Util()->setError(10047, "error", "El numero de cuenta debe de tener 4 digitos");
			}
		}
		
		if(!$data["tiposComprobanteId"])
		{
			$vs->Util()->setError(10047, "error");
		}

		if($vs->Util()->PrintErrors()){ return false; }
		
		if($notaCredito)
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM serie WHERE tiposComprobanteId = '2' AND empresaId = ".$_SESSION["empresaId"]." AND rfcId = '".$activeRfc."' AND consecutivo <= folioFinal AND serieId = ".$data["tiposSerieId"]." ORDER BY serieId DESC LIMIT 1");
		}
		else
		{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM serie WHERE tiposComprobanteId = ".$data["tiposComprobanteId"]." AND empresaId = ".$_SESSION["empresaId"]." AND rfcId = '".$activeRfc."' AND consecutivo <= folioFinal AND serieId = ".$data["tiposSerieId"]." ORDER BY serieId DESC LIMIT 1");
		}
		
		$serie = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		if(!$serie)
		{
			$vs->Util()->setError(10047, "error");
		}

		if($vs->Util()->PrintErrors()){ return false; }

		if($sobreescribirFecha === true)
		{
			$folio = $data["folioSobre"];
		}
		else
		{
			$folio = $serie["consecutivo"];
		}
		$fecha = $this->Util()->FormatDateAndTime(time() - 600);
		$fechaPago = $this->Util()->FormatDate(time());
		
		if($_SESSION["empresaId"] == 292)
		{
			//$fecha = "2016-06-30 21:49:52";
		}
		
		$data["fechaPago"] = $fechaPago;
		
		//el tipo de comprobante lo determina tiposComprobanteId
		$tipoDeComprobante = $this->GetTipoComprobante($data["tiposComprobanteId"]);
		if($tipoDeComprobante == 'nomina') {
			$tipoDeComprobante = 'egreso';
		}
		$data["comprobante"] = $this->InfoComprobante($data["tiposComprobanteId"]);

		$data["serie"] = $serie;
		$data["folio"] = $folio;
		$data["fecha"] = $fecha;
//		return;
		$data["tipoDeComprobante"] = $tipoDeComprobante;
		$data["certificado"] = $serie["noCertificado"];

		//build informacion nodo emisor
		$myEmpresa = new Empresa;
		$myEmpresa->setEmpresaId($_SESSION["empresaId"], 1);
		$myEmpresa->setSucursalId($data["sucursalId"]);
		$nodoEmisor = $myEmpresa->GetSucursalInfo();

		$this->setRfcId($activeRfc);
		$nodoEmisorRfc = $this->InfoRfc();
		$data["nodoEmisor"]["sucursal"] = $nodoEmisor;
		$data["nodoEmisor"]["rfc"] = $nodoEmisorRfc;

		if(!$data["nodoEmisor"]["rfc"]["regimenFiscal"])
		{
			$vs->Util()->setError(10047, "error", "Necesitas el Regimen Fiscal, esto se actualiza en Datos Generales, en la opcion de edicion.");
			if($vs->Util()->PrintErrors()){ return false; }
		}

		if($_SESSION["version"] == "auto")
		{
			$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/qrs/";
			$qrRfc = strtoupper($nodoEmisorRfc["rfc"]);
			$nufa = $serie["serieId"]."_".$serie["noAprobacion"]."_".$qrRfc.".png";
			if(!file_exists($rootQr.$nufa))
			{
				$nufa = $serie["serieId"]."_".$serie["noAprobacion"]."_".$qrRfc."_.png";
				if(!file_exists($rootQr.$nufa))
				{
					$nufa = $serie["serieId"].".png";
					if(!file_exists($rootQr.$nufa))
					{
						$vs->Util()->setError(10048, "error");
					}
				}
			}
	
			if($vs->Util()->PrintErrors()){ return false; }
			
		}
		$userId = $data["userId"];
																		 
		//build informacion nodo receptor
		
		if(!$data["fromNomina"])
		{
			$vs->setUserId($userId, 1);
			$nodoReceptor = $vs->GetUserInfo($userId);
			
			$nodoReceptor["rfc"] = str_replace("&AMP;", "&", $nodoReceptor["rfc"]);
			
		}
		else
		{
			$usuario = new Usuario;
			$usuario->setUsuarioId($userId);
			$nodoReceptor = $usuario->InfoUsuario();

		}
		$data["nodoReceptor"] = $nodoReceptor;
		//checar si nos falta unidad en alguno
		foreach($_SESSION["conceptos"] as $concepto)
		{
			if($concepto["unidad"] == "")
			{
				$vs->Util()->setError(10048, "error", "El campo de Unidad no puede ser vacio");
			}
		}

		if($vs->Util()->PrintErrors()){ return false; }
		switch($_SESSION["version"])
		{
			case "auto":
			case "v3":
			case "construc":
				include_once(DOC_ROOT.'/classes/cadena_original_v3.class.php');break;
			case "2": 	
				include_once(DOC_ROOT.'/classes/cadena_original_v2.class.php');break;
		}

		$cadena = new Cadena;
		$cadenaOriginal = $cadena->BuildCadenaOriginal($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"]);

		$data["cadenaOriginal"] = utf8_encode($cadenaOriginal);
		$data["cadenaOriginal"] = $cadenaOriginal;
		$md5Cadena = utf8_decode($cadenaOriginal);

		$md5 = sha1($md5Cadena);

		$sello = $this->GenerarSello($cadenaOriginal, $md5);
		$data["sello"] = $sello["sello"];
		$data["certificado"] = $sello["certificado"];

		switch($_SESSION["version"])
		{
			case "auto":
			case "v3":
			case "construc":
				include_once(DOC_ROOT.'/classes/generate_xml_default.class.php');break;
			case "2":	
				include_once(DOC_ROOT.'/classes/generate_xml_v2.class.php');break;
		}
		
		$xmlGen = new XmlGen;
		$xmlDb = $xmlGen->GenerateXML($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);

		//despues de la generacion del xml, viene el timbrado.
		if($_SESSION["version"] == "v3" || $_SESSION["version"] == "construc")
		{
			$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
			$rfcActivo = $this->getRfcActive();
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/";
			$root_dos = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/timbres/";
			$nufa_dos = "SIGN_".$empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
			$xmlFile = $root.$nufa.".xml";
			$zipFile = $root.$nufa.".zip";
			$signedFile = $root."SIGN_".$nufa.".xml";
			$timbreFile = $root.$nufa."_timbre.zip";
//			$timbradoFile = $root."timbreCFDi.xml";
//			$timbradoFile = $root."/timbres/".$nufa.".xml";
			$timbradoFile = $root.$nufa_dos.".xml";
			//$this->Util()->Zip($root, $nufa);
		
			$user = USER_PAC;
			$pw = PW_PAC;
			$pac = new Pac;
			$response = $pac->GetCfdi($user, $pw, $zipFile, $root, $signedFile, $empresa["empresaId"]);

			if(is_array($response))
			{
				if($response["tipo"] == "error")
				{
					$vs->Util()->setError(10047, "error", utf8_encode($response["msg"]));
					if($vs->Util()->PrintErrors()){ return false; }
				}
			}
	
			$timbreXml = $pac->ParseTimbre($response, $data["sello"]);
			
			$cadenaOriginalTimbre = $pac->GenerateCadenaOriginalTimbre($timbreXml);
			$cadenaOriginalTimbreSerialized = serialize($cadenaOriginalTimbre);

			//add addenda
			if($_SESSION["impuestos"])
			{
				$nufa = "SIGN_".$empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
				$realSignedXml = $root.$nufa.".xml";
				$strAddenda = "<cfdi:Addenda>";
				foreach($_SESSION["impuestos"] as $impuesto)
				{
					$strAddenda .= "  <cfdi:impuesto tipo=\"".$impuesto["tipo"]."\" nombre=\"".$impuesto["impuesto"]."\" importe=\"".$impuesto["importe"]."\" tasa=\"".$impuesto["tasaIva"]."\" />";
				}
				$strAddenda .= "</cfdi:Addenda>";
				
//				$fh = fopen($realSignedXml, 'r');
//			$theData = fread($fh, filesize($realSignedXml));
//				fclose($fh);
//				$theData = str_replace("</cfdi:Complemento>", "</cfdi:Complemento>".$strAddenda, $theData);
				
		
//				$fh = fopen($realSignedXml, 'w') or die("can't open file");
//				fwrite($fh, $theData);
//				fclose($fh);
			}

			include_once(DOC_ROOT."/addendas/addenda_xml.php");


			$data["timbreFiscal"] = $cadenaOriginalTimbre;
		}
		//generatePDF
		//cambios 29 junio 2011		

	switch($data["metodoDePago"])
	{
				case "01": $data["metodoDePagoLetra"] = "Efectivo"; break;
				case "02": $data["metodoDePagoLetra"] = "Cheque"; break;
				case "03": $data["metodoDePagoLetra"] = "Transferencia"; break;
				case "04": $data["metodoDePagoLetra"] = "Tarjetas de Credito"; break;
				case "05": $data["metodoDePagoLetra"] = "Monederos electronicos"; break;
				case "06": $data["metodoDePagoLetra"] = "Dinero electronico"; break;
				case "08": $data["metodoDePagoLetra"] = "Vales de despensa"; break;
				case "28": $data["metodoDePagoLetra"] = "Tarjeta de Debito"; break;
				case "29": $data["metodoDePagoLetra"] = "Tarjeta de Servici"; break;
				case "99": $data["metodoDePagoLetra"] = "Otros"; break;
	}

		if(!$data["fromNomina"])
		{
				include_once(DOC_ROOT."/classes/disenios_facturase.php");
		}
		else
		{
				include_once(DOC_ROOT."/classes/disenios_facturase_nomina.php");
		}
		
			//	return false;
		//cambios 29 junio 2011
		//insert new comprobante
		switch($data["tiposDeMoneda"])
		{
			case "MXN": $data["tiposDeMoneda"] = "peso"; break;
			case "USD": $data["tiposDeMoneda"] = "dolar"; break;
			case "EUR": $data["tiposDeMoneda"] = "euro"; break;
		}
		
		if($_SESSION["empresaId"] == 333)
		{
			$add = "
				`banco`,
				`fechaDeposito`,
				`referencia`,";

			$add2 = "
				'".$data["banco"]."',
				'".$data["fechaDeposito"]."',
				'".$data["referencia"]."',";

		}
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
			INSERT INTO `comprobante` (
				`comprobanteId`, 
				`userId`, 
				`formaDePago`, 
				`condicionesDePago`, 
				`metodoDePago`, 
				`tasaIva`, 
				`tipoDeMoneda`, 
				`tipoDeCambio`, 
				`porcentajeRetIva`, 
				`porcentajeRetIsr`, 
				`tiposComprobanteId`, 
				`porcentajeIEPS`, 
				`porcentajeDescuento`, 
				`empresaId`, 
				`sucursalId`, 
				`observaciones`,
				`serie`,
				`folio`,
				`fecha`,
				`sello`,
				`noAprobacion`,
				`anoAprobacion`,
				`noCertificado`,
				`certificado`,
				`subtotal`,
				`descuento`,
				`motivoDescuento`,
				`total`,
				`tipoDeComprobante`,
				`xml`,
				`rfcId`,
				`ivaTotal`,
				`data`,
				`conceptos`,
				`impuestos`,
				`cadenaOriginal`,
				".$add."
				`timbreFiscal`
			) VALUES 
			(
			 	NULL, 
				'".$userId."', 
				'".$data["formaDePago"]."', 
				'".$data["condicionesDePago"]."', 
				'".$data["metodoDePago"]."', 
				'".$data["tasaIva"]."', 
				'".$data["tiposDeMoneda"]."', 
				'".$data["tipoDeCambio"]."', 
				'".$data["porcentajeRetIva"]."', 
				'".$data["porcentajeRetIsr"]."', 
				'".$data["tiposComprobanteId"]."', 
				'".$data["porcentajeIEPS"]."', 
				'".$data["porcentajeDescuento"]."', 
				'".$empresa["empresaId"]."', 
				'".$data["sucursalId"]."', 
				'".$data["observaciones"]."',
				'".$serie["serie"]."',
				'".$folio."',
				'".$fecha."',
				'".$data["sello"]."',
				'".$serie["noAprobacion"]."',
				'".$serie["anoAprobacion"]."',
				'".$serie["noCertificado"]."',
				'".$data["certificado"]."',
				'".$totales["subtotal"]."',
				'".$totales["descuento"]."',
				'".$data["motivoDescuento"]."',
				'".$totales["total"]."',
				'".$tipoDeComprobante."',
				'".$xmlDb."',
				'".$data["nodoEmisor"]["rfc"]["rfcId"]."',
				'".$totales["iva"]."',
				'".$myData."',
				'".$myConceptos."',
				'".$myImpuestos."',
				'".$data["cadenaOriginal"]."',
				".$add2."
				'".$cadenaOriginalTimbreSerialized."'
			)");
			$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT comprobanteId FROM comprobante ORDER BY comprobanteId DESC LIMIT 1");
			$comprobanteId = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			
		if(!isset($data['notaVentaId']) && !isset($_SESSION['ticketsId']))
		{
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
				'".$totales["subtotal"]."',
				'".$totales["iva"]."',
				'".$totales["total"]."'
			)";
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT notaVentaId FROM notaVenta ORDER BY notaVentaId DESC LIMIT 1");
			$notaVentaId = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			
			//insert conceptos
			foreach($_SESSION["conceptos"] as $concepto)
			{
				$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("
					INSERT INTO `concepto` (
						`comprobanteId`, 
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
						".$concepto["valorUnitario"].", 
						'".$concepto["excentoIva"]."', 
						".$concepto["importe"].", 
						".$userId.", 
						".$empresa["empresaId"]."
						)");
				$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
				
				//quitar del inventario
				$sql = "UPDATE producto SET disponible = disponible - '".$concepto["cantidad"]."' WHERE noIdentificacion = '".$concepto["noIdentificacion"]."'";
				$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
				$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
				
			}
			if($data['cuentaPorPagar'] != "yes")
			{
				$sql = "INSERT INTO payment(`notaVentaId`,`amount`,`paymentDate`) VALUES(".$notaVentaId.",".$totales["total"].",'".date("Y-m-d")."')";
				$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
				$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
			}
			
			$sql = "UPDATE notaVenta SET facturado = '1', comprobanteId = '".$comprobanteId."' WHERE notaVentaId = ".$notaVentaId;
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		}
		//End notaVenta			
		
		if($sobreescribirFecha === true)
		{
			//finally we update the 'consecutivo
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("UPDATE serie SET consecutivo = ".$data["folioSobre"]."+1 WHERE serieId = ".$serie["serieId"]);
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		}
		else
		{
			//finally we update the 'consecutivo
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("UPDATE serie SET consecutivo = consecutivo + 1 WHERE serieId = ".$serie["serieId"]);
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		}

		if(isset($data['notaVentaId']))
		{
			$sql = "UPDATE notaVenta SET facturado = '1', comprobanteId = '".$comprobanteId."' WHERE notaVentaId = ".$data['notaVentaId'];
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		}
		
		if(isset($_SESSION['ticketsId']))
		{
			foreach($_SESSION['ticketsId'] as $key => $resId)
			{
				$sql = "UPDATE notaVenta SET facturado = '1', comprobanteId = '".$comprobanteId."' WHERE notaVentaId = ".$resId;
				$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
				$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
			}
		}
		unset($_SESSION['ticketsId']);
		
		return true;
	}//Generar
}


?>
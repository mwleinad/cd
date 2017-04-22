<?php

class ComprobanteAPI extends Comprobante
{
	
	function Generar($data, $notaCredito = false, $usId = 0)
	{
		//Checamos si existe el ID de la Empresa
		
		$sql = 'SELECT * FROM empresa 
				WHERE empresaId = "'.$_SESSION['empresaId'].'"';
		$this->Util()->DB()->setQuery($sql);
		$empresa = $this->Util()->DB()->GetRow();

		if(!$empresa['empresaId']){
			$msgRet['error'] = 'El ID de la empresa no existe.';
			return $msgRet;
		}
		
		$vs = new User;
		$activeRfc =  $vs->getRfcActive();
		
		//Checamos si existe el RFC del Cliente
		
		$sql = 'SELECT userId FROM cliente 
				WHERE rfc = "'.$data['rfcReceptor'].'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['userId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		if(!$data['userId']){
			$msgRet['error'] = 'El RFC del cliente no existe.';
			return $msgRet;
		}
		
		//Checamos si existe el Tipo de Comprobante
		
		$sql = 'SELECT tiposComprobanteId FROM tiposComprobante 
				WHERE UPPER(nombre) = "'.strtoupper($data['tipoComprobante']).'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['tiposComprobanteId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		if(!$data['tiposComprobanteId']){
			$msgRet['error'] = 'El tipo de comprobante no existe.';
			return $msgRet;
		}
		
		//Checamos si existe la Sucursal
		
		$sql = 'SELECT sucursalId FROM sucursal 
				WHERE UPPER(identificador) = "'.strtoupper($data['sucursal']).'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['sucursalId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		if(!$data['sucursalId']){
			$msgRet['error'] = 'La sucursal no existe.';
			return $msgRet;
		}
				
		//Checamos si existe la Serie
		
		if($notaCredito){
			$sql = 'SELECT serieId FROM serie 
					WHERE tiposComprobanteId = "2" 
					AND empresaId = '.$_SESSION["empresaId"].' 
					AND rfcId = "'.$activeRfc.'" 
					AND consecutivo <= folioFinal 
					AND UPPER(serie) = "'.strtoupper($data["serie"]).'" 
					ORDER BY serieId DESC LIMIT 1';
		}else{
			$sql = 'SELECT serieId FROM serie 
					WHERE UPPER(serie) = "'.strtoupper($data['serie']).'"
					AND sucursalId = "'.$data['sucursalId'].'"
					AND tiposComprobanteId = "'.$data['tiposComprobanteId'].'"
					AND empresaId = '.$_SESSION["empresaId"].'
					AND rfcId = "'.$activeRfc.'"
					AND consecutivo <= folioFinal
					ORDER BY serieId DESC LIMIT 1';
		}
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$data['serieId'] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		if(!$data['serieId']){
			$msgRet['error'] = 'La serie no existe.';
			return $msgRet;
		}
		
		$data["tiposSerieId"] = $data['serieId'];
		
		//Checamos la Forma de Pago
		
		if(strlen($data["formaDePago"]) <= 0){
			$msgRet['error'] = 'La forma de pago no esta definida.';
			return $msgRet;
		}
		
		//*******
		
		$myData = urlencode(serialize($data));
				
		$values = explode("&", $data["datosFacturacion"]);
		unset($data["datosFacturacion"]);
		foreach($values as $key => $val)
		{
			$array = explode("=", $values[$key]);
			$data[$array[0]] = $array[1];
		}
		
		if(count($_SESSION["conceptos"]) < 1)
		{
			$msgRet['error'] = 'No existen conceptos para facturar.';
			return $msgRet;
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
			
		if(!is_numeric($data["numDiasPagados"]) && $data["fromNomina"])
		{
			$msgRet['error'] = 'El numero de dias pagados debe de ser un numero.';
			return $msgRet;
		}
		
		$myConceptos = urlencode(serialize($_SESSION["conceptos"]));
		$myImpuestos = urlencode(serialize($_SESSION["impuestos"]));
		
		$userId = $data["userId"];
		
		$totales = $this->GetTotalDesglosado($data);
				
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
		
		//Get datos serie de acuerdo al tipo de comprobante expedido.
		
		if(!$data["metodoDePago"])
		{
			$msgRet['error'] = 'El metodo de pago no puede ser vacio.';
			return $msgRet;
		}

		if($data["NumCtaPago"])
		{
			if(strlen($data["NumCtaPago"]) < 4)
			{
				$msgRet['error'] = 'El numero de cuenta debe de tener 4 digitos';
				return $msgRet;
			}
		}
		
		$sql = 'SELECT * FROM serie 
				WHERE serieId = "'.$data['serieId'].'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$serie = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
				
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
		$data["fechaPago"] = $fechaPago;
		
		//el tipo de comprobante lo determina tiposComprobanteId
		$tipoDeComprobante = $this->GetTipoComprobante($data["tiposComprobanteId"]);
		$data["comprobante"] = $this->InfoComprobante($data["tiposComprobanteId"]);

		$data["serie"] = $serie;
		$data["folio"] = $folio;
		$data["fecha"] = $fecha;

		$data["tipoDeComprobante"] = $tipoDeComprobante;
		$data["certificado"] = $serie["noCertificado"];

		//Build informacion Nodo Emisor
		
		$myEmpresa = new Empresa;
		$myEmpresa->setEmpresaId($_SESSION["empresaId"], 1);
		$myEmpresa->setSucursalId($data["sucursalId"]);
		$nodoEmisor = $myEmpresa->GetSucursalInfo();

		$this->setRfcId($activeRfc);
		$nodoEmisorRfc = $this->InfoRfc();
		$data["nodoEmisor"]["sucursal"] = $nodoEmisor;
		$data["nodoEmisor"]["rfc"] = $nodoEmisorRfc;

		$data["nodoEmisor"]["sucursal"] = $nodoEmisor;
		$data["nodoEmisor"]["rfc"] = $nodoEmisorRfc;

		if(!$data["nodoEmisor"]["rfc"]["regimenFiscal"])
		{
			$msgRet['error'] = 'Regimen fiscal no definido.';
			return $msgRet;
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
						$msgRet['error'] = 'No has subido tu Codigo de Barras Bidimensional.';
						return $msgRet;
					}
				}
			}
			
		}
		
		$userId = $data["userId"];
																		 
		//Build Nodo Receptor
		
		if(!$data["fromNomina"])
		{			
			$sql = "SELECT * FROM cliente WHERE userId = ".$userId;
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
			$nodoReceptor = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		}
		else
		{
			$usuario = new Usuario;
			$usuario->setUsuarioId($userId);
			$nodoReceptor = $usuario->InfoUsuario();
		}

		$data["nodoReceptor"] = $nodoReceptor;
		
		//Checar si nos falta unidad en alguno
		
		foreach($_SESSION["conceptos"] as $concepto)
		{
			if($concepto["unidad"] == "")
			{
				$msgRet['error'] = 'Falta definir la unidad en uno de los conceptos.';
				return $msgRet;
			}
		}
		
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
//print_r($_SESSION);

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
		$xml = $xmlGen->GenerateXML($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);

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
			$signedFile = $root.$nufa."_signed.zip";
			$timbreFile = $root.$nufa."_timbre.zip";
			$timbradoFile = $root.$nufa_dos.".xml";
			
			$this->Util()->Zip($root, $nufa);
		
			$user = USER_PAC;
			$pw = PW_PAC;
			$pac = new Pac;
			
			$response = $pac->GetCfdi($user, $pw, $zipFile, $root, $signedFile, $empresa["empresaId"]);
			if($response == "fault")
			{
				$msgRet['error'] = 'Ocurrio un error al sellar el comprobante.';
				return $msgRet;
			}
	
			$timbreXml = $pac->ParseTimbre($timbradoFile);
			
			$cadenaOriginalTimbre = $pac->GenerateCadenaOriginalTimbre($timbreXml);
			$cadenaOriginalTimbreSerialized = serialize($cadenaOriginalTimbre);

			//Add addenda
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
				
				$fh = fopen($realSignedXml, 'r');
				$theData = fread($fh, filesize($realSignedXml));
				fclose($fh);
				$theData = str_replace("</cfdi:Complemento>", "</cfdi:Complemento>".$strAddenda, $theData);
				
		
				$fh = fopen($realSignedXml, 'w') or die("can't open file");
				fwrite($fh, $theData);
				fclose($fh);
			}

			$data["timbreFiscal"] = $cadenaOriginalTimbre;
		}
		
		//GeneratePDF
		
		define('SITENAME','FACTURASE');
		
		if(!$data["fromNomina"])
		{
			switch(SITENAME)
			{
				case "FACTURASE": include_once(DOC_ROOT."/classes/disenios_facturase.php"); break;
				default: include_once(DOC_ROOT."/classes/disenios_confactura.php"); break;
			}
		}
		else
		{
			switch(SITENAME)
			{
				case "FACTURASE": include_once(DOC_ROOT."/classes/disenios_facturase_nomina.php"); break;
				default: include_once(DOC_ROOT."/classes/disenios_confactura_nomina.php"); break;
			}
		}
		
		//Insert new comprobante
		switch($data["tiposDeMoneda"])
		{
			case "MXN": $data["tiposDeMoneda"] = "peso"; break;
			case "USD": $data["tiposDeMoneda"] = "dolar"; break;
			case "EUR": $data["tiposDeMoneda"] = "euro"; break;
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
				'".$xml."',
				'".$data["nodoEmisor"]["rfc"]["rfcId"]."',
				'".$totales["iva"]."',
				'".$myData."',
				'".$myConceptos."',
				'".$myImpuestos."',
				'".$data["cadenaOriginal"]."',
				'".$cadenaOriginalTimbreSerialized."'
			)");
			$this->Util()->DBSelect($_SESSION["empresaId"])->InsertData();
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT comprobanteId FROM comprobante ORDER BY comprobanteId DESC LIMIT 1");
			$comprobanteId = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
		
		//NotaVenta
		
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
			
			//Insert conceptos
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
		
		$msgRet['ok'] = 'OK';
		$msgRet['xml'] = $xml;
		$msgRet['folio'] = $folio;
		$msgRet['serie'] = $serie['serie'];
		
		return $msgRet;	
		
	}//Generar
	
	function Cancelar($id_comprobante)
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT noCertificado, xml, rfc FROM comprobante
			LEFT JOIN cliente ON cliente.userId = comprobante.userId
			WHERE comprobanteId = ".$id_comprobante);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();		
		$xml = $row["xml"];

		$info = $this->Info();
		
		if($info["version"] == "v3" || $info["version"] == "construc")
		{			
			$rfcActivo = $this->getRfcActive();
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/SIGN_".$xml.".xml";		
			
			$fh = fopen($root, 'r');
			$theData = fread($fh, filesize($root));
			fclose($fh);
			$theData = explode("UUID", $theData);
			$theData = $theData[1];
			$theData = explode("FechaTimbrado", $theData);
			$theData = $theData[0];
			$uuid = str_replace("\"", "", $theData);
			$uuid = str_replace("=", "", $uuid);
			$uuid = str_replace(" ", "", $uuid);
						
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/";
			if ($handle = opendir($root)) 
			{
				while (false !== ($file = readdir($handle))) 
				{
					$ext = substr($file, -3);
					 if($ext == "pfx")
					 {
						 $key = $file;
					 }
				}
			}
			
			$path = $root.$key;
			
			$user = USER_PAC;
			$pw = PW_PAC;
			$pac = new Pac;
	
			//Get Password
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/password.txt";		
			$fh = fopen($root, 'r');
			$password = fread($fh, filesize($root));
			
			fclose($fh);
	
			if(!$password){
				$msgRet['tipo'] = 'Fail';
				$msgRet['error'] = 'Tienes que actualizar tu certificado para que podamos obtener el password.';
				return $msgRet;
			}
			
			$this->setRfcId($rfcActivo);
			$nodoEmisorRfc = $this->InfoRfc();
			$response = $pac->CancelaCfdi($user, $pw, $nodoEmisorRfc["rfc"], $uuid, $path, $password);
			
		}//if
		
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("UPDATE comprobante SET status = '0' WHERE comprobanteId = ".$id_comprobante);
		$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
		
		$fileName = $xml.".pdf";	
		$path = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/1/facturas/pdf/".$fileName;

		$pdf =& new FPDI();
 
		$pagecount = $pdf->setSourceFile($path); 
		$tplidx = $pdf->importPage(1, '/MediaBox'); 
 
		$pdf->addPage(); 
		$pdf->useTemplate($tplidx, 0, 0, 210); 

		$pdf->AddFont('verdana','','verdana.php');
		$pdf->SetFont('verdana','',72);

		$pdf->SetY(100);
		$pdf->SetX(10);
		$pdf->SetTextColor(200, 0, 0);
	  	$pdf->Cell(20,10,"CANCELADO",0,0,'L');
		$pdf->Output($path, 'F'); 
		
		$msgRet['tipo'] = 'Ok';
		
		return $msgRet;			
		
	}//Cancelar
	
	function GenerarSello($cadenaOriginal, $md5)
	{
		
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/";
		
		if(!is_dir($root))
		{
			mkdir($root, 0777);
		}		
		
		$data["certificado"] = $arr['noCertificado'];
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/";

		if(!is_dir($root))
		{
			mkdir($root, 0777);
		}		

		if ($handle = opendir($root))
		{		
	    	while (false !== ($file = readdir($handle))) 
			{
				$ext = substr($file, -7);
				 if($ext == "cer.pem")
				 {
					 $cert = $file;
				 }

				 if($ext == "key.pem")
				 {
					 $key = $file;
				 }
			}
		}

    	closedir($handle);

		$file = $root.$key; 
		
		//Write md5 to txt
		
		$fp = fopen ($root."/md5.txt", "w+");
    	fwrite($fp, $md5);
		fclose($fp);

		//Sign the original md5 with private key
		exec("openssl dgst -sha1 -sign ".$file." -out ".$root."/md5sha1.txt ".$root."/md5.txt");

		$myFile = $root."/md5sha1.txt";
		$fh = fopen($myFile, 'r');
		$theData = fread($fh, filesize($myFile));
		fclose($fh);
		
		//Generate Public
		exec("openssl rsa -in ".$file." -pubout -out ".$root."/publickey.txt");		
				
		//Verify
		exec("openssl dgst -sha1 -verify ".$root."/publickey.txt -out ".$root."/verified.txt -signature ".$root."/md5sha1.txt ".$root."/md5.txt");		
		
		$cadenaOriginalDecoded = utf8_decode($cadenaOriginal);

		$file = $root.$cert;      // Ruta al archivo
		$datos = file($file);
		$data["certificado"] = ""; 
		$carga=false;
		for ($i=0; $i<sizeof($datos); $i++) 
		{
			if (strstr($datos[$i],"END CERTIFICATE"))
				$carga = false;
			if ($carga){
				$data["certificado"] .= trim($datos[$i]);
			}
			if (strstr($datos[$i],"BEGIN CERTIFICATE"))
				$carga = true;
		}
		$keyFile = $root.$key;
		$pkeyid = openssl_get_privatekey(file_get_contents($root.$key));
		openssl_sign($cadenaOriginalDecoded, $crypttext, $pkeyid, OPENSSL_ALGO_SHA1);

		$data["sello"] = base64_encode($crypttext);  
		
		return $data;
		
	}//GenerarSello
	
}//ComprobanteAPI 


?>
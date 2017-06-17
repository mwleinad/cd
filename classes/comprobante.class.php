<?php

class Comprobante extends Producto
{

	function CancelarComprobanteMantenimiento($data, $id_comprobante, $notaCredito = false, $recipient)
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT noCertificado, xml, rfc, timbreFiscal FROM comprobante
			LEFT JOIN cliente ON cliente.userId = comprobante.userId
			WHERE comprobanteId = ".$id_comprobante);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();		
		$xml = $row["xml"];

		$info = $this->Info();
		
		if($info["version"] == "v3" || $info["version"] == "construc")
		{
			
			$rfcActivo = $this->getRfcActive();
			
			$timbreFiscal = unserialize(urldecode($row["timbreFiscal"]));
			$uuid = $timbreFiscal["UUID"];
			
			
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
	
			//Get password
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/password.txt";		
			$fh = fopen($root, 'r');
			$password = fread($fh, filesize($root));
			
			fclose($fh);
	 
			if(!$password)
			{
				$this->Util()->setError('', "error", "Tienes que actualizar tu certificado para que podamos obtener el password");
				$this->Util()->PrintErrors();
				return false;
			}
			
			$this->setRfcId($rfcActivo);
			$nodoEmisorRfc = $this->InfoRfc();
			$response = $pac->CancelaCfdi($user, $pw, $nodoEmisorRfc["rfc"], $uuid, $path, $password);
			
		}
		
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
		
		$this->Util()->setError('', "complete", "El folio ha sido cancelado exitosamente");
		$this->Util()->PrintErrors();	
				
		return true;			
		
	}//CancelarComprobante

	
	function CancelarComprobante($data, $id_comprobante, $notaCredito = false, $recipient, $motivo_cancelacion)
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
			$uuid = substr($theData, 2, 36);
/*			$theData = explode("noCertificadoSAT", $theData);
			$theData = $theData[0];
			$uuid = str_replace("\"", "", $theData);
			$uuid = str_replace("=", "", $uuid);
			$uuid = str_replace(" ", "", $uuid);
*/					
			//Buscar Pfx			
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
	
			//Get password
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/password.txt";		
			$fh = fopen($root, 'r');
			$password = fread($fh, filesize($root));
			
			fclose($fh);
	
			if(!$password)
			{
				$this->Util()->setError('', "error", "Tienes que actualizar tu certificado para que podamos obtener el password");
				$this->Util()->PrintErrors();
				return false;
			}
			
			$this->setRfcId($rfcActivo);
			$nodoEmisorRfc = $this->InfoRfc();
			$response = $pac->CancelaCfdi($user, $pw, $nodoEmisorRfc["rfc"], $uuid, $path, $password);
			
		}
		if($response === true)
		{
			$date = date("Y-m-d");
			
			$sqlQuery = 'UPDATE comprobante SET motivoCancelacion = "'.$motivo_cancelacion.'", status = "0", fechaPedimento = "'.$date.'" WHERE comprobanteId = '.$id_comprobante;
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sqlQuery);		
			$this->Util()->DBSelect($_SESSION["empresaId"])->UpdateData();
			
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("UPDATE comprobante SET motivoCancelacion = '".$motivo_cancelacion."', status = '0' WHERE comprobanteId = ".$id_comprobante);
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
			
			$this->Util()->setError('', "complete", "El folio ha sido cancelado exitosamente");
			$this->Util()->PrintErrors();	
			return true;
		}
		else
		{
			$this->Util()->setError('', "error", "Hubo un error en la conexion al SAT. Intenta de nuevo mas tarde");
			$this->Util()->PrintErrors();	
			return false;			
		}
				
		
	}//CancelarComprobante
	
	function CancelarComprobanteUUID($data, $id_comprobante, $notaCredito = false, $recipient, $uuid)
	{
	
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT noCertificado, xml, rfc FROM comprobante
			LEFT JOIN cliente ON cliente.userId = comprobante.userId
			WHERE comprobanteId = ".$id_comprobante);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();		
		$xml = $row["xml"];

		$info = $this->Info();
		echo 'inicio';
		echo '<br>';
		if($info["version"] == "v3" || $info["version"] == "construc")
		{
			
			$rfcActivo = $this->getRfcActive();
									
			//Buscar Pfx			
			
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
	
			//Get password
			$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/password.txt";		
			$fh = fopen($root, 'r');
			$password = fread($fh, filesize($root));
			
			fclose($fh);
	
			if(!$password)
			{
				$this->Util()->setError('', "error", "Tienes que actualizar tu certificado para que podamos obtener el password");
				$this->Util()->PrintErrors();
				return false;
			}
			
			$this->setRfcId($rfcActivo);
			$nodoEmisorRfc = $this->InfoRfc();
			$response = $pac->CancelaCfdi($user, $pw, $nodoEmisorRfc["rfc"], $uuid, $path, $password,true);
			
			echo 'aaa';
			print_r($response);
			
		}
		
		echo '<br>';
		echo 'sali';
		
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
		
		$this->Util()->setError('', "complete", "El folio ha sido cancelado exitosamente");
		$this->Util()->PrintErrors();	
				
		return true;			
		
	}//CancelarComprobanteUUID


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
			$data["ieps"] += $concepto["totalIeps"];
			$data["ish"] += $concepto["totalIsh"];
		} 

		foreach($_SESSION["conceptos"] as $key => $concepto)
		{
			$totalImpuesto = 0;
			//cada concepto correrle los impuestos extra.
			if($_SESSION["impuestos"])
			{
				$importe = $concepto["importe"];
				foreach($_SESSION["impuestos"] as $keyImpuesto => $impuesto)
				{
					//impuesto extra, suma
					if($_SESSION["impuestos"][$keyImpuesto]["importe"] != 0)
					{
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
			
			$data["valorUnitario"] = $concepto["valorUnitario"];
			$concepto["importe"] = $importe;
			
			//para retencion de iva'
			if($concepto["excentoIva"] == "no")
			{
				$paraRetencionIva += $_SESSION["conceptos"][$key]["importe"] - $data["descuentoThis"];
			}

		}
		//print_r($data);
		$afterDescuento = $data["subtotal"] - $data["descuento"];

		//ieps de descuento
		if(!$data["porcentajeIEPS"])
		{
			$data["porcentajeIEPS"] = 0;
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
		
		if($data["porcentajeIEPS"] == 0 && $data["ieps"] > 0)
		{
			$data["porcentajeIEPS"] = 1;
		}
		
		//ish de descuento
		if($data["ish"] > 0)
		{
			$data["porcentajeISH"] = TASA_ISH;
		}
		//$data["ish"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeISH"] / 100));
		$afterImpuestos = $afterDescuento + $data["iva"] + $data["ieps"] + $data["ish"];
		if($_SESSION["empresaId"] == "416")
		{
			$data["retIva"] = $this->Util()->RoundNumber(($afterDescuento - $totalImpuesto) * ($data["porcentajeRetIva"] / 100));
			//$data["retIva"] = $this->Util()->RoundNumber(($paraRetencionIva) * ($data["porcentajeRetIva"] / 100));			
		}
		else
		{
			//$data["retIva"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeRetIva"] / 100));
			$data["retIva"] = $this->Util()->RoundNumber(($paraRetencionIva) * ($data["porcentajeRetIva"] / 100));
		}

		$data["retIsr"] = $this->Util()->RoundNumber($afterDescuento * ($data["porcentajeRetIsr"] / 100));
		$data["total"] = $this->Util()->RoundNumber($data["subtotal"] - $data["descuento"] + $data["iva"] + $data["ieps"] + $data["ish"] - $data["retIva"] - $data["retIsr"]);
		
		return $data;
	}
	
	protected function GetTipoComprobante($value)
	{
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT tipoDeComprobante FROM tiposComprobante WHERE tiposComprobanteId = ".$value." LIMIT 1");
			return $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
	}



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

		$file=$root.$key;      // Ruta al archivo
		//write md5 to txt
		$fp = fopen ($root."md5.txt", "w+");
    	fwrite($fp, $md5);
		fclose($fp);


		//sign the original md5 with private key
		exec("openssl dgst -sha1 -sign ".$file." -out ".$root."/md5sha1.txt ".$root."/md5.txt");

		$myFile = $root."/md5sha1.txt";
		$fh = fopen($myFile, 'r');
		$theData = fread($fh, filesize($myFile));
		fclose($fh);
		//generate public
		exec("openssl rsa -in ".$file." -pubout -out ".$root."/publickey.txt");		
				
		//verify
		exec("openssl dgst -sha1 -verify ".$root."/publickey.txt -out ".$root."/verified.txt -signature ".$root."/md5sha1.txt ".$root."/md5.txt");
		
		$cadenaOriginalDecoded = utf8_decode($cadenaOriginal);

		$file = $root.$cert;      // Ruta al archivo
		$datos = file($file);
		$data["certificado"] = ""; 
		$carga=false;
		for ($i=0; $i<sizeof($datos); $i++) 
		{
				if (strstr($datos[$i],"END CERTIFICATE")) $carga=false;
				if ($carga)
				{ 
					$data["certificado"] .= trim($datos[$i]);
					
				}
				if (strstr($datos[$i],"BEGIN CERTIFICATE")) $carga=true;
		}
		$keyFile = $root.$key;
		$pkeyid = openssl_get_privatekey(file_get_contents($root.$key));
//		openssl_sign($cadenaOriginal, $crypttext, $pkeyid, OPENSSL_ALGO_SHA1);
		openssl_sign($cadenaOriginalDecoded, $crypttext, $pkeyid, OPENSSL_ALGO_SHA1);

		$data["sello"] = base64_encode($crypttext);  
		
		return $data;
	}

	function GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa, $cancelado = 0, $vistaPrevia = 0)
	{
	}
	
	/** Demo Testing PDF **/
	
	function GenerateDemoPDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa, $cancelado = 0)
	{
	}
	
	/** End Demo **/



	function GenerarSelloGral($cadenaOriginal, $md5, $certificado, $llave, $pass, $id_rfc)
	{
		$id_empresa = $_SESSION['empresaId'];
		
		$file = DOC_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc.'/'.$certificado.'.pem';      // Ruta al archivo
		$root = DOC_ROOT.'/empresas/'.$id_empresa.'/certificados/'.$id_rfc;

		//write md5 to txt
		$fp = fopen ($root."/md5.txt", "w+");
    	fwrite($fp, $md5);
		fclose($fp);
		
		//generate .key.pem file
		exec('openssl pkcs8 -inform DER -in '.$root.'/'.$certificado.' -out '.$root.'/'.$certificado.'.pem -passin pass:'.$pass);
		
		//generate .cer.pem file
		exec('openssl x509 -inform DER -outform PEM -in '.$root.'/'.$llave.' -out '.$root.'/'.$llave.'.pem');

		//sign the original md5 with private key
		exec("openssl dgst -sha1 -sign ".$file." -out ".$root."/md5sha1.txt ".$root."/md5.txt");

		//generate public
		exec("openssl rsa -in ".$file." -pubout -out ".$root."/publickey.txt");		
				
		//verify
		exec("openssl dgst -sha1 -verify ".$root."/publickey.txt -out ".$root."/verified.txt -signature ".$root."/md5sha1.txt ".$root."/md5.txt");	
		
		//changed 02 agosto
		//generate merge
		$nombreCertificado = substr($llave, 0, -4);
		$noCertificado = $this->Util()->GetNoCertificado($root, $nombreCertificado);
		
		exec('openssl pkcs12 -export -out '.$root.'/'.$noCertificado.'.pfx -inkey '.$root.'/'.$certificado.'.pem -in '.$root.'/'.$llave.'.pem -passout pass:'.$pass);
		//changed 02 agosto
			
	
	}//GenerarSelloGral

	function GetLastComprobante()
	{
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM comprobante ORDER BY comprobanteId DESC");
		
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		$row["path"] = urlencode(WEB_ROOT."/empresas/".$row["empresaId"]."/certificados/".$row["rfcId"]."/facturas/");
		
		return $row;
	}
	
	function GetInfoComprobante($id_comprobante){
	
		$sqlQuery = 'SELECT * FROM comprobante WHERE comprobanteId = '.$id_comprobante;	
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sqlQuery);
		$row = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		
		$card['total_formato'] = number_format($row['total'],2,'.',',');
			
		//get payments
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM payment WHERE comprobanteId = '".$id_comprobante."'");

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
	
	}//GetInfoComprobante
	
	function GetComprobantesByUser(){
	
		global $user;

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery('SELECT COUNT(*) FROM comprobante WHERE userId = '.$_SESSION['userId'].' ORDER BY fecha DESC');
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/cliente-consulta");

		$sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];

		$sqlQuery = 'SELECT * FROM comprobante WHERE userId = '.$_SESSION['userId'].' ORDER BY fecha DESC '.$sqlAdd;
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val){
			
			$user->setUserId2($_SESSION['userId'],1);
			
			$usr = $user->GetUserInfo();
			
			$card['rfc'] = $usr['rfc'];
			$card['nombre'] = $usr['nombre'];
			$card['fecha'] = date('d-m-Y',strtotime($val['fecha']));
			
			$cadenaOriginal = explode("|", $val["cadenaOriginal"]);
			$card['subTotal'] = $val["subTotal"];
			$card['total'] = $val["total"];
																		 
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
		
	}//GetComprobantesByUser
	
	function GetComprobantesByRfc(){
	
		global $user;
				
		$id_rfc = $this->getRfcActive();

		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery('SELECT COUNT(*) FROM comprobante WHERE tiposComprobanteId != 8 AND rfcId = '.$id_rfc.' ORDER BY fecha DESC');
		$total = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();

		$pages = $this->Util->HandleMultipages($this->page, $total ,WEB_ROOT."/sistema/consultar-facturas");

		$sqlAdd = "LIMIT ".$pages["start"].", ".$pages["items_per_page"];

		$sqlQuery = 'SELECT * FROM comprobante WHERE tiposComprobanteId != 8 AND rfcId = '.$id_rfc.' ORDER BY fecha DESC '.$sqlAdd;
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val){
			
			$user->setUserId($val['userId'],1);
			
			$errores = $user->Util()->getErrors();
			$user->Util()->cleanErrors();
			
			if($errores["total"] == 0)
			{
				$usr = $user->GetUserInfo();
			}
			else
			{
				$usr['nombre'] = "Cliente fue Borrado";
				$usr['rfc'] = "Borrado";
			}

			$card['rfc'] = $usr['rfc'];
			$card['nombre'] = $usr['nombre'];
			$card['fecha'] = date('d-m-Y',strtotime($val['fecha']));
			
			$cadenaOriginal = explode("|", $val["cadenaOriginal"]);
			$card['subTotal'] = $val["subTotal"];
			$card['total'] = $val["total"];
																		 
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
	
	function SearchComprobantesByRfc($values){
	
		global $user;
		
		$sqlSearch = '';
		
		if($values['rfc']){
			$sqlSearch .= ' AND cliente.rfc LIKE "%'.$values['rfc'].'%"';
		}//if
		
		if($values['nombre']){
			$sqlSearch .= ' AND cliente.nombre LIKE "%'.$values['nombre'].'%"';
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
				
/*		echo $sqlQuery = 'SELECT 
						c.* 
					FROM 
						comprobante AS c,
						cliente AS u
					WHERE 
							c.userId = u.userId
							AND c.rfcId = '.$id_rfc.$sqlSearch.'							 
					ORDER BY 
							c.fecha DESC';*/

				if($_SESSION["empresaId"] == 333)
				{
					$add = ", cliente.carrera, cliente.noControl";
				}
		 $sqlQuery = 'SELECT 
					comprobante.* '.$add.'
					FROM 
						comprobante
					LEFT JOIN cliente ON cliente.userId = comprobante.userId 
					WHERE 
							tiposComprobanteId != 8 AND comprobante.rfcId = '.$id_rfc.$sqlSearch.'							 
					ORDER BY 
							comprobante.fecha DESC';
				
		$id_empresa = $_SESSION['empresaId'];
		
		$this->Util()->DBSelect($id_empresa)->setQuery($sqlQuery);
		$comprobantes = $this->Util()->DBSelect($id_empresa)->GetResult();
		
		$info = array();
		foreach($comprobantes as $key => $val){
			$user->setUserId($val['userId'],1);
			
			$errores = $user->Util()->getErrors();
			$user->Util()->cleanErrors();
			
			if($errores["total"] == 0)
			{
				$usr = $user->GetUserInfo();
			}
			else
			{
				$usr['nombre'] = "Cliente fue Borrado";
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
			$card['total_formato'] = $val['total'];
			$card['tipoDeMoneda'] = $val['tipoDeMoneda'];
			$card['tipoDeCambio'] = $val['tipoDeCambio'];
			$card['porcentajeRetIva'] = $val['porcentajeRetIva'];
			$card['porcentajeRetIsr'] = $val['porcentajeRetIsr'];
			$card['porcentajeIEPS'] = $val['porcentajeIEPS'];
			$card['comprobanteId'] = $val['comprobanteId'];
			$card['status'] = $val['status'];
			$card['tipoDeComprobante'] = $val['tipoDeComprobante'];
			$card['xml'] = $val['xml'];
			$card['comprobanteId'] = $val['comprobanteId'];


			//get payments
			$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT SUM(amount) FROM payment WHERE comprobanteId = '".$val['comprobanteId']."'");

			$card["payments_noformat"] = $this->Util()->DBSelect($_SESSION["empresaId"])->GetSingle();
			$card["payments"] = number_format($card["payments_noformat"],2,'.',',');
			
			$card["statusPayment"] = "Debe";
			if($card["payments_noformat"] >= $card['total'])
			{
				$card["statusPayment"] = "Pagada";
			}

			if($_SESSION["empresaId"] == 333)
			{
				$card['carrera'] = $val['carrera'];
				$card['control'] = $val['noControl'];
				$card['banco'] = $val['banco'];
				$card['fechaDeposito'] = $val['fechaDeposito'];
				$card['referencia'] = $val['referencia'];
				$conceptos = unserialize(urldecode($val["conceptos"]));
				
				//concepto
				foreach($conceptos as $concepto)
				{
					$card['concepto'] = $concepto["descripcion"];
					break;
				}
			}
			
			$info[$key] = $card;
			
		}//foreach

		$data["items"] = $info;
		$data["pages"] = $pages;

		return $data;
		
	}//SearchComprobantesByRfc
	
	function GenerateQR($data, $totales, $nodoEmisor, $nodoReceptor, $empresa, $serie)
	{
		$total = $this->Util()->RoundNumber($totales["total"], 6);
		$total = $this->Util()->PadStringLeft(number_format($total, 6, ".", ""), 17, "0");
		$cadenaCodigoBarras = "?re=".$data["nodoEmisor"]["rfc"]["rfc"]."&rr=".$nodoReceptor["rfc"]."&tt=".$total."&id=".$data["timbreFiscal"]["UUID"];

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		
		if(!is_dir($rootFacturas))
		{
			mkdir($rootFacturas, 0777);
		}

		if(!is_dir($root))
		{
			mkdir($root, 0777);
		}
		
		//$pdf->Output($root.$nufa.".pdf", "F");
		QRcode::png($cadenaCodigoBarras, $root.$nufa.".png", 'L', 4, 2);

	}

}//Comprobante


require(DOC_ROOT.'/pdf/fpdf.php');
require(DOC_ROOT.'/pdf/fpdi.php');

class PDF extends FPDF
{
	
	var $widths;
	var $aligns;
	var $borders;
//Page header
function Header()
{
    //Logo
		//$this->Image('facturabg.png',0,0, 210, 297);		
    //Arial bold 15
    $this->SetFont('Arial','B',10);
		$this->SetY(0);
		$this->SetX(10);
		//hotel leos
		if($_SESSION["empresaId"] != 278)
		{
				if($_SESSION["empresaId"] != 292 && $_SESSION["empresaId"] != 587 && $_SESSION["empresaId"] != 576  && $_SESSION["empresaId"] != 439  && $_SESSION["empresaId"] != 506)
				{
			    $this->Cell(190,10,'Comprobantes Fiscales Digitales http://www.comprobantedigital.mx',0,0,'C');
				}
		}
		else
		{
			
		}
    //Line break
    $this->Ln(20);
}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-8);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');

}

function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' or $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m', ($x+$r)*$k, ($hp-$y)*$k ));

        $xc = $x+$w-$r;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-$y)*$k ));
        if (strpos($angle, '2')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$y)*$k ));
        else
            $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);

        $xc = $x+$w-$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-$yc)*$k));
        if (strpos($angle, '3')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x+$w)*$k, ($hp-($y+$h))*$k));
        else
            $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x+$r;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2f %.2f l', $xc*$k, ($hp-($y+$h))*$k));
        if (strpos($angle, '4')===false)
            $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-($y+$h))*$k));
        else
            $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);

        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$yc)*$k ));
        if (strpos($angle, '1')===false)
        {
            $this->_out(sprintf('%.2f %.2f l', ($x)*$k, ($hp-$y)*$k ));
            $this->_out(sprintf('%.2f %.2f l', ($x+$r)*$k, ($hp-$y)*$k ));
        }
        else
            $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2f %.2f %.2f %.2f %.2f %.2f c ', $x1*$this->k, ($h-$y1)*$this->k, 
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }
		
	function WordWrap(&$text, $maxwidth)
	{
			$text = trim($text);
			if ($text==='')
					return 0;
			$space = $this->GetStringWidth(' ');
			$lines = explode("\n", $text);
			$text = '';
			$count = 0;
	
			foreach ($lines as $line)
			{
					$words = preg_split('/ +/', $line);
					$width = 0;
	
					foreach ($words as $word)
					{
							$wordwidth = $this->GetStringWidth($word);
							if ($width + $wordwidth <= $maxwidth)
							{
									$width += $wordwidth + $space;
									$text .= $word.' ';
							}
							else
							{
									$width = $wordwidth + $space;
									$text = rtrim($text)."\n".$word.' ';
									$count++;
							}
					}
					$text = rtrim($text)."\n";
					$count++;
			}
			$text = rtrim($text);
			return $count;
	}
	
	function SetWidths($w)
	{
			//Set the array of column widths
			$this->widths=$w;
	}
	
	function SetAligns($a)
	{
			//Set the array of column alignments
			$this->aligns=$a;
	}

	function SetBorders($a)
	{
			//Set the array of column alignments
			$this->borders=$a;
	}
	
	function Row($data, $pixelHeight = 5)
	{
			//Calculate the height of the row
			$nb=0;
			for($i=0;$i<count($data);$i++)
					$nb=max($nb, $this->NbLines($this->widths[$i], $data[$i]));
			$h=$pixelHeight * $nb;
			//Issue a page break first if needed
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++)
			{
					$w=$this->widths[$i];
					$b=$this->borders[$i];
					
					if(!$b)
					{
						$b = 0;
					}
					$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//			print_r($a);
					//Save the current position
					$x=$this->GetX();
					$y=$this->GetY();
					//Draw the border
					//$this->Rect($x, $y, $w, $h);
					//Print the text
					$this->MultiCell($w, $pixelHeight, $data[$i], $b, $a);
					//Put the position to the right of the cell
					$this->SetXY($x+$w, $y);
			}
			//Go to the next line
			$this->Ln($h);
	}
	
	function CheckPageBreak($h)
	{
			//If the height h would cause an overflow, add a new page immediately
			if($this->GetY()+$h>$this->PageBreakTrigger)
					$this->AddPage($this->CurOrientation);
	}
	
	function NbLines($w, $txt)
	{
			//Computes the number of lines a MultiCell of width w will take
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
					$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r", '', $txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
					$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb)
			{
					$c=$s[$i];
					if($c=="\n")
					{
							$i++;
							$sep=-1;
							$j=$i;
							$l=0;
							$nl++;
							continue;
					}
					if($c==' ')
							$sep=$i;
					$l+=$cw[$c];
					if($l>$wmax)
					{
							if($sep==-1)
							{
									if($i==$j)
											$i++;
							}
							else
									$i=$sep+1;
							$sep=-1;
							$j=$i;
							$l=0;
							$nl++;
					}
					else
							$i++;
			}
			return $nl;
	}	
}

class PDF_ImageAlpha extends PDF{ 

	//Private properties 
	var $tmpFiles = array();  
	
	/******************************************************************************* 
	*                                                                              * 
	*                               Public methods                                 * 
	*                                                                              * 
	*******************************************************************************/ 
	function Image($file,$x,$y,$w=0,$h=0,$type='',$link='', $isMask=false, $maskImg=0) 
	{ 
			//Put an image on the page 
			if(!isset($this->images[$file])) 
			{ 
					//First use of image, get info 
					if($type=='') 
					{ 
							$pos=strrpos($file,'.'); 
							if(!$pos) 
									$this->Error('Image file has no extension and no type was specified: '.$file); 
							$type=substr($file,$pos+1); 
					} 
					$type=strtolower($type); 
					$mqr=@get_magic_quotes_runtime(); 
					@set_magic_quotes_runtime(0); 
					if($type=='jpg' || $type=='jpeg') 
							$info=$this->_parsejpg($file); 
					elseif($type=='png'){ 
							$info=$this->_parsepng($file); 
							if ($info=='alpha') return $this->ImagePngWithAlpha($file,$x,$y,$w,$h,$link); 
					} 
					else 
					{ 
							//Allow for additional formats 
							$mtd='_parse'.$type; 
							if(!method_exists($this,$mtd)) 
									$this->Error('Unsupported image type: '.$type); 
							$info=$this->$mtd($file); 
					} 
					@set_magic_quotes_runtime($mqr); 
					 
					if ($isMask){ 
				$info['cs']="DeviceGray"; // try to force grayscale (instead of indexed) 
			} 
					$info['i']=count($this->images)+1; 
					if ($maskImg>0) $info['masked'] = $maskImg;### 
					$this->images[$file]=$info; 
			} 
			else 
					$info=$this->images[$file]; 
			//Automatic width and height calculation if needed 
			if($w==0 && $h==0) 
			{ 
					//Put image at 72 dpi 
					$w=$info['w']/$this->k; 
					$h=$info['h']/$this->k; 
			} 
			if($w==0) 
					$w=$h*$info['w']/$info['h']; 
			if($h==0) 
					$h=$w*$info['h']/$info['w']; 
			 
			if ($isMask) $x = ($this->CurOrientation=='P'?$this->CurPageFormat[0]:$this->CurPageFormat[1]) + 10; // embed hidden, ouside the canvas 
			$this->_out(sprintf('q %.2f 0 0 %.2f %.2f %.2f cm /I%d Do Q',$w*$this->k,$h*$this->k,$x*$this->k,($this->h-($y+$h))*$this->k,$info['i'])); 
			if($link) 
					$this->Link($x,$y,$w,$h,$link); 
					 
			return $info['i']; 
	} 
	
	// needs GD 2.x extension 
	// pixel-wise operation, not very fast 
	function ImagePngWithAlpha($file,$x,$y,$w=0,$h=0,$link='') 
	{ 
			$tmp_alpha = tempnam('.', 'mska'); 
			$this->tmpFiles[] = $tmp_alpha; 
			$tmp_plain = tempnam('.', 'mskp'); 
			$this->tmpFiles[] = $tmp_plain; 
			 
			list($wpx, $hpx) = getimagesize($file); 
			$img = imagecreatefrompng($file); 
			$alpha_img = imagecreate( $wpx, $hpx ); 
			 
			// generate gray scale pallete 
			for($c=0;$c<256;$c++) ImageColorAllocate($alpha_img, $c, $c, $c); 
			 
			// extract alpha channel 
			$xpx=0; 
			while ($xpx<$wpx){ 
					$ypx = 0; 
					while ($ypx<$hpx){ 
							$color_index = imagecolorat($img, $xpx, $ypx); 
							$alpha = 255-($color_index>>24)*255/127; // GD alpha component: 7 bit only, 0..127! 
							imagesetpixel($alpha_img, $xpx, $ypx, $alpha); 
					++$ypx; 
					} 
					++$xpx; 
			} 
	
			imagepng($alpha_img, $tmp_alpha); 
			imagedestroy($alpha_img); 
			 
			// extract image without alpha channel 
			$plain_img = imagecreatetruecolor ( $wpx, $hpx ); 
			imagecopy ($plain_img, $img, 0, 0, 0, 0, $wpx, $hpx ); 
			imagepng($plain_img, $tmp_plain); 
			imagedestroy($plain_img); 
			 
			//first embed mask image (w, h, x, will be ignored) 
			$maskImg = $this->Image($tmp_alpha, 0,0,0,0, 'PNG', '', true);  
			 
			//embed image, masked with previously embedded mask 
			$this->Image($tmp_plain,$x,$y,$w,$h,'PNG',$link, false, $maskImg); 
	} 
	
	function Close() 
	{ 
			parent::Close(); 
			// clean up tmp files 
			foreach($this->tmpFiles as $tmp) @unlink($tmp); 
	} 
	
	/******************************************************************************* 
	*                                                                              * 
	*                               Private methods                                * 
	*                                                                              * 
	*******************************************************************************/ 
	function _putimages() 
	{ 
			$filter=($this->compress) ? '/Filter /FlateDecode ' : ''; 
			reset($this->images); 
			while(list($file,$info)=each($this->images)) 
			{ 
					$this->_newobj(); 
					$this->images[$file]['n']=$this->n; 
					$this->_out('<</Type /XObject'); 
					$this->_out('/Subtype /Image'); 
					$this->_out('/Width '.$info['w']); 
					$this->_out('/Height '.$info['h']); 
					 
					if (isset($info["masked"])) $this->_out('/SMask '.($this->n-1).' 0 R'); ### 
					 
					if($info['cs']=='Indexed') 
							$this->_out('/ColorSpace [/Indexed /DeviceRGB '.(strlen($info['pal'])/3-1).' '.($this->n+1).' 0 R]'); 
					else 
					{ 
							$this->_out('/ColorSpace /'.$info['cs']); 
							if($info['cs']=='DeviceCMYK') 
									$this->_out('/Decode [1 0 1 0 1 0 1 0]'); 
					} 
					$this->_out('/BitsPerComponent '.$info['bpc']); 
					if(isset($info['f'])) 
							$this->_out('/Filter /'.$info['f']); 
					if(isset($info['parms'])) 
							$this->_out($info['parms']); 
					if(isset($info['trns']) && is_array($info['trns'])) 
					{ 
							$trns=''; 
							for($i=0;$i<count($info['trns']);$i++) 
									$trns.=$info['trns'][$i].' '.$info['trns'][$i].' '; 
							$this->_out('/Mask ['.$trns.']'); 
					} 
					$this->_out('/Length '.strlen($info['data']).'>>'); 
					$this->_putstream($info['data']); 
					unset($this->images[$file]['data']); 
					$this->_out('endobj'); 
					//Palette 
					if($info['cs']=='Indexed') 
					{ 
							$this->_newobj(); 
							$pal=($this->compress) ? gzcompress($info['pal']) : $info['pal']; 
							$this->_out('<<'.$filter.'/Length '.strlen($pal).'>>'); 
							$this->_putstream($pal); 
							$this->_out('endobj'); 
					} 
			} 
	} 
	
	// this method overwriing the original version is only needed to make the Image method support PNGs with alpha channels. 
	// if you only use the ImagePngWithAlpha method for such PNGs, you can remove it from this script. 
	function _parsepng($file) 
	{ 
			//Extract info from a PNG file 
			$f=fopen($file,'rb'); 
			if(!$f) 
					$this->Error('Can\'t open image file: '.$file); 
			//Check signature 
			if(fread($f,8)!=chr(137).'PNG'.chr(13).chr(10).chr(26).chr(10)) 
					$this->Error('Not a PNG file: '.$file); 
			//Read header chunk 
			fread($f,4); 
			if(fread($f,4)!='IHDR') 
					$this->Error('Incorrect PNG file: '.$file); 
			$w=$this->_readint($f); 
			$h=$this->_readint($f); 
			$bpc=ord(fread($f,1)); 
			if($bpc>8) 
					$this->Error('16-bit depth not supported: '.$file); 
			$ct=ord(fread($f,1)); 
			if($ct==0) 
					$colspace='DeviceGray'; 
			elseif($ct==2) 
					$colspace='DeviceRGB'; 
			elseif($ct==3) 
					$colspace='Indexed'; 
			else { 
					fclose($f);      // the only changes are  
					return 'alpha';  // made in those 2 lines 
			} 
			if(ord(fread($f,1))!=0) 
					$this->Error('Unknown compression method: '.$file); 
			if(ord(fread($f,1))!=0) 
					$this->Error('Unknown filter method: '.$file); 
			if(ord(fread($f,1))!=0) 
					$this->Error('Interlacing not supported: '.$file); 
			fread($f,4); 
			$parms='/DecodeParms <</Predictor 15 /Colors '.($ct==2 ? 3 : 1).' /BitsPerComponent '.$bpc.' /Columns '.$w.'>>'; 
			//Scan chunks looking for palette, transparency and image data 
			$pal=''; 
			$trns=''; 
			$data=''; 
			do 
			{ 
					$n=$this->_readint($f); 
					$type=fread($f,4); 
					if($type=='PLTE') 
					{ 
							//Read palette 
							$pal=fread($f,$n); 
							fread($f,4); 
					} 
					elseif($type=='tRNS') 
					{ 
							//Read transparency info 
							$t=fread($f,$n); 
							if($ct==0) 
									$trns=array(ord(substr($t,1,1))); 
							elseif($ct==2) 
									$trns=array(ord(substr($t,1,1)),ord(substr($t,3,1)),ord(substr($t,5,1))); 
							else 
							{ 
									$pos=strpos($t,chr(0)); 
									if($pos!==false) 
											$trns=array($pos); 
							} 
							fread($f,4); 
					} 
					elseif($type=='IDAT') 
					{ 
							//Read image data block 
							$data.=fread($f,$n); 
							fread($f,4); 
					} 
					elseif($type=='IEND') 
							break; 
					else 
							fread($f,$n+4); 
			} 
			while($n); 
			if($colspace=='Indexed' && empty($pal)) 
					$this->Error('Missing palette in '.$file); 
			fclose($f); 
			return array('w'=>$w,'h'=>$h,'cs'=>$colspace,'bpc'=>$bpc,'f'=>'FlateDecode','parms'=>$parms,'pal'=>$pal,'trns'=>$trns,'data'=>$data); 
	} 
} 


?>
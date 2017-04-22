<?php

	include_once('../init.php');
	include_once('../config.php');
	include_once(DOC_ROOT.'/libraries.php');
	
	include_once(DOC_ROOT."/classes/override_generator_pdf.class.php");
	
	$ruta = DOC_ROOT.'/temp/';
	
  	foreach ($_FILES as $key) {
		
    	if($key['error'] == UPLOAD_ERR_OK){
		
      		$nombre = $key['name'];
      		$temporal = $key['tmp_name']; 
      	    
			$file = pathinfo($nombre);
			$ext = $file['extension']; 
			
			$pathXml = $ruta.nombre;
			
			if($ext != 'xml'){
				$util->setError(0,'error','Archivo inv&aacute;lido. Debe ser .xml <br>Por favor, verifique.');
				$util->PrintErrors();
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				exit;
			}
			 
			if(!move_uploaded_file($temporal, $pathXml)){
						
				$util->setError(0,'error','Ocurri&oacute; un error al guardar el archivo.');
				$util->PrintErrors();
				echo "fail[#]";
				$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');
				exit;
			}      		
			
    	}else{
		
      		echo $key['error'];
			
    	}//else
		
	}//foreach
			
	//Generamos el PDF.
	
	$xml = simplexml_load_file($pathXml);
	
	$ns = $xml->getNamespaces(true);
	$xml->registerXPathNamespace('c',$ns['cfdi']);
	$xml->registerXPathNamespace('t',$ns['tfd']);
	
	//Comprobante
	
	foreach($xml->xpath('//cfdi:Comprobante') as $comp){
		
		$serie['serie'] = $comp['serie'];
		$serie['noCertificado'] = $comp['noCertificado'];
		
		$data['folio'] = $comp['folio'];
		$fecha = explode('T',$comp['fecha']);
		$data['fecha'] = $fecha[0].' '.$fecha[1];
		$data['tipoDeComprobante'] = $comp['tipoDeComprobante'];
		
		$data['formaDePago'] = $comp['formaDePago'];
		$data['metodoDePago'] = $comp['metodoDePago'];		
		$data['LugarExpedicion'] = $comp['LugarExpedicion'];
		$data['tiposDeMoneda'] = $comp['Moneda'];
		$data['tipoDeCambio'] = $comp['TipoCambio'];
		
		$totales['subtotal'] = $comp['subTotal'];
		$totales['descuento'] = $comp['descuento'];
		$totales['total'] = $comp['total'];		
				
	}//foreach
	
	//Obtenemos la informacion del Comprobante
	
	$sql = 'SELECT * FROM comprobante 
			WHERE serie = "'.$serie['serie'].'" AND folio = "'.$data['folio'].'"';
	$util->DBSelect($_SESSION["empresaId"])->setQuery($sql);
	$fact = $util->DBSelect($_SESSION["empresaId"])->GetRow();
	
	$cancelado = ($fact['status'] == 0) ? 1 : 0;
	
	$data['sucursalId'] = $fact['sucursalId'];
	$data['tiposComprobanteId'] = $fact['tiposComprobanteId'];
	$data['observaciones'] = $fact['observaciones'];
	$data["comprobante"] = $comprobante->InfoComprobante($data["tiposComprobanteId"]);
	
	$empresaId = $_SESSION['empresaId'];
	
	$empresa->setEmpresaId($empresaId);
	$emp = $empresa->Info();
			
	//Retenciones
	
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Retenciones//cfdi:Retencion') as $ret){ 	   
	   	if($ret['impuesto'] == 'IVA')
			$totales['retIva'] = floatval($ret['importe']);
		elseif($ret['impuesto'] == 'ISR')
			$totales['retIsr'] = floatval($ret['importe']); 
	} 
	
	//Traslados
	
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Impuestos//cfdi:Traslados//cfdi:Traslado') as $tras){ 	   
	   	if($tras['impuesto'] == 'IVA'){
			$totales['iva'] = floatval($tras['importe']);
			$totales['tasaIva'] = $tras['tasa'];
		}elseif($tras['impuesto'] == 'IEPS'){
			$totales['ieps'] = floatval($tras['importe']);
			$totales['porcentajeIEPS'] = $tras['tasa'];
		}	   
	} 
	
	//Emisor
	
	$card = array();
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $emisor){		
		$card['rfc'] = $emisor['rfc'];
		$card['razonSocial'] = $emisor['nombre'];						
	}//foreach
	
	//Emisor > Domicilio Fiscal
	
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:DomicilioFiscal') as $domFiscal){		
		$card['calle'] = $domFiscal['calle'];
		$card['noExt'] = $domFiscal['noExterior'];
		$card['noInt'] = $domFiscal['noInterior'];
		$card['colonia'] = $domFiscal['colonia'];
		$card['municipio'] = $domFiscal['municipio'];
		$card['estado'] = $domFiscal['estado'];
		$card['pais'] = $domFiscal['pais'];
		$card['cp'] = $domFiscal['codigoPostal'];				
	}//foreach
	
	//Emisor > Regimen Fiscal
	
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:RegimenFiscal') as $regimen){		
		$card['regimenFiscal'] = $regimen['Regimen'];						
	}//foreach
	
	$data['nodoEmisor']['rfc'] = $card;
	
	//Emisor > Expedido En
	
	$card = array();
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:ExpedidoEn') as $exp){		
		$card['identificador'] = $data['LugarExpedicion'];
		$card['calle'] = $exp['calle'];
		$card['noExt'] = $exp['noExterior'];
		$card['noInt'] = $exp['noInterior'];
		$card['colonia'] = $exp['colonia'];
		$card['municipio'] = $exp['municipio'];
		$card['estado'] = $exp['estado'];
		$card['pais'] = $exp['pais'];
		$card['cp'] = $exp['codigoPostal'];						
	}//foreach
		
	$data['nodoEmisor']['sucursal'] = $card;
	$data['nodoEmisor']['sucursal']['nombre'] = $card['identificador'];
	$data['nodoEmisor']['sucursal']['sucursalActiva'] = 'no';
	
	//Receptor
	
	$card = array();
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $receptor){		
		$card['rfc'] = $receptor['rfc'];
		$card['nombre'] = $receptor['nombre'];						
	}//foreach
	
	//Receptor > Domicilio
	
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Receptor//cfdi:Domicilio') as $dom){		
		$card['calle'] = $dom['calle'];
		$card['noExt'] = $dom['noExterior'];
		$card['noInt'] = $dom['noInterior'];
		$card['colonia'] = $dom['colonia'];
		$card['municipio'] = $dom['municipio'];
		$card['estado'] = $dom['estado'];
		$card['pais'] = $dom['pais'];
		$card['cp'] = $dom['codigoPostal'];				
	}//foreach
		
	$data['nodoReceptor'] = $card;
	$nodoReceptor = $card;
	
	//Conceptos 
	$conceptos = array();
	foreach($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $con){ 	   
	   $conceptos[] = $con;	   
	}
	
	//TimbreFiscalDigital
	
	foreach($xml->xpath('//t:TimbreFiscalDigital') as $tfd){		
		$data['UUID'] = $tfd['UUID'];
		$data['FechaTimbrado'] = $tfd['FechaTimbrado'];
		$data['sello'] = $tfd['selloCFD'];
		$data['selloSAT'] = $tfd['selloSAT'];		
	}//foreach
	
	$sql = 'SELECT serieId FROM serie 
			WHERE serie = "'.$serie['serie'].'" 
			AND sucursalId = '.$fact['sucursalId'];
	$util->DBSelect($_SESSION['empresaId'])->setQuery($sql);
	$serie['serieId'] = $util->DBSelect($_SESSION['empresaId'])->GetSingle();
	
	$infEmp['empresaId'] = $empresaId;
	
	//Cadena Original
	
	switch($emp['version'])
	{
		case 'auto':
		case 'v3':
		case 'construc':
			include_once(DOC_ROOT.'/classes/cadena_original_v3.class.php');break;
		case '2': 	
			include_once(DOC_ROOT.'/classes/cadena_original_v2.class.php');break;
	}
	
	$cadena = new Cadena;
	$cadenaOriginal = $cadena->BuildCadenaOriginal($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $conceptos);
	$data['cadenaOriginal'] = $cadenaOriginal;
	
	//Timbre
	
	$user = USER_PAC;
	$pw = PW_PAC;
	$pac = new Pac;
			
	$nufa = $infEmp["empresaId"]."_".$serie["serie"]."_".$data["folio"];
	$rfcActivo = $rfc->getRfcActive();
	$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/";
	$root_dos = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/timbres/";

	$nufa_dos = "SIGN_".$_SESSION["empresaId"]."_".$serie["serie"]."_".$data["folio"];	
	$timbradoFile = $root.$nufa_dos.".xml";	
	$timbreXml = $pac->ParseTimbre($timbradoFile);		
	$cadenaOriginalTimbre = $pac->GenerateCadenaOriginalTimbre($timbreXml);
	$data['timbreFiscal'] = $cadenaOriginalTimbre;
	
	$override = new Override;
	$override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $conceptos, $infEmp, $cancelado);
	/*
	if($modo == 'ver'){
		
		header('Location: '.WEB_ROOT.'/temp/factura_'.$data['sucursalId'].'.pdf?noCache='.rand());	
		
	}elseif($modo == 'descargar'){
	
		$archivo = 'factura_'.$data['sucursalId'].'.pdf?noCache='.rand();		
		$nomPdf = $_SESSION['empresaId'].'_'.$serie['serie'].'_'.$data['folio'].'.pdf';	
		
		$enlace = WEB_ROOT.'/temp/'.$archivo;

		header ("Content-Disposition: attachment; filename=".$nomPdf."\n\n"); 
		header ("Content-Type: text/pdf"); 		
		readfile($enlace); 
		
	}//elseif
	*/
	
	@unlink($pathXml);
	
	$archivo = 'factura_'.$data['sucursalId'].'.pdf';		
	$nomPdf = $_SESSION['empresaId'].'_'.$serie['serie'].'_'.$data['folio'].'.pdf';	
	$enlace = WEB_ROOT.'/temp/'.$archivo;
	
	$util->setError(0,'complete','El archivo pdf fue generado correctamente.');
	$util->PrintErrors();
	
	echo 'ok[#]';
	$smarty->display(DOC_ROOT.'/templates/boxes/status.tpl');	
	echo '[#]';
	echo '<div align="center">
		  	<a href="'.WEB_ROOT.'/download_pdf.php?archivo='.$enlace.'&nomPdf='.$nomPdf.'">
		  		<img src="'.WEB_ROOT.'/images/pdf_icon.png" width="75" height="80" border="0">
				<br>Descargar Archivo
		  	</a>
		  </div>';

?>
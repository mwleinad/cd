<?php

class XmlTransformCompra extends Comprobante
{
	function Execute($ruta, $archivo)
	{	
		//$file = file_get_contents($archivo);
		$pathXml = $ruta.$archivo;
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
			$data['NumCtaPago'] = $comp['NumCtaPago'];		
			$data['LugarExpedicion'] = $comp['LugarExpedicion'];
			$data['tiposDeMoneda'] = $comp['Moneda'];
			$data['tipoDeCambio'] = $comp['TipoCambio'];
			
			$totales['subtotal'] = $comp['subTotal'];
			$totales['descuento'] = $comp['descuento'];
			$totales['total'] = $comp['total'];		
					
		}//foreach
		
		//Obtenemos la informacion del Comprobante
		
/*		$sql = 'SELECT * FROM comprobante 
				WHERE serie = "'.$serie['serie'].'" AND folio = "'.$data['folio'].'"';
		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery($sql);
		$fact = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		*/
		$cancelado = ($fact['status'] == 0) ? 1 : 0;
		
		$data['sucursalId'] = $fact['sucursalId'];
		$data['tiposComprobanteId'] = $fact['tiposComprobanteId'];
		$data['observaciones'] = $fact['observaciones'];
/*		$comprobante = new Comprobante;
		$data["comprobante"] = $comprobante->InfoComprobante($data["tiposComprobanteId"]);*/
		
		$empresaId = $_SESSION['empresaId'];
		
		$empresa = new Empresa;
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
		
		$tempCard = $card;
		
		//Emisor > Regimen Fiscal
		
		foreach($xml->xpath('//cfdi:Comprobante//cfdi:Emisor//cfdi:RegimenFiscal') as $regimen){		
			$card['regimenFiscal'] = $regimen['Regimen'];						
		}//foreach
		
		$data['nodoEmisor']['rfc'] = $card;
		
		//Emisor > Expedido En
		$expedidoEn = $data['LugarExpedicion'];
		
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
		
		//get 
/*		$this->Util()->DBSelect($_SESSION["empresaId"])->setQuery("SELECT * FROM sucursal WHERE identificador = '".rawurlencode($expedidoEn)."' AND rfcId != 0");
		$sucursal = $this->Util()->DBSelect($_SESSION["empresaId"])->GetRow();
		//Receptor*/

		if(!$card)
		{
			$card['identificador'] = $sucursal['identificador'];
			$card['calle'] = $sucursal['calle'];
			$card['noExt'] = $sucursal['noExt'];
			$card['noInt'] = $sucursal['noInt'];
			$card['colonia'] = $sucursal['colonia'];
			$card['municipio'] = $sucursal['municipio'];
			$card['estado'] = $sucursal['estado'];
			$card['pais'] = $sucursalsucursal['pais'];
			$card['cp'] = $tempCard['cp'];									
		}

		$data['nodoEmisor']['sucursal'] = $card;
		$data['nodoEmisor']['sucursal']['nombre'] = $card['identificador'];
		$data['nodoEmisor']['sucursal']['sucursalActiva'] = 'no';
		
		
		
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
		
	/*	$sql = 'SELECT serieId FROM serie 
				WHERE serie = "'.$serie['serie'].'" 
				AND sucursalId = '.$fact['sucursalId'];
		$this->Util()->DBSelect($_SESSION['empresaId'])->setQuery($sql);
		$serie['serieId'] = $this->Util()->DBSelect($_SESSION['empresaId'])->GetSingle();*/
		
		$infEmp['empresaId'] = $empresaId;
		
		$data["conceptos"] = $conceptos;
		$data["serie"] = $serie;
		$data["totales"] = $totales;
		return $data;

	}//VistaPreviaComprobante
	
}



?>
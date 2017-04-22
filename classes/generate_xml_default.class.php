<?php
class XmlGen extends Producto{

	function CargaAtt(&$nodo, $attr) 
	{
		foreach ($attr as $key => $val) 
		{
    	if (strlen($val)>0) 
			{	   
        $nodo->setAttribute($key,$val);
   	 	}
		}
	}

	function GenerateXML($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa)
	{
		$miEmpresa = $this->Info();
		
		$xml = new DOMdocument("1.0","UTF-8");
		$root = $xml->createElement("cfdi:Comprobante");
		$root = $xml->appendChild($root);
		
		$root->setAttribute("xmlns:cfdi", "http://www.sat.gob.mx/cfd");
		$root->setAttribute("xmlns:cfdi", "http://www.sat.gob.mx/cfd/3");
		$root->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
		
		if($totales['porcentajeISH'] > 0){
			$root->setAttribute("xmlns:implocal", "http://www.sat.gob.mx/implocal");
		}			

		if($miEmpresa['donatarias'] == "Si"){
			$root->setAttribute("xmlns:implocal", "http://www.sat.gob.mx/donat");
		}			

			$infoSucursal = urldecode($data["nodoEmisor"]["sucursal"]["identificador"]);
			$infoSucursal .= urldecode($data["nodoEmisor"]["sucursal"]["calle"]." ".$data["nodoEmisor"]["sucursal"]["noExt"]." ".$data["nodoEmisor"]["sucursal"]["noInt"]);
			$infoSucursal .= urldecode($data["nodoEmisor"]["sucursal"]["colonia"]);
			$infoSucursal .= urldecode($data["nodoEmisor"]["sucursal"]["municipio"]." ".$data["nodoEmisor"]["sucursal"]["estado"]." ".$data["nodoEmisor"]["sucursal"]["pais"]." CP: ".$data["nodoEmisor"]["sucursal"]["cp"]);

			if($data["nodoEmisor"]["sucursal"]["calle"] == "")
			{
				$infoSucursal = utf8_encode(
					urldecode(
						$data["nodoEmisor"]["rfc"]["calle"]." ".
						$data["nodoEmisor"]["rfc"]["noExt"]." ".
						$data["nodoEmisor"]["rfc"]["noInt"]." ".
						$data["nodoEmisor"]["rfc"]["colonia"]." ".
						$data["nodoEmisor"]["rfc"]["municipio"]." ".
						$data["nodoEmisor"]["rfc"]["estado"]." ".
						$data["nodoEmisor"]["rfc"]["pais"]."  
						CP: ".$data["nodoEmisor"]["rfc"]["cp"] 
						)
					);
				
			}

		$data["fecha"] = explode(" ", $data["fecha"]);
		$data["fecha"] = $data["fecha"][0]."T".$data["fecha"][1];
		
		if($data["fromNomina"])
		{
			$tipoDeCambio = $this->Util()->CadenaOriginalVariableFormat($data["tipoDeCambio"], false,false, false, false, true);

			$horasExtraImporte = 0;
			if(count($_SESSION["horasExtras"]) > 0)
			{
				foreach($_SESSION["horasExtras"] as $myHoraExtra)
				{
					$horasExtraImporte += $myHoraExtra["importePagado"];
				}	
			}
			
			$totalPercepciones = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"];
			//$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalPercepciones, true);
	
			$totalDeducciones = $_SESSION["conceptos"]["1"]["deducciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["deducciones"]["totalExcento"] + $_SESSION["conceptos"]["1"]["incapacidades"]["total"];
			//$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totalDeducciones, true);
	
			$totalOtrosPagos = 0;
			foreach($_SESSION["otrosPagos"] as $key => $value)
			{
				$totalOtrosPagos += $value["importe"];
			}
			
			$totales["subtotal"] = $totalPercepciones + $totalOtrosPagos + $horasExtraImporte;
			$totales["descuento"] = $totalDeducciones;
			$totales["total"] = $totales["subtotal"] - $totales["descuento"] ;
			
		}
		else
		{
			$tipoDeCambio = $this->Util()->CadenaOriginalVariableFormat($data["tipoDeCambio"], true,false, true);
		}
	//	$data["fecha"] = "2010-09-22T07:45:09";
		$this->CargaAtt($root, array("version"=>"3.2",
													"serie"=>$this->Util()->CadenaOriginalVariableFormat($serie["serie"],false,false),
													"folio"=>$this->Util()->CadenaOriginalVariableFormat($data["folio"],false,false),
													"fecha"=>$this->Util()->CadenaOriginalVariableFormat($data["fecha"],false,false),
													"sello"=>$data["sello"],
//													"noAprobacion"=>$this->Util()->CadenaOriginalVariableFormat($serie["noAprobacion"],false,false),
//													"anoAprobacion"=>$this->Util()->CadenaOriginalVariableFormat($serie["anoAprobacion"],false,false),
													"tipoDeComprobante"=>$this->Util()->CadenaOriginalVariableFormat($data["tipoDeComprobante"],false,false),
													"formaDePago"=>$this->Util()->CadenaOriginalVariableFormat($data["formaDePago"],false,false),
													"metodoDePago"=>$this->Util()->CadenaOriginalVariableFormat($data["metodoDePago"],false,false),
													"LugarExpedicion"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["cp"],false,false),
													"NumCtaPago"=>$this->Util()->CadenaOriginalVariableFormat($data["NumCtaPago"],false,false),
													"condicionesDePago"=>$this->Util()->CadenaOriginalVariableFormat($data["condicionesDePago"],false,false),
													"noCertificado"=>$this->Util()->CadenaOriginalVariableFormat($serie["noCertificado"],false,false),
													"certificado"=>$data["certificado"],
													"subTotal"=>$this->Util()->CadenaOriginalVariableFormat($totales["subtotal"],true,false),
													"descuento"=>$this->Util()->CadenaOriginalVariableFormat($totales["descuento"], true,false),
													//tipos de cambio
													"TipoCambio"=>$tipoDeCambio,
													"Moneda"=>$this->Util()->CadenaOriginalVariableFormat($data["tiposDeMoneda"], false,false),
													//tipos de cambio
													"total"=>$this->Util()->CadenaOriginalVariableFormat($totales["total"], true,false)
											 )
										);


		$emisor = $xml->createElement("cfdi:Emisor");
		$emisor = $root->appendChild($emisor);
		
		$emisorData = array(
			"rfc"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["rfc"],false,false),
			"nombre"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["razonSocial"],false,false)
		);
		
		
		$this->CargaAtt($emisor, $emisorData);

if(!$data["fromNomina"])
{						
		$domfis = $xml->createElement("cfdi:DomicilioFiscal");
		$domfis = $emisor->appendChild($domfis);
		
		$this->CargaAtt($domfis, array("calle"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["calle"],false,false),
														"noExterior"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["noExt"],false,false),
														"noInterior"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["noInt"],false,false),
														"colonia"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["colonia"],false,false),
														"localidad"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["localidad"],false,false),
														"referencia"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["referencia"],false,false),
														"municipio"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["municipio"],false,false),
														"estado"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["estado"],false,false),
														"pais"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["pais"],false,false),
														"codigoPostal"=>$this->Util()->CadenaOriginalVariableFormat($this->Util()->PadStringLeft($data["nodoEmisor"]["rfc"]["cp"], 5, "0"),false,false)
											 )
										);

	if($data["nodoEmisor"]["sucursal"]["sucursalActiva"] == 'no'){
		
		$suc = $xml->createElement("cfdi:ExpedidoEn");
		$suc = $emisor->appendChild($suc);
		
		$this->CargaAtt($suc, array("calle"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["calle"],false,false),
														"noExterior"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["noExt"],false,false),
														"noInterior"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["noInt"],false,false),
														"colonia"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["colonia"],false,false),
														"localidad"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["localidad"],false,false),
														"referencia"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["referencia"],false,false),
														"municipio"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["municipio"],false,false),
														"estado"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["estado"],false,false),
														"pais"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["pais"],false,false),
														"codigoPostal"=>$this->Util()->CadenaOriginalVariableFormat($this->Util()->PadStringLeft($data["nodoEmisor"]["sucursal"]["cp"], 5, "0"),false,false)
											 )
										);
										
	}//if
}
	
		$regfis = $xml->createElement("cfdi:RegimenFiscal");
		$regfis = $emisor->appendChild($regfis);
		
		$this->CargaAtt($regfis, array("Regimen"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["regimenFiscal"],false,false)
										)				
										);
		
		$receptor = $xml->createElement("cfdi:Receptor");
		$receptor = $root->appendChild($receptor);
		$this->CargaAtt($receptor, array("rfc"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["rfc"],false,false),
															"nombre"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["nombre"],false,false)
													)
											);
											
if(!$data["fromNomina"])
{												
		$domicilio = $xml->createElement("cfdi:Domicilio");
		$domicilio = $receptor->appendChild($domicilio);
		$this->CargaAtt($domicilio, array("calle"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["calle"],false,false),
														"noExterior"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["noExt"],false,false),
														"noInterior"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["noInt"],false,false),
													 "colonia"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["colonia"],false,false),
													 "localidad"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["localidad"],false,false),
													 "referencia"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["referencia"],false,false),
													 "municipio"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["municipio"],false,false),
													 "estado"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["estado"],false,false),
													 "pais"=>$this->Util()->CadenaOriginalVariableFormat($nodoReceptor["pais"],false,false),
													 "codigoPostal"=>$this->Util()->CadenaOriginalVariableFormat($this->Util()->PadStringLeft($nodoReceptor["cp"], 5, "0"),false,false),
											 )
									 );
}

		$conceptos = $xml->createElement("cfdi:Conceptos");
		$conceptos = $root->appendChild($conceptos);
		foreach($nodosConceptos as $concepto) 
		{
			$myConcepto = $xml->createElement("cfdi:Concepto");
			
			if($data["fromNomina"])
			{		
				$cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false,false,false,true);
				$concepto["unidad"] = "ACT";
				$concepto["descripcion"] = "Pago de nómina";
				$concepto["valorUnitario"] = $totales["subtotal"];
				$concepto["importe"] = $totales["subtotal"];
			}
			else
			{
				$cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],true,false);
			}
			
			$myConcepto = $conceptos->appendChild($myConcepto);
			$this->CargaAtt($myConcepto, array("cantidad"=>$cantidad,
																"unidad"=>$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
																"noIdentificacion"=>$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false),
																"descripcion"=>$this->Util()->CadenaOriginalVariableFormat($concepto["descripcion"],false,false),
																"valorUnitario"=>$this->Util()->CadenaOriginalVariableFormat($concepto["valorUnitario"],true,false),
																"importe"=>$this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true,false),
										 )
									);
			//		aca falta la informacion aduanera
			if(strlen($concepto["cuentaPredial"]) > 0)
			{
					$cuentaPredial = $xml->createElement("cfdi:CuentaPredial");
					$cuentaPredial = $myConcepto->appendChild($cuentaPredial);
					$this->CargaAtt($cuentaPredial, array("numero"=>$this->Util()->CadenaOriginalVariableFormat($concepto["cuentaPredial"],false,false),
												 )
											);
			}
		}

		$impuestos = $xml->createElement("cfdi:Impuestos");
		$impuestos = $root->appendChild($impuestos);

		if(!$data["fromNomina"])
		{
			$this->CargaAtt($impuestos, array(
				"totalImpuestosRetenidos" => $this->Util()->CadenaOriginalVariableFormat($totales["retIsr"]+$totales["retIva"],true,false),
				"totalImpuestosTrasladados" => $this->Util()->CadenaOriginalVariableFormat($totales["iva"]+$totales["ieps"],true,false))
							);	

		$retenciones = $xml->createElement("cfdi:Retenciones");
		$retenciones = $impuestos->appendChild($retenciones);

		$retencion = $xml->createElement("cfdi:Retencion");
		$retencion = $retenciones->appendChild($retencion);

		$this->CargaAtt($retencion, array(
				"impuesto" => $this->Util()->CadenaOriginalVariableFormat("IVA",false,false),
				"importe" => $this->Util()->CadenaOriginalVariableFormat($totales["retIva"],true,false))
							);	

		$retencion = $xml->createElement("cfdi:Retencion");
		$retencion = $retenciones->appendChild($retencion);

		$this->CargaAtt($retencion, array(
				"impuesto" => $this->Util()->CadenaOriginalVariableFormat("ISR",false,false),
				"importe" => $this->Util()->CadenaOriginalVariableFormat($totales["retIsr"],true,false))
							);	

		
		$traslados = $xml->createElement("cfdi:Traslados");
		$traslados = $impuestos->appendChild($traslados);

		$traslado = $xml->createElement("cfdi:Traslado");
		$traslado = $traslados->appendChild($traslado);

		$this->CargaAtt($traslado, array(
				"impuesto" => $this->Util()->CadenaOriginalVariableFormat("IVA",false,false),
				"tasa" => $this->Util()->CadenaOriginalVariableFormat($totales["tasaIva"],true,false),
				"importe" => $this->Util()->CadenaOriginalVariableFormat($totales["iva"],true,false))
							);	

		$traslado = $xml->createElement("cfdi:Traslado");
		$traslado = $traslados->appendChild($traslado);

		$this->CargaAtt($traslado, array(
				"impuesto" => $this->Util()->CadenaOriginalVariableFormat("IEPS",false,false),
				"tasa" => $this->Util()->CadenaOriginalVariableFormat($totales["porcentajeIEPS"],true,false),
				"importe" => $this->Util()->CadenaOriginalVariableFormat($totales["ieps"],true,false))
							);	
		}

		$complementos = $xml->createElement("cfdi:Complemento");
		$complementos = $root->appendChild($complementos);
		
		if($data["fromNomina"])
		{
				include_once(DOC_ROOT."/classes/complemento_nomina_12_xml.php");
				$xsdNomina = "http://www.sat.gob.mx/nomina http://www.sat.gob.mx/sitio_internet/cfd/nomina/nomina12.xsd";
		}

		if($miEmpresa["donatarias"] == "Si")
		{
			include_once(DOC_ROOT."/addComplementos/complemento_donataria_xml.php");
			$xsdDonataria = "http://www.sat.gob.mx/donat http://www.sat.gob.mx/sitio_internet/cfd/donat/donat11.xsd";
		}
		
		if($totales['porcentajeISH'] > 0){
			include_once(DOC_ROOT."/addImpuestos/complemento_ish_xml.php");			
		}
				
		$root->setAttribute("xsi:schemaLocation", "http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv32.xsd ".$xsdNomina." ".$xsdDonataria." ".$xsdImplocal);

	//	falta nodo complemento
/**/	
		//$xml->formatOutput = true;
		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/xml/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		
		if(!is_dir($rootFacturas))
		{
			mkdir($rootFacturas, 0777);
		}

		if(!is_dir($root))
		{
			mkdir($root, 0777);
		}

    $xml->save($root.$nufa.".xml");
		return $nufa;
	}
	
}
?>

<?php

class Cadena extends Comprobante
{
	public function BuildCadenaOriginal($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos)
	{
		$miEmpresa = $this->Info();
		//informacion nodo comprobante
		$cadenaOriginal = "||3.2|";
//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($serie["serie"]);
//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["folio"]);
		$data["fecha"] = explode(" ", $data["fecha"]);
		$data["fecha"] = $data["fecha"][0]."T".$data["fecha"][1];
		//$data["fecha"] = "2010-09-22T07:45:09";
		
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
			//$totalOtrosPagos = $_SESSION["conceptos"]["1"]["deducciones"]["total"];
			if(!is_array($_SESSION["otrosPagos"]))
			{
				$_SESSION["otrosPagos"] = array();
			}
			
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
		
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["fecha"]);
//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($serie["noAprobacion"]);
//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($serie["anoAprobacion"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["tipoDeComprobante"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["formaDePago"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["condicionesDePago"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["subtotal"], true);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["descuento"], true);
		//tipo de cambio
		
		if($data["fromNomina"])
		{
			$tipoDeCambio = $this->Util()->CadenaOriginalVariableFormat($data["tipoDeCambio"], false, true, false, false, true);
		}
		else
		{
			$tipoDeCambio = $this->Util()->CadenaOriginalVariableFormat($data["tipoDeCambio"], true,true,true);
		}
		
		$cadenaOriginal .= $tipoDeCambio;
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["tiposDeMoneda"], false);
		
		//tipo de cambio
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["total"], true);

		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["metodoDePago"]);
		
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
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["cp"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["NumCtaPago"]);

		//informacion nodo emisor
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["rfc"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["razonSocial"]);
		
		//informacion nodo domiciliofiscal
if(!$data["fromNomina"])
{									
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["calle"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["noExt"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["noInt"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["colonia"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["localidad"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["referencia"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["municipio"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["estado"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["pais"]);
//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["cp"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($this->Util()->PadStringLeft($data["nodoEmisor"]["rfc"]["cp"], 5, "0"));
		
		if($data["nodoEmisor"]["sucursal"]["sucursalActiva"] == 'no'){
		
			//informacion nodo expedidoen
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["calle"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["noExt"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["noInt"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["colonia"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["localidad"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["referencia"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["municipio"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["estado"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["pais"]);
	//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["sucursal"]["cp"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($this->Util()->PadStringLeft($data["nodoEmisor"]["sucursal"]["cp"], 5, "0"));
		
		}
}
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["regimenFiscal"]);

		//informacion nodo receptor
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["rfc"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["nombre"]);

if(!$data["fromNomina"])
{									

		//informacion nodo domicilio
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["calle"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["noExt"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["noInt"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["colonia"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["localidad"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["referencia"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["municipio"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["estado"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["pais"]);
//		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($nodoReceptor["cp"]);
		$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($this->Util()->PadStringLeft($nodoReceptor["cp"], 5, "0"));
}
		//informacion nodos conceptos
		foreach($nodosConceptos as $concepto)
		{
			if($data["fromNomina"])
			{		
				$cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,true,false,false,true);
				$concepto["unidad"] = "ACT";
				$concepto["descripcion"] = "Pago de nómina";
				$concepto["valorUnitario"] = $totales["subtotal"];
				$concepto["importe"] = $totales["subtotal"];
			}
			else
			{
				$cantidad = $this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],true);
			}
			$cadenaOriginal .= $cantidad;
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($concepto["unidad"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($concepto["descripcion"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($concepto["valorUnitario"],true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($concepto["importe"],true);
			//aca falta la informacion aduanera

			//		aca falta la informacion aduanera
			if(strlen($concepto["cuentaPredial"]) > 0)
			{
				$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($concepto["cuentaPredial"]);
			}
		}
		
		//todo complementoconcepto
		if(!$data["fromNomina"])
		{
			//nodoretenciones
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("IVA");
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["retIva"],true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("ISR");
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["retIsr"],true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["retIsr"]+$totales["retIva"],true);
	
			//nodotraslados
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("IVA");
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["tasaIva"], true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["iva"], true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("IEPS");
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["porcentajeIEPS"], true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["ieps"], true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales["iva"] + $totales["ieps"], true);
		}
		//falta nodo complemento
		
		if($data["fromNomina"])
		{
			$complementoNomina = new ComplementoNomina;
			$cadenaComplementoNomina = $complementoNomina->GenerarCadena($data);
			$cadenaOriginal .= $cadenaComplementoNomina;
		}
		
		//falta nodo complemento
		if($totales['porcentajeISH'] > 0){
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("1.0");
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat(0,true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales['ish'],true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat("ISH");
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales['porcentajeISH'],true);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($totales['ish'],true);
		}		
		
		if($miEmpresa["donatarias"] == "Si")
		{
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat(VERSION_DONATARIAS);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($miEmpresa["noAutorizacion"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($miEmpresa["fechaAutorizacion"]);
			$cadenaOriginal .= $this->Util()->CadenaOriginalVariableFormat($miEmpresa["leyenda"]);
		}
		$cadenaOriginal .= "|";

		$cadenaOriginal = utf8_encode($cadenaOriginal);
		return $cadenaOriginal;
	}
	
}



?>
<?php

//$complementos = $xml->createElement("cfdi:Complemento");
//$complementos = $root->appendChild($complementos);

$myConplementoNomina = $xml->createElement("nomina12:Nomina");
$myConplementoNomina = $complementos->appendChild($myConplementoNomina);

$myConplementoNomina->setAttribute("xmlns:nomina12", "http://www.sat.gob.mx/nomina12");

if($data["nodoReceptor"]["fechaInicioRelLaboral"] == "0000-00-00")
{
	$data["nodoReceptor"]["fechaInicioRelLaboral"] = "1969-01-01";
}

if(!$data["nodoReceptor"]["periodicidadPago"])
{
	$data["nodoReceptor"]["periodicidadPago"] = "Quincenal";
}

$versionNomina = VERSION_NOMINA_12;


		$totalPercepciones = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"] + $horasExtraImporte;

		$totalDeducciones = $_SESSION["conceptos"]["1"]["deducciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["deducciones"]["totalExcento"] + $_SESSION["conceptos"]["1"]["incapacidades"]["total"];
		
		$totalOtrosPagos = 0;
		foreach($_SESSION["otrosPagos"] as $key => $value)
		{
			$totalOtrosPagos += $value["importe"];
		}

if($data["nodoReceptor"]["periodicidadPago"] != 99)
{
	$tipoNomina = "O";
}
else
{
	$tipoNomina = "E";
}

$nominaMain = array(
			"Version"=>$versionNomina,
			"TipoNomina"=>$tipoNomina,
			"FechaPago"=>$this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false, false),
			"FechaInicialPago"=>$this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false, false),
			"FechaFinalPago"=>$this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false, false),
			"NumDiasPagados"=>$this->Util()->CadenaOriginalVariableFormat($data["numDiasPagados"], true, false, false, true),
			"TotalPercepciones"=>$this->Util()->CadenaOriginalVariableFormat($totalPercepciones, true, false),
			);
			
if($totalDeducciones > 0)
{
	$nominaMain["TotalDeducciones"] = $this->Util()->CadenaOriginalVariableFormat($totalDeducciones, true, false);
}

if($totalOtrosPagos > 0)
{
	$nominaMain["TotalOtrosPagos"] = $this->Util()->CadenaOriginalVariableFormat($totalOtrosPagos, true, false);
}

$this->CargaAtt(
	$myConplementoNomina, 
		 $nominaMain
		);

		//nodo emisor
		$emisor = $xml->createElement("nomina12:Emisor");
		$emisor = $myConplementoNomina->appendChild($emisor);

		$emisorData = array(
					"RegistroPatronal"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["registroPatronal"], false, false),
				);		
				
		if(strlen($data["nodoEmisor"]["rfc"]["rfc"]) == 13 && strlen($data["nodoEmisor"]["rfc"]["curp"]) > 0)
		{
			$emisorData["Curp"] = $this->Util()->CadenaOriginalVariableFormat($data["nodoEmisor"]["rfc"]["curp"],false,false);
		}
				
		$this->CargaAtt(
			$emisor, $emisorData
			);
		
		//nodo receptor (sin subcontratacion)
		$antiguedad = $this->Util()->weeks($data["nodoReceptor"]["fechaInicioRelLaboral"], $data["fechaPago"]);
		$antiguedad = "P".$antiguedad."W";
		
		$receptor = $xml->createElement("nomina12:Receptor");
		$receptor = $myConplementoNomina->appendChild($receptor);
		$this->CargaAtt(
			$receptor, 
				array(
					"Curp"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["curp"], false, false),
					"NumSeguridadSocial"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numSeguridadSocial"], false, false),
					"FechaInicioRelLaboral"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["fechaInicioRelLaboral"], false, false),
					"Antigüedad"=>$this->Util()->CadenaOriginalVariableFormat($antiguedad, false, false),
					"TipoContrato"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoContrato"], false, false),
					"TipoJornada"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoJonada"], false, false),
					"TipoRegimen"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoRegimen"], false, false),
					"NumEmpleado"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numEmpleado"], false, false),
					"Departamento"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["departamento"], false, false),
					"Puesto"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["puesto"], false, false),
					"RiesgoPuesto"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["riesgoPuesto"], false, false),
					"PeriodicidadPago"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["periodicidadPago"], false, false),
					//"Banco"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["banco"], false, false),
					//"CuentaBancaria"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["clabe"], false, false),
					"SalarioBaseCotApor"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioBaseCotApor"], true, false),
					"SalarioDiarioIntegrado"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioDiarioIntegrado"], true, false),
					"ClaveEntFed"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["estado"], false, false),
				)
			);

//percepciones
$percepcion = $xml->createElement("nomina12:Percepciones");
$percepcion = $myConplementoNomina->appendChild($percepcion);

$totalSueldos = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"] + $horasExtraImporte;
$totalGravado = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $horasExtraImporte;

$this->CargaAtt(
	$percepcion, 
		array(
			"TotalSueldos"=>$this->Util()->CadenaOriginalVariableFormat($totalSueldos, true, false),
			"TotalGravado"=>$this->Util()->CadenaOriginalVariableFormat($totalGravado, true, false),
			"TotalExento"=>$this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"], true, false),
		)
	);

foreach($_SESSION["percepciones"] as $myPercepcion)
{
	$percepciones = $xml->createElement("nomina12:Percepcion");
	$percepciones = $percepcion->appendChild($percepciones);
	$this->CargaAtt(
		$percepciones, 
			array(
				"TipoPercepcion"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["tipoPercepcion"], false, false),
				"Clave"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["tipoPercepcion"], false, false),
				"Concepto"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["nombrePercepcion"], false, false),
				"ImporteGravado"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["importeGravado"], true, false),
				"ImporteExento"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["importeExcento"], true, false),
			)
		);
}

//nodo horas extra
if(count($_SESSION["horasExtras"]) > 0)
{
	foreach($_SESSION["horasExtras"] as $myHoraExtra)
	{
		$percepciones = $xml->createElement("nomina12:Percepcion");
		$percepciones = $percepcion->appendChild($percepciones);
		//tipo horas extra hacerlo hard code
		$this->CargaAtt(
			$percepciones, 
				array(
					"TipoPercepcion"=>$this->Util()->CadenaOriginalVariableFormat("019", false, false),
					"Clave"=>$this->Util()->CadenaOriginalVariableFormat("003", false, false),
					"Concepto"=>$this->Util()->CadenaOriginalVariableFormat("Horas Extra", false, false),
					"ImporteGravado"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["importePagado"], true, false),
					"ImporteExento"=>$this->Util()->CadenaOriginalVariableFormat(0, true, false),
				)
			);

		$horasExtra = $xml->createElement("nomina12:HorasExtra");
		$horasExtra = $percepciones->appendChild($horasExtra);

		if($myHoraExtra["dias"] == 0)
		{
			$myHoraExtra["dias"] = 1;
		}

		$this->CargaAtt(
			$horasExtra, 
				array(
					"Dias"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["dias"], false, false),
					"TipoHoras"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["tipoHoras"], false, false),
					"HorasExtra"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["horasExtra"], false, false),
					"ImportePagado"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["importePagado"], true, false)
				)
			);
	}	
}

//nodo deducciones
if(count($_SESSION["deducciones"]) > 0)
{
	$totalOtrasDeducciones = 0;
	$totalImpuestosRetenidos = 0;
	
	foreach($_SESSION["deducciones"] as $myDeduccion)
	{
		if($myDeduccion["tipoDeduccion"] == "002")
		{
			$totalImpuestosRetenidos += $myDeduccion["importeExcento"] + $myDeduccion["importeGravado"];
		}
		else
		{
			$totalOtrasDeducciones += $myDeduccion["importeExcento"] + $myDeduccion["importeGravado"];
		}
	}
	
	if(count($_SESSION["incapacidades"]) > 0)
	{
		foreach($_SESSION["incapacidades"] as $myIncapacidad)
		{	
			$totalOtrasDeducciones += $myIncapacidad["descuento"];
		}
	}
	
	$deduccion = $xml->createElement("nomina12:Deducciones");
	$deduccion = $myConplementoNomina->appendChild($deduccion);
	
	$atributosDeduccion["TotalOtrasDeducciones"] = $this->Util()->CadenaOriginalVariableFormat($totalOtrasDeducciones, true, false);
	
	if($totalImpuestosRetenidos > 0)
	{
		$atributosDeduccion["TotalImpuestosRetenidos"] =$this->Util()->CadenaOriginalVariableFormat($totalImpuestosRetenidos, true, false);
	}
	
	$this->CargaAtt(
		$deduccion, 
			$atributosDeduccion
		);
	
	foreach($_SESSION["deducciones"] as $myDeduccion)
	{
		$deducciones = $xml->createElement("nomina12:Deduccion");
		$deducciones = $deduccion->appendChild($deducciones);

		$importe = $myDeduccion["importeGravado"] + $myDeduccion["importeExcento"];
		$this->CargaAtt(
			$deducciones, 
				array(
					"TipoDeduccion"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["tipoDeduccion"], false, false),
					"Clave"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["tipoDeduccion"], false, false),
					"Concepto"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["nombreDeduccion"], false, false),
					"Importe"=>$this->Util()->CadenaOriginalVariableFormat($importe, true, false),
				)
			);
	}
}//count deducciones


//nodo otros pagos
if(count($_SESSION["otrosPagos"]) > 0)
{
$otroPago = $xml->createElement("nomina12:OtrosPagos");
$otroPago = $myConplementoNomina->appendChild($otroPago);

//$totalSueldos = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"] + $horasExtraImporte;
//$totalGravado = $_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"] + $horasExtraImporte;

$this->CargaAtt(
	$otroPago, 
		array(
//			"TotalSueldos"=>$this->Util()->CadenaOriginalVariableFormat($totalSueldos, true, false),
//			"TotalGravado"=>$this->Util()->CadenaOriginalVariableFormat($totalGravado, true, false),
//			"TotalExento"=>$this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"], true, false),
		)
	);

foreach($_SESSION["otrosPagos"] as $myOtroPago)
{
	$otrosPagos = $xml->createElement("nomina12:OtroPago");
	$otrosPagos = $otroPago->appendChild($otrosPagos);
	$this->CargaAtt(
		$otrosPagos, 
			array(
				"TipoOtroPago"=>$this->Util()->CadenaOriginalVariableFormat($myOtroPago["tipoOtroPago"], false, false),
				"Clave"=>$this->Util()->CadenaOriginalVariableFormat($myOtroPago["tipoOtroPago"], false, false),
				"Concepto"=>$this->Util()->CadenaOriginalVariableFormat($myOtroPago["nombreOtroPago"], false, false),
				"Importe"=>$this->Util()->CadenaOriginalVariableFormat($myOtroPago["importe"], true, false),
			)
		);
		
	if($myOtroPago["tipoOtroPago"] == "002")
	{
		$subsidio = $xml->createElement("nomina12:SubsidioAlEmpleo");
		$subsidio = $otrosPagos->appendChild($subsidio);
		$this->CargaAtt(
			$subsidio, 
				array(
					"SubsidioCausado"=>$this->Util()->CadenaOriginalVariableFormat($myOtroPago["importe"], true, false),
				)
			);
	}
	
	if($myOtroPago["tipoOtroPago"] == "004")
	{
		$subsidio = $xml->createElement("nomina12:CompensacionSaldosAFavor");
		$subsidio = $otrosPagos->appendChild($subsidio);
		$this->CargaAtt(
			$subsidio, 
				array(
					"SaldoAFavor"=>$this->Util()->CadenaOriginalVariableFormat($myOtroPago["importe"], true, false),
					"Año"=>$this->Util()->CadenaOriginalVariableFormat(date("Y"), true, false),
					"RemanenteSalFav"=>$this->Util()->CadenaOriginalVariableFormat("0", true, false),
				)
			);
	}
}

//nodo incapacidades
if(count($_SESSION["incapacidades"]) > 0)
{
	$incapacidad = $xml->createElement("nomina12:Incapacidades");
	$incapacidad = $myConplementoNomina->appendChild($incapacidad);
	
	foreach($_SESSION["incapacidades"] as $myIncapacidad)
	{
		$incapacidades = $xml->createElement("nomina12:Incapacidad");
		$incapacidades = $incapacidad->appendChild($incapacidades);
		$this->CargaAtt(
			$incapacidades, 
				array(
					"DiasIncapacidad"=>$this->Util()->CadenaOriginalVariableFormat($myIncapacidad["diasIncapacidad"], true, false,false,false,true),
					"TipoIncapacidad"=>$this->Util()->CadenaOriginalVariableFormat($myIncapacidad["tipoIncapacidad"], false, false),
					"ImporteMonetario"=>$this->Util()->CadenaOriginalVariableFormat($myIncapacidad["descuento"], true, false)
				)
			);
	}
}

}
?>
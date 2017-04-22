<?php

//$complementos = $xml->createElement("cfdi:Complemento");
//$complementos = $root->appendChild($complementos);

$myConplementoNomina = $xml->createElement("nomina:Nomina");
$myConplementoNomina = $complementos->appendChild($myConplementoNomina);

$myConplementoNomina->setAttribute("xmlns:nomina", "http://www.sat.gob.mx/nomina");

if($data["nodoReceptor"]["fechaInicioRelLaboral"] == "0000-00-00")
{
	$data["nodoReceptor"]["fechaInicioRelLaboral"] = "1969-01-01";
}

if(!$data["nodoReceptor"]["periodicidadPago"])
{
	$data["nodoReceptor"]["periodicidadPago"] = "Quincenal";
}

$versionNomina = VERSION_NOMINA;

$this->CargaAtt(
	$myConplementoNomina, 
		array(
			"Version"=>$versionNomina,
			"RegistroPatronal"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["registroPatronal"], false, false),
			"NumEmpleado"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numEmpleado"], false, false),
			"CURP"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["curp"], false, false),
			"TipoRegimen"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoRegimen"], false, false),
			"NumSeguridadSocial"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["numSeguridadSocial"], false, false),
			"FechaPago"=>$this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false, false),
			"FechaInicialPago"=>$this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false, false),
			"FechaFinalPago"=>$this->Util()->CadenaOriginalVariableFormat($data["fechaPago"], false, false),
			"NumDiasPagados"=>$this->Util()->CadenaOriginalVariableFormat($data["numDiasPagados"], true, false),
			"Departamento"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["departamento"], false, false),
			"CLABE"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["clabe"], false, false),
			"Banco"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["banco"], false, false),
			"FechaInicioRelLaboral"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["fechaInicioRelLaboral"], false, false),
			"Puesto"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["puesto"], false, false),
			"TipoContrato"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoContrato"], false, false),
			"TipoJornada"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["tipoJonada"], false, false),
			"PeriodicidadPago"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["periodicidadPago"], false, false),
			"SalarioBaseCotApor"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioBaseCotApor"], true, false),
			"RiesgoPuesto"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["riesgoPuesto"], false, false),
			"SalarioDiarioIntegrado"=>$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["salarioDiarioIntegrado"], true, false),
			)
		);

//percepciones
$percepcion = $xml->createElement("nomina:Percepciones");
$percepcion = $myConplementoNomina->appendChild($percepcion);

$this->CargaAtt(
	$percepcion, 
		array(
			"TotalGravado"=>$this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["percepciones"]["totalGravado"], true, false),
			"TotalExento"=>$this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["percepciones"]["totalExcento"], true, false),
		)
	);

foreach($_SESSION["percepciones"] as $myPercepcion)
{
	$percepciones = $xml->createElement("nomina:Percepcion");
	$percepciones = $percepcion->appendChild($percepciones);
	$this->CargaAtt(
		$percepciones, 
			array(
				"TipoPercepcion"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["tipoPercepcion"], false, false),
				"Clave"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["tipoPercepcion"], false, false),
				"Concepto"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["nombrePercepcion"], false, false),
				"ImporteExento"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["importeExcento"], true, false),
				"ImporteGravado"=>$this->Util()->CadenaOriginalVariableFormat($myPercepcion["importeGravado"], true, false),
			)
		);
}

//nodo deducciones
if(count($_SESSION["deducciones"]) > 0)
{
	$deduccion = $xml->createElement("nomina:Deducciones");
	$deduccion = $myConplementoNomina->appendChild($deduccion);
	
	$this->CargaAtt(
		$deduccion, 
			array(
				"TotalGravado"=>$this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["deducciones"]["totalGravado"], true, false),
				"TotalExento"=>$this->Util()->CadenaOriginalVariableFormat($_SESSION["conceptos"]["1"]["deducciones"]["totalExcento"], true, false),
			)
		);
	
	foreach($_SESSION["deducciones"] as $myDeduccion)
	{
		$deducciones = $xml->createElement("nomina:Deduccion");
		$deducciones = $deduccion->appendChild($deducciones);

		$this->CargaAtt(
			$deducciones, 
				array(
					"TipoDeduccion"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["tipoDeduccion"], false, false),
					"Clave"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["tipoDeduccion"], false, false),
					"Concepto"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["nombreDeduccion"], false, false),
					"ImporteExento"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["importeExcento"], true, false),
					"ImporteGravado"=>$this->Util()->CadenaOriginalVariableFormat($myDeduccion["importeGravado"], true, false),
				)
			);
	}
}//count deducciones

//nodo incapacidades
if(count($_SESSION["incapacidades"]) > 0)
{
	$incapacidad = $xml->createElement("nomina:Incapacidades");
	$incapacidad = $myConplementoNomina->appendChild($incapacidad);
	
	foreach($_SESSION["incapacidades"] as $myIncapacidad)
	{
		$incapacidades = $xml->createElement("nomina:Incapacidad");
		$incapacidades = $incapacidad->appendChild($incapacidades);

		$this->CargaAtt(
			$incapacidades, 
				array(
					"DiasIncapacidad"=>$this->Util()->CadenaOriginalVariableFormat($myIncapacidad["diasIncapacidad"], true, false),
					"TipoIncapacidad"=>$this->Util()->CadenaOriginalVariableFormat($myIncapacidad["tipoIncapacidad"], false, false),
					"Descuento"=>$this->Util()->CadenaOriginalVariableFormat($myIncapacidad["descuento"], true, false)
				)
			);
	}
}

//nodo horas extra
if(count($_SESSION["horasExtras"]) > 0)
{
	$horaExtra = $xml->createElement("nomina:HorasExtras");
	$horaExtra = $myConplementoNomina->appendChild($horaExtra);
	
	foreach($_SESSION["horasExtras"] as $myHoraExtra)
	{
		$horasExtras = $xml->createElement("nomina:HorasExtra");
		$horasExtras = $horaExtra->appendChild($horasExtras);

		$this->CargaAtt(
			$horasExtras, 
				array(
					"Dias"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["dias"], false, false),
					"TipoHoras"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["tipoHoras"], false, false),
					"HorasExtra"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["horasExtra"], false, false),
					"ImportePagado"=>$this->Util()->CadenaOriginalVariableFormat($myHoraExtra["importePagado"], true, false)
				)
			);
	}	
}
?>
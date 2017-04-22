<?php

//$complementos = $xml->createElement("cfdi:Complemento");
//$complementos = $root->appendChild($complementos);

$myConplementoNomina = $xml->createElement("donat:Donatarias");
$myConplementoNomina = $complementos->appendChild($myConplementoNomina);
$myConplementoNomina->setAttribute("xmlns:donat", "http://www.sat.gob.mx/donat");
$this->CargaAtt(
	$myConplementoNomina, 
		array(
			"version"=>VERSION_DONATARIAS,
			"noAutorizacion"=>$this->Util()->CadenaOriginalVariableFormat($miEmpresa["noAutorizacion"], false, false),
			"fechaAutorizacion"=>$this->Util()->CadenaOriginalVariableFormat($miEmpresa["fechaAutorizacion"], false, false),
			"leyenda"=>$this->Util()->CadenaOriginalVariableFormat($miEmpresa["leyenda"], false, false),
			)
		);
?>
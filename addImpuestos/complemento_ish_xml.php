<?php
			$impuestoslocales = $xml->createElement("implocal:ImpuestosLocales");
			$impuestoslocales = $complementos->appendChild($impuestoslocales);
			$this->CargaAtt($impuestoslocales, array(
					"TotaldeRetenciones" => $this->Util()->CadenaOriginalVariableFormat(0,true,false),
					"TotaldeTraslados"   => $this->Util()->CadenaOriginalVariableFormat($totales['ish'],true,false),
					"version" => $this->Util()->CadenaOriginalVariableFormat("1.0",false,false))
						);
			
			$impuestolocal = $xml->createElement("implocal:TrasladosLocales");
			$impuestolocal = $impuestoslocales->appendChild($impuestolocal);
			$this->CargaAtt($impuestolocal,array(
					"ImpLocTrasladado" => $this->Util()->CadenaOriginalVariableFormat("ISH",false,false),
					"TasadeTraslado"   => $this->Util()->CadenaOriginalVariableFormat($totales['porcentajeISH'],true,false),
					"Importe"          => $this->Util()->CadenaOriginalVariableFormat($totales['ish'],true,false)
						)
					);

?>
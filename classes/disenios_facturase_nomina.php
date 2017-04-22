<?php 
		switch($empresa["empresaId"])
		{
			case 15: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_nomina_317.php");
				$override = new Override;
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);
				break;
			default: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_nomina_317.php");
				$override = new Override;
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);
		}
            
            ?>
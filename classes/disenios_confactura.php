<?php

		switch($empresa["empresaId"])
		{
			default: 
				switch($_SESSION["version"])
				{
					case "v3":
					case "construc": include_once(DOC_ROOT."/classes/override_generate_pdf_default.php"); break;
					case "auto": include_once(DOC_ROOT."/classes/override_generate_pdf_default_auto.php");break;
					case "2": include_once(DOC_ROOT."/classes/override_generate_pdf_default_2.php");break;
				}
				
				$override = new Override;
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);
		}

?>
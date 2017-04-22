<?php
		switch($empresa["empresaId"])
		{
			//keops especial
			case 203: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_203.php");
				$override = new Override;
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			//keops especial
			case 174: 
			case 469: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_117.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			case 290: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_249.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			case 333: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_333.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			case 252: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_252.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			case 190: 
				//construcciones y servicios centenario
				include_once(DOC_ROOT."/classes/override_generate_pdf_190.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			case 284: 
			case 304: 
				if($empresa["empresaId"] == 284 || $empresa["empresaId"] == 304 || $empresa["empresaId"] == 642)
				{
					$data["formatoNormal"] = 1;
				}
				//marca de agua
				include_once(DOC_ROOT."/classes/override_generate_pdf_307.php");
				$override = new Override;
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			case 187: 
				//construcciones y servicios centenario
				include_once(DOC_ROOT."/classes/override_generate_pdf_187.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
			case 285: //bambu 
				//modelo con desglosado el iva gravado en 0%
				include_once(DOC_ROOT."/classes/override_generate_pdf_285.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;

			case 175: 
				include_once(DOC_ROOT."/classes/override_generate_pdf_importes.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;	
			case 416: 
				//construcciones y servicios centenario
				include_once(DOC_ROOT."/classes/override_generate_pdf_416.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;

			//con observaciones abajo
			case 312: 
				//construcciones y servicios centenario
				include_once(DOC_ROOT."/classes/override_generate_pdf_312.php");
				$override = new Override;
				//print_r($_SESSION["conceptos"]);
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");break;
				//con isn
			default: 
				if($empresa["moduloAgrario"] == "Si")
				{
					include_once(DOC_ROOT."/classes/override_generate_pdf_agrario.php");
				}
				else
				{
					switch($_SESSION["version"])
					{
						case "v3":
						case "construc":  include_once(DOC_ROOT."/classes/override_generate_pdf_default.php"); break;
						case "auto": include_once(DOC_ROOT."/classes/override_generate_pdf_default_auto.php");break;
						case "2": include_once(DOC_ROOT."/classes/override_generate_pdf_default_2.php");break;
					}		
				}
				
				$override = new Override;
				$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0, "vistaPrevia");
		}
            
            ?>
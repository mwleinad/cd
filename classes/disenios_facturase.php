<?php

		if($empresa['moduloImpuestos'] == 'Si'){
			include_once(DOC_ROOT."/classes/override_generate_pdf_117.php");
			$override = new Override;
			$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);
		} else {
			switch($empresa["empresaId"])
			{
				//normal solo cambio de logo
				case 203:
					include_once(DOC_ROOT."/classes/override_generate_pdf_203.php");
					$override = new Override;
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
				case 174:
				case 469:
					include_once(DOC_ROOT."/classes/override_generate_pdf_117.php");
					$override = new Override;
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
				case 290:
					include_once(DOC_ROOT."/classes/override_generate_pdf_249.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0);break;
				case 333:
					include_once(DOC_ROOT."/classes/override_generate_pdf_333.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa,0);break;
				case 252:
					include_once(DOC_ROOT."/classes/override_generate_pdf_252.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
				//facturas para solo cambiar el header
				case 190:
					//construcciones y servicios centenario
					include_once(DOC_ROOT."/classes/override_generate_pdf_190.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
				case 284:
				case 304:
					if($empresa["empresaId"] == 284 || $empresa["empresaId"] == 304 || $empresa["empresaId"] == 642)
					{
						$data["formatoNormal"] = 1;
					}
					//marca de agua
					include_once(DOC_ROOT."/classes/override_generate_pdf_307.php");
					$override = new Override;
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
				case 187:
					//construcciones y servicios centenario
					include_once(DOC_ROOT."/classes/override_generate_pdf_187.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;

				case 285: //bambu
					//modelo con desglosado el iva gravado en 0%
					include_once(DOC_ROOT."/classes/override_generate_pdf_285.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;

				case 175:
					include_once(DOC_ROOT."/classes/override_generate_pdf_importes.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
				case 416:
					include_once(DOC_ROOT."/classes/override_generate_pdf_416.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
				//observaciones abajo
				case 312:
					include_once(DOC_ROOT."/classes/override_generate_pdf_312.php");
					$override = new Override;
					//print_r($_SESSION["conceptos"]);
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);break;
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
							case "construc": include_once(DOC_ROOT."/classes/override_generate_pdf_default.php"); break;
							case "auto": include_once(DOC_ROOT."/classes/override_generate_pdf_default_auto.php");break;
							case "2": include_once(DOC_ROOT."/classes/override_generate_pdf_default_2.php");break;
						}
					}

					$override = new Override;
					$pdf = $override->GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $_SESSION["conceptos"],$empresa);
			}

		}

?>
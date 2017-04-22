<?php

			foreach($nodosConceptos as $concepto)
			{
				$concepto["descripcion"] = str_replace("[%]MAS[%]", "+", $concepto["descripcion"]);
				if($count % 2 == 0)
				{
					$pdf->SetTextColor(100, 100, 100);
				}
				else
				{
					$pdf->SetTextColor(0, 0, 0);
				}
				$count++;
				
				//$nb = $pdf->WordWrap($concepto["descripcion"], 105);
				$pdf->SetWidths(array(2,30, 40, 40, 47, 47));
				$pdf->SetAligns(array('L', 'L', 'L', 'R', 'R', 'R'));
				$xstart = 15;
				
				$pdf->Row(
					array(
						"",
						"CANTIDAD:".$this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false),
						"UNIDAD:".$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
						"NO IDENTIFICACION:".$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false), 
						"VALOR UNITARIO:"."$".$this->Util()->CadenaOriginalPDFFormat($concepto["valorUnitario"], true,false)
					),3
				);
	
				$xstart = 15;
				$pdf->SetWidths(array(2, 153, 25, 25));
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', '0'));
	
				$pdf->Row(
					array(
						"",
						utf8_decode($concepto["descripcion"]),
						"",
						"$".$this->Util()->CadenaOriginalPDFFormat($concepto["importe"], true,false)
					),3
				);
	
			}
			
				$pdf->SetWidths(array(2, 153, 25, 25));
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', '0'));
					$pdf->Row(
						array(
							"",
							"16% IVA", 
							"",
							"$".$this->Util()->CadenaOriginalPDFFormat($totales["iva"], true, false) 
							 
						),3
					);
	
				$pdf->SetFont('courier','B',7);
				$pdf->SetWidths(array(2, 153, 25, 25));
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', 'T'));
					$pdf->Row(
						array(
							"",
							"IMPORTE TOTAL", 
							"",
							"$".$this->Util()->CadenaOriginalPDFFormat($tempSubtotal + $totales["iva"], true, false) 
						),3
					);
			$pdf->SetFont('courier','',7);
	
			
			$pdf->SetTextColor(0, 0, 0);
	
			$count = 1;
			if($_SESSION["impuestos"])
			{
				//Table with 20 rows and 4 columns
				$pdf->SetWidths(array(2, 153, 25, 25));
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', '0'));
				
				if($count % 2 == 0)
				{
					$pdf->SetTextColor(100, 100, 100);
				}
				else
				{
					$pdf->SetTextColor(0, 0, 0);
				}
				$count++;
	
				$existImpuesto = 0;
				foreach($_SESSION["impuestos"] as $impuesto)
				{
					if($impuesto["tipo"] == "amortizacion")
					{
						$existImpuesto++;
					}
				}
				
				if($existImpuesto > 0)
				{
					$setY = $pdf->GetY();
					$pdf->SetX(2);
					$pdf->SetFont('courier','B',7);
					$pdf->Cell(40,8,"AMORTIZACIONES",0,0,"L");
					$pdf->SetFont('courier','',7);
					$pdf->Ln();
					$pdf->SetTextColor(0, 0, 0);
					
					$suma = 0;
					
					foreach($_SESSION["impuestos"] as $impuesto)
					{
						if($impuesto["tipo"] == "amortizacion")
						{
							$suma += $impuesto["importe"] * count($_SESSION["conceptos"]);
							if($impuesto["tasaIva"] > 0)
							{
								if(strpos($impuesto["impuesto"], "16%"))
								{
									$impuesto["impuesto"] = substr($impuesto["impuesto"], 0, 7);
								}
							}
							
							$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
							$pdf->Row(
								array(
									"",
									$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false),
									"", 
									"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
								),3
							);
							$temp = $impuesto["impuesto"];
						}
				}//foreach
				
					$pdf->SetFont('courier','B',7);
					$pdf->SetAligns(array('L','L', 'R', 'R'));
					$pdf->SetBorders(array('0','0', '0', 'T'));
						$pdf->Row(
							array(
								"",
								"IMPORTE TOTAL", 
								"",
								"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
								 
							),3
						);
				}//if
			$pdf->SetFont('courier','',7);
				
							
				$existImpuesto = 0;
				foreach($_SESSION["impuestos"] as $impuesto)
				{
					if($impuesto["tipo"] == "deduccion")
					{
						$existImpuesto++;
					}
				}
				
				if($existImpuesto > 0)
				{
	
					$setY = $pdf->GetY();
					$pdf->SetX(2);
					$pdf->SetFont('courier','B',5);
					$pdf->Cell(40,8,"DEDUCCIONES",0,0,"L");
					$pdf->SetFont('courier','',5);
					$pdf->Ln();
					$pdf->SetTextColor(0, 0, 0);
		
					
					$suma = 0;
					foreach($_SESSION["impuestos"] as $impuesto)
					{
						if($impuesto["tipo"] == "deduccion")
						{
							$suma += $impuesto["importe"] * count($_SESSION["conceptos"]);
							if($impuesto["tasaIva"] > 0)
							{
								if(strpos($impuesto["impuesto"], "16%"))
								{
									$impuesto["impuesto"] = substr($impuesto["impuesto"], 0, 7);
								}
							}
							
							$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
							$pdf->Row(
								array(
									"",
									$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
									"",
									"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
								),3
							);
						}
				}//foreach
	
					$pdf->SetFont('courier','B',7);
					$pdf->SetAligns(array('L','L', 'R', 'R'));
					$pdf->SetBorders(array('0','0', '0', 'T'));
						$pdf->Row(
							array(
								"",
								"IMPORTE TOTAL", 
								"",
								"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
								 
							),3
						);
				}//if
				$pdf->SetFont('courier','',7);
				
				$existImpuesto = 0;
				foreach($_SESSION["impuestos"] as $impuesto)
				{
					if($impuesto["tipo"] == "retencion")
					{
						$existImpuesto++;
					}
				}
				
				if($existImpuesto > 0)
				{
					
					$setY = $pdf->GetY();
					$pdf->SetX(2);
					$pdf->SetFont('courier','B',7);
					$pdf->Cell(40,8,"RETENCIONES",0,0,"L");
					$pdf->SetFont('courier','',7);
					$pdf->Ln();
					$pdf->SetTextColor(0, 0, 0);
					
					$suma = 0;
					foreach($_SESSION["impuestos"] as $impuesto)
					{
						if($impuesto["tipo"] == "retencion")
						{
							$suma += $impuesto["importe"] * count($_SESSION["conceptos"]);
							if($impuesto["tasaIva"] > 0)
							{
								if(strpos($impuesto["impuesto"], "16%"))
								{
									$impuesto["impuesto"] = substr($impuesto["impuesto"], 0, 7);
								}
							}
							
							$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
							$pdf->Row(
								array(
									"",
									$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
									"",
									"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
								),3
							);
						}
				}//foreach
				
					$pdf->SetFont('courier','B',7);
					$pdf->SetAligns(array('L','L', 'R', 'R'));
					$pdf->SetBorders(array('0','0', '0', 'T'));
						$pdf->Row(
							array(
								"",
								"IMPORTE TOTAL", 
								"",
								"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
								 
							),3
						);
					$pdf->SetFont('courier','',7);
						
				}//if
	
				$existImpuesto = 0;
				foreach($_SESSION["impuestos"] as $impuesto)
				{
					if($impuesto["tipo"] == "impuesto")
					{
						$existImpuesto++;
					}
				}
				
				if($existImpuesto > 0)
				{
	
					$setY = $pdf->GetY();
					$pdf->SetX(2);
					$pdf->SetFont('courier','B',7);
					$pdf->Cell(40,8,"IMPUESTOS",0,0,"L");
					$pdf->SetFont('courier','',7);
					$pdf->Ln();
					$pdf->SetTextColor(0, 0, 0);
					
					$suma = 0;
					foreach($_SESSION["impuestos"] as $impuesto)
					{
						if($impuesto["tipo"] == "impuesto")
						{
							$suma += $impuesto["importe"] * count($_SESSION["conceptos"]);
							if($impuesto["tasaIva"] > 0)
							{
								if(strpos($impuesto["impuesto"], "16%"))
								{
									$impuesto["impuesto"] = substr($impuesto["impuesto"], 0, 7);
								}
							}
							
							$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
							$pdf->Row(
								array(
									"",
									$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
									"",
									"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
								),3
							);
						}
				}//foreach
	
					$pdf->SetFont('courier','B',7);
					$pdf->SetAligns(array('L','L', 'R', 'R'));
					$pdf->SetBorders(array('0','0', '0', 'T'));
						$pdf->Row(
							array(
								"",
								"IMPORTE TOTAL", 
								"",
								"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
								 
							),3
						);
					$pdf->SetFont('courier','',7);
				}//if
				
	
				
			//check page break
	//		$pdf->CheckPageBreak(50);
			}
	
					$pdf->SetFont('courier','B',7);
				$pdf->SetWidths(array(2, 153, 25, 25));
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', 'T'));
					$pdf->Row(
						array(
							"",
							"ALCANCE LIQUIDO ", 
							"",
							"$".$this->Util()->CadenaOriginalPDFFormat($totales["total"], true, false) 
							 
						),3
					);
					$pdf->SetFont('courier','',7);
					
		$setY = $pdf->GetY() + 3;
		$pdf->SetFont('verdana','',7);

		//block con letra
		$pdf->SetTextColor(255, 255, 255);


		$totales["total"];
		$cents = ($totales["total"] - floor($totales["total"]))*100;
		$totales["total2"] = $totales["total"];
		
		$centavosLetra = $this->Util()->GetCents($totales["total"]);
		if($cents >= 99)
		{
			$totales["total"] = ceil($totales["total"]);
		}
		else
		{
			$totales["total"] = floor($totales["total"]);
		}
		//echo $centavosLetra;
		$cantidadLetra = $this->Util()->num2letras($totales["total"], false);
		//tipo de cambio
		switch($data["tiposDeMoneda"])
		{
			case "MXN": $tiposDeCambio = "Pesos"; $tiposDeCambioSufix = "M.N";break;
			case "USD": $tiposDeCambio = "Dolares"; $tiposDeCambioSufix = "";break;
			case "EUR": $tiposDeCambio = "Euros"; $tiposDeCambioSufix = "";break;
		}
		
	$temp = new CNumeroaLetra ();
	$temp->setMayusculas(1);
	$temp->setGenero(1);
	$temp->setMoneda($tiposDeCambio);
	$temp->setDinero(1);
	$temp->setPrefijo('(');
	$temp->setSufijo($tiposDeCambioSufix.')');
	$temp->setNumero($totales["total2"]);
	$letra = $temp->letra();
		$x = 2;
		$y = $setY;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0,0,0);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(30,3,utf8_decode("Cantidad Con Letra"),1, "C", 1);

		$x = 32;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->SetFont('courier','B',7);
		$pdf->MultiCell(170,3,$this->Util()->DecodeVal($letra),1, "C", 1);
		
		$xstart = 3;
		$pdf->SetY($setY+3);
		$pdf->SetX($xstart);
		$pdf->SetFont('verdana','',7);					
?>
<?php

		//block conceptos
		$pdf->SetFillColor(143,58,63);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Rect(2, $pdf->GetY()+2, 205, 6, 'DF');

		$xstart = 2;
		$y = $pdf->GetY();
		$pdf->SetY($pdf->GetY()+2);
		$pdf->SetX($xstart);
		$pdf->Cell(15,8,"Cnt.",0,0,"C");
		$pdf->Cell(15,8,"Unid.",0,0,"C");
		$pdf->Cell(20,8,"No. Id",0,0,"C");
		$pdf->Cell(113,8,"Descripcion",0,0,"C");
		$pdf->Cell(17,8,"P. Unit.",0,0,"C");
		$pdf->Cell(22,8,"Importe",0,0,"C");

		$setY = $pdf->GetY()+10;
		$pdf->SetY($setY);
 		$pdf->SetTextColor(0,0,0);
		
		//Table with 20 rows and 4 columns
		$pdf->SetWidths(array(5,15, 15, 20, 106, 22, 22));
		$pdf->SetAligns(array('L','L', 'L', 'L', 'L', 'R', 'R'));
		$pdf->SetFont('courier','',7);
		$xstart = 15;
		$count = 1;
		foreach($nodosConceptos as $concepto)
		{
/*			if($count % 2 == 0)
			{
				$pdf->SetTextColor(100, 100, 100);
			}
			else
			{
*/					$pdf->SetTextColor(0, 0, 0);
	//		}
		$count++;
			$concepto["descripcion"] = str_replace("&quot;", "\"", $concepto["descripcion"]);
			$concepto["descripcion"] = str_replace("&#039;", "'", $concepto["descripcion"]);
			
			//$nb = $pdf->WordWrap($concepto["descripcion"], 105);
			$xstart = 15;
	    $pdf->Row(
				array(
					"   -",
					$this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false),
					$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
					$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false), 
					utf8_decode($concepto["descripcion"]), 
					"$".$this->Util()->CadenaOriginalPDFFormat($concepto["valorUnitario"], true,false), 
					"$".$this->Util()->CadenaOriginalPDFFormat($concepto["importe"], true,false)
				),3
			);

		}
		
		$pdf->SetTextColor(0, 0, 0);
		//check page break
//		$pdf->CheckPageBreak(50);
		//$impuesto["importe"] = number_format($impuesto["importe"], 2);

		$count = 1;
		if($_SESSION["impuestos"])
		{
			$setY = $pdf->GetY();
			$pdf->SetX($xstart);
			$pdf->Cell(40,8,"Otros impuestos o retenciones",0,0,"C");
			$pdf->Ln();
			$pdf->SetTextColor(0, 0, 0);
	
			//Table with 20 rows and 4 columns
			$pdf->SetWidths(array(20, 20, 142, 22));
			$pdf->SetAligns(array('L', 'L', 'L', 'R'));
			
			$xstart = 15;

			if($count % 2 == 0)
			{
				$pdf->SetTextColor(100, 100, 100);
			}
			else
			{
				$pdf->SetTextColor(0, 0, 0);
			}
			$count++;
			
			foreach($_SESSION["impuestos"] as $impuesto)
			{
				$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						$this->Util()->CadenaOriginalVariableFormat(ucfirst($impuesto["tipo"]),false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["tasa"]."%",false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
					),3
				);
	
			//TODO la parte y el complemento.
		}
		//check page break
//		$pdf->CheckPageBreak(50);
		}

		$setY = $pdf->GetY() + 3;
		$pdf->Line(10,$setY,200,$setY);
		$pdf->Line(10,$setY+1,200,$setY+1);

		//block con letra
		$pdf->SetFillColor(143,58,63);
		$pdf->Rect(2, $setY+2, 22, 13, 'DF');
		$pdf->SetTextColor(255, 255, 255);

		$xstart = 3;
		$pdf->SetY($setY+3);
		$pdf->SetX($xstart);
		$pdf->SetFont('verdana','',7);
		$pdf->MultiCell(25,3,"Total Con letra",0);
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
		
//		$letra = "(".$cantidadLetra." ".$tiposDeCambio." ".$centavosLetra."/100 ".$tiposDeCambioSufix.")";
		//tipo de cambio
		$pdf->SetTextColor(0,0,0);
		$pdf->SetY($setY+3);
		$pdf->SetX(25);
		$pdf->MultiCell(120,3,$letra,0);

		$pdf->SetFont('verdana','',7);

		//add cuenta
		if($data["NumCtaPago"])
		{
			$add = "Numero de Cuenta: ".$data["NumCtaPago"];
		}
		else
		{
			$add = "Numero de Cuenta: No identificado";
		}
				
		$y = $pdf->GetY()+3;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
//echo $data["formaDePago"];
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(25,3,"Tipo De Pago",0);
		$pdf->SetY($y);
		$pdf->SetX(25);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(120,3,$this->Util()->DecodeVal($data["formaDePago"]."\nMetodo de Pago: ".$data["metodoDePago"].". ".$add),0);


		//block totales
		$pdf->SetFillColor(143,58,63);
		$pdf->Rect(155, $setY+2, 20, 16, 'DF');

		//$pdf->SetFillColor(255);
		$pdf->SetTextColor(255, 255, 255);

		$xstart = 155;
		$pdf->SetY($setY+2);
		$pdf->SetX($xstart);
		//$pdf->SetFillColor(192);
		$pdf->MultiCell(20,3,"Subtotal",0,"C",0);
		$pdf->SetY($pdf->GetY()-3);
		$pdf->SetX($xstart+20);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totales["subtotal"], true,false),0,"R",0);

		if($totales["descuento"] != 0)
		{
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->MultiCell(20,3,"Descuento",0,"C");
			$pdf->SetY($pdf->GetY()-3);
			$pdf->SetX($xstart+20);
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totales["descuento"], true,false),0,"R",0);
		}
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(20,3,$totales["tasaIva"]."% IVA",0,"C");
		$pdf->SetY($pdf->GetY()-3);
		$pdf->SetX($xstart+20);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totales["iva"], true,false),0,"R",0);
//print_r($totales);
		if($totales["retIva"] != 0)
		{
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->MultiCell(20,3,"Ret Iva",0,"C");
			$pdf->SetY($pdf->GetY()-3);
			$pdf->SetX($xstart+20);
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totales["retIva"], true,false),0,"R",0);
		}
		
		if($totales["retIsr"] != 0)
		{
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->MultiCell(20,3,"Ret Isr",0,"C");
			$pdf->SetY($pdf->GetY()-3);
			$pdf->SetX($xstart+20);
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totales["retIsr"], true,false),0,"R",0);
		}
		
		if($totales["porcentajeIEPS"] != 0)
		{
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);
			$pdf->SetTextColor(255, 255, 255);
			$pdf->MultiCell(20,3,"IEPS",0,"C");
			$pdf->SetY($pdf->GetY()-3);
			$pdf->SetX($xstart+20);
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totales["ieps"], true,false),0,"R",0);
		}

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(20,3,"Total",0,"C");
		$pdf->SetY($pdf->GetY()-3);
		$pdf->SetX($xstart+20);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totales["total2"], true,false),0,"R",0);

		$setY = $pdf->GetY() + 15;
		//$pdf->Line(10,$setY+1,200,$setY+1);
		//$pdf->Line(10,$setY+2,200,$setY+2);

		$pdf->SetY($pdf->GetY()+10);
		$pdf->SetX($xstart);
		$xstart = 2;
		$pdf->SetX($xstart);

?>
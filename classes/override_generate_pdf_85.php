<?php

class Override extends Comprobante
{
	function GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa, $cancelado = 0, $vistaPrevia = 0)
	{
		$this->GenerateQR($data, $totales, $nodoEmisor, $nodoReceptor, $empresa, $serie);		
		//Instanciation of inherited class
		$pdf=new PDF('P', 'mm', "a4");
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->AddFont('verdana','','verdana.php');
		$pdf->SetFont('verdana','',9);

		$pdf->SetY(5);
		$pdf->SetX(10);


		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/pdf/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";


			$pdf->Image(DOC_ROOT."/images/header_85.jpg",10,15, 155,25); 	
$pdf->Image($rootQr.$nufa.'.png',$xstart+165,13, 28, 28);					
			
			$pdf->Image(DOC_ROOT."/images/fondo_85.jpg",20,100, 170,120); 		

 		$pdf->SetTextColor(0, 0, 0);
		//block emisor
		$pdf->SetFillColor(192);

		$pdf->SetFont('courier','',9);
		//block serie
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(125, 45, 35, 35, 3, 'DF', '1234');

		$xstart = 127;
		$pdf->SetY(45);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"FACTURA No.",0);

		$pdf->SetY(55);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Certificado",0);

		$pdf->SetY(60);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Fecha",0);

		$pdf->SetY(65);
		$pdf->SetX($xstart);
		$pdf->Cell(90,8,utf8_decode("UUID"),0);

		$pdf->SetY(70);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Fecha Timbrado",0);

		$xstart = 165;
		$pdf->SetY(45);
		$pdf->SetX($xstart);
		$pdf->SetTextColor(200, 0, 0);
		$pdf->Cell(40,8,$data["serie"]["serie"],0,0,'R');

		$pdf->SetTextColor(0, 0, 0);
		$xstart = 165;
		$pdf->SetY(50);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["folio"],0,0,'R');

		$pdf->SetY(55);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["serie"]["noCertificado"],0,0,'R');

		$pdf->SetY(60);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["fecha"],0,0,'R');

		$pdf->SetFont('courier','',5);

		$pdf->SetY(65);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["timbreFiscal"]["UUID"],0,0,'R');

		$pdf->SetFont('courier','',9);

		$pdf->SetY(70);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["timbreFiscal"]["FechaTimbrado"],0,0,'R');

		$pdf->Line(10,42,200,42);
		$pdf->Line(10,43,200,43);
		
		//block receptor
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(10, 45, 110, 35, 3, 'DF', '1234');
		
		$pdf->SetFont('courier','',8);
		
		$xstart = 15;
		$pdf->SetY(45);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Cliente",0);
		
		$infoReceptor = urldecode($data["nodoReceptor"]["nombre"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["colonia"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".str_pad($data["nodoReceptor"]["cp"], 5, "0", STR_PAD_LEFT));
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["rfc"]);
				
		$xstart = 10;
		$pdf->SetY(52);
		$pdf->SetX($xstart);


		$pdf->SetFont('courier','',7);
		$pdf->SetWidths(array(80));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		$nb = $pdf->WordWrap($infoReceptor, 80);
	    $pdf->Row(
				array( utf8_decode(urldecode($infoReceptor))), 3
			);
		$pdf->SetFont('courier','',8);

		$pdf->Line(10,87,200,87);
		$pdf->Line(10,88,200,88);

		$xstart = 15;
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, $pdf->GetY()+20, 190, 6, 3, 'DF', '1234');
		$y = $pdf->GetY();
		$pdf->SetY($pdf->GetY()+20);
		$pdf->SetX($xstart);
		$pdf->Cell(35,8,"CANTIDAD",0,0,"C");
		$pdf->Cell(100,8,"DESCRIPCION",0,0,"C");
		$pdf->Cell(22,8,"P. UNIT",0,0,"C");
		$pdf->Cell(22,8,"IMPORTE",0,0,"C");

		//observaciones
		$setY = $pdf->GetY()+12;
		$pdf->SetY($setY);
		$pdf->SetFont('courier','',8);
		$pdf->SetWidths(array(180));
		$pdf->SetAligns("J");
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		//$nb = $pdf->WordWrap($data["observaciones"], 180);
	    $pdf->Row(
				array( utf8_decode(urldecode($data["observaciones"]))), 4
			);
		$pdf->SetFont('courier','',8);
		$pdf->CheckPageBreak(50);

		//block conceptos


		$setY = $pdf->GetY()+12;
		$pdf->SetY($setY);
		
		//Table with 20 rows and 4 columns
		$pdf->SetWidths(array(0, 157, 0, 32));
		$pdf->SetAligns(array("L", "L", "L", "R"));
		
		$xstart = 15;
		foreach($nodosConceptos as $concepto)
		{
			$nb = $pdf->WordWrap($concepto["descripcion"], 80);
			$xstart = 15;
	    $pdf->Row(
				array(
					"",
					$this->Util()->CadenaOriginalPDFFormat($concepto["descripcion"]), 
					"", 
					"$".$this->Util()->CadenaOriginalPDFFormat($concepto["importe"], true,false)
				)
			,3);

			//TODO la parte y el complemento.
		}
		
	    $pdf->Row(
				array(
					"",
					$totales["tasaIva"]."% de IVA", 
					"", 
					$this->Util()->CadenaOriginalPDFFormat($totales["iva"], true,false)
				)
			,3);

		//check page break
		$pdf->CheckPageBreak(10);

		$setY = $pdf->GetY();
		$pdf->SetX($xstart);
		$pdf->SetX($setY);

		//Table with 20 rows and 4 columns
		$pdf->SetWidths(array(0, 0, 157, 32));
		$pdf->SetAligns(array("L", "L", "L", "R"));
		
		$xstart = 15;

				$pdf->SetFont('courier','B',8);

		if($_SESSION["impuestos"])
		{
			$pdf->Ln();
			$pdf->SetFont('courier','',8);
			$total = 0;
			
			foreach($_SESSION["impuestos"] as $impuesto)
			{
				if($impuesto["tipo"] != "impuesto")
				{
					continue;
				}
				$total = $total + $impuesto["importe"];
			}
			foreach($_SESSION["impuestos"] as $impuesto)
			{
				if($impuesto["tipo"] != "impuesto")
				{
					continue;
				}
				
				if($total == 0)
				{
					continue;
				}
				
				$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						"",
						"",
						$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"], true, false) 
					)
				,3);

			}
			$total = $total + $totales["iva"] + $totales["valorUnitario"];
				$pdf->SetFont('courier','B',8);
				$pdf->Row(
					array(
						"",
						"Total",
						"", 
						"$".$this->Util()->CadenaOriginalPDFFormat($total, true, false)
					)
				,3);


			$total = 0;
			foreach($_SESSION["impuestos"] as $impuesto)
			{
				if($impuesto["tipo"] != "amortizacion")
				{
					continue;
				}
				$total = $total + $impuesto["importe"];
			}
			
			if($total > 0)
			{
				$pdf->Ln();
				$pdf->Row(
					array(
						"AMORTIZACIONES",
						"",
						"", 
						"" 
					)
				,3);
				$pdf->SetFont('courier','',8);

				foreach($_SESSION["impuestos"] as $impuesto)
				{
					if($impuesto["tipo"] != "amortizacion")
					{
						continue;
					}
	
	
					$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
					$xstart = 15;
					$pdf->Row(
						array(
							"",
							"",
							$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
							"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"],true, false) 
						)
					,3);
					
				}
				$pdf->SetFont('courier','B',8);
				$pdf->Row(
					array(
						"",
						"Total",
						"", 
						"$".$this->Util()->CadenaOriginalPDFFormat($total,true, false)
					)
				,3);
			}


			$total = 0;
			foreach($_SESSION["impuestos"] as $impuesto)
			{
				if($impuesto["tipo"] != "retencion")
				{
					continue;
				}
				$total = $total + $impuesto["importe"];
			}
			
			if($total > 0)
			{
				$pdf->Ln();
				$pdf->Row(
					array(
						"RETENCIONES",
						"",
						"", 
						"" 
					)
				,3);
				$pdf->SetFont('courier','',8);

				foreach($_SESSION["impuestos"] as $impuesto)
				{
					if($impuesto["tipo"] != "retencion")
					{
						continue;
					}
	
	
					$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
					$xstart = 15;
					$pdf->Row(
						array(
							"",
							"",
							$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
							"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"],true, false) 
						)
					,3);
	
				}
				$pdf->SetFont('courier','B',8);
				$pdf->Row(
					array(
						"",
						"Total",
						"", 
						"$".$this->Util()->CadenaOriginalPDFFormat($total)
					)
				,3);
			}

				$pdf->SetFont('courier','B',8);

			$total = 0;
			foreach($_SESSION["impuestos"] as $impuesto)
			{
				if($impuesto["tipo"] != "deduccion")
				{
					continue;
				}
				$total = $total + $impuesto["importe"];
			}
			
			if($total > 0)
			{
				$pdf->Ln();
				$pdf->Row(
					array(
						"DEDUCCIONES: ",
						"",
						"", 
						"" 
					)
				,3);
				$pdf->SetFont('courier','',8);

			$pdf->SetFont('courier','',8);

			foreach($_SESSION["impuestos"] as $impuesto)
			{
				if($impuesto["tipo"] != "deduccion")
				{
					continue;
				}


				$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						"",
						"",
						$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"],true, false) 
					)
				,3);

			}

				$pdf->SetFont('courier','B',8);

				$pdf->Row(
					array(
						"",
						"Total",
						"", 
						"$".$this->Util()->CadenaOriginalPDFFormat($total, true, false)
					)
				,3);
			}

				$pdf->SetFont('courier','',8);

		$pdf->Ln();
		//check page break
		$pdf->CheckPageBreak(50);
		}

		$setY = $pdf->GetY();


		$pdf->Line(10,$setY,200,$setY);
		$pdf->Line(10,$setY+1,200,$setY+1);

		//block con letra
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, $setY+5, 35, 18, 3, 'DF', '1234');

		$xstart = 15;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);
		$pdf->SetFont('courier','',6);
		$pdf->Cell(35,8,"Total Con letra",0);
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
		//tipo de cambio
		//$pdf->Cell(60,8,$letra,0);
		$pdf->MultiCell(90,3,$letra,0,"L",0);
		$pdf->SetFont('courier','',6);

		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);

		//add cuenta
		if($data["NumCtaPago"])
		{
			$add = "Num. Cuenta: ".$data["NumCtaPago"];
		}
		
		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);
		$pdf->Cell(35,8,"Forma De Pago",0);
		$pdf->Cell(60,8,$this->Util()->DecodeVal($data["formaDePago"]."\nMetodo de Pago: ".$data["metodoDePago"]." ".$add),0);
		$pdf->SetFont('courier','',9);


		//block totales
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(140, $setY+5, 25, 18, 3, 'DF', '1234');

		$xstart = 140;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Alcance",0,0,"C");


		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Liquido",0,0,"C");
		$pdf->Cell(35,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["total2"], true,false),0,0,"R");

		//$offset = 5;
		
		//echo $totales["total"];

		$setY = $setY + 30 + $offset;
		$pdf->Line(10,$setY,200,$setY);
		$pdf->Line(10,$setY+1,200,$setY+1);

		$pdf->CheckPageBreak(30);

		$xstart = 10;
		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);

		$pdf->SetFont('courier','',6);
		$y = $pdf->GetY();
		if($data["autorizo"])
		{
			$pdf->MultiCell(60,3,utf8_decode("AUTORIZO:\n").urldecode($data["autorizo"]),0,"C",0);
		}
		$pdf->SetY($y);
		$pdf->SetX(70);
		if($data["recibio"])
		{
			$pdf->MultiCell(60,3,utf8_decode(urldecode("RECIBIO:\n".$data["recibio"]))."\nADMINISTRADOR UNICO",0,"C", 0);
		}
		$pdf->SetY($y);
		$pdf->SetX(140);
		if($data["vobo"])
		{
			$pdf->MultiCell(60,3,utf8_decode(urldecode("Vo. Bo:\n".$data["vobo"])),0,"C", 0);
		}

		if($data["autorizo"] || $data["recibio"] || $data["vobo"])
		{
			$pdf->CheckPageBreak(15);
			$pdf->SetY($pdf->GetY()+15);
			$pdf->SetX($xstart);
		}
		
		//$pdf->SetX(10);
		$y = $pdf->GetY();
		if($data["reviso"])
		{
			$pdf->MultiCell(90,3,utf8_decode(urldecode("REVISO:\n".$data["reviso"])),0,"C",0);
		}
		
		$pdf->SetY($y);
		$pdf->SetX(100);
		
		if($data["pago"])
		{
			$pdf->MultiCell(90,3,utf8_decode(urldecode("PAGO:\n".$data["pago"])),0,"C",0);
		}

		$setY = $pdf->GetY();
		if($data["reviso"] || $data["pago"])
		{
//			$pdf->CheckPageBreak(10);
//			$pdf->SetY($setY+10);
//			$pdf->SetX($xstart);
		}
//		$pdf->CheckPageBreak(30);

		$pdf->SetY($pdf->GetY());
		$pdf->Cell(180,8,utf8_decode("ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDi"),0,0,"C");
		
		$pdf->SetFont('courier','',5);
		$pdf->SetFillColor(200,200,200);
		$pdf->Ln();
		$pdf->MultiCell(150,3,"Sello Emisor: ".$data["sello"],0,"L",1);
//		$pdf->Ln();
		$pdf->MultiCell(150,3,"Sello SAT: ".$data["timbreFiscal"]["selloSAT"],0,"L",1);
//		$pdf->Ln();
//		$cadena["cadenaOriginal"] = utf8_decode(utf8_decode($data["cadenaOriginal"]));
//		$pdf->MultiCell(150,3,"Cadena Original: \n".$cadena["cadenaOriginal"],0,"L",1);

		$cadena["cadenaOriginalTimbre"] = utf8_decode(utf8_decode($data["timbreFiscal"]["original"]));
		$pdf->MultiCell(150,3,"Cadena Original Timbre Fiscal: \n".$cadena["cadenaOriginalTimbre"],0,"L",1);

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/pdf/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";

//		$pdf->Image($rootQr.$nufa.'.png',$xstart+160,$pdf->getY()-40, 28, 28);		

		if($cancelado){
		
			$xstart = 10;
			$pdf->SetFont('courier','',36);
			$pdf->SetTextColor(255,00,00);
			$pdf->SetY($setY-15);
			$pdf->SetX($xstart);
			$pdf->Cell(180,8,"C A N C E L A D O",0,0,"C");
					
		}//if
		
		
		if(!is_dir($rootFacturas))
		{
			mkdir($rootFacturas, 0777);
		}

		if(!is_dir($root))
		{
			mkdir($root, 0777);
		}

		if(!$vistaPrevia)
		{
			$pdf->Output($root.$nufa.".pdf", "F");
		}
		else
		{
			@unlink(DOC_ROOT."/empresas/".$_SESSION["empresaId"]."_vistaPrevia.pdf");
			$pdf->Output(DOC_ROOT."/empresas/".$_SESSION["empresaId"]."_vistaPrevia.pdf", "F");


		}

	}
}


?>
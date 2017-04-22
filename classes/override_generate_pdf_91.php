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
 		$pdf->SetTextColor(200, 0, 0);
	  	$pdf->Cell(20,10,$data["comprobante"]["nombre"],0,0,'L');

		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/qrs/";
		$qrRfc = strtoupper($data["nodoEmisor"]["rfc"]["rfc"]);
		$nufa = $serie["serieId"].".jpg";
	
		if(file_exists($rootQr.$nufa))
		{
			//$pdf->Image($rootQr.$nufa,$xstart+160,$setY+15, 27.5, 27.5,'PNG'); 		
			$pdf->Image($rootQr.$nufa,10,15, 25,25); 		
		}

 		$pdf->SetTextColor(0, 0, 0);
		//block emisor
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(40, 15, 25, 6, 3, 'DF', '1234');

		$xstart = 45;
		$pdf->SetY(15);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Emisor",0);

		$pdf->SetFont('verdana','',5);
		$xstart = 40;
		$pdf->SetY(20);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["razonSocial"])),0);

		$pdf->SetY(25);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["calle"]." ".$data["nodoEmisor"]["rfc"]["noExt"]." ".$data["nodoEmisor"]["rfc"]["noInt"])),0);

		$pdf->SetY(30);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["colonia"])),0);

		$pdf->SetY(35);
		$pdf->SetX($xstart);
		$pdf->Cell(90,8,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["municipio"]." ".$data["nodoEmisor"]["rfc"]["estado"]." ".$data["nodoEmisor"]["rfc"]["pais"]." CP: ".$data["nodoEmisor"]["rfc"]["cp"])),0);

		$pdf->SetY(40);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,8,"RFC: ".$data["nodoEmisor"]["rfc"]["rfc"],0);
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,"Regimen Fiscal: ".utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["regimenFiscal"])),0);
		

		$pdf->SetFont('verdana','',9);
		//block serie
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(125, 15, 35, 35, 3, 'DF', '1234');

		$xstart = 127;
		$pdf->SetY(15);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Serie",0);

		$pdf->SetY(20);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Folio",0);

		$pdf->SetY(25);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Certificado",0);

		$pdf->SetY(30);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Fecha",0);

		$pdf->SetY(35);
		$pdf->SetX($xstart);
		$pdf->Cell(90,8,utf8_decode("UUID"),0);

		$pdf->SetY(40);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Fecha Timbrado",0);

		$xstart = 165;
		$pdf->SetY(15);
		$pdf->SetX($xstart);
		$pdf->SetTextColor(200, 0, 0);
		$pdf->Cell(40,8,$data["serie"]["serie"],0,0,'R');

		$pdf->SetTextColor(0, 0, 0);
		$xstart = 165;
		$pdf->SetY(20);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["folio"],0,0,'R');

		$pdf->SetY(25);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["serie"]["noCertificado"],0,0,'R');

		$pdf->SetY(30);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["fecha"],0,0,'R');

		$pdf->SetFont('verdana','',5);

		$pdf->SetY(35);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["timbreFiscal"]["UUID"],0,0,'R');

		$pdf->SetFont('verdana','',9);

		$pdf->SetY(40);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["timbreFiscal"]["FechaTimbrado"],0,0,'R');

		
		//block receptor
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, 55, 25, 6, 3, 'DF', '1234');
		
		$pdf->SetFont('verdana','',10);
		
		$xstart = 15;
		$pdf->SetY(55);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Receptor",0);
		
		$infoReceptor = urldecode($data["nodoReceptor"]["nombre"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["colonia"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".$data["nodoReceptor"]["cp"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["rfc"]);

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		$rfcActivo = $this->getRfcActive();
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";
		$pdf->Image($rootQr.$nufa.'.png',$xstart+155,55, 28, 28);					

		$xstart = 10;
		$pdf->SetY(62);
		$pdf->SetX($xstart);


		$pdf->SetFont('verdana','',7);
		$pdf->SetWidths(array(80));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		$nb = $pdf->WordWrap($infoReceptor, 80);
	    $pdf->Row(
				array( utf8_decode(urldecode($infoReceptor))), 3
			);
		$pdf->SetFont('verdana','',8);

//$pdf->MultiCell(80,4,$infoReceptor,0);
				
		//block sucursal
		
		if($data["nodoEmisor"]["sucursal"]["sucursalActiva"] == 'no'){
		
			$infoSucursal = utf8_decode(urldecode($data["nodoEmisor"]["sucursal"]["identificador"]));
			$infoSucursal .= "\n".utf8_decode(urldecode($data["nodoEmisor"]["sucursal"]["calle"]." ".$data["nodoEmisor"]["sucursal"]["noExt"]." ".$data["nodoEmisor"]["sucursal"]["noInt"]));
			$infoSucursal .= "\n".utf8_decode(urldecode($data["nodoEmisor"]["sucursal"]["colonia"]));
			$infoSucursal .= "\n".utf8_decode(urldecode($data["nodoEmisor"]["sucursal"]["municipio"]." ".$data["nodoEmisor"]["sucursal"]["estado"]." ".$data["nodoEmisor"]["sucursal"]["pais"]." CP: ".$data["nodoEmisor"]["sucursal"]["cp"]));
			$infoSucursal .= "\n".utf8_decode(urldecode($data["nodoEmisor"]["sucursal"]["rfc"]));
			
			$pdf->SetFillColor(192);
			$pdf->RoundedRect(105, 55, 25, 6, 3, 'DF', '1234');
	
			$xstart = 110;
			$pdf->SetY(55);
			$pdf->SetX($xstart);
			$pdf->Cell(70,8,"Sucursal",0);
			
			$xstart = 105;
			$pdf->SetY(62);
			$pdf->SetX($xstart);

			$pdf->SetFont('verdana','',5);
			$pdf->SetWidths(array(80));
			//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
			$nb = $pdf->WordWrap($infoSucursal, 80);
				$pdf->Row(
					array( utf8_decode(urldecode($infoSucursal))
					), 3
				);
			$pdf->SetFont('verdana','',8);

//$pdf->MultiCell(80,4,$infoSucursal,0);
		
		}//if
		
		$pdf->Line(10,87,200,87);
		$pdf->Line(10,88,200,88);

		//observaciones
		$setY = 90;
		$pdf->SetY($setY);
		
		//block conceptos
//		$pdf->SetFillColor(192);
//		$pdf->RoundedRect(10, $pdf->GetY()+5, 190, 6, 3, 'DF', '1234');

		$xstart = 15;
		$y = $pdf->GetY();
		$pdf->SetY($pdf->GetY()+5);
		$pdf->SetX($xstart);
		
		//Table with 20 rows and 4 columns
//		$pdf->SetWidths(array(20, 15, 30, 80, 22, 22));
		$pdf->SetWidths(array(145, 22, 22));
		$pdf->SetAligns(array("J", "L", "L"));
		$pdf->SetFont('verdana','',7);
		
		$xstart = 10;
		$pdf->SetX($xstart);
		
		//print_r($nodosConceptos);
		foreach($nodosConceptos as $concepto)
		{
			//$nb = $pdf->WordWrap($concepto["descripcion"], 80);
			
			$valorUnitario = "$".$this->Util()->CadenaOriginalVariableFormat($concepto["valorUnitario"], true,false);
			$importe = "$".$this->Util()->CadenaOriginalVariableFormat($concepto["importe"], true,false);
			if($concepto["valorUnitario"] == 0)
			{
				$valorUnitario = "";
			}
			if($concepto["importe"] == 0)
			{
				$importe = "";
			}
			
			$xstart = 10;
			$pdf->SetX($xstart);
	    $pdf->Row(
				array(
					//$this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false),
					//$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
					//$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false), 
					utf8_decode(urldecode($concepto["descripcion"])), 
					$valorUnitario, 
					$importe
				)
			,3);

			$pdf->Ln();
			//TODO la parte y el complemento.
		}
		$pdf->Ln();
		//check page break
		$pdf->CheckPageBreak(50);
		$setY = $pdf->GetY();
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,"Otros impuestos o retenciones",0,0,"C");
		$pdf->Ln();

		//Table with 20 rows and 4 columns
		$pdf->SetWidths(array(20, 20, 127, 22));
		
		$xstart = 15;
		//$impuesto["importe"] = number_format($impuesto["importe"], 2);
		
		if($_SESSION["impuestos"])
		{
			foreach($_SESSION["impuestos"] as $impuesto)
			{
				$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						$this->Util()->CadenaOriginalVariableFormat(ucfirst($impuesto["tipo"]),false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["tasa"]."%",false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true) 
					)
				);
	
				$pdf->Ln();
			//TODO la parte y el complemento.
		}
		$pdf->Ln();
		//check page break
		$pdf->CheckPageBreak(50);
		}


		$setY = $pdf->GetY();
		$pdf->Line(10,$setY,200,$setY);
		$pdf->Line(10,$setY+1,200,$setY+1);

		$setY = $pdf->GetY();

		//block con letra
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, $setY+5, 35, 23, 3, 'DF', '1234');

		$xstart = 15;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);
		$pdf->SetFont('verdana','',6);
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
		$pdf->Cell(60,8,$letra,0);

		$pdf->SetFont('verdana','',6);

		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);

		//add cuenta
		if($data["NumCtaPago"])
		{
			$add = "Num. Cuenta: ".$data["NumCtaPago"];
		}
		
		$pdf->SetY($setY+18);
		$pdf->SetX($xstart);
		$pdf->Cell(35,8,"Forma De Pago",0);
		$pdf->Cell(60,8,$this->Util()->DecodeVal($data["formaDePago"]."\nMetodo de Pago: ".$data["metodoDePago"]." ".$add),0);
		$pdf->SetFont('verdana','',9);


		//block totales
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(150, $setY+5, 25, 36, 3, 'DF', '1234');

		$xstart = 150;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Subtotal",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalVariableFormat($totales["subtotal"], true,false),0,0,"R");

		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Descuento",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalVariableFormat($totales["descuento"], true,false),0,0,"R");

		$pdf->SetY($setY+15);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,$totales["tasaIva"]."% IVA",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalVariableFormat($totales["iva"], true,false),0,0,"R");

		$pdf->SetY($setY+20);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Ret Iva",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalVariableFormat($totales["retIva"], true,false),0,0,"R");

		$pdf->SetY($setY+25);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Ret Isr",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalVariableFormat($totales["retIsr"], true,false),0,0,"R");

		$offset = 5;
		if($totales["porcentajeIEPS"] != 0)
		{
			$pdf->SetY($setY+30);
			$pdf->SetX($xstart);
			$pdf->Cell(25,8,"IEPS",0,0,"C");
			$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalVariableFormat($totales["ieps"], true,false),0,0,"R");
			$offset = 10;
		}
		
		//echo $totales["total"];
		$pdf->SetY($setY+25+$offset);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Total",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalVariableFormat($totales["total2"], true,false),0,0,"R");

		$setY = $setY + 30 + $offset;
		$pdf->Line(10,$setY+10,200,$setY+10);
		$pdf->Line(10,$setY+11,200,$setY+11);

		$xstart = 10;
		$pdf->SetY($setY+15);
		$pdf->SetX($xstart);

		$pdf->SetFont('courier','',6);
		$pdf->SetWidths(array(180));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		//$nb = $pdf->WordWrap($data["observaciones"], 180);
	    $pdf->Row(
				array( utf8_decode(urldecode($data["observaciones"]))), 4
			);
		$pdf->SetFont('verdana','',8);
		$pdf->CheckPageBreak(10);

		$xstart = 10;
		$pdf->SetY($pdf->GetY()+10);
		$pdf->SetX($xstart);

//		$pdf->CheckPageBreak(30);

		$xstart = 10;
//		$pdf->SetY($setY+15);
		$pdf->SetX($xstart);

		$pdf->SetFillColor(255);

		$pdf->SetFont('verdana','',6);
		$y = $pdf->GetY();
		if($data["autorizo"] && $data["autorizo"] != "$('autorizo').value")
		{
			$pdf->MultiCell(60,3,utf8_decode("AUTORIZO:").urldecode($data["autorizo"]),0,"C",0);
		}
		$pdf->SetY($y);
		$pdf->SetX(70);
		if($data["recibio"] && $data["recibio"] != "$('recibio').value")
		{
			$pdf->MultiCell(60,3,utf8_decode(urldecode("CONTRATISTA:".$data["recibio"])),0,"C", 0);
		}
		$pdf->SetY($y);
		$pdf->SetX(140);
		if($data["vobo"] && $data["vobo"] != "$('vobo').value")
		{
			$pdf->MultiCell(60,3,utf8_decode(urldecode("Vo. Bo:".$data["vobo"])),0,"C", 0);
		}

		if($data["autorizo"] || $data["recibio"] || $data["vobo"])
		{
			$pdf->CheckPageBreak(15);
			$pdf->SetY($pdf->GetY()+15);
			$pdf->SetX($xstart);
		}
		
		//$pdf->SetX(10);
		$y = $pdf->GetY();
		if($data["reviso"] && $data["reviso"] != "$('reviso').value")
		{
			$pdf->MultiCell(90,3,utf8_decode(urldecode("REVISO:\n".$data["reviso"])),0,"C",0);
		}
		
		$pdf->SetY($y);
		$pdf->SetX(100);
		
		if($data["pago"] && $data["pago"] != "$('pago').value")
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
		
		$pdf->SetFont('verdana','',5);
		$pdf->SetFillColor(200,200,200);
		$pdf->Ln();
		$pdf->MultiCell(190,3,"Sello Emisor: ".$data["sello"],0,"L",1);
//		$pdf->Ln();
		$pdf->MultiCell(190,3,"Sello SAT: ".$data["timbreFiscal"]["selloSAT"],0,"L",1);
//		$pdf->Ln();
//		$cadena["cadenaOriginal"] = utf8_decode(utf8_decode($data["cadenaOriginal"]));
//		$pdf->MultiCell(190,3,"Cadena Original: \n".$cadena["cadenaOriginal"],0,"L",1);

		$cadena["cadenaOriginalTimbre"] = utf8_decode(utf8_decode($data["timbreFiscal"]["original"]));
		$pdf->MultiCell(190,3,"Cadena Original Timbre Fiscal: \n".$cadena["cadenaOriginalTimbre"],0,"L",1);

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/pdf/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";

		//$pdf->Image($rootQr.$nufa.'.png',$xstart+160,$pdf->getY()-40, 28, 28);		

		if($cancelado){
		
			$xstart = 10;
			$pdf->SetFont('verdana','',36);
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
<?php

class Override extends Comprobante
{
	function GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa, $cancelado = 0, $vistaPrevia = 0)
	{
		$this->GenerateQR($data, $totales, $nodoEmisor, $nodoReceptor, $empresa, $serie);		
		//Instanciation of inherited class
		$pdf=new PDF('P', 'mm', "a4");
		$pdf->SetMargins(0.5,0.1,0.5);
		$pdf->SetAutoPageBreak(1, 5);		
		
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->AddFont('verdana','','verdana.php');
		$pdf->SetFont('verdana','',7);

		$pdf->SetFont('verdana','',12);
		$pdf->SetY(0);
		$pdf->SetX(2);
 		$pdf->SetTextColor(200, 0, 0);
  	$pdf->Cell(20,10,strtoupper($data["comprobante"]["nombre"]),0,0,'C');

		$pdf->SetFont('verdana','',7);
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/qrs/";
		$qrRfc = strtoupper($data["nodoEmisor"]["rfc"]["rfc"]);
		$nufa = $serie["serieId"].".jpg";
	
		if(file_exists($rootQr.$nufa))
		{
			//$pdf->Image($rootQr.$nufa,$xstart+160,$setY+15, 27.5, 27.5,'PNG'); 		
			$pdf->Image($rootQr.$nufa,2,7, 35,35); 		
		}

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/pdf/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";

		$pdf->Image($rootQr.$nufa.'.png',178,8, 30, 30);		

		$pdf->Image(DOC_ROOT."/images/fondo_278.jpg",50,90, 112,112); 		

 		$pdf->SetTextColor(0, 0, 0);
		//block emisor
		
		$idEmisor = $_SESSION["empresaId"];
		include_once(DOC_ROOT."/classes/".$idEmisor."_emisor.php");

//		$pdf->MultiCell(140,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["razonSocial"])),0);
		
		$y = 40;	
		$x = 2;
		$pdf->SetFont('verdana','',9);
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(54,4,utf8_decode("No. De Serie del Cert. SAT"),1, "C", 1);


		$pdf->SetFont('verdana','',9);
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(54,4,utf8_decode(SELLO_PAC),1, "C", 1);

		$y = 40;	
		$x = 56;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(50,4,utf8_decode("No. De Serie del Cert. Emisor"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(50,4,utf8_decode($data["serie"]["noCertificado"]),1, "C", 1);

		$y = 40;	
		$x = 106;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(25,4,utf8_decode("Serie y Folio"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(25,4,utf8_decode($data["serie"]["serie"]." ".$data["folio"]),1, "C", 1);

		$y = 40;	
		$x = 131;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(75,4,utf8_decode("Folio Fiscal"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(75,4,utf8_decode($data["timbreFiscal"]["UUID"]),1, "C", 1);


		$data["nodoReceptor"]["nombre"] = urlencode($data["nodoReceptor"]["nombre"]);
		
//		$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoReceptor"]["nombre"])),0);
		
		$infoReceptor = utf8_decode(urldecode($data["nodoReceptor"]["nombre"]));
		$infoReceptor .= "\n".utf8_decode(urldecode($data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]));
		$infoReceptor .= ", ".utf8_decode(urldecode($data["nodoReceptor"]["colonia"]));
		$infoReceptor .= ", ".utf8_decode(urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".$data["nodoReceptor"]["cp"]));
		
		$x = 2;
		$y = 50;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(129,4,utf8_decode("Datos Del CLiente"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(129,4,utf8_decode($infoReceptor),1, "C", 1);

		$x = 131;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(75,4,utf8_decode("R. F. C"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(75,16,$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["rfc"],false,false),1, "C", 1);

		$x = 2;
		$y = 72;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(129,4,utf8_decode("Lugar y Fecha de Elaboracion"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(129,4,utf8_decode("CINTALAPA DE FIGUEROA, CHIAPAS. ".$data["fecha"]),1, "C", 1);

		$x = 131;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(75,4,utf8_decode("Fecha y Hora de Certificacion"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(75,4,$this->Util()->CadenaOriginalVariableFormat($data["timbreFiscal"]["FechaTimbrado"],false,false),1, "C", 1);

		$x = 2;
		$y = 82;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(30,4,utf8_decode("Forma de Pago"),1, "C", 1);

		$x = 32;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(75,4,$this->Util()->DecodeVal($data["formaDePago"]),1, "C", 1);

		$x = 107;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(30,4,utf8_decode("Metodo de Pago"),1, "C", 1);

		if($data["NumCtaPago"])
		{
			$add = $data["NumCtaPago"];
		}

		$x = 137;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(69,4,$this->Util()->DecodeVal($data["metodoDePago"].". ".$add),1, "C", 1);

		//block serie
		$pdf->SetY(89);
		$y = 89;
		$x = 2;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(20,3,utf8_decode("CANTIDAD"),1, "C", 1);

		$x = 22;
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(20,3,utf8_decode("UNIDAD"),1, "C", 1);

		$x = 42;
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(100,3,utf8_decode("DESCRIPCION"),1, "C", 1);

		$x = 142;
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(32,3,utf8_decode("P. UNITARIO"),1, "C", 1);

		$x = 174;
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(32,3,utf8_decode("IMPORTE"),1, "C", 1);

		$pdf->SetWidths(array(20,20, 100, 32, 32));
		$pdf->SetAligns(array('R','C', 'L', 'R', 'R'));
		$pdf->SetFont('courier','',8);
		$xstart = 15;
		$count = 1;
		foreach($nodosConceptos as $concepto)
		{
			$pdf->SetTextColor(0, 0, 0);
			$count++;

			$concepto["descripcion"] = str_replace("&quot;", "\"", $concepto["descripcion"]);
			$concepto["descripcion"] = str_replace("&#039;", "'", $concepto["descripcion"]);
			
			//$nb = $pdf->WordWrap($concepto["descripcion"], 105);
			$xstart = 15;
	    $pdf->Row(
				array(
					$this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false),
					$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
//					$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false), 
					utf8_decode($concepto["descripcion"]), 
					"$".$this->Util()->CadenaOriginalPDFFormat($concepto["valorUnitario"], true,false), 
					"$".$this->Util()->CadenaOriginalPDFFormat($concepto["importe"], true,false)
				),3
			);

		}

		$xstart = 2;
 		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('courier','',8);
		$pdf->SetY($pdf->GetY()+2);
		$pdf->SetX($xstart);
		foreach($nodosConceptos as $concepto)
		{
			$buenoPor = $concepto["importe"] + ($concepto["importe"] * $totales["iva"]);
			$tempSubtotal += $concepto["importe"];
		}
		
		$setY=132;
		$setY = $pdf->GetY() + 5;
		$pdf->SetY($setY);
 		$pdf->SetTextColor(0,0,0);
		
		$xstart = 15;
		$count = 1;
		$pdf->SetTextColor(0, 0, 0);

		$setY = $pdf->GetY() + 3;
		$pdf->SetFont('verdana','',9);

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
		$setY = 195;
		$x = 2;
		$y = $setY;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(35,4,utf8_decode("Cantidad Con Letra"),1, "C", 1);

		$x = 37;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(169,4,$this->Util()->DecodeVal($letra),1, "C", 1);
		
		$x = 2;
		$setY = $pdf->GetY()+2;
		$y = $setY;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(130,9,utf8_decode("ESTE DOCUMENTO ES REPRESENTACION IMPRESA DE UN CFDI"),1, "C", 1);
		
		$x = 142;
		$setY = $y;
		$y = $setY;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(30,4,utf8_decode("Subtotal"),1, "C", 1);

		$x = 172;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(34,4,"$".$this->Util()->CadenaOriginalPDFFormat($totales["subtotal"], true,false),1, "R", 1);

		$x = 142;
		$setY = $pdf->GetY();
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(30,4,utf8_decode("Descuento"),1, "C", 1);

		$x = 172;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(34,4,"$".$this->Util()->CadenaOriginalPDFFormat($totales["descuento"], true,false),1, "R", 1);

		$x = 142;
		$setY = $pdf->GetY();
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(30,4,utf8_decode($totales["tasaIva"]."% IVA"),1, "C", 1);

		$x = 172;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(34,4,"$".$this->Util()->CadenaOriginalPDFFormat($totales["iva"], true,false),1, "R", 1);

		$x = 142;
		$setY = $pdf->GetY();
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(30,4,utf8_decode("2% ISH"),1, "C", 1);

		$x = 172;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($setY);
		$pdf->SetX($x);
		$pdf->MultiCell(34,4,"$".$this->Util()->CadenaOriginalPDFFormat($totales["ish"], true,false),1, "R", 1);

		if($totales["retIva"] != 0)
		{
			$x = 142;
			$setY = $pdf->GetY();
			$pdf->SetTextColor(255, 255, 255);
			$pdf->SetFillColor(0, 0, 0);
			$pdf->SetY($setY);
			$pdf->SetX($x);
			$pdf->MultiCell(30,4,utf8_decode("Ret. IVA"),1, "C", 1);
	
			$x = 172;
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($setY);
			$pdf->SetX($x);
			$pdf->MultiCell(34,4,"$".$this->Util()->CadenaOriginalPDFFormat($totales["retIva"], true,false),1, "R", 1);
		}

		if($totales["retIsr"] != 0)
		{
			$x = 142;
			$setY = $pdf->GetY();
			$pdf->SetTextColor(255, 255, 255);
			$pdf->SetFillColor(0, 0, 0);
			$pdf->SetY($setY);
			$pdf->SetX($x);
			$pdf->MultiCell(30,4,utf8_decode("Ret. ISR"),1, "C", 1);
	
			$x = 172;
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($setY);
			$pdf->SetX($x);
			$pdf->MultiCell(34,4,"$".$this->Util()->CadenaOriginalPDFFormat($totales["retIsr"], true,false),1, "R", 1);
		}

			$x = 142;
			$setY = $pdf->GetY();
			$pdf->SetTextColor(255, 255, 255);
			$pdf->SetFillColor(0, 0, 0);
			$pdf->SetY($setY);
			$pdf->SetX($x);
			$pdf->MultiCell(30,4,utf8_decode("Total"),1, "C", 1);
	
			$x = 172;
			$pdf->SetTextColor(0, 0, 0);
			$pdf->SetFillColor(255, 255, 255);
			$pdf->SetY($setY);
			$pdf->SetX($x);
			$pdf->MultiCell(34,4,"$".$this->Util()->CadenaOriginalPDFFormat($totales["total2"], true,false),1, "R", 1);

		//observaciones
		$x = 2;
		$pdf->SetY($setY + 5);
		$pdf->SetX($x);
		$pdf->SetFont('courier','',8);
		$pdf->SetWidths(array(180));
		$pdf->SetAligns(array('L'));
		$pdf->SetBorders(array('1'));
		
	    $pdf->Row(
				array( utf8_decode(urldecode($data["observaciones"]))), 3
			);

		
		//tipo de cambio
		$pdf->SetTextColor(0,0,0);

		$pdf->SetY($pdf->GetY() + 3);
		$pdf->SetX($xstart);
		$xstart = 2;
		$pdf->SetX($xstart);

		$pdf->SetFillColor(255);

		$y = $pdf->GetY();
		$pdf->SetY($y);

		$xstart = 2;
		$pdf->SetY($pdf->GetY());
		
		$pdf->SetFont('verdana','',6);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->MultiCell(207,3,"Sello Emisor: ".$data["sello"],0,"L",1);
//		$pdf->Ln();
		$pdf->MultiCell(207,3,"Sello SAT: ".$data["timbreFiscal"]["selloSAT"],0,"L",1);
//		$pdf->Ln();
//		$cadena["cadenaOriginal"] = utf8_decode(utf8_decode($data["cadenaOriginal"]));
//		$pdf->MultiCell(207,3,"Cadena Original: \n".$cadena["cadenaOriginal"],0,"L",1);

		$cadena["cadenaOriginalTimbre"] = utf8_decode(utf8_decode($data["timbreFiscal"]["original"]));
		$pdf->MultiCell(207,3,"Cadena Original Timbre Fiscal: \n".$cadena["cadenaOriginalTimbre"],0,"L",1);

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
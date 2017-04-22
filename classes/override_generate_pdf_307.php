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

		$pdf->SetY(2);
		$pdf->SetX(2);
 		$pdf->SetTextColor(200, 0, 0);
  	$pdf->Cell(20,10,$data["comprobante"]["nombre"],0,0,'C');

		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/qrs/";
		$qrRfc = strtoupper($data["nodoEmisor"]["rfc"]["rfc"]);
		$nufa = $serie["serieId"].".jpg";
	
		if(file_exists($rootQr.$nufa))
		{
			//$pdf->Image($rootQr.$nufa,$xstart+160,$setY+15, 27.5, 27.5,'PNG'); 		
			//$pdf->Image($rootQr.$nufa,2,10, 25,25); 		
		}

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/pdf/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";

		$pdf->Image($rootQr.$nufa.'.png',180,8, 28, 28);		
		$pdf->Image(DOC_ROOT."/images/fondo_".$_SESSION["empresaId"].".jpg",60,70, 90,90); 		


 		$pdf->SetTextColor(0, 0, 0);
		//block emisor
		$idEmisor = $_SESSION["empresaId"];
		include_once(DOC_ROOT."/classes/".$idEmisor."_emisor.php");

		$xstart = 35;
		$pdf->SetY(8);
		$pdf->SetX($xstart);
		$xstart = 30;
		$pdf->SetY(10);
		$pdf->SetX($xstart);

		$y = 35;	
		$x = 2;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(54,3,utf8_decode("No. De Serie del Cert. SAT"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(54,3,utf8_decode("00001000000302390533"),1, "C", 1);

		$y = 35;	
		$x = 56;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(50,3,utf8_decode("No. De Serie del Cert. Emisor"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(50,3,utf8_decode($data["serie"]["noCertificado"]),1, "C", 1);

		$y = 35;	
		$x = 106;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(25,3,utf8_decode("Serie y Folio"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(25,3,utf8_decode($data["serie"]["serie"]." ".$data["folio"]),1, "C", 1);

		$y = 35;	
		$x = 131;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(75,3,utf8_decode("Folio Fiscal"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(75,3,utf8_decode($data["timbreFiscal"]["UUID"]),1, "C", 1);


		$data["nodoReceptor"]["nombre"] = urlencode($data["nodoReceptor"]["nombre"]);
		
//		$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoReceptor"]["nombre"])),0);
		
		$infoReceptor = utf8_decode(urldecode($data["nodoReceptor"]["nombre"]));
		$infoReceptor .= "\n".utf8_decode(urldecode($data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]));
		$infoReceptor .= ", ".utf8_decode(urldecode($data["nodoReceptor"]["colonia"]));
		$infoReceptor .= ", ".utf8_decode(urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".$data["nodoReceptor"]["cp"]));
		
		$x = 2;
		$y = 41;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(129,3,utf8_decode("Datos Del CLiente"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(129,3,utf8_decode($infoReceptor),1, "C", 1);

		$x = 131;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(75,3,utf8_decode("R. F. C"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(75,12,$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["rfc"],false,false),1, "C", 1);

		$x = 2;
		$y = 56;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(129,3,utf8_decode("Lugar y Fecha de Elaboracion"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(129,3,
			utf8_decode(
				urldecode($data["nodoEmisor"]["rfc"]["calle"]." ".$data["nodoEmisor"]["rfc"]["noExt"]." ".$data["nodoEmisor"]["rfc"]["noInt"]." ".$data["nodoEmisor"]["rfc"]["colonia"]."\n".$data["pdfAutomatico"])),1, "C", 1);

		$x = 131;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(75,3,utf8_decode("Fecha y Hora de Certificacion"),1, "C", 1);

 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($x);
		$pdf->MultiCell(75,9,$this->Util()->CadenaOriginalVariableFormat($data["timbreFiscal"]["FechaTimbrado"],false,false),1, "C", 1);

		$x = 2;
		$y = 68;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(25,3,utf8_decode("Forma de Pago"),1, "C", 1);

		$x = 27;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(50,3,$this->Util()->DecodeVal($data["formaDePago"]),1, "C", 1);

		$x = 77;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(25,3,utf8_decode("Metodo de Pago"),1, "C", 1);

		if($data["NumCtaPago"])
		{
			$add = $data["NumCtaPago"];
		}

		$x = 102;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($y);
		$pdf->SetX($x);

		$pdf->MultiCell(50,3,$this->Util()->DecodeVal($data["metodoDePago"]." ".$data["metodoDePagoLetra"].". ".$add),1, "C", 1);


		$x = 152;
 		$pdf->SetTextColor(255, 255, 255);
 		$pdf->SetFillColor(0, 0, 0);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(25,3,utf8_decode("Tiempo Limite"),1, "C", 1);


		$x = 177;
 		$pdf->SetTextColor(0, 0, 0);
 		$pdf->SetFillColor(255, 255, 255);
		$pdf->SetY($y);
		$pdf->SetX($x);
		$pdf->MultiCell(29,3,utf8_decode(urldecode($data["tiempoLimite"])),1, "C", 1);


		//block serie
		$pdf->SetY(70);
		$setY = 70;

		$xstart = 113;
		$xstart = 138;

		//observaciones
		$pdf->SetY($setY + 2);
		$pdf->SetFont('courier','',7);
		$pdf->SetWidths(array(205));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		//$nb = $pdf->WordWrap($data["observaciones"], 180);
	    $pdf->Row(
				array( utf8_decode(urldecode($data["observaciones"]))), 3
			);
		$pdf->SetFont('courier','',7);
		//$pdf->CheckPageBreak(50);


		$xstart = 2;
 		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('courier','',7);
		$pdf->SetY($pdf->GetY()+2);
		$pdf->SetX($xstart);
		foreach($nodosConceptos as $concepto)
		{
			$buenoPor = $concepto["importe"] + ($concepto["importe"] * $totales["iva"]);
			$tempSubtotal += $concepto["importe"];
		}
		
		$setY = $pdf->GetY();
		$pdf->SetY($setY);
 		$pdf->SetTextColor(0,0,0);
		
		if($data["formatoNormal"] == 1)
		{
			include_once(DOC_ROOT."/classes/307_normal.php");
		}
		else
		{
			include_once(DOC_ROOT."/classes/307_especial.php");
		}

		
//		$letra = "(".$cantidadLetra." ".$tiposDeCambio." ".$centavosLetra."/100 ".$tiposDeCambioSufix.")";
		//tipo de cambio
		$pdf->SetTextColor(0,0,0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$xstart = 2;
		$pdf->SetX($xstart);

		$pdf->SetFillColor(255);

		$y = $pdf->GetY()+5;
		$pdf->SetY($y);
		if($data["autorizo"])
		{
			$pdf->MultiCell(60,3,utf8_decode("\n\n\n".urldecode($data["autorizo"])),0,"C",0);
		}
		$pdf->SetY($y);
		$pdf->SetX(70);
		if($data["recibio"])
		{
			$pdf->MultiCell(60,3,utf8_decode(urldecode("\n\n\n".$data["recibio"])),0,"C", 0);
		}
		$pdf->SetY($y);
		$pdf->SetX(140);
		if($data["vobo"])
		{
			$pdf->MultiCell(60,3,utf8_decode(urldecode("\n\n\n".$data["vobo"])),0,"C", 0);
		}

		if($data["autorizo"] || $data["recibio"] || $data["vobo"])
		{
			$pdf->CheckPageBreak(15);
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);
		}
		
		//$pdf->SetX(10);
		$y = $pdf->GetY();
		$pdf->SetY($y+5);
		if($data["reviso"])
		{
			$pdf->MultiCell(90,3,utf8_decode(urldecode("\n\n\n".$data["reviso"])),0,"C",0);
		}
		
		$pdf->SetY($y+5);
		$pdf->SetX(100);
		
		if($data["pago"])
		{
			$pdf->MultiCell(90,3,utf8_decode(urldecode("\n\n\n".$data["pago"])),0,"C",0);
		}

		$xstart = 2;
		$pdf->SetY($pdf->GetY()+10);
		$pdf->SetX($xstart);
		$pdf->MultiCell(207,3,utf8_decode("\nESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI"),0,"C");

		$pdf->SetY($pdf->GetY());
		
		$pdf->SetFont('verdana','',5);
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
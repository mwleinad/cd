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
		$pdf->Cell(70,8,"RFC: ".$data["nodoEmisor"]["rfc"]["rfc"],0);

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

		$pdf->Line(10,52,200,52);
		$pdf->Line(10,53,200,53);
		
		//block receptor
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, 55, 25, 6, 3, 'DF', '1234');
		
		$pdf->SetFont('verdana','',8);
		
		$xstart = 15;
		$pdf->SetY(55);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Receptor",0);
		
		$infoReceptor = html_entity_decode(urldecode($data["nodoReceptor"]["nombre"]));
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["colonia"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".$data["nodoReceptor"]["cp"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["rfc"]);
				
		$xstart = 10;
		$pdf->SetY(62);
		$pdf->SetX($xstart);


		$pdf->SetFont('verdana','',5);
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

		//block conceptos
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, 95, 190, 6, 3, 'DF', '1234');

		$xstart = 15;
		$pdf->SetY(95);
		$pdf->SetX($xstart);
		$pdf->Cell(15,8,"Cantidad",0,0,"L");
		$pdf->Cell(12,8,"Unidad",0,0,"C");
		$pdf->Cell(15,8,"Cantidad",0,0,"L");
		$pdf->Cell(12,8,"Unidad",0,0,"C");
		$pdf->Cell(15,8,"Id",0,0,"C");
		$pdf->Cell(75,8,"Descripcion",0,0,"C");
		$pdf->Cell(19,8,"P. Unitario",0,0,"C");
		$pdf->Cell(22,8,"P. Importe",0,0,"C");

		$setY = 103;
		$pdf->SetY($setY);
		
		//Table with 20 rows and 4 columns
		$pdf->SetWidths(array(20, 16, 10, 15, 13, 73, 25, 25));
		
		$xstart = 15;
		foreach($nodosConceptos as $concepto)
		{
			$nb = $pdf->WordWrap($concepto["descripcion"], 75);
			$xstart = 25;
	    $pdf->Row(
				array(

					"  ".$this->Util()->CadenaOriginalVariableFormat($concepto["cantidad"],false,false),
					$this->Util()->CadenaOriginalPDFFormat($concepto["unidad"],false,true),
					$this->Util()->CadenaOriginalVariableFormat($concepto["monto"],false,false),

					$this->Util()->CadenaOriginalPDFFormat($concepto["medida"],false,false),
					$this->Util()->CadenaOriginalVariableFormat($concepto["noIdentificacion"],false,false), 
					$this->Util()->CadenaOriginalPDFFormat($concepto["descripcion"]), 
					"$".$this->Util()->CadenaOriginalPDFFormat($concepto["valorUnitario"], true,false), 
					"$".$this->Util()->CadenaOriginalPDFFormat($concepto["importe"], true,false)
				)
			);

			$pdf->Ln();
			//TODO la parte y el complemento.
		}
		$pdf->Ln();
		//check page break
		$pdf->CheckPageBreak(50);
		$setY = $pdf->GetY();
		$pdf->Line(10,$setY,200,$setY);
		$pdf->Line(10,$setY+1,200,$setY+1);

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
			default : $tiposDeCambio = "Pesos"; $tiposDeCambioSufix = "M.N";break;
		}
		$letra = $cantidadLetra." ".$tiposDeCambio." ".$centavosLetra."/100 ".$tiposDeCambioSufix;
		//tipo de cambio
		$pdf->Cell(60,8,$letra,0);

		$pdf->SetFont('verdana','',6);

		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);
	//	$pdf->Cell(35,8,"Observaciones",0);
		$pdf->SetWidths(array(35, 115));
		$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		$nb = $pdf->WordWrap($data["observaciones"], 95);
	    $pdf->Row(
				array( "Observaciones", utf8_decode(urldecode($data["observaciones"]))
				), 3
			);

//$pdf->Cell(60,8,utf8_decode(urldecode($data["observaciones"])),0);

		$pdf->SetY($setY+18);
		$pdf->SetX($xstart);
		$pdf->Cell(35,8,"Tipo De Pago",0);
		$pdf->Cell(60,8,$this->Util()->DecodeVal($data["formaDePago"]),0);
		$pdf->SetFont('verdana','',9);


		//block totales
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(150, $setY+5, 25, 36, 3, 'DF', '1234');

		$xstart = 150;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Subtotal",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["subtotal"], true,false),0,0,"R");

		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Descuento",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["descuento"], true,false),0,0,"R");

		$pdf->SetY($setY+15);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,$totales["tasaIva"]."% IVA",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["iva"], true,false),0,0,"R");

		$pdf->SetY($setY+20);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Ret Iva",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["retIva"], true,false),0,0,"R");

		$pdf->SetY($setY+25);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Ret Isr",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["retIsr"], true,false),0,0,"R");

		$offset = 5;
		if($totales["porcentajeIEPS"] != 0)
		{
			$pdf->SetY($setY+30);
			$pdf->SetX($xstart);
			$pdf->Cell(25,8,"IEPS",0,0,"C");
			$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["ieps"], true,false),0,0,"R");
			$offset = 10;
		}
		
		//echo $totales["total"];
		$pdf->SetY($setY+25+$offset);
		$pdf->SetX($xstart);
		$pdf->Cell(25,8,"Total",0,0,"C");
		$pdf->Cell(25,8,"$".$this->Util()->CadenaOriginalPDFFormat($totales["total2"], true,false),0,0,"R");

		$setY = $setY + 30 + $offset;
		$pdf->Line(10,$setY+10,200,$setY+10);
		$pdf->Line(10,$setY+11,200,$setY+11);

		$xstart = 10;
		$pdf->SetY($setY+15);
		$pdf->SetX($xstart);
		$pdf->Cell(180,8,utf8_decode("Este documento es una representación impresa de un CFDi"),0,0,"C");
		
		$pdf->SetFont('verdana','',5);
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

		$pdf->Image($rootQr.$nufa.'.png',$xstart+160,$pdf->getY()-40, 28, 28);		

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
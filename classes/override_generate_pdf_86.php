<?php

class Override extends Comprobante
{
	function GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa, $cancelado = 0, $vistaPrevia = 0)
	{
		$this->GenerateQR($data, $totales, $nodoEmisor, $nodoReceptor, $empresa, $serie);		
		//Instanciation of inherited class
		$pdf=new PDF('P', 'mm', "a4");
		
		$pdf->SetAutoPageBreak(true, 1.6);
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

		$pdf->Image(DOC_ROOT."/images/header_86.jpg",10,15, 155,25); 		
		$pdf->Image($rootQr.$nufa.'.png',$xstart+165,13, 28, 28);		
			
			
			$pdf->Image(DOC_ROOT."/images/fondo_86.jpg",20,90, 170,120); 		

 		$pdf->SetTextColor(0, 0, 0);
		//block emisor
		$pdf->SetFillColor(192);

		$pdf->SetFont('verdana','',9);
		//block serie
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(125, 45, 35, 28, 3, 'DF', '1234');

		$xstart = 127;
		$pdf->SetY(45);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"FACTURA No.",0);

		$pdf->SetY(50);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Certificado",0);

		$pdf->SetY(55);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Fecha",0);

		$pdf->SetY(60);
		$pdf->SetX($xstart);
		$pdf->Cell(90,8,utf8_decode("UUID"),0);

		$pdf->SetY(65);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Fecha Timbrado",0);

		$xstart = 165;
		$pdf->SetY(45);
		$pdf->SetX($xstart);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->Cell(20,8,$data["serie"]["serie"],0,0,'R');

		$pdf->SetTextColor(170, 0, 0);
		$pdf->Cell(20,8,$data["folio"],0,0,'R');

		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetY(50);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["serie"]["noCertificado"],0,0,'R');

		$pdf->SetY(55);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["fecha"],0,0,'R');

		$pdf->SetFont('verdana','',5);

		$pdf->SetY(60);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["timbreFiscal"]["UUID"],0,0,'R');

		$pdf->SetFont('verdana','',9);

		$pdf->SetY(65);
		$pdf->SetX($xstart);
		$pdf->Cell(40,8,$data["timbreFiscal"]["FechaTimbrado"],0,0,'R');

//		$pdf->Line(10,42,200,42);
//		$pdf->Line(10,43,200,43);
		
		//block receptor
		$pdf->SetFillColor(255);
		$pdf->RoundedRect(10, 45, 110, 28, 3, 'DF', '1234');
		
		$pdf->SetFont('verdana','',8);
		
		$xstart = 15;
		$pdf->SetY(45);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Cliente",0);
		
		$infoReceptor = utf8_decode(urldecode($this->Util()->CadenaOriginalVariableFormatNoMas($data["nodoReceptor"]["nombre"], false, false)));
		$infoReceptor .= "\n".utf8_decode(urldecode($data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]));
		$infoReceptor .= utf8_decode(urldecode($data["nodoReceptor"]["colonia"]));
		$infoReceptor .= "\n".utf8_decode(urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." \nCP: ".str_pad($data["nodoReceptor"]["cp"], 5, "0", STR_PAD_LEFT)));
		
		//$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["razonSocial"])),0);
		
		$infoReceptor .= " ".utf8_decode(urldecode("RFC: ".$this->Util()->CadenaOriginalVariableFormatNoMas($data["nodoReceptor"]["rfc"],false,false)));

		$infoReceptor = str_replace("&AMP;", "&", $infoReceptor);
		
/*		$infoReceptor = urldecode($data["nodoReceptor"]["nombre"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]);
		$infoReceptor .= "\n\nColonia: ".urldecode($data["nodoReceptor"]["colonia"]);
		$infoReceptor .= "\n".urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".$data["nodoReceptor"]["cp"]);
		$infoReceptor .= "\n\nRFC: ".urldecode($data["nodoReceptor"]["rfc"]);
				
*/		$xstart = 10;
		$pdf->SetY(52);
		$pdf->SetX($xstart);


/*		$pdf->Line(10,51,120,51);
		$pdf->Line(10,55,120,55);
		$pdf->Line(10,58,120,58);
		$pdf->Line(10,61,120,61);
		$pdf->Line(10,64,120,64);
		$pdf->Line(10,67,120,67);
		$pdf->Line(10,70,120,70);
		$pdf->Line(10,73,120,73);
*/
		$pdf->SetFont('verdana','',7);
		$pdf->SetWidths(array(80));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		$nb = $pdf->WordWrap($infoReceptor, 80);
	    $pdf->Row(
				array( utf8_decode(urldecode($infoReceptor))), 3
			);
		$pdf->SetFont('verdana','',8);

//		$pdf->Line(10,83,200,83);
//		$pdf->Line(10,84,200,84);

		$yObservaciones = 10;
		if($data["observaciones"])
		{
			$yObservaciones = 5;
			$setY = $pdf->GetY()+10;
			$pdf->SetY($setY);
			$pdf->SetFont('courier','',8);
			$pdf->SetWidths(array(180));
			//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
			//$nb = $pdf->WordWrap($data["observaciones"], 180);
				$pdf->Row(
					array( utf8_decode(urldecode($data["observaciones"]))), 4
				);
			$pdf->SetFont('verdana','',8);
			$pdf->CheckPageBreak(20);
		}

		$setY = $pdf->GetY();
		
		$xstart = 15;
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, $pdf->GetY()+$yObservaciones, 190, 6, 3, 'DF', '1234');
		$y = $pdf->GetY();
		$pdf->SetY($pdf->GetY()+$yObservaciones);
		$pdf->SetX($xstart);
		$pdf->Cell(35,8,"CANTIDAD",0,0,"C");
		$pdf->Cell(100,8,"DESCRIPCION",0,0,"C");
		$pdf->Cell(22,8,"P. UNIT",0,0,"C");
		$pdf->Cell(22,8,"IMPORTE",0,0,"C");


		//block conceptos


		$setY = $pdf->GetY()+8;
		$pdf->SetY($setY);
		$pdf->SetFont('verdana','',7);
		
		//Table with 20 rows and 4 columns
		$pdf->SetWidths(array(15,15,15, 100, 22, 22));
		$pdf->SetAligns(array("L","L","L", "L", "L", "L"));
		
		//print_r($nodosConceptos);
		$xstart = 15;
		$currentCategory = "";
		foreach($nodosConceptos as $concepto)
		{
			if($concepto["categoriaConcepto"] != $currentCategory)
			{
				$currentCategory = $concepto["categoriaConcepto"];

			$pdf->SetFont('verdana','',9);
	    $pdf->Row(
				array(
					"",
					"",
					"",
					"            ".$currentCategory, 
					"", 
					""
				)
			, 6);
				
			}
			$pdf->SetFont('verdana','',7);
			$nb = $pdf->WordWrap($concepto["descripcion"], 80);
			$xstart = 15;
	    $pdf->Row(
				array(
					"  ",
					$this->Util()->CadenaOriginalVariableFormat("          ".$concepto["cantidad"],false,false),
					$this->Util()->CadenaOriginalVariableFormat($concepto["unidad"],false,false),
					$this->Util()->CadenaOriginalPDFFormat($concepto["descripcion"], false, false), 
					"$".number_format($this->Util()->CadenaOriginalVariableFormat($concepto["valorUnitario"], true,false), 2, ".", ","), 
					"$".number_format($this->Util()->CadenaOriginalVariableFormat($concepto["importe"], true,false), 2, ".", ",")
				)
			, 3);

		$pdf->SetY($pdf->GetY());

//			$pdf->Ln();
			//TODO la parte y el complemento.
		}
		$pdf->Ln();
		//check page break
		$pdf->CheckPageBreak(10);


		$setY = $pdf->GetY();
//		$pdf->Line(10,$setY,200,$setY);
//		$pdf->Line(10,$setY+1,200,$setY+1);

		//observaciones
//		$pdf->Line(10,$setY,200,$setY);
//		$pdf->Line(10,$setY+1,200,$setY+1);
		$pdf->SetFont('verdana','',8);

		//block con letra
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(10, $setY+5, 35, 18, 3, 'DF', '1234');

		$xstart = 15;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);
		$pdf->SetFont('verdana','',6);
		$pdf->Cell(35,8,"Total Con letra",0);
		$totales["total"];
		$cents = ($totales["total"] - floor($totales["total"]))*100;
		$totales["total2"] = $totales["total"];
		
		//$centavosLetra = $this->Util()->GetCents($totales["total"] - $data["isn"] - $data["spf"]);
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
		//$cantidadLetra = $this->Util()->num2letras($totales["total"] - $data["isn"] - $data["spf"], false);
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
//	$temp->setNumero($totales["total2"] - $data["isn"] - $data["spf"]);
	$letra = $temp->letra();
		//tipo de cambio
		$pdf->MultiCell(90,3,$letra,0,"L",0);		
//		$pdf->Cell(60,8,$letra,0);

		$pdf->SetFont('verdana','',6);

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
		$pdf->Cell(60,8,$this->Util()->DecodeVal($data["formaDePago"]." Metodo de Pago: ".$data["metodoDePago"]." ".$add),0);
		$pdf->SetFont('verdana','',8);


		//block totales
		$pdf->SetFillColor(192);
		$pdf->RoundedRect(142, $setY+5, 32, 32, 3, 'DF', '1234');

		$xstart = 145;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);
		$pdf->Cell(30,8,"Subtotal",0,0,"C");
		
	if(is_array($_SESSION["impuestos"]))
	{
		foreach($_SESSION["impuestos"] as $impuesto)
		{
			$suma = $impuesto["importe"]*count($_SESSION["conceptos"]);
		}
	}
		
		$pdf->Cell(25,8,"$".number_format($this->Util()->CadenaOriginalVariableFormat($totales["subtotal"] + $suma, true,false),2, ".", ","),0,0,"R");

		if($totales["descuento"] != 0)
		{
			$pdf->SetY($setY+10);
			$pdf->SetX($xstart);

			$pdf->Cell(30,8,"Descuento",0,0,"C");
			$pdf->Cell(25,8,"$".number_format($this->Util()->CadenaOriginalVariableFormat($totales["descuento"], true,false),2, ".", ","),0,0,"R");			
		}


		$pdf->SetY($setY+10);
		$pdf->SetX($xstart);
		$pdf->Cell(30,8,"+ ".$totales["tasaIva"]."% IVA",0,0,"C");
		$pdf->Cell(25,8,"$".number_format($this->Util()->CadenaOriginalVariableFormat($totales["iva"], true,false),2, ".", ","),0,0,"R");
	$offset = 15;

	if(is_array($_SESSION["impuestos"]))
	{
		foreach($_SESSION["impuestos"] as $impuesto)
		{
			$pdf->SetY($setY+$offset);
			$pdf->SetX($xstart);
			$pdf->Cell(30,8,"".$impuesto["impuesto"],0,0,"C");
			$pdf->Cell(25,8,"$".number_format($this->Util()->CadenaOriginalVariableFormat($impuesto["importe"]*count($_SESSION["conceptos"]), true,false),2, ".", ","),0,0,"R");
			$offset+=5;
		}
	}
		
		//echo $totales["total"];
		$pdf->SetY($setY+20+$offset);
		$pdf->SetX($xstart);
		$pdf->Cell(30,8,"Total",0,0,"C");
		//$pdf->Cell(25,8,"$".number_format($this->Util()->CadenaOriginalVariableFormat($totales["total2"] - $data["isn"] - $data["spf"], true,false),2, ".", ","),0,0,"R");
		$pdf->Cell(25,8,"$".number_format($this->Util()->CadenaOriginalVariableFormat($totales["total2"], true,false),2, ".", ","),0,0,"R");

		$setY = $setY + 30 + $offset;
//		$pdf->Line(10,$setY,200,$setY);
//		$pdf->Line(10,$setY+1,200,$setY+1);

		$pdf->CheckPageBreak(10);

		$xstart = 10;
		$pdf->SetY($setY+5);
		$pdf->SetX($xstart);



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
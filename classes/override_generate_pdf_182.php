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
		
		$nufa = DOC_ROOT."/images/fondo_182.jpg";
		if(file_exists($nufa))
		{
			$pdf->Image($nufa,2,15, 25,10); 		
		}

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/pdf/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";

		$pdf->Image($rootQr.$nufa.'.png',180,10, 28, 28);		
		//block emisor

 		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetFont('verdana','',14);
		$xstart = 48;
		$pdf->SetY(8);
		$pdf->SetX($xstart);
		$pdf->MultiCell(0,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["razonSocial"])),0);
		
		
		$xstart = 30;
		$pdf->SetFont('verdana','',7);
		$pdf->SetY(15);
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,"R.F.C. ".$data["nodoEmisor"]["rfc"]["rfc"],0, "C");
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["calle"]." ".$data["nodoEmisor"]["rfc"]["noExt"]." ".$data["nodoEmisor"]["rfc"]["noInt"])),0, "C");

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$data["nodoEmisor"]["rfc"]["cp"] = str_pad($data["nodoEmisor"]["rfc"]["cp"], 5, "0", STR_PAD_LEFT);
		$pdf->MultiCell(80,3,utf8_decode(urldecode("TELS. (01 961) 612 3419, 612-3408, 612-3559")),0, "C");

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$data["nodoEmisor"]["rfc"]["cp"] = str_pad($data["nodoEmisor"]["rfc"]["cp"], 5, "0", STR_PAD_LEFT);
		$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["municipio"]." ".$data["nodoEmisor"]["rfc"]["estado"])),0, "C");


		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,"Regimen Fiscal: ".utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["regimenFiscal"])),0, "C");

		//block serie
		$pdf->SetFillColor(30,30,30);
 		$pdf->SetTextColor(0, 0, 0);
//		$pdf->Rect(112, 15, 25, 22, 'DF');
		$pdf->SetFillColor(30);
		$pdf->RoundedRect(112, 15, 25, 22, 2);
		$pdf->SetFillColor(255);

		$xstart = 113;
		$pdf->SetY(16);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Serie",0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Folio",0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Certificado",0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Fecha",0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(90,3,utf8_decode("UUID"),0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Fecha Timbrado",0);

		$xstart = 138;
		$pdf->SetY(15);
		$pdf->SetX($xstart);
		$pdf->SetTextColor(200, 0, 0);
		$pdf->MultiCell(43,3,$data["serie"]["serie"],0,0,'R');

		$pdf->SetTextColor(0, 0, 0);
		$xstart = 138;
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(43,3,$data["folio"],0,0,'R');

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(43,3,$data["serie"]["noCertificado"],0,0,'R');

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(43,4,$data["fecha"],0,0,'R');

		$pdf->SetFont('verdana','',5);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(43,3,$data["timbreFiscal"]["UUID"],0,0,'R');

		$pdf->SetFont('verdana','',7);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(43,3,$data["timbreFiscal"]["FechaTimbrado"],0,0,'R');

		$pdf->SetY(35);

		//block receptor
		$pdf->SetFillColor(30,30,30);
//		$pdf->Rect(2, 40, 25, 3, 'DF');
		$pdf->RoundedRect(2, 38, 100, 25, 2);
 		$pdf->SetTextColor(255, 255, 255);
		
		$pdf->SetFont('verdana','',7);
		
		$xstart = 2;
		$pdf->SetY(40);
		$pdf->SetX(6);
 		$pdf->SetTextColor(0,0,0);
		
		$data["nodoReceptor"]["nombre"] = urlencode($data["nodoReceptor"]["nombre"]);
		
//		$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoReceptor"]["nombre"])),0);
		
		$infoReceptor = utf8_decode(urldecode($data["nodoReceptor"]["nombre"]));
		$infoReceptor .= "\n".utf8_decode(urldecode("Direccion ".$data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]));
		$infoReceptor .= "\n".utf8_decode(urldecode($data["nodoReceptor"]["colonia"]));
		$infoReceptor .= "\n".utf8_decode(urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".$data["nodoReceptor"]["cp"]));
		
		//$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["razonSocial"])),0);
		
		$infoReceptor .= "\n".urldecode("RFC: ".$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["rfc"],false,false));
				
		$xstart = 2;
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);


		$pdf->SetFont('verdana','',7);
		$pdf->SetWidths(array(100));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		$nb = $pdf->WordWrap($infoReceptor, 100);
	    $pdf->Row(
				array( $infoReceptor), 3
			);
			
		$pdf->SetFont('verdana','',7);

//$pdf->MultiCell(80,4,$infoReceptor,0);
				
		//block sucursal
		
		if($data["nodoEmisor"]["sucursal"]["sucursalActiva"] == 'no'){
		
			$infoSucursal = urldecode($data["nodoEmisor"]["sucursal"]["identificador"]);
			$infoSucursal .= "\n".urldecode("Direccion: ".$data["nodoEmisor"]["sucursal"]["calle"]." ".$data["nodoEmisor"]["sucursal"]["noExt"]." ".$data["nodoEmisor"]["sucursal"]["noInt"]);
			$infoSucursal .= "\n".urldecode($data["nodoEmisor"]["sucursal"]["colonia"]);
			$infoSucursal .= "\n".urldecode($data["nodoEmisor"]["sucursal"]["municipio"]." ".$data["nodoEmisor"]["sucursal"]["estado"]." ".$data["nodoEmisor"]["sucursal"]["pais"]." \nCP: ".$data["nodoEmisor"]["sucursal"]["cp"]);
			//$infoSucursal .= "\n".urldecode("RFC: ".$data["nodoEmisor"]["sucursal"]["rfc"]);
			
			$pdf->SetFillColor(30,30,30);
			$pdf->RoundedRect(105, 38, 95, 25, 2);
			
//			$pdf->Rect(105, 40, 35, 3, 'DF');
	 		$pdf->SetTextColor(0, 0, 0);
	
			$xstart = 110;
			$pdf->SetY(38);
			$pdf->SetX($xstart);
			$pdf->MultiCell(70,8,"Lugar de Expedicion:",0);
	 		$pdf->SetTextColor(0,0,0);
			
			$xstart = 105;
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);

			$pdf->SetFont('verdana','',7);
			$pdf->SetWidths(array(100));
			//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
			$nb = $pdf->WordWrap($infoSucursal, 100);
				$pdf->Row(
					array( utf8_decode(urldecode($infoSucursal))
					), 3
				);
			$pdf->SetFont('verdana','',8);

		
		}//if
		else
		{
			$infoSucursal = urldecode($data["nodoEmisor"]["sucursal"]["identificador"]."\n . \n . \n .  \n");
			
			$pdf->SetFillColor(30,30,30);
//			$pdf->Rect(105, 40, 35, 3, 'DF');
			$pdf->RoundedRect(105, 38, 102, 25, 2);
	 		$pdf->SetTextColor(0, 0, 0);
	
			$xstart = 110;
			$pdf->SetY(38);
			$pdf->SetX($xstart);
			$pdf->MultiCell(70,8,"Lugar de Expedicion",0);
	 		$pdf->SetTextColor(0,0,0);
			
			$xstart = 105;
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);

			$pdf->SetFont('verdana','',7);
			$pdf->SetWidths(array(100));
			//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
			$nb = $pdf->WordWrap($infoSucursal, 100);
				$pdf->Row(
					array( utf8_decode(urldecode($infoSucursal))
					), 3
				);
			$pdf->SetFont('verdana','',8);

		
		}//if
		
		$setY = $pdf->GetY() + 5;
		$pdf->SetY($setY);

		//observaciones
		$pdf->SetY($pdf->GetY() + 2);
		$pdf->SetFont('courier','',7);
		$pdf->SetWidths(array(210));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		//$nb = $pdf->WordWrap($data["observaciones"], 180);
	    $pdf->Row(
				array( utf8_decode(urldecode($data["observaciones"]))), 3
			);
		$pdf->SetFont('verdana','',7);
		//$pdf->CheckPageBreak(50);
		
		//block conceptos
		$pdf->SetFillColor(30,30,30);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Rect(2, $pdf->GetY()+2, 205, 6, 'DF');

		$xstart = 2;
		$y = $pdf->GetY();
		$pdf->SetY($pdf->GetY()+2);
		$pdf->SetX($xstart);
		$pdf->Cell(15,8,"Cnt.",0,0,"C");
		$pdf->Cell(15,8,"Unid.",0,0,"C");
		$pdf->Cell(20,8,"No. Id",0,0,"C");
		$pdf->Cell(75,8,"Descripcion",0,0,"C");
		$pdf->Cell(20,8,"P. sin Imp.",0,0,"C");
		$pdf->Cell(20,8,"%Imp.",0,0,"C");
		$pdf->Cell(17,8,"P. con Imp.",0,0,"C");
		$pdf->Cell(22,8,"Importe",0,0,"C");

		$setY = $pdf->GetY()+10;
		$pdf->SetY($setY);
 		$pdf->SetTextColor(0,0,0);
		
		//Table with 20 rows and 4 columns
		$pdf->SetWidths(array(5,15, 15, 20, 62, 22, 22, 22, 22));
		$pdf->SetAligns(array('L','L', 'L', 'L', 'L', 'R', 'R', 'R', 'R'));
		$pdf->SetFont('courier','',7);
		$xstart = 15;
		$count = 1;
		
		$subtotalWithIva = 0;
		$subtotalExcento = 0;
		foreach($nodosConceptos as $concepto)
		{
//			print_r($concepto);
			$pdf->SetTextColor(0, 0, 0);
			$count++;
			
			$tasaConcepto = 0;
			$withIva = $concepto["valorUnitario"];
			
			if($concepto["excentoIva"] == "no")
			{
				$subtotalWithIva += $concepto["importe"]; 
				$withIva = $concepto["valorUnitario"] * (1 + $totales["tasaIva"] / 100); 
				$tasaConcepto = $totales["tasaIva"];
			}
			else
			{
				$subtotalExcento += $concepto["importe"]; 
			}
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
					$this->Util()->CadenaOriginalPDFFormat($tasaConcepto, true,false), 
					"$".$this->Util()->CadenaOriginalPDFFormat($withIva, true,false), 
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
		$pdf->SetFillColor(30,30,30);
		//$pdf->Rect(2, $setY+2, 22, 13, 'DF');
		$pdf->RoundedRect(2, $setY+2, 125, 20, 2);
		$pdf->SetTextColor(0, 0, 0);

		$xstart = 3;
		$pdf->SetY($setY+3);
		$pdf->SetX($xstart);
		$pdf->SetFont('verdana','',7);
		$pdf->MultiCell(25,3,"Cantidad en letra",0);
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
		$pdf->SetY($setY+6);
		$pdf->SetX($xstart+5);
		$pdf->MultiCell(120,3,$letra."\nMetodo de Pago: ".$data["metodoDePago"],0);

		$pdf->SetFont('verdana','',7);

		//add cuenta
		if($data["NumCtaPago"])
		{
			$add = "Numero de Cuenta: ".$data["NumCtaPago"];
		}
				
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);

		//block totales
		$pdf->SetFillColor(30,30,30);
		$pdf->RoundedRect(130, $setY+2, 77, 20,2);

		//$pdf->SetFillColor(255);
		$pdf->SetTextColor(0, 0, 0);

		$xstart = 130;
		$pdf->SetY($setY+2);
		$pdf->SetX($xstart);

		$pdf->MultiCell(55,5,"Total: Producto 0% Gravado","BR","R",0);
		$pdf->SetY($pdf->GetY()-5);
		$pdf->SetX($xstart+46);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,5,"$".$this->Util()->CadenaOriginalPDFFormat($subtotalExcento, true,false),"B","R",0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);

		$pdf->MultiCell(55,5,$totales["tasaIva"]."% Gravado","BR","R",0);
		$pdf->SetY($pdf->GetY()-5);
		$pdf->SetX($xstart+46);
		$pdf->MultiCell(31,5,"$".$this->Util()->CadenaOriginalPDFFormat($subtotalWithIva, true,false),"B","R",0);

		if($totales["descuento"] != 0)
		{
			$pdf->SetY($pdf->GetY());
			$pdf->SetX($xstart);
			$pdf->MultiCell(55,5,"Descuento","BR","R");
			$pdf->SetY($pdf->GetY()-3);
			$pdf->SetX($xstart+46);
			$pdf->SetTextColor(0,0,0);
			$pdf->MultiCell(31,5,"$".$this->Util()->CadenaOriginalPDFFormat($totales["descuento"], true,false),"B","R",0);
		}
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(55,5,$totales["tasaIva"]."% IVA","BR","R");
		$pdf->SetY($pdf->GetY()-5);
		$pdf->SetX($xstart+46);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,5,"$".$this->Util()->CadenaOriginalPDFFormat($totales["iva"], true,false),"B","R",0);
//print_r($totales);
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(55,5,"Total","R","R");
		$pdf->SetY($pdf->GetY()-5);
		$pdf->SetX($xstart+46);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,5,"$".$this->Util()->CadenaOriginalPDFFormat($totales["total2"], true,false),0,"R",0);

		$setY = $pdf->GetY() + 15;
		$pdf->Line(10,$setY+1,200,$setY+1);
		$pdf->Line(10,$setY+2,200,$setY+2);

		$xstart = 2;
		$pdf->SetX($xstart);
		$pdf->SetFillColor(255);
		$pdf->SetY($pdf->GetY()+3);
		$pdf->SetX($xstart);
		$pdf->MultiCell(207,3,utf8_decode("ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI\nEFECTOS FISCALES AL PAGO\nPAGO HECHO EN UNA SOLA EXHIBICION"),0,"C");

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
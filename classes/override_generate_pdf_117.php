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
			$pdf->Image($rootQr.$nufa,2,10, 25,25); 		
		}

		$nufa = $empresa["empresaId"]."_".$serie["serie"]."_".$data["folio"];
		
		$rfcActivo = $this->getRfcActive();
		$root = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/pdf/";
		$rootFacturas = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/";
		$rootQr = DOC_ROOT."/empresas/".$_SESSION["empresaId"]."/certificados/".$rfcActivo."/facturas/qr/";

		$pdf->Image($rootQr.$nufa.'.png',180,8, 28, 28);		


 		$pdf->SetTextColor(255, 255, 255);
		//block emisor
		$pdf->SetFillColor(30,30,30);
		$pdf->SetDrawColor(30,30,30);
		$pdf->Rect(30, 10, 20, 3, 'DF');

		$xstart = 35;
		$pdf->SetY(8);
		$pdf->SetX($xstart);
		$pdf->Cell(70,8,"Emisor",0);
 		$pdf->SetTextColor(0, 0, 0);

		$pdf->SetFont('verdana','',9);
		$xstart = 30;
		$pdf->SetY(14);
		$pdf->SetX($xstart);
		$pdf->MultiCell(140,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["razonSocial"])),0);
		$pdf->SetFont('verdana','',7);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(140,3,utf8_decode("Direccion: ".urldecode($data["nodoEmisor"]["rfc"]["calle"]." ".$data["nodoEmisor"]["rfc"]["noExt"]." ".$data["nodoEmisor"]["rfc"]["noInt"]." ".$data["nodoEmisor"]["rfc"]["colonia"])),0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(140,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["municipio"]." ".$data["nodoEmisor"]["rfc"]["estado"]." ".$data["nodoEmisor"]["rfc"]["pais"]." CP: ".$data["nodoEmisor"]["rfc"]["cp"])),0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(140,3,"RFC: ".$data["nodoEmisor"]["rfc"]["rfc"],0);


		if($data["nodoEmisor"]["sucursal"]["sucursalActiva"] == 'no'){
		
			$infoSucursal = urldecode($data["nodoEmisor"]["sucursal"]["identificador"]);
			$infoSucursal .= " ".urldecode("Direccion: ".$data["nodoEmisor"]["sucursal"]["calle"]." ".$data["nodoEmisor"]["sucursal"]["noExt"]." ".$data["nodoEmisor"]["sucursal"]["noInt"]);
			$infoSucursal .= " ".urldecode($data["nodoEmisor"]["sucursal"]["colonia"]);
			$infoSucursal .= "  ".urldecode($data["nodoEmisor"]["sucursal"]["municipio"]." ".$data["nodoEmisor"]["sucursal"]["estado"]." ".$data["nodoEmisor"]["sucursal"]["pais"]." \nCP: ".$data["nodoEmisor"]["sucursal"]["cp"]);

		}
		else
		{
			$infoSucursal = urldecode($data["nodoEmisor"]["sucursal"]["identificador"]);
		}

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(140,3,"Lugar de Expedicion: ".utf8_decode(urldecode($infoSucursal)),0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(140,3,"Regimen Fiscal: ".utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["regimenFiscal"])),0);

		$pdf->Line(10,$pdf->GetY()+3,200,$pdf->GetY()+3);
		$pdf->Line(10,$pdf->GetY()+4,200,$pdf->GetY()+4);

		//block receptor
		$pdf->SetFillColor(30,30,30);
		$pdf->Rect(2, 40, 25, 3, 'DF');
 		$pdf->SetTextColor(255, 255, 255);
		
		$pdf->SetFont('verdana','',7);
		
		$xstart = 2;
		$pdf->SetY(38);
		$pdf->SetX(6);
		$pdf->MultiCell(70,8,"Receptor",0);
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

		$pdf->Line(10,$pdf->GetY(),200,$pdf->GetY());
		$pdf->Line(10,$pdf->GetY() + 1,200,$pdf->GetY() + 1);

//$pdf->MultiCell(80,4,$infoReceptor,0);
				
		//block sucursal
		//block serie
		$pdf->SetY(38);
		$pdf->SetFillColor(30,30,30);
 		$pdf->SetTextColor(255, 255, 255);
		$pdf->Rect(112, 38, 25, 22, 'DF');
		$pdf->SetFillColor(255);

		$xstart = 113;
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
		$pdf->SetY(38);
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
		
		if($_SESSION["empresaId"] == 184)
		{
			//$data["fecha"] = "2014-03-31 23:29:52";
		}
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
		
		$setY = $pdf->GetY() + 5;
		$pdf->SetY($setY);

		$xstart = 2;
 		$pdf->SetTextColor(0,0,0);
		$pdf->SetFont('courier','',7);
		$pdf->SetY($pdf->GetY()+2);
		$pdf->SetX($xstart);
		foreach($nodosConceptos as $concepto)
		{
			$buenoPor = $concepto["importe"] + ($concepto["importe"] * $totales["iva"]);
		}
		
		//$pdf->Cell(205,8,"BUENO POR: $".$this->Util()->CadenaOriginalPDFFormat($buenoPor, true, false),0,0,"R");

		$setY = $pdf->GetY()+10;
		$pdf->SetY($setY);
 		$pdf->SetTextColor(0,0,0);
		
		//Table with 20 rows and 4 columns
//		$pdf->SetWidths(array(5,15, 15, 20, 106, 22, 22));
//		$pdf->SetAligns(array('L','L', 'L', 'L', 'L', 'R', 'R'));
		
		$xstart = 15;
		$count = 1;
		foreach($nodosConceptos as $concepto)
		{
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
					"VALOR UNITARIO:"."$".$this->Util()->CadenaOriginalPDFFormat($concepto["valorUnitario"], true,false), 
					"IMPORTE:"."$".$this->Util()->CadenaOriginalPDFFormat($concepto["importe"], true,false)
				),3
			);

			$xstart = 15;
			$pdf->SetWidths(array(2,205));
			$pdf->SetAligns(array('L', 'J'));

			$concepto["descripcion"] = str_replace("&quot;","\"", $concepto["descripcion"]);
			$concepto["descripcion"] = str_replace("[%]MAS[%]","+", $concepto["descripcion"]);
//			echo $concepto["descripcion"];
	    $pdf->Row(
				array(
					"",
					utf8_decode($concepto["descripcion"])
				),3
			);

		}
		
		$pdf->SetTextColor(0, 0, 0);

		$count = 1;
		if($_SESSION["impuestos"])
		{
			//Table with 20 rows and 4 columns
			$pdf->SetWidths(array(2, 153, 25, 25));
			$pdf->SetAligns(array('L','L', 'R'));
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
				if($impuesto["tipo"] == "deduccion")
				{
					$existImpuesto++;
				}
			}
			
			if($existImpuesto > 0)
			{

				$setY = $pdf->GetY();
				$pdf->SetX(2);
				$pdf->Cell(40,8,"MENOS DEDUCCIONES",0,0,"L");
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
							$impuesto["impuesto"] = str_replace("16%", "", $impuesto["impuesto"]);
						}
						
						$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
						$pdf->Row(
							array(
								"",
								$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
								"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
							),3
						);
					}
			}//foreach
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', 'T'));
					$pdf->Row(
						array(
							"",
							"", 
							"",
							"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
							 
						),3
					);
			}//if
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
				$pdf->Cell(40,8,"MENOS RETENCIONES",0,0,"L");
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
							$impuesto["impuesto"] = str_replace("16%", "", $impuesto["impuesto"]);
						}
						
						$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
						$pdf->Row(
							array(
								"",
								$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
								"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
							),3
						);
					}
			}//foreach
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', 'T'));
					$pdf->Row(
						array(
							"",
							"", 
							"",
							"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
							 
						),3
					);
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
				$pdf->Cell(40,8,"MENOS IMPUESTOS",0,0,"L");
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
							$impuesto["impuesto"] = str_replace("16%", "", $impuesto["impuesto"]);
						}
						
						$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
						$pdf->Row(
							array(
								"",
								$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
								"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
							),3
						);
					}
			}//foreach
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', 'T'));
					$pdf->Row(
						array(
							"",
							"", 
							"",
							"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
							 
						),3
					);
			}//if
			
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
				$pdf->Cell(40,8,"MENOS AMORTIZACIONES",0,0,"L");
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
							$impuesto["impuesto"] = str_replace("16%", "", $impuesto["impuesto"]);
						}
						
						$nb = $pdf->WordWrap($impuesto["impuesto"], 80);
						$pdf->Row(
							array(
								"",
								$this->Util()->CadenaOriginalVariableFormat($impuesto["impuesto"],false,false), 
								"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"] * count($_SESSION["conceptos"]), true, false) 
							),3
						);
					}
			}//foreach
				$pdf->SetAligns(array('L','L', 'R', 'R'));
				$pdf->SetBorders(array('0','0', '0', 'T'));
					$pdf->Row(
						array(
							"",
							"", 
							"",
							"$".$this->Util()->CadenaOriginalPDFFormat($suma, true, false) 
							 
						),3
					);
			}//if
			
		//check page break
//		$pdf->CheckPageBreak(50);
		}

			$pdf->SetWidths(array(2, 153, 25, 25));
			$pdf->SetAligns(array('L','R', 'R', 'R'));
			$pdf->SetBorders(array('0','0', '0', 'T'));
				$pdf->Row(
					array(
						"",
						"ALCANCE LIQUIDO =", 
						"",
						"$".$this->Util()->CadenaOriginalPDFFormat($totales["total"], true, false) 
						 
					),3
				);

		$setY = $pdf->GetY() + 3;
		$pdf->Line(10,$setY,200,$setY);
		$pdf->Line(10,$setY+1,200,$setY+1);
		$pdf->SetFont('verdana','',7);

		//block con letra
		$pdf->SetFillColor(30,30,30);
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
				
		$y = $pdf->GetY()+3;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
//echo $data["formaDePago"];
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(25,3,"Forma De Pago",0);
		$pdf->SetY($y);
		$pdf->SetX(25);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(120,3,$this->Util()->DecodeVal($data["formaDePago"]."\nMetodo de Pago: ".$data["metodoDePago"]." ".$data["metodoDePagoLetra"].". ".$add),0);


		//block totales
		$pdf->SetFillColor(30,30,30);
		$pdf->Rect(155, $setY+2, 20, 24, 'DF');

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
		$pdf->Line(10,$setY+1,200,$setY+1);
		$pdf->Line(10,$setY+2,200,$setY+2);

		//observaciones
		$pdf->SetY($setY + 2);
		$pdf->SetFont('courier','',7);
		$pdf->SetWidths(array(210));
		//$data["observaciones"] = substr(str_replace(array("\r", "\r\n", "\n"), "", $data["observaciones"]), 0, 173);
		//$nb = $pdf->WordWrap($data["observaciones"], 180);
	    $pdf->Row(
				array( utf8_decode(urldecode($data["observaciones"]))), 3
			);
		$pdf->SetFont('courier','',7);
		//$pdf->CheckPageBreak(50);

		$pdf->SetY($pdf->GetY()+5);
		$pdf->SetX($xstart);
		$xstart = 2;
		$pdf->SetX($xstart);

		$pdf->SetFillColor(255);

		$y = $pdf->GetY();
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
		$pdf->SetY($pdf->GetY()+20);
		$pdf->SetX($xstart);
		$pdf->MultiCell(207,3,utf8_decode("ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI"),0,"C");

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
<?php

class Override extends Comprobante
{
	function GeneratePDF($data, $serie, $totales, $nodoEmisor, $nodoReceptor, $nodosConceptos,$empresa, $cancelado = 0, $vistaPrevia = 0)
	{
		$this->GenerateQR($data, $totales, $nodoEmisor, $nodoReceptor, $empresa, $serie);		
		
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

		$pdf->SetFont('verdana','',7);
		$xstart = 30;
		$pdf->SetY(14);
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["razonSocial"])),0);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,utf8_decode("Direccion: ".urldecode($data["nodoEmisor"]["rfc"]["calle"]." ".$data["nodoEmisor"]["rfc"]["noExt"]." ".$data["nodoEmisor"]["rfc"]["noInt"]." ".$data["nodoEmisor"]["rfc"]["colonia"])),0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$data["nodoEmisor"]["rfc"]["cp"] = str_pad($data["nodoEmisor"]["rfc"]["cp"], 5, "0", STR_PAD_LEFT);
		$pdf->MultiCell(80,3,utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["municipio"]." ".$data["nodoEmisor"]["rfc"]["estado"]." ".$data["nodoEmisor"]["rfc"]["pais"]." CP: ".$data["nodoEmisor"]["rfc"]["cp"])),0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,"RFC: ".$data["nodoEmisor"]["rfc"]["rfc"],0);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,"Regimen Fiscal: ".utf8_decode(urldecode($data["nodoEmisor"]["rfc"]["regimenFiscal"])),0);
		
		$infoSucursal = urldecode($data["nodoEmisor"]["sucursal"]["identificador"]);
		$infoSucursal .= " ".urldecode("Direccion: ".$data["nodoEmisor"]["sucursal"]["calle"]." ".$data["nodoEmisor"]["sucursal"]["noExt"]." ".$data["nodoEmisor"]["sucursal"]["noInt"]);
		$infoSucursal .= " ".urldecode($data["nodoEmisor"]["sucursal"]["colonia"]);
		$infoSucursal .= " ".urldecode($data["nodoEmisor"]["sucursal"]["municipio"]." ".$data["nodoEmisor"]["sucursal"]["estado"]." ".$data["nodoEmisor"]["sucursal"]["pais"]." CP: ".$data["nodoEmisor"]["sucursal"]["cp"]);

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(80,3,"Lugar de Expedicion: ".utf8_decode(urldecode($infoSucursal)),0);


		//block serie
		$pdf->SetFillColor(30,30,30);
 		$pdf->SetTextColor(255, 255, 255);
		$pdf->Rect(112, 10, 25, 22, 'DF');
		$pdf->SetFillColor(255);

		$xstart = 113;
		$pdf->SetY(11);
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
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"# Certificado SAT",0);
		

		$xstart = 138;
		$pdf->SetY(10);
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

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(43,3,$data["timbreFiscal"]["noCertificadoSAT"],0,0,'R');

		$pdf->SetY(35);

		//block receptor
		$pdf->SetFillColor(30,30,30);
		$pdf->Rect(2, 40, 30, 3, 'DF');
 		$pdf->SetTextColor(255, 255, 255);
		
		$pdf->SetFont('verdana','',7);
		
		$xstart = 2;
		$pdf->SetY(38);
		$pdf->SetX(6);
		$pdf->MultiCell(70,8,"Datos del Empleado",0);
 		$pdf->SetTextColor(0,0,0);
		
		$data["nodoReceptor"]["nombre"] = urlencode($data["nodoReceptor"]["nombre"]);
		
		$infoReceptor = utf8_decode(urldecode($this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["nombre"], false, false)));
		
		if($_SESSION["empresaId"] != 317)
		{
			$infoReceptor .= "\n".utf8_decode(urldecode("DIRECCION: ".$data["nodoReceptor"]["calle"]." ".$data["nodoReceptor"]["noExt"]." ".$data["nodoReceptor"]["noInt"]));
			$infoReceptor .= "\nCOLONIA ".utf8_decode(urldecode($data["nodoReceptor"]["colonia"]));
			$infoReceptor .= "\n".utf8_decode(urldecode($data["nodoReceptor"]["municipio"]." ".$data["nodoReceptor"]["estado"]." ".$data["nodoReceptor"]["pais"]." CP: ".$data["nodoReceptor"]["cp"]));
		}
		
		$main = new Main();
		$regimen = $main->Regimenes($data["nodoReceptor"]["tipoRegimen"]);
		//print_r($regimen);
		
		$infoReceptor .= "\n".utf8_decode(urldecode("REGIMEN: ".$regimen["nombreRegimen"]));
						
		$infoReceptor .= "\n".urldecode("RFC: ".$this->Util()->CadenaOriginalVariableFormat($data["nodoReceptor"]["rfc"],false,false));
				
		$xstart = 2;
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);


		$pdf->SetFont('verdana','',7);
		$pdf->SetWidths(array(85));
		
		$nb = $pdf->WordWrap($infoReceptor, 85);
	    $pdf->Row(
				array( $infoReceptor), 3
			);
			
		$pdf->SetFont('verdana','',7);
		
					
		//$pdf->SetFillColor(255,255,255);
		//$pdf->Rect(105, 40, 35, 3, 'DF');
		$pdf->SetTextColor(255, 255, 255);

		$xstart = 80;
		$pdf->SetY(38);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,8,"",0);
		$pdf->SetTextColor(0,0,0);
		
		//bloque
		$xstart = 80;
		$pdf->SetY(43);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Registro Patronal:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY(43);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["registroPatronal"],0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY(43);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"# Empleado:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY(43);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["numEmpleado"],0);
		$pdf->SetTextColor(0,0,0);


		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"CURP:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["curp"],0);
		$pdf->SetTextColor(0,0,0);

/*		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Tipo de Regimen:",0);
		$pdf->SetTextColor(0,0,0);
		echo "jere";
		print_r($data["nodoReceptor"]);
		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["tipoDeRegimen"],0);
		$pdf->SetTextColor(0,0,0);*/
		
		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"# Seguro Social:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["numSeguridadSocial"],0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Fecha de Pago:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["fechaPago"],0);
		$pdf->SetTextColor(0,0,0);
		
		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Fecha Inicial del Pago:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,urldecode($data["periodoDePagoInicial"]),0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Fecha final del Pago:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,urldecode($data["periodoDePagoFinal"]),0);
		$pdf->SetTextColor(0,0,0);


		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"# Dias Pagados:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["numDiasPagados"],0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Departamento:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["departamento"],0);
		$pdf->SetTextColor(0,0,0);		

		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Banco:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["banco"],0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Fecha Ini. Rel. Lab:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,urldecode($data["nodoReceptor"]["fechaInicioRelLaboral"]),0);
		$pdf->SetTextColor(0,0,0);		

		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Antiguedad:",0);
		$pdf->SetTextColor(0,0,0);

		//calcular semanas
		$diff = time() - strtotime($data["nodoReceptor"]["fechaInicioRelLaboral"]);
		$weeks = floor($diff / 60 / 60 / 24 / 7);
		
		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$weeks." Semanas",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Puesto:",0);
		$pdf->SetTextColor(0,0,0);
		
		if(strlen($data["nodoReceptor"]["puesto"]) > 12)
		{
			$pdf->SetFont('verdana','',5);
		}
		
		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["puesto"],0);
		$pdf->SetTextColor(0,0,0);		

		$pdf->SetFont('verdana','',7);
		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Tipo de Contrato:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["tipoContrato"],0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Tipo Jornada:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["tipoJornada"],0);
		$pdf->SetTextColor(0,0,0);		

		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Periodicidad del Pago:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["periodicidadPago"],0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Salario Base Cot:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["salarioDiarioIntegrado"],0);
		$pdf->SetTextColor(0,0,0);		
		
		//bloque
		$xstart = 80;
		$y = $pdf->GetY();
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Riesgo Puesto:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 110;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["riesgoPuesto"],0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 145;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,"Salario Diario:",0);
		$pdf->SetTextColor(0,0,0);

		$xstart = 175;
		$pdf->SetY($y);
		$pdf->SetX($xstart);
		$pdf->MultiCell(70,3,$data["nodoReceptor"]["salarioBaseCotApor"],0);
		$pdf->SetTextColor(0,0,0);		

		
						
		$setY = $pdf->GetY() + 5;
		$pdf->SetY($setY);

		//Observaciones
		$pdf->SetY($pdf->GetY() + 2);
		$pdf->SetFont('courier','',7);
		$pdf->SetWidths(array(210));
	    $pdf->Row(
				array( utf8_decode(urldecode($data["observaciones"]))), 3
			);
		$pdf->SetFont('verdana','',7);
		
		//Block conceptos
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
		
		$totalOtrosPagos = 0;
		foreach($_SESSION["otrosPagos"] as $key => $value)
		{
			$totalOtrosPagos += $value["importe"];
		}

		foreach($nodosConceptos as $concepto)
		{
			$pdf->SetTextColor(0, 0, 0);

			$count++;
			$concepto["descripcion"] = str_replace("&quot;", "\"", $concepto["descripcion"]);
			$concepto["descripcion"] = str_replace("&#039;", "'", $concepto["descripcion"]);		
			
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
		$count = 1;
		if($_SESSION["percepciones"])
		{
			$setY = $pdf->GetY();
			$pdf->SetX($xstart);
			$pdf->SetFont('courier','B',7);
			$pdf->Cell(10,8,"PERCEPCIONES",0,0,"C");
			$pdf->Ln();
			$pdf->SetTextColor(0, 0, 0);
	
			//Table with 20 rows and 4 columns
			$pdf->SetWidths(array(20, 120, 22, 22, 22));
			$pdf->SetAligns(array('L', 'L', 'R', 'R', 'R'));
			$pdf->SetBorders(array('1', '1', '1', '1', '1'));
			
			$xstart = 15;

			$pdf->SetTextColor(0, 0, 0);
			$count++;

				$pdf->Row(
					array(
						"\nCLAVE\n",
						"\nNOMBRE\n",
						"IMPORTE GRAVADO",
						"IMPORTE EXENTO",
						"\nTOTAL\n"
					),3
				);
			
			$pdf->SetFont('courier','',7);
			$totalPercepciones = 0;
			foreach($_SESSION["percepciones"] as $impuesto)
			{
				$totalPercepciones += $impuesto["total"];
				$nb = $pdf->WordWrap($impuesto["nombrePercepcion"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						$this->Util()->CadenaOriginalVariableFormat(ucfirst($impuesto["tipoPercepcion"]),false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["nombrePercepcion"],false,false),
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importeGravado"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importeExcento"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["total"], true, false), 
					),3
				);
	
			}//foreach
		}
		
		if($_SESSION["otrosPagos"])
		{
			$setY = $pdf->GetY();
			$pdf->SetX($xstart);
			$pdf->SetFont('courier','B',7);
			$pdf->Cell(10,8,"OTROS PAGOS",0,0,"C");
			$pdf->Ln();
			$pdf->SetTextColor(0, 0, 0);
	
			//Table with 20 rows and 4 columns
			$pdf->SetWidths(array(20, 120, 22, 22, 22));
			$pdf->SetAligns(array('L', 'L', 'R','R', 'R'));
			$pdf->SetBorders(array('1', '1', '1','1', '1'));
			
			$xstart = 15;

			$pdf->SetTextColor(0, 0, 0);
			$count++;

				$pdf->Row(
					array(
						"\nCLAVE\n",
						"\nNOMBRE\n",
						"\n\n",
						"\nIMPORTE\n",
						"\nTOTAL\n"
					),3
				);
			
			$pdf->SetFont('courier','',7);
			$totalOtrosPagos = 0;
			foreach($_SESSION["otrosPagos"] as $impuesto)
			{
				$totalOtrosPagos += $impuesto["total"];
				$nb = $pdf->WordWrap($impuesto["nombreOtroPago"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						$this->Util()->CadenaOriginalVariableFormat(ucfirst($impuesto["tipoOtroPago"]),false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["nombreOtroPago"],false,false),
						$this->Util()->CadenaOriginalVariableFormat("",false,false),
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importe"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["total"], true, false), 
					),3
				);
	
			}//foreach
		}		
		
		$count = 1;
		if($_SESSION["deducciones"])
		{
			$setY = $pdf->GetY();
			$pdf->SetX($xstart);
			$pdf->SetFont('courier','B',7);
			$pdf->Cell(10,8,"DEDUCCIONES",0,0,"C");
			$pdf->Ln();
			$pdf->SetTextColor(0, 0, 0);
	
			//Table with 20 rows and 4 columns
			$pdf->SetWidths(array(20, 120, 22, 22, 22));
			$pdf->SetAligns(array('L', 'L', 'R', 'R', 'R'));
			$pdf->SetBorders(array('1', '1', '1', '1', '1'));
			
			$xstart = 15;

			$pdf->SetTextColor(0, 0, 0);
			$count++;

				$pdf->Row(
					array(
						"\nCLAVE\n",
						"\nNOMBRE\n",
						"IMPORTE GRAVADO",
						"IMPORTE EXENTO",
						"\nTOTAL\n"
					),3
				);
			
			$pdf->SetFont('courier','',7);
			$totalDeducciones = 0;
			$totalIsr = 0;
			foreach($_SESSION["deducciones"] as $impuesto)
			{
				if($impuesto["tipoDeduccion"] != "002")
				{
					$totalDeducciones += $impuesto["total"];
				}
				else
				{
					$totalIsr += $impuesto["total"];
				}
				$nb = $pdf->WordWrap($impuesto["nombreDeduccion"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						$this->Util()->CadenaOriginalVariableFormat(ucfirst($impuesto["tipoDeduccion"]),false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["nombreDeduccion"],false,false),
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importeGravado"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importeExcento"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["total"], true, false), 
					),3
				);
	
			}//foreach
		}		

		$count = 1;
		if($_SESSION["incapacidades"])
		{
			$setY = $pdf->GetY();
			$pdf->SetX($xstart);
			$pdf->SetFont('courier','B',7);
			$pdf->Cell(10,8,"INCAPACIDADES",0,0,"C");
			$pdf->Ln();
			$pdf->SetTextColor(0, 0, 0);
	
			//Table with 20 rows and 4 columns
			$pdf->SetWidths(array(20, 120, 22, 22, 22));
			$pdf->SetAligns(array('L', 'L', 'R', 'R', 'R'));
			$pdf->SetBorders(array('1', '1', '1', '1', '1'));
			
			$xstart = 15;

			$pdf->SetTextColor(0, 0, 0);
			$count++;

				$pdf->Row(
					array(
						"\nCLAVE\n",
						"\nNOMBRE\n",
						"DIAS INCAPACIDAD",
						"\nDESCUENTO\n",
						"\nTOTAL\n"
					),3
				);
			
			$pdf->SetFont('courier','',7);
			$incapacidades = 0;
			foreach($_SESSION["incapacidades"] as $impuesto)
			{
				$incapacidades += $impuesto["total"];
				$nb = $pdf->WordWrap($impuesto["nombreIncapacidad"], 80);
				$xstart = 15;
				$pdf->Row(
					array(
						$this->Util()->CadenaOriginalVariableFormat(ucfirst($impuesto["tipoIncapacidad"]),false,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["nombreIncapacidad"],false,false),
						$this->Util()->CadenaOriginalPDFFormat($impuesto["diasIncapacidad"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["descuento"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["total"], true, false), 
					),3
				);
	
			}//foreach
		}		
		
		$count = 1;
		if($_SESSION["horasExtras"])
		{
			$setY = $pdf->GetY();
			$pdf->SetX($xstart);
			$pdf->SetFont('courier','B',7);
			$pdf->Cell(10,8,"HORAS EXTRA",0,0,"C");
			$pdf->Ln();
			$pdf->SetTextColor(0, 0, 0);
	
			//Table with 20 rows and 4 columns
			$pdf->SetWidths(array(20, 120, 22, 22, 22));
			$pdf->SetAligns(array('L', 'L', 'R', 'R', 'R'));
			$pdf->SetBorders(array('1', '1', '1', '1', '1'));
			
			$xstart = 15;

			$pdf->SetTextColor(0, 0, 0);
			$count++;

				$pdf->Row(
					array(
						"\nDIAS\n",
						"\nTIPO HORAS\n",
						"\nHORAS\n",
						"IMPORTE PAGADO",
						"\nTOTAL\n"
					),3
				);
			
			$pdf->SetFont('courier','',7);
			$horasExtra = 0;
			foreach($_SESSION["horasExtras"] as $impuesto)
			{
				$horasExtra += $impuesto["total"];
				$xstart = 15;
				$pdf->Row(
					array(
						$this->Util()->CadenaOriginalPDFFormat($impuesto["dias"],true,false),
						$this->Util()->CadenaOriginalVariableFormat($impuesto["tipoHoras"],false,false),
						$this->Util()->CadenaOriginalPDFFormat($impuesto["horasExtra"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["importePagado"], true, false), 
						"$".$this->Util()->CadenaOriginalPDFFormat($impuesto["total"], true, false), 
					),3
				);
	
			}//foreach
		}		
		
		$setY = $pdf->GetY() + 3;
		$pdf->Line(10,$setY,200,$setY);
		$pdf->Line(10,$setY+1,200,$setY+1);

		//block con letra
		$pdf->SetFillColor(30,30,30);
		$pdf->Rect(2, $setY+2, 22, 13, 'DF');
		$pdf->SetTextColor(255, 255, 255);

		$xstart = 3;
		$pdf->SetY($setY+3);
		$pdf->SetX($xstart);
		$pdf->SetFont('verdana','',7);
		$pdf->MultiCell(25,3,"Total Con letra",0);
		$totales["total"] = $totales["total"];
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

		$cantidadLetra = $this->Util()->num2letras($totales["total"], false);
		
		//Tipo de cambio
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

		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(25,3,"Tipo De Pago",0);
		$pdf->SetY($y);
		$pdf->SetX(25);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(120,3,$this->Util()->DecodeVal($data["formaDePago"]."\nMetodo de Pago: ".$data["metodoDePago"]." ".$data["metodoDePagoLetra"].". ".$add),0);


		//block totales
		$pdf->SetFillColor(30,30,30);
		$pdf->Rect(155, $setY+2, 20, 20, 'DF');

		//$pdf->SetFillColor(255);
		$pdf->SetTextColor(255, 255, 255);

		echo $totalPercepciones;
		echo " ";
		echo $totalDeducciones;
		echo " ";
		echo $incapacidades;
		echo " ";
		echo $horasExtra;
		echo " ";
		
		$antesDescuento = $totalPercepciones + $horasExtra + $totalOtrosPagos;
		$subtotal = $antesDescuento - $totalDeducciones - $incapacidades;
		$xstart = 155;
		$pdf->SetY($setY+2);
		$pdf->SetX($xstart);
		$pdf->MultiCell(20,3,"Antes de Descuento",0,"C",0);
		$pdf->SetY($pdf->GetY()-3);
		$pdf->SetX($xstart+20);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($antesDescuento, true,false),0,"R",0);
		
		//calcular descuento

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(20,3,"Descuento",0,"C");
		$pdf->SetY($pdf->GetY()-3);
		$pdf->SetX($xstart+20);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totalDeducciones + $incapacidades, true,false),0,"R",0);
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(20,3,"Subtotal",0,"C");
		$pdf->SetY($pdf->GetY()-3);
		$pdf->SetX($xstart+20);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($subtotal, true,false),0,"R",0); 

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->MultiCell(20,3,"Ret Isr",0,"C");
		$pdf->SetY($pdf->GetY()-3);
		$pdf->SetX($xstart+20);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(31,3,"$".$this->Util()->CadenaOriginalPDFFormat($totalIsr, true,false),0,"R",0);
		
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

		$pdf->SetY($pdf->GetY()+10);
		$pdf->SetX($xstart);
		$xstart = 2;
		$pdf->SetX($xstart);

		$pdf->SetFillColor(255);

		$xstart = 2;
		$pdf->SetY($pdf->GetY()+20);
		$pdf->SetX($xstart);
		$pdf->MultiCell(207,3,utf8_decode("ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI"),0,"C");

		$pdf->SetY($pdf->GetY());
		
		$pdf->SetFont('verdana','',5);
		$pdf->SetFillColor(255,255,255);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->MultiCell(207,3,"Sello Emisor: ".$data["sello"],0,"L",1);

		$pdf->MultiCell(207,3,"Sello SAT: ".$data["timbreFiscal"]["selloSAT"],0,"L",1);

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
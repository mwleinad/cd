<?php

		$fondo = DOC_ROOT."/images/header_176.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 9, 178,26); 		
		}
		else
		{
		//block emisor
		$pdf->SetFillColor(30,30,30);
		$pdf->SetDrawColor(30,30,30);
		$pdf->Rect(30, 10, 20, 3, 'DF');
 		$pdf->SetTextColor(255, 255, 255);

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
			
		}
	
?>
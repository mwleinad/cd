<?php

		$fondo = DOC_ROOT."/images/fondo_252.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 9, 175,27); 		
		}
		else
		{

/* 		$pdf->SetTextColor(58, 87, 145);
		
		$pdf->SetY(30);
		
		$pdf->SetFont('arial','',16);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX(130);
		$pdf->MultiCell(60,3,"S. A. de C. V.",0, "C");

		$xstart = 2;
		$pdf->SetY(28);
		$pdf->SetFont('arial','',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(120,3,"R. F. C. CSC111026LE8",0, "C");
		
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(120,3,utf8_decode("Andador Pilar No. 490 Manzana 63 Interior B"),0, "C");

		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(120,3,utf8_decode("Col. San Jose Chapultepec I C.P 29027 Tuxtla Gutierrez, Chiapas."),0, "C");
*/
		}
	
?>
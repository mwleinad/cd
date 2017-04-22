<?php

		$xstart = 35;
		$pdf->SetY(8);
		$pdf->SetX($xstart);
		$xstart = 30;
		$pdf->SetY(8);
		$pdf->SetX($xstart);

		$pdf->SetFont('arial','B',16);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,5,utf8_decode("INGENIEROS CIVILES"),0, "C");

		$pdf->SetFont('arial','B',16);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,5,utf8_decode("RAMIREZ & DOMINGUEZ S.A DE C.V"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY()+8);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,"7a pte sur No. 612-B Colonia Centro. Tuxtla Gutierrez, Chiapas. CP 29000",0, "C");
		
		$pdf->SetFont('arial','',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("Oficina: 961 212 1389 - Celular 961 177 3529"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("RFC: ICR1101125E0 - IMSS: A6843662102"),0, "C");


	
?>
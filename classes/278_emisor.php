<?php

		$xstart = 35;
		$pdf->SetY(8);
		$pdf->SetX($xstart);
		$xstart = 30;
		$pdf->SetY(8);
		$pdf->SetX($xstart);

		$pdf->SetFont('arial','B',22);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,5,utf8_decode("LEOS HOTEL"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY()+2);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,5,utf8_decode("OSMAR AGUSTIN JUAN LEY"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY()+1);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,"CENTRAL SUR 72, COL. CENTRO. CINTALAPA, CHIAPAS, MEXICO CP 30400",0, "C");
		
		$pdf->SetFont('arial','',8);
		$pdf->SetY($pdf->GetY() + 1);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("TELEFONO: (968) 68 421 92 - FAX (968) 68 4 40 94"),0, "C");

		$pdf->SetFont('arial','',8);
		$pdf->SetY($pdf->GetY() + 1);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("LEOS_HOTEL@HOTMAIL.COM, HOTEL_LEOS@HOTMAIL.COM, HOTELLEOS@HOTMAIL.COM"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY() + 2);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("RFC: JULO6208279W4"),0, "C");


	
?>
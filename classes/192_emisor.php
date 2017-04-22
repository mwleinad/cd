<?php

		$xstart = 35;
		$pdf->SetY(8);
		$pdf->SetX($xstart);
		$xstart = 30;
		$pdf->SetY(8);
		$pdf->SetX($xstart);

		$pdf->SetFont('arial','B',16);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,5,utf8_decode("CONSTRUCCIONES Y ACABADOS EN GENERAL"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,4,utf8_decode("Venta de Materiales para Contrucción, Acarreo de Material y Renta de Maquinaria Pesada"),0, "C");

		$pdf->SetFont('arial','B',11);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,4,utf8_decode("Silvia Gutiérrez Rios"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,4,"R. F. C. GURS690612PC8",0, "C");
		
		$pdf->SetFont('arial','',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,4,utf8_decode("REGIMEN: PERSONA FISICA CON ACTIVIDAD EMPRESARIAL DEL REGIMEN INTERMEDIO"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("CALLE 4 PONIENTE NORTE NO. 227 COLONIA TERAN. TUXTLA GUTIERREZ, CHIS. C.P. 29050"),0, "C");

		$pdf->SetFont('arial','B',6);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("FALSO PLAFON, TEXTURIZADOS, IMPERMEABILIZACIONES, PINTURA EN GENERAL, PLOMERIA, HERRERIA, ELECTRICIDAD Y AIRES ACONDICIONADOS"),0, "C");

	
?>
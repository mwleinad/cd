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
		$pdf->MultiCell(150,4,utf8_decode("VENTA DE MATERIALES PARA CONTRUCCION , ACARREO DE PERSONAL Y MATERIALES DE CONTRUCCION, SUMINISTRO DE ALIMENTOS Y RENTA DE MAQUINARIA PESADA"),0, "C");

		$pdf->SetFont('arial','B',11);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,4,utf8_decode("C. P. MARTHA MARIA RAMIREZ SANTANDER"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,"R. F. C. RASM771222V95 CURP: RASM771222MVZMNR09",0, "C");
		
		$pdf->SetFont('arial','',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("REGIMEN: PERSONA FISICA CON ACTIVIDAD EMPRESARIAL DEL REGIMEN INTERMEDIO"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("4 CALLE PONIENTE NORTE NO. 227 COL. TERAN TUXTLA GUTIERREZ, CHIAPAS. C.P. 29050"),0, "C");

		$pdf->SetFont('arial','B',6);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("FALSO PLAFON, TEXTURIZADOS, IMPERMEABILIZACIONES, PINTURA EN GENERAL, PLOMERIA, HERRERIA Y ELECTRICIDAD"),0, "C");

	
?>
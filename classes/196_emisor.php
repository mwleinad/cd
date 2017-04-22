<?php

		$xstart = 35;
		$pdf->SetY(8);
		$pdf->SetX($xstart);
		$xstart = 30;
		$pdf->SetY(8);
		$pdf->SetX($xstart);

		$pdf->SetFont('arial','B',16);
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,5,utf8_decode("ERNESTO GUTIERREZ VELAZQUEZ"),0, "C");

		$pdf->SetFont('arial','B',12);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,5,utf8_decode("CONTRATISTA"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,4,"R. F. C. GUVE421101C51",0, "C");
		
		$pdf->SetFont('arial','',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("REGIMEN: PERSONA FISICA CON ACTIVIDAD EMPRESARIAL DEL REGIMEN INTERMEDIO"),0, "C");

		$pdf->SetFont('arial','B',8);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("TRABAJOS DE ALBAÑILERIA, OTROS TRABAJOS DE ACABADOS EN EDIFICIOS, FABRICACION DE PRODUCTOS DE HERRERIA, INSTALACIONES HIDROSANITARIAS Y DE GAS EN CONSTRUCCIONES, INSATALACIONES ELECTRICAS EN CONSTRUCCIONES Y ACABADOS EN URBANIZACIONES"),0, "C");

		$pdf->SetFont('arial','B',6);
		$pdf->SetY($pdf->GetY());
		$pdf->SetX($xstart);
		$pdf->MultiCell(150,3,utf8_decode("CALLE 4 PONIENTE NORTE NO. 227 COLONIA TERAN. TUXTLA GUTIERREZ, CHIS. C.P. 29050 CEL: 961 603 65 20"),0, "C");

	
?>
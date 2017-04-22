<?php

		$fondo = DOC_ROOT."/images/fondo_220.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 7, 175,31); 		
		}

 		$pdf->SetTextColor(58, 87, 145);
		
		$pdf->SetY(30);
		
	
?>
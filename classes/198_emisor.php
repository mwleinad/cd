<?php

		$fondo = DOC_ROOT."/images/fondo_198.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 6, 180,32); 		
		}

 		$pdf->SetTextColor(58, 87, 145);
		
		$pdf->SetY(30);
		
	
?>
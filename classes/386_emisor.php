<?php

		$fondo = DOC_ROOT."/images/fondo_386.jpg";
		$fondo2 = DOC_ROOT."/images/header_386.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 9, 175,25); 		
			$pdf->Image($fondo2,50, 90, 100,100); 		
		}
		else
		{
		}
	
?>
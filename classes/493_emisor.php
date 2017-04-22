<?php

		$fondo = DOC_ROOT."/images/header_493.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 9, 178,26); 		
		}
		else
		{
		}
	
?>
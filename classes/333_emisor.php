<?php

		$fondo = DOC_ROOT."/images/header_333.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 9, 175,28); 		
		}
		else
		{
		}
	
?>
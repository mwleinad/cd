<?php

		$fondo = DOC_ROOT."/images/fondo_249.jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 9, 175,30); 		
		}
		else
		{
		}
	
?>
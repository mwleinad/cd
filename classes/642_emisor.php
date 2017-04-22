<?php

		$fondo = DOC_ROOT."/images/header_".$_SESSION["empresaId"].".jpg";
	
		if(file_exists($fondo))
		{
			$pdf->Image($fondo,2, 9, 175,25); 		
		}

	
?>
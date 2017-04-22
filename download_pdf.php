<?php
		
	$archivo = $_GET['archivo'];
	$nomPdf = $_GET['nomPdf'];
	
	header ("Content-Disposition: attachment; filename=".$nomPdf."\n\n"); 
	header ("Content-Type: text/pdf"); 		
	readfile($archivo); 
		
?>
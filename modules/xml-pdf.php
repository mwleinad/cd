<?php

	$user->AuthAdmin();
	
	switch($_POST['accion']){
		
		case 'convertir':
								
				$tmp_archivo = $_FILES['xml']['tmp_name']; 
				$nombre_archivo = $_FILES['xml']['name']; 
				$file = pathinfo($nombre_archivo);
				$ext = $file['extension'];
				$ruta_destino = $ruta_dir.'/'.$nombre_archivo;	
				
			break;
		
	}

?>
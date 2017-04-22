<?php

	//$user->AuthAdmin();
	
	switch($_POST['accion']){
		
		case 'convertir':
				$cancelacion = $comprobante->CancelarComprobanteMantenimiento($data, $_POST["idComprobante"], $notaCredito = false, $recipient);
				exit;
			break;
		
	}

?>
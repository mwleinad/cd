<?php
	$meses = array();
	for($mes = 0 ; $mes<13; $mes++) {
		$texto = ($mes == 0)?"Todos":$util->ConvertirMes($mes);
		$meses[$mes]['id'] = $mes;
		$meses[$mes]['nombre'] = ucfirst($texto);
	}
	
	$anioActual = date(Y);
	$smarty->assign("meses",$meses);
	$smarty->assign("anioActual",$anioActual);
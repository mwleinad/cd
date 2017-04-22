function ShowTab(tab){
	$("Facturase").style.display = 'none';
	$("Actualizaciones").style.display = 'none';
	$("Soporte").style.display = 'none';
	
	$("tabFacturase").removeClassName('activo');
	$("tabActualizaciones").removeClassName('activo');
	$("tabSoporte").removeClassName('activo');
	
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


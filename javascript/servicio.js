function ShowTab(tab){
	$("Facturase").style.display = 'none';
	$("Caracteristicas").style.display = 'none';
	$("Ventajas").style.display = 'none';
	
	$("tabFacturase").removeClassName('activo');
	$("tabCaracteristicas").removeClassName('activo');
	$("tabVentajas").removeClassName('activo');
		
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


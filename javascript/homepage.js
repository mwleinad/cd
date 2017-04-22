function ShowTab(tab){
	$("Sistemas").style.display = 'none';
	$("Caracteristicas").style.display = 'none';
	$("Folios").style.display = 'none';
	$("Esquema").style.display = 'none';
	$("Adendas").style.display = 'none';
	
	$("tabSistemas").removeClassName('activo');
	$("tabCaracteristicas").removeClassName('activo');
	$("tabFolios").removeClassName('activo');
	$("tabEsquema").removeClassName('activo');
	$("tabAdendas").removeClassName('activo');
		
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


function ShowTab(tab){
	$("Aviso").style.display = 'none';
	$("Anexo1").style.display = 'none';
	$("Anexo2").style.display = 'none';
	$("Anexo3").style.display = 'none';
	
	$("tabAviso").removeClassName('activo');
	$("tabAnexo1").removeClassName('activo');
	$("tabAnexo2").removeClassName('activo');
	$("tabAnexo3").removeClassName('activo');
	
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


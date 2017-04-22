function ShowTab(tab){
	$("Pac").style.display = 'none';
	$("InfoSat").style.display = 'none';
	$("Presentacion").style.display = 'none';
	
	$("tabPac").removeClassName('activo');
	$("tabInfoSat").removeClassName('activo');
	$("tabPresentacion").removeClassName('activo');
		
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


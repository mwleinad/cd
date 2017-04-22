function ShowTab(tab){
	$("AutoImp").style.display = 'none';
	$("Presentacion").style.display = 'none';
	
	$("tabAutoImp").removeClassName('activo');
	$("tabPresentacion").removeClassName('activo');
		
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


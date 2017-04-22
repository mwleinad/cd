function ShowTab(tab){
	$("Plan").style.display = 'none';
	$("Funciona").style.display = 'none';
	$("Promotores").style.display = 'none';
	$("Inversionistas").style.display = 'none';
	
	$("tabPlan").removeClassName('activo');
	$("tabFunciona").removeClassName('activo');
	$("tabPromotores").removeClassName('activo');
	$("tabInversionistas").removeClassName('activo');
	
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


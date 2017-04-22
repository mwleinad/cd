function ShowTab(tab){
	$("About").style.display = 'none';
	$("Friends").style.display = 'none';
	$("Stuff").style.display = 'none';
	
	$("tabAbout").removeClassName('activo');
	$("tabFriends").removeClassName('activo');
	$("tabStuff").removeClassName('activo');
	
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}


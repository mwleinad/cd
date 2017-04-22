	var DOC_ROOT = "../";
	var DOC_ROOT_TRUE = "../";
	var DOC_ROOT_SECTION = "../../";

function AddUsuarioDiv(id)
{
	grayOut(true);
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	$('fview').show();
	
	new Ajax.Request(WEB_ROOT+'/ajax/usuarios.php', 
	{
		method:'post',
		parameters: {type:"addUsuario"},
    	onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('agregarUsuario'), "click", AddUsuario);
			Event.observe($('fviewclose'), "click", function(){ AddUsuarioDiv(0); });

		},
    	onFailure: function(){ alert('Something went wrong...') }
  });
}


function AddUsuario()
{
	new Ajax.Request(WEB_ROOT+'/ajax/usuarios.php', 
	{
		method:'post',
		parameters: $('agregarUsuarioForm').serialize(true),
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			console.log(response);
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('usuariosDiv').innerHTML = splitResponse[2];
				//reload event listeners here
				HideFview();
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}


function DeleteUsuarioPopup(id)
{
	var message = "Realmente deseas eliminar este Usuario?";
	if(!confirm(message))
	{
		return;
	}	
	new Ajax.Request(WEB_ROOT+'/ajax/usuarios.php', 
	{
		method:'post',
		parameters: {type: "deleteUsuario", usuario:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				ShowStatus(splitResponse[1])
			}
			else
			{
				ShowStatus(splitResponse[1])
				$('usuariosDiv').innerHTML = splitResponse[2];
				HideFview();
				//reload event listeners here
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
  	});
}


function EditUsuarioPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/usuarios.php', 
	{
		method:'post',
		parameters: {type: "editUsuario", usuario:id},
    	onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('editarUsuario'), "click", EditarUsuario);
			Event.observe($('closePopUpDiv'), "click", function(){ AddUsuarioDiv(0); });

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}


function EditarUsuario()
{
	new Ajax.Request(WEB_ROOT+'/ajax/usuarios.php', 
	{
		method:'post',
		parameters: $('editarUsuarioForm').serialize(true),
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			console.log(response);
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('usuariosDiv').innerHTML = splitResponse[2];
				HideFview();
			}

		},
		onFailure: function(){ alert('Something went wrong...') }
  });
}

function CheckTipoUser(){
		
	var tipo = $("tipoUsuario").value;
	
	if(tipo == "empleado"){
		$("divEmpleado").show();
		$("divPermisos").hide();
	}else if(tipo == ""){
		$("divEmpleado").hide();
		$("divPermisos").hide();
	}else{
		$("divEmpleado").hide();
		$("divPermisos").show();
	}
		
}

Event.observe(window, 'load', function() {
																			 
	AddEditUsuarioListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		
		if(del == true)
		{
			DeleteUsuarioPopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		
		if(del == true)
		{
			EditUsuarioPopup(id);
		}
	}
	
	$('usuariosDiv').observe("click", AddEditUsuarioListeners);																	

});
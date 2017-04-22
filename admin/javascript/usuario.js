Event.observe(window, 'load', function() {
	Event.observe($('addUsuario'), "click", AddUsuarioDiv);

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
		
		del = el.hasClassName('spanAdqui');
		if(del == true)
		{
			adquirir(id);
		}
	}

	$('content').observe("click", AddEditUsuarioListeners);

});

function adquirir(id){
	
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/usuario.php',
	{
		method:'post',
		parameters: {type: "adquisicion", idUsuario:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditUsuarioPopup(0); });
			Event.observe($('adquisicionAdd'), "click", adquisicionAdd);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});

}

function adquisicionAdd(){

new Ajax.Request(WEB_ROOT+'/ajax/usuario.php',
	{
		method:'post',
		parameters: $('addAdqFoliosForm').serialize(true),
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			console.log(response);
			var splitResponse = response.split("[#]");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[2];
				EditUsuarioPopup(0);
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

	new Ajax.Request(WEB_ROOT+'/ajax/usuario.php',
	{
		method:'post',
		parameters: {type: "editUsuario", idUsuario:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditUsuarioPopup(0); });
			Event.observe($('editUsuario'), "click", EditUsuario);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function EditUsuario()
{
	new Ajax.Request(WEB_ROOT+'/ajax/usuario.php',
	{
		method:'post',
		parameters: $('editUsuarioForm').serialize(true),
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[2];
				EditUsuarioPopup(0);
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
	new Ajax.Request(WEB_ROOT+'/ajax/usuario.php',
	{
		method:'post',
		parameters: {type: "deleteUsuario", idUsuario: id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('content').innerHTML = splitResponse[2];
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddUsuarioDiv(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/usuario.php',
	{
		method:'post',
		parameters: {type: "addUsuario"},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('addUsuario'), "click", AddUsuario);
			Event.observe($('fviewclose'), "click", function(){ AddUsuarioDiv(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddUsuario()
{
	new Ajax.Request(WEB_ROOT+'/ajax/usuario.php',
	{
		method:'post',
		parameters: $('addUsuarioForm').serialize(true),
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[2];
				AddUsuarioDiv(0);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


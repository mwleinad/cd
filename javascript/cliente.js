function EditClientePopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/cliente.php', 
	{
		method:'post',
		parameters: {type: "editCliente", id:id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddClienteDiv(0); });
			Event.observe($('editarCliente'), "click", EditarCliente);

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function EditarCliente()
{
	new Ajax.Request(WEB_ROOT+'/ajax/cliente.php', 
	{
		method:'post',
		parameters: $('editarClienteForm').serialize(true),
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
				$('empresaClientesDiv').innerHTML = splitResponse[2];
				HideFview();
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function DeleteClientePopup(id)
{
	var message = "Realmente deseas eliminar este Cliente?";
	if(!confirm(message))
  {
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/cliente.php', 
	{
		method:'post',
		parameters: {type: "deleteCliente", id: id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('empresaClientesDiv').innerHTML = splitResponse[2];
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
	

}

function AddClienteDiv(id)
{
	grayOut(true);
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	$('fview').show();
	
	new Ajax.Request(WEB_ROOT+'/ajax/cliente.php', 
	{
		method:'post',
		parameters: {type: "addCliente"},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('agregarCliente'), "click", AddCliente);

			Event.observe($('fviewclose'), "click", function(){ AddClienteDiv(0); });
			$("rfc").observe("keyup",Search);

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function AddCliente()
{
	new Ajax.Request(WEB_ROOT+'/ajax/cliente.php', 
	{
		method:'post',
		parameters: $('agregarClienteForm').serialize(true),
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
						console.log(response);

			var splitResponse = response.split("[#]");
			
			if(splitResponse[0] == "ok"){
				ShowStatusPopUp(splitResponse[1]);
				$('empresaClientesDiv').innerHTML = splitResponse[2];
				HideFview();
			}else{
				ShowStatusPopUp(splitResponse[1]);			
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function Search()
{	
	console.log("here");
	new Ajax.Request(WEB_ROOT+'/ajax/cliente.php', 
	{
		method:'post',
		parameters: {valur: $('rfcbusqueda').value, type: "search"},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			$('empresaClientesDiv').innerHTML = response;
			console.log($('rfcbusqueda').value);
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

Event.observe(window, 'load', function() {
									   
	Event.observe($('addCliente'), "click", AddClienteDiv);
	
	AddEditClienteListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		if(del == true)
		{
			DeleteClientePopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditClientePopup(id);
		}
	}

	$('empresaClientesDiv').observe("click", AddEditClienteListeners);
	$("rfc").observe("keyup",Search);
	
});
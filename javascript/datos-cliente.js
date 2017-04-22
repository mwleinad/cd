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
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('empresaClientesDiv').innerHTML = splitResponse[2];
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
//			alert(response);
			FViewOffSet(response);
			Event.observe($('agregarCliente'), "click", AddCliente);
			Event.observe($('fviewclose'), "click", function(){ AddClienteDiv(0); });

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
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1]);
				$('agregarClienteForm').reset();
				$('empresaClientesDiv').innerHTML = splitResponse[2];
				//reload event listeners here
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

Event.observe(window, 'load', function() {
	
	$('editarCliente').observe("click", EditarCliente);

});

function Search()
{
	if($('rfc').value.length < 3)
	{
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/cliente.php', 
	{
		method:'post',
		parameters: {valur: $('rfc').value, type: "search"},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			$('empresaClientesDiv').innerHTML = response;
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}
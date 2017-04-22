Event.observe(window, 'load', function() {
	Event.observe($('addSimulador'), "click", AddSimuladorDiv);

	AddEditSimuladorListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		if(del == true)
		{
			DeleteSimuladorPopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditSimuladorPopup(id);
		}
	}

	$('content').observe("click", AddEditSimuladorListeners);

});

function EditSimuladorPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/simulador.php',
	{
		method:'post',
		parameters: {type: "editSimulador", idSimulador:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditSimuladorPopup(0); });
			Event.observe($('editSimulador'), "click", EditSimulador);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function EditSimulador()
{
	new Ajax.Request(WEB_ROOT+'/ajax/simulador.php',
	{
		method:'post',
		parameters: $('editSimuladorForm').serialize(true),
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
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function DeleteSimuladorPopup(id)
{
	var message = "Realmente deseas eliminar esta Simulador?";
	if(!confirm(message))
	{
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/simulador.php',
	{
		method:'post',
		parameters: {type: "deleteSimulador", idSimulador: id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('content').innerHTML = splitResponse[2];
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddSimuladorDiv(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/simulador.php',
	{
		method:'post',
		parameters: {type: "addSimulador"},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('addSimulador'), "click", AddSimulador);
			Event.observe($('fviewclose'), "click", function(){ AddSimuladorDiv(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddSimulador()
{
	new Ajax.Request(WEB_ROOT+'/ajax/simulador.php',
	{
		method:'post',
		parameters: $('addSimuladorForm').serialize(true),
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
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


Event.observe(window, 'load', function() {
	Event.observe($('addOrden'), "click", AddOrdenDiv);

	AddEditOrdenListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		if(del == true)
		{
			DeleteOrdenPopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditOrdenPopup(id);
		}
	}

	$('content').observe("click", AddEditOrdenListeners);

});

function EditOrdenPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/orden.php',
	{
		method:'post',
		parameters: {type: "editOrden", idOrden:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditOrdenPopup(0); });
			Event.observe($('editOrden'), "click", EditOrden);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function EditOrden()
{
	new Ajax.Request(WEB_ROOT+'/ajax/orden.php',
	{
		method:'post',
		parameters: $('editOrdenForm').serialize(true),
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
				AddOrdenDiv(0);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function DeleteOrdenPopup(id)
{
	var message = "Realmente deseas eliminar este registro?";
	if(!confirm(message))
	{
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/orden.php',
	{
		method:'post',
		parameters: {type: "deleteOrden", idOrden: id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('content').innerHTML = splitResponse[2];
				AddOrdenDiv(0);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddOrdenDiv(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/orden.php',
	{
		method:'post',
		parameters: {type: "addOrden"},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('addOrden'), "click", AddOrden);
			Event.observe($('fviewclose'), "click", function(){ AddOrdenDiv(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddOrden()
{
	new Ajax.Request(WEB_ROOT+'/ajax/orden.php',
	{
		method:'post',
		parameters: $('addOrdenForm').serialize(true),
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
				AddOrdenDiv(0);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


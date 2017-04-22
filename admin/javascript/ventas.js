Event.observe(window, 'load', function() {
	Event.observe($('addVentas'), "click", AddVentasDiv);

	AddEditVentasListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		if(del == true)
		{
			DeleteVentasPopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditVentasPopup(id);
		}
	}

	$('content').observe("click", AddEditVentasListeners);

});

function EditVentasPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/ventas.php',
	{
		method:'post',
		parameters: {type: "editVentas", idVenta:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditVentasPopup(0); });
			Event.observe($('editVentas'), "click", EditVentas);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function EditVentas()
{
	new Ajax.Request(WEB_ROOT+'/ajax/ventas.php',
	{
		method:'post',
		parameters: $('editVentasForm').serialize(true),
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
				AddVentasDiv(0);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function DeleteVentasPopup(id)
{
	var message = "Realmente deseas eliminar este registro?";
	if(!confirm(message))
	{
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/ventas.php',
	{
		method:'post',
		parameters: {type: "deleteVentas", idVenta: id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('content').innerHTML = splitResponse[2];
				AddVentasDiv(0);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddVentasDiv(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/ventas.php',
	{
		method:'post',
		parameters: {type: "addVentas"},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('addVentas'), "click", AddVentas);
			Event.observe($('fviewclose'), "click", function(){ AddVentasDiv(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddVentas()
{
	new Ajax.Request(WEB_ROOT+'/ajax/ventas.php',
	{
		method:'post',
		parameters: $('addVentasForm').serialize(true),
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
				$('content').innerHTML = splitResponse[2];
				AddVentasDiv(0);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


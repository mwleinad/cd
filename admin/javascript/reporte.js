Event.observe(window, 'load', function() {
	Event.observe($('addReporte'), "click", AddReporteDiv);

	AddEditReporteListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		if(del == true)
		{
			DeleteReportePopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditReportePopup(id);
		}
	}

	$('content').observe("click", AddEditReporteListeners);

});

function EditReportePopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/reporte.php',
	{
		method:'post',
		parameters: {type: "editReporte", idReporte:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditReportePopup(0); });
			Event.observe($('editReporte'), "click", EditReporte);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function EditReporte()
{
	new Ajax.Request(WEB_ROOT+'/ajax/reporte.php',
	{
		method:'post',
		parameters: $('editReporteForm').serialize(true),
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
				AddReporteDiv(0);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function DeleteReportePopup(id)
{
	var message = "Realmente deseas eliminar este registro?";
	if(!confirm(message))
	{
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/reporte.php',
	{
		method:'post',
		parameters: {type: "deleteReporte", idReporte: id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('content').innerHTML = splitResponse[2];
				AddReporteDiv(0);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddReporteDiv(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/reporte.php',
	{
		method:'post',
		parameters: {type: "addReporte"},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('addReporte'), "click", AddReporte);
			Event.observe($('fviewclose'), "click", function(){ AddReporteDiv(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddReporte()
{
	new Ajax.Request(WEB_ROOT+'/ajax/reporte.php',
	{
		method:'post',
		parameters: $('addReporteForm').serialize(true),
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
				AddReporteDiv(0);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


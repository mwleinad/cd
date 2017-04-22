function AddRfcDiv(id)
{
	grayOut(true);
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	$('fview').show();
	
	new Ajax.Request(WEB_ROOT+'/ajax/datos-generales.php', 
	{
		method:'post',
		parameters: {type: "addRfc"},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('agregarRfc'), "click", AddRfc);
			Event.observe($('fviewclose'), "click", function(){ AddRfcDiv(0); });

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}


function AddRfc()
{
	var form = $('agregarRfcForm').serialize();
	new Ajax.Request(WEB_ROOT+'/ajax/datos-generales.php', 
	{
		method:'post',
		parameters: {form: form, type: "saveRfc"},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
		//	alert(response);
			var splitResponse = response.split("[#]");
			
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('empresaRfcsDiv').innerHTML = splitResponse[2];
				HideFview();
				//reload event listeners here
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function EditarRfc()
{
	var form = $('editRfcForm').serialize();
	new Ajax.Request(WEB_ROOT+'/ajax/datos-generales.php', 
	{
		method:'post',
		parameters: {form: form, type: "saveEditRfc"},
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
				$('empresaRfcsDiv').innerHTML = splitResponse[2];
				HideFview();
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function EditRfcPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/datos-generales.php', 
	{
		method:'post',
		parameters: {type: "editRfc", id:id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddRfcDiv(0); });
			Event.observe($('editarRfc'), "click", EditarRfc);

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function DeleteRfcPopup(id)
{
	var message = "Realmente deseas eliminar este RFC?";
	if(!confirm(message))
  {
		return;
	}	

	new Ajax.Request(WEB_ROOT+'/ajax/datos-generales.php', 
	{
		method:'post',
		parameters: {type: "deleteRfc", rfcId: id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('empresaRfcsDiv').innerHTML = splitResponse[2];
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function DeleteSucursal(id)
{
	var message = "Realmente deseas eliminar esta Sucursal?";
	if(!confirm(message))
  {
		return;
	}	

	new Ajax.Request(WEB_ROOT+'/ajax/sucursales.php', 
	{
		method:'post',
		parameters: {type: "deleteSucursal", sucursalId: id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1]);
			ShowSucursales(splitResponse[2]);
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function EditSucursalPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/sucursales.php', 
	{
		method:'post',
		parameters: {type: "editSucursal", id:id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddRfcDiv(0); });
			Event.observe($('editarSucursal'), "click", EditarSucursal);

		},
    onFailure: function(){ alert('Something went wrong...') }
  });	
}

function EditarSucursal()
{
	var form = $('editSucursalForm').serialize();
	
	new Ajax.Request(WEB_ROOT+'/ajax/sucursales.php', 
	{
		method:'post',
		parameters: {form:form, type: "saveEditSucursal", sucursalId:$('sucursalId').value},
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
				ShowSucursales(splitResponse[2]);
				HideFview();
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function AddSucursal(rfcId)
{
		
	var form = $('agregarSucursalForm').serialize();
	
	new Ajax.Request(WEB_ROOT+'/ajax/sucursales.php', 
	{
		method:'post',
		parameters: {form:form, rfcId:rfcId, type: "saveSucursal"},
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
				ShowSucursales(rfcId);
				HideFview();
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });	
}
function AddSucursalDiv(id, rfcId)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/sucursales.php', 
	{
		method:'post',
		parameters: {type: "addSucursal"},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddSucursalDiv(0); });
			Event.observe($('agregarSucursal'), "click", function(){ AddSucursal(rfcId); });

		},
    onFailure: function(){ alert('Something went wrong...') }
  });

}
function ShowSucursales(id)
{
	var rfcId = id;
	new Ajax.Request(WEB_ROOT+'/ajax/sucursales.php', 
	{
		method:'post',
		parameters: {type: "listSucursales", rfc: id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			$('empresaSucursalesDiv').innerHTML = response;
			Event.observe($('addSucursal'), "click", function(){ AddSucursalDiv(1, rfcId); });

			
		},
    onFailure: function(){ alert('Something went wrong...') }
  });	
	
}

function ChangeSucursalStatus(id)
{
	new Ajax.Request(WEB_ROOT+'/ajax/sucursales.php', 
	{
		method:'post',
		parameters: {type: "changeStatus", sucursalId: id},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowSucursales(splitResponse[1]);
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

Event.observe(window, 'load', function() {
																			 
	AddEditRfcListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		if(del == true)
		{
			DeleteRfcPopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditRfcPopup(id);
		}
		else
		{
			ShowSucursales(id);
		}
	}
	
	$('empresaRfcsDiv').observe("click", AddEditRfcListeners);																	 

	SucursalesListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDeleteSucursal');
		var id = el.identify();
		if(del == true)
		{
			DeleteSucursal(id);
			return;
		}

		del = el.hasClassName('spanEditSucursal');
		
		if(del == true)
		{
			EditSucursalPopup(id);
			return;
		}

		del = el.hasClassName('spanStatusSucursal');
		
		if(del == true)
		{
			ChangeSucursalStatus(id);
			return;
		}

	}
	
	$('empresaSucursalesDiv').observe("click", SucursalesListeners);																	 

	Event.observe($('addRfc'), "click", function(){ AddRfcDiv(1); });

});


Event.observe(window, 'load', function() {
	if($('addContacto'))
	{
		Event.observe($('addContacto'), "click", AddContacto);
	}
//	Event.observe($('addContacto'), "click", AddContactoDiv);

	AddEditContactoListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();
		if(del == true)
		{
			DeleteContactoPopup(id);
			return;
		}

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditContactoPopup(id);
		}
	}

	$('content').observe("click", AddEditContactoListeners);

});

function EditContactoPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/contacto.php',
	{
		method:'post',
		parameters: {type: "editContacto", idContacto:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditContactoPopup(0); });
			Event.observe($('editContacto'), "click", EditContacto);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function DeleteContactoPopup(id)
{
	var message = "Realmente deseas eliminar esta Contacto?";
	if(!confirm(message))
	{
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/contacto.php',
	{
		method:'post',
		parameters: {type: "deleteContacto", idContacto: id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			ShowStatus(splitResponse[1])
			$('content').innerHTML = splitResponse[2];
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddContacto()
{
	new Ajax.Request(WEB_ROOT+'/ajax/contacto.php',
	{
		method:'post',
		parameters: $('addContactoForm').serialize(true),
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1]);
				grayOut(false);
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				grayOut(false);
//				$('addContacto').disable();
				$('addContactoForm').reset();
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


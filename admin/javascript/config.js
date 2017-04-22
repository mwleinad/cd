Event.observe(window, 'load', function() {

//			Event.observe($('editConfig'), "click", EditConfig);

	AddEditConfigListeners = function(e) {
		var el = e.element();
		var del = el.hasClassName('spanDelete');
		var id = el.identify();

		del = el.hasClassName('spanEdit');
		if(del == true)
		{
			EditConfigPopup(id);
		}
	}

	$('content').observe("click", AddEditConfigListeners);

});

function EditConfigPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/config.php',
	{
		method:'post',
		parameters: {type: "editConfig", idConfig:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditConfigPopup(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function EditConfig()
{
	$('nosotros').enable();
//	alert($('nosotros').value);
	new Ajax.Request(WEB_ROOT+'/ajax/config.php',
	{
		method:'post',
		parameters: $('editConfigForm').serialize(true),
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			alert(response);
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
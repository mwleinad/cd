Event.observe(window, 'load', function() {
	Event.observe($('addPaqFolios'), "click", AddPaqFoliosDiv);

	

});

function AddPaqFoliosDiv(id){
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	new Ajax.Request(WEB_ROOT+'/ajax/paqFolios.php',
	{
		method:'post',
		parameters: {type: "addPaqFolios"},
		onSuccess: function(transport){
		
			var response = transport.responseText || "no response text";
			//alert(response)
			FViewOffSet(response);
			
		    Event.observe($('addPaqFolios'), "click", AddPaqFolios);
			Event.observe($('fviewclose'), "click", function(){ AddPaqFoliosDiv(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});

}

function editPaqFolios(id){
grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/paqFolios.php',
	{
		method:'post',
		parameters: {type: "editPaqFolios",paqFoliosId:id},
		onSuccess: function(transport){
		
			var response = transport.responseText || "no response text";
		//	alert(response)
			FViewOffSet(response);
			
		    Event.observe($('editPaqFolios'), "click", EditPaqFoliosSave);
			Event.observe($('fviewclose'), "click", function(){ AddPaqFoliosDiv(0); });
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
	
	

}



function EditPaqFoliosSave(){
new Ajax.Request(WEB_ROOT+'/ajax/paqFolios.php',
	{
		method:'post',
		parameters: $('editPaqFoliosForm').serialize(true),
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
				$('fview').hide();
				grayOut(false);
				return;
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


function AddPaqFolios(){
new Ajax.Request(WEB_ROOT+'/ajax/paqFolios.php',
	{
		method:'post',
		parameters: $('addPaqFoliosForm').serialize(true),
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
				$('fview').hide();
				grayOut(false);
				return;
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}
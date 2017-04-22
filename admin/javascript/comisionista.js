var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";
Event.observe(window, 'load', function() {
	ordenes = function(e) {
		var el = e.element();
		var del = el.hasClassName('buttonForm');
		var id = el.identify();
	if(del == true)
		{
			FiltroTipo();
			return;
		}
		
	var del = el.hasClassName('addLog');
	if(del == true)
		{
			AddLog(id);
			return;
		}
		
	var del = el.hasClassName('Editpor');
	if(del == true)
		{
			EditcomisionistaPopup(id);
			return;
		}	
		
	var del = el.hasClassName('cancelarOrdenes');
	if(del == true)
		{
			cancelarOrdenes(id);
			return;
		}
		
	var del = el.hasClassName('showreferido');
	if(del == true)
		{
			showreferido(id);
			return;
		}


	}
	$('ordenesDiv').observe("click", ordenes);																	 

});

		function FiltroTipo()
		{
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php', 
	{	
		
  		parameters:$('filtro').serialize(), 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				$('content').innerHTML = splitResponse[1];
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function EditcomisionistaPopup(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php',
	{
		method:'post',
		parameters: {type: "editComisionista", id:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ EditcomisionistaPopup(0); });
			Event.observe($('editComisionista'), "click", saveEditComisionista);
		},
		onFailure: function(){ alert('Something went wrong...') }
		
		
	});
}


function showreferido(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php',
	{
		method:'post',
		parameters: {type: "showreferido", id:id},
		onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ showreferido(0); });

		},
		onFailure: function(){ alert('Something went wrong...') }
		
		
	});
}



		
		function cancelarOrdenes(id)
		{
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php', 
	{	
		
  		parameters:'type=cancelarOrdenes&id='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				
				ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[2];
				grayOut(false);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}
		function AddLog(id)
		{
			
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php', 
	{	
		
  		parameters:'type=addLog&id='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddLog(0); });
			Event.observe($('guardarFolios'), "click", SaveAddLog);

		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


		function saveEditComisionista()
		{
	//		alert('hola');
	
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php', 
	{	
  		parameters:$('editComisionistaForm').serialize(), 
		method:'post',
    	onSuccess: function(transport){
   		var response = transport.responseText || "no response text";
		//alert (response);
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[2];
				grayOut(false);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}







		function SaveAddLog()
		{
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php', 
	{	
		
  		parameters:$('addLog').serialize(), 
		method:'post',
    	onSuccess: function(transport){
   		var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				ShowStatusPopUp(splitResponse[1])
//				$('content').innerHTML = splitResponse[2];
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

		function SaveAddFolios()
		{
	new Ajax.Request(WEB_ROOT+'/ajax/comisionista.php', 
	{	
		
  		parameters:$('addFolios').serialize(), 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
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

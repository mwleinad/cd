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
		
		var del = el.hasClassName('buttonForm1');
	if(del == true)
		{
			Busqueda(id);
			return;
		}
		
	var del = el.hasClassName('addLog');
	if(del == true)
		{
			AddLog(id);
			return;
		}
	var del = el.hasClassName('cancelarOrdenes');
	if(del == true)
		{
			cancelarOrdenes(id);
			return;
		}


	}
	$('ordenesDiv').observe("click", ordenes);																	 
	//$('ordenesDiv').observe("click", ordenes);	
});

function BorrarEmpresa(id)
{
	var message = "Realmente estas seguro que deseas eliminar esta empresa?";
	if(!confirm(message))
	{
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:'type=borrarEmpresa&empresaId='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
					console.log(response);
			var splitResponse = response.split("|");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				
				//ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[1];
				$('fview').hide();
				grayOut(false);
				return;
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function ToggleInterno(id)
{
	var message = "Realmente estas seguro que deseas cambiar el estatus interno o externo de esta empresa?";
	if(!confirm(message))
	{
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:'type=toggleInterno&empresaId='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
					console.log(response);
			var splitResponse = response.split("|");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				
				//ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[1];
				$('fview').hide();
				grayOut(false);
				return;
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}
function changeActivo(id)
{
	var message = "Realmente estas seguro que deseas cambiar el estatus de esta empresa?";
	if(!confirm(message))
	{
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:'type=changeActivo&empresaId='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
					console.log(response);
			var splitResponse = response.split("|");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				
				//ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[1];
				$('fview').hide();
				grayOut(false);
				return;
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function Busqueda(){
   
new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:$('filtro').serialize(), 
		method:'post',
		  onLoading: function(){
			$("loading").show();
		 },
    	onSuccess: function(transport){
		   $("loading").hide();
      		var response = transport.responseText || "no response text";
			//alert(response)
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
		onFailure: function(){
		$("loading").hide();
				alert('Something went wrong...') 
		
		}
	});



}

		function FiltroTipo()
		{
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
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

function changeSocio(id){

	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:'type=changeSocio&empresaId='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
		//	alert(response)
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddLog(0); });
			Event.observe($('editSocio'), "click", saveSocioChange);

		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}


function changePrice(id){

	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:'type=changePrice&empresaId='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
					console.log(response);
		//	alert(response)
			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddLog(0); });
			Event.observe($('editPrice'), "click", savePriceChange);

		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function  savePriceChange(){

new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:$('frmPriceEdit').serialize(), 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				
				//ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[1];
				$('fview').hide();
				grayOut(false);
				return;
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});


}




function  saveSocioChange(){

new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{	
		
  		parameters:$('frmSocioEdit').serialize(), 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1])
			}
			else
			{
				
				//ShowStatusPopUp(splitResponse[1])
				$('content').innerHTML = splitResponse[1];
				$('fview').hide();
				grayOut(false);
				return;
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});


}


		
function cancelarOrdenes(id)
{
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
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
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
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

		function SaveAddLog()
		{
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
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
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
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

function EdtiFechaVenc(id){

	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{			
  		parameters:'type=editFechaVenc&empresaId='+id, 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";

			FViewOffSet(response);
			Event.observe($('closePopUpDiv'), "click", function(){ AddLog(0); });
			Event.observe($('editPrice'), "click", savePriceChange);

		},
		onFailure: function(){ alert('Something went wrong...') }
	});
	
}//EdtiFechaVenc

function SaveFechaVenc(){

	new Ajax.Request(WEB_ROOT+'/ajax/ordenes.php', 
	{			
  		parameters: $('frmFechaVenc').serialize(), 
		method:'post',
    	onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");

			if(splitResponse[0] == "ok"){				
				ShowStatusPopUp(splitResponse[1]);
				$('content').innerHTML = splitResponse[2];
				$('fview').hide();
				grayOut(false);
				return;
			}else{				
				ShowStatusPopUp(splitResponse[1]);
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});

}//SaveFechaVenc

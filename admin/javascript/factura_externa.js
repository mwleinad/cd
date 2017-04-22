var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";

Event.observe(window, 'load', function() {
	Busqueda();	
})

function Busqueda(){
new Ajax.Request(WEB_ROOT+'/ajax/factura_externa.php', 
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
var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";

// Logic to execute when the end user
// clicks the element
function registerCheck() {
	//alert(WEB_ROOT+'/ajax/register-manual.php');
	new Ajax.Request('http://'+document.location.hostname+'/ajax/register-manual.php',
	{
  	parameters: $('registerForm').serialize(true), 
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
	//		alert(response);
			var splitResponse = response.split("|");

			$('divStatus').innerHTML = splitResponse[1];
			$('centeredDiv').show();
			grayOut(true);

			if(splitResponse[0] == "ok")
			{
			//	$('registerForm').reset();
			}
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function SuggestProveedor()
{
	new Ajax.Request(WEB_ROOT+'/ajax/suggest-proveedor.php', 
	{
  	parameters: {value: $('proveedorId').value},
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			$('suggestionDiv').show();
			$('suggestionDiv').innerHTML = response;
			var elements = $$('span.resultSuggestUser');
			AddSuggestListener(elements);
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function HideSuggestions()
{
	$('suggestionDiv').hide();
}

function AddSuggestListener(elements)
{
	elements.each(
		function(e) {
			var id = $(e).innerHTML;
			$('suggestionDiv').show();
			Event.observe(e, "click", function (e) {
				FillProveedor(e, id);
			});
		}
	);
}

function FillProveedor(elem, id)
{
	id = id.strip();
	$('proveedorId').value = id;
	$('suggestionDiv').hide();
}

function ShowTab(tab){
	$("Personal").style.display = 'none';
	$("Empresa").style.display = 'none';
	$("Cuenta").style.display = 'none';
	
	$("tabPersonal").removeClassName('activo');
	$("tabEmpresa").removeClassName('activo');
	$("tabCuenta").removeClassName('activo');
			
	$(tab).style.display = '';
	$("tab"+tab).addClassName('activo');
}

function SavePersonal(){
	//console.log(WEB_ROOT);
	$("type").value = "savePersonal";
	
	new Ajax.Request(WEB_ROOT+'/ajax/register-manual.php', 
	{
		method:'post',
		parameters: $('registerForm').serialize(true),
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";

			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "ok")
			{
				ShowTab('Empresa');							
			}
			else
			{				
				ShowStatus(splitResponse[1]);	
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}


function SaveEmpresa(){
	
	$("type").value = "saveEmpresa";
	
	new Ajax.Request(WEB_ROOT+'/ajax/register-manual.php', 
	{
		method:'post',
		parameters: $('registerForm').serialize(true),
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";

			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "ok")
			{
				ShowTab('Cuenta');							
			}
			else
			{				
				ShowStatus(splitResponse[1]);	
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function SaveRegistro(){
	
	$("type").value = "saveCuentaNew";
	new Ajax.Request(WEB_ROOT+'/ajax/register-manual.php', 
	{
		method:'post',
		parameters: $('registerForm').serialize(true),
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			console.log(response);

			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "ok")
			{
				ShowStatus(splitResponse[1]);
				$("registerForm").reset();
				ShowTab('Personal');							
			}
			else
			{				
				ShowStatus(splitResponse[1]);	
			}

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
	
}

function ShowCfdi(){
	
	$("listFolios").style.display = '';
	
}

function ShowCbb(){
		
	$("listFolios").style.display = 'none';
	
}

/*
Event.observe(window, 'load', function() {
	Event.observe($('register'), "click", registerCheck);
	Event.observe($('proveedorId'), "keyup", SuggestProveedor);
	Event.observe($('parent'), "focus", HideSuggestions);
});
*/
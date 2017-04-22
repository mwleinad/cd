var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";

// Logic to execute when the end user
// clicks the element
function registerCheck() {
	new Ajax.Request(WEB_ROOT+'/ajax/register.php', 
	{
  	parameters: $('registerForm').serialize(true), 
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");

			$('divStatus').innerHTML = splitResponse[1];
			$('centeredDiv').show();
			grayOut(true);

			if(splitResponse[0] == "ok")
			{
				$('registerForm').reset();
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


Event.observe(window, 'load', function() {
	Event.observe($('register'), "click", registerCheck);
	Event.observe($('proveedorId'), "keyup", SuggestProveedor);
	Event.observe($('parent'), "focus", HideSuggestions);
});




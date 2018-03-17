var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";
/* Andres*/
Event.observe(window, 'load', function() {
	if($('login_0'))
	{
		Event.observe($('login_0'), "click", LoginCheck);
		Event.observe($('password'), "keypress", function(evt) {
       		if(evt.keyCode == 13)
				LoginCheck();
    	});

	}
	/********** LOGIN CLIENTE **************/
	if($('login_01'))
	{
		Event.observe($('login_01'), "click", LoginCheckCliente);
		Event.observe($('password'), "keypress", function(evt) {
       		if(evt.keyCode == 13)
				LoginCheckCliente();
    	});

	}
	/********** END LOGIN CLIENTE **************/

});

function enviarEmail()
{
	new Ajax.Request(WEB_ROOT+'/ajax/sistema.php',
	{
  	parameters: $('formInformes').serialize(true),
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				alert(splitResponse[1]);
			}
			else if(splitResponse[0] == "empty")
			{
				alert("Alguno de los campos esta vacio");
			}
			else if(splitResponse[0] == "ok")
			{
				alert("Su mensaje fue enviado correctamente");
			}
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function LoginCheckCliente()
{
	new Ajax.Request(WEB_ROOT+'/ajax/login.php',
	{
  	parameters: $('loginForm').serialize(true),
		method:'post',
    onSuccess: function(transport){
      		var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");

			if(splitResponse[0] == "fail")
			{
				$('errorLoginDiv').innerHTML = splitResponse[1];
			}
			else
			{
				Redirect("/cliente-factura");
			}
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function LoginCheck()
{
	new Ajax.Request(WEB_ROOT+'/ajax/login.php',
	{
  	parameters: $('loginForm').serialize(true),
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				$('errorLoginDiv').innerHTML = splitResponse[1];
			}
			else
			{
				Redirect("/sistema");
			}
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function ToogleStatusDiv()
{
	$('centeredDiv').toggle();
	grayOut(false);
}

function ToogleStatusDivOnPopup()
{
	$('centeredDivOnPopup').toggle();
	grayOut(false);
}

function Redirect(page)
{
	window.location = WEB_ROOT+page;
}

function RedirectRoot(page)
{
	window.location = page;
}

function Logout() {
	new Ajax.Request(WEB_ROOT+'/ajax/logout.php',
	{
		method:'post',
    onSuccess: function(transport){
      RedirectRoot("http://www.comprobantedigital.mx/sistema/login");
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

Event.observe(window, 'load', function() {
	if($("logoutDiv") != undefined)
		Event.observe($('logoutDiv'), "click", Logout);
});

function CambiarRfcActivo()
{
	new Ajax.Request(WEB_ROOT+'/ajax/sistema.php',
	{
  	parameters: {rfcId: $('rfcId').value, type: "cambiarRfcActivo"},
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			window.location.reload();
		},
    onFailure: function(){ alert('Something went wrong...') }
  });

}

function ToggleDiv(id)
{
	$(id).toggle();
}

function HideFview(){
	$('fview').hide();
	grayOut(false);
}
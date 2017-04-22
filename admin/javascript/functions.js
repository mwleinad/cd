var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";

 function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
 
         return true;
      }

Event.observe(window, 'load', function() {
	if($('login_0'))
	{
		Event.observe($('login_0'), "click", LoginCheck);
	}
});

function LoginCheck()
{
	new Ajax.Request(WEB_ROOT+'/ajax/login.php', 
	{
  	parameters: $('loginForm').serialize(true), 
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			var splitResponse = response.split("|");
			//alert(response)
			if(splitResponse[0] == "fail")
			{
				$('divStatus').innerHTML = splitResponse[1];
				$('centeredDiv').show();
				grayOut(true);
			}
			else
			{
				Redirect('/');
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
}

function Redirect(page)
{
	window.location = WEB_ROOT+page;
}

function Logout() {
	new Ajax.Request(WEB_ROOT+'/ajax/logout.php', 
	{
		method:'post',
    onSuccess: function(transport){
      Redirect('/');
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}



 function checkTecla(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode ==13)
           LoginCheck();
      }


Event.observe(window, 'load', function() {
	Event.observe($('logoutDiv'), "click", Logout);
});

function validateFloatKeyPress(el, evt, ints, decimals) {

    // El punto lo cambiamos por la coma
  /*  if (evt.keyCode == 46) {
        evt.keyCode = 44;
    }*/
    
    // Valores numéricos
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31
        && (charCode < 48 || charCode > 57)) {
        return false;
    }
    
    // Sólo una coma
    if (charCode == 46) {
        if (el.value.indexOf(".") !== -1) {
            return false;
        }

        return true;
    }

    // Determinamos si hay decimales o no
    if (el.value.indexOf(".") == -1) {
        // Si no hay decimales, directamente comprobamos que el número que hay ya supero el número de enteros permitidos
        if (el.value.length >= ints) {
            return false;
        }
    }
    else {

        // Damos el foco al elemento
        el.focus();

        // Para obtener la posición del cursor, obtenemos el rango de la selección vacía
        var oSel = document.selection.createRange();

        // Movemos el inicio de la selección a la posición 0
        oSel.moveStart('character', -el.value.length);

        // La posición de caret es la longitud de la selección
        iCaretPos = oSel.text.length;

        // Distancia que hay hasta la coma
        var dec = el.value.indexOf(".");

        // Si la posición es anterior a los decimales, el cursor está en la parte entera
        if (iCaretPos <= dec) {
            // Obtenemos la longitud que hay desde la posición 0 hasta la coma, y comparamos
            if (dec >= ints) {
                return false;
            }
        }
        else { // El cursor está en la parte decimal
            // Obtenemos la longitud de decimales (longitud total menos distancia hasta la coma menos el carácter coma)
            var numDecimals = el.value.length - dec - 1;
                
            if (numDecimals >= decimals) {
                return false;
            }
        }
    }
    
    return true;
}




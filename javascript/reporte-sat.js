Event.observe(window, 'load', function() {
	Event.observe($('generarReporteButton'), "click", GenerarReporte);
});

function GenerarReporte()
{
	new Ajax.Request(WEB_ROOT+'/ajax/reporte-sat.php', 
	{
		method:'post',
		parameters: {anio: $('anio').value,mes: $('mes').value, type: "generarReporte"},
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			console.log(response);
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				$('descargarArchivo').innerHTML = splitResponse[1];
			}
			else
			{
				$('descargarArchivo').innerHTML = splitResponse[1];
			}
			
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

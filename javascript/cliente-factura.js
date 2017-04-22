var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";

function VistaPreviaComprobante()
{
	var message = "Esto solo generara una vista previa, para generar un comprobante da click en Generar Comprobante.";
	if(!confirm(message))
  {
		return;
	}		
	
	$('totalesDesglosadosDiv').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />Generando Vista Previa, este proceso puede tardar unos segundos';

	$('nuevaFactura').enable();
	var nuevaFactura = $('nuevaFactura').serialize();
	$('nuevaFactura').disable();
	$('rfc').enable();
	$('userId').enable();
	$('formaDePago').enable();
	$('condicionesDePago').enable();
	$('metodoDePago').enable();
	$('tasaIva').enable();
	$('tiposDeMoneda').enable();
	$('porcentajeRetIva').enable();
	$('porcentajeDescuento').enable();
	$('tipoDeCambio').enable();
	$('porcentajeRetIsr').enable();
	$('tiposComprobanteId').enable();
	$('sucursalId').enable();
	$('porcentajeIEPS').enable();
	$('nuevaFactura').enable();
	
	if($('reviso')) var reviso = $('reviso').value;
	else var reviso = "";

	if($('autorizo')) var autorizo = $('autorizo').value;
	else var autorizo = "";

	if($('recibio')) var recibio = $('recibio').value;
	else var recibio = "";

	if($('vobo')) var vobo = $('vobo').value;
	else var vobo = "";

	if($('pago')) var pago = $('pago').value;
	else var pago = "";
	
	if($('tiempoLimite')) var tiempoLimite = $('tiempoLimite').value;
	else var tiempoLimite = "";

	if($('porcentajeISH')) var porcentajeISH = $('porcentajeISH').value;
	else var porcentajeISH = 0;

	new Ajax.Request(WEB_ROOT+'/ajax/sistema.php', 
	{
  	parameters: {nuevaFactura: nuevaFactura, observaciones: $('observaciones').value, type: "vistaPreviaComprobante", reviso: reviso, autorizo: autorizo, recibio: recibio, vobo: vobo, pago: pago, porcentajeISH: porcentajeISH, tiempoLimite:tiempoLimite},
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
//			alert(response);
			var splitResponse = response.split("|");
			if(splitResponse[0] == "fail")
			{
				$('divStatus').innerHTML = splitResponse[1];
				$('centeredDiv').show();
				grayOut(true);
			}
			else
			{
				$('totalesDesglosadosDiv').innerHTML = response;
			}
		},
    onFailure: function(){ alert('Something went wrong...') }
  });		
}

function GeneraComprobante()
{
	var message = "Realmente deseas generar un comprobante. Asegurate de que lo estes generando para tu RFC Correcto.";
	if(!confirm(message))
	{
		return;
	}		
	
	/*$('totalesDesglosadosDiv').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />Generando Comprobante, este proceso puede tardar unos segundos';

	$('nuevaFactura').enable();
	var nuevaFactura = $('nuevaFactura').serialize();
	$('nuevaFactura').disable();
	$('rfc').enable();
	$('userId').enable();
	
	$('formaDePago').enable();
	$('condicionesDePago').enable();
	$('metodoDePago').enable();
	$('tasaIva').enable();
	$('tiposDeMoneda').enable();
	$('porcentajeRetIva').enable();
	$('porcentajeDescuento').enable();
	$('tipoDeCambio').enable();
	$('porcentajeRetIsr').enable();
	$('tiposComprobanteId').enable();
	$('sucursalId').enable();
	$('porcentajeIEPS').enable();
	$('nuevaFactura').enable();

	if($('reviso')) var reviso = $('reviso').value;
	else var reviso = "";

	if($('autorizo')) var autorizo = $('autorizo').value;
	else var autorizo = "";

	if($('recibio')) var recibio = $('recibio').value;
	else var recibio = "";

	if($('vobo')) var vobo = $('vobo').value;
	else var vobo = "";

	if($('pago')) var pago = $('pago').value;
	else var pago = "";
	
	if($('tiempoLimite')) var tiempoLimite = $('tiempoLimite').value;
	else var tiempoLimite = "";
	
	if($('fechaSobreDia')) var fechaSobreDia = $('fechaSobreDia').value;
	else var fechaSobreDia = "";

	if($('fechaSobreMes')) var fechaSobreMes = $('fechaSobreMes').value;
	else var fechaSobreMes = "";

	if($('fechaSobreAnio')) var fechaSobreAnio = $('fechaSobreAnio').value;
	else var fechaSobreAnio = "";

	if($('folioSobre')) var folioSobre = $('folioSobre').value;
	else var folioSobre = "";
	
	if($('cuentaPorPagar').checked) var cuentaPorPagar = $('cuentaPorPagar').value;
	else var cuentaPorPagar = "";*/

//alert(reviso);
	var ticketTC = $('ticketTC').value;
	
	new Ajax.Request(WEB_ROOT+'/ajax/factura-ticket.php', 
	{
  	parameters: {type: "generaComprobante",ticketTC: ticketTC},
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "ok")
			{
				$('totalesDesglosadosDiv').innerHTML = splitResponse[1];
			}
			else
			{
				$('totalesDesglosadosDiv').innerHTML = "Ha ocurrido un error al generar el comprobante por favor contactar a la empresa emisosa. En la mayoria de los casos el error es porque los datos de facturacion no estan bien capturados";
			}
		},
    onFailure: function(){ alert('Something went wrong...') }
  });		
}

Event.observe(window, 'load', function() {
	if($('divForm')!= undefined)
	{
		$('generarFactura').observe("click", GeneraComprobante);
	}
});
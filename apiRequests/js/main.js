// The root URL for the RESTful services

var rootURL = "http://" + document.location.hostname + "/facturacion/api/facturas";

function AgregarFactura(tipo) {

	$("#tipo").val(tipo);

	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: rootURL,
		dataType: "json",
		data: formToJSON(),
		success: function(data, textStatus, jqXHR){

			if(data.tipo == "Fail"){
				alert(data.msg);
			}else if(data.tipo == "Factura"){
				alert('La Factura fue creada correctamente Serie: ' + data.serie + ' Folio: ' + data.folio);
			}else if(data.tipo == "VistaPrevia"){
				alert('La Vista Previa fue creada correctamente');
				window.open(data.url);
			}
		},
		/*
		error: function(jqXHR, textStatus, errorThrown){
			alert('addWine error: ' + textStatus);
		}
		*/
		error:function(jqXHR, status, exception) {
			if (jqXHR.status === 0) {
				alert('Not connect.\n Verify Network.');
			} else if (jqXHR.status == 404) {
				alert('Requested page not found. [404]');
			} else if (jqXHR.status == 500) {
				alert('Internal Server Error [500].');
			} else if (exception === 'parsererror') {
				alert('Requested JSON parse failed.');
			} else if (exception === 'timeout') {
				alert('Time out error.');
			} else if (exception === 'abort') {
				alert('Ajax request aborted.');
			} else {
				alert('Uncaught Error.\n' + jqXHR.responseText);
			}
			console.log(jqXHR.responseText);
		}
	});
	
}//AgregarFactura

function ListarFacturas(){

	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: rootURL,
		dataType: "json",
		data: formToJSON2(),		
		success: function(data, textStatus, jqXHR){
		
			if(data.tipo){
				if(data.tipo == "Fail"){
					alert(data.msg);
				}			
			}else{
				renderList(data);
			}
		},
		error:function(jqXHR, status, exception) {
			if (jqXHR.status === 0) {
				alert('Not connect.\n Verify Network.');
			} else if (jqXHR.status == 404) {
				alert('Requested page not found. [404]');
			} else if (jqXHR.status == 500) {
				alert('Internal Server Error [500].');
			} else if (exception === 'parsererror') {
				alert('Requested JSON parse failed.');
			} else if (exception === 'timeout') {
				alert('Time out error.');
			} else if (exception === 'abort') {
				alert('Ajax request aborted.');
			} else {
				alert('Uncaught Error.\n' + jqXHR.responseText);
			}
		}
	});
	
}//ListarFacturas

function VerFactura(){

	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: rootURL,
		dataType: "json",
		data: formToJSON3(),
		success: function(data, textStatus, jqXHR){
			if(data.tipo == "Fail")
				alert(data.msg);				
			else
				renderInfo(data);
		},		
		error:function(jqXHR, status, exception) {
			if (jqXHR.status === 0) {
				alert('Not connect.\n Verify Network.');
			} else if (jqXHR.status == 404) {
				alert('Requested page not found. [404]');
			} else if (jqXHR.status == 500) {
				alert('Internal Server Error [500].');
			} else if (exception === 'parsererror') {
				alert('Requested JSON parse failed.');
			} else if (exception === 'timeout') {
				alert('Time out error.');
			} else if (exception === 'abort') {
				alert('Ajax request aborted.');
			} else {
				alert('Uncaught Error.\n' + jqXHR.responseText);
			}
		}
	});
	
}

function CancelarFactura(){
	
	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: rootURL,
		dataType: "json",
		data: formToJSON4(),
		success: function(data, textStatus, jqXHR){
			if(data.tipo == "Fail")
				alert(data.msg);				
			else
				alert(data.msg);
		},		
		error:function(jqXHR, status, exception) {
			if (jqXHR.status === 0) {
				alert('Not connect.\n Verify Network.');
			} else if (jqXHR.status == 404) {
				alert('Requested page not found. [404]');
			} else if (jqXHR.status == 500) {
				alert('Internal Server Error [500].');
			} else if (exception === 'parsererror') {
				alert('Requested JSON parse failed.');
			} else if (exception === 'timeout') {
				alert('Time out error.');
			} else if (exception === 'abort') {
				alert('Ajax request aborted.');
			} else {
				alert('Uncaught Error.\n' + jqXHR.responseText);
			}
		}
	});
	
}

// Helper function to serialize all the form fields into a JSON string

function formToJSON() {
	
	return JSON.stringify({
						  
		"accion": $('#accion').val(),
		"usrEmail": $('#usrEmail').val(), 
		"passwd": $('#passwd').val(), 
		"tipo": $('#tipo').val(), 
		"email": $('#email').val(), 
		"passwd": $('#passwd').val(), 
		"rfcReceptor": $('#rfcReceptor').val(),		
		"formaDePago": $('#formaDePago').val(),
		"metodoDePago": $('#metodoDePago').val(),
		"NumCtaPago": $('#NumCtaPago').val(),
		"condicionesDePago": $('#condicionesDePago').val(),
		
		"tipoComprobante": $('#tipoComprobante').val(),
		"sucursal": $('#sucursal').val(),
		"serie": $('#serie').val(),
		"observaciones": $('#observaciones').val(),
		"tasaIva": $('#tasaIva').val(),
		"tiposDeMoneda": $('#tiposDeMoneda').val(),
		"tiposDeCambio": $('#tiposDeCambio').val(),
		
		"porcentajeDescuento": $('#porcentajeDescuento').val(),
		"porcentajeRetIva": $('#porcentajeRetIva').val(),
		"porcentajeRetIsr": $('#porcentajeRetIsr').val(),
		"porcentajeRetIEPS": $('#porcentajeRetIEPS').val(),
				
		"conceptos": [
			{ "noIdentificacion":"A", "cantidad":"1", "unidad":"Pza.", "valorUnitario":"1", "importe":"1", "descripcion":"Prod A", "tasaIva":"16" }, 
			{ "noIdentificacion":"B", "cantidad":"1", "unidad":"Pza.", "valorUnitario":"1", "importe":"1", "descripcion":"Prod B", "tasaIva":"16" },
			{ "noIdentificacion":"C", "cantidad":"1", "unidad":"Pza.", "valorUnitario":"1", "importe":"1", "descripcion":"Prod C", "tasaIva":"16" }
		]
	});
	
}//formToJSON

function formToJSON2() {
	
	return JSON.stringify({						  
		"accion": $('#accion').val(), 		
		"usrEmail": $('#usrEmail').val(), 
		"passwd": $('#passwd').val()
	});
	
}//formToJSON2

function formToJSON3() {
	
	return JSON.stringify({						  
		"accion": $('#accion').val(),
		"usrEmail": $('#usrEmail').val(), 
		"passwd": $('#passwd').val(), 
		"serie": $('#serie').val(),
		"folio": $('#folio').val()		
	});
	
}//formToJSON3

function formToJSON4() {
	
	return JSON.stringify({						  
		"accion": $('#accion').val(),
		"usrEmail": $('#usrEmail').val(), 
		"passwd": $('#passwd').val(), 
		"serie": $('#serie').val(),
		"folio": $('#folio').val(),
		"motivoCancelacion": $('#motivoCancelacion').val()
	});
	
}//formToJSON4

function renderList(data) {
	// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
	var list = data == null ? [] : (data.facturas instanceof Array ? data.facturas : [data.facturas]);
	var status = "";
		
	$('#facturasList li').remove();
	$.each(list, function(index, fact) {
		
		if(fact.status == 1)
			status = "Activo";
		else
			status = "Cancelado";
		
		$('#facturasList').append('<li>' + fact.serie + ' ' + fact.folio + ' :: ' + status + '</li>');
	});
	
}//renderList

function renderInfo(data){
	
	$('#facturaView li').remove();
	$("#facturaView").append("<li>" + data.serie + " " + data.folio + "</li>");
	$("#facturaView").append("<li><a href='" + data.pdf + "'>Factura</a></li>");
	$("#facturaView").append("<li><a href='" + data.xml + "'>Xml</a></li>");
	
}//renderInfo

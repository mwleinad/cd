var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";
var WEB_ROOT = "http://www.prana.mx";

// Logic to execute when the end user
// clicks the element

function AddFinalizarListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(1).previous(2).innerHTML;
			Event.observe(e, "click", function (e) {
				FinalizarPeriodo(e, id);
			});
		}
	);
}

function AddReporteListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(1).previous(2).innerHTML;
			Event.observe(e, "click", function (e) {
				ReportePeriodo(e, id);
			});
		}
	);
}

function ReportePeriodo(elem,id)
{
	id = id.strip();
	window.open(WEB_ROOT+'/pdf/reporte.php?id='+id,'Reporte', 'width=400, height=200, toolbar=yes, location=yes, directories=yes, status=yes, menubar=yes, scrollbars=yes, copyhistory=yes, resizable=yes');
	return;
}

function FinalizarPeriodo(elem,id)
{
	var message = "Realmente quieres finalizar este periodo? Toma en cuenta que no podras volver a activarlo y se generara un periodo activo nuevo";
	if(!confirm(message))
  {
		return;
	}	
	id = id.strip();
	new Ajax.Request(WEB_ROOT+'/ajax/periodos.php', 
	{
		parameters: {action: "finalizar", id: id.strip()}, 
		method:'post',
		onSuccess: function(transport){
			response = transport.responseText || "no response text";
			alert(response);
			splitResponse = response.split("#|#");
			if(splitResponse[0] == "fail")
			{
				ShowStatus(splitResponse[1]);
			}
			else
			{
				$('divListaPeriodos').innerHTML = splitResponse[1]; 
				var elements = $$('span.linkFinalizar');
				AddFinalizarListeners(elements)

				elements = $$('span.linkReporte');
				AddReporteListeners(elements)
			}
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

Event.observe(window, 'load', function() {
	var elements = $$('span.linkFinalizar');
	AddFinalizarListeners(elements)

	elements = $$('span.linkReporte');
	AddReporteListeners(elements)

	elements = $$('span.linkEditar');
	AddEditarUsuarioListeners(elements)

	elements = $$('span.linkDetalles');
	AddDetallesUsuarioListeners(elements)

	elements = $$('span.linkPagoCancelar');
	AddPagoCancelarListeners(elements)

	elements = $$('span.linkPagoNivelUno');
	AddPagoNivelUnoListeners(elements)

	elements = $$('span.linkPagoNivelDos');
	AddPagoNivelDosListeners(elements)

	elements = $$('span.linkPagoNivelTres');
	AddPagoNivelTresListeners(elements)

});

function AddEditarUsuarioListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(0).previous(1).innerHTML;
			Event.observe(e, "click", function (e) {
				EditarUsuario(e, id);
			});
		}
	);
}

function EditarUsuario(elem,id)
{
	id = id.strip();
	new Ajax.Request(WEB_ROOT+'/ajax/admin_usuarios.php', 
	{
		parameters: {action: "detalles", id: id.strip()}, 
		method:'post',
		onSuccess: function(transport){
			response = transport.responseText || "no response text";
			ShowStatus(response);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
	return;
}

function AddDetallesUsuarioListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(0).previous(1).innerHTML;
			Event.observe(e, "click", function (e) {
				DetallesUsuario(e, id);
			});
		}
	);
}

function DetallesUsuario(elem,id)
{
	id = id.strip();
	new Ajax.Request(WEB_ROOT+'/ajax/admin_usuarios.php', 
	{
		parameters: {action: "detalles", id: id.strip()}, 
		method:'post',
		onSuccess: function(transport){
			response = transport.responseText || "no response text";
			ShowStatus(response);
		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddPagoCancelarListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(1).previous(2).innerHTML;
			Event.observe(e, "click", function (e) {
				PagoCancelar(e, id);
			});
		}
	);
}

function PagoCancelar(elem,id)
{
	var message = "Realmente desea cancelar el pago de este usuario";
	if(!confirm(message))
  {
		return;
	}	
	id = id.strip();
	new Ajax.Request(WEB_ROOT+'/ajax/admin_usuarios.php', 
	{
		parameters: {action: "cancelar_pago", id: id.strip()}, 
		method:'post',
		onSuccess: function(transport){
			response = transport.responseText || "no response text";
			splitResponse = response.split("#|#");
			ShowStatus(splitResponse[0]);
			$('statusPagoDiv'+id).innerHTML = splitResponse[1];

			Event.observe($('divPagoNivelUno'+id), "click", function (e) {
				PagarPeriodo(e, id, $('divPagoNivelUno'+id).innerHTML);
			});

			Event.observe($('divPagoNivelDos'+id), "click", function (e) {
				PagarPeriodo(e, id, $('divPagoNivelDos'+id).innerHTML);
			});

			Event.observe($('divPagoNivelTres'+id), "click", function (e) {
				PagarPeriodo(e, id, $('divPagoNivelTres'+id).innerHTML);
			});

		},
		onFailure: function(){ alert('Something went wrong...') }
	});
}

function AddPagoNivelUnoListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(0).previous(2).innerHTML;
			var cantidad = $(e).innerHTML.strip();
			Event.observe(e, "click", function (e) {
				PagarPeriodo(e, id, cantidad);
			});
		}
	);
}

function AddPagoNivelDosListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(0).previous(2).innerHTML;
			var cantidad = $(e).innerHTML.strip();
			Event.observe(e, "click", function (e) {
				PagarPeriodo(e, id, cantidad);
			});
		}
	);
}

function AddPagoNivelTresListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(0).previous(2).innerHTML;
			var cantidad = $(e).innerHTML.strip();
			Event.observe(e, "click", function (e) {
				PagarPeriodo(e, id, cantidad);
			});
		}
	);
}

function PagarPeriodo(elem,id, cantidad)
{
	var message = "Realmente desea confirmar el pago por $"+cantidad+" de este usuario";
	if(!confirm(message))
  {
		return;
	}		
	id = id.strip();
	new Ajax.Request(WEB_ROOT+'/ajax/admin_usuarios.php', 
	{
		parameters: {action: "pagar_periodo", id: id.strip(), cantidad: cantidad}, 
		method:'post',
		onSuccess: function(transport){
			response = transport.responseText || "no response text";
			splitResponse = response.split("#|#");
			ShowStatus(splitResponse[0]);
			$('statusPagoDiv'+id).innerHTML = splitResponse[1];

			Event.observe($('divPagoCancelar'+id), "click", function (e) {
				PagoCancelar(e, id);
			});
				
		},
		onFailure: function(){ alert('Something went wrong...') }
	});

}

var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";

function FillNoIdentificacion(elem, id)
{
	$('noIdentificacion').value = id;
	$('suggestionProductDiv').hide();
	FillConceptoData();
}

function AddPagos(id)
{
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}

	var form = $('nuevaFactura').serialize();

	new Ajax.Request(WEB_ROOT+'/ajax/nueva-venta.php', 
	{
		method:'post',
		parameters: {form:form, type:"addPagos"},
    	onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			var splitResponse = response.split("[#]");
			if(splitResponse[0] == "fail")
			{
				alert(splitResponse[1]);
			}else
			{
			grayOut(true);
			$('fview').show();
			FViewOffSet(response);
			Event.observe($('addPaymentButton'), "click", AddPayment);
			Event.observe($('fviewclose'), "click", function(){ AddPagos(0); });
			}
			

		},
    	onFailure: function(){ alert('Something went wrong...') }
  });
}
function AddPayment()
{
	new Ajax.Request(WEB_ROOT+'/ajax/nueva-venta.php', 
	{
		method:'post',
		parameters: $("addPaymentForm").serialize(true),
    	onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			//console.log("variable response2  "+response);
			var splitResponse = response.split("[#]");

			if(splitResponse[0] == "fail")
			{
				ShowStatusPopUp(splitResponse[1]);
			}else
			{
				GenerarComprobante();
			}
		},
    	onFailure: function(){ alert('Something went wrong...') }
  });
}
function GenerarComprobante()
{
	var message = "Realmente deseas finalizar esta venta?.";
	if(!confirm(message))
  	{
		return;
	}		
	
	$('totalesDesglosadosDiv').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />Generando Comprobante, este proceso puede tardar unos segundos';

	var nuevaFactura = $('nuevaFactura').serialize();
	
	new Ajax.Request(WEB_ROOT+'/ajax/nueva-venta.php', 
	{
  	parameters: {nuevaFactura: nuevaFactura, type: "generarNotaVenta"},
		method:'post',
    onSuccess: function(transport){		
		var response = transport.responseText || "no response text";
		var splitResponse = response.split("|");
		
		if(splitResponse[0] == "fail")
		{
			$('divStatus').innerHTML = splitResponse[1];
			$('centeredDiv').show();
			grayOut(true);
			AddPagos(0);
		}
		else
		{
			$('cantidad').value = "";
			$('noIdentificacion').value = "";
			$('unidad').value = "";
			$('valorUnitario').value = "";
			$('valorUnitarioCI').value = "";
			$('descripcion').value = "";
			$('conceptos').innerHTML = "Ninguno (Has click en Agregar para agregar un concepto)";
			$('totalesDesglosadosDiv').innerHTML = "Necesitas Agregar al menos un concepto";
			AddPagos(0);
			window.open(WEB_ROOT+"/ventas-ticket/ventaId/"+splitResponse[1],"_blank");
		}
	},
    onFailure: function(){ alert('Something went wrong...') }
  });		
}

function SuggestProduct()
{
	new Ajax.Request(WEB_ROOT+'/ajax/suggest_x.php', 
	{
  	parameters: {value: $('noIdentificacion').value, type: "producto"},
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			$('suggestionProductDiv').show();
			$('suggestionProductDiv').innerHTML = response;
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function HideSuggestions()
{
	$('suggestionDiv').hide();
}

function FillConceptoData()
{
	$('loadingDivConcepto').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />';
	new Ajax.Request(WEB_ROOT+'/ajax/fill_form.php', 
	{
  	parameters: {value: $('noIdentificacion').value, type: "producto"},
		method:'post',
      onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			var splitResponse = response.split("{#}");
			$('descripcion').value = splitResponse[0];
			$('valorUnitario').value = splitResponse[1];
			$('unidad').value = splitResponse[2];
			$('precioCompra').value = splitResponse[3];
			$('loadingDivConcepto').innerHTML = '';
			UpdateValorUnitarioConIva();
		},
    onFailure: function(){ alert('Something went wrong...') }
  });
	
}

function UpdateValorUnitarioConIva()
{
	var valor = parseFloat($('valorUnitario').value) || 0;
	var valorConIva = valor + (valor * (parseInt($('tasaIva').value) / 100));
	$('valorUnitarioCI').value = valorConIva.toFixed(2);
}

function UpdateValorUnitarioSinIva(valor)
{
	var valor = $('valorUnitarioCI').value;
	var valorSinIva = parseFloat(valor) || 0;
	var tasaIva = 1 + (parseInt($('tasaIva').value) / 100);	
	
	valorSinIva = valorSinIva / tasaIva;
	
	$('valorUnitario').value = valorSinIva.toFixed(6);
}


function AgregarConcepto()
{
	$('conceptos').innerHTML = '<div align="center"><img src="'+WEB_ROOT+'/images/load.gif" /></div>';
	
	new Ajax.Request(WEB_ROOT+'/ajax/nueva-venta.php', 
	{ 
		method:'post',
		parameters: $('conceptoForm').serialize(true), 
		onSuccess: function(transport){
    	var response = transport.responseText || "no response text";
		var splitResponse = response.split("|");

		if(splitResponse[0] == "fail")
		{
			$('divStatus').innerHTML = splitResponse[1];
			$('centeredDiv').show();
			grayOut(true);
		}
		
		$('conceptos').innerHTML = splitResponse[2];
		var elements = $$('span.linkBorrar'); 
		AddBorrarConceptoListeners(elements);
		UpdateTotalesDesglosados();
		$('cantidad').value = "";
		$('noIdentificacion').value= "";
		$('unidad').value="";
		$('valorUnitario').value="";
		$('valorUnitarioCI').value="";
		$('descripcion').value="";
		$('precioCompra').value="";
	},
    onFailure: function(){ alert('Something went wrong...') }
  });	
}

function BorrarConcepto(id)
{
	new Ajax.Request(WEB_ROOT+'/ajax/nueva-venta.php', 
	{
  	parameters: {id: id, type: "borrarConcepto"},
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			$('conceptos').innerHTML = response;
			var elements = $$('span.linkBorrar');
			AddBorrarConceptoListeners(elements)			
			UpdateTotalesDesglosados();

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

function AddBorrarConceptoListeners(elements)
{
	elements.each(
		function(e) {
			var id = $(e).up(0).previous(7).innerHTML;
			Event.observe(e, "click", function (e) {
				BorrarConcepto(e, id);
			});
		}
	);
}

function UpdateTotalesDesglosados()
{
	var form = $('nuevaFactura').serialize();
	new Ajax.Request(WEB_ROOT+'/ajax/nueva-venta.php', 
	{
  	parameters: {form: form, type: "updateTotalesDesglosados"},
		method:'post',
    onSuccess: function(transport){
      var response = transport.responseText || "no response text";
			$('totalesDesglosadosDiv').innerHTML = response;
		},
    onFailure: function(){ alert('Something went wrong...') }
  });	
}

function ShowPopUpDiv(id)
{
	grayOut(true);
	$('fview').show();
	if(id == 0)
	{
		$('fview').hide();
		grayOut(false);
		return;
	}
	
	new Ajax.Request(WEB_ROOT+'/ajax/popupdivtest.php', 
	{
		method:'post',
    onSuccess: function(transport){
			var response = transport.responseText || "no response text";
			$('fview').innerHTML = response;
			Event.observe($('closePopUpDiv'), "click", function(){ ShowPopUpDiv(0); });
			new Draggable('fview',{scroll:window,handle:'popupheader'});

		},
    onFailure: function(){ alert('Something went wrong...') }
  });
}

Event.observe(window, 'load', function() {
	if($('noIdentificacion'))
	{
		Event.observe($('noIdentificacion'), "keyup", function(){ SuggestProduct(); FillConceptoData();});
	}
	if($('agregarConceptoDiv'))
	{
		Event.observe($('agregarConceptoDiv'), "click", AgregarConcepto);
	}
	if($('generarFactura'))
	{
		Event.observe($('generarFactura'), "click", function(){AddPagos(1);});
		//aca ira mi código
	}
	if($$('span.linkBorrar'))
	{
		var elements = $$('span.linkBorrar');
		AddBorrarConceptoListeners(elements);
	}

		AddSuggestListener = function(e) {
			var el = e.element();
			var del = el.hasClassName('suggestProductoDiv');
			var id = el.identify();
			if(del == true){
				FillNoIdentificacion(1, id);
				return;
			}

			del = el.hasClassName('closeSuggestUserDiv');
			
			if(del == true){
				$('suggestionDiv').hide();
				return;
			}

			del = el.hasClassName('closeSuggestProductoDiv');
			
			if(del == true){
				$('suggestionProductDiv').hide();
				return;
			}

			del = el.hasClassName('closeSuggestImpuestoDiv');
			
			if(del == true){
				$('suggestionImpuestoDiv').hide();
				return;
			}


		}
	
	if($('divForm')!= undefined)
	{
		$('divForm').observe("click", AddSuggestListener);
	}
});





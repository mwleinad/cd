var DOC_ROOT = "../";
var DOC_ROOT_TRUE = "../";
var DOC_ROOT_SECTION = "../../";

function GuardarNomina()
{
    var message = "Esta opcion guarda los datos de nomina para poder reutilizarlos.";
    if(!confirm(message))
    {
        return;
    }

    $('totalesDesglosadosDiv').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />Guardando Previa, este proceso puede tardar unos segundos';

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

    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            parameters: {nuevaFactura: nuevaFactura, observaciones: $('observaciones').value, type: "guardarDatosNomina", reviso: reviso, autorizo: autorizo, recibio: recibio, vobo: vobo, pago: pago, porcentajeISH: porcentajeISH, tiempoLimite:tiempoLimite},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                console.log(response);
//			alert(response);
                alert("Has guardado los datos ve a tu seccion de empleados para generar una nomina automatica");
//				$('totalesDesglosadosDiv').innerHTML = response;
//			}
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

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


function SuggestUser()
{
    new Ajax.Request(WEB_ROOT+'/ajax/suggest_empleado.php',
        {
            parameters: {value: $('rfc').value},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                $('suggestionDiv').show();
                $('suggestionDiv').innerHTML = response;
                console.log("aa");
                console.log($('divForm'));
                $('divForm').observe("click", AddSuggestListener);
                console.log("bb");
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function FillRFC(elem, id)
{
    $('suggestionDiv').hide();
    FillDatosFacturacion(id);
}

function FillNoIdentificacion(elem, id)
{
    $('noIdentificacion').value = id;
    $('suggestionProductDiv').hide();
    FillConceptoData();
}

function FillImpuestoId(elem, id)
{
    $('impuestoId').value = id;
    $('suggestionImpuestoDiv').hide();
    FillImpuestoData();
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

function SuggestImpuesto()
{
    new Ajax.Request(WEB_ROOT+'/ajax/suggest_x.php',
        {
            parameters: {value: $('impuestoId').value, type: "impuesto"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                $('suggestionImpuestoDiv').show();
                $('suggestionImpuestoDiv').innerHTML = response;
                var elements = $$('span.resultSuggestImpuesto');
                AddSuggestImpuestoListener(elements);
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function HideSuggestions()
{
    $('suggestionDiv').hide();
}

function FillImpuestoData()
{
    $('loadingDivImpuesto').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />';

//	$('suggestionProductDiv').hide();
    new Ajax.Request(WEB_ROOT+'/ajax/fill_form.php',
        {
            parameters: {value: $('impuestoId').value, type: "impuesto"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                var splitResponse = response.split("{#}");
                $('impuestoId').value = splitResponse[0];
                $('tasa').value = splitResponse[1];
                $('tipo').value = splitResponse[2];
                $('iva').value = splitResponse[3];
                $('loadingDivImpuesto').innerHTML = '';
            },
            onFailure: function(){ alert('Something went wrong...') }
        });

}

function FillConceptoData()
{
    $('loadingDivConcepto').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />';

//	$('suggestionProductDiv').hide();
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
                $('loadingDivConcepto').innerHTML = '';
            },
            onFailure: function(){ alert('Something went wrong...') }
        });

}

function FillDatosFacturacion(id)
{
    $('loadingDivDatosFactura').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />';

//	$('suggestionDiv').hide();
    new Ajax.Request(WEB_ROOT+'/ajax/fill_form_empleado.php',
        {
            parameters: {value: id, type: "datosFacturacion"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                var splitResponse = response.split("{#}");
                //splitResponse[3] = splitResponse[3].replace(/\r?\n/g, '<br />');
                //alert(decodeURIComponent(splitResponse[3]));
                $('razonSocial').value = splitResponse[3];
                $('rfc').value = splitResponse[4];
                $('userId').value = splitResponse[5];
                $('calle').value = splitResponse[6];
                $('pais').value = splitResponse[7];
                $('loadingDivDatosFactura').innerHTML = '';

            },
            onFailure: function(){ alert('Something went wrong...') }
        });

}

function UpdateTotalesDesglosados()
{
    var form = $('nuevaFactura').serialize();
    console.log(form);
    new Ajax.Request(WEB_ROOT+'/ajax/sistema.php',
        {
            parameters: {form: form, type: "updateTotalesDesglosados"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                console.log(response);
                $('totalesDesglosadosDiv').innerHTML = response;
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function GenerarComprobante()
{
    var message = "Realmente deseas generar un comprobante. Asegurate de que lo estes generando para tu RFC Correcto.";
    if(!confirm(message))
    {
        return;
    }

    $('totalesDesglosadosDiv').innerHTML = '<img src="'+WEB_ROOT+'/images/load.gif" />Generando Comprobante, este proceso puede tardar unos segundos';

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
    else var cuentaPorPagar = "";

//alert(reviso);

    new Ajax.Request(WEB_ROOT+'/ajax/cfdi33.php',
        {
            parameters: {nuevaFactura: nuevaFactura, observaciones: $('observaciones').value, type: "generarComprobante", reviso: reviso, autorizo: autorizo, recibio: recibio, vobo: vobo, pago: pago, fechaSobreDia: fechaSobreDia, fechaSobreMes: fechaSobreMes, fechaSobreAnio: fechaSobreAnio, folioSobre: folioSobre, tiempoLimite:tiempoLimite, cuentaPorPagar:cuentaPorPagar},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                console.log(response);
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
                    //$('reemplazarBoton').innerHTML += response;;
                    //$('reemplazarBoton').innerHTML = splitResponse[1];;
                }
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

//percepciones
function AgregarPercepcion()
{
    $('percepciones').innerHTML = '<div align="center"><img src="'+WEB_ROOT+'/images/load.gif" /></div>';
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            method:'post',
            parameters: $('percepcionesForm').serialize(true),
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                console.log(response);
                var splitResponse = response.split("|");

                if(splitResponse[0] == "fail")
                {
                    $('divStatus').innerHTML = splitResponse[1];
                    $('centeredDiv').show();
                    grayOut(true);
                }

                $('percepciones').innerHTML = splitResponse[2];

                UpdateConcepto();
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function BorrarPercepcion(id)
{
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            parameters: {id: id, type: "borrarPercepcion"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                $('percepciones').innerHTML = response;

                UpdateConcepto();

            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

//otros pagos
function AgregarOtroPago()
{
    $('otrosPagos').innerHTML = '<div align="center"><img src="'+WEB_ROOT+'/images/load.gif" /></div>';
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            method:'post',
            parameters: $('otrosPagosForm').serialize(true),
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                console.log(response);
                var splitResponse = response.split("|");

                if(splitResponse[0] == "fail")
                {
                    $('divStatus').innerHTML = splitResponse[1];
                    $('centeredDiv').show();
                    grayOut(true);
                }

                $('otrosPagos').innerHTML = splitResponse[2];

                UpdateConcepto();
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function BorrarOtroPago(id)
{
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            parameters: {id: id, type: "borrarOtroPago"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                $('otrosPagos').innerHTML = response;

                UpdateConcepto();

            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}



//deducciones
function AgregarDeduccion()
{
    $('deducciones').innerHTML = '<div align="center"><img src="'+WEB_ROOT+'/images/load.gif" /></div>';
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            method:'post',
            parameters: $('deduccionesForm').serialize(true),
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                var splitResponse = response.split("|");

                if(splitResponse[0] == "fail")
                {
                    $('divStatus').innerHTML = splitResponse[1];
                    $('centeredDiv').show();
                    grayOut(true);
                }
                $('deducciones').innerHTML = splitResponse[2];

                UpdateConcepto();
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function BorrarDeduccion(id)
{
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            parameters: {id: id, type: "borrarDeduccion"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                $('deducciones').innerHTML = response;

                UpdateConcepto();

            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

//incapacidades
function AgregarIncapacidad()
{
    $('incapacidades').innerHTML = '<div align="center"><img src="'+WEB_ROOT+'/images/load.gif" /></div>';
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            method:'post',
            parameters: $('incapacidadesForm').serialize(true),
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                var splitResponse = response.split("|");

                if(splitResponse[0] == "fail")
                {
                    $('divStatus').innerHTML = splitResponse[1];
                    $('centeredDiv').show();
                    grayOut(true);
                }
                $('incapacidades').innerHTML = splitResponse[2];

                UpdateConcepto();
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function BorrarIncapacidad(id)
{
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            parameters: {id: id, type: "borrarIncapacidad"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                $('incapacidades').innerHTML = response;

                UpdateConcepto();

            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

//horas extra
function AgregarHoraExtra()
{
    $('horasExtras').innerHTML = '<div align="center"><img src="'+WEB_ROOT+'/images/load.gif" /></div>';
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            method:'post',
            parameters: $('horasExtrasForm').serialize(true),
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                var splitResponse = response.split("|");

                if(splitResponse[0] == "fail")
                {
                    $('divStatus').innerHTML = splitResponse[1];
                    $('centeredDiv').show();
                    grayOut(true);
                }
                $('horasExtras').innerHTML = splitResponse[2];

                UpdateConcepto();
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function BorrarHoraExtra(id)
{
    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            parameters: {id: id, type: "borrarHoraExtra"},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                $('horasExtras').innerHTML = response;

                UpdateConcepto();

            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}

function UpdateConcepto()
{
    console.log("dasd");
    $('conceptos').innerHTML = '<div align="center"><img src="'+WEB_ROOT+'/images/load.gif" /></div>';
    console.log("dasd2");

    new Ajax.Request(WEB_ROOT+'/ajax/nomina.php',
        {
            parameters: {type: "updateConcepto", serie: $('tiposComprobanteId').value},
            method:'post',
            onSuccess: function(transport){
                var response = transport.responseText || "no response text";
                console.log(response);
                console.log(response);
                $('conceptos').innerHTML = response;
                UpdateTotalesDesglosados();
            },
            onFailure: function(){ alert('Something went wrong...') }
        });
}


Event.observe(window, 'load', function() {
    if($('rfc'))
    {
//		Event.observe($('rfc'), "keyup", function(){ SuggestUser(); FillDatosFacturacion();});
        Event.observe($('rfc'), "keyup", function(){ SuggestUser(); });
    }
    if($('rfc'))
    {
        //Event.observe($('noIdentificacion'), "keyup", function(){ SuggestProduct(); FillConceptoData();});
    }
    if($('rfc'))
    {
        //percepciones
        Event.observe($('agregarPercepcionDiv'), "click", AgregarPercepcion);
        Event.observe($('agregarOtroPagoDiv'), "click", AgregarOtroPago);
        Event.observe($('agregarDeduccionDiv'), "click", AgregarDeduccion);
        Event.observe($('agregarIncapacidadDiv'), "click", AgregarIncapacidad);
        Event.observe($('agregarHorasExtraDiv'), "click", AgregarHoraExtra);
    }
    if($('rfc'))
    {
        Event.observe($('generarFactura'), "click", GenerarComprobante);
    }

    if($('rfc'))
    {
        Event.observe($('vistaPrevia'), "click", VistaPreviaComprobante);
        Event.observe($('GuardarNomina'), "click", GuardarNomina);
    }

    if($$('span.linkBorrar'))
    {
//		var elements = $$('span.linkBorrar');
//		AddBorrarConceptoListeners(elements);
    }

    AddSuggestListener = function(e) {
        var el = e.element();
        var del = el.hasClassName('suggestUserDiv');
        var id = el.identify();
        if(del == true){
            FillRFC(1, id);
            return;
        }

        del = el.hasClassName('closeSuggestUserDiv');

        if(del == true){
            $('suggestionDiv').hide();
            return;
        }
    }

    if($('divForm')!= undefined)
    {
        $('divForm').observe("click", AddSuggestListener);
    }
});





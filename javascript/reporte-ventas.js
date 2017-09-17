	var DOC_ROOT = "../";
	var DOC_ROOT_TRUE = "../";
	var DOC_ROOT_SECTION = "../../"; 

	function editarConceptos(id){
		grayOut(true);
		$('fview').show();
		if(id == 0){
				$('fview').hide();
		   	grayOut(false);
				return;
				}
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php',{
			method:'post',
			parameters: {type: "editarConceptos", id:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				console.log(response);//andres 
				FViewOffSet(response);
				Event.observe($('closePopUpDiv'), "click", function(){ AddPaymentPopup(0); });
				$('editarConceptosButton').observe("click", EditarSave);
				Event.observe($('importe'), "keypress", function(evt) { 
       		if(evt.charCode == 13)
					{
						EditarSave();
					}
    			});//fin funcion tecla enter
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//AddPaymentPopup		
	
		function EditarSave()
	{
			new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php', 
		{
			method:'post',
			parameters: $('addPaymentForm').serialize(true),
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "ok"){
					ShowStatusPopUp(splitResponse[1]);
					$('facturasListDiv').innerHTML = splitResponse[4];
					AddPaymentPopup(splitResponse[5]);
				}else{
					ShowStatusPopUp(splitResponse[1]);				
				}
	
			},
			onFailure: function(){ alert('Something went wrong...') }
		});
	}
	function Facturar(id)
	{
		window.open(WEB_ROOT+"/sistema/nueva-factura/id/"+id,"_self");
	}
	
	function FacturarNoFacturados()
	{
		var ticketsFacturar = $('facturarTickes').serialize();
		if(ticketsFacturar == ""){
		alert("Debe seleccionar al menos un Tickets para facturar");
		return;	
		}
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php', 
		{
			method:'post',
			parameters: {type: "ticketsFacturar", ticketsFacturar: ticketsFacturar},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "ok")
					window.open(WEB_ROOT+"/sistema/nueva-factura","_self");
				else
					if(splitResponse[0] == "fail")
						alert("Debe elegir 1 o mas tickets para facturar");
					else
						alert("Something went wrogn");
				/**ShowStatusPopUp(splitResponse[1])
				$('paymentContent').innerHTML = splitResponse[2];
				Buscar();*/
			},
			onFailure: function(){ alert('Something went wrong...') }
		});
	}
	function AddPaymentPopup(id){
		grayOut(true);
		$('fview').show();
		if(id == 0){
				$('fview').hide();
		   	grayOut(false);
				return;
				}
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php',{
			method:'post',
			parameters: {type: "addPayment", id:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				console.log(response);//andres 
				FViewOffSet(response);
				Event.observe($('closePopUpDiv'), "click", function(){ AddPaymentPopup(0); });
				$('addPaymentButton').observe("click", AddPayment);
				Event.observe($('importe'), "keypress", function(evt) { 
       		if(evt.charCode == 13)
					{
						AddPayment();
					}
    			});//fin funcion tecla enter
				$('imprimir').observe("click", PrintPayments);
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//AddPaymentPopup	
	
	function AddPayment()
	{
			new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php', 
		{
			method:'post',
			parameters: $('addPaymentForm').serialize(true),
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "ok"){
					ShowStatusPopUp(splitResponse[1]);
					$('paymentContent').innerHTML = splitResponse[2];
					$('total').innerHTML = splitResponse[3];
					$('facturasListDiv').innerHTML = splitResponse[4];
					AddPaymentPopup(splitResponse[5]);
				}else{
					ShowStatusPopUp(splitResponse[1]);				
				}
	
			},
			onFailure: function(){ alert('Something went wrong...') }
		});
	}
	
	function DeletePayment(id)
	{
		var message = "Realmente deseas eliminar este pago?";
		if(!confirm(message)){
			return;
		}
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php', 
		{
			method:'post',
			parameters: {type: "deletePayment", id: id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";				
				var splitResponse = response.split("[#]");
		
				ShowStatusPopUp(splitResponse[1])
				$('paymentContent').innerHTML = splitResponse[2];
				$('total').innerHTML = splitResponse[3];
				$('facturasListDiv').innerHTML = splitResponse[4];
				AddPaymentPopup(splitResponse[5]);
			},
			onFailure: function(){ alert('Something went wrong...') }
		});
	}
	
	function PrintPayments()
	{
		var id = $('comprobanteId').value
		window.open(WEB_ROOT+"/pdf/payments.php?id="+id,"_blank");
	}

	function showDetailsPopup(id){
		
		window.open(WEB_ROOT+"/ventas-ticket/ventaId/"+id,"_blank");
		
	}//showDetailsPopup	

	function Exportar(){
		$('type').value = "exportar";		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php',{
			method:'post',
			parameters: $('frmBusqueda').serialize(true),
			onLoading: function(){
				$('loadBusqueda').show();	
			},
			onSuccess: function(transport){
				$('loadBusqueda').hide();
				
				var response = transport.responseText || "no response text";
			},
			onFailure: function(){ alert('Something went wrong...') }
	  	});	
		
	}//Buscar
	
	function Buscar(){
		$('type').value = "buscar";		
				
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php',{
			method:'post',
			parameters: $('frmBusqueda').serialize(true),
			onLoading: function(){
				$('loadBusqueda').show();	
			},
			onSuccess: function(transport){
				$('loadBusqueda').hide();
				
				var response = transport.responseText || "no response text";
				
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "ok"){
					$('total').update(splitResponse[1]);
					$('facturasListDiv').update(splitResponse[2]);	
				}
			},
			onFailure: function(){ alert('Something went wrong...') }
	  	});	
		
	}//Buscar
	
	function EnviarEmail(id){
				
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php', 
		{
			method:'post',
			parameters: {type: 'enviar_email', id_comprobante: id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
			//	alert(response);
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "ok"){					
					ShowStatusPopUp(splitResponse[1])									
				}
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//EnviarEmail
	
	function CancelarFactura(id)
	{
		grayOut(true);
		$('fview').show();
			if(id == 0){
				$('fview').hide();
				grayOut(false);
				return;
				}
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php',{
			method:'post',
			parameters: {type: "cancelar_div", id_item:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				FViewOffSet(response);
				Event.observe($('closePopUpDiv'), "click", function(){ HideFview(); });
				Event.observe($('btnCancelar'), "click", DoCancelacionVenta);
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//CancelarFactura
	
	function DoCancelacion(){
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php', 
		{
			method:'post',
			parameters: $('frmCancelar').serialize(true),
			onLoading: $('cancelLoading').innerHTML = "Por favor espere. Estamos cancelando su comprobante. <img src='"+WEB_ROOT+"/images/load.gif' />",
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				$('cancelLoading').innerHTML = ""
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "fail"){					
					ShowStatusPopUp(splitResponse[1]);
				}else{
					ShowStatusPopUp(splitResponse[1]);
					HideFview();
						}
				},
			onFailure: function(){ alert('Something went wrong...') }
	  	});
		
	}//DoCancelacion
	//
		function DoCancelacionVenta(){ //DoCancelacionVenta
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-ventas.php', 
		{
			method:'post',
			parameters: $('frmCancelar').serialize(true),
			onLoading: $('cancelLoading').innerHTML = "Por favor espere. Estamos cancelando su Venta. <img src='"+WEB_ROOT+"/images/load.gif' />",
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				$('cancelLoading').innerHTML = ""
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "fail"){					
					ShowStatusPopUp(splitResponse[1]);
				}else{
					ShowStatusPopUp(splitResponse[1]);
					$("facturasListDiv").innerHTML = splitResponse[2];
					HideFview();
				}
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//DoCancelacionVenta
	
function pressEnter()
{
	
	
	
	}	
	
	
	Event.observe(window, 'load', function() {
																			 
		AddEditItemsListeners = function(e) {
			
			var el = e.element();
			var del = el.hasClassName('spanDetails');
			var id = el.identify();
			
			if(del == true)
				showDetailsPopup(id);
			
			del = el.hasClassName('spanCancel');
			if(del == true)
				CancelarFactura(id);

			del = el.hasClassName('spanPayments');
			if(del == true)
				AddPaymentPopup(id);
			
			del = el.hasClassName('spanFacturar');
			if(del == true)
				Facturar(id);
			
		}
		
		SendItemsListeners = function(e) {
			
			var el = e.element();
			var del = el.hasClassName('spanSend');
			var id = el.identify();
			if(del == true)
				EnviarEmail(id);
			
		}
		
	$('facturasListDiv').observe("click", AddEditItemsListeners);
});
	var DOC_ROOT = "../";
	var DOC_ROOT_TRUE = "../";
	var DOC_ROOT_SECTION = "../../";
	
	function DeletePayment(id)
	{
		var message = "Realmente deseas eliminar este pago?";
		if(!confirm(message))
		{
			return;
		}
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php', 
		{
			method:'post',
			parameters: {type: "deletePayment", id: id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				ShowStatusPopUp(splitResponse[1])
				$('paymentContent').innerHTML = splitResponse[2];
				Buscar();
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
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php',{
			method:'post',
			parameters: {type: "addPayment", id:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				FViewOffSet(response);
				Event.observe($('closePopUpDiv'), "click", function(){ showDetailsPopup(0); });
				$('addPaymentButton').observe("click", AddPayment);
				$('paymentContent').observe("click", DeletePaymentListeners);
				$('imprimir').observe("click", PrintPayments);
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//showDetailsPopup	
	
	function PrintPayments()
	{
		var id = $('comprobanteId').value
		window.open(WEB_ROOT+"/pdf/payments.php?id="+id,"_blank");
	}

	function AddPayment()
	{
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php', 
		{
			method:'post',
			parameters: $('addPaymentForm').serialize(true),
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "fail")
				{
					ShowStatusPopUp(splitResponse[1])
				}
				else
				{
					ShowStatusPopUp(splitResponse[1]);
					$('paymentContent').innerHTML = splitResponse[2];
					Buscar();
					//reload event listeners here
				}
	
			},
			onFailure: function(){ alert('Something went wrong...') }
		});
	}

	function showDetailsPopup(id){
		
		grayOut(true);
		$('fview').show();
		if(id == 0){
			$('fview').hide();
			grayOut(false);
			return;
		}
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php',{
			method:'post',
			parameters: {type: "showDetails", id_item:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				FViewOffSet(response);
				Event.observe($('closePopUpDiv'), "click", function(){ showDetailsPopup(0); });
				$('accionList').observe("click", SendItemsListeners);
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//showDetailsPopup	

	function Exportar(){
		
		$('type').value = "exportar";		
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php',{
			method:'post',
			parameters: $('frmBusqueda').serialize(true),
			onLoading: function(){
				$('loadBusqueda').show();	
			},
			onSuccess: function(transport){				
				var response = transport.responseText || "no response text";
				console.log(response);
				var splitResponse = response.split("[#]");
				
				$('loadBusqueda').hide();

				if(splitResponse[0] == "ok")
					alert(splitResponse[1]);
				else
					alert("Ocurrio un error al generar el reporte");
				
			},
			onFailure: function(){ alert('Something went wrong...') }
	  	});	
		
	}//Exportar
	
	function Buscar(){
		
		$('type').value = "buscar";		
				
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php',{
			method:'post',
			parameters: $('frmBusqueda').serialize(true),
			onLoading: function(){
				$('loadBusqueda').show();	
			},
			onSuccess: function(transport){			
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				
				$('loadBusqueda').hide();
				
				$('total').update(splitResponse[1]);
				$('facturasListDiv').update(splitResponse[2]);	
			},
			onFailure: function(){ alert('Something went wrong...') }
	  	});	
		
	}//Buscar
	
	function EnviarEmail(id){
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php', 
		{
			method:'post',
			parameters: {type: 'enviar_email', id_comprobante: id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				console.log(response);
			//	alert(response);
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "ok"){					
					ShowStatusPopUp(splitResponse[1])									
				}
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//EnviarEmail
	
	function CancelarFactura(id){
		
		grayOut(true);
		$('fview').show();
		if(id == 0){
			$('fview').hide();
			grayOut(false);
			return;
		}
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php',{
			method:'post',
			parameters: {type: "cancelar_div", id_item:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				console.log("here2");
				FViewOffSet(response);
				console.log("here");
				Event.observe($('closePopUpDiv'), "click", function(){ showDetailsPopup(0); });
				Event.observe($('btnCancelar'), "click", DoCancelacion);
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//CancelarFactura
	
	function DoCancelacion(){
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php', 
			{
					method:'post',
					parameters: $('frmCancelar').serialize(true),
					onLoading: $('cancelLoading').innerHTML = "Por favor espere. Estamos cancelando su comprobante. <img src='"+WEB_ROOT+"/images/load.gif' />",
					onSuccess: function(transport){
						var response = transport.responseText || "no response text";
						var splitResponse = response.split("[#]");
					
						$('cancelLoading').innerHTML = ""			
			
						if(splitResponse[0] == "ok"){					
							ShowStatusPopUp(splitResponse[1]);
							$("total").innerHTML = splitResponse[2];
							$("facturasListDiv").innerHTML = splitResponse[3];
							HideFview();
						}else{
							ShowStatusPopUp(splitResponse[1]);					
						}
			
					},
					onFailure: function(){ alert('Something went wrong...') }
		  });
		
	}//DoCancelacion
	
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
			
		}
		
		SendItemsListeners = function(e) {
			
			var el = e.element();
			var del = el.hasClassName('spanSend');
			var id = el.identify();
			
			if(del == true)
				EnviarEmail(id);
			
		}
		
		DeletePaymentListeners = function(e) {
			
			var el = e.element();
			var del = el.hasClassName('spanDeletePayment');
			var id = el.identify();
			
			if(del == true)
				DeletePayment(id);
			
		}
	
	$('facturasListDiv').observe("click", AddEditItemsListeners);
	$('btnBuscar').observe("click", Buscar);
	$('btnExportar').observe("click", Exportar);
	$('btnDescargar').observe("click", Descargar);
	
	
	$('rfc').observe("keypress", function(evt) { 
       		if(evt.keyCode == 13)
				Buscar();
    }); 
	
	$('nombre').observe("keypress", function(evt) { 
       		if(evt.keyCode == 13)
				Buscar();
    }); 

	$('anio').observe("keypress", function(evt) { 
       		if(evt.keyCode == 13)
				Buscar();
    });


	
});

	function Descargar(){
		
		$('type').value = "descargar";		
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-facturas.php',{
			method:'post',
			parameters: $('frmBusqueda').serialize(true),
			onLoading: function(){
				$('loadBusqueda').show();	
			},
			onSuccess: function(transport){				
				var response = transport.responseText || "no response text";
				console.log(response);
				var splitResponse = response.split("[#]");
				
				$('loadBusqueda').hide();

				if(splitResponse[0] == "ok")
				{
					window.location.href = splitResponse[1];
				}
				else
					alert("Ocurrio un error al generar el archivo");
				
			},
			onFailure: function(){ alert('Something went wrong...') }
	  	});	
		
	}//Exportar
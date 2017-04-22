	var DOC_ROOT = "../";
	var DOC_ROOT_TRUE = "../";
	var DOC_ROOT_SECTION = "../../";
		
	function AddProductoDiv(id){
		
		grayOut(true);
		if(id == 0){
			$('fview').hide();
			grayOut(false);
			return;
		}
		$('fview').show();
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-productos.php',{
			method:'post',
			parameters: {type: "addProducto"},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				FViewOffSet(response);
				Event.observe($('btnGuardarProducto'), "click", AddProducto);
				Event.observe($('fviewclose'), "click", function(){ AddProductoDiv(0); });
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//AddProductoDiv
	
	function AddProducto(){
		
		var form = $('frmAgregarProducto').serialize();
		new Ajax.Request(WEB_ROOT+'/ajax/manage-productos.php', 
		{
			method:'post',
			parameters: {form: form, type: "saveProducto"},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";				
				var splitResponse = response.split("[#]");
				
				if(splitResponse[0] == "ok"){					
					ShowStatusPopUp(splitResponse[1]);
					$('productosListDiv').innerHTML = splitResponse[2];
					HideFview();
				}else{
					ShowStatusPopUp(splitResponse[1]);					
				}
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//AddProducto

	function guardar_productos(){
				
		var oOptions = {   
            method: "POST",   
            parameters: Form.serialize("frmAgregarProductos"),   
            asynchronous: true,   
            onFailure: function (oXHR) {				
                 $('txtMsg').update('<span class="txtRed">Error al guardar los datos.</span>');				 
            },   
            onLoading: function (oXHR) {				 
                 $('txtMsg').update('<img src="../images/loading.gif" border="0" /><span class="txtBlack">&nbsp;Enviando datos...</span>');   
            },                             
            onSuccess: function(oXHR) {
				 var message = oXHR.responseText;
				 
				 if(message == 'success'){
					$('frmAgregarProductos').reset();
					$('content').update('<p align="center">Los datos fueron guardados correctamente.</p>');				
				 }else
                 	$('txtMsg').update(oXHR.responseText);   
            }
       	};   

		var oRequest = new Ajax.Updater({success: oOptions.onSuccess.bindAsEventListener(oOptions)}, "../ajax/admin-productos.php", oOptions);
			
	}//guardar_productos
	
	function EditProductoPopup(id){
		
		grayOut(true);
		$('fview').show();
		if(id == 0){
			$('fview').hide();
			grayOut(false);
			return;
		}
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-productos.php',{
			method:'post',
			parameters: {type: "editProducto", id_producto:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				FViewOffSet(response);
				Event.observe($('closePopUpDiv'), "click", function(){ AddProductoDiv(0); });
				Event.observe($('btnEditarProducto'), "click", EditarProducto);
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//EditProductoPopup

	function DeleteProductoPopup(id){
		
		var message = "Realmente deseas eliminar este producto?";
		if(!confirm(message)){
			return;
		}	
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-productos.php',{
			method:'post',
			parameters: {type: "deleteProducto", id_producto: id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				ShowStatus(splitResponse[1])
				$('productosListDiv').innerHTML = splitResponse[2];
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//DeleteProductoPopup
	
	function EditarProducto(){
		
		var form = $('frmEditarProducto').serialize();
		new Ajax.Request(WEB_ROOT+'/ajax/manage-productos.php', {
			method:'post',
			parameters: {form: form, type: "saveEditProducto"},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				console.log(response);
				var splitResponse = response.split("[#]");
				if(splitResponse[0] == "fail")
				{
					ShowStatusPopUp(splitResponse[1])
				}
				else
				{
					ShowStatusPopUp(splitResponse[1])
					$('productosListDiv').innerHTML = splitResponse[2];
					HideFview();
				}
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//EditarProducto
	
	Event.observe(window, 'load', function() {
																			 
		AddEditProductosListeners = function(e) {
			var el = e.element();
			var del = el.hasClassName('spanDelete');
			var id = el.identify();
			if(del == true){
				DeleteProductoPopup(id);
				return;
			}
	
			del = el.hasClassName('spanEdit');
			if(del == true)
				EditProductoPopup(id);
			
		}
	
	if($('productosListDiv')!= undefined)
		$('productosListDiv').observe("click", AddEditProductosListeners);


	Event.observe($('addProducto'), "click", function(){ AddProductoDiv(1); });

});
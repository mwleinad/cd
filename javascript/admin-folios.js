	var DOC_ROOT = "../";
	var DOC_ROOT_TRUE = "../";
	var DOC_ROOT_SECTION = "../../";

	function AgregarCertificado(){
		
		$('frmCertificado').submit();
		
	}//AgregarCertificado

	function CambiarRfcActivo(){
		
		new Ajax.Request(WEB_ROOT+'/ajax/sistema.php', 
		{
		parameters: {rfcId: $('rfcId').value, type: "cambiarRfcActivo"},
			method:'post',
		onSuccess: function(transport){
		  var response = transport.responseText || "no response text";
				window.location.reload();
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });	
	
	}//CambiarRfcActivo
		
	function AddFoliosDiv(){

		grayOut(true);		
		$('fview').show();
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-folios.php',{
			method:'post',
			parameters: {type: "addFolios"},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";				
				FViewOffSet(response);
				Event.observe($('btnGuardarFolios'), "click", AddFolios);				
				Event.observe($('fviewclose'), "click", function(){ HideFview() });
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//AddFoliosDiv
	
	function AddFolios(){
		
		var form = $('frmAgregarFolios').serialize();
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-folios.php', 
		{
			method:'post',
			parameters: {form: form, type: "saveFolios"},
			onSuccess: function(transport){				
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");

				if(splitResponse[0] == "ok"){					
					ShowStatusPopUp(splitResponse[1]);
					$("foliosListDiv").innerHTML = splitResponse[2];
					HideFview();
				}else{
					ShowStatusPopUp(splitResponse[1]);									
				}	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//AddFolios
	
	function EditFoliosPopup(id){
		
		grayOut(true);
		$('fview').show();
		if(id == 0){
			$('fview').hide();
			grayOut(false);
			return;
		}
		
		new Ajax.Request(WEB_ROOT+'/ajax/manage-folios.php',{
			method:'post',
			parameters: {type: "editFolios", id_serie:id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				FViewOffSet(response);
				Event.observe($('closePopUpDiv'), "click", function(){ HideFview(); });
				Event.observe($('btnEditarFolios'), "click", EditarFolios);
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//EditFoliosPopup
	
	function EditarFolios(){
		
		var form = $('frmEditarFolios').serialize();
		new Ajax.Request(WEB_ROOT+'/ajax/manage-folios.php', {
			method:'post',
			parameters: {form: form, type: "saveEditFolios"},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
				
				if(splitResponse[0] == "ok"){
					ShowStatusPopUp(splitResponse[1]);
					$('foliosListDiv').innerHTML = splitResponse[2];
					HideFview();
				}else{
					ShowStatusPopUp(splitResponse[1]);					
				}
	
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//EditarFolios
	
	function DeleteFolio(id){
		
		var message = "Realmente deseas eliminar estos folios?";
		
		if(!confirm(message)){
			return;
		}	

		new Ajax.Request(WEB_ROOT+'/ajax/manage-folios.php',{
			method:'post',
			parameters: {type: "deleteFolios", id_serie: id},
			onSuccess: function(transport){
				var response = transport.responseText || "no response text";
				var splitResponse = response.split("[#]");
			
				ShowStatus(splitResponse[1]);
				$('foliosListDiv').innerHTML = splitResponse[2];
				HideFview();
			},
		onFailure: function(){ alert('Something went wrong...') }
	  });
		
	}//DeleteFoliosPopup
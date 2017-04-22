var LOADER = '<img src="'+WEB_ROOT+'/images/loading.gif" /><br />Cargando...';

function Convertir(){
	
	$("txtErrMsg").innerHTML = "";
	$("stBox").innerHTML = LOADER;
	$("btnConv").hide();
	
	if($("xml").value == ""){
		$("stBox").innerHTML = "";
		$("txtErrMsg").innerHTML = "Por favor, seleccione el archivo";
		$("btnConv").show();
		
		return;
	}
		
	var archivos = document.getElementById("xml");
	var archivo = archivos.files;
	
	if(window.XMLHttpRequest){ 
 		var Req = new XMLHttpRequest(); 
 	}else if(window.ActiveXObject){ 
 		var Req = new ActiveXObject("Microsoft.XMLHTTP"); 
 	}
	
	var data = new FormData();
	
	for(i=0; i<archivo.length; i++){
   		data.append('archivo'+i,archivo[i]);
	}
	
	Req.open("POST", WEB_ROOT+"/ajax/xml-pdf.php", true);
	
	Req.onload = function(Event) {	
		if (Req.status == 200) { 
		
		  	var response = Req.responseText || "no response text";
			var splitResponse = response.split("[#]");

			$("stBox").innerHTML = "";
			
			if(splitResponse[0] == "ok"){
				ShowStatus(splitResponse[1]);	
				$("stBox").innerHTML = splitResponse[2];
				$("xml").value = "";
				$("btnConv").show();
			}else{
		  		ShowStatus(splitResponse[1]);			
				$("btnConv").show();
			}
				
		} else { 
		  console.log(Req.status); 
		} 
	};
	
	Req.send(data); 
	 
}//Convertir
<div id="divForm" align="center">
	<form id="frmXmlPdf" name="frmXmlPdf" method="post" enctype="multipart/form-data">
    <input type="hidden" name="accion" value="convertir" />
    <fieldset>				
                   
    * Seleccione el archivo .xml:
    <br /><br />
	<input type="file" name="xml[]" id="xml" class="largeInput" />            
    
    <div id="btnConv">
    <a class="button" onclick="Convertir()"><span>Convertir a Pdf</span></a>
    </div>
    
    <div style="clear:both"></div>
    <br />
    <div align="center" id="txtErrMsg"></div>
    <div align="center" id="stBox"></div>
        
    
             
  	</fieldset>
    </form>
</div>
<br />
<br />
{if $cmpMsg}
<div align="center" style="color:#009900">{$cmpMsg}<br /><br /></div>
{/if}
{if $errMsg}
<div align="center" style="color:#FF0000">{$errMsg}<br /><br /></div>
{/if}
<div id="divForm">
	<form id="frmCertificado" name="frmCertificado" method="post" enctype="multipart/form-data">
    <input type="hidden" name="accion" value="guardar_certificado" />
    <fieldset>				
             
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">Asunto:</div> 
        <div style="width:350px;float:left">
        <select name="asunto" id="asunto" class="largeInput">
        <option value="Problema con el sistema">Problema con el sistema</option>
        <option value="Soporte General">Soporte General</option>
        </select>
            <div style="position:relative">
               <div style="display:none;position:absolute;top:-20; z-index:100" id="suggestionDiv"></div>
             </div>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">* Mensaje:</div> 
         <div style="width:650px;float:left"><textarea name="mensaje" id="mensaje" rows="10" cols="60" class="largeInput"></textarea>
            <div style="position:relative">
               <div style="color:#FF0000; display:{if $errPass}block{else}none{/if}">{$errPass}</div>
             </div>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
 		<hr />
      </div>
      <div align="left">* Campos requeridos.</div>
	    <div class="formLine" style="text-align:center">
      	<a class="button" id="agregarCertificado" name="agregarCertificado" onclick="Enviar()"><span>Enviar</span></a>     	</div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:100%;float:left">Si tu direccion de contacto no es correcta no podremos contestarte. Para Actualizar tus datos de contacto da <a href="{$WEB_ROOT}actualizar">Click Aqui</a>:</div> 
       	<div style="clear:both; padding-top:5px"></div>
      </div>
         
  	</fieldset>
    </form>
</div>

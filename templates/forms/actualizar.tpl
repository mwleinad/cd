<br />
<br />
{if $cmpMsg}
<div align="center" style="color:#009900">{$cmpMsg}<br /><br /></div>
{/if}
{if $errMsg}
<div align="center" style="color:#FF0000">{$errMsg}<br /><br /></div>
{/if}
<div id="divForm">
	<form id="frmCertificado" name="frmCertificado" method="post">
    <input type="hidden" name="accion" value="guardar_certificado" />
    <fieldset>				
             
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Nombre de la Persona de Contacto:</div> 
        <div style="width:750px;float:left"><input name="nombrePer" id="nombrePer" type="text" size="30" value="{$post.nombrePer}" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Correo de la Empresa o Persona de Contacto:</div> 
        <div style="width:750px;float:left"><input name="emailPer" id="emailPer" type="text" size="30" value="{$post.emailPer}" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Telefono de la Empresa:</div> 
        <div style="width:750px;float:left"><input name="telefono" id="telefono" type="text" size="30" value="{$post.telefono}" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Telefono de Contacto:</div> 
        <div style="width:750px;float:left"><input name="telefonoPer" id="telefonoPer" type="text" size="30" value="{$post.telefonoPer}" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">*Celular:</div> 
        <div style="width:750px;float:left"><input name="celularPer" id="celularPer" type="text" size="30" value="{$post.celularPer}" class="largeInput"/>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:150px;float:left">En Caso de Tener un Socio de Referencia, quien es? (Ejemplo: algun contador):</div> 
        <div style="width:750px;float:left">
        <select name="socioReferenciaPer" id="socioReferenciaPer" class="largeInput"/>
        	<option value="0">Elige</option>
        	{foreach from=$socios item=socio}
          	<option value="{$socio.idUsuario}" {if $socio.idUsuario == $info.socioId}selected="selected"{/if}>{$socio.nombre}</option>
          {/foreach}
        </select>
        </div>       
       	<div style="clear:both; padding-top:5px"></div>
      </div>
      
 		<hr />

      <div align="left">* Campos requeridos.</div>
	    <div class="formLine" style="text-align:center">
      <input type="submit" id="enviar" name="enviar" value="Actualizar Datos" />
  	</fieldset>
    </form>

      </div>
</div>

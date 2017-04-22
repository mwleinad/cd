<div id="divForm">
	<form id="editRfcForm" name="editRfcForm" method="post">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Nombre Completo o Razón Social:</div><input name="razonSocial" id="razonSocial" type="text" value="{$post.razonSocial}" size="50" class="largeInput wide2"/>
        <hr />
       
      </div>
       <div class="formLine">
       		Dirección:<br />
          <div style="width:30%;float:left">Calle:</div> <input name="calle" id="calle" type="text" value="{$post.calle}" size="50" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">No. Exterior:</div> <input name="noExt" id="noExt" type="text" value="{$post.noExt}" size="10" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">No. Interior:</div> <input name="noInt" id="noInt" type="text" value="{$post.noInt}" size="10" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Referencia:</div> <input name="referencia" id="referencia" type="text" value="{$post.referencia}" size="50" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Colonia:</div> <input name="colonia" id="colonia" type="text" value="{$post.colonia}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Localidad:</div> <input name="localidad" id="localidad" type="text" value="{$post.localidad}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Municipio o Delegación:</div> <input name="municipio" id="municipio" type="text" value="{$post.municipio}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Ciudad:</div> <input name="ciudad" id="ciudad" type="text" value="{$post.municipio}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">CP:</div> <input name="cp" id="cp" type="text" value="{$post.cp}" size="10" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Estado:</div> <input name="estado" id="estado" type="text" value="{$post.estado}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">País:</div> <input name="pais" id="pais" type="text" value="{$post.pais}" size="50" class="largeInput wide2"/><br />
          <div style="width:60%;float:left">RFC y Homoclave (12 o 13 Letras SIN espacio o guiones):</div><input name="rfc" id="rfc" type="text" value="{$post.rfc}" size="13" class="largeInput wide2"/><br />
          <div style="width:60%;float:left">Régimen Fiscal:</div>
          
          <select name="tipoRegimen" id="tipoRegimen"  class="largeInput wide2">
            	{foreach from=$regimenes item=item}
              <option value="{$item.claveRegimen}" {if $post.regimenFiscal == $item.claveRegimen} selected="selected"{/if}>{$item.nombreRegimen}</option>
              {/foreach}
            </select>
<br />
          <div style="width:60%;float:left">Permiso para Facturar del Cliente:</div>
          <select id="permisoFacturar" name="permisoFacturar" class="largeInput wide2">
          	<option value="Si" {if $post.permisoFacturar == "Si"} selected="selected"{/if}>Si</option>
          	<option value="No" {if $post.permisoFacturar == "No"} selected="selected"{/if}>No</option>
          </select>
          <br />
          <div style="width:60%;float:left">Días Para Facturar:</div><input name="diasFacturar" id="diasFacturar" type="text" value="{$post.diasFacturar}" size="13" class="largeInput wide2"/><br />
          <div style="width:60%;float:left">CURP (Solo persona fisica):</div><input name="curp" id="curp" type="text" value="{$post.curp}" size="13" class="largeInput wide2"/><br />
          
          <div style="clear:both"></div>
 					<hr />
          
      </div>

      <div style="clear:both"></div>
     	<div class="formLine" style="text-align:center">
      <a class="button" id="editarRfc" name="editarRfc"><span>Editar RFC</span></a>
     	</div>
         
  	</fieldset>
  	<input type="hidden" id="rfcId" name="rfcId" value="{$post.rfcId}" />
	</form>
</div>

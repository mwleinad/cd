<div id="divForm">
	<form id="agregarSucursalForm" name="agregarSucursalForm" method="post">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:50%;float:left">*Identificador de la sucursal? (Ej: Matriz, Sucursal 1):</div>
        <input name="identificador" id="identificador" type="text" value="{$post.identificador}" size="30" class="largeInput wide2"/>
        <hr />
        
          <div style="width:30%;float:left">*Calle:</div> <input name="calle" id="calle" type="text" value="{$post.calle}" size="50" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">*No. Exterior:</div> <input name="noExt" id="noExt" type="text" value="{$post.noExt}" size="10" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">No. Interior:</div> <input name="noInt" id="noInt" type="text" value="{$post.noInt}" size="10" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Referencia:</div> <input name="referencia" id="referencia" type="text" value="{$post.referencia}" size="50" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Colonia:</div> <input name="colonia" id="colonia" type="text" value="{$post.colonia}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">*Localidad:</div> <input name="localidad" id="localidad" type="text" value="{$post.localidad}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Municipio o Delegaci&oacute;n:</div> <input name="municipio" id="municipio" type="text" value="{$post.ciudad}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Ciudad:</div> <input name="ciudad" id="ciudad" type="text" value="{$post.ciudad}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">CP:</div> <input name="cp" id="cp" type="text" value="{$post.cp}" size="10" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">Estado:</div> <input name="estado" id="estado" type="text" value="{$post.estado}" size="30" class="largeInput wide2"/><br />
          <div style="width:30%;float:left">*Pa&iacute;s:</div> <input name="pais" id="pais" type="text" value="{$post.pais}" size="50" class="largeInput wide2"/>
 					
     
      </div>
      <div style="clear:both"></div>
			<hr />
      
     	<div class="formLine" style="text-align:center">
      <a class="button" id="agregarSucursal" name="agregarSucursal"><span>Guardar Sucursal</span></a>
     	</div>
         
  	</fieldset>
	</form>
</div>

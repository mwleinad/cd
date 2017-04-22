<div id="divForm">
	<form id="registerForm" name="registerForm" method="post">
    <fieldset>
      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Nombre Completo o Raz&oacute;n Social:</div><input name="razonSocial" id="razonSocial" type="text" value="{$post.razonSocial}" size="50"/>
        <hr />
       
      </div>
       <div class="formLine">
       		Direcci&oacute;n:<br />
          <div style="width:30%;float:left">Calle:</div> <input name="calle" id="calle" type="text" value="{$post.calle}" size="50"/><br />
          <div style="width:30%;float:left">No. Exterior:</div> <input name="noExt" id="noExt" type="text" value="{$post.noExt}" size="10"/><br />
          <div style="width:30%;float:left">No. Interior:</div> <input name="noInt" id="noInt" type="text" value="{$post.noInt}" size="10"/><br />
          <div style="width:30%;float:left">Referencia:</div> <input name="referencia" id="referencia" type="text" value="{$post.referencia}" size="50"/><br />
          <div style="width:30%;float:left">Colonia:</div> <input name="colonia" id="colonia" type="text" value="{$post.colonia}" size="30"/><br />
          <div style="width:30%;float:left">Localidad:</div> <input name="localidad" id="localidad" type="text" value="{$post.localidad}" size="30"/><br />
          <div style="width:30%;float:left">Municipio o Delegaci&oacute;n:</div> <input name="municipio" id="municipio" type="text" value="{$post.ciudad}" size="30"/><br />
          <div style="width:30%;float:left">Ciudad:</div> <input name="ciudad" id="ciudad" type="text" value="{$post.ciudad}" size="30"/><br />
          <div style="width:30%;float:left">CP:</div> <input name="cp" id="cp" type="text" value="{$post.cp}" size="10"/><br />
          <div style="width:30%;float:left">Estado:</div> <input name="estado" id="estado" type="text" value="{$post.estado}" size="30"/><br />
          <div style="width:30%;float:left">Pa&iacute;s:</div> <input name="pais" id="pais" type="text" value="{$post.pais}" size="50"/><br />
 					<hr />
      </div>

       <div class="formLine">
          <div style="width:15%;float:left">RFC y Homoclave:</div> 
          <div style="width:15%;float:left"><input name="rfc" id="rfc" type="text" value="{$post.rfc}" size="10"/></div>
          <div style="clear:both"></div>
 					<hr />
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:15%;float:left">Correo Electr&oacute;nico:</div>
         <div style="width:15%;float:left"><input name="email" id="email" type="text" value="{$post.email}" size="12"/></div>
          <div style="width:15%;float:left">Password:</div> 
          <div style="width:15%;float:left"><input name="password" id="password" type="password" /></div>
          <div style="clear:both"></div>
 					<hr />
       
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:15%;float:left">Producto Contratado:</div>
         <div style="width:15%;float:left">	
         	<select name="productId" id="productId">
         	{foreach from=$productos item=producto}
          <option value="{$producto.productId}">{$producto.name}</option> <br />
          {/foreach}
          </select></div>
          <div style="clear:both"></div>
 					<hr />
       
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:15%;float:left">Socio: (Si no sabes, marca "Ninguno")</div>
         <div style="width:15%;float:left">	
         	<select name="socioId" id="socioId">
         	{foreach from=$socios item=socio}
          <option value="{$socio.socioId}">{$socio.nombre}</option> <br />
          {/foreach}
          </select></div>
          <div style="clear:both"></div>
 					<hr />
       
      </div>

      <div class="formLine" style="width:100%; text-align:left">
        <div style="width:15%;float:left">E-Mail del Proveedor: (Si no sabes, deja en blanco)</div>
         <div style="width:15%;float:left"><input name="proveedorId" id="proveedorId" type="text" value="{$post.proveedorId}" size="12"/>
         <div style="position:relative">
         		<div style="display:none;position:absolute;top:-20; z-index:100" id="suggestionDiv">
        	 	</div>
         </div>

         </div>
          <div style="clear:both"></div>
 					<hr />
       
      </div>

      <div style="clear:both"></div>
			<hr />
			</div>
     	<div class="formLine" style="text-align:center">
      	<input type="button" id="register" name="register" class="buttonForm" value="Registrarte!" />
     	</div>
         
  	</fieldset>
	</form>
</div>

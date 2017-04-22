<div id="divForm">
	<form id="editarClienteForm" name="editarClienteForm" method="post">
    <fieldset>
    
			<div class="a">
            	<div class="l">Nombre Completo o Raz&oacute;n Social*:</div>
                <div class="r"><input type="text" name="razonSocial" id="razonSocial" class="largeInput wide2" value="{$post.nombre}">
              </div>
            </div>

			<div class="a">
            	<div class="l">Direcci&oacute;n*:</div>
                <div class="r"><input type="text" name="calle" id="calle" class="largeInput wide2" value="{$post.calle}">
              </div>
            </div>

					<div class="a">
            	<div class="l">No Exterior*:</div>
                <div class="r"><input type="text" name="noExt" id="noExt" class="largeInput wide2" value="{$post.noExt}">
              </div>
            </div>

					<div class="a">
            	<div class="l">No Interior:</div>
                <div class="r"><input type="text" name="noInt" id="noInt" class="largeInput wide2" value="{$post.noInt}">
              </div>
            </div>

					<div class="a">
            	<div class="l">Referencia:</div>
                <div class="r"><input type="text" name="referencia" id="referencia" class="largeInput wide2" value="{$post.referencia}">
              </div>
            </div>

					<div class="a">
            	<div class="l">Colonia:</div>
                <div class="r"><input type="text" name="colonia" id="colonia" class="largeInput wide2" value="{$post.colonia}">
              </div>
            </div>

					<div class="a">
            	<div class="l">Localidad*:</div>
                <div class="r"><input type="text" name="localidad" id="localidad" class="largeInput wide2" value="{$post.localidad}">
              </div>
            </div>

					<div class="a">
            	<div class="l">Municipio o Delegación:</div>
                <div class="r"><input type="text" name="municipio" id="municipio" class="largeInput wide2" value="{$post.municipio}">
              </div>
            </div>

					<div class="a">
            	<div class="l">Ciudad o Delegación:</div>
                <div class="r"><input type="text" name="ciudad" id="ciudad" class="largeInput wide2" value="{$post.ciudad}">
              </div>
            </div>

						<div class="a">
            	<div class="l">Código Postal:</div>
                <div class="r"><input type="text" name="cp" id="cp" class="largeInput wide2" value="{$post.cp}">
              </div>
            </div>

						<div class="a">
            	<div class="l">Estado:</div>
                <div class="r"><input type="text" name="estado" id="estado" class="largeInput wide2" value="{$post.estado}">
              </div>
            </div>

						<div class="a">
            	<div class="l">Pa&iacute;s*:</div>
                <div class="r"><input type="text" name="pais" id="pais" class="largeInput wide2" value="{$post.pais}">
              </div>
            </div>

						<div class="a">
            	<div class="l">Tel&eacute;fono:</div>
                <div class="r"><input type="text" name="telefono" id="telefono" class="largeInput wide2" value="{$post.telefono}">
              </div>
            </div>
    

						<div class="a">
            	<div class="l">RFC y Homoclave*:</div>
                <div class="r"><input type="text" name="rfc" id="rfc" class="largeInput wide2" value="{$post.rfc}">
              </div>
            </div>

						<div class="a">
            	<div class="l">Correo Electrónico*:</div>
                <div class="r"><input type="text" name="email" id="email" class="largeInput wide2" value="{$post.email}">
              </div>
            </div>

						<div class="a">
            	<div class="l">Password (Dejar vació para no cambiar):</div>
                <div class="r"><input type="password" name="password" id="password" class="largeInput wide2" value="">
              </div>
            </div>
    
      <div style="clear:both"></div>
			<hr />
     	<div class="formLine" style="text-align:center">
      	<a class="button" id="editarCliente" name="editarCliente"><span>Editar Cliente</span></a>
     	</div>
        <input type="hidden" id="type" name="type" value="saveEditCliente"/>
        <input type="hidden" id="userId" name="userId" value="{$post.userId}"/>
  	</fieldset>
	</form>
</div>

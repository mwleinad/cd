<div id="divForm">
	<form id="editarClienteForm" name="editarClienteForm" method="post">
    <fieldset>
    
			<div class="a">
            	<div class="l">* Nombre Completo o Raz&oacute;n Social:</div>
                <div class="r"><input type="text" name="razonSocial" autofocus id="razonSocial" class="largeInput wide2" value="{$post.nombre}" >
              </div>
            </div>
            
						<div class="a">
            	<div class="l">* RFC con Homoclave:</div>
                <div class="r"><input type="text" name="rfc" id="rfc" class="largeInput wide2" value="{$post.rfc}" tabindex="2">
              </div>
            </div>
            

			<div class="a">
            	<div class="l">* Direcci&oacute;n:</div>
                <div class="r"><input type="text" name="calle" id="calle" class="largeInput wide2" value="{$post.calle}" tabindex="1">
              </div>
            </div>

					<div class="a">
            	<div class="l">* No. Exterior:</div>
                <div class="r"><input type="text" name="noExt" id="noExt" class="largeInput wide2" value="{$post.noExt}" tabindex="2">
              </div>
            </div>

					<div class="a">
            	<div class="l">No. Interior:</div>
                <div class="r"><input type="text" name="noInt" id="noInt" class="largeInput wide2" value="{$post.noInt}" tabindex="3">
              </div>
            </div>

					<div class="a">
            	<div class="l">Referencia:</div>
                <div class="r"><input type="text" name="referencia" id="referencia" class="largeInput wide2" value="{$post.referencia}"  tabindex="4">
              </div>
            </div>

					<div class="a">
            	<div class="l">* Colonia:</div>
                <div class="r"><input type="text" name="colonia" id="colonia" class="largeInput wide2" value="{$post.colonia}" tabindex="5">
              </div>
            </div>

					<div class="a">
            	<div class="l">* Localidad:</div>
                <div class="r"><input type="text" name="localidad" id="localidad" class="largeInput wide2" value="{$post.localidad}"  tabindex="6">
              </div>
            </div>

			<div class="a">
            	<div class="l">Ciudad o Delegaci&oacute;n:</div>
                <div class="r"><input type="text" name="ciudad" id="ciudad" class="largeInput wide2" value="{$post.ciudad}"  tabindex="7">
              </div>
            </div>
					<div class="a">
            	<div class="l">* Municipio o Delegaci&oacute;n:</div>
                <div class="r"><input type="text" name="municipio" id="municipio" class="largeInput wide2" value="{$post.municipio}" tabindex="8">
              </div>
            </div>				

						<div class="a">
            	<div class="l">* C&oacute;digo Postal:</div>
                <div class="r"><input type="text" name="cp" id="cp" class="largeInput wide2" value="{$post.cp}" tabindex="9">
              </div>
            </div>

						<div class="a">
            	<div class="l">* Estado:</div>
                <div class="r"><input type="text" name="estado" id="estado" class="largeInput wide2" value="{$post.estado}" tabindex="10">
              </div>
            </div>

						<div class="a">
            	<div class="l">* Pa&iacute;s:</div>
                <div class="r"><input type="text" name="pais" id="pais" class="largeInput wide2" value="{$post.pais}" tabindex="11">
              </div>
            </div>

						<div class="a">
            	<div class="l">Tel&eacute;fono:</div>
                <div class="r"><input type="text" name="telefono" id="telefono" class="largeInput wide2" value="{$post.telefono}"  tabindex="12">
              </div>
            </div>
    


						{if $info.moduloEscuela == "Si"}
						<div class="a">
            	<div class="l">* # Control:</div>
                <div class="r"><input type="text" name="noControl" id="noControl" class="largeInput wide2" tabindex="14" value="{$post.noControl}">
              </div>
            </div>

						<div class="a">
            	<div class="l">* Carrera:</div>
                <div class="r">
                <select name="carrera" id="carrera" class="largeInput">
									<option value="No Aplica" {if $post.carrera == "No Aplica"} selected="selected"{/if}>No Aplica</option>
                  <option value="Ing. Industrial" {if $post.carrera == "Ing. Industrial"} selected="selected"{/if}>Ing. Industrial</option>
                	<option value="Ing. Industrias Alimentarias" {if $post.carrera == "Ing. Industrias Alimentarias"} selected="selected"{/if}>Ing. Industrias Alimentarias</option>
                	<option value="Ing. Desarrollo Comunitario" {if $post.carrera == "Ing. Desarrollo Comunitario"} selected="selected"{/if}>Ing. Desarrollo Comunitario</option>
                	<option value="Ing. Informatica" {if $post.carrera == "Ing. Informatica"} selected="selected"{/if}>Ing. Informatica</option>
                	<option value="Ing. Energias Renovables" {if $post.carrera == "Ing. Energias Renovables"} selected="selected"{/if}>Ing. Energias Renovables</option>
                	<option value="Ing. Civil" {if $post.carrera == "Ing. Civil"} selected="selected"{/if}>Ing. Civil</option>
                </select>
              </div>
            </div>
            
            {/if}

						<div class="a">
            	<div class="l">* Correo Electr&oacute;nico Facturacion:</div>
                <div class="r"><input type="text" name="email" id="email" class="largeInput wide2" value="{$post.email}"  tabindex="16">
              </div>
            </div>

						<div class="a">
            	<div class="l">* Correo Electr&oacute;nico Directivo:</div>
                <div class="r"><input type="text" name="emailDirector" id="emailDirector" class="largeInput wide2" value="{$post.emailDirector}"  tabindex="16">
              </div>
            </div>

						<div class="a">
            	<div class="l">* Correo Electr&oacute;nico Administrativo:</div>
                <div class="r"><input type="text" name="emailAdmin" id="emailAdmin" class="largeInput wide2" value="{$post.emailAdmin}"  tabindex="16">
              </div>
            </div>

						<div class="a">
            	<div class="l">Contrase&ntilde;a de acceso al sistema (Dejar vació para no cambiar):</div>
                <div class="r"><input type="password" name="password" id="password" class="largeInput wide2" value=""  tabindex="15">
              </div>
            </div>
    
      	<div style="clear:both"></div>
		<hr />
        <div>* Campos requeridos.</div>
     	<div class="formLine" style="text-align:center; margin-left:280px">
      	<a class="button" id="editarCliente" name="editarCliente"  tabindex="16"><span>Actualizar</span></a>
     	</div>
        <input type="hidden" id="type" name="type" value="saveEditCliente"/>
        <input type="hidden" id="userId" name="userId" value="{$post.userId}"/>
  	</fieldset>
	</form>
</div>

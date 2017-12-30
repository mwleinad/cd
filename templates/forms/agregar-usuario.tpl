<div id="divForm">
	<form id="agregarUsuarioForm" name="agregarUsuarioForm" method="post">
    <fieldset>
       	<div class="formLine">
        	<div style="width:30%;float:left">* Nombre Completo:</div> 
            <input name="nombreCompleto" id="nombreCompleto" type="text" size="30" class="largeInput wide2" value="{$post.nombreCompleto}"/>
            
        	<div style="width:30%;float:left">* Tipo:</div>
			<select name="tipoUsuario" id="tipoUsuario" class="largeInput wide2" onchange="CheckTipoUser()">
				<option value="">Seleccione</option>
   				{foreach from=$tipoUsuario item=tipo key=key}
					<option value="{$tipo}">{$tipo|capitalize}</option>
  				{/foreach}
 			</select>
          	<div style="width:30%;float:left">Email:</div> 
            <input name="email" id="email" type="text" size="30" class="largeInput wide2"/>          	
            <div style="width:30%;float:left">Sucursal:</div>
			<select name="sucursalId" id="sucursalId" class="largeInput wide2">
				<option value="">Todas</option>
   				{foreach from=$sucursales item=sucursal key=key}
					<option value="{$sucursal.sucursalId}">{$sucursal.identificador|urldecode}</option>
  				{/foreach}
 			</select>
             <br />
             
             <div id="divPermisos" style="display:none">
             
             <div style="width:30%;float:left">Contrase&ntilde;a:</div> 
            <input name="password" id="password" type="text"  size="30" class="largeInput wide2"/>
                          
             <div>Permisos:</div>
             <table width="100%">
             	<tr>
                	<th></th>
                    <th>Ver</th>
                    <th>Crear</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
             {foreach from=$modulos item=item key=key}
             	<tr>
                	<td><input type="checkbox" id="permisos[]" name="permisos[]" value="{$key}" >{$item}</td>
                    <td><input type="checkbox" value="view" name="row_{$key}[]" id="row_{$key}[]" /></td>
                    <td><input type="checkbox" value="create" name="row_{$key}[]" id="row_{$key}[]"  /></td>
                    <td><input type="checkbox" value="edit" name="row_{$key}[]" id="row_{$key}[]"  /></td>
                    <td><input type="checkbox" value="delete" name="row_{$key}[]" id="row_{$key}[]"  /></td>
                </tr>
             {/foreach}
             </table>
                          
			</div> <!-- divPermisos -->
            
            <div id="divEmpleado" style="display:none">

                <div style="width:30%;float:left">* N&uacute;mero de Empleado:</div>
                <input name="numEmpleado" id="numEmpleado" type="text" size="30" class="largeInput wide2" value="{$post.numEmpleado}"/>

                <div style="width:30%;float:left">* CURP:</div>
                <input name="curp" id="curp" type="text" size="30" class="largeInput wide2" value="{$post.curp}" maxlength="18"/>

                <div style="width:30%;float:left">* Tipo de R&eacute;gimen:</div>
                <select name="tipoRegimen" id="tipoRegimen"  class="largeInput wide2">
                    {foreach from=$tiposRegimen item=item}
                        <option value="{$item.claveRegimen}" {if $post.tipoRegimen == $item.claveRegimen} selected="selected"{/if}>{$item.nombreRegimen}</option>
                    {/foreach}
                </select>
                <br />

                <div style="width:30%;float:left">Registro Patronal:</div>
                <input name="registroPatronal" id="registroPatronal" type="text" size="30" class="largeInput wide2" value="{$post.registroPatronal}"/>

                <div style="width:30%;float:left">N&uacute;mero de Seguridad Social:</div>
                <input name="numSeguridadSocial" id="numSeguridadSocial" type="text" size="30" class="largeInput wide2" value="{$post.numSeguridadSocial}"/>

                <div style="width:30%;float:left">Departamento:</div>
                <input name="departamento" id="departamento" type="text" size="30" class="largeInput wide2" value="{$post.departamento}"/>

                <div style="width:30%;float:left">Cuenta Bancaria:</div>
                <input name="clabe" id="clabe" type="text" size="30" class="largeInput wide2" value="{$post.clabe}"/>

                <div style="width:30%;float:left">* Banco (Si el banco no aparece favor de solicitarlo):</div>
                <select name="banco" id="banco"  class="largeInput wide2">
                    {foreach from=$bancos item=item}
                        <option value="{$item.claveBanco}" {if $post.banco == $item.claveBanco} selected="selected"{/if}>{$item.nombreBanco}</option>
                    {/foreach}
                </select>

                <div style="width:30%;float:left">Fecha Inicio Relaci&oacute;n Laboral:
                    <div style="position:relative; top:20px; left:550px">
                        <a style="" href="javascript:NewCal('fechaInicioRelLaboral','ddmmyyyy')"><img src="{$WEB_ROOT}/images/cal.gif" width="16" height="16" border="0" alt="Selecciona una Fecha diferente"></a><br />
                    </div>
                </div> <input name="fechaInicioRelLaboral" id="fechaInicioRelLaboral" type="text" size="30" class="largeInput wide2" value="{$post.fechaInicioRelLaboral}" maxlength="12"/>


                <div style="width:30%;float:left">Puesto:</div>
                <input name="puesto" id="puesto" type="text" size="30" class="largeInput wide2" value="{$post.puesto}"/>

                <div style="width:30%;float:left">Tipo Contrato:</div>
                <select name="tipoContrato" id="tipoContrato"  class="largeInput wide2">
                    {foreach from=$contratos item=item}
                        <option value="{$item.claveTipoContrato}" {if $post.tipoContrato == $item.claveTipoContrato} selected="selected"{/if}>{$item.nombreTipoContrato}</option>
                    {/foreach}
                </select>

                <div style="width:30%;float:left">Tipo Jornada:</div>
                <select name="tipoJornada" id="tipoJornada"  class="largeInput wide2">
                    {foreach from=$tipoJornada item=item}
                        <option value="{$item.c_TipoJornada}" {if $post.tipoJornada == $item.c_TipoJornada} selected="selected"{/if}>{$item.descripcion}</option>
                    {/foreach}
                </select>

                <div style="width:30%;float:left">Periodicidad Pago:</div>
                <select name="periodicidadPago" id="periodicidadPago"  class="largeInput wide2">
                    {foreach from=$periodicidadPagos item=item}
                        <option value="{$item.clavePeriodicidadPago}" {if $post.periodicidadPago == $item.clavePeriodicidadPago} selected="selected"{/if}>{$item.nombrePeriodicidadPago}</option>
                    {/foreach}
                </select>

                <div style="width:30%;float:left">Salario Base:</div>
                <input name="salarioBaseCotApor" id="salarioBaseCotApor" type="text" size="30" class="largeInput wide2" value="{$post.salarioBaseCotApor}"/>

                <div style="width:30%;float:left">Riesgo:</div>
                <select name="riesgoPuesto" id="riesgoPuesto"  class="largeInput wide2">
                    {foreach from=$riesgos item=item}
                        <option value="{$item.riesgoClave}" {if $post.riesgoPuesto == $item.riesgoClave} selected="selected"{/if}>{$item.riesgoNombre}</option>
                    {/foreach}
                </select>


                <div style="width:30%;float:left">Salario Diario Integrado:</div>
                <input name="salarioDiarioIntegrado" id="salarioDiarioIntegrado" type="text" size="30" class="largeInput wide2" value="{$post.salarioDiarioIntegrado}"/>

                <div style="width:30%;float:left">* RFC</div>
                <input name="rfc" id="rfc" type="text" size="30" class="largeInput wide2" value="{$post.rfc}"/>

                <div style="width:30%;float:left">* Calle:</div>
                <input name="calle" id="calle" type="text" size="30" class="largeInput wide2" value="{$post.calle}"/>

                <div style="width:30%;float:left">* No. Ext:</div>
                <input name="noExt" id="noExt" type="text" size="30" class="largeInput wide2" value="{$post.noExt}"/>

                <div style="width:30%;float:left">No. Int:</div>
                <input name="noInt" id="noInt" type="text" size="30" class="largeInput wide2" value="{$post.noInt}"/>

                <div style="width:30%;float:left">* Colonia:</div>
                <input name="colonia" id="colonia" type="text" size="30" class="largeInput wide2" value="{$post.colonia}"/>

                <div style="width:30%;float:left">* Municipio:</div>
                <input name="municipio" id="municipio" type="text" size="30" class="largeInput wide2" value="{$post.municipio}"/><br />

                <div style="width:30%;float:left">* C&oacute;digo Postal:</div>
                <input name="cp" id="cp" type="text" size="30" class="largeInput wide2" value="{$post.cp}"/>

                <div style="width:30%;float:left">* Estado:</div>
                <select name="estado" id="estado"  class="largeInput wide2">
                    {foreach from=$estados item=item}
                        <option value="{$item.claveEstado}" {if $post.estado == $item.claveEstado} selected="selected"{/if}>{$item.nombreEstado}</option>
                    {/foreach}
                </select>

                <div style="width:30%;float:left">* Pa&iacute;s</div>
                <input name="pais" id="pais" type="text" size="30" class="largeInput wide2" value="{$post.pais}"/>
			
            </div> <!-- divEmpleado -->
            
       	<div style="clear:both"></div>
		<hr />
     	<div class="formLine" style="margin-left:300px">
        <a class="button" id="agregarUsuario" name="agregarUsuario"><span>Agregar</span></a>
        <input type="hidden" name="type" value="saveUsuario" />
     	</div>
	</fieldset>
	</form>
</div>

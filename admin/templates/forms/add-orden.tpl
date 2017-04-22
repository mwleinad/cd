<div id="divForm">
	<form id="addOrdenForm" name="addOrdenForm" method="post">
		<fieldset>
	{*}{if $roleId==1}
    	<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Socios :</div>
        <select  name="idSocio" id="idSocio" style="width:150px">
        {foreach from=$usuarios item=socio}
        	<option value="{$socio.idUsuario}">{$socio.nombre}</option>
         {/foreach} 
       	</select>
        
			</div>
	 {else}
    <input type="hidden" name="idUsuario" id="idUsuario" value="{$idUsuario}">	 
			
	 {/if}{*}
			<div class="formLine" style="width:100%; text-align:left">
		<div style="width:30%;float:left">Empresa:</div>
        <select  name="idEmpresa" id="idEmpresa" style="width:300px">
        {foreach from=$resOrden item=orden}
			{if $orden!='Corporativo' || $roleId==1}		   
		 	 <option value="{$orden.empresaId}">{$orden.razonSocial}</option>
			{/if}
			
		{foreachelse}
		   <option >No hay ninguna empresa asigna a usted</option>
		 {/foreach} 
       	</select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				{if $resOrden|count>0}<input type="button" id="addOrden" name="addOrden" class="buttonForm" value="Agregar" />{/if}
			</div>
			<input type="hidden" id="type" name="type" value="saveAddOrden"/>
			<input type="hidden" id="type" name="type" value="saveAddOrden"/>
			<input type="hidden" id="idOrden" name="idOrden" value="{$post.idOrden}"/>
		</fieldset>
	</form>
</div>

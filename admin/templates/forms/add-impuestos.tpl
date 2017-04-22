<div id="divForm">
	<form id="addVentasForm" name="addVentasForm" method="post">
		<fieldset>
	 
	 {foreach from=$datos item=item}
	    <div class="formLine" style="width:100%; text-align:left">
		      
		<div style="width:30%;float:left">Folios Disponibles: </div>{$item.restantes}
		{assign var="disponibles" value="{$item.restantes}"} 
		 </div>
	  {/foreach}
			<div class="formLine" style="width:100%; text-align:left">

		
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Empresa:</div>
        <select  name="idEmpresa" id="idEmpresa" style="width:300px">
        {foreach from=$resOrden item=orden}
        	<option value="{$orden.empresaId}">{$orden.razonSocial}</option>
         {foreachelse} 
		 <option >No hay empresas asignadas a usted</option>
		  {/foreach} 
       	</select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				{if $resOrden|count>0}<input type="button" id="addVentas" name="addVentas" class="buttonForm" value="Agregar" />{/if}
			</div>
			<input type="hidden" id="type" name="type" value="saveAddVentas"/>
			<input type="hidden" id="disponibles" name="disponibles" value="{$disponibles}"/>
			<input type="hidden" id="idVenta" name="idVenta" value="{$post.idVenta}"/>
		</fieldset>
	</form>
</div>

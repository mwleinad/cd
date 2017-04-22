<div id="divForm">
	<form id="addAdqFoliosForm" name="addAdqFoliosForm" method="post">
		<fieldset>
			
			
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Paquete:</div>
				  <select id="paqFoliosId" name="paqFoliosId">
				  <option value="0">Selecciona paquete a adquirir</option>
				    {foreach from=$paquetes item=item}
					   <option value="{$item.paqFoliosId}"> {$item.nombre} &nbsp; &nbsp; &nbsp; {$item.cantidad} Folios&nbsp; &nbsp; &nbsp; ${$item.monto}</option>
					{/foreach}
				  </select>
				
			</div>
					
		
			
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="adquisicionAdd" name="adquisicionAdd" class="buttonForm" value="Adquirir Folios" />
			</div>
			<input type="hidden" id="type" name="type" value="adquisicionAdd"/>
			<input type="hidden" id="usuarioId" name="usuarioId" value="{$post.idUsuario}"/>
			
		</fieldset>
	</form>
</div>

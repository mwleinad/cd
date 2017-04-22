<div id="divForm">
	<form id="editVentasForm" name="editVentasForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Status:</div>
       <select  name="status" id="status">
       <option value="pagado">Activo</option>
       <option value="noPagado">No Activo</option>
       <option value="cancelado">Cancelado</option>
      
       </select>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editVentas" name="editVentas" class="buttonForm" value="Actualizar" />
			</div>
			<input type="hidden" id="type" name="type" value="saveEditVentas"/>
			<input type="hidden" id="idVenta" name="idVenta" value="{$post.idVenta}"/>
		</fieldset>
	</form>
</div>

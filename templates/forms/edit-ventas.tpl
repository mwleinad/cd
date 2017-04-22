<div id="divForm">
	<form id="editVentasForm" name="editVentasForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Cantidad:</div><input name="cantidad" id="cantidad" type="text" value="{$post.cantidad}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Fecha:</div><input name="fecha" id="fecha" type="text" value="{$post.fecha}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">IdSocio:</div><input name="idSocio" id="idSocio" type="text" value="{$post.idSocio}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Status:</div><input name="status" id="status" type="text" value="{$post.status}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">IdEmpresa:</div><input name="idEmpresa" id="idEmpresa" type="text" value="{$post.idEmpresa}" size="50"/>
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

<div id="divForm">
	<form id="editPaqFoliosForm" name="editPaqFoliosForm" method="post">
		<fieldset>
		<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Descripci&oacute;n del Paquete:</div><input value="{$info.nombre}" name="nombre" id="nombre" type="text"  size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Cantidad de Folios:</div><input maxlength="4" value="{$info.cantidad}" onkeypress="return isNumberKey(event)" name="cantidad" id="cantidad" type="text"  size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Costo del Paquete:</div><input name="monto"  value="{$info.monto}" onkeypress="return validateFloatKeyPress(this,event,4,6)" id="monto" type="text"  size="50"/>
			</div>
			
		<input type="hidden" id="paqFoliosId" name="paqFoliosId" value="{$info.paqFoliosId}">
			
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editPaqFolios" name="editPaqFolios" class="buttonForm" value="Actualizar Paquete" />
			</div>
			<input type="hidden" id="type" name="type" value="saveEditPaqFolios"/>
			
		</fieldset>
	</form>
</div>

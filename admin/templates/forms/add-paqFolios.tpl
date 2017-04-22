<div id="divForm">
	<form id="addPaqFoliosForm" name="addPaqFoliosForm" method="post">
		<fieldset>
		<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Descripci&oacute;n del Paquete:</div><input  name="nombre" id="nombre" type="text"  size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Cantidad de Folios:</div><input maxlength="4" onkeypress="return isNumberKey(event)" name="cantidad" id="cantidad" type="text"  size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Costo del Paquete:</div><input name="monto" onkeypress="return validateFloatKeyPress(this,event,4,6)" id="monto" type="text"  size="50"/>
			</div>
			
		
			
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="addPaqFolios" name="addPaqFolios" class="buttonForm" value="Agregar Paquete Folios" />
			</div>
			<input type="hidden" id="type" name="type" value="saveAddPaqFolios"/>
			
		</fieldset>
	</form>
</div>

<div id="divForm">
	<form id="addFolios" name="addFolios" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Num. de Folios:</div><input name="cantidad" id="cantidad" type="text" value="" size="50"/>
				<div style="width:30%;float:left">Status:</div><input name="status" id="status" type="text" value="" size="50"/>
			</div>
			<div class="formLine" style="text-align:center">
				<input type="button" id="guardarFolios" name="guardarFolios" class="buttonForm" value="Agregar Folios" />
			</div>
			<input type="hidden" id="type" name="type" value="saveAddFolios"/>
			<input type="hidden" id="id" name="id" value="{$data.empresaId}"/>
		</fieldset>
	</form>
</div>

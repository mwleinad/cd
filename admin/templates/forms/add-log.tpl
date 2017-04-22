<div id="divForm">
	<form id="addLog" name="addLog" method="post">
			<input type="hidden" id="id" name="id" value="{$empresaId}"/>
			<input type="hidden" id="type" name="type" value="saveAddLog"/>
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Descripci&oacute;n:</div><textarea name="log" id="log" type="text"></textarea>
			</div>
			<div class="formLine" style="text-align:center">
				<input type="button" id="guardarFolios" name="guardarFolios" class="buttonForm" value="Agregar Log" />
			</div>
		</fieldset>
	</form>
</div>

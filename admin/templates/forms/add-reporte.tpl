<div id="divForm">
	<form id="addReporteForm" name="addReporteForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Date:</div><input name="date" id="date" type="text" value="{$post.date}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Data:</div><input name="data" id="data" type="text" value="{$post.data}" size="50"/>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="addReporte" name="addReporte" class="buttonForm" value="Agregar" />
			</div>
			<input type="hidden" id="type" name="type" value="saveAddReporte"/>
			<input type="hidden" id="idReporte" name="idReporte" value="{$post.idReporte}"/>
		</fieldset>
	</form>
</div>

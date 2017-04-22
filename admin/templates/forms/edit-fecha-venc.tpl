<div id="divForm">
	<form id="frmFechaVenc" name="frmFechaVenc" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Fecha de Vencimiento:</div>
                 <input type="text" name="fechaVenc" id="fechaVenc" value="{$info.vencimiento}" class="smallInput">
			</div>
            <br />
            <div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Limite de Folios:</div>
                 <input type="text" name="limiteFolios" id="limiteFolios" value="{$info.limite}" class="smallInput">
			</div>
			

			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" class="buttonForm" value="Actualizar" onclick="SaveFechaVenc()" />
			</div>
			<input type="hidden" id="type" name="type" value="saveFechaVenc"/>
			<input type="hidden" id="empresaId" name="empresaId" value="{$info.empresaId}"/>
		</fieldset>
	</form>
</div>

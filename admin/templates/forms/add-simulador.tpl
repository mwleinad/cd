<div id="divForm">
	<form id="addSimuladorForm" name="addSimuladorForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">SueldoMensual:</div><input name="sueldoMensual" id="sueldoMensual" type="text" value="{$post.sueldoMensual}" size="50"/>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Tipo DeNomina:</div><select name="tipoDeNomina" id="tipoDeNomina">
        <option value="semanal">Semanal</option>
        <option value="quincenal">Quincenal</option>
        </select>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Monto solicitado:</div><input name="montoAFinanciar" id="montoAFinanciar" type="text" value="{$post.montoAFinanciar}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">% Tasa de inter&eacute;s:</div><input name="tasa" id="tasa" type="text" value="4" size="5"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Tus descuentos serian de:</div><input name="descuento" id="descuento" type="text" value="{$post.descuento}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Tu pago es de:</div><input name="pago" id="pago" type="text" value="{$post.pago}" size="50"/> semanas
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="addSimulador2" name="addSimulador2" class="buttonForm" value="Simular" />
			</div>
			<input type="hidden" id="type" name="type" value="saveAddSimulador"/>
			<input type="hidden" id="idSimulador" name="idSimulador" value="{$post.idSimulador}"/>
		</fieldset>
	</form>
</div>

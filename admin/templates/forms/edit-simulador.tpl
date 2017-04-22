<div id="divForm">
	<form id="editSimuladorForm" name="editSimuladorForm" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">MontoAFinanciar:</div><input name="montoAFinanciar" id="montoAFinanciar" type="text" value="{$post.montoAFinanciar}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Tasa:</div><input name="tasa" id="tasa" type="text" value="{$post.tasa}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">IvaTasa:</div><input name="ivaTasa" id="ivaTasa" type="text" value="{$post.ivaTasa}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">TotalTasa:</div><input name="totalTasa" id="totalTasa" type="text" value="{$post.totalTasa}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">CuotaApertura:</div><input name="cuotaApertura" id="cuotaApertura" type="text" value="{$post.cuotaApertura}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">IvaCuota:</div><input name="ivaCuota" id="ivaCuota" type="text" value="{$post.ivaCuota}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">TotalCoutaApertura:</div><input name="totalCoutaApertura" id="totalCoutaApertura" type="text" value="{$post.totalCoutaApertura}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">TipoDeNomina:</div><input name="tipoDeNomina" id="tipoDeNomina" type="text" value="{$post.tipoDeNomina}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Descuento:</div><input name="descuento" id="descuento" type="text" value="{$post.descuento}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Pago:</div><input name="pago" id="pago" type="text" value="{$post.pago}" size="50"/>
			</div>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">SueldoMensual:</div><input name="sueldoMensual" id="sueldoMensual" type="text" value="{$post.sueldoMensual}" size="50"/>
			</div>
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editSimulador" name="editSimulador" class="buttonForm" value="Editar Simulador" />
			</div>
			<input type="hidden" id="type" name="type" value="saveEditSimulador"/>
			<input type="hidden" id="idSimulador" name="idSimulador" value="{$post.idSimulador}"/>
		</fieldset>
	</form>
</div>

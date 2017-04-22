<div id="divForm">
	<form id="frmPriceEdit" name="frmPriceEdit" method="post">
		<fieldset>
			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Activar Modulo Impuestos:</div>
        	<select name="moduloImpuestos" id="moduloImpuestos">
          	<option value="Si" {if $info.moduloImpuestos == "Si"} selected="selected"{/if}>Si</option>
          	<option value="No" {if $info.moduloImpuestos == "No"} selected="selected"{/if}>No</option>
          </select>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Vigencia Modulo Impuestos:</div>
                 <input type="text" name="costoModuloImpuestos" id="costoModuloImpuestos" value="{$info.venImpuestos|date_format:"%d-%m-%Y"}" onclick="NewCal('costoModuloImpuestos','ddmmyyyy')">
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Activar Modulo Nomina:</div>
        	<select name="moduloNomina" id="moduloNomina">
          	<option value="Si" {if $info.moduloNomina == "Si"} selected="selected"{/if}>Si</option>
          	<option value="No" {if $info.moduloNomina == "No"} selected="selected"{/if}>No</option>
          </select>
			</div>

			<div class="formLine" style="width:100%; text-align:left">
				<div style="width:30%;float:left">Vigencia Modulo Nomina:</div>
                 <input type="text" name="costoModuloNomina" id="costoModuloNomina" value="{$info.venNomina|date_format:"%d-%m-%Y"}" onclick="NewCal('costoModuloNomina','ddmmyyyy')">
			</div>

			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<input type="button" id="editPrice" name="editPrice" class="buttonForm" value="Actualizar" />
			</div>
			<input type="hidden" id="type" name="type" value="changePriceSave"/>
			<input type="hidden" id="empresaId" name="empresaId" value="{$empresaId}"/>
		</fieldset>
	</form>
</div>

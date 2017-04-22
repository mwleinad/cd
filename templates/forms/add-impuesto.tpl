<div id="divForm">
	<form id="addImpuestoForm" name="addImpuestoForm" method="post">
  <input type="hidden" id="type" name="type" value="saveAddImpuesto"/>
		<fieldset>
			<div class="a">
            	<div class="l">* Nombre:</div>
                <div class="r"><input type="text" name="nombre" id="nombre" value="{$post.nombre}" class="largeInput wide2">
              </div>
            </div>

			<div class="a">
            	<div class="l">* Tasa:</div>
                <div class="r"><input type="text" name="tasa" id="tasa" value="{$post.tasa}" class="largeInput wide2">
              </div>
            </div>

			<div class="a">
            	<div class="l">* Tipo:</div>
                <div class="r">
                <select name="tipo" id="" class="largeInput wide2">
        		<option value="retencion">Retenci&oacute;n</option>
        		<option value="deduccion">Deducci&oacute;n</option>
        		<option value="impuesto">Impuesto</option>
        		<option value="amortizacion">Amortizaci&oacute;n</option>
        		</select>
              </div>
            </div>
                
			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center; margin-left:250px">
				<a class="button" id="addImpuesto" name="addImpuesto"><span>Agregar Impuesto</span></a></div>
			</div>
			
			<input type="hidden" id="impuestoId" name="impuestoId" value="{$post.impuestoId}"/>
		</fieldset>
	</form>
</div>

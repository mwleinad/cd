<div id="divForm">
	<form id="editImpuestoForm" name="editImpuestoForm" method="post">
		<fieldset>
						<div class="a">
            	<div class="l">Nombre*:</div>
                <div class="r"><input type="text" name="nombre" id="nombre" value="{$post.nombre}" class="largeInput wide2">
              </div>
            </div>

						<div class="a">
            	<div class="l">Tasa*:</div>
                <div class="r"><input type="text" name="tasa" id="tasa" value="{$post.tasa}" class="largeInput wide2">
              </div>
            </div>

						<div class="a">
            	<div class="l">Tipo*:</div>
                <div class="r">
                 <select name="tipo" id="tipo" class="largeInput wide2">
        <option value="retencion" {if $post.tipo == "retencion"} selected="selected"{/if}>Retenci&oacute;n</option>
        <option value="deduccion" {if $post.tipo == "deduccion"} selected="selected"{/if}>Deducci&oacute;n</option>
        <option value="impuesto" {if $post.tipo == "impuesto"} selected="selected"{/if}>Impuesto</option>
        <option value="amortizacion" {if $post.tipo == "amortizacion"} selected="selected"{/if}>Amortizaci&oacute;n</option>
        </select>
              </div>
            </div>

			<div style="clear:both"></div>
			<hr />
			<div class="formLine" style="text-align:center">
				<a class="button" id="editImpuesto" name="editImpuesto"><span>Editar Impuesto</span></a>
			</div>
			<input type="hidden" id="type" name="type" value="saveEditImpuesto"/>
			<input type="hidden" id="impuestoId" name="impuestoId" value="{$post.impuestoId}"/>
		</fieldset>
	</form>
</div>

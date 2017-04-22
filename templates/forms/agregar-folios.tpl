<!-- Form -->
<div id="divForm">     
     <div class="m">
		<form name="frmAgregarFolios" id="frmAgregarFolios" method="post" action="">
		<fieldset>
			<div class="a">
            	<div class="l">Serie:</div>
                <div class="r"><input type="text" name="serie" id="serie" class="largeInput wide2"></div>
            </div>
			<div class="a">
            	<div class="l">* Folio Inicial:</div>
                <div class="r"><input type="text" name="folio_inicial" id="folio_inicial"  class="largeInput wide2"></div>
            </div>
<input type="hidden" name="folio_final" id="folio_final"  class="largeInput wide2" value="999999999">            
{*}			<div class="a">
            	<div class="l">* Numero aprobaci&oacute;n:</div>
                <div class="r"><input type="text" name="no_aprobacion" id="no_aprobacion"  class="largeInput wide2"></div>
            </div>
			<div class="a">
            	<div class="l">* A&ntilde;o aprobaci&oacute;n:</div>
                <div class="r"><input type="text" name="anio_aprobacion" id="anio_aprobacion"  class="largeInput wide2"></div>
            </div>{*}
			<div class="a">
            	<div class="l">* Comprobante:</div>
                <div class="r">
                	<select name="comprobante" id="comprobante"  class="largeInput wide2">
                		<option value="">Seleccione</option>
                        {foreach from=$comprobantes item=com key=key}
                        <option value="{$com.tiposComprobanteId}">{$com.nombre}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="a">
            	<div class="l">* Lugar de expedici&oacute;n:</div>
                <div class="r">
                	<select name="lugar_expedicion" id="lugar_expedicion"  class="largeInput wide2">
                		<option value="">Seleccione</option>
                        {foreach from=$sucursales item=suc key=key}
                        <option value="{$suc.sucursalId}">{$suc.identificador}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="a">
            	<div class="l">* N&uacute;mero de certificado:</div>
                <div class="r">
                	<select name="no_certificado" id="no_certificado"  class="largeInput wide2">
                		<option value="">Seleccione</option>
                        <option value="{$nom_certificado}">{$nom_certificado}</option>
                    </select>
                </div>
            </div>
            <div class="a">
                <div class="l">* Sucursal:</div>
                <div class="r">
                    <select name="sucursalId" id="sucursalId" class="largeInput wide2">
                    <option value="">Seleccione</option>
                    {foreach from=$sucursales item=sucursal key=key}
                        <option value="{$sucursal.sucursalId}">{$sucursal.identificador}</option>
                    {/foreach}
                    </select>
                </div>
			</div>			
            <div style="clear:both"></div>
            <div class="a">
            	<div class="l">* Campos requeridos</div>               
            </div>
            <div style="clear:both"></div>
            <div style="margin-left:280px">            	
                <div class="r" align="center">
                 <a class="button" id="btnGuardarFolios"><span>Guardar</span></a>
                </div>
            </div>
            <div class="a">
            	<div id="txtMsg"></div>
            </div>	
			<div class="a"></div>
		</fieldset>
		</form>
	</div>
</div>     
<!-- End Form -->
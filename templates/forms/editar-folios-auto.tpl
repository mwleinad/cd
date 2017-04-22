<!-- Form -->
     
     <div class="m">
		<form name="frmEditarFolios" id="frmEditarFolios" method="post" action="">
		<fieldset>
			<div class="a">
            	<div class="l">Serie</div>
                <div class="r"><input type="text" name="serie" id="serie" value="{$info.serie}" class="largeInput wide2"></div>
            </div>
			<div class="a">
            	<div class="l">Folio Inicial *</div>
                <div class="r"><input type="text" name="folio_inicial" id="folio_inicial" value="{$info.folioInicial}" class="largeInput wide2"></div>
            </div>
            <div class="a">
            	<div class="l">Folio Final *</div>
                <div class="r"><input type="text" name="folio_final" id="folio_final" value="{$info.folioFinal}" class="largeInput wide2"></div>
            </div>
			<div class="a">
            	<div class="l">Numero aprobaci&oacute;n *</div>
                <div class="r"><input type="text" name="no_aprobacion" id="no_aprobacion" value="{$info.noAprobacion}" class="largeInput wide2"></div>
            </div>
			<div class="a">
            	<div class="l">Fecha dd/mm/YYYY HH:MM:SS*</div>
                <div class="r">
                	<input style="width:30px; float:left" value="{$fecha.0}" type="text" name="fecha_dia" id="fecha_dia" maxlength="2" width="2" class="largeInput wide2">
                	<input style="width:30px; float:left" value="{$fecha.1}" type="text" name="fecha_mes" id="fecha_mes" maxlength="2" width="2" class="largeInput wide2">
                	<input style="width:30px; float:left" value="{$fecha.2}" type="text" name="fecha_anio" id="fecha_anio" maxlength="4" width="2" class="largeInput wide2">&nbsp;
                	<input style="width:30px; float:left" value="{$fecha.3}" type="text" name="fecha_hora" id="fecha_hora" maxlength="2" width="2" class="largeInput wide2">
                	<input style="width:30px; float:left" value="{$fecha.4}" type="text" name="fecha_minuto" id="fecha_minuto" maxlength="2" width="2" class="largeInput wide2">
                	<input style="width:30px; float:left" value="{$fecha.5}" type="text" name="fecha_segundo" id="fecha_segundo" maxlength="2" width="2" class="largeInput wide2">
                 </div>
            </div>
			<div class="a">
            	<div class="l">Comprobante *</div>
                <div class="r">
                	<select name="comprobante" id="comprobante" class="largeInput wide2">
                		<option value="">Seleccione</option>
                        {foreach from=$comprobantes item=com key=key}
                        <option value="{$com.tiposComprobanteId}" {if $info.tiposComprobanteId == $com.tiposComprobanteId} selected {/if}>{$com.nombre}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="a">
            	<div class="l">Lugar de expedicion *</div>
                <div class="r">
                	<select name="lugar_expedicion" id="lugar_expedicion" class="largeInput wide2">
                		<option value="">Seleccione</option>
                        {foreach from=$sucursales item=suc key=key}
                        <option value="{$suc.sucursalId}" {if $info.lugarDeExpedicion == $suc.sucursalId} selected {/if}>{$suc.identificador}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="a">
            	<div class="l">Email de aviso *</div>
                <div class="r"><input type="text" name="email" id="email"  value="{$info.email}" class="largeInput wide2"></div>
            </div>           	
			<div class="a">
            	<div class="l">&nbsp;</div>
                <div class="r">
                <a class="button" id="btnEditarFolios"><span>Guardar Folios</span></a>
            </div>
             <div class="a">
            	<div class="l">* Campos requeridos</div>               
            </div>
            <div class="a">
            	<div id="txtMsg"></div>
            </div>	
			<div class="a"></div>
		</fieldset>
        <input type="hidden" name="id_serie" value="{$info.serieId}" />
		</form>
	</div>
     
<!-- End Form -->
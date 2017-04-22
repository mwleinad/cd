<!-- Form -->
     
     <div class="m">
		<form name="frmEditarFolios" id="frmEditarFolios" method="post" action="">
		<fieldset>
			<div class="a">
            	<div class="l">Serie:</div>
                <div class="r"><input type="text" name="serie" id="serie" value="{$info.serie}" class="largeInput wide2"></div>
            </div>
			<div class="a">
            	<div class="l">* Folio Inicial:</div>
                <div class="r"><input type="text" name="folio_inicial" id="folio_inicial" value="{$info.folioInicial}" class="largeInput wide2" /></div> 
            </div>
<input type="hidden" name="folio_final" id="folio_final"  class="largeInput wide2" value="999999999">

						<div class="a">
            	<div class="l">* Comprobante:</div>
                <div class="r">
                		<select name="comprobante" id="comprobante" class="largeInput wide2">
                		<option value="">Seleccione</option>
                        {foreach from=$comprobantes item=com key=key}
                        <option value="{$com.tiposComprobanteId}" {if $info.tiposComprobanteId == $com.tiposComprobanteId} selected="selected" {/if}>{$com.nombre}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="a">
            	<div class="l">* Lugar de expedici&oacute;n:</div>
                <div class="r">
                	<select name="lugar_expedicion" id="lugar_expedicion" class="largeInput wide2">
                		<option value="">Seleccione</option>
                        {foreach from=$sucursales item=suc key=key}
                        <option value="{$suc.sucursalId}" {if $info.lugarDeExpedicion == $suc.sucursalId} selected="selected" {/if}>{$suc.identificador}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="a">
            	<div class="l">N&uacute;mero de certificado:</div>
                <div class="r">
                	<select name="no_certificado" id="no_certificado" class="largeInput wide2">
                		<option value="">Seleccione</option>
                        <option value="{$nom_certificado}" {if $info.noCertificado == $nom_certificado} selected {/if}>{$nom_certificado}</option>
                    </select>
                </div>
            </div>
{*}            <div class="a">
            	<div class="l">* Email de aviso:</div>
                <div class="r"><input type="text" name="email" id="email"  value="{$info.email}" class="largeInput wide2"></div>
            </div>{*}
            <div class="a">
                <div class="l">* Sucursal:</div>
                <div class="r">
                    <select name="sucursalId" id="sucursalId" class="largeInput wide2">
                    <option value="">Seleccione</option>
                    {foreach from=$sucursales item=sucursal key=key}
                        <option value="{$sucursal.sucursalId}" {if $info.sucursalAsignada == $sucursal.sucursalId} selected="selected" {/if}>{$sucursal.identificador}</option>
                    {/foreach}
                    </select>
                </div>
			</div>   
            
            <div style="clear:both"></div>
            <div class="a">
            	<div class="l">* Campos requeridos</div>               
            </div>
            <div style="clear:both"></div>
            <div style="margin-left:260px">            	
                <div class="r" align="center">
                 <a class="button" id="btnEditarFolios"><span>Actualizar</span></a>
                </div>
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
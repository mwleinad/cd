<div id="divForm">
    <form id="addPaymentForm" name="addPaymentForm" method="post" onSubmit="return false">
    <input type="hidden" id="type" name="type" value="saveAddPayment"/>
    <fieldset>
        <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Metodo de Pago:</div>
        <!-- CAMPO IMPORTE   -->
        <select name="metodoPago" id="metodoPago" class="largeInput wide2">
        	<option value="Efectivo">Efectivo</option>
        	<option value="Tarjeta Credito o Debito">Tarjeta Credito o Debito</option>
        	<option value="Transferencia">Transferencia</option>
        	<option value="Cheque">Cheque</option>
        	<option value="Otro">Otro</option>
        </select>  
        </div>

        <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Fecha:</div>
        <!-- CAMPO IMPORTE   -->
        <input name="fecha" id="fecha" type="date" value="{$date}"  size="50" autofocus class="largeInput wide2"/>
        </div>

        <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Importe del Pago:</div>
        <!-- CAMPO IMPORTE   -->
        <input name="importe" id="importe" type="text" value="{$infoComprobante.debt_noformat|number_format:2:'.':''}"  size="50" autofocus class="largeInput wide2"/>
        </div>

        {if $infoComprobante.version == '3.3'}
        <div class="formLine" style="width:100%; text-align:left">
            <div style="width:60%;float:left; color:#f00">Generar comprobante con complemento de pago por este importe?</div>
            <!-- CAMPO generarComprobantePago   -->
            <input type="checkbox" name="generarComprobantePago" checked id="generarComprobantePago">
        </div>
        {/if}

        <div style="clear:both"></div>
    
        <div class="formLine" style="margin-left:280px">
            <a class="button" id="addPaymentButton" name="addPaymentButton"><span>Agregar Pago</span></a>  
        </div>
    	
        <div style="clear:both"></div>
                
        <input type="hidden" id="comprobanteId" name="comprobanteId" value="{$infoComprobante.notaVentaId}"/>
    </fieldset>
    </form>
</div>


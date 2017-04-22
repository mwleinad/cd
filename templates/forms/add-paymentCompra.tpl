<div id="divForm">
    <form id="addPaymentForm" name="addPaymentForm" method="post" onSubmit="return false">
    <input type="hidden" id="type" name="type" value="saveAddPayment"/>
    <fieldset>
        <div class="formLine" style="width:100%; text-align:left">
        <div style="width:30%;float:left">Importe del Pago:</div>
        <!-- CAMPO IMPORTE   -->
        <input name="importe" id="importe" type="text" value="{$infoComprobante.debt_noformat|number_format:2:'.':''}"  size="50" autofocus class="largeInput wide2"/>
        </div>
        <div style="clear:both"></div>
    
        <div class="formLine" style="margin-left:280px">
            <a class="button" onclick="AddPayment()" name="addPaymentButton"><span>Agregar Pago</span></a>  
        </div>
    	
        <div style="clear:both"></div>
                
        <input type="hidden" id="comprobanteId" name="comprobanteId" value="{$infoComprobante.compraId}"/>
    </fieldset>
    </form>
</div>


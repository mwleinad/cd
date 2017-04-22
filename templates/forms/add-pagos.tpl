<div id="divForm">
	<form id="addPaymentForm" name="addPaymentForm" method="post">
	<input type="hidden" id="type" name="type" value="saveAddPayment"/>
	<fieldset>
	<div class="formLine" style="width:100%; text-align:left">
		<div style="width:30%;float:left">Importe del Pago:</div>
			
        <input name="importe" id="importe" type="text" value="{$totalImporteVenta}" size="50" class="largeInput wide2"/>
	</div>
	
    <div style="clear:both"></div>
    <div class="formLine" style="margin-left:280px">
    	<a class="button" id="addPaymentButton" name="addPaymentButton"><span>Agregar Pago</span></a>
    </div>
    <div style="clear:both"></div>
    <br />
         *Si cometes algún error, puedes editar los pagos en la sección Reportes > Reporte de Ventas.
    
	<input type="hidden" id="comprobanteId" name="comprobanteId" value="{$infoComprobante.notaVentaId}"/>
 	<input type="hidden" id="totalVenta" name="totalVenta" value="{$totalImporteVenta}"/>
	</fieldset>
	</form>
</div>
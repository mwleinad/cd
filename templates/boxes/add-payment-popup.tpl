<div class="popupheader" style="z-index:70">
	<div id="fviewmenu" style="z-index:70">
		<div id="fviewclose"><span style="color:#CCC" id="closePopUpDiv">
			<a href="javascript:void(0)">Close<img src="{$WEB_ROOT}/images/b_disn.png" border="0" alt="close" /></a></span>
		</div>
	</div>

	<div id="ftitl">
		<div class="flabel">Agregar Pago</div>
    	<div id="vtitl">
        	<span title="Titulo">Agregar Pago</span>
        	<br /><br />
        	No. Nota: {$infoComprobante.notaVentaId}
    	</div>
	</div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
    	<img src="{$WEB_ROOT}/images/draganddrop.png" border="0" alt="mueve" />
	</div>
</div>

<div class="wrapper">
    <div align="center"><b>Deuda del Comprobante:</b>
    	 <br /><span style="font-size:16px;">${$infoComprobante.debt}</span>
    </div>

{*}<div style="float:right; height:100%;">
    	<input type="button" name="imprimir" id="imprimir" value="Imprimir" />
	</div>{*}
	<div>&nbsp;</div>
 
    {include file="{$DOC_ROOT}/templates/forms/add-payment.tpl"}
    
	<div id="paymentContent">
	{include file="{$DOC_ROOT}/templates/lists/payments.tpl"}
	</div>     
</div>

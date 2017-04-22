<div class="popupheader" style="z-index:70">
	<div id="fviewmenu" style="z-index:70">
		<div id="fviewclose"><span style="color:#CCC" id="closePopUpDiv">
			<a href="javascript:void(0)">Close<img src="{$WEB_ROOT}/images/b_disn.png" border="0" alt="close" /></a></span>
		</div>
	</div>

	<div id="ftitl">
		<div class="flabel">Editar Conceptos</div>
    	<div id="vtitl">
        	<span title="Titulo">Editar Conceptos</span>
        	<br /><br />
        	No. Nota: {$infoComprobante.notaVentaId}
    	</div>
	</div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
    	<img src="{$WEB_ROOT}/images/draganddrop.png" border="0" alt="mueve" />
	</div>
</div>

<div class="wrapper">

<div id="divForm">
    <form id="addPaymentForm" name="addPaymentForm" method="post" onSubmit="return false">
    <input type="hidden" id="ventaId" name="ventaId" value="{$infoComprobante.notaVentaId}"/>
    <input type="hidden" id="type" name="type" value="saveEditarConcepto"/>
    <fieldset>
<table border="1" width="100%" cellpadding="0" cellspacing="0" id="box-table-a">
<tr>
<td># Identificacion</td>
<td>Descripcion</td>
<td>Importe</td>
</tr>
{foreach from=$productos item=item}
<tr>
<td>{$item.noIdentificacion}</td>
<td>{$item.descripcion|truncate:50}</td>
<td><input type="text" name="importe[{$item.conceptoId}]" id="importe" value="{$item.importe}" /></td>
</tr>
{/foreach}
</table>
        <div class="formLine" style="margin-left:280px">
            <a class="button" id="editarConceptosButton" name="editarConceptosButton"><span>Editar Nota de Venta</span></a>  
        </div>
    	
        <div style="clear:both"></div>
                
    </fieldset>
    </form>
</div>

    
</div>

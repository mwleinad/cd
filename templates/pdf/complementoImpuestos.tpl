{if $xmlData.impuestosLocales|count > 0}
    <table width="100%" class="outline-table pre font-smaller no-bold">
        <tr class="border-bottom border-right">
            <td class="border-top left" width="55%"><strong>IMPORTE DE LA ESTIMACION No 01 (UNO) Y FINIQUITO</strong></td>
            <td class="border-top right" width="15%"><strong>SUBTOTAL</strong></td>
            <td class="border-top right" width="15%"><strong>{$xmlData.cfdi.SubTotal|number}</strong></td>
            <td class="border-top right" width="15%"><strong>&nbsp;</strong></td>
        </tr>
        {if count($xmlData.impuestos.traslados) > 0}
            {assign var="ivaExtra" value="0"}
            {foreach from=$xmlData.impuestos.traslados item=traslado}
                {if $traslado.Impuesto == '002'}
                    <tr class="border-bottom border-right">
                        <td class="border-top left"><strong>&nbsp;</strong></td>
                        <td class="border-top right"><strong>16% IVA</strong></td>
                        <td class="border-top right"><strong>{$traslado.Importe|number}</strong></td>
                        <td class="border-top right">
                            <strong>
                                {assign var="totalFromImpuestos" value=$xmlData.cfdi.SubTotal + $traslado.Importe}
                                {$totalFromImpuestos|number}
                            </strong>
                        </td>
                    </tr>
                {/if}
            {/foreach}
        {/if}
        <tr class="border-bottom border-right">
            <td colspan="4" class="border-top left">&nbsp;</td>
        </tr>
        {assign var="totalDeducciones" value=0}
        {foreach from=$xmlData.impuestosLocales key=keyTipo item=impuesto}
            {if $impuesto.extra}
                <tr class="border-right border-bottom">
                    <td class="left">{$impuesto.impuesto.impuesto}</td>
                    <td class="right">SUBTOTAL</td>
                    <td class="right">{$impuesto.impuesto.importe|number}</td>
                    <td class="right"></td>
                </tr>
                <tr class="border-right border-bottom">
                    <td class="left"></td>
                    <td class="right">16% IVA</td>
                    <td class="right">{$impuesto.extra.importe|number}</td>
                    <td class="right"></td>
                </tr>
                <tr class="border-right border-bottom">
                    <td class="left"></td>
                    <td class="right"></td>
                    <td class="right"></td>
                    <td class="right">
                        {assign var="totalImpuesto" value=$impuesto.impuesto.importe + $impuesto.extra.importe}
                        {$totalImpuesto|number}
                    </td>
                </tr>
                <tr class="border-right border-bottom">
                    <td class="left">Subtotal</td>
                    <td class="right"></td>
                    <td class="right"></td>
                    <td class="right">
                        {assign var="subtotalAlcanceLiquido" value=$totalFromImpuestos - $impuesto.impuesto.importe - $impuesto.extra.importe}
                        {$subtotalAlcanceLiquido|number}</td>
                </tr>
            {else}
                {assign var="totalDeducciones" value=$totalDeducciones+$impuesto.impuesto.importe}
                <tr class="border-right border-bottom">
                    <td class="left">{$impuesto.impuesto.impuesto}</td>
                    <td class="right"></td>
                    <td class="right">{$impuesto.impuesto.importe|number}</td>
                    <td class="right"></td>
                </tr>
            {/if}
        {/foreach}
        <tr class="border-right border-bottom">
            <td class="left">Total deducciones</td>
            <td class="right"></td>
            <td class="right"></td>
            <td class="right">{$totalDeducciones|number}</td>
        </tr>
        <tr class="border-bottom border-right">
            <td colspan="4" class="border-top left">&nbsp;</td>
        </tr>
        <tr class="border-right border-bottom">
            <td class="left"></td>
            <td class="right"></td>
            <td class="right">Alcance liquido</td>
            <td class="right">
                {assign var="alcanceLiquido" value=$subtotalAlcanceLiquido - $totalDeducciones}
                {$alcanceLiquido|number}
            </td>
        </tr>
    </table>
{/if}
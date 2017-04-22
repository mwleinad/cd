{include file="{$DOC_ROOT}/templates/items/paymentsCompra_header.tpl" clase="Off"}
{foreach from=$payments item=prod key=key}
    {if $key%2 == 0}
        {include file="{$DOC_ROOT}/templates/items/paymentsCompra_base.tpl" clase="Off"}
    {else}
        {include file="{$DOC_ROOT}/templates/items/paymentsCompra_base.tpl" clase="On"}
    {/if}
{foreachelse}
	<tr><td colspan="3" align="center"><div align="center">Ning&uacute;n pago encontrado.</div></td></tr>
{/foreach}
{include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$clientes.pages colspan=3}
{include file="{$DOC_ROOT}/templates/items/factura_header.tpl" clase="Off"}

{foreach from=$comprobantes.items item=fact key=key}
    {if $key%2 == 0}
        {include file="{$DOC_ROOT}/templates/items/nomina_base.tpl" clase="Off"}
    {else}
        {include file="{$DOC_ROOT}/templates/items/nomina_base.tpl" clase="On"}
    {/if}
{foreachelse}
	<tr>
    	<td align="center" colspan="6">Ning&uacute;n registro encontrado.</td>
    </tr>
{/foreach}

{if count($comprobantes.pages)}
{include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$comprobantes.pages colspan="6"}
{/if}
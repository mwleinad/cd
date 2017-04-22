
{include file="{$DOC_ROOT}/templates/items/clientes_header.tpl" clase="Off"}

{foreach from=$clientes.items item=cliente key=key}
    {if $key%2 == 0}
        {include file="{$DOC_ROOT}/templates/items/clientes_base.tpl" clase="Off"}
    {else}
        {include file="{$DOC_ROOT}/templates/items/clientes_base.tpl" clase="On"}
    {/if}
{foreachelse}
	<tr>
    	<td colspan="3" align="center">Ning&uacute;n registro encontrado.</td>
    </tr>
{/foreach}

{include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$clientes.pages colspan=3}


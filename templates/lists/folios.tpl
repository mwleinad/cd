{include file="{$DOC_ROOT}/templates/items/folio_header.tpl" clase="Off"}

{foreach from=$folios item=folio key=key}
    {if $key%2 == 0}
        {include file="{$DOC_ROOT}/templates/items/folio_base.tpl" clase="Off"}
    {else}
        {include file="{$DOC_ROOT}/templates/items/folio_base.tpl" clase="On"}
    {/if}
{foreachelse}
<tr><td colspan="8" align="center">Ning&uacute;n registro encontrado.</td></tr>
{/foreach}

{include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$pages colspan="8"}
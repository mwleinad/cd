{include file="{$DOC_ROOT}/templates/items/usuarios_header.tpl" clase="Off"}

{foreach from=$empresaUsuarios item=usuario key=key}
    {if $key%2 == 0}
        {include file="{$DOC_ROOT}/templates/items/usuarios_base.tpl" clase="Off"}
    {else}
        {include file="{$DOC_ROOT}/templates/items/usuarios_base.tpl" clase="On"}
    {/if}
{foreachelse}
	<tr><td colspan="7" align="center">Nin&uacute;n registro encontrado.</td></tr>
{/foreach}

{include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$pages colspan=7}
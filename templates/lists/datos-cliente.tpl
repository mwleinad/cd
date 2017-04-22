
{include file="{$DOC_ROOT}/templates/items/clientes_header.tpl" clase="Off"}

{if count($clientes.items)}
	{foreach from=$clientes.items item=cliente key=key}
    	{if $key%2 == 0}
			{include file="{$DOC_ROOT}/templates/items/clientes_base.tpl" clase="Off"}
        {else}
			{include file="{$DOC_ROOT}/templates/items/clientes_base.tpl" clase="On"}
        {/if}
	{/foreach}
 	{if count($clientes.pages)}
    {include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$clientes.pages colspan=3}
  {/if}
{else}
	No se encontraron Clientes 
{/if}
{include file="{$DOC_ROOT}/templates/items/sucursales_header.tpl" clase="Off"}

{if count($sucursales)}
	{foreach from=$sucursales item=sucursal key=key}
    	{if $key%2 == 0}
			{include file="{$DOC_ROOT}/templates/items/sucursales_base.tpl" clase="Off"}
        {else}
			{include file="{$DOC_ROOT}/templates/items/sucursales_base.tpl" clase="On"}
        {/if}
	{/foreach}
  {include file="{$DOC_ROOT}/templates/lists/pages_ajax.tpl" pages=$pages}
{else}
	No se encontraron Sucursales 
{/if}

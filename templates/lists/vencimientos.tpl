{include file="{$DOC_ROOT}/templates/items/venciemintos-header.tpl" clase="Off"}
	{foreach from=$ventas item=fact key=key}
    	{if $key%2 == 0}
			{include file="{$DOC_ROOT}/templates/items/vencimientos-base.tpl" clase="Off"}
        {else}
			{include file="{$DOC_ROOT}/templates/items/vencimientos-base.tpl" clase="On"}
        {/if}
	{/foreach}
 	{if count($fact)}
    {include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$comprobantes.pages colspan=8}
  {/if}

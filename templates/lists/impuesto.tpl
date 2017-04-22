
{include file="{$DOC_ROOT}/templates/items/impuesto-header.tpl" clase="Off"}

{if count($resImpuesto.items)}
	{foreach from=$resImpuesto.items item=item key=key}
    	{if $key%2 == 0}
			{include file="{$DOC_ROOT}/templates/items/impuesto-base.tpl" clase="Off"}
        {else}
			{include file="{$DOC_ROOT}/templates/items/impuesto-base.tpl" clase="On"}
        {/if}
	{/foreach}
 	{if count($resImpuesto.pages)}
  {/if}
    {include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$resImpuesto.pages colspan=5}
{else}
	No se encontraron Clientes 
{/if}
{if count($periodos)}
	{foreach from=$periodos item=periodo key=key}
		{include file="{$DOC_ROOT}/templates/items/periodo_base.tpl"}
	{/foreach}
{else}
No se encontraron periodos  
{/if}
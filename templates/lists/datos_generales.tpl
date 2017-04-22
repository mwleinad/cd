{include file="{$DOC_ROOT}/templates/items/datos_generales_header.tpl" clase="Off"}

{if count($empresaRfcs)}
	{foreach from=$empresaRfcs item=rfc key=key}
    	{if $key%2 == 0}
			{include file="{$DOC_ROOT}/templates/items/datos_generales_base.tpl" clase="Off"}
        {else}
			{include file="{$DOC_ROOT}/templates/items/datos_generales_base.tpl" clase="On"}
        {/if}
	{/foreach}
  {include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$pages}
{else}
	No se encontraron RFCs 
{/if}

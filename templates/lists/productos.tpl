{include file="{$DOC_ROOT}/templates/items/producto_header.tpl" clase="Off"}
{if count($productos.items)}
	{foreach from=$productos.items item=prod key=key}
    	{if $key%2 == 0}
			{include file="{$DOC_ROOT}/templates/items/producto_base.tpl" clase="Off"}
        {else}
			{include file="{$DOC_ROOT}/templates/items/producto_base.tpl" clase="On"}
        {/if}
	{/foreach}
 	{if count($productos.pages)}
{*}    {include file="{$DOC_ROOT}/templates/lists/pages.tpl" pages=$productos.pages}{*}
  {/if}
  {include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$productos.pages colspan=5}
{else}
<div align="center">No existen productos en estos momentos.</div>
{/if}
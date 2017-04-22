{include file="{$DOC_ROOT}/templates/items/proveedor_header.tpl" clase="Off"}
{if count($proveedores.items)}
	{foreach from=$proveedores.items item=prod key=key}
    	{if $key%2 == 0}
			{include file="{$DOC_ROOT}/templates/items/proveedor_base.tpl" clase="Off"}
        {else}
			{include file="{$DOC_ROOT}/templates/items/proveedor_base.tpl" clase="On"}
        {/if}
	{/foreach}
 	{if count($proveedores.pages)}
{*}    {include file="{$DOC_ROOT}/templates/lists/pages.tpl" pages=$proveedores.pages}{*}
  {/if}
  {include file="{$DOC_ROOT}/templates/lists/pages_new.tpl" pages=$proveedores.pages colspan=5}
{else}
<div align="center">No existen proveedores en estos momentos.</div>
{/if}
<br />
{if count($pages.numbers)}
{if $type == "ajax"}{assign var="linktpl" value="{$DOC_ROOT}/templates/links/ajax_link.tpl"}{else}{assign var="linktpl" value="{$DOC_ROOT}/templates/links/link.tpl"}{/if} 
<div class="pages" style="text-align:center; font:Verdana, Geneva, sans-serif; font-size:16px">
	{if $pages.first}{include file=$linktpl link=$pages.first name="&laquo;"}{/if}
	{if $pages.prev}{include file=$linktpl link=$pages.prev name="&lt;"}{/if}
	{foreach from=$pages.numbers item=page key=key}
	{if $pages.current == $key}<span class="p">{$key}</span>{else}{include file=$linktpl link=$page name=$key}{/if}
	{/foreach}
	{if $pages.next}{include file=$linktpl link=$pages.next name="&gt;"}{/if}
	{if $pages.last}{include file=$linktpl link=$pages.last name="&raquo;"}{/if}
</div>
{/if}
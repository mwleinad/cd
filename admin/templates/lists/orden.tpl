<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
	{include file="{$DOC_ROOT}/templates/items/orden-header.tpl"}
<tbody>
	{include file="{$DOC_ROOT}/templates/items/orden-base.tpl"}
</tbody>
</table>
	{if count($resOrden.pages)}
	{include file="{$DOC_ROOT}/templates/lists/pages.tpl" pages=$resOrden.pages}
	{/if}

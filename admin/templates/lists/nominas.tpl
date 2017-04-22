<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
	{include file="{$DOC_ROOT}/templates/items/nominas-header.tpl"}
<tbody>
	{include file="{$DOC_ROOT}/templates/items/nominas-base.tpl"}
</tbody>
</table>
	{if count($resVentas.pages)}
	{include file="{$DOC_ROOT}/templates/lists/pages.tpl" pages=$resVentas.pages}
	{/if}

<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
	{include file="{$DOC_ROOT}/templates/items/reporte-header.tpl"}
<tbody>
	{include file="{$DOC_ROOT}/templates/items/reporte-base.tpl"}
</tbody>
</table>
	{if count($resReporte.pages)}
	{include file="{$DOC_ROOT}/templates/lists/pages.tpl" pages=$resReporte.pages}
	{/if}

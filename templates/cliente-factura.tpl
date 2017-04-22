{include file="boxes/white_open.tpl"}
{if $nodoEmisorRfc.permisoFacturar == "Si"}
	{include file="forms/cliente-factura.tpl"}
{else}
<div style="text-align:center">
	No tienes permiso de realizar facturas, comun&iacute;cate con el emisor de tu factura para mas detalles.
</div>
{/if}
{include file="boxes/white_close.tpl"}
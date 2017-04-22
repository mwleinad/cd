{include file="boxes/white_open.tpl"}
<div style="text-align:center; color:#00C; font-weight:bold">
{*}<a href="{$WEB_ROOT}/privacidad" target="_blank">Consulta nuestro Aviso de Privacidad</a><br />{*}
</div>
{include file="menus/admin_folios.tpl"}

<div style="text-align:center; color:#FF0000">
{foreach from=$error item=item}
	{$item}<br />
{/foreach}
</div>

<div style="text-align:center; color:#060">
{foreach from=$success item=item}
	{$item}<br />
{/foreach}
</div>

{include file="forms/actualizar.tpl"}

{include file="boxes/white_close.tpl"}
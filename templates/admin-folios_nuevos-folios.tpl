{include file="boxes/white_open.tpl"}

{if $cmpMsg}
<div align="center" style="color:#009900">{$cmpMsg}<br /><br /></div>
{/if}
{if $errMsg}
<div align="center" style="color:#FF0000">{$errMsg}<br /><br /></div>
{/if}

{if in_array("create", $nuevosPermisos.nuevos_folios)}
<div align="center">
    <a href="javascript:void(0)" class="inline_add" onclick="AddFoliosDiv()">Agregar Folios</a>            
</div>
{/if}

<div id="foliosListDiv">
{include file="lists/folios.tpl"}
</div>

{include file="boxes/white_close.tpl"}
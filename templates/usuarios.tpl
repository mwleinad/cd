{include file="boxes/white_open.tpl"}

{if in_array("create", $nuevosPermisos.usuarios)}
<div align="center">
    <a href="javascript:void(0)" class="inline_add" onclick="AddUsuarioDiv(1)">Agregar Empleado</a>            
</div>
<br />
{/if}

<div id="usuariosDiv">
	{include file="lists/usuarios.tpl"}
</div>

{include file="boxes/white_close.tpl"}
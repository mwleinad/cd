<div class="clienteRow{$clase}">
    <div class="clienteColL" style="width:35px;">{$cliente.userId}</div>
    <div class="clienteColL" style="width:300px;">{$cliente.nombre}</div>
    <div class="clienteColL" style="width:100px;">{$cliente.rfc}</div>
    <div class="clienteColC" style="width:60px; clear:right">
    {if in_array("edit", $nuevosPermisos.cliente)}
    	<a href="#" class="editCliente" title="Modificar Cliente">M</a>
	{/if}
    {if in_array("delete", $nuevosPermisos.cliente)}
        <a href="#" class="delCliente" title="Eliminar Cliente">E</a>
	{/if}
    </div>
</div>
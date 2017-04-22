<tr>
    <td align="center">{$cliente.rfc}</td>
    <td align="left">{$cliente.nombre}</td>
    <td align="center"e>    
    {if in_array("edit", $nuevosPermisos.cliente)}
    <a href="javascript:void(0)" title="Editar">
        <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" id="{$cliente.userId}"/>
    </a>
    {/if}
    {if in_array("delete", $nuevosPermisos.cliente)}
    <a href="javascript:void(0)" title="Eliminar">
        <img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" id="{$cliente.userId}" border="0"/>
    </a>
    {/if}
    </td>
</tr>

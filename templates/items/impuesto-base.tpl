<tr>
    <td align="center">{$item.impuestoId}</td>
    <td>{$item.nombre}</td>
    <td align="center">{$item.tasa}</td>
    <td align="center">{$item.tipo}</td>
    <td align="center">    
    {if in_array("edit",$nuevosPermisos.impuesto)}
    <a href="javascript:void(0)" title="Editar">
        <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" id="{$item.impuestoId}" border="0"/>
    </a>
    {/if}
    {if in_array("delete",$nuevosPermisos.impuesto)}
    <a href="javascript:void(0)" title="Eliminar">
        <img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" id="{$item.impuestoId}" border="0" />
    </a>
    {/if}
    </td>
</tr>
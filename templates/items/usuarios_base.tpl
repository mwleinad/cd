<tr>
    <td>{$usuario.nombreCompleto}</td>
    <td align="center">{$usuario.numEmpleado}</td>
    <td align="center">{$usuario.email}</td>
    <td align="center">{$usuario.password}</td>
    <td align="center">{$usuario.type}</td>
    <td align="center">{$usuario.sucursal}</td>
    {if $info.moduloNomina == "Si"}
    <td align="center">${$usuario.totalNomina|number_format:2}</td>
    {/if}
    <td align="center">
    {if $usuario.main == "no"}
      {if in_array("edit", $nuevosPermisos.usuarios)}
      <a href="javascript:void(0)" title="Editar">
          <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" id="{$usuario.usuarioId}"/>
      </a>
      {/if}
      {if in_array("delete", $nuevosPermisos.usuarios)}
      <a href="javascript:void(0)" title="Eliminar">
      <img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" id="{$usuario.usuarioId}"/>
      </a>
      {/if}
      {if $info.moduloNomina == "Si"}
        <a title="Generar Nomina" href="{$WEB_ROOT}/nomina/id/{$usuario.usuarioId}">
        <img width="16" src="{$WEB_ROOT}/images/icons/re-facturar.png" class="" id="{$usuario.usuarioId}"/>
        </a>
      {/if}
    {/if}
    </td>
</tr>
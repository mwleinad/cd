              <tr>
                <td>{$sucursal.rfc}</td>
                <td>{$sucursal.identificador}</td>
                <td>{$sucursal.sucursalActiva}</td>
                <td>
                	{if in_array("delete", $nuevosPermisos.datos_generales)}
                    {if $sucursal.sucursalActiva != "si"}
                    <img src="{$WEB_ROOT}/images/b_dele.png" class="spanDeleteSucursal" title="Eliminar" id="{$sucursal.sucursalId}"/></span>
                    {/if}
                  {/if}
                    {if in_array("edit", $nuevosPermisos.datos_generales)}
                    <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEditSucursal" title="Editar" id="{$sucursal.sucursalId}"/>
                    {/if}
				</td>
              </tr>
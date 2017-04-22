              <tr>
                <td>{$rfc.rfc}</td>
                <td>{$rfc.razonSocial}</td>
                <td>{$rfc.calle} {$rfc.noExt} {$rfc.noInt} {$rfc.rfcId}</td>
                <td>
                {*if in_array("delete", $nuevosPermisos.datos_generales)}
                    <img src="{$WEB_ROOT}/images/b_dele.png" class="spanDelete" title="Eliminar" id="{$rfc.rfcId}" style="cursor:pointer"/>
				{/if*}
                {if in_array("edit", $nuevosPermisos.datos_generales)}
                    <img src="{$WEB_ROOT}/images/b_edit.png" class="spanEdit" title="Editar" id="{$rfc.rfcId}" style="cursor:pointer"/>
				{/if}
                {if in_array("create", $nuevosPermisos.datos_generales)}
					<img src="{$WEB_ROOT}/images/addn.png" class="spanSucursales" title="Ver Sucursales" id="{$rfc.rfcId}" style="cursor:pointer"/>
				{/if}
				</td>
              </tr>


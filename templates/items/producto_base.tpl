              <tr>
                <td>{$prod.noIdentificacion}</td>
                <td>{$prod.descripcion}</td>
                <td>{$prod.unidad}</td>
                <td>${$prod.valorUnitario}</td>
                <td>${$prod.precioCompra}</td>
                <td>
                {if $prod.disponible == 0}
                <span style="color:#F00">{$prod.disponible}</span>
                {elseif $prod.disponible < 10}
                <span style="color:#F90">{$prod.disponible}</span>
                {else}
                {$prod.disponible}
                {/if}
                
                </td>
                <td>
                	<img src="{$WEB_ROOT}/images/b_dele.png" title="Eliminar" class="spanDelete" id="{$prod.productoId}"/>
    		<img src="{$WEB_ROOT}/images/b_edit.png" title="Editar"class="spanEdit" id="{$prod.productoId}"/></td>
              </tr>

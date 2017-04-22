              <tr>
                <td width="34">{$fact.rfc}</td>
                <td>{$fact.nombre}</td>
                <td>{$fact.fecha}</td>
                <td>{$fact.total_formato}</td>
                <td title="{if $info.version == "construc" || $info.version == "v3"}{$fact.uuid}{/if}">{$fact.serie}{$fact.folio}</td>
                <td width="90">
                	<a href="javascript:void(0)">
				    	<img src="{$WEB_ROOT}/images/icons/details.png" class="spanDetails" id="{$fact.comprobanteId}" border="0" title="Ver Detalles" />
					</a>
				</td>
              </tr>
             
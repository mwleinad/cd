              <tr>
                <td width="34">{$fact.rfc}</td>
                <td>{$fact.nombre}</td>
                <td>{$fact.fecha}</td>
                <td>{$fact.total_formato}</td>
                <td title="{if $info.version == "construc" || $info.version == "v3"}{$fact.uuid}{/if}">{$fact.serie}{$fact.folio}</td>
                <td width="90"><a href="javascript:void(0)">
                				{if in_array("view",$nuevosPermisos.consultar_facturas)}
						    	<img src="{$WEB_ROOT}/images/icons/details.png" class="spanDetails" id="{$fact.comprobanteId}" border="0" title="Ver Detalles" />
                                {/if}
                              {if in_array("delete",$nuevosPermisos.consultar_facturas)}
						      {if $fact.status == 1}<a href="javascript:void(0)"><img src="{$WEB_ROOT}/images/icons/cancel.png" class="spanCancel" id="{$fact.comprobanteId}" border="0" title="Cancelar"/></a>{/if}
                              {/if}
                  {*if $fact.status == 1}
						    	<img src="{$WEB_ROOT}/images/payment.png" class="spanPayments" id="{$fact.comprobanteId}" border="0" Title="Agregar Pago" />
                  {/if*}
      					</td>
              </tr>
             
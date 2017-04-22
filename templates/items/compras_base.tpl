              <tr>
                <td width="34">{$fact.rfc}</td>
                <td>{$fact.nombre}</td>
                <td>{$fact.fecha}</td>
                <td>{$fact.total_formato}</td>
                <td {if $fact.statusPayment == "Pagada"} style="color:#090"{else} style="color:#F00"{/if}>{$fact.payments}</td>
                <td title="{if $info.version == "construc" || $info.version == "v3"}{$fact.uuid}{/if}">{$fact.serie}{$fact.folio}</td>
                <td width="90"><a href="javascript:void(0)">
                {if in_array("view",$nuevosPermisos.consultar_facturas)}
                {*descargar xml*}  
                <a href="{$WEB_ROOT}/sistema/descargar-xml-compra/item/{$fact.comprobanteId}">
                	<img src="{$WEB_ROOT}/images/icons/descargar.png" border="0" width="16" />
                </a>
                {/if}

      				{if $fact.statusPayment != "Pagada"}
                    <img src="{$WEB_ROOT}/images/payment.png" class="spanPayments" id="{$fact.comprobanteId}" border="0" title="Agregar Pago" style="cursor:pointer;" />{/if}

                  {if in_array("delete",$nuevosPermisos.consultar_facturas)}
						      {if $fact.status == 1}<a href="javascript:void(0)"><img src="{$WEB_ROOT}/images/icons/cancel.png" class="spanCancel" id="{$fact.comprobanteId}" border="0" title="Cancelar"/></a>{/if}
                              {/if}
      					</td>
              </tr>
             
              <tr>
                <td width="34">{$fact.rfc}</td>
                <td>{$fact.nombre}</td>
                <td>{$fact.fecha}</td>
                <td>{$fact.total_formato}</td>
                <td title="{if $info.version == "construc" || $info.version == "v3"}{$fact.uuid}{/if}">{$fact.serie}{$fact.folio}</td>
                <td width="90"><a href="javascript:void(0)">
                				{if in_array("view",$nuevosPermisos.consultar_facturas)}
                        
                {*ver factura*}  
								<a href="{$WEB_ROOT}/sistema/ver-pdf/item/{$fact.comprobanteId}" target="_blank">
                	<img src="{$WEB_ROOT}/images/icons/ver_factura.png" border="0" width="16" />
                </a>
                 
                {*enviar correo*}  
                <a href="javascript:void(0)">
                    <img src="{$WEB_ROOT}/images/icons/email.png" border="0" onclick="EnviarEmail({$fact.comprobanteId})" width="16" />
                </a>
                
                {*descargar pdf*}  
                <a href="{$WEB_ROOT}/sistema/descargar-pdf/item/{$fact.comprobanteId}">
                	<img src="{$WEB_ROOT}/images/pdf_icon.png" class="" id="{$fact.comprobanteId}" border="0" title="Descargar PDF" width="16"/>
                </a>
                
                {*descargar xml*}  
                <a href="{$WEB_ROOT}/sistema/descargar-xml/item/{$fact.comprobanteId}">
                	<img src="{$WEB_ROOT}/images/icons/descargar.png" border="0" width="16" />
                </a>
                {/if}
                  {if in_array("delete",$nuevosPermisos.consultar_facturas)}
						      {if $fact.status == 1}<a href="javascript:void(0)"><img src="{$WEB_ROOT}/images/icons/cancel.png" class="spanCancel" id="{$fact.comprobanteId}" border="0" title="Cancelar"/></a>{/if}
                              {/if}
                  {*if $fact.status == 1}
						    	<img src="{$WEB_ROOT}/images/payment.png" class="spanPayments" id="{$fact.comprobanteId}" border="0" title="Agregar Pago" />
                  {/if*}
      					</td>
              </tr>
             
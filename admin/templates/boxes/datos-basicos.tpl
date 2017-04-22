            	<table id="taskSheet" cellpadding="2" cellspacing="1" border="0" class="sheet" width="100%">
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Razon Social</td>
              	<td width="70%" width="50%" style="font-size:12px">{$item.rfc.razonSocial}</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">RFC</td>
              	<td width="70%" style="font-size:12px">{$item.rfc.rfc}</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Direccion</td>
              	<td width="70%" width="50%" style="font-size:12px">{$item.rfc.calle|replace:"%20":" "} {$item.rfc.noExt|replace:"%20":" "} {$item.rfc.noInt|replace:"%20":" "} {$item.rfc.colonia|replace:"%20":" "} {$item.rfc.localidad|replace:"%20":" "} {$item.rfc.municipio|replace:"%20":" "} {$item.rfc.estado|replace:"%20":" "} {$item.rfc.pais|replace:"%20":" "} {$item.rfc.cp|replace:"%20":" "}</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Usuario</td>
              	<td width="70%" style="font-size:12px">{$item.email}</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Password</td>
              	<td width="70%" style="font-size:12px">{$item.password}</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Ultima Factura</td>
              	<td width="70%" style="font-size:12px">{$item.ultimaExpedida}</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Limite/Expedidas</td>
              	<td width="70%" style="font-size:12px" {if $item.terminar == 1} style="background-color:#C30"{/if}>{$item.limite} / {$item.expedidos}</td>
              </tr>
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Activo</td>
              	<td width="70%" style="font-size:12px">{if $item.activo == 1}Si{else}No{/if}</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="100%" colspan="2" style="font-size:12px; text-align:center">Datos de Contacto</td>
              </tr>
              
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Persona Contacto</td>
              	<td width="70%" style="font-size:12px">{$item.nombrePer}</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Telefono Empresarial</td>
              	<td width="70%" style="font-size:12px">{$item.telefono}</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Telefono Contacto</td>
              	<td width="70%" style="font-size:12px">{$item.telefonoPer}</td>
              </tr>

              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Celular Contacto</td>
              	<td width="70%" style="font-size:12px">{$item.celularPer}</td>
              </tr>
              
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Correo Contacto</td>
              	<td width="70%" style="font-size:12px">{$item.emailPer}</td>
              </tr>

              
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Localidad</td>
              	<td width="70%" style="font-size:12px">{$item.rfc.localidad}</td>
              </tr>
						{if $roleId==1}
              <tr style="font-size:12px">
              	<td width="30%" style="font-size:12px">Socio</td>
              	<td width="70%" style="font-size:12px">{$item.socio.razonSocial1}</td>
              </tr>
            {/if}
             </table>
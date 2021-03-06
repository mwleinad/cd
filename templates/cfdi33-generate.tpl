{if $certAboutToExpire}
    <div style="font-size:18px; border:solid; border-width:1px; background-color:#eee; padding:5px; text-align: center">
        Sello Digital Proximo a Expirar o ha expirado <a href='{$WEB_ROOT}/admin-folios/actualizar-certificado'>Actualizar aqui</a><br>
        La fecha de expiracion es: {$fechaExpiracion|date_format:"%d/%m/%Y"}
        <br>Si no sabes que es o como se genera necesitas contactar a tu contador.
        <br>Si tu sello digital expira no podras timbrar ningun comprobante.
    </div>
{/if}

<div id="testmodal" style="display:none; text-align:center">
    <a href="{$WEB_ROOT}/reportePago" title="Simple form"  style="font-size:18px; text-align:center; color:#F00">Tu cuenta expira el {$vencimiento.vencimiento|date_format:"%d/%m/%Y"}. Da click aqui para saber las opciones para renovar tu cuenta.</a>
</div>

{if (1) && $renew}
    <div style="font-size:14px; border:solid; border-width:1px; background-color:#CAFFF8; padding:5px">

        <p>Recuerda que el {$vencimiento.vencimiento|date_format:"%d/%m/%Y"} es la fecha l&iacute;mite de la vigencia de tus Timbres Fiscales, a partir del cual tus Timbres se congelar&aacute;n y <b>no podr&aacute;s seguir elaborando m&aacute;s Comprobantes Digitales</b>. Para continuar disfrutando de nuestro servicio tienes que contratar un paquete de timbres de Folios.<br />
            Para saber los pasos, costos y datos de deposito para contratar nuevos timbres visita<b> <a href="{$WEB_ROOT}/reportePago">Aqui</a>
        </p>

    </div>
{/if}
{if ($info.expedidos * 100 / $info.limite) > 80 && (1)}
    <div style="font-size:14px; border:solid; border-width:1px; background-color:#eee; padding:5px">
        Estimado Cliente hemos detectado que tus timbres estan proximos a terminarse. Actualmente te quedan  solamente {$info.limite-$info.expedidos} Timbres. <br />
        Cuando los timbres se te terminen <b>no podras hacer uso del sistema.</b><br />
        Para saber los pasos, costos y datos de deposito  para contratar nuevos timbres visita<b> <a href="{$WEB_ROOT}/timbres">Aqui</a></b>
    </div>
{/if}
{include file="boxes/white_open.tpl"}
<ul>
    {if $info.version != "auto" && $certNuevo == ""}
        <li>No has subido tu Certificado de Sello Digital. Para subirlo Ir a la Secci&oacute;n de Folios > Actualizar Certificado. No podr&aacute;s hacer facturas hasta subirlo.</li>
    {/if}
    {if $noFolios == 0}
        <li style="color:#C00; font-size:14px">Tienes que subir al menos una serie de Folios. Para hacerlo ve a Folios > Nuevos Folios. No podr&aacute;s hacer facturas hasta hacerlo.</li>
    {/if}
    {if $info.version == "auto" && $qrs == 0}
        <li style="color:#C00; font-size:14px">No has subido tu C&oacute;digo de Barras Bidimensional. Para subirlo ve a la secci&oacute;n de Folios > Cambiar QR</li>
    {/if}
    {if $countClientes == 0}
        <li style="color:#C00; font-size:14px">Tienes que agregar al menos un cliente. Para crearlo ve a la secci&oacute;n de Clientes > Nuevo Cliente</li>
    {/if}

</ul>

{if ($SITENAME == "PASCACIO" OR $SITENAME == "FACTURASE") && $renewImpuestos && $info.moduloImpuestos == "Si"}
    <div style="font-size:14px; border:solid; border-width:1px; background-color:#eee; padding:5px">
        <p>Recuerda que el {$vencimiento.venImpuestos|date_format:"%d/%m/%Y"} es la fecha l&iacute;mite de la vigencia de tu modulo de impuestos espciales y locales, a partir del cual el modulo se congelar&aacute;n y no podr&aacute;s seguir elaborando comprobantes con este tipo de impuestos. Para continuar disfrutando de nuestro servicio sirvase elaborar el pago.</p>

        <table width="100%">
            <td>Modulo de Impuestos Vigencia 1 a&ntilde;o: </td>
            <td align="right">$1600.00</td>
            </tr>
        </table>

        Banco: Bancomer<br />
        Leticia Angel Hernandez<br />
        Sucursal: <b>0179</b><br />
        Cuenta: <b>0473528960</b><br />
        CLABE: <b>012107004735289601</b><br />


        Si necesita factura o tiene alguna duda, favor de mandar un correo a ventas@pascacio.com.mx
        <br />
        Los costos son MAS IVA.
    </div><br />
{/if}

{if $info.aceptacionTerminosDeServicio2017 != ''}
    <div style="font-size:14px; border:solid; border-width:1px; background-color:#CAFFF8; padding:5px; text-align: center">
        <p style="font-size: 20px;color: red;">¡¡¡IMPORTANTE!!! ¡¡¡IMPORTANTE!!! ¡¡¡IMPORTANTE!!!</p>
        <p>
            Debido a las nuevas disposiciones del SAT es NECESARIO firmar el contrato de servicios del nuevo PAC<br>
            Cualquier duda favor de comunicarse al correo:<br>
            <a href="mailto:comprobantefiscal@braunhuerin.com.mx">comprobantefiscal@braunhuerin.com.mx</a>
        </p>
        <p style="font-weight: bold">
            De no hacerlo no podra emitir mas timbres. La fecha limite para el registro es el 30 de Agosto del 2019.
        </p>
        <p>
            El contrato lo pueden firmar aqui:
            <br>
            <a style="font-size: 16px; font-weight: bold" target="_blank" href="https://manifiesto.cfdiquadrum.com.mx/IPmU">Contrato PAC Centro de Validacion Digital</a>
            <br>Necesitaran su Firma Electronica.
        </p>
        <p style="text-align: center">
            <a style="font-size: 20px" target="_blank" href="https://app.ilosvideos.com/view/mWfBcgUKU2So">Ver video tutorial</a>
        </p>
    </div>
    <br><br>
    {include file="forms/cfdi33.tpl"}
{else}
    {include file="terminos2017.tpl"}
{/if}

{include file="boxes/footer_factura.tpl"}
{include file="boxes/white_close.tpl"}


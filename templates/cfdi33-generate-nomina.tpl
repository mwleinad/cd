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

    {if $faltaSerieNomina}
        <li style="color:#C00; font-size:14px">Tienes que agregar al menos una serie de folios de N&oacute;mina. Para crearlo ve a la secci&oacute;n de Configuraci&oacute;n > Folios > Nuevos Folios</li>
    {/if}

</ul>

{if ($SITENAME == "PASCACIO" OR $SITENAME == "FACTURASE") && $renew}
    <div style="font-size:14px; border:solid; border-width:1px; background-color:#eee; padding:5px">
        <p>Recuerda que el {$vencimiento.venNomina|date_format:"%d/%m/%Y"} es la fecha l&iacute;mite de la vigencia de tu modulo de nomina, a partir del cual el modulo se congelar&aacute;n y no podr&aacute;s seguir elaborando recibos de nomina. Para continuar disfrutando de nuestro servicio sirvase elaborar el pago.</p>

        <table width="100%">
            <td>Modulo de Nomina Vigencia 1 a&ntilde;o: </td>
            <td align="right">$1000.00</td>
            </tr>
        </table>

        <p>Banco:Banamex. <br />
            A nombre de:Daniel Alfonso Lopez Angel.	<br />
            Cuenta: 0179 224996	<br />
            CLABE:002100017902249960.	</p>
        <p>O al Paypal dlopez@trazzos.com</p>
        <p><br />

            Si necesita factura o tiene alguna duda, favor de mandar un correo a ventas@pascacio.com.mx
            <br />
            Los costos son MAS IVA.
        </p>
    </div><br />
{/if}

{if !$expired}
    {include file="forms/cfdi33-nomina.tpl"}
{else}
    Modulo Congelado hasta confirmacion de pago.
{/if}

{include file="boxes/white_close.tpl"}


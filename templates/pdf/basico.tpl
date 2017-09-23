<html>
<head>
    <title>Invoice</title>
    <style type="text/css">
        body {
            font-family: helvetica, Sans-Serif;
            font-size: 11px;
            line-height: 20px;
        }
        #page-wrap {
            width: 700px;
            margin: 0 auto;
        }
        table {
            font-size: 11px;
            line-height: 20px;
        }
        table.outline-table {
            border: 2px solid #ccc;
            border-spacing: 0;
        }
        tr.border-bottom td, td.border-bottom {
            border-bottom: 1px solid #ccc;
        }
        tr.border-top td, td.border-top {
            border-top: 1px solid #ccc;
        }
        tr.border-right td, td.border-right {
            border-right: 1px solid #ccc;
        }
        tr.border-left td, td.border-left {
            border-left: 1px solid #ccc;
        }
        tr.border-right td:last-child {
            border-right: 0px;
        }
        tr.center td, td.center {
            text-align: center;
            vertical-align: text-top;
        }
        td.pad-left {
            padding-left: 5px;
        }
        tr.right-center td, td.right-center {
            text-align: right;
            padding-right: 50px;
        }
        tr.right td, td.right {
            text-align: right;
        }
        .font-smallest{
            font-size: 8px;
            line-height: 10px;
            font-weight: bold;;
        }
        .font-smaller{
            font-size: 9px;
            line-height: 12px;
            font-weight: bold;;
        }
        .bold {
            font-weight: bold;
        }
        .no-bold{
            font-weight: normal !important;
        }
        .no-border-left {
            border-left:none !important;
        }
        .no-border-right {
            border-right:none !important;
        }
        .no-border {
            border: none !important;
        }
        .small-height{
            max-height: 10px;
            height: 10px;
            min-height: 10px;
            margin: 0px;
        }
        .word-break{
            word-break: break-all;
        }
        .text-center {
            text-align: center;
        }
        .padding-vertical {
            padding: 10px 0px
        }
        .pre {
            font-family:"Courier New";
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
</head>
<body>
<div id="page-wrap">
    <table width="100%">
        <tbody>
        <tr>
            <td rowspan="2" width="20%" valign="top">
                <img src="{$logo}" width="130px">
            </td>
            <td width="40%" valign="top">
                <strong>Nombre emisor:</strong>{$xmlData.emisor.Nombre}<br>
                <strong>RFC emisor:</strong> {$xmlData.emisor.Rfc}<br>
                <strong>Nombre receptor:</strong> {$xmlData.receptor.Nombre}<br>
                <strong>RFC receptor:</strong> {$xmlData.receptor.Rfc}<br>
                <strong>Uso CFDI:</strong> {$xmlData.receptor.UsoCFDI} {$catalogos.UsoCFDI}<br>
            </td>
            <td width="40%" valign="top">
                <strong>Folio fiscal:</strong> {$xmlData.timbreFiscal.UUID}<br>
                <strong>No. de serie del CSD:</strong> {$xmlData.cfdi.NoCertificado}<br>
                <strong>Lugar, fecha y hora de emisión:</strong> {$xmlData.cfdi.LugarExpedicion} {$xmlData.cfdi.Fecha|replace:'T':' '}<br>
                <strong>Efecto de comprobante:</strong> {$xmlData.cfdi.TipoDeComprobante} {$catalogos.EfectoComprobante}<br>
                <strong>Folio y serie:</strong> {$xmlData.cfdi.Serie} {$xmlData.cfdi.Folio}<br>
            </td>
        </tr>
        <tr>
            <td colspan="2" width="100%" valign="top">
                <strong>Régimen fiscal:</strong> {$xmlData.emisor.RegimenFiscal} {$catalogos.RegimenFiscal}
            </td>
        </tr>
        </tbody>
    </table>
    <p class="bold">Conceptos</p>
    {foreach from=$xmlData.conceptos item=concepto}
    <table width="100%" class="outline-table">
        <tbody>
        <tr class="border-bottom border-right center font-smallest">
            <td class="border-top" width="10%"><strong>Cve del producto/servicio</strong></td>
            <td class="border-top" width="10%"><strong>No. identification</strong></td>
            <td class="border-top" width="10%"><strong>Cantidad</strong></td>
            <td class="border-top" width="10%"><strong>Unidad</strong></td>
            <td class="border-top" width="10%"><strong>Valor unitario</strong></td>
            <td class="border-top" width="10%"><strong>Importe</strong></td>
            <td class="border-top" width="10%"><strong>Descuento</strong></td>
        </tr>
        <tr class="border-right border-bottom">
            <td class="left">{$concepto.concepto.ClaveProdServ}</td>
            <td class="left">{$concepto.NoIdentificacion}</td>
            <td class="left">{$concepto.concepto.Cantidad}</td>
            <td class="left">{$concepto.concepto.Unidad}</td>
            <td class="left">{$concepto.concepto.ValorUnitario}</td>
            <td class="left">{$concepto.concepto.Importe}</td>
            <td class="left">{$concepto.concepto.Descuento}</td>
        </tr>
        <tr class="border-right border-bottom">
            <td colspan="7" class="pad-left">{$concepto.concepto.Descripcion}</td>
        </tr>
        <tr class="border-right">
            <td colspan="3" width="100%" class="pad-left no-border-right">
                &nbsp;
            </td>
            <td colspan="4" width="100%" class="pad-left no-border-left padding-vertical">
                {if count($concepto.traslados) > 0}
                <table width="100%" class="outline-table no-border">
                    <tbody>
                    <tr class="border-bottom">
                        <td colspan="5" class="font-smaller"><strong>Traslados</strong></td>
                    </tr>
                    <tr class="border-bottom border-right center font-smallest">
                        <td class="border-left" width="15%"><strong>Base</strong></td>
                        <td width="10%"><strong>Impuesto</strong></td>
                        <td width="10%"><strong>Tipo factor</strong></td>
                        <td width="20%"><strong>Tasa o cuota</strong></td>
                        <td width="20%"><strong>Importe</strong></td>
                    </tr>
                    {foreach from=$concepto.traslados item=traslado}
                        <tr class="border-right font-smallest">
                            <td class="center border-bottom border-left">{$traslado.Base}</td>
                            <td class="center border-bottom">{$catalogos.impuestos[{$traslado.Impuesto}]}</td>
                            <td class="center border-bottom">{$traslado.TipoFactor}</td>
                            <td class="center border-bottom">{$traslado.TasaOCuota}</td>
                            <td class="center border-bottom">{$traslado.Importe}</td>
                        </tr>
                    {/foreach}
                    </tbody>
                </table>
                {/if}

                {if count($concepto.retenciones) > 0}
                <table width="100%" class="outline-table no-border">
                    <tbody>
                    <tr class="border-bottom">
                        <td colspan="5" class="font-smaller"><strong>Retenciones</strong></td>
                    </tr>
                    <tr class="border-bottom border-right center font-smallest">
                        <td class="border-left" width="15%"><strong>Base</strong></td>
                        <td width="10%"><strong>Impuesto</strong></td>
                        <td width="10%"><strong>Tipo factor</strong></td>
                        <td width="20%"><strong>Tasa o cuota</strong></td>
                        <td width="20%"><strong>Importe</strong></td>
                    </tr>
                    {foreach from=$concepto.retenciones item=retencion}
                    <tr class="border-right font-smallest">
                        <td class="center border-bottom border-left">{$retencion.Base}</td>
                        <td class="center border-bottom">{$catalogos.impuestos[{$retencion.Impuesto}]}</td>
                        <td class="center border-bottom">{$retencion.TipoFactor}</td>
                        <td class="center border-bottom">{$retencion.TasaOCuota}</td>
                        <td class="center border-bottom">{$retencion.Importe}</td>
                    </tr>
                    {/foreach}
                    </tbody>
                </table>
                {/if}

                {if $concepto.cuentaPredial.Numero}
                    Cuenta predial: {$concepto.cuentaPredial.Numero}
                {/if}
            </td>
        </tr>
        </tbody>
    </table>
    <p class="small-height">&nbsp;</p>
    {/foreach}

    <table width="100%">
        <tbody>
        <tr>
            <td width="60%" valign="top">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td width="50%" valign="top">
                            <strong>Moneda:</strong> {$xmlData.cfdi.Moneda}
                        </td>
                        <td width="50%" valign="top">
                            <strong>Forma de pago:</strong> {$xmlData.cfdi.FormaPago} {$catalogos.FormaPago}
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" valign="top">
                            <strong>Método de pago:</strong> {$xmlData.cfdi.MetodoPago} {$catalogos.MetodoPago}
                        </td>
                        <td width="50%" valign="top">
                            <strong>Condiciones de pago:</strong> {$xmlData.cfdi.CondicionesDePago}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="40%" valign="top">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td class="right" width="50%" valign="top">
                            <strong>Subtotal: $</strong>
                        </td>
                        <td class="right border-bottom" width="50%" valign="top">
                            <span class="underline">{$xmlData.cfdi.SubTotal}</span>
                        </td>
                    </tr>
                    {if $xmlData.cfdi.Descuento > 0}
                    <tr>
                        <td class="right" width="50%" valign="top">
                            <strong>Descuento: $</strong>
                        </td>
                        <td class="right border-bottom" width="50%" valign="top">
                            {$xmlData.cfdi.Descuento}
                        </td>
                    </tr>
                    {/if}
                    {if count($xmlData.impuestos.traslados) > 0}
                        <tr>
                            <td class="right" width="50%" valign="top">
                                <strong>Impuestos trasladados</strong>
                            </td>
                            <td class="right" width="50%" valign="top">
                                &nbsp;
                            </td>
                        </tr>
                        {foreach from=$xmlData.impuestos.traslados item=traslado}
                            <tr>
                                <td class="right" width="50%" valign="top">
                                    <strong>{$catalogos.impuestos[{$traslado.Impuesto}]}: $</strong>
                                </td>
                                <td class="right border-bottom" width="50%" valign="top">
                                    {$traslado.Importe}
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    {if $xmlData.impuestosLocales.ish.Importe > 0}
                        <tr>
                            <td class="right" width="50%" valign="top">
                                <strong>{$xmlData.impuestosLocales.ish.ImpLocTrasladado}: $</strong>
                            </td>
                            <td class="right border-bottom" width="50%" valign="top">
                                {$xmlData.impuestosLocales.ish.Importe}
                            </td>
                        </tr>
                    {/if}
                    {if count($xmlData.impuestos.retenciones) > 0}
                        <tr>
                            <td class="right" width="50%" valign="top">
                                <strong>Impuestos retenidos</strong>
                            </td>
                            <td class="right" width="50%" valign="top">
                                &nbsp;
                            </td>
                        </tr>
                        {foreach from=$xmlData.impuestos.retenciones item=retencion}
                            <tr>
                                <td class="right" width="50%" valign="top">
                                    <strong>{$catalogos.impuestos[{$retencion.Impuesto}]}: $</strong>
                                </td>
                                <td class="right border-bottom" width="50%" valign="top">
                                    {$retencion.Importe}
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    <tr>
                        <td class="right" width="50%" valign="top">
                            <strong>TOTAL: $</strong>
                        </td>
                        <td class="right border-bottom" width="50%" valign="top">
                            {$xmlData.cfdi.Total}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    {*Complemento de pagos*}
    {include file="pdf/complementoPago.tpl"}

    {*Complemento de nomina*}
    {include file="pdf/complementoNomina.tpl"}

    <p class=""><span class="no-bold word-break pre">{$xmlData.db.observaciones|urldecode}</span> </p>

    <table width="100%" class="font-smaller">
        <tbody>
        <tr>
            <td width="1-0%" valign="top" class="word-break">
                <strong>Total con letra:</strong><br>
                <span class="no-bold">{$xmlData.letra}</span>
            </td>
        </tr>
        <tr>
            <td width="1-0%" valign="top" class="word-break">
                <strong>Sello digital del CFDI:</strong><br>
                <span class="no-bold word-break">{$xmlData.timbreFiscal.SelloCFD|wordwrap:135:"<br />\n":true}</span>
            </td>
        </tr>
        <tr>
            <td width="1-0%" valign="top">
                <strong>Sello digital del SAT:</strong><br>
                <span class="no-bold word-break">{$xmlData.timbreFiscal.SelloSAT|wordwrap:135:"<br />\n":true}</span>
            </td>
        </tr>
        </tbody>
    </table>
    <table width="100%" class="font-smaller">
        <tbody>
        <tr>
            <td rowspan="2" width="30%" valign="top">
                <img width="200px" src="{$qrFile}">
            </td>
            <td width="70%" valign="top">
                <strong>Cadena Original del complemento de certificación digital del SAT:</strong> <br>
                <span class="no-bold word-break">{$xmlData.timbre.original|wordwrap:100:"<br />\n":true}</span>
            </td>
        </tr>
        <tr>
            <td width="70%" valign="top">
                <table width="100%" class="font-smaller">
                    <tbody>
                    <tr>
                        <td width="30%" valign="top">
                            <strong>Folio fiscal:</strong> <br>
                        </td>
                        <td width="70%" valign="top" class="no-bold">
                            {$xmlData.timbreFiscal.UUID}
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" valign="top">
                            <strong>No. de serie del certificado SAT:</strong> <br>
                        </td>
                        <td width="70%" valign="top" class="no-bold">
                            {$xmlData.timbreFiscal.NoCertificadoSAT}
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" valign="top">
                            <strong>Fecha y hora de certificación:</strong> <br>
                        </td>
                        <td width="70%" valign="top" class="no-bold">
                            {$xmlData.timbreFiscal.FechaTimbrado|replace:'T':' '}
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" valign="top">
                            <strong>RFC del proveedor de certificación:</strong> <br>
                        </td>
                        <td width="70%" valign="top" class="no-bold">
                            {$xmlData.timbreFiscal.RfcProvCertif}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
    <p class="text-center small-height">Este documento es una representación impresa de un CFDI</p>
    <p class="text-center small-height">www.comprobantedigital.mx</p>
</div>
</body>
</html>
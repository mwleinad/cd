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
        pre {
            line-height: 10px;
            white-space: pre-wrap;
        }
        .no-margin{
            margin: 0;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
</head>
<body>
<div id="page-wrap">

    {*TODO I really don't like this, the whole purpose of just having one version is defeated <_<*}
    {if $empresaId == 15 || $empresaId == 333 || $empresaId == 1356}
    <table width="100%">
        <tbody>
            <tr>
                <td colspan="2" width="100%" valign="top">
                    <img src="{$logoEscuela}" width="700px">
                </td>
            </tr>
        <tr>
            <td width="50%" valign="top">
                <strong>Nombre emisor:</strong>{$xmlData.emisor.Nombre}<br>
                <strong>RFC emisor:</strong> {$xmlData.emisor.Rfc}<br>
                <strong>Nombre receptor:</strong> {$xmlData.receptor.Nombre}<br>
                <strong>RFC receptor:</strong> {$xmlData.receptor.Rfc}<br>
                <strong>Uso CFDI:</strong> {$xmlData.receptor.UsoCFDI} {$catalogos.UsoCFDI}<br>
                {if $xmlData.cfdiRelacionados}
                    <strong>CFDI Relacionado:</strong> {$xmlData.cfdiRelacionados.uuid} <br>
                {/if}
                {if $xmlData.escuela.noControl} <strong># Control:</strong> {$xmlData.escuela.noControl} <br>{/if}
                {if $xmlData.escuela.carrera} <strong>Carrera:</strong> {$xmlData.escuela.carrera} <br>{/if}
            </td>
            <td width="50%" valign="top">
                <strong>Folio fiscal:</strong> {$xmlData.timbreFiscal.UUID}<br>
                <strong>No. de serie del CSD:</strong> {$xmlData.cfdi.NoCertificado}<br>
                <strong>Lugar, fecha y hora de emisión:</strong> {$xmlData.cfdi.LugarExpedicion} {$xmlData.cfdi.Fecha|replace:'T':' '}<br>
                <strong>Efecto de comprobante:</strong> {$xmlData.cfdi.TipoDeComprobante} {$catalogos.EfectoComprobante}<br>
                <strong>Folio y serie:</strong> {$xmlData.cfdi.Serie} {$xmlData.cfdi.Folio}<br>
                {if $xmlData.cfdiRelacionados}
                    <strong>Tipo relacion:</strong> {$xmlData.cfdiRelacionados.tipoRelacion} {$catalogos.CfdiRelacionado}<br>
                {/if}
                {if $xmlData.escuela.banco} <strong>Banco:</strong> {$xmlData.escuela.banco} {/if}<br>
                {if $xmlData.escuela.fechaDeposito} <strong>Fecha deposito:</strong> {$xmlData.escuela.fechaDeposito|urldecode} <br>{/if}
                {if $xmlData.escuela.referencia} <strong>Referencia:</strong> {$xmlData.escuela.referencia} <br>{/if}
            </td>
        </tr>
        <tr>
            <td colspan="2" width="100%" valign="top">
                <strong>Régimen fiscal:</strong> {$xmlData.emisor.RegimenFiscal} {$catalogos.RegimenFiscal}
            </td>
        </tr>
        </tbody>
    </table>
    {else}
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
                {if $xmlData.cfdiRelacionados}
                    <strong>CFDI Relacionado:</strong> {$xmlData.cfdiRelacionados.uuid} <br>
                {/if}
                {if $xmlData.escuela.noControl} <strong># Control:</strong> {$xmlData.escuela.noControl} {/if}<br>
                {if $xmlData.escuela.carrera} <strong>Carrera:</strong> {$xmlData.escuela.carrera} {/if}<br>
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
    {/if}

    <p class="bold no-margin">Conceptos</p>
    {foreach from=$xmlData.conceptos item=concepto}
    <table width="100%" class="outline-table">
        <tbody>
        <tr class="border-bottom border-right center font-smallest">
            <td class="border-top" width="5%"><strong>Cve del prd./ser.</strong></td>
            <td class="border-top" width="5%"><strong>Cve unidad</strong></td>
            <td class="border-top" width="10%"><strong>No. identification</strong></td>
            <td class="border-top" width="10%"><strong>Cantidad</strong></td>
            <td class="border-top" width="10%"><strong>Unidad</strong></td>
            <td class="border-top" width="10%"><strong>Valor unitario</strong></td>
            <td class="border-top" width="10%"><strong>Importe</strong></td>
            <td class="border-top" width="10%"><strong>Descuento</strong></td>
        </tr>
        <tr class="border-right border-bottom">
            <td class="left">{$concepto.concepto.ClaveProdServ}</td>
            <td class="left">{$concepto.concepto.ClaveUnidad}</td>
            <td class="left">{$concepto.concepto.NoIdentificacion}</td>
            <td class="left">{$concepto.concepto.Cantidad}</td>
            <td class="left">{$concepto.concepto.Unidad}</td>
            <td class="right">{$concepto.concepto.ValorUnitario|number:$xmlData.cfdi.Moneda}</td>
            <td class="right">{$concepto.concepto.Importe|number:$xmlData.cfdi.Moneda}</td>
            <td class="right">{$concepto.concepto.Descuento|number:$xmlData.cfdi.Moneda}</td>
        </tr>
        <tr class="border-right border-bottom">
            <td colspan="8" class="pad-left pre" style="font-family: monospace">
                {$concepto.concepto.Descripcion|nl2br|replace:" ":"&nbsp;"|replace:"[%]MAS[%]":"+"}

                {if $xmlData.amortizacionData.amortizacionFiniquitoSubtotal > 0 || $xmlData.amortizacionData.amortizacion > 0}
                    <table width="100%" class="">
                        {if $xmlData.amortizacionData.amortizacionFiniquitoSubtotal > 0}
                            <tr class="no-border">
                                <td class="no-border left" width="55%">{$xmlData.amortizacionData.amortizacionFiniquito|urldecode}</td>
                                <td class="no-border right" width="15%">SUBTOTAL</td>
                                <td class="no-border right" width="15%">{$xmlData.amortizacionData.amortizacionFiniquitoSubtotal|number:$xmlData.cfdi.Moneda}</td>
                                <td class="no-border right" width="15%">&nbsp;</td>
                            </tr>
                            <tr class="no-border">
                                <td class="no-border left" width="55%"></td>
                                <td class="no-border right" width="15%">IVA</td>
                                <td class="no-border right" width="15%">{$xmlData.amortizacionData.amortizacionFiniquitoIva|number:$xmlData.cfdi.Moneda}</td>
                                <td class="no-border right" width="15%"><u>{$xmlData.amortizacionData.amortizacionFiniquitoIva+$xmlData.amortizacionData.amortizacionFiniquitoSubtotal|number:$xmlData.cfdi.Moneda}</u></td>
                            </tr>
                        {/if}
                        {if $xmlData.amortizacionData.amortizacion > 0}
                            <tr class="no-border">
                                <td class="no-border left">AMORTIZACION DEL ANTICIPO</td>
                                <td class="no-border right">SUBTOTAL</td>
                                <td class="no-border right">{$xmlData.amortizacionData.amortizacion|number:$xmlData.cfdi.Moneda}</td>
                                <td class="no-border right">&nbsp;</td>
                            </tr>
                            <tr class="no-border">
                                <td class="no-border left"></td>
                                <td class="no-border right">IVA</td>
                                <td class="no-border right">{$xmlData.amortizacionData.amortizacionIva|number:$xmlData.cfdi.Moneda}</td>
                                <td class="no-border right"><u>{$xmlData.amortizacionData.amortizacionIva+$xmlData.amortizacionData.amortizacion|number:$xmlData.cfdi.Moneda}</u></td>
                            </tr>
                        {/if}
                        <tr>
                            <td colspan="4">
                                &nbsp;
                            </td>
                        </tr>
                        <tr class="no-border">
                            <td class="no-border left"></td>
                            <td class="no-border right"></td>
                            <td class="no-border right">ALCANCE LIQUIDO</td>
                            <td class="no-border right"><u>{$xmlData.cfdi.Total|number:$xmlData.cfdi.Moneda}</u></td>
                        </tr>
                    </table>
                {/if}
            </td>
        </tr>
        <tr class="border-right">
            <td colspan="3" width="100%" class="pad-left no-border-right">
                &nbsp;
            </td>
            <td colspan="5" width="100%" class="pad-left no-border-left padding-vertical">
                {if count($concepto.traslados) > 0}
                <table width="100%" class="outline-table no-border">
                    <tbody>
                    <tr class="border-bottom">
                        <td colspan="5" class="font-smaller">Traslados</strong></td>
                    </tr>
                    <tr class="border-bottom border-right center font-smallest">
                        <td class="border-left" width="15%">Base</strong></td>
                        <td width="10%"><strong>Impuesto</strong></td>
                        <td width="10%"><strong>Tipo factor</strong></td>
                        <td width="20%"><strong>Tasa o cuota</strong></td>
                        <td width="20%"><strong>Importe</strong></td>
                    </tr>
                    {foreach from=$concepto.traslados item=traslado}
                        <tr class="border-right font-smallest">
                            <td class="center border-bottom border-left">{$traslado.Base|number:$xmlData.cfdi.Moneda}</td>
                            <td class="center border-bottom">{$catalogos.impuestos[{$traslado.Impuesto}]}</td>
                            <td class="center border-bottom">{$traslado.TipoFactor}</td>
                            <td class="center border-bottom">{$traslado.TasaOCuota}</td>
                            <td class="center border-bottom">{$traslado.Importe|number:$xmlData.cfdi.Moneda}</td>
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
                        <td class="center border-bottom border-left">{$retencion.Base|number:$xmlData.cfdi.Moneda}</td>
                        <td class="center border-bottom">{$catalogos.impuestos[{$retencion.Impuesto}]}</td>
                        <td class="center border-bottom">{$retencion.TipoFactor}</td>
                        <td class="center border-bottom">{$retencion.TasaOCuota}</td>
                        <td class="center border-bottom">{$retencion.Importe|number:$xmlData.cfdi.Moneda}</td>
                    </tr>
                    {/foreach}
                    </tbody>
                </table>
                {/if}

                {if $concepto.cuentaPredial.Numero}
                    Cuenta predial: {$concepto.cuentaPredial.Numero}
                {/if}

                {if $concepto.instEducativas}
                    Nombre alumno: {$concepto.instEducativas[0].nombreAlumno}<br>
                    CURP: {$concepto.instEducativas[0].CURP}<br>
                    RVOE: {$concepto.instEducativas[0].autRVOE}<br>
                    Nivel educativo: {$concepto.instEducativas[0].nivelEducativo}<br>
                {/if}

            </td>
        </tr>
        </tbody>
    </table>
    <p class="small-height">&nbsp;</p>
    {/foreach}
    {if isset($xmlData.db.status) && $xmlData.db.status == 0}
        <span style="font-size: 96px; color: #f00; text-align: center">CANCELADO</span>
    {elseif !isset($xmlData.db.status)}
        <span style="font-size: 48px; color: #f00; text-align: center">VISTA PREVIA</span>
    {/if}

    {*Complemento de impuestos*}
    {include file="{$DOC_ROOT}/templates/pdf/complementoImpuestos.tpl"}

    <p class=""><span class="no-bold word-break pre">{$xmlData.db.observaciones|urldecode|replace:"[%]MAS[%]":"+"}</span> </p>

    {*Totales*}
    {include file="{$DOC_ROOT}/templates/pdf/totales.tpl"}


    {if ($empresaId == 15 || $empresaId == 333 || $empresaId == 1356) && $xmlData.impuestosLocales|count == 0}
        <table width="100%" class="outline-table">
            <tbody>
            <tr class="border-bottom border-right center font-smallest">
                <td class="border-top" width="50%"><strong>Nombre y firma del cajero</strong></td>
                <td class="border-top" width="50%"><strong>Sello</strong></td>
            </tr>
            <tr class="border-right border-bottom">
                <td class="left">&nbsp;<br>&nbsp;</td>
                <td class="left">&nbsp;<br>&nbsp;</td>
            </tr>
            </tbody>
        </table>
    {/if}

    {if $xmlData.firmasLocales}
        <table width="100%" class="outline-table">
            <tbody>
                <tr class="border-bottom border-right center font-smallest">
                    {foreach from=$xmlData.firmasLocales item=firma}
                        <td class="border-top" width="20%"><strong>{$firma.nombre}<br><br><br>{$firma.valor|nl2br}</strong></td>
                    {/foreach}
                </tr>
            </tbody>
        </table>
    {/if}
    {*Complemento de pagos*}
    {include file="{$DOC_ROOT}/templates/pdf/complementoPago.tpl"}

    {*Complemento de nomina*}
    {include file="{$DOC_ROOT}/templates/pdf/complementoNomina.tpl"}

    {*Complemento de nomina*}
    {include file="{$DOC_ROOT}/templates/pdf/complementoDonatarias.tpl"}

    {*Cadenas y timbres*}
    {include file="{$DOC_ROOT}/templates/pdf/cadenasTimbres.tpl"}

    <p class="text-center small-height">Este documento es una representación impresa de un CFDI</p>
    <p class="text-center small-height">www.comprobantedigital.mx</p>
</div>
</body>
</html>

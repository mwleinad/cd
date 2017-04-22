<html>
<head>
<title>Ticket de Venta</title>
<style type="text/css">
.txtTicket{
	font-size:{$fontSize}px;
}
</style>
</head>
<body>
<table width="200" align="center" cellpadding="0" cellspacing="0" border="0" class="txtTicket">
{if $mode != "descuento"}
<tr>
	<td align="center">
    	<b>{$infE.razonSocial|urldecode}</b>
        <br><br>
        <b>DOMICILIO FISCAL</b>
        {if $infE.calle}
            <br />{$infE.calle|urldecode}
        {/if}
        {if $infE.noExt}
             {$infE.noExt}
        {/if}
        {if $infE.noInt}
            {$infE.noInt}
        {/if}
        {if $infE.colonia}
         <br />COL. {$infE.colonia|urldecode}
        {/if}
        {if $infE.cp}
         <br />C.P. {$infE.cp} 
        {/if}
        {if $infE.ciudad}
          {$infE.ciudad|urldecode} 
        {/if}
        {if $infE.municipio}
          , {$infE.municipio|urldecode} 
        {/if}
        {if $infE.estado}
          , {$infE.estado|urldecode} 
        {/if}
        <br /> RFC. {$infE.rfc}         
        {if $infE.telefono}
          <br /> TEL. {$infE.telefono} 
        {/if}
        <br />&nbsp;
    </td>
</tr>
<tr>
	<td align="center">
        <b>DOMICILIO ESTABLECIMIENTO</b>
        {if $infS.nombre}
            <br />{$infS.nombre}
        {/if}
        {if $infS.calle}
            <br />{$infS.calle}
        {/if}
        {if $infS.noExt}
             {$infS.noExt}
        {/if}
        {if $infS.noInt}
            {$infS.noInt}
        {/if}
        {if $infS.colonia}
         <br />COL. {$infS.colonia}
        {/if}
        {if $infS.cp}
         <br />C.P. {$infS.cp} 
        {/if}
        {if $infS.ciudad}
          {$infS.ciudad} 
        {/if}
        {if $infS.municipio}
          , {$infS.municipio} 
        {/if}
        {if $infS.estado}
          , {$infS.estado} 
        {/if}
        <br /> RFC. {$infE.rfc} 
        {if $infS.telefono}
          <br /> TEL. {$infS.telefono} 
        {/if}
    </td>
</tr>
<tr>
	<td align="center">
    ------------------------------------------
    <br />
    <b>NOTA DE VENTA</b>
    </td>
</tr>
{/if}
<tr>
	<td align="center">
    ------------------------------------------
    </td>
</tr>
{*}<tr>
	<td align="left">
    <b>VENDEDOR:</b> {$info.vendedor}
    </td>
</tr>
<tr>
	<td align="left">
    <b>CAJERO:</b> {$info.usuario}
    </td>
</tr>{*}
<tr>
	<td align="center">
    ------------------------------------------
        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="txtTicket">
        <tr>
            <td align="center" width="33%"><b>TICKET</b> <br /> {$info.notaVentaId}</td>
            <td align="center"><b>FECHA</b> <br /> {$info.fecha}</td>
            <td align="center" width="33%"><b>HORA</b> <br />{$info.hora}</td>
        </tr>
        </table>
    ------------------------------------------
    </td>
</tr>
<tr>
	<td align="left">
    	<table width="90%" cellpadding="0" cellspacing="0" border="0" class="txtTicket">
        <tr>
        	<td colspan="3">
            <b>DESCRIPCION</b>
            </td>
        </tr>
        <tr>
            <td align="center" width="33%"><b>CANT.</b></td>
            <td align="center"><b>PRECIO</b></td>
            <td align="center" width="33%"><b>IMPORTE</b></td>
        </tr>
        <tr>
        	<td align="center" colspan="3">------------------------------------------</td>
        </tr>
        {foreach from=$productos item=item}
        <tr>
        	<td colspan="3">
           	{$item.descripcion}
            </td>
        </tr>
        <tr>
            <td align="center" width="33%">{$item.cantidad}</td>
            <td align="center">{$item.precioUnitario|number_format:2:'.':','}</td>
            <td align="right" width="33%">{$item.total|number_format:2:'.':','}</td>
        </tr>
        
        {if $item.tipoDesc != ""}
        <tr>
        	<td align="center">Desc.</td>
            <td align="center">{$item.valDesc} {if $item.tipoDesc == "Porcentaje"}%{/if}</td>
            <td align="right">{$item.totalDesc|number_format:2:'.':','}</td>
        </tr>
        {/if}
        
        {/foreach}
        
        <tr>
        	<td align="center" colspan="3">&nbsp;</td>
        </tr>        
        <tr>
            <td align="left" width="33%">SUBTOTAL</td>
            <td align="right" colspan="2">{$info.subtotal|number_format:2:'.':','}</td>
        </tr>
        
        {if $info.tipoDesc != ""}
        <tr>
            <td align="left" width="33%">DESC. {if $info.tipoDesc == "Porcentaje"}{$info.valDesc}%{/if}</td>
            <td align="right" colspan="2">- {$info.descuento|number_format:2:'.':','}</td>
        </tr>
        <tr>
            <td align="left" width="33%">SUBTOTAL</td>
            <td align="right" colspan="2">{$info.subtotal2|number_format:2:'.':','}</td>
        </tr>
        {/if}
        
        <tr>
            <td align="left" width="33%">IVA</td>
            <td align="right" colspan="2">{$info.iva|number_format:2:'.':','}</td>
        </tr>                        
        <tr>
        	<td align="center" colspan="3">------------------------------------------</td>
        </tr>
        <tr>
            <td align="left" width="33%"><b>TOTAL</b></td>
            <td align="right" colspan="2"><b>{$info.total|number_format:2:'.':','}</b></td>
        </tr>
        <tr>
        	<td align="center" colspan="3">------------------------------------------</td>
        </tr>
        {*if $mode != "descuento"}
        <tr>
            <td align="left" width="33%">SU PAGO</td>
            <td align="right" colspan="2">{$info.pago|number_format:2:'.':','}</td>
        </tr>
        <tr>
            <td align="left" width="33%">SU CAMBIO</td>
            <td align="right" colspan="2">{$info.cambio|number_format:2:'.':','}</td>
        </tr>
        {/if*}
        </table>
   </td>
</tr>
<tr>
	<td align="center">&nbsp;</td>
</tr>
<tr>
	<td align="center">
    	<b>GRACIAS POR SU COMPRA</b>
        <br />
        Regimen General de Ley Personas Morales
    </td>
</tr>
<tr>
	<td align="center">
    	<b>CT: {$codigoFacturacion}</b>
    </td>
</tr>
</table>
{if $mode != "descuento"}
<script type="text/javascript">
{if $mode == "cobro"}
	window.print();
	//window.close();
{else}
	var resp = confirm("Desea imprimir este ticket?");
	if(resp)
		window.print();
{/if}
</script>
{/if}
</body>
</html>
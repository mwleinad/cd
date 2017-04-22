{include file="boxes/white_open.tpl"}
<div align="center">
	{if in_array("create", $nuevosPermisos.cliente)}
    <a href="javascript:void(0)" class="inline_add"id="addCliente"><span>Agregar Nuevo Cliente</span></a>        
	{/if}
</div>
<br />

<table width="100%" cellpadding="0" cellspacing="0" id="box-table-a">
<thead>
  <tr>
    <th align="center"><div align="center">B&uacute;squeda por RFC o Nombre</div></th>
  </tr>
</thead>
<tbody>
  <tr>
    <td align="center"><input type="text" size="35" name="rfcbusqueda" id="rfcbusqueda" class="largeInput" onkeyup="Search()"/></td>
  </tr>  
</tbody>
</table>
<br />
<div id="empresaClientesDiv">
{include file="lists/cliente.tpl"}
</div>

{include file="boxes/white_close.tpl"}
<div id="boxVik">
</div>
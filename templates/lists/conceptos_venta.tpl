{if count($conceptos)}
<table width="100%" cellpadding="0" cellspacing="0" id="box-table-a">
  <thead>
    <tr>
      <th width="50" scope="col">&nbsp;</th>
      <th width="50" scope="col">Cantidad</th>
      <th width="50" scope="col">Unidad</th>
      <th width="50" scope="col"># Identificacion</th>
      <th width="500" scope="col">Descripci&oacute;n</th>
      <th width="100" scope="col">Precio Unitario</th>
      <th width="100" scope="col">Importe</th>
      <th width="50" scope="col">Excento Iva</th>
      <th width="100" scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$conceptos item=concepto key=key}
     {include file="{$DOC_ROOT}/templates/items/concepto_base_ventas.tpl"}
  {/foreach}
   </tbody>
  </table>
{else}
No se encontraron conceptos  
{/if}
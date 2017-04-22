{if count($conceptos)}
<table width="100%" cellpadding="0" cellspacing="0" id="box-table-a">
  <thead>
    <tr>
      <th width="50" scope="col">&nbsp;</th>
      <th width="50" scope="col">Cant.</th>
      <th width="50" scope="col">Unid.</th>
      <th width="50" scope="col">Id.</th>
 {*}     <th width="100" scope="col">Categor&iacute;a</th>{*}
      <th width="500" scope="col">Descripci&oacute;n</th>
      <th width="100" scope="col">Valor Unitario</th>
      <th width="100" scope="col">Importe</th>
      <th width="50" scope="col">Exento Iva</th>
{*}      <th width="50" scope="col">E. Ish</th>{*}
      <th width="50" scope="col">IEPS</th>
      <th width="100" scope="col">Acciones</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$conceptos item=concepto key=key}
     {include file="{$DOC_ROOT}/templates/items/concepto_base.tpl"}
  {/foreach}
   </tbody>
  </table>
{else}
No se encontraron conceptos  
{/if}
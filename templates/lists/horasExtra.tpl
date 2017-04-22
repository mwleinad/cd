
{if count($horasExtras)}

   <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed">Datos Generales</div>
		<div class="portlet-content nopadding">
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
            <thead>
              <tr>
                <th width="50" scope="col">&nbsp;</th>
                <th width="100" scope="col">Tipo Horas.</th>
                <th width="100" scope="col">D&iacute;as.</th>
                <th width="100" scope="col">Horas Extra.</th>
                <th width="100" scope="col">Importe Pagado.</th>
                <th width="100" scope="col">Total</th>
                <th width="100" scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
	{foreach from=$horasExtras item=horaExtra key=key}
		{include file="{$DOC_ROOT}/templates/items/horaExtra_base.tpl"}
	{/foreach}
    </tbody>
    </table>
    </div>
    </div>
{else}
No se encontraron conceptos  
{/if}
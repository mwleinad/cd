
{if count($deducciones)}

   <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">
        <div class="portlet-header fixed">Datos Generales</div>
		<div class="portlet-content nopadding">
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
            <thead>
              <tr>
                <th width="50" scope="col">&nbsp;</th>
                <th width="100" scope="col">Clave.</th>
                <th width="200" scope="col">Deducci&oacute;n.</th>
                <th width="100" scope="col">Importe Gravado.</th>
                <th width="100" scope="col">Importe Excento.</th>
                <th width="100" scope="col">Total</th>
                <th width="100" scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody>
	{foreach from=$deducciones item=deduccion key=key}
		{include file="{$DOC_ROOT}/templates/items/deduccion_base.tpl"}
	{/foreach}
    </tbody>
    </table>
    </div>
    </div>
{else}
No se encontraron conceptos  
{/if}
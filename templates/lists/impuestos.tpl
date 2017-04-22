{if count($impuestos)}

        <div class="portlet-header fixed">Datos Generales</div>
		<div class="portlet-content nopadding">
        <form action="" method="post">
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
            <thead>
              <tr>
                <th width="50" scope="col">&nbsp;</th>
                <th width="50" scope="col">Tasa.</th>
                <th width="400" scope="col">Nombre.</th>
                <th width="100" scope="col">Tipo.</th>
                <th width="100" scope="col">Importe</th>
                <th width="100" scope="col">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
            

<div id="">
</div>
	{foreach from=$impuestos item=impuesto key=key}
		{include file="{$DOC_ROOT}/templates/items/impuesto_base.tpl"}
	{/foreach}
{else}
No se encontraron impuestos o retenciones Extras 
{/if}
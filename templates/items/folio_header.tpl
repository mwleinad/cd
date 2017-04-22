<div class="clear"></div>
<!--THIS IS A WIDE PORTLET-->
<div class="portlet">
    <div class="portlet-header fixed">
    {if $info.limite > 0}
                Se han utilizado {$info.expedidos} Timbres de {$info.limite} disponibles.
    {else} 
        Tu paquete contiene folios ilimitados.
    {/if}</div>
    <div class="portlet-content nopadding">
      <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a" summary="Employee Pay Sheet">
        <thead>
          <tr>
            <th width="80"><div align="center">Serie</div></th>
            <th width="80"><div align="center">Ini</div></th>
            <th width="80"><div align="center">Con</div></th>
            <th width=""><div align="center">Logo</div></th>
            {if $info.version == "auto"}
            <th width="80">QR</th>
            {/if}
            <th width="80"><div align="center"></div></th>
            <th width="100"><div align="center">Acci&oacute;n</div></th>
          </tr>
        </thead>
        <tbody>
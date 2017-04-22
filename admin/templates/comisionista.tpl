<div id="ordenesDiv">
    <div align="center">
  		{*include file="forms/ordenesFiltro.tpl"*}
    </div>
    
    <div id="content" class="content">
        {include file="lists/comisionista.tpl"}
    </div>

    <div id="content" class="reporteSocios">
        {foreach from=$data.countRazonSocial key=key item=item}
        <div>
        	<div style="float:left; width:300px">
          	{$key}
          </div>
          <div style="float:left">
          	{$item}
          </div>
          <div style="clear:both"></div>
        </div>
        {/foreach}
    </div>
    
</div>
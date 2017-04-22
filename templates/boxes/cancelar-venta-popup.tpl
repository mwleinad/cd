		<div class="popupheader" style="z-index:70"> 
		<div id="fviewmenu" style="z-index:70">
	    <div id="fviewclose"><span style="color:#CCC" id="closePopUpDiv">
        <a href="javascript:void(0)">Close<img src="{$WEB_ROOT}/images/b_disn.png" border="0" alt="close" /></a></span>
      </div>
      </div>

      <div id="ftitl">
    	<div class="flabel">&nbsp;</div>
			<div id="vtitl">
            	<span title="Titulo">Cancelaci&oacute;n de Venta
        			<br />
                    <br />Id Venta: {$id_venta} 
                </span>
           </div>
    </div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
    		<img src="{$WEB_ROOT}/images/draganddrop.png" border="0" alt="mueve" />
   	</div>
		</div>
		
    <div class="wrapper">
    <div id="cancelLoading">
    </div>
    	{if $status == 1}
			{include file="{$DOC_ROOT}/templates/forms/motivo-cancelacion-venta.tpl"}
		{else}
        	<div class="m">La venta ya fue cancelada.</div>
        {/if}
    </div>
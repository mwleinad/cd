  
 	<div id="fview" style="display:none;">	
 	  <div id="fviewload" style="display:block"><img src="{$WEB_ROOT}/images/load.gif" border="0" /></div>
 	 	<div id="fviewcontent" style="display:none"></div>
 	</div>
<div id="top">
	<div id="logo">
  		<div style="position:relative; top:20px">
            <img src="{$WEB_ROOT}/images/facturase-logo.png" width="200" height="80" border="0"/>
           {*} <a href="http://www.trazzos.com" target="_blank">
                <img src="http://www.trazzos.com/newtrazzos/images/trazzos-logo.gif" width="150" height="60" border="0"/>
            </a>{*}
 		</div>
    <div style="position:relative">
  		<div style="position:absolute; top:-20px; left:600px; width:550px">
      		{if !$info}
            {include file="forms/login.tpl"}
          {else}
          	<div class="registerinputblank">
          	<span style="color:#003">RFCs:</span> <select id="rfcId" name="rfcId">
            	{foreach from=$empresaRfcs item=rfc}
              	<option value="{$rfc.rfcId}" {if $rfc.activo == 'si'}selected="selected"{/if}>{$rfc.rfc}</option>
              {/foreach}
            </select>  
            </div>
            <div id="cambiarRfcButton" name="cambiarRfcButton" class="signup" style="cursor:pointer">Cambiar</div>
          {/if} 
	 		</div>
    </div>
		{include file="menus/main-avantika.tpl"}
  	</div>
</div>




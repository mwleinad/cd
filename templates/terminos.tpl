<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabAviso">
            	<a href="javascript:void(0)" onclick="ShowTab('Terminos')">T&eacute;rminos y Condiciones del Servicio</a>
            </li>
        </ul><!-- e tab menu -->
                
        <ul id="boxes">            
            <li id="Aviso" class="box" style="background-color:#666">                
            {if $info.rfc}
                {include file="{$DOC_ROOT}/templates/content/terminos-terminos.tpl"}
            {else}
                {include file="{$DOC_ROOT}/templates/content/terminos-terminos-t.tpl"}
            {/if}    
                <span></span>
            </li>
        </ul><!-- e: boxes -->
            
    </div><!-- e: global wrapping #box -->

		<!-- Bodybox end -->
		<br class="spacer" />

</div>

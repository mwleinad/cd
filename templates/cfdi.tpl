<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabPac">
            	<a href="javascript:void(0)" onclick="ShowTab('Pac')">PYMES PAC o CORPORATIVO PAC</a>
            </li>
            <li id="tabInfoSat">
            	<a href="javascript:void(0)" onclick="ShowTab('InfoSat')">INFOSAT</a>
            </li>
            <li id="tabPresentacion">
            	<a href="javascript:void(0)" onclick="ShowTab('Presentacion')">Presentaci&oacute;n CFDI</a>
            </li>
        </ul><!-- e tab menu -->
                
        <ul id="boxes">            
            <li id="Pac" class="box">                
                {include file="{$DOC_ROOT}/templates/content/cfdi-pac.tpl"}
                <span></span>
            </li>
            <li id="InfoSat" class="box" style="display:none">                
                {include file="{$DOC_ROOT}/templates/content/cfdi-infosat.tpl"}
                <span></span>
            </li>
            <li id="Presentacion" class="box" style="display:none">                
                {include file="{$DOC_ROOT}/templates/content/cfdi-presentacion.tpl"}
                <span></span>
            </li>                          
        </ul><!-- e: boxes -->
        
            
    </div><!-- e: global wrapping #box -->

		<!-- Bodybox end -->
		<br class="spacer" />

</div>

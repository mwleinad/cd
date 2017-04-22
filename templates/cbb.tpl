<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabAutoImp">
            	<a href="javascript:void(0)" onclick="ShowTab('AutoImp')">Auto-Impreso PYMES</a>
            </li>
            <li id="tabPresentacion">
            	<a href="javascript:void(0)" onclick="ShowTab('Presentacion')">Presentaci&oacute;n CBB</a>
            </li>
        </ul><!-- e tab menu -->
                
        <ul id="boxes">            
            <li id="AutoImp" class="box">                
                {include file="{$DOC_ROOT}/templates/content/cbb-autoimpreso.tpl"}
                <span></span>
            </li>
            <li id="Presentacion" class="box" style="display:none">                
                {include file="{$DOC_ROOT}/templates/content/cbb-presentacion.tpl"}
                <span></span>
            </li>                          
        </ul><!-- e: boxes -->
        
            
    </div><!-- e: global wrapping #box -->

		<!-- Bodybox end -->
		<br class="spacer" />

</div>

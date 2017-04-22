<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabFacturase">
            	<a href="javascript:void(0)" onclick="ShowTab('Facturase')">Facturase</a>
            </li>
            <li id="tabActualizaciones">
            	<a href="javascript:void(0)" onclick="ShowTab('Actualizaciones')">Actualizaciones</a>
            </li>
            <li id="tabSoporte">
            	<a href="javascript:void(0)" onclick="ShowTab('Soporte')">Soporte y Capacitaci&oacute;n</a>
            </li>
        </ul><!-- e tab menu -->
                
        <ul id="boxes">            
            <li id="Facturase" class="box">                
                {include file="{$DOC_ROOT}/templates/content/beneficios-facturase.tpl"}
                <span></span>
            </li>
            <li id="Actualizaciones" class="box" style="display:none">
                {include file="{$DOC_ROOT}/templates/content/beneficios-actualizaciones.tpl"}
                <span></span>
            </li>
            <li id="Soporte" class="box" style="display:none">                
                {include file="{$DOC_ROOT}/templates/content/beneficios-soporte.tpl"}
                <span></span>
            </li>          
        </ul><!-- e: boxes -->
            
    </div><!-- e: global wrapping #box -->

		<!-- Bodybox end -->
		<br class="spacer" />

</div>

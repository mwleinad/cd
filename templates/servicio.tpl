<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabFacturase">
            	<a href="javascript:void(0)" onclick="ShowTab('Facturase')">Demo Facturase</a>
            </li>
            <li id="tabCaracteristicas">
            	<a href="javascript:void(0)" onclick="ShowTab('Caracteristicas')">Caracter&iacute;sticas</a>
            </li>
            <li id="tabVentajas">
            	<a href="javascript:void(0)" onclick="ShowTab('Ventajas')">Ventajas</a>
            </li>
        </ul><!-- e tab menu -->
                
        <ul id="boxes">            
            <li id="Facturase" class="box">                
                {include file="{$DOC_ROOT}/templates/content/servicio-facturase.tpl"}
                <span></span>
            </li>
            <li id="Caracteristicas" class="box" style="display:none">                
                {include file="{$DOC_ROOT}/templates/content/servicio-caracteristicas.tpl"}
                <span></span>
            </li>
            <li id="Ventajas" class="box" style="display:none">                
                {include file="{$DOC_ROOT}/templates/content/servicio-ventajas.tpl"}
                <span></span>
            </li>                          
        </ul><!-- e: boxes -->
        
            
    </div><!-- e: global wrapping #box -->

		<!-- Bodybox end -->
		<br class="spacer" />

</div>

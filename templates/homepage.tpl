<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
	
    <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabSistemas">
            	<a href="javascript:void(0)" onClick="ShowTab('Sistemas')">Sistemas</a>
            </li>
            <li id="tabCaracteristicas">
            	<a href="javascript:void(0)" onClick="ShowTab('Caracteristicas')">Caracter&iacute;sticas</a>
            </li>
            <li id="tabFolios">
            	<a href="javascript:void(0)" onClick="ShowTab('Folios')">Folios</a>
            </li>
            <li id="tabEsquema">
            	<a href="javascript:void(0)" onClick="ShowTab('Esquema')">Esquema de Facturaci&oacute;n</a>
            </li>
            <li id="tabAdendas">
            	<a href="javascript:void(0)" onClick="ShowTab('Adendas')">Adendas</a>
            </li>                 
        </ul><!-- e tab menu -->
                
        <ul id="boxes">            
            <li id="Sistemas" class="box"> 
                {include file="{$DOC_ROOT}/templates/content/planes-sistemas.tpl"}
                <span></span>
            </li>            
            <li id="Caracteristicas" class="box" style="display:none"> 
                {include file="{$DOC_ROOT}/templates/content/planes-caracteristicas.tpl"}
                <span></span>
            </li>
            <li id="Folios" class="box" style="display:none"> 
                {include file="{$DOC_ROOT}/templates/content/planes-folios.tpl"}
                <span></span>
            </li>
            <li id="Esquema" class="box" style="display:none"> 
                {include file="{$DOC_ROOT}/templates/content/planes-esquema.tpl"}
                <span></span>
            </li>
            <li id="Adendas" class="box" style="display:none"> 
                {include file="{$DOC_ROOT}/templates/content/planes-adendas.tpl"}
                <span></span>
            </li>                         
        </ul><!-- e: boxes -->
            
    </div><!-- e: global wrapping #box -->
    
</div>
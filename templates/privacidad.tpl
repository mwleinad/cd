<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabAviso">
            	<a href="javascript:void(0)" onclick="ShowTab('Aviso')">Aviso de Privacidad</a>
            </li>
            <li id="tabAnexo1">
            	<a href="javascript:void(0)" onclick="ShowTab('Anexo1')">Anexo 1</a>
            </li>
            <li id="tabAnexo2">
            	<a href="javascript:void(0)" onclick="ShowTab('Anexo2')">Anexo 2</a>
            </li>
            <li id="tabAnexo3">
            	<a href="javascript:void(0)" onclick="ShowTab('Anexo3')">Anexo 3</a>
            </li>
        </ul><!-- e tab menu -->
        {if $info.rfc}        
        <ul id="boxes">            
            <li id="Aviso" class="box" style="background-color:#999">                
                {include file="{$DOC_ROOT}/templates/content/privacidad-aviso.tpl"}
                <span></span>
            </li>
            <li id="Anexo1" class="box" style="display:none;background-color:#999">
                {include file="{$DOC_ROOT}/templates/content/privacidad-anexo1.tpl"}
                <span></span>
            </li>
            <li id="Anexo2" class="box" style="display:none;background-color:#999">                
                {include file="{$DOC_ROOT}/templates/content/privacidad-anexo2.tpl"}
                <span></span>
            </li>          
            <li id="Anexo3" class="box" style="display:none;background-color:#999">                
                {include file="{$DOC_ROOT}/templates/content/privacidad-anexo3.tpl"}
                <span></span>
            </li>          
        </ul><!-- e: boxes -->
        {else}
        <ul id="boxes">            
            <li id="Aviso" class="box" style="background-color:#999">                
                {include file="{$DOC_ROOT}/templates/content/privacidad-aviso-t.tpl"}
                <span></span>
            </li>
            <li id="Anexo1" class="box" style="display:none;background-color:#999">
                {include file="{$DOC_ROOT}/templates/content/privacidad-anexo1.tpl"}
                <span></span>
            </li>
            <li id="Anexo2" class="box" style="display:none;background-color:#999">                
                {include file="{$DOC_ROOT}/templates/content/privacidad-anexo2.tpl"}
                <span></span>
            </li>          
            <li id="Anexo3" class="box" style="display:none;background-color:#999">                
                {include file="{$DOC_ROOT}/templates/content/privacidad-anexo3.tpl"}
                <span></span>
            </li>          
        </ul><!-- e: boxes -->
        {/if}
            
    </div><!-- e: global wrapping #box -->

		<!-- Bodybox end -->
		<br class="spacer" />

</div>

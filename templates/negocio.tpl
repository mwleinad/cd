<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box">
	
        <ul id="menu">
            <li class="activo" id="tabPlan">
            	<a href="javascript:void(0)" onclick="ShowTab('Plan')">Plan de Negocios</a>
            </li>
            <li id="tabFunciona">
            	<a href="javascript:void(0)" onclick="ShowTab('Funciona')">C&oacute;mo Funciona</a>
            </li>
            <li id="tabPromotores">
            	<a href="javascript:void(0)" onclick="ShowTab('Promotores')">Promotores</a>
            </li>
            <li id="tabInversionistas">
            	<a href="javascript:void(0)" onclick="ShowTab('Inversionistas')">Inversionistas</a>
            </li>            
        </ul><!-- e tab menu -->
                
        <ul id="boxes">            
            <li id="Plan" class="box">                
                {include file="{$DOC_ROOT}/templates/content/negocio-plan.tpl"}
                <span></span>
            </li>
            <li id="Funciona" class="box" style="display:none">
                {include file="{$DOC_ROOT}/templates/content/negocio-funciona.tpl"}
                <span></span>
            </li>
            <li id="Promotores" class="box" style="display:none">
                {include file="{$DOC_ROOT}/templates/content/negocio-promotor.tpl"}
                <span></span>
            </li>
            <li id="Inversionistas" class="box" style="display:none">
                {include file="{$DOC_ROOT}/templates/content/negocio-inversionista.tpl"}
                <span></span>
            </li>                    
        </ul><!-- e: boxes -->
            
    </div><!-- e: global wrapping #box -->

		<!-- Bodybox end -->
		<br class="spacer" />

</div>

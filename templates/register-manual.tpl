<div class="leftSide">
	
    {include file="{$DOC_ROOT}/templates/menus/mnuNav.tpl"}
    
</div>

<div class="rightSide">
		
        <div id="box"  style="background-color:#09C">
	
        <ul id="menu">
            <li class="activo" id="tabPersonal">
            	<a href="javascript:void(0)" onclick="ShowTab('Personal')">Por favor, ingresa tus datos</a>
            </li>
        </ul><!-- e tab menu -->
        
        <form id="registerForm" name="registerForm" method="post">
        <input type="hidden" name="type" id="type" value="" />  
        <ul id="boxes">            
            <li id="Personal" class="box">                
                {include file="{$DOC_ROOT}/templates/content/register-personal.tpl"}
                <span></span>
            </li>
        </ul><!-- e: boxes -->
        </form>
            
    </div><!-- e: global wrapping #box -->

		

</div>
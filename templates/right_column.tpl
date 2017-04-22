			<div id="right">
				<div class="find-car">
        	{if !$user}
          	{include file="forms/login.tpl"}
          {else}
          	{include file="menus/right_menu.tpl"}
          {/if} 
				</div><!-- find car close -->
				<div class="sell-car">
        
       	{include file="templates/tips/{$includedTpl}.tpl"}	

				</div><!-- sell car close -->
				
   		{include file="menus/footermenu.tpl"}
			</div><!-- right close -->
      
      <div class="spacer">&nbsp;</div>
      
    <div id="centeredDiv" class="statuscssbox" style="margin:auto; position:fixed; top:50%; left:50%; margin-top:-75px;margin-left:-250px;z-index:70; display:none">
      <div class="statuscssbox_head">
			{if !empty($errors)}
      	<h3>
    			{if $errors.complete}
			    	<img src="{$WEB_ROOT}/images/ok.gif" style="cursor:pointer" onclick="ToogleStatusDiv()"/>
    			{else}
	       		<img src="{$WEB_ROOT}/images/error.gif" style="cursor:pointer" onclick="ToogleStatusDiv()"/>
    			{/if}  
       	</h3>
       	<div id="close_icon" style="position:absolute;top: 10px; left: 460px;"><img src="{$WEB_ROOT}/images/close_icon.gif" onclick="ToogleStatusDiv()" style="cursor:pointer"/></div>
      	</div>
      	<div class="statuscssbox_body">
       	<p>  
      	{foreach from=$errors.value item="error" key="key"}
    			{$error}
    			{if $errors.field.$key}
       			Campo: {$errors.field.$key}
    			{/if} 
     			<br />
  			{/foreach}
      	</p>
      {/if}  
      </div>
    </div>

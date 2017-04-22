			{if !empty($errors)}
        {foreach from=$errors.value item="error" key="key"}
    			{$error}
    			{if $errors.field.$key}
       			 : {$errors.field.$key}
    			{/if} 
     			<br />
  			{/foreach}
      {/if}  

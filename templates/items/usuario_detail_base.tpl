<div id="friendsBaseDiv{$user.userId}">
	{foreach from=$vs item=item key=key}
    <div id="friendsBaseUserId{$user.userId}">
      <b>{$key}</b>: {$item}
    </div>
  {/foreach}
</div>
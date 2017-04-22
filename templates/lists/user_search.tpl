{if count($users)}
	{foreach from=$users item=user key=key}
		{include file="{$DOC_ROOT}/templates/items/user_base.tpl"}
	{/foreach}
  {include file="{$DOC_ROOT}/templates/lists/pages_ajax.tpl" pages=$pages}
{/if}
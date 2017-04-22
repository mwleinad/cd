<div id="content">
	{include file="lists/contacto.tpl"}
	{if count($__contacto.pages)}
    {include file="lists/pages.tpl" pages=$__contacto.pages}
  {/if}
</div>

<div class="popupheader" style="z-index:70">
	<div id="fviewmenu" style="z-index:70">
		<div id="fviewclose"><span style="color:#CCC" id="closePopUpDiv">Cerrar<img src="{$WEB_ROOT}/images/b_disn.png" border="0" alt="close" /></span>
		</div>
	</div>
	<div id="ftitl">
		<div class="flabel">Cambio de Precios</div>
		<div id="vtitl"><span title="Titulo">Cambio Precios</span></div>
	</div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
		<img src="{$WEB_ROOT}/images/draganddrop.png" style="cursor:pointer" border="0" alt="mueve" />
	</div>
</div>
<div class="wrapper">
	{include file="{$DOC_ROOT}/templates/boxes/datos-basicos.tpl" item=$info}
  
	{*include file="{$DOC_ROOT}/templates/forms/edit-price.tpl"*}
</div>

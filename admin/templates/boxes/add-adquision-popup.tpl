

<div class="popupheader" style="z-index:70">
	<div id="fviewmenu" style="z-index:70">
		<div id="fviewclose"><span style="color:#CCC" id="closePopUpDiv">Cerrar<img src="{$WEB_ROOT}/images/b_disn.png" border="0" alt="close" /></span>
		</div>
	</div>
	<div id="ftitl">
		<div class="flabel">ADQUISICION DE FOLIOS PARA {$post.nombre|upper}</div>
		<div id="vtitl"><span title="Titulo">ADQUISICION DE FOLIOS PARA {$post.nombre|upper}</span></div>
	</div>
	<div id="draganddrop" style="position:absolute;top:45px;left:640px">
		<img src="{$WEB_ROOT}/images/draganddrop.png" border="0" alt="desplaza" />
	</div>
</div>
<div class="wrapper">
	{include file="{$DOC_ROOT}/templates/forms/add-adqFolios.tpl"}
</div>

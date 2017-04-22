<div id="friendsBaseDiv{$usuario.userId}">
	<div id="friendsBaseUserId{$usuario.userId}" style="float:left; width:30px">
	  {$usuario.userId}
  </div>
	<div style="float:left;width:100px">
	  {$usuario.username}
  </div>
	<div style="float:left;width:100px">
	  <span class="linkEditar" style="cursor:pointer">Editar</span>
	  <span class="linkDetalles" style="cursor:pointer">Detalles</span>
  </div>
	<div style="float:left;width:200px" id="statusPagoDiv{$usuario.userId}">
  {include file="{$DOC_ROOT}/templates/items/status_pago_base.tpl"}
  </div>
	<div style="float:left;width:100px">
	  <span class="linkDetalles" style="cursor:pointer">Hijos: {$usuario.hijos}</span>
	  <span class="linkDetalles" style="cursor:pointer">Nietos: {$usuario.nietos}</span>
  </div>
	<div style="float:left;width:50px">
	  <span class="linkDetalles" style="cursor:pointer">Linea Activa: {$usuario.enLineaActiva}</span>
  </div>
	<div style="float:left;width:80px">
	  <span >password: <b>{$usuario.password}</b></span>
  </div>
  <div style="clear:both"></div>
</div>
<hr />

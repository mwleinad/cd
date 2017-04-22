	  <span>Status</span>
    {if $usuario.flagPago == "si"}
	  	<span class="linkTogglePago">Pagado: ${$usuario.cantidad} | 
      <span class="linkPagoCancelar" id="divPagoCancelar{$usuario.userId}" style="cursor:pointer">Cancelar Pago</span></span>
    {else}
      Por Pagar 
        $<span class="linkPagoNivelUno" id="divPagoNivelUno{$usuario.userId}" style="cursor:pointer">{$empresa.activacionNivelUno}</span> | 
        $<span class="linkPagoNivelDos" id="divPagoNivelDos{$usuario.userId}" style="cursor:pointer">{$empresa.activacionNivelDos}</span> |
        $<span class="linkPagoNivelTres" id="divPagoNivelTres{$usuario.userId}" style="cursor:pointer">{$empresa.activacionNivelTres}</span>
    {/if}  

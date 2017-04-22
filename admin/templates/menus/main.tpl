

	<ul id="nav" class="level0">               
      <li><a href="{$WEB_ROOT}">Inicio</a>      
      </li>
    </ul>
		<ul id="nav" class="level0">               
      <li><a href="{$WEB_ROOT}/reporte-new">Reporte de Ingresos</a>
      </li>
    </ul>

		<ul id="nav" class="level0">               
      <li><a href="http://facturase.com/erpt">Pendientes por Cobrar</a>
      </li>
    </ul>
	
	
    {if $info.tipo == "admin"}
		<ul id="nav" class="level0">               
      <li>Administrador              
        <ul class="level1">
          <li>
            <a href="{$WEB_ROOT}/usuario">Usuarios</a>
          </li>
		    <li>
            <a href="{$WEB_ROOT}/paqFolios">Paquete de Folios</a>
          </li>
        </ul>
      </li>
    </ul>
	{/if}
	
	{if $info.tipo}
	
	<ul class="level0">
      <li>Ordenes              
        <ul class="level1">
          <li>
            <a href="{$WEB_ROOT}/ordenes">Clientes</a>      
          </li>
		     {if $info.tipo == "admin" || $info.tipo == "partner" || $info.tipo == "partnerPro"}  
          <li>
            <a href="{$WEB_ROOT}/ventas">Venta de Folios</a> 
          </li>          
		  {/if}
      {if $info.tipo == "admin"}
          <li>
            <a href="{$WEB_ROOT}/nominas">Renovar o Activar Modulo Nominas</a> 
          </li>
          <li>
            <a href="{$WEB_ROOT}/impuestos">Renovar o Activar Modulo Impuestos</a> 
          </li>
      {/if}
        </ul>
      </li>
 	</ul>	
	
	{/if}




 

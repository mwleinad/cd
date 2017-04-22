   <div class="clear"></div>
    <!--THIS IS A WIDE PORTLET-->
    <div class="portlet">

		<div class="portlet-content nopadding">
        <form action="" method="post">
          <table width="100%" cellpadding="0" cellspacing="0" id="box-table-a">
            <thead>
              <tr>
                <th width=""><div align="center">Nombre</div></th>
                <th width=""><div align="center"># Empleado</div></th>
                <th width=""><div align="center">Email</div></th>
                <th width=""><div align="center">Password</div></th>
                <th width=""><div align="center">Tipo de Usuario</div></th>
                <th width=""><div align="center">Sucursal</div></th>
                {if $info.moduloNomina == "Si"}
                <th width=""><div align="center">Nomina</div></th>
                {/if}
                <th width=""><div align="center">Acciones</div></th>
              </tr>
            </thead>
            <tbody>
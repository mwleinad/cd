<div class="container_16">
  <div class="grid_6 prefix_5 suffix_5">
   	  <h1>{$SITENAME|lower|capitalize} - Cliente - Login</h1>
    	<div id="login">
    	  <p class="tip">Presiona el bot&oacute;n y estar&aacute;s dentro!</p>
          <p class="error" id="errorLoginDiv"></p>        
    	  <form id="loginForm" name="loginForm" method="post" action="">
          	<input type="hidden" name="tipoLogin" id="tipoLogin" value="cliente" />
    	    <p>
    	      <label><strong>RFC Emisor</strong>
<input type="text" name="rfc" class="inputText" id="rfc" />
    	      </label>
  	      </p>
    	    <p>
    	      <label><strong>Email</strong>
<input type="text" name="email" class="inputText" id="email" />
    	      </label>
  	      </p>
    	    <p>
    	      <label><strong>Password</strong>
  <input type="password" name="password" class="inputText" id="password" />
  	        </label>
    	    </p>
    		<a class="black_button"><span id="login_01">Autentificacion&nbsp;</span></a>
             <label>
             <input type="checkbox" name="checkbox" id="checkbox" />
              Recordarme</label>            
    	  </form>
		  <br clear="all" />
    	</div>
        <div id="forgot">
        <a href="{$WEB_ROOT}/registro-cliente" class="forgotlink"><span>O Registrase en la Pagina</span></a></div>
  </div>
</div>

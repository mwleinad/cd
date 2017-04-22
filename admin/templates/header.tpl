  <div id="fview" style="display:none;">	
	  <input type="hidden" id="inputs_changed" value="0" />  	
		<div id="fviewload" style="display:block"><img src="{$WEB_ROOT}/images/load.gif" border="0" /></div>
		<div id="fviewcontent" style="display:none"></div>
		<div id="modal">
			<div id="submodal">
				Close without saving?<br />
				<a href="#" id="modalyes">Yes</a>&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="#" id="modalno">No</a>
			</div>
		</div>
	</div>

<div id="header">
   <form name="zappa" action="index.php" method="post" id="zappa">
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="mode" value="save" />
        <input type="hidden" name="sort" value="priority" />
    	<input type="hidden" name="dir" value="1" />
        <input type="hidden" name="show" value="today" />
        <input type="hidden" name="finishedt" value="" />
        
        <input type="hidden" name="userFilter" id="userFilter" value="" />
        <input type="hidden" name="requesterFilter" id="requesterFilter" value="" />
        <input type="hidden" name="projectFilter" id="projectFilter" value="" />   
        <input type="hidden" name="contextFilter" id="contextFilter" value="" />        
   </form>     
	<div id="header1">
  	<div id="userlogout"><span id="logoutDiv" style="cursor:pointer" title="Logout">
    <img id="frk-logout" src="{$WEB_ROOT}/images/logout.png" style="position: relative; top: -3px" border="0"/></span>
    </div>
    <div id="user">
    	<div id="usernamenotime">Bienvenido {$info.username}</div>
    </div>
    <div id="titAdmin">Admin Facturase</div>
  </div>

  <div id="header2">
    <div id="menu">
      {include file="menus/main.tpl"}
    </div>
    <div id="rightmenu">
      {include file="menus/right.tpl"}
    </div>
  </div>

</div>

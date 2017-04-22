<?php /* Smarty version Smarty3-b7, created on 2016-02-20 09:55:12
         compiled from "./templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:167370089556c8a880271038-21571287%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97c13ae6868bbc459509c9f1b968154acd23eecc' => 
    array (
      0 => './templates/header.tpl',
      1 => 1455433643,
    ),
  ),
  'nocache_hash' => '167370089556c8a880271038-21571287',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
  <div id="fview" style="display:none;">	
	  <input type="hidden" id="inputs_changed" value="0" />  	
		<div id="fviewload" style="display:block"><img src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/load.gif" border="0" /></div>
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
    <img id="frk-logout" src="<?php echo $_smarty_tpl->getVariable('WEB_ROOT')->value;?>
/images/logout.png" style="position: relative; top: -3px" border="0"/></span>
    </div>
    <div id="user">
    	<div id="usernamenotime">Bienvenido <?php echo $_smarty_tpl->getVariable('info')->value['username'];?>
</div>
    </div>
    <div id="titAdmin">Admin Facturase</div>
  </div>

  <div id="header2">
    <div id="menu">
      <?php $_template = new Smarty_Internal_Template("menus/main.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

    </div>
    <div id="rightmenu">
      <?php $_template = new Smarty_Internal_Template("menus/right.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>

    </div>
  </div>

</div>

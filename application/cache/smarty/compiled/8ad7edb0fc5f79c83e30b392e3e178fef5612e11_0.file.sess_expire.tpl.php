<?php
/* Smarty version 3.1.28, created on 2024-02-08 12:13:07
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/sess_expire.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c477fb090a27_51936508',
  'file_dependency' => 
  array (
    '8ad7edb0fc5f79c83e30b392e3e178fef5612e11' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/sess_expire.tpl',
      1 => 1706090555,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c477fb090a27_51936508 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/modifier.date_format.php';
?>
<div class="container-fluid">
    <div class="errorContainer">
        <div class="page-header">
            <h1 class="center">Session <small>expired</small></h1>
        </div>
        <h2 class="center errormsg">Your session is expired. Please login again.</h2>
        <div class="center">
            <a href="<?php echo $_smarty_tpl->tpl_vars['login_entry_url']->value;?>
?_=<?php echo smarty_modifier_date_format(time(),'%Y%m%d%H%M%S');?>
"  class="btn btn-default"><span class="icon16 icomoon-icon-enter"></span>Login here</a>
        </div>
    </div>
</div><?php }
}

<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:51:59
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_login_template.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c456e7f176a0_16588567',
  'file_dependency' => 
  array (
    'ca57571145ac43653e8e9f812c06e6e7a860e155' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_login_template.tpl',
      1 => 1706087703,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top/top_login.tpl' => 1,
    'file:bottom/bottom.tpl' => 1,
  ),
),false)) {
function content_65c456e7f176a0_16588567 ($_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <base href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
" />
        <title><?php echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('CPANEL_TITLE');?>
</title>
        <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCompanyFavIconURL();?>
" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <meta http-equiv="cache-control" content="no-cache" />
        <meta http-equiv="pragma" content="no-cache" />
        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("forms/validate.css","admin/style.css","admin/icons.css","admin/font-awesome.css","bootstrap/bootstrap.css","misc/jquery.ui.pattern.css","bootstrap/main.css");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_DISPLAY'))."/theme.css","theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_DISPLAY'))."/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN')),"theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_CUSTOMIZE')));?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src("login");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("admin/basic/jquery-ui-1.9.2.min.js","admin/bootstrap/bootstrap.js","admin/misc/cookie/jquery.cookie.js","admin/misc/mouse/jquery.mousewheel.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("admin/validate/jquery.validate.js","admin/misc/pattern/jquery.ui.pattern.js");?>

        <?php echo '<script'; ?>
 type="text/javascript">
            var admin_url = "<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
", admin_image_url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('admin_images_url');?>
";
            var js_lang_label = {
                GENERIC_FORGOT_PASSWORD_USERNAME_ERR : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseTPLMessage('GENERIC_FORGOT_PASSWORD_USERNAME_ERR');?>
",
                GENERIC_LOGIN_USERNAME_ERR : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseTPLMessage('GENERIC_LOGIN_USERNAME_ERR');?>
",
                GENERIC_LOGIN_PASSWORD_ERR : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseTPLMessage('GENERIC_LOGIN_PASSWORD_ERR');?>
",
                GENERIC_RESET_PASSWORD_ERR : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseTPLMessage('GENERIC_RESET_PASSWORD_ERR');?>
",
                GENERIC_RESET_RETYPE_PASSWORD_ERR : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseTPLMessage('GENERIC_RESET_RETYPE_PASSWORD_ERR');?>
",
                GENERIC_RESET_RETYPE_SAME_ERR : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseTPLMessage('GENERIC_RESET_RETYPE_NOT_MATCH_ERR');?>
",
                GENERIC_RESET_SECURITY_CODE_ERR : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseTPLMessage('GENERIC_RESET_SECURITY_CODE_ERR');?>
"
            }
        <?php echo '</script'; ?>
>
    </head>
    <body>
        <div class="top-bg <?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN_HEAD');?>
">
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:top/top_login.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        </div>
        <div class="login-main-page">
            <?php $_smarty_tpl->tpl_vars["error_box"] = new Smarty_Variable("display:none;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_box", 0);?>
            <?php $_smarty_tpl->tpl_vars["error_class"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_class", 0);?>
            <?php $_smarty_tpl->tpl_vars["error_close"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_close", 0);?>
            <?php $_smarty_tpl->tpl_vars["message_box"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "message_box", 0);?>
            <?php if ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('success') != '') {?>
                <?php $_smarty_tpl->tpl_vars["error_class"] = new Smarty_Variable("alert-success", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_class", 0);?>
                <?php $_smarty_tpl->tpl_vars["error_close"] = new Smarty_Variable("success", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_close", 0);?>
                <?php $_smarty_tpl->tpl_vars["error_box"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_box", 0);?>
                <?php $_smarty_tpl->tpl_vars["message_box"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('success'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "message_box", 0);?>
            <?php } elseif ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('failure') != '') {?>   
                <?php $_smarty_tpl->tpl_vars["error_class"] = new Smarty_Variable("alert-error", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_class", 0);?>
                <?php $_smarty_tpl->tpl_vars["error_close"] = new Smarty_Variable("error", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_close", 0);?>
                <?php $_smarty_tpl->tpl_vars["error_box"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "error_box", 0);?>
                <?php $_smarty_tpl->tpl_vars["message_box"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('failure'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "message_box", 0);?>
            <?php }?> 
            <div class="errorbox-position" id="var_msg_cnt" style="<?php echo $_smarty_tpl->tpl_vars['error_box']->value;?>
">
                <div class="closebtn-errorbox <?php echo $_smarty_tpl->tpl_vars['error_close']->value;?>
" id="closebtn_errorbox">
                    <a href="javascript://" onClick="Project.closeMessage();"><button class="close" type="button">×</button></a>
                </div>
                <div class="content-errorbox alert <?php echo $_smarty_tpl->tpl_vars['error_class']->value;?>
" id="err_msg_cnt"><?php echo $_smarty_tpl->tpl_vars['message_box']->value;?>
</div>
            </div>            
            <div class="content-login" id="content_login" class="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN_BODY');?>
">
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, $_smarty_tpl->tpl_vars['include_script_template']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            </div>
        </div>
        <div class="login-bottom-page">
            <div>
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:bottom/bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            </div>
        </div>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src("login");?>

    </body>
</html>
<?php }
}

<?php
/* Smarty version 3.1.28, created on 2024-12-08 19:22:51
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/login.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_6756628b65d632_38347860',
  'file_dependency' => 
  array (
    '0ebcbb552dbe786adf8f72abc59a1b5cf67d4134' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/login.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6756628b65d632_38347860 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("login.js");?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $_smarty_tpl->tpl_vars['heading']->value;?>
Login </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
user/login_action" id="login-form-normal" class="form-horizontal">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="User_Email">Username / Email <span class="required text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input value="" type="text" class="form-control" id="User_vUserName" name="User[vUserName]" maxlength="50" size="60" />
                    </div>
                    <span id="vUserNameErr"></span>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="User_vPassword">Password <span class="required text-danger">*</span></label>
                    <div class="col-sm-4">
                        <input value=""  type="password" class="form-control" id="User_vPassword" name="User[vPassword]" maxlength="255" size="60" />
                    </div>
                    <span id="vPasswordErr"></span>
                </div>
                <div class="form-group">
                    <div class="checkbox col-sm-offset-2 col-sm-4">
                        <label><input type="checkbox" name="remember_me" value="Yes" id="remember_me" style="margin-top:0;"> Keep me logged in</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button name="submit" type="submit" class="btn btn-success" id="login">Login</button>&nbsp;
                        <a href="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
" class="btn btn-danger">Cancel</a>
                        <a class="btn btn-link" id="forgot_password" href="forgot-password.html" title="Forgot Password">Forgot Password?</a>
                    </div>
                </div>
            </form>      
        </div>
    </div>
</div>
<?php }
}

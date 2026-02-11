<?php
/* Smarty version 3.1.28, created on 2024-04-02 16:00:36
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/register.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_660bde4c8bbc60_16906092',
  'file_dependency' => 
  array (
    '818c53123b59d18119a01652da3eb08500315c44' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/register.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_660bde4c8bbc60_16906092 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("register.js");?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $_smarty_tpl->tpl_vars['heading']->value;?>
</div>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <form method="post" action="<?php if ($_smarty_tpl->tpl_vars['type']->value == 'register') {
echo base_url('user/register_action');
} else {
echo base_url('user/profile');
}?>" id="frm<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" class="form-horizontal">
                <div class="col-md-12">
                     <div class="form-group">
                        <label class="col-sm-2 control-label" for="User_vFirstName">First Name <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="User_vFirstName" name="User[vFirstName]" maxlength="50" size="60" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['firstname'];?>
" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="User_vLastName">Last Name <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="User_vLastName" name="User[vLastName]" maxlength="50" size="60" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['lastname'];?>
"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="User_vEmail">Email <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="User_vEmail" name="User[vEmail]" maxlength="50" size="60" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
" <?php if ($_smarty_tpl->tpl_vars['type']->value != 'register') {?>readonly=true<?php }?> />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="User_vUserName">User Name <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="User_vUserName" name="User[vUserName]" maxlength="50" size="60" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
" <?php if ($_smarty_tpl->tpl_vars['type']->value != 'register') {?>readonly=true<?php }?> />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="User_vPassword">Password <span class="text-danger">*</span></label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="User_vPassword" autocomplete="off" name="User[vPassword]" maxlength="255" size="60" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['password'];?>
" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?php if ($_smarty_tpl->tpl_vars['type']->value == 'register') {?>
                                <button name="submit" type="submit" class="btn btn-success" id="login">Register</button>&nbsp;
                                <a href="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
" class="btn btn-danger">Cancel</a>
                            <?php } else { ?>
                                <input type="hidden" name="userId" id="userId" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
"/>
                                <input name="update" type="submit" class="btn btn-success" value="Update"/>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
" class="btn btn-danger">Back</a>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><?php }
}

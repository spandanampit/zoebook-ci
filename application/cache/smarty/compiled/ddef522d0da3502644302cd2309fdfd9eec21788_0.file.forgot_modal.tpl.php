<?php
/* Smarty version 3.1.28, created on 2024-02-21 06:40:26
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/forgot_modal.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65d59adabbb356_33467338',
  'file_dependency' => 
  array (
    'ddef522d0da3502644302cd2309fdfd9eec21788' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/forgot_modal.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65d59adabbb356_33467338 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/forgotpassword.js");?>

<div class="modal fade cmn-modal" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<form class="cmn-form" id="frmforgotpassword" name="frmforgotpassword" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/forgotpassword_action');?>
">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">Forgot Password</h5>
      </div>
      <div class="modal-body">
        <h6>Please enter your registered email address</h6>
        
          <div class="form-group input-group">
            <div class="w-100 position-relative">
              <div class="input-group-append">
                <span class="input-group-text"><i class="far fa-envelope"></i></span>
              </div>
              <input type="email" class="form-control email-input" aria-describedby="emailHelp" placeholder="Email" id="vForgotEmail" name="User[vForgotEmail]">
            </div>
            <div class="error-msg-form" id='vForgotEmailErr'></div>
          </div>
          
        
      </div>
      <div class="modal-footer justify-content-center" style="margin-bottom:10px;">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel">Cancel</button>
        <button type="submit" class="btn btn-primary" id="submitforgot">Submit</button>
      </div>
    </div>
  </div>
  </form>
</div><?php }
}

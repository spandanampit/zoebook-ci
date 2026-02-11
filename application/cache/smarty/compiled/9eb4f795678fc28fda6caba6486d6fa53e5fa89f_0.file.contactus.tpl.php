<?php
/* Smarty version 3.1.28, created on 2024-01-31 14:17:06
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/content/views/contactus.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65ba090a60f2a5_54471927',
  'file_dependency' => 
  array (
    '9eb4f795678fc28fda6caba6486d6fa53e5fa89f' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/content/views/contactus.tpl',
      1 => 1706090576,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65ba090a60f2a5_54471927 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/contactus.js");?>

<div class="page-heading">
  <h2>Contact us</h2>
</div> 
<div class="page-content-row">
  <div class="container">
    <div class="contact-form-block">
        <form class="cmn-form" id="frmcontact" name="frmcontact" method="post" >
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="form-group input-group">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="far fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="vContactName" name="vContactName" placeholder="First Name">
                  <div class="error-msg-form" id='vContactNameErr'></div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12">
                <div class="form-group input-group">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="email" class="form-control email-input" id="vContactEmail" name="vContactEmail" aria-describedby="emailHelp" placeholder="john@zoebook.com">
                  <div class="error-msg-form" id='vContactEmailErr'></div>
                </div>
              </div>
              <div class="col-lg-12 col-md-12">
                <div class="form-group input-group">
                  <div class="input-group-append icon-top">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <textarea rows="3" cols="100" class="form-control" id="vContactMessage" name="vContactMessage" maxlength="999" placeholder="Message" style="resize:none"></textarea>
                  <div class="error-msg-form" id='vContactMessageErr'></div>
                </div>
              </div>
            </div>

            <div class="g-recaptcha" data-sitekey="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('GOOGLE_CAPTCHA_SITE_KEY');?>
"></div>
            <div style="padding-bottom:10px;"></div>
            <button type="submit" class="btn btn-primary w-100" id="submitcontact" name="submitcontact">Send</button>
        </form>
    </div>
  </div>
</div><?php }
}

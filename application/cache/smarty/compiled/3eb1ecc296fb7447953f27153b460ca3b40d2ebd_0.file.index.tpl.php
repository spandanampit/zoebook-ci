<?php
/* Smarty version 3.1.28, created on 2024-01-31 04:37:26
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/content/views/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9ce86799bc3_50944167',
  'file_dependency' => 
  array (
    '3eb1ecc296fb7447953f27153b460ca3b40d2ebd' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/content/views/index.tpl',
      1 => 1706090577,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9ce86799bc3_50944167 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/login.js");?>

<div class="landing-content">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-md-6">
        <div class="content-block">
          <h1>Zoebook</h1>
          <p>The Viral-Based Social Media that focuses on distributing user content to every single user that's on its platform for 48 hours respectively</p>
          <div class="app-button">
            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('PLAY_STORE_LINK');?>
" target="_blank" class="btn">
              <i>
                <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/google-play.svg" alt="" class="svg">
              </i>
              <h6><span>Get it on</span>Google Play</h6>
            </a>
            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('APP_STORE_LINK');?>
" target="_blank" class="btn">
              <i>
                <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/apple.svg" alt="" class="svg apple-icon ">
              </i>
              <h6><span>Download on the</span>App Store</h6>
            </a>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-6 d-flex justify-content-end">
        <div class="login-block">
          <form class="cmn-form" id="frmlogin" name="frmlogin" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/login_action');?>
">
            <div class="form-title">
              <h3>Login</h3>
              <p>It's quick and easy.</p>
            </div>
            <div class="form-group input-group">
              <div class="w-100 position-relative">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="far fa-envelope"></i></span>
                </div>
                <input type="email" class="form-control email-input" aria-describedby="emailHelp" placeholder="Email" id="vLoginEmail" name="User[vLoginEmail]">  
              </div>
              <div class="error-msg-form" id='vLoginEmailErr'></div>
            </div>

            <div class="form-group input-group">
              <div class="w-100 position-relative">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control" id="vLoginPassword" name="User[vLoginPassword]" placeholder="Password">
                <a href="javascript:void(0)" class="forgot-link" data-toggle="modal" data-target="#forgotModal">Forgot?</a>
              </div>
              <div class="error-msg-form" id='vLoginPasswordErr'></div>
            </div>

            <button type="submit" class="btn w-100" id="submitlogin">Login</button>
            </form>
            <div class="other-login text-center ">

              Or Sign in with
              <a href="<?php echo $_smarty_tpl->tpl_vars['fbauthURL']->value;?>
" class="fblogin" title="Facebook" data-id="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('FB_APP_ID');?>
"><i class="fab fa-facebook-f"></i></a>
              <a href="<?php echo $_smarty_tpl->tpl_vars['googleloginURL']->value;?>
" title="Google" class="googlelogin"><i class="fab fa-google-plus-g"></i></a>
            </div>

            <div class="signup-row text-center">
              <p>Don’t have an account?  <a href="javascript:void(0)" data-toggle="modal" data-target="#signupModal">Sign Up</a></p>
            </div>
          
        </div>
      </div>

    </div>
  </div>
</div><?php }
}

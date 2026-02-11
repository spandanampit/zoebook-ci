<?php
/* Smarty version 3.1.28, created on 2025-01-30 03:44:40
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_679b662819bed4_10703598',
  'file_dependency' => 
  array (
    '5b45b71f0f296844d1e5c69b0e0382c6bdfac7ce' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/index.tpl',
      1 => 1738237477,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_679b662819bed4_10703598 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<section class="login-sec">
    <div class="container-fluid p-0">
      <div class="row gx-0">
        <div class="col-lg-6 col-md-12">
          <div class="log-in-img">
            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/logo.png" class="login" alt="">
            <h3><?php echo $_smarty_tpl->tpl_vars['welcome']->value;?>
</h3>
            <p><?php echo $_smarty_tpl->tpl_vars['login_text']->value;?>
</p>
            <div class="filter-store">
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('PLAY_STORE_LINK');?>
" target="_blank">
                  <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/play-store.png" alt="">
                </a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('APP_STORE_LINK');?>
">
                  <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/apple-store.png" alt="">
                </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 custom-scroll">
          <div class="login-form-box">
            <div class="login-form-heading">
              <h3><?php echo $_smarty_tpl->tpl_vars['login']->value;?>
</h3>
              <p><?php echo $_smarty_tpl->tpl_vars['its_quick_and_easy']->value;?>
</p>
            </div>
            <div class="login-form">
              <form class="cmn-form" id="frmlogin" name="frmlogin" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/login_action');?>
">
                <div class="form-group">
                  <label for="vLoginEmail"><?php echo $_smarty_tpl->tpl_vars['email']->value;?>
</label>
                  <input type="email" class="form-control email-input" id="vLoginEmail" aria-describedby="emailHelp" placeholder="email@domain.com" name="User[vLoginEmail]">
                </div>
                <div class="error-msg-form" id='vLoginEmailErr'></div>
                
                <div class="form-group">
                  <label for="vLoginPassword"><?php echo $_smarty_tpl->tpl_vars['password']->value;?>
</label>
                  <input type="password" class="form-control" id="vLoginPassword" name="User[vLoginPassword]" placeholder="Password">
                </div>
                <div class="error-msg-form" id='vLoginPasswordErr'></div>

                <div class="form-forgot">
                  <a href="javascript:void(0)" class="forgot-linkk" data-toggle="modal" data-target="#forgotModal"><?php echo $_smarty_tpl->tpl_vars['forgot_password']->value;?>
?</a>
                </div>
                <button type="submit" class="btn btn-primary form-btn"><?php echo $_smarty_tpl->tpl_vars['submit']->value;?>
</button>
              </form>
            </div>
            <div class="form-divider">
              <p>Or</p>
            </div>
            <div class="form-social">
              <ul>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['fbauthURL']->value;?>
" class="fblogin" title="Facebook" data-id="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('FB_APP_ID');?>
"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['googleloginURL']->value;?>
" title="Google" class="googlelogin"><i class="fa-brands fa-google-plus-g"></i></a></li>
              </ul>
            </div>
            <div class="signup-box">
              <p><?php echo $_smarty_tpl->tpl_vars['dont_have_an_account']->value;?>
? <a href="javascript:void(0)" data-toggle="modal" data-target="#signupModal"><?php echo $_smarty_tpl->tpl_vars['sign_up']->value;?>
</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
   </section>

   <?php echo '<script'; ?>
>
    $(".box-switch").on("click", () => {
            $("body").toggleClass("dark");
         });
   <?php echo '</script'; ?>
>
   <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/posts.js");
}
}

<?php
/* Smarty version 3.1.28, created on 2025-01-28 05:25:42
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/signup.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_6798dad6c29072_67634009',
  'file_dependency' => 
  array (
    'fa01e94478926d041d28de3bf1e5551d92210185' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/user/views/signup.tpl',
      1 => 1738070737,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6798dad6c29072_67634009 ($_smarty_tpl) {
?>
<section class="login-sec">
    <div class="container-fluid p-0">
      <div class="row gx-0">
        <div class="col-lg-6 col-md-12">
          <div class="log-in-img">
            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/logo.png" class="login" alt="">
            <h3><?php echo $_smarty_tpl->tpl_vars['welcome']->value;?>
</h3>
            <p><?php echo $_smarty_tpl->tpl_vars['distraction_fact']->value;?>
</p>
            <div class="filter-store">
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('PLAY_STORE_LINK');?>
">
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
              <h3><?php echo $_smarty_tpl->tpl_vars['sign_up']->value;?>
</h3>
              <p><?php echo $_smarty_tpl->tpl_vars['its_quick_and_easy']->value;?>
</p>
            </div>
            <div class="login-form">
              <form name="frmregister" id="frmregister" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/register_action');?>
" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="vEmail"><?php echo $_smarty_tpl->tpl_vars['email']->value;?>
</label>
                  <input type="email" class="form-control email-input" aria-describedby="emailHelp" id="vEmail" name="User[vEmail]" placeholder="email@domain.com">
                </div>
                <div class="error-msg-form" id='vEmailErr'></div>

                <div class="form-group">
                  <label for="vName"><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</label>
                  <input type="text" class="form-control" id="vName" name="User[vName]" placeholder="Name">
                </div>
                <div class="error-msg-form" id='vNameErr'></div>
                
                <div class="form-group">
                  <label for="vPassword"><?php echo $_smarty_tpl->tpl_vars['password']->value;?>
</label>
                  <input type="password" class="form-control" id="vPassword" name="User[vPassword]" placeholder="Password">
                </div>
                <div class="error-msg-form" id='vPasswordErr'></div>

                <div class="form-group">
                  <label for="vConfirmPassword"><?php echo $_smarty_tpl->tpl_vars['confirm_password']->value;?>
</label>
                  <input type="password" class="form-control" id="vConfirmPassword" name="User[vConfirmPassword]" placeholder="Password">
                </div>
                <div class="error-msg-form" id='vConfirmPasswordErr'></div>

                <div class="form-group">
                  <label for="vPhone"><?php echo $_smarty_tpl->tpl_vars['mobile_number']->value;?>
</label>
                  <input type="text" class="form-control" id="vPhone" name="User[vPhone]" placeholder="+915879252558">
                </div>
                <div class="error-msg-form" id='vPhoneErr'></div> 

                <div class="form-group">
                  <label for="dDOB"><?php echo $_smarty_tpl->tpl_vars['birthday']->value;?>
</label>
                  <input type="date" class="form-control" id="dDOB" name="User[dDOB]" placeholder="Date">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><?php echo $_smarty_tpl->tpl_vars['gender']->value;?>
</label>
                  <select class="form-control" id="eGender" name="User[eGender]">
                    <option value="Male"><?php echo $_smarty_tpl->tpl_vars['male']->value;?>
</option>
                    <option value="Female"><?php echo $_smarty_tpl->tpl_vars['female']->value;?>
</option>
                    <option value="Others"><?php echo $_smarty_tpl->tpl_vars['others']->value;?>
</option>
                  </select>
                </div>
                
                <div class="form-group" style="margin-top: 35px;">
                  <div class="g-recaptcha" data-sitekey="6Lc35isqAAAAAE2lVb0PercbNSgIAEt-K1t5V2-E"></div>
                </div>

                <div class="form-forgot">
                  <a href="javascript:void(0)" class="forgot-linkk" data-toggle="modal" data-target="#forgotModal"><?php echo $_smarty_tpl->tpl_vars['forgot_password']->value;?>
?</a>
                </div>

                <button type="submit" class="btn btn-primary form-btn" title="Sign Up" id="signup"><?php echo $_smarty_tpl->tpl_vars['submit']->value;?>
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
" title="Google" class="googlelogin" ><i class="fa-brands fa-google-plus-g"></i></a></li>
              </ul>
            </div>
            <div class="signup-box">
              <p><?php echo $_smarty_tpl->tpl_vars['dont_have_an_account']->value;?>
? <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/index');?>
">Login</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
   </section>
  <?php echo '<script'; ?>
 src="https://www.google.com/recaptcha/api.js" async defer><?php echo '</script'; ?>
>
<?php }
}

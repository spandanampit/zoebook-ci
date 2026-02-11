<?php
/* Smarty version 3.1.28, created on 2024-01-31 04:37:26
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/user/views/register_modal.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9ce867aa0c8_67988995',
  'file_dependency' => 
  array (
    '365ee3a71c64fb630f879ffe600fa17bee55f963' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/user/views/register_modal.tpl',
      1 => 1706090591,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9ce867aa0c8_67988995 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/register.js");?>

<div class="modal fade cmn-modal signup-modal" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupmodallabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">

      <form class="cmn-form" name="frmregister" id="frmregister" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/register_action');?>
" enctype="multipart/form-data">

      <div class="modal-header">

        <h5 class="modal-title text-center" id="signupmodallabel">Register</h5>

        <div class="avatar-upload">
          <div class="avatar-edit">
            <div id="form-image">
              <input type='file' id="profile_image" name="profile_image" accept=".png, .jpg, .jpeg" />
              <label for="profile_image">
                <i class="fas fa-camera"></i>
              </label>
            </div>
          </div>
          <div class="avatar-preview">
            <img class="profile-user-img" id="imagePreview" src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/upload-profile-icon.png" alt="User profile picture">
          </div>
        </div>
      </div>

      <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="form-group input-group">
                <div class="w-100 position-relative">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="email" class="form-control email-input" aria-describedby="emailHelp" id="vEmail" name="User[vEmail]" placeholder="Email">  
                </div>
                <div class="error-msg-form" id='vEmailErr'></div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group input-group">
                <div class="w-100 position-relative">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="far fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" id="vName" name="User[vName]" placeholder="name">
                </div>
                <div class="error-msg-form" id='vNameErr'></div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group input-group">
                <div class="w-100 position-relative">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" id="vPassword" name="User[vPassword]" placeholder="Password">
                </div>
                <div class="error-msg-form" id='vPasswordErr'></div>
              </div>              
            </div>

            <div class="col-lg-6">
              <div class="form-group input-group">
                <div class="w-100 position-relative">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" id="vConfirmPassword" name="User[vConfirmPassword]" placeholder="Confirm Password">
                </div>  
                <div class="error-msg-form" id='vConfirmPasswordErr'></div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="form-group input-group">
                <div class="w-100 position-relative">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" id="vPhone" name="User[vPhone]" placeholder="Mobile Number">
                </div> 
                <div class="error-msg-form" id='vPhoneErr'></div> 
              </div>
            </div>

            <div class="col-lg-6">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group input-group">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                    </div>
                    <input type="text" class="form-control" id="dDOB" name="User[dDOB]" placeholder="Birthday">
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group input-group">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                    </div>
                    <select class="form-control" id="eGender" name="User[eGender]">
                      <option selected>Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                </div>

              </div>
            </div>
          </div>
        
        <p class="text-center">Your detail will always remain private. By clicking on 'Sign Up' button below you agree to our application 
            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/staticpage','','code:termsconditions');?>
" title="Terms and conditions" target="_blank">Terms and Conditions</a> and 
            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/staticpage','','code:privacypolicy');?>
" title="Privacy Policy" target="_blank">Privacy Policy</a>
        </p>
      </div>

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Cancel" id="cancelsignup">Cancel</button>
        <button type="submit" class="btn btn-primary" title="Sign Up" id="signup">Sign Up</button>
      </div>

      </form>

    </div>
  </div>
</div><?php }
}

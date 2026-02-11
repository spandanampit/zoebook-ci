<?php
/* Smarty version 3.1.28, created on 2025-01-20 04:56:05
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/profile_cover.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_678e47e5998e66_62881906',
  'file_dependency' => 
  array (
    '92aa812cbe316a607a86bf11bf53c86fb0bdd29e' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/profile_cover.tpl',
      1 => 1737377745,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678e47e5998e66_62881906 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/third_party/Smarty/plugins/modifier.replace.php';
?>
<style>
.new-form{
   z-index: 1;
   margin-right: -23px;
   height: 100px;
}

.new-icon{
   font-size: 24px;
   color: #ff8d00;
   margin-bottom: 0px;
   margin-top: 82px;
   position: relative;
   left: 92px;
}

#save-button {
   background-color: transparent;
   border: none;
}

</style>

<div class="view-post-banner">
   <div class="back-button">
      <a href="#" class="back-button"><i class="fa-solid fa-arrow-left-long"></i></a>                    
   </div>
   <div class="view-profile-banner">
      <form class="cmn-form" name="frmcover" id="frmcover" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/myprofile_action');?>
" enctype="multipart/form-data">
         <input type="hidden" name="topcover" id="topcover" value="">
         <input type="hidden" name="loadedtopcover" id="loadedtopcover" value="<?php echo $_smarty_tpl->tpl_vars['coverydimention']->value;?>
"> 
         <?php if ($_smarty_tpl->tpl_vars['profile_type']->value == 'my_profile') {?>  
            <div class="edit-box avatar-edit" id="changephoto_block" style="z-index: 1;">
               <div id="form-image">
               <input type='file' id="cover_photo" name="cover_photo" style="display:none;" accept=".png, .jpg, .jpeg,.mp4" />
                  <label for="cover_photo">
                     <span id="changephoto"><i class="fa-solid fa-pen"></i></span>
                  </label>
               </div>
            </div>
            <div class="edit-box avatar-edit" id="savephoto_block" style="display:none; z-index: 1;">
               <div id="form-image">
                  <input type='hidden' id="saved_cover_photo" name="saved_cover_photo" />
                  <label>
                     <div id="savephoto"><i class="fa fa-save"></i></div>
                  </label>
               </div>
            </div>
         <?php }?>
         <input type='hidden' id="coverphoto_type" name="coverphoto_type" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['coverphoto_type'];?>
"/>

         <div style="display:none;" class="dragimagetext"><?php echo $_smarty_tpl->tpl_vars['dragDesc']->value;?>
</div>
         <div id="loadingcover" class="row text-center"><span style="text-align:center;width:20%;padding:10px;background:lightgray"><?php echo $_smarty_tpl->tpl_vars['loadCover']->value;?>
</span></div>
         <div class="avatar-preview" id="loaddraggable">
            <?php ob_start();
echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');
$_tmp1=ob_get_clean();
$_smarty_tpl->tpl_vars['covernoimage1'] = new Smarty_Variable(($_tmp1).('public/images/noimage.gif'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'covernoimage1', 0);?>
            <?php ob_start();
echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');
$_tmp2=ob_get_clean();
$_smarty_tpl->tpl_vars['covernoimage2'] = new Smarty_Variable(($_tmp2).('public/images/noimage_1000x320.png'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'covernoimage2', 0);?>
            <input type="hidden" name="coversrc" id="coversrc" value="<?php if ($_smarty_tpl->tpl_vars['getuserid']->value != $_smarty_tpl->tpl_vars['followuserid']->value) {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_cover_photo'],$_smarty_tpl->tpl_vars['covernoimage1']->value,$_smarty_tpl->tpl_vars['covernoimage2']->value);
} else {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_cover_photo'],$_smarty_tpl->tpl_vars['covernoimage1']->value,$_smarty_tpl->tpl_vars['covernoimage2']->value);
}?>">
            <div id="displaycover"></div>
         </div>
      </form>  
   </div>
   <div class="profile-detail-box">
      <div class="profile-detail-user">
         <div class="profile-detail-img">

         <!--//new fixes-->
         <form enctype="multipart/form-data" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/myprofile_action');?>
 " class="new-form">
            <input type="hidden" name="selprofilepic" id="selprofilepic" value="profilepic">
            <div id="input-container">
               <label for="profile_image" style="cursor: pointer;">
                     <i class="fa fa-plus-circle new-icon" style="font-size: 24px;"></i>
               </label>
               <input type="file" name="profile_image" id="profile_image" style="display: none;" />
            </div>
            <button type="submit" id="save-button" style="display: none;">
               <i class="fa fa-save new-icon" style="font-size: 24px; cursor: pointer;"></i>
            </button>
         </form>

            <form class="cmn-form" name="frmprofilepic" id="frmprofilepic" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/myprofile_action');?>
" enctype="multipart/form-data">
               <?php if ($_smarty_tpl->tpl_vars['profile_type']->value == 'my_profile') {?>   
                  <div class="edit-box-2 avatar-edit" id="changeprofilepic_block" style="display:none;">
                     <div id="form-image">
                        <input type='file' id="profile_image" name="profile_image" style="display:none;" accept=".png, .jpg, .jpeg,.mp4" />
                        <label for="profile_image">
                        <span id="changeprofilepic"><i class="fa-solid fa-pen"></i></span>
                        </label>
                     </div>
                  </div> 
                  <div class="edit-box-2 avatar-edit" id="saveprofilepic_block" style="display:none;">
                     <div id="form-image">
                        <input type='file' id="profile_image" name="profile_image" style="display:none;" accept=".png, .jpg, .jpeg,.mp4" />
                        <input type='hidden' id="saved_profile_photo" name="saved_profile_photo" />
                        <label>
                           <div id="saveprofilepic" style="display:none;cursor:pointer;"><i class="fas fa-save"></i></div>
                        </label>
                     </div>
                  </div>                  
                  <input type="hidden" name="profile_pic" id="profile_pic" value="<?php if ($_smarty_tpl->tpl_vars['getuserid']->value != $_smarty_tpl->tpl_vars['followuserid']->value) {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['covernoimage1']->value,$_smarty_tpl->tpl_vars['covernoimage2']->value);
} else {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['covernoimage1']->value,$_smarty_tpl->tpl_vars['covernoimage2']->value);
}?>"/>
               <?php }?>   

               <!--<?php if ($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'] != '') {?>
                  <img id="imagePreviewProfile" src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="User profile picture">
               <?php } else { ?>
                  <img id="imagePreviewProfile" src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/user.png" alt="Default profile picture">
               <?php }?>-->
               <?php if ($_smarty_tpl->tpl_vars['profile_type']->value == 'my_profile') {?>
                  <!--<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
-->
                  <input type="hidden" name="profilepicsrc" id="profilepicsrc" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" />
                  <div class="avatar-preview">
                     <div id="profilepic_inner"></div>
                  </div>
               <?php } else { ?>
                  <div class="avatar-preview">
                     <img id="imagePreviewProfile" src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="User profile picture">
                  </div>
               <?php }?>
                  <input type="hidden" name="profilepicsrc" id="profilepicsrc" value="<?php if ($_smarty_tpl->tpl_vars['getuserid']->value != $_smarty_tpl->tpl_vars['followuserid']->value) {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['covernoimage1']->value,$_smarty_tpl->tpl_vars['covernoimage2']->value);
} else {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['covernoimage1']->value,$_smarty_tpl->tpl_vars['covernoimage2']->value);
}?>" />
                  <div id="profilepic_inner"></div>
                  <?php ob_start();
echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');
$_tmp3=ob_get_clean();
$_smarty_tpl->tpl_vars['profileImage1'] = new Smarty_Variable(($_tmp3).('public/images/noimage.gif'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'profileImage1', 0);?>
                  <?php ob_start();
echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');
$_tmp4=ob_get_clean();
$_smarty_tpl->tpl_vars['profileImage2'] = new Smarty_Variable(($_tmp4).('public/images/noimage_1000x320.png'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'profileImage2', 0);?>
                  <input type="hidden" name="profilesrc" id="profilesrc" value="<?php if ($_smarty_tpl->tpl_vars['getuserid']->value != $_smarty_tpl->tpl_vars['followuserid']->value) {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['profileImage1']->value,$_smarty_tpl->tpl_vars['profileImage2']->value);
} else {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['profileImage1']->value,$_smarty_tpl->tpl_vars['profileImage2']->value);
}?>">
            </form>
         </div>
         <div class="profile-detail-content">
         <h3><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_name'];?>
</h3>
         <ul>
            <li><?php echo $_smarty_tpl->tpl_vars['post']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['userinfo']->value['post_count'];?>
</li>
            <li><?php echo $_smarty_tpl->tpl_vars['follower']->value;?>

               <input type="hidden" id="totfollowercount" name="totfollowercount" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['follower_count'];?>
" />
               <a href="javascript:" data-toggle="modal" <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['follower_count'] > 0) {?> data-target="#followModal" <?php }?> id="showfollowercount">
               <?php echo $_smarty_tpl->tpl_vars['userinfo']->value['follower_count'];?>

            </a>
            </li>
            <li style="display:flex"><?php echo $_smarty_tpl->tpl_vars['following']->value;?>
&nbsp; <input type="hidden" id="totfollowingcount" name="totfollowingcount" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['following_count'];?>
">
            <div class="follower-count"><a href="javascript:" data-toggle="modal" <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['following_count'] > 0) {?>data-target="#followingModal"<?php }?> id="showfollowingcount"><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['following_count'];?>
</a></div>
            </li>
         </ul>
         </div>
      </div>
      <div class="profile-detail-btn-box">
         <input type="hidden" name="getuser_id" id="getuser_id" value="<?php echo $_smarty_tpl->tpl_vars['getuserid']->value;?>
">
         <input type="hidden" name="userfollow_id" id="userfollow_id" value="<?php echo $_smarty_tpl->tpl_vars['followuserid']->value;?>
">
         <?php if ($_smarty_tpl->tpl_vars['profile_type']->value == 'user_profile') {?>
            <?php if ($_smarty_tpl->tpl_vars['getuserid']->value != $_smarty_tpl->tpl_vars['followuserid']->value) {?>
               <form class="cmn-form" name="frmfollowuser" id="frmfollowuser" method="post" action="" >
                  <input type="hidden" name="pending_request_id" id="pending_request_id" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['pending_request_id'];?>
">
                  <input type="hidden" name="pending_request_id_1" id="pending_request_id_1" value="<?php echo $_smarty_tpl->tpl_vars['pendingrequestid']->value;?>
">
                  <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['is_follwing'] == 'Pending') {?>
                  <?php $_smarty_tpl->tpl_vars['follow_class'] = new Smarty_Variable('btn-secondary', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'follow_class', 0);?>
                  <?php $_smarty_tpl->tpl_vars['followid'] = new Smarty_Variable('cancelfollowrequest', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'followid', 0);?>
                  <?php $_smarty_tpl->tpl_vars['followname'] = new Smarty_Variable('Cancel Request', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'followname', 0);?>
                  <?php $_smarty_tpl->tpl_vars['actbtn'] = new Smarty_Variable('Deleted', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'actbtn', 0);?>
                  <?php } elseif ($_smarty_tpl->tpl_vars['userinfo']->value['is_follwing'] == 'Yes') {?>
                  <?php $_smarty_tpl->tpl_vars['follow_class'] = new Smarty_Variable('btn-secondary', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'follow_class', 0);?>
                  <?php $_smarty_tpl->tpl_vars['followid'] = new Smarty_Variable('unfollowrequest', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'followid', 0);?>
                  <?php $_smarty_tpl->tpl_vars['followname'] = new Smarty_Variable('Unfollow', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'followname', 0);?>
                  <?php $_smarty_tpl->tpl_vars['actbtn'] = new Smarty_Variable('Deleted', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'actbtn', 0);?>
                  <?php } else { ?>
                  <?php $_smarty_tpl->tpl_vars['follow_class'] = new Smarty_Variable('profile-btn bg-green', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'follow_class', 0);?>
                  <?php $_smarty_tpl->tpl_vars['followid'] = new Smarty_Variable('savefollowuser', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'followid', 0);?>
                  <?php $_smarty_tpl->tpl_vars['followname'] = new Smarty_Variable('Follow', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'followname', 0);?>
                  <?php $_smarty_tpl->tpl_vars['actbtn'] = new Smarty_Variable('follow', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'actbtn', 0);?>
                  <?php }?>
                  <input type="hidden" name="actbtn" id="actbtn" value="<?php echo $_smarty_tpl->tpl_vars['actbtn']->value;?>
">
                  <div class="profile-detail-btn-box">
                     <a class="btn <?php echo $_smarty_tpl->tpl_vars['follow_class']->value;?>
 followuser_act" href="javascript:void(0)" id="<?php echo $_smarty_tpl->tpl_vars['followid']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['followname']->value;?>
</a>
                     <?php if ($_smarty_tpl->tpl_vars['acceptrejectfollow']->value == 'yes') {?>
                     <span id="acceptrejectblock">
                     <a class="profile-btn bg-yellow followuser_act" href="javascript:void(0)" id="acceptrequestid"><?php echo $_smarty_tpl->tpl_vars['accept']->value;?>
</a>
                     <a class="profile-btn bg-red followuser_act" href="javascript:void(0)" id="rejectrequestid"><?php echo $_smarty_tpl->tpl_vars['reject']->value;?>
</a>
                     </span>
                     <?php }?>
                     <!--<span id="followerrornote"></span>-->
                     <a class="profile-btn bg-yellow" href="javascript:void(0)" onclick="openChatBox(<?php echo $_smarty_tpl->tpl_vars['getuserid']->value;?>
,<?php echo $_smarty_tpl->tpl_vars['followuserid']->value;?>
,
                        '<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_name'];?>
','<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_email'];?>
','<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image_firebase'];?>
');" ><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
<i class="fas fa-mail ml-1"></i></a>            
                     <a class="profile-btn bg-red block_user" data-userid="<?php echo $_smarty_tpl->tpl_vars['followuserid']->value;?>
" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['block']->value;?>
</a>
                  </div>
               </form>
            <?php }?>
         <?php } elseif ($_smarty_tpl->tpl_vars['profile_type']->value == 'my_profile') {?>
            <a href="javascript:void(0)" class="profile-btn-2 bg-lt-green" data-toggle="modal" data-target="#editProfile"><?php echo $_smarty_tpl->tpl_vars['edit_profile']->value;?>
</a>
            <a href="javascript:void(0)" class="profile-btn-2 bg-lt-green" data-toggle="modal" data-target="#changePassword"><?php echo $_smarty_tpl->tpl_vars['change_password']->value;?>
</a>
         <?php }?>
      </div>
   </div>
</div>

<!-- editProfile Modal Popup -->
<form class="cmn-form" name="frmeditprofile" id="frmeditprofile" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/edit_profile_action');?>
">
   <div class="modal fade cmn-modal" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title text-center" id="exampleModalLabel"><?php echo $_smarty_tpl->tpl_vars['edit_profile']->value;?>
</h5>
            </div>
            <div class="modal-body">
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_email'];?>
" class="form-control email-input" aria-describedby="emailHelp" id="vEditEmail" name="vEditEmail" placeholder="john@zoebook.com" readonly>
               </div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="far fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_name'];?>
" id="vEditName" name="vEditName" placeholder="name">
               </div>
               <div class="error-msg-form" id='vNameErr'></div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_phone'];?>
" id="vEditPhone" name="vEditPhone" placeholder="Mobile Number">
               </div>
               <div class="error-msg-form" id='vPhoneErr'></div>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" id="canceleditprofile"><?php echo $_smarty_tpl->tpl_vars['cancel']->value;?>
</button>
               <button type="submit" class="btn btn-primary" id="saveeditprofile"><?php echo $_smarty_tpl->tpl_vars['save']->value;?>
</button>
            </div>
         </div>
      </div>
   </div>
</form>
<!-- changePassword Modal Popup -->
<form class="cmn-form" name="frmchangepassword" id="frmchangepassword" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/changepassword_action');?>
">
   <div class="modal fade cmn-modal" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title text-center" id="exampleModalLabel"><?php echo $_smarty_tpl->tpl_vars['change_password']->value;?>
</h5>
            </div>
            <div class="modal-body">
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="vOldPassword" id="vOldPassword" placeholder="Old Password">
               </div>
               <div class="error-msg-form" id='vOldPasswordErr'></div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="vNewPassword" id="vNewPassword" placeholder="New Password">
               </div>
               <div class="error-msg-form" id='vNewPasswordErr'></div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" id="vRePassword" name="vRePassword" placeholder="Retype New Password">
               </div>
               <div class="error-msg-form" id='vRePasswordErr'></div>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelchangepassword"><?php echo $_smarty_tpl->tpl_vars['cancel']->value;?>
</button>
               <button type="submit" class="btn btn-primary" id="savechangepassword"><?php echo $_smarty_tpl->tpl_vars['save']->value;?>
</button>
            </div>
         </div>
      </div>
   </div>
</form>

<?php echo '<script'; ?>
>
   const inputField = document.getElementById('profile_image');
   const inputContainer = document.getElementById('input-container');
   const saveButton = document.getElementById('save-button');

   inputField.addEventListener('change', function () {
      if (this.files.length > 0) {
         inputContainer.style.display = 'none';
         saveButton.style.display = 'inline-block';
      }
   });
<?php echo '</script'; ?>
><?php }
}

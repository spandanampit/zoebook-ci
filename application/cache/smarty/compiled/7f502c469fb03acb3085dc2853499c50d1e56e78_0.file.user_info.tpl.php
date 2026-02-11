<?php
/* Smarty version 3.1.28, created on 2024-01-31 13:00:15
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/user_info.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9f7078d1792_91639959',
  'file_dependency' => 
  array (
    '7f502c469fb03acb3085dc2853499c50d1e56e78' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/user_info.tpl',
      1 => 1706091458,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9f7078d1792_91639959 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat-count.js");?>

<div class="cmn-white-block left-panel">
    <form class="cmn-form" name="frmprofilepic" id="frmprofilepic" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/myprofile_action');?>
" enctype="multipart/form-data">
        <input type="hidden" name="selprofilepic" id="selprofilepic" value="profilepic">
        <div class="user-left-details">
            <div class="circle-profile">
                <div class="avatar-upload">
                    <?php if ($_smarty_tpl->tpl_vars['profile_type']->value == 'my_profile') {?>
                        <div class="avatar-edit" id="changeprofilepic_block">
                            <div id="form-image">
                                <input type='file' id="profile_image" name="profile_image" accept=".png, .jpg, .jpeg" />
                                <label for="profile_image">
                                    <span id="changeprofilepic"><i class="fas fa-edit"></i></span>
                                    
                                </label>
                            </div>
                        </div>
                        <div class="avatar-edit" id="saveprofilepic_block"  style="display:none;">
                            <div id="form-image">
                                <input type='hidden' id="saved_profile_photo" name="saved_profile_photo" />
                                <label>
                                    <div id="saveprofilepic" style="display:none;cursor:pointer;"><i class="fas fa-save"></i></div>
                                </label>
                            </div>
                        </div>
                    <?php }?>
                
                    <?php if ($_smarty_tpl->tpl_vars['profile_type']->value == 'my_profile') {?>
                    <input type="hidden" name="profilepicsrc" id="profilepicsrc" value="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
">
                    <div class="avatar-preview">
                        <span id="profilepic_inner"></span>
                    </div>
                    <?php } else { ?>
                    <div class="avatar-preview">
                        <img class="profile-user-img" id="imagePreviewProfile" src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="User profile picture">
                    </div>
                    <?php }?>
                </div>
            </div>
            <h3 class="user-name"><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_name'];?>
</h3>
            <input type="hidden" name="firebase_token" id="firebase_token" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('firebase_token');?>
">
            <div class="user-location" style='display:none;'>
                <i class="fas fa-map-marker-alt"></i> Florida
            </div>
        </div>
    </form>

    <hr>

    <div class="left-menu">
        <ul>
            <li>
                <a href="viral-posts.html" class="<?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_method() == 'viral_posts') {?>active<?php }?>"><i class="fas fa-wifi"></i> Viral Post</a>
            </li>
            <li>
                <a href="home.html" class="<?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_class() == 'home' && $_smarty_tpl->tpl_vars['this']->value->router->fetch_method() == 'index') {?>active<?php }?>"><i class="fas fa-list-ul"></i> My Feed</a>
            </li>
            <li>
                <a href="hidden-posts.html" class="<?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_class() == 'home' && $_smarty_tpl->tpl_vars['this']->value->router->fetch_method() == 'hide_posts') {?>active<?php }?>"><i class="fa fa-eye-slash"></i> Hidden Post</a>
            </li>
            <li>
                <a href="javascript:;" class="chat-link"><i class="far fa-comment"><span class="show-chat-count"></span></i> Chat</a>
            </li>
           
           <?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_method() != 'user_profile') {?>
            <li>
                <a href="javascript:void(0);" id="notifications_modal">
                    <i class="far fa-bell"><span class="notify_display"></span></i> Notification
                </a>
            </li>
             <li>
                <a href="javascript:void(0);" id="block_user_modal">
                    <i class="fa fa-ban"></i> Blocked Users
                </a>
            </li>
            <?php }?>
        </ul>
    </div>
</div>
<?php }
}

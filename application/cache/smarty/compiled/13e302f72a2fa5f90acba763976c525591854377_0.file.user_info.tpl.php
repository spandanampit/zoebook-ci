<?php
/* Smarty version 3.1.28, created on 2025-01-14 05:38:01
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/user_info.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_678668b94a66b5_91178700',
  'file_dependency' => 
  array (
    '13e302f72a2fa5f90acba763976c525591854377' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/user_info.tpl',
      1 => 1736861859,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678668b94a66b5_91178700 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/third_party/Smarty/plugins/modifier.replace.php';
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat-count.js");?>

<style>
.badge{
    position: relative;
    background: red;
    top: -11px;
    right: 13px;
    border-radius: 22px;
}
</style>

<div class="col-xl-3 col-md-12">
    <div class="sidebar" style="margin-left: -43px;"> 
    <form class="cmn-form" name="frmprofilepic" id="frmprofilepic" method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/myprofile_action');?>
" enctype="multipart/form-data">
        <input type="hidden" name="selprofilepic" id="selprofilepic" value="profilepic">

            <?php if ($_smarty_tpl->tpl_vars['profile_type']->value != 'my_profile') {?>
                <div class="sidebar-user">
                    <div class="sidebar-user-img avatar-edit" id="changeprofilepic_block">
                        <div id="form-image">
                            <input type='file' id="profile_image" name="profile_image" style="display:none;" accept=".png, .jpg, .jpeg" />
                            <label for="profile_image">
                                <!--<a href="#" style="z-index: 1"><i class="fa-solid fa-pen" ></i></a>-->
                            </label>
                        </div>
                        <img id="imagePreviewProfile" src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="User profile picture" style = "position:relative; bottom: 24px;">
                    </div>
                    <div class="sidebar-user-img avatar-edit" id="saveprofilepic_block" style="display:none;">
                        <div id="form-image">
                            <input type='hidden' id="saved_profile_photo" name="saved_profile_photo" />
                            <label>
                                <div id="saveprofilepic" style="display:none;cursor:pointer;"><i class="fas fa-save"></i></div>
                            </label>
                        </div>
                    </div>
                    <div class="sidebar-user-title">
                        <h3><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_name'];?>
</h3>
                    </div>
                </div>
            <?php }?>
            <?php ob_start();
echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');
$_tmp1=ob_get_clean();
$_smarty_tpl->tpl_vars['profileImage1'] = new Smarty_Variable(($_tmp1).('public/images/noimage.gif'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'profileImage1', 0);?>
            <?php ob_start();
echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');
$_tmp2=ob_get_clean();
$_smarty_tpl->tpl_vars['profileImage2'] = new Smarty_Variable(($_tmp2).('public/images/noimage_1000x320.png'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'profileImage2', 0);?>
            <input type="hidden" name="profilesrc" id="profilesrc" value="<?php if ($_smarty_tpl->tpl_vars['getuserid']->value != $_smarty_tpl->tpl_vars['followuserid']->value) {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['profileImage1']->value,$_smarty_tpl->tpl_vars['profileImage2']->value);
} else {
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'],$_smarty_tpl->tpl_vars['profileImage1']->value,$_smarty_tpl->tpl_vars['profileImage']->value);
}?>">
        </form>
        <div class="sidebar-nav">
            <div class="scroll-content">
                <ul>
                    <li class="sidebar-nav-item">
                        <a href="viral-posts.html" class="<?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_method() == 'viral_posts') {?>active<?php }?>"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/viral.png" alt=""><?php echo $_smarty_tpl->tpl_vars['viral_post']->value;?>
</a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="home.html" class="<?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_class() == 'home' && $_smarty_tpl->tpl_vars['this']->value->router->fetch_method() == 'index') {?>active<?php }?>"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/feed.png" alt=""> <?php echo $_smarty_tpl->tpl_vars['home']->value;?>
</a>
                    </li>
                    <li class="sidebar-nav-item">
                        <?php if ($_smarty_tpl->tpl_vars['profile_type']->value == 'user_profile') {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/playlist');?>
?user_id=<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_users_id'];?>
&profile_type=user_profile"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/music.png" alt=""> <?php echo $_smarty_tpl->tpl_vars['my_playlist']->value;?>
</a>
                        <?php } else { ?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/playlist');?>
?user_id=<?php echo $_smarty_tpl->tpl_vars['pl_userId']->value;?>
&profile_type=my_profile"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/music.png" alt=""> <?php echo $_smarty_tpl->tpl_vars['my_playlist']->value;?>
</a>
                        <?php }?>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/watchvideo');?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/viral.png" alt=""> <?php echo $_smarty_tpl->tpl_vars['viral_post_plus']->value;?>
</a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="hidden-posts.html" class="<?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_class() == 'home' && $_smarty_tpl->tpl_vars['this']->value->router->fetch_method() == 'hide_posts') {?>active<?php }?>"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/hidden.png" alt=""> <?php echo $_smarty_tpl->tpl_vars['hidden_post']->value;?>
</a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="javascript:;" class="chat-link"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/chat.png" alt=""> <?php echo $_smarty_tpl->tpl_vars['chat']->value;?>
</a>
                    </li>
                    <?php if ($_smarty_tpl->tpl_vars['profile_type']->value != 'my_profile') {?>
                        <?php if ($_smarty_tpl->tpl_vars['this']->value->router->fetch_method() != 'user_profile') {?>
                            <li class="sidebar-nav-item">
                                <a href="#" id="notificationNewLink" data-bs-toggle="modal" data-bs-target="#notificationNewModal" style="gap: 0px !important;">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/notification.png" alt="">
                                    <span class="badge"><?php echo $_smarty_tpl->tpl_vars['total_notification']->value;?>
</span> <?php echo $_smarty_tpl->tpl_vars['notification']->value;?>

                                </a>
                            </li>
                    
                            <li class="sidebar-nav-item">
                                <a href="#" id="blockUserNewModalTrigger" data-bs-toggle="modal" data-bs-target="#blockUserNewModal">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/block.png" alt=""> <?php echo $_smarty_tpl->tpl_vars['blocked_users']->value;?>

                                </a>
                            </li>
                        <?php }?>
                    <?php }?>    
                </ul>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
>
    document.getElementById('notifications_modal').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('notificationNew'));
        myModal.show();
    });
<?php echo '</script'; ?>
>

<?php }
}

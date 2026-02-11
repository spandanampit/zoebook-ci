<?php
/* Smarty version 3.1.28, created on 2024-02-07 19:24:56
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/views/template.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c38bb07a9175_11525103',
  'file_dependency' => 
  array (
    '14cee390f719eab43d16fcddee089effacd9243e' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/views/template.tpl',
      1 => 1707314089,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top/top.tpl' => 1,
    'file:bottom/footer.tpl' => 1,
    'file:../user/views/register_modal.tpl' => 1,
    'file:../user/views/forgot_modal.tpl' => 1,
    'file:../home/views/common/chat_popup.tpl' => 1,
  ),
),false)) {
function content_65c38bb07a9175_11525103 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" /> <base href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
" />
        <title><?php echo $_smarty_tpl->tpl_vars['this']->value->session->flashdata('failure');
if (is_array($_smarty_tpl->tpl_vars['meta_info']->value) && $_smarty_tpl->tpl_vars['meta_info']->value['title'] != '') {
echo $_smarty_tpl->tpl_vars['meta_info']->value['title'];
} else {
echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_TITLE');
}?></title>
        <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCompanyFavIconURL();?>
" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?php if (is_array($_smarty_tpl->tpl_vars['meta_info']->value) && $_smarty_tpl->tpl_vars['meta_info']->value['description'] != '') {
echo $_smarty_tpl->tpl_vars['meta_info']->value['description'];
} else {
echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_DESCRIPTION');
}?>" />
        <meta name="keywords" content="<?php if (is_array($_smarty_tpl->tpl_vars['meta_info']->value) && $_smarty_tpl->tpl_vars['meta_info']->value['keywords'] != '') {
echo $_smarty_tpl->tpl_vars['meta_info']->value['keywords'];
} else {
echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_KEYWORD');
}?>" />

        <meta property="og:title" content="<?php echo preg_replace('!<[^>]*?>!', ' ', html_entity_decode($_smarty_tpl->tpl_vars['ogTitle']->value));?>
"/>
        <meta property="og:type" content="<?php echo $_smarty_tpl->tpl_vars['ogType']->value;?>
"/>
        <meta property="og:description" content="<?php echo preg_replace('!<[^>]*?>!', ' ', html_entity_decode($_smarty_tpl->tpl_vars['ogDescription']->value));?>
"/>
        <meta property="og:site_name" content="Zoebook"/>
        <meta property="og:locale" content="en_GB" />
        <meta property="article:author" content="https://zoebook.com/contactus.html" />
        <meta property="article:section" content="India" />
        <meta property="og:url" content="<?php echo $_smarty_tpl->tpl_vars['ogUrl']->value;?>
"/>
        <meta property="og:image" content="<?php echo $_smarty_tpl->tpl_vars['ogImage']->value;?>
"/>
        <meta property="og:image:alt" content="Zoebook. Post from user" />


        <meta property="fb:app_id" content="<?php echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('FB_APP_ID');?>
"/>

        <?php if (is_array($_smarty_tpl->tpl_vars['meta_info']->value) && is_array($_smarty_tpl->tpl_vars['meta_info']->value['other'])) {?>
            <?php $_smarty_tpl->tpl_vars["meta_other"] = new Smarty_Variable($_smarty_tpl->tpl_vars['meta_info']->value['other'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "meta_other", 0);?>
            <?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['meta_other']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
                <meta <?php echo $_smarty_tpl->tpl_vars['meta_other']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['key'];?>
="<?php echo $_smarty_tpl->tpl_vars['meta_other']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['value'];?>
" content="<?php echo $_smarty_tpl->tpl_vars['meta_other']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['content'];?>
" />
            <?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>
        <?php } else { ?>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <?php if ($_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_OTHER') != '') {?>
                <?php echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_OTHER');?>

            <?php }?>
        <?php }?>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("custom-scrollbar/css/jquery.mCustomScrollbar.css","front/bootstrap.min.css","front/font-awesome/css/all.min.css","front/owl.carousel.min.css","front/jquery.mCustomScrollbar.css","front/jquery-ui.css","front/font-face.css","front/style.css","front/custom-designer.css","front/custom-developer.css","front/media.css","front/bootstrap_datepicker.css","front/dev.css");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("libraries/emoji_picker/emoji.css");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

        <?php echo '<script'; ?>
 type='text/javascript'>
            var site_url = '<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item("site_url");?>
';
        <?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src='https://www.google.com/recaptcha/api.js' async defer><?php echo '</script'; ?>
>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getJSLanguageLables();?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/jquery.min.js","front/jquery-ui.js","front/popper.min.js","front/bootstrap.min.js","front/owl.carousel.js","front/jquery.mCustomScrollbar.concat.min.js","front/circle-progress.js","front/bootbox.min.js","front/custom-designer.js");?>


        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/custom-developer.js");?>


        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("libraries/emoji_picker/config.js","libraries/emoji_picker/util.js","libraries/emoji_picker/jquery.emojiarea.js","libraries/emoji_picker/emoji-picker.js");?>


        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("validate/jquery.validate.min.js","validate/additional-methods.min.js","common.js","front/bootstrap-datepicker.js","blockui/jquery.blockUI.min.js","custom-scrollbar/js/jquery.mCustomScrollbar.concat.min.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-app.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-database.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-analytics.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-auth.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase-config.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/sweetalert.min.js");?>


        <link rel="stylesheet" href="https://unpkg.com/cloudinary-video-player/dist/cld-video-player.min.css">
    </head>
    <body class="<?php if ($_smarty_tpl->tpl_vars['islandinglcass']->value == 'yes') {?>landing-page<?php }?>  loggedin">
        <div id="main-container" class="main-container">
            <div id="inner-container" class="inner-container">
                <header>
                    <!--top-part start here-->
                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:top/top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                    <!--top-part End here-->
                </header>
                <main>
                    <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:none;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                    <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                    <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                    <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('success') != '') {?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable("alert-success", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable("success", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('success'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('failure') != '') {?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable("alert-error", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable("error", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('failure'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('warning') != '') {?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable("alert-warning", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable("warning", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('warning'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('info') != '') {?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable("alert-info", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable("info", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('info'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php }?>
                    <div class="errorbox-position" id="var_msg_cnt" style="<?php echo $_smarty_tpl->tpl_vars['msg_box_style']->value;?>
">
                        <div class="closebtn-errorbox <?php echo $_smarty_tpl->tpl_vars['msg_box_close']->value;?>
" id="closebtn_errorbox">
                            <a href="javascript:void(0);" onClick="Project.closeMessage();"><button class="close" type="button">×</button></a>
                        </div>
                        <div class="content-errorbox alert <?php echo $_smarty_tpl->tpl_vars['msg_box_class']->value;?>
" id="err_msg_cnt"><?php echo $_smarty_tpl->tpl_vars['msg_box_text']->value;?>
</div>
                    </div>

                    <!-- middle part start here-->
                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, $_smarty_tpl->tpl_vars['include_script_template']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                    <!-- middle part end here-->
                </main>
            </div>
            <footer>
                <!--footer-part start here-->
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:bottom/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <!--footer-part End here-->
            </footer>

        <?php if ($_smarty_tpl->tpl_vars['islandinglcass']->value == 'yes') {?>
        <!-- Signup Modal Popup -->
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:../user/views/register_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


        <!-- for Modal Popup -->
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:../user/views/forgot_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php }?>

  <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') != '') {?>
  <div class="modal fade cmn-modal" id="browseprofile" tabindex="-1" role="dialog" aria-labelledby="browseprofileLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title text-center" id="browseprofileLabel" >Browse Profiles</h5>
              </div>
              <div class="modal-body">
                  <div class="follow-friend-block scrollbarContent" id="modalfollowuser">
                      <input type="hidden" name="setuserid" id="setuserid" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId');?>
">
                      <div class="follow-friend-list" id="listbrowseprofile" style="text-align: center;">
                          <i class="fas fa-spinner mr-2"></i> Loading Please Wait ..
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

    <div class="modal fade cmn-modal" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center modal-header-common" id="exampleModalLabel"></h5>
                </div>
                <div class="modal-body">
                    <div class="notifications-list scrollbarContent">
                        <ul id="notifications_list_container">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php }?>


        </div>
        <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') > 0) {?>
            <!--Chat Popup Start-->
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:../home/views/common/chat_popup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <!--Chat Popup End-->
        <?php }?>
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <?php echo '<script'; ?>
 async src="https://www.googletagmanager.com/gtag/js?id=UA-170794673-1"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-170794673-1');
        <?php echo '</script'; ?>
>
        
        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src();?>

        <?php echo '<script'; ?>
 type='text/javascript'>
            var sess_user_id = '<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata("iUserId");?>
';
            is_logged = "No";
            if(sess_user_id > 0){
                is_logged = "Yes";
            }
            $(document).ready(function () {
                Project.init();
            });
        <?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
 src="https://unpkg.com/cloudinary-core/cloudinary-core-shrinkwrap.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="https://unpkg.com/cloudinary-video-player/dist/cld-video-player.min.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
>
        var players = cloudinary.videoPlayers('.cld-video-player', {
                cloud_name: 'demo',
                autoplay: true,
                controls: true,
                transformation: { width: 500, crop: 'limit' }
                });
        <?php echo '</script'; ?>
>

    </body>
</html>
<?php }
}

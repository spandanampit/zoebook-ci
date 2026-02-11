<?php
/* Smarty version 3.1.28, created on 2024-11-06 23:34:39
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/views/template.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_672c6d8f0d0228_18180341',
  'file_dependency' => 
  array (
    'd001a38d8e9d461881d5516ef09e5caee5c500e1' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/views/template.tpl',
      1 => 1730964703,
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
function content_672c6d8f0d0228_18180341 ($_smarty_tpl) {
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />

        <meta property="fb:app_id" content="<?php echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('FB_APP_ID');?>
"/>
        <!--<meta name="google-adsense-account" content="ca-pub-5186045650038047">-->
        <meta name="monetag" content="0687985c90cfcc4b623f9f205c95d8d7">

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">


        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("custom-scrollbar/css/jquery.mCustomScrollbar.css","front/bootstrap.min.css","front/font-awesome/css/all.min.css","front/owl.carousel.min.css","front/jquery.mCustomScrollbar.css","front/jquery-ui.css","front/style.css","front/media.css","front/bootstrap_datepicker.css","front/dev.css");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/new-css/bootstrap.min.css","front/new-css/owl.carousel.min.css","front/new-css/owl.theme.default.min.css","front/new-css/responsive.css","front/new-css/style-new.css","front/new-css/all.min.css");?>

        <?php if ($_smarty_tpl->tpl_vars['page_type']->value == 'movement') {?>
            <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/movement-css/style.css");?>

        <?php }?>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("libraries/emoji_picker/emoji.css");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>


        <link href="https://unpkg.com/cloudinary-video-player/dist/cld-video-player.css" rel="stylesheet">

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

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/jquery-ui.js","front/popper.min.js","front/bootstrap.min.js","front/owl.carousel.js","front/jquery.mCustomScrollbar.concat.min.js","front/circle-progress.js","front/bootbox.min.js","front/custom-designer.js","front/userprofile.js","front/new-js/jquery.min.js","front/new-js/owl.carousel.js","front/new-js/custom.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/custom-developer.js");?>


        <?php if ($_smarty_tpl->tpl_vars['page_type']->value == 'movement') {?>
            <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/movement-js/custom.js","front/movement-js/jquery.min.js","front/movement-js/posts.js");?>

        <?php }?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("libraries/emoji_picker/config.js","libraries/emoji_picker/util.js","libraries/emoji_picker/jquery.emojiarea.js","libraries/emoji_picker/emoji-picker.js");?>


        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("validate/jquery.validate.min.js","validate/additional-methods.min.js","common.js","front/bootstrap-datepicker.js","blockui/jquery.blockUI.min.js","custom-scrollbar/js/jquery.mCustomScrollbar.concat.min.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-app.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-database.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-analytics.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-auth.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase/firebase-storage.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/firebase-config.js");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/sweetalert.min.js");?>

        <!--<?php echo '<script'; ?>
 src="https://alwingulla.com/88/tag.min.js" data-zone="75134" async data-cfasync="false"><?php echo '</script'; ?>
>-->
    </head>
    <body class="<?php if ($_smarty_tpl->tpl_vars['islandinglcass']->value == 'yes') {?>landing-page<?php }?>">
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

        <div class="modal fade cmn-modal" id="browseprofile" tabindex="-1" role="dialog" aria-labelledby="browseprofileLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 78%">
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

  <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') != '') {?>
  <!-- notification popup start -->
  <div class="modal fade notification-popup" id="notificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center modal-header-common" id="staticBackdropLabel">Notification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeNotification()"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <div class="notification-active notifications-list scrollbarContent">
          <ul id="notifications_list_container">
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- notification popup end -->

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
 type="text/javascript">
            //open_sticker_section

            $(document).on('click', '.open_gif_section', function(){
                var postId = $(this).data('gif-post-id');
                runGifStickerProgram('gifs',postId);
            });

            $('.open_sticker_section').on('click', function(){
                var postId = $(this).data('sticker-post-id');
                runGifStickerProgram('stickers',postId);
            });

            function runGifStickerProgram(types,post_Id){

                var type = types;

                var postId = post_Id;

                $('.gif_section_'+postId).show();

                $('.close_gif_div_'+postId).on('click', function(){
                    $('.gif_section_'+postId).hide();
                    $('#searchInput_'+postId).val('');
                });

                if(type=='gifs')
                {
                    $('#searchInput_'+postId).attr('placeholder','Search for GIFs');
                }
                if(type=='stickers'){
                    $('#searchInput_'+postId).attr('placeholder','Search for Stickers');
                }

                searchGifs();

                function displayGifs(gifs) {
                    const gifPicker = $('#gifPicker_'+postId);
                    gifPicker.empty();
                    gifs.forEach(gif => {
                        const img = $('<img>').attr('src', gif.images.downsized_medium.url).attr('alt', gif.title).click(() => {
                            $('#selectedGifUrl_'+postId).val(gif.images.original.url);
                            $('div.comment_post_'+postId).append(gif.images.original.url);
                            $('div.comment_post_'+postId).focus();
                            $('.close_gif_div_'+postId).trigger('click');
                            gifPicker.empty();
                        });
                        gifPicker.append(img);
                    });
                }

                function searchGifs(query) {
                    $.ajax({
                        url: `https://api.giphy.com/v1/${type}/search?api_key=${apiKey}&q=${query}&limit=50`,
                        method: 'GET',
                        success: (response) => {
                            const gifs = response.data;
                            displayGifs(gifs);
                        },
                        error: (xhr, status, error) => {
                            console.error(error);
                        }
                    });
                }

                $('#searchInput_'+postId).on('input', (e) => {
                    const searchTerm = e.target.value.trim();
                    if (searchTerm !== '') {
                        searchGifs(searchTerm);
                    }else{
                        searchGifs();
                    }
                });
            }

        <?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
>

            const apiKey = 'ipXu0ONVnGDpzTs7wdxLFQvCYL8EYzm6';

            $(document).on('click', '.open_reply_gif_section', function () {

                //alert('dfdsf');

                var postId = $(this).data('gif-postid');
                var postCommentId = $(this).data('gif-postcommentid'); 

                runReplyGifStickerProgram('gifs', postId, postCommentId);

            });

            $(document).on('click', '.open_reply_sticker_section', function () {

                //alert('dfdsf');

                var postId = $(this).data('sticker-postid');
                var postCommentId = $(this).data('sticker-postcommentid'); 

                runReplyGifStickerProgram('stickers', postId, postCommentId);

            });

            function runReplyGifStickerProgram(types,post_Id, post_CommentId){

                //alert('sdfdsf');

                var type = types;

                var postId = post_Id;
                var postCommentId = post_CommentId;

                $('.reply_gif_section_'+postId).show();

                $('.reply_close_gif_div_'+postId).on('click', function(){
                    $('.reply_gif_section_'+postId).hide();
                    $('#reply_searchInput_'+postId).val('');
                });

                if(type=='gifs')
                {
                    $('#reply_searchInput_'+postId).attr('placeholder','Search for GIFs');
                }
                if(type=='stickers'){
                    $('#reply_searchInput_'+postId).attr('placeholder','Search for Stickers');
                }

                replySearchGifs();

                function replyDisplayGifs(gifs) {
                    const gifPicker = $('#reply_gifPicker_'+postId);
                    gifPicker.empty();
                    gifs.forEach(gif => {
                        const img = $('<img>').attr('src', gif.images.downsized_medium.url).attr('alt', gif.title).click(() => {
                            // alert(postId);
                            // alert(gif.images.original.url);
                            $('#replycommentad_'+postCommentId).val(gif.images.original.url);
                            $('div.reply_comment_post_'+postId).append(gif.images.original.url);
                            $('div.reply_comment_post_'+postId).focus();
                            $('.reply_close_gif_div_'+postId).trigger('click');
                            gifPicker.empty();
                        });
                        gifPicker.append(img);
                    });
                }

                function replySearchGifs(query) {
                    $.ajax({
                        url: `https://api.giphy.com/v1/${type}/search?api_key=${apiKey}&q=${query}&limit=50`,
                        method: 'GET',
                        success: (response) => {
                            const gifs = response.data;
                            replyDisplayGifs(gifs);
                        },
                        error: (xhr, status, error) => {
                            console.error(error);
                        }
                    });
                }

                $('#reply_searchInput_'+postId).on('input', (e) => {
                    const searchTerm = e.target.value.trim();
                    if (searchTerm !== '') {
                        replySearchGifs(searchTerm);
                    }else{
                        replySearchGifs();
                    }
                });
            }
        <?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
>
        
            $('.chat_open_gif_section').on('click', function(){
                runChatGifStickerProgram('gifs');
            });

            $('.chat_open_sticker_section').on('click', function(){
                runChatGifStickerProgram('stickers');
            });

            function runChatGifStickerProgram(types){

                var type = types;

                $('.chat_gif_section').fadeIn(400);

                $('.chat_close_gif_div').on('click', function(){
                    $('.chat_gif_section').fadeOut(400);
                    $('#chat_searchInput').val('');
                });

                if(type=='gifs')
                {
                    $('#chat_searchInput').attr('placeholder','Search for GIFs');
                }
                if(type=='stickers'){
                    $('#chat_searchInput').attr('placeholder','Search for Stickers');
                }

                chatSearchGifs();

                function chatDisplayGifs(gifs) {
                    const gifPicker = $('#chat_gifPicker');
                    gifPicker.empty();
                    gifs.forEach(gif => {
                        const img = $('<img style="width: auto !important;">').attr('src', gif.images.downsized_medium.url).attr('alt', gif.title).click(() => {
                            //alert(gif.images.original.url);
                            $('#message_input').val(gif.images.original.url);
                            $('div.message-input').append(gif.images.original.url);
                            // $('div.comment_post_'+postId).focus();
                            // $('.close_gif_div_'+postId).trigger('click');
                            // gifPicker.empty();
                        });
                        gifPicker.append(img);
                    });
                }

                function chatSearchGifs(query) {
                    $.ajax({
                        url: `https://api.giphy.com/v1/${type}/search?api_key=${apiKey}&q=${query}&limit=50`,
                        method: 'GET',
                        success: (response) => {
                            const gifs = response.data;
                            chatDisplayGifs(gifs);
                        },
                        error: (xhr, status, error) => {
                            console.error(error);
                        }
                    });
                }

                $('#chat_searchInput').on('input', (e) => {
                    const searchTerm = e.target.value.trim();
                    if (searchTerm !== '') {
                        chatSearchGifs(searchTerm);
                    }else{
                        chatSearchGifs();
                    }
                });
            }
        <?php echo '</script'; ?>
>

        <?php echo '<script'; ?>
 type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/cloudinary-core/2.3.0/cloudinary-core-shrinkwrap.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript" src="https://unpkg.com/cloudinary-video-player/dist/cld-video-player.js"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
            var cld = cloudinary.Cloudinary.new({ cloud_name: 'dmiqh8jar' });

            // Initialize players
            var players = cld.videoPlayers('.cld-video-player', {
            autoplay: true,
            controls: true,
            showLogo: false,
            fluid: true,
            aiHighlightsGraph: true,
            colors: {
                base: '#0C0C0C',
                accent: '#0D6EFF',
                text: '#F1EBF1'
            },
            fontFace: 'Handlee',
            transformation: { width: 500, crop: 'limit' }
            });
        <?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
function closeNotification() {
  $('#notificationModal').modal('hide');
}
<?php echo '</script'; ?>
>
    </body>
</html>
<?php }
}

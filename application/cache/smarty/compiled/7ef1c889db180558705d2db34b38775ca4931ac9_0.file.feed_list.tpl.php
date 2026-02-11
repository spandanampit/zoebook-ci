<?php
/* Smarty version 3.1.28, created on 2025-02-12 06:52:17
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/feed_list.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67acb5a162bef3_29084927',
  'file_dependency' => 
  array (
    '7ef1c889db180558705d2db34b38775ca4931ac9' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/feed_list.tpl',
      1 => 1739371930,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/feed_actions.tpl' => 2,
    'file:common/comments.tpl' => 2,
  ),
),false)) {
function content_67acb5a162bef3_29084927 ($_smarty_tpl) {
$_smarty_tpl->tpl_vars["count"] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "count", 0);?>
<style>
.swiper-container {
    width: 100%;
    height: auto;
    overflow: hidden;
    }
.top-usename {
    width: 9rem;
    color: white;
    text-align: center;
    position: relative;
    right: 31px;
    margin-top: 5px;
    font-weight: bold;
}
/* Container for the button and background */
.video-btn-overlay {
    display: none; /* Hidden initially */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Dark semi-transparent background */
    backdrop-filter: blur(5px); /* Blur effect */
    justify-content: center;
    align-items: center;
    z-index: 10; /* Make sure it appears above the video */
}

/* Button styling */
.refresh-btn {
    background-color: transparent; /* Button background */
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 26px;
    cursor: pointer;
    border-radius: 5px;
    width: 60%;
    display: flex;
}

.refresh-btn i {
    margin-right: 5px;
}

.btn_name{
    text-align: center;
    font-size: 14px;
}
/* Ensure the video is styled properly */
#plyr-video {
    position: relative; /* To ensure the overlay is positioned correctly */
}

</style>


<!--<p><?php echo $_smarty_tpl->tpl_vars['posts_pgtype']->value;?>
</p>-->
<!-- Home Page Posts -->
<?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value != 'my_profile' && $_smarty_tpl->tpl_vars['posts_pgtype']->value != 'other_profile') {?>
<div class="video-dash-post mb-20 feed_item" style="height: 34rem;">
    <!--<?php echo print_r($_smarty_tpl->tpl_vars['playlist_post']->value);?>
-->
    <div class="top-playlist-heading">
        <p class="create-text">
            <a style="color: #FF8D00;" href="#" data-toggle="modal" data-target="#playlistModal"><?php echo $_smarty_tpl->tpl_vars['create']->value;?>
</a>
        </p>
        <p style="color: #FF8D00;"><?php echo $_smarty_tpl->tpl_vars['top_play_list']->value;?>
</p>
    </div>
    <div class="swiper-container top-playlist">
        <div class="swiper-wrapper">
        <!--<pre>
        <?php echo print_r($_smarty_tpl->tpl_vars['playlist_post']->value);?>

        </pre>-->
            <?php
$_from = $_smarty_tpl->tpl_vars['playlist_post']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
                <div class="swiper-slide item" style="margin-right: 0px !important;">
                    <div class="tp-playlist-media" style="height: 29rem;">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/playlistshare');?>
?playlistId=<?php echo $_smarty_tpl->tpl_vars['row']->value['playlist_id'];?>
&userId=<?php echo $_smarty_tpl->tpl_vars['row']->value['playlist_userId'];?>
">
                            <?php if ($_smarty_tpl->tpl_vars['row']->value['main_media'][0]['full_thumbnail_url']) {?>
                                <video width="100%" height="100%" preload="auto" poster="<?php echo $_smarty_tpl->tpl_vars['row']->value['main_media'][0]['full_thumbnail_url'];?>
" style="object-fit: cover;"muted>
                                </video>
                            <?php } else { ?>
                                <video width="100%" height="100%" preload="auto" poster="<?php echo $_smarty_tpl->tpl_vars['row']->value['main_media'][0]['full_thumbnail_url'];?>
" style="object-fit: cover;"muted>
                                    <source src="<?php echo $_smarty_tpl->tpl_vars['row']->value['main_media'][0]['vUploadFile'];?>
" type="video/mp4">
                                </video>
                            <?php }?>
                        </a>
                    </div>
                    <div class="tp-user-image">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['main_media'][0]['u_profile_image'];?>
">
                        <!--<h6 style="width: 10rem; color: white;"><?php echo $_smarty_tpl->tpl_vars['row']->value['main_media'][0]['u_name'];?>
</h6>-->
                        <h6 class="top-usename"><?php echo $_smarty_tpl->tpl_vars['row']->value['main_media'][0]['u_name'];?>
</h6>
                    </div>
                </div>
            <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation -->
        <!--<div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>-->
    </div>
</div>
<?php }?>
<!--<pre>
<?php echo print_r($_smarty_tpl->tpl_vars['posts']->value);?>

</pre>-->

<?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posts']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Share') {?>
        <?php $_smarty_tpl->tpl_vars['posttext_without_emoji'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posttext_without_emoji', 0);?>
        <?php $_smarty_tpl->tpl_vars['meta_posttext_without_emoji'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['text']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'meta_posttext_without_emoji', 0);?>
        <div class="video-dash-post mb-20 feed_item" id="feed_id_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
            <div class="video-dash-post-heading">
                <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <!--<?php echo $_smarty_tpl->tpl_vars['posts_pgtype']->value;?>
-->
                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
">
                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'] != '') {?>
                        <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral') {?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                        <?php } else { ?>
                            <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value != 'other_profile') {?>
                                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                            <?php } else { ?>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                            <?php }?>
                        <?php }?>
                    <?php } else { ?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                    <?php }?>
                    </a>
                </div>
                <div class="video-post-content">
                    <h5><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
" style="color: gray;"><?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
</a></h5>
                    <p title="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'];?>
">
                        
                        <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getLocalDateTime($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'],"Y-m-d H:i");?>

                    </p>
                </div>
                </div>
                <div class="video-post-icon">
                <a href="#">
                   <i class="fa fa-ellipsis-v"></i>
                </a>
                </div>
            </div>
            <div class="video-post-content">
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
">
                    <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext(removeEmoji($_smarty_tpl->tpl_vars['posttext_without_emoji']->value));?>
</p>
                </a>

                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['link'] != '') {?>
                    <p class="displayemoji_comment"><!-- <?php echo nl2br($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['text']);?>
 -->
                    <?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext(removeEmoji($_smarty_tpl->tpl_vars['meta_posttext_without_emoji']->value));?>

                    </p>
                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['title'] != '') {?>
                        <p class="displayemoji_comment"><?php echo nl2br($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['title']);?>
</p>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['image'] != '') {?>
                        <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['link'];?>
"><img style="width:100%;" src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['image'];?>
"/></a>
                    <?php }?>
                <?php } else { ?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_text']);?>
">
                    <p class="displayemoji_comment"><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_text']);?>
</p>
                    </a>
                <?php }?>
            </div>
            <div class="video-post-vid">
                <div class="video-wrapper">
                <p class="view <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['is_impressed'] == 1) {?>active<?php }?>"><i class="fa-regular fa-eye"></i> &nbsp <?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['impression_count'];?>
 </p>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_type'] == 'Live') {?>
                    <?php $_smarty_tpl->tpl_vars['post_media'] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post_media'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'post_media', 0);?>
                    <?php
$__section_j_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_j']) ? $_smarty_tpl->tpl_vars['__section_j'] : false;
$__section_j_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['post_media']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_j_1_total = $__section_j_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_j'] = new Smarty_Variable(array());
if ($__section_j_1_total != 0) {
for ($__section_j_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] = 0; $__section_j_1_iteration <= $__section_j_1_total; $__section_j_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']++){
?>
                        <div class="video-container-2 owl-carousel owl-theme media-slider media_slider" data-getmediaid="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_post_media_id'];?>
" data-getpostid="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_post_id'];?>
" id="video-container">
                            <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Image') {?>
                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file_org'];?>
" alt=""></a>
                            <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Video') {?>
                                <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_vSourceType'] == 'aws') {?>
                                    <video controls="" id="plyr-video" class="playerembed autoplay-video" preload="metadata" width="100%" height="100%" controls data-poster="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_video_thumbnail_org'];?>
" controlsList="nodownload" muted>
                                        <source src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_upload_file'];?>
" type="video/mp4">
                                    </video>
                                <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_vSourceType'] == 'cld') {?>
                                    <video controls="" id="plyr-video" class="playerembed autoplay-video" preload="metadata" width="100%" height="100%" controls data-poster="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_vCloudinary'];?>
" controlsList="nodownload" muted>
                                        <source src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_vCloudinary'];?>
" type="video/mp4">
                                    </video>
                                    
                                <?php }?>
                            <?php }?>
                            <div class="play-button-wrapper">
                            <div title="Play video" class="play-gif" id="circle-play-b">
                                <!-- SVG Play Button -->
                            </div>
                            </div>
                        </div>
                        <div class="video-btn-overlay">
                            <button class="refresh-btn">
                                <div style="margin-right: 100px;" class="btn_options">
                                    <a data-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']);?>
">
                                        <i class="fa fa-toggle-right text-white"></i>
                                        <p class="btn_name text-white"><?php echo $_smarty_tpl->tpl_vars['see_more_in_video']->value;?>
</p>
                                    </a>
                                </div>
                                <div class="btn_options replay-btn">
                                    <i class="fa fa-refresh"></i>
                                    <p class="btn_name"><?php echo $_smarty_tpl->tpl_vars['replay']->value;?>
</p>
                                </div>
                            </button>
                        </div>
                    <?php
}
}
if ($__section_j_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_j'] = $__section_j_1_saved;
}
?>
                <?php }?>
                </div>
            </div>
            <div class="video-share-box-wrapper">
                <div class="video-share-box" id="feed_action_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                <ul>
                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/feed_actions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                </ul>
                </div>
                <div class="video-photo">
                <a href="#">
                    <i class="fa-regular fa-images"></i>
                </a>
                <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value == 'my_profile') {?>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral') {?>
                    <div class="my-progress-bar" data-value="<?php echo time_left($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_added_date'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['expire_date']);?>
" data-thickness="4">
                        <span style="color: gray"><?php echo hours_left($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['expire_date']);?>
</span>
                    </div>
                <?php }?>
                <?php }?>
                
                </div>
            </div>
            <div class="comment">
                <div class="cmnt-pic">
                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'] != '') {?>
                        <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral') {?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                        <?php } else { ?>
                            <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value != 'other_profile') {?>
                                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                            <?php } else { ?>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                            <?php }?>
                        <?php }?>
                    <?php } else { ?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                    <?php }?>
                </div>
                <div class="comment-text comment-text-new">
                    <div class="post-add-comment add-comments">                    
                        <div class="comment-text comment-text-new" style="padding-top: 11px !important;">
                            <form style="display: flex; height: 53px">
                                <div class="form-group">
                                    <textarea class="form-control comment_post comment_post_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" id="comment-box9"  data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" rows="1" placeholder="Add Comment" data-emojiable="true"></textarea>
                                    <span class="err_msg_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="font-size: 12px; color: #4e4c4c;"></span>
                                    <input type="hidden" name="post_comment_emoji" id="post_comment_emoji">
                                </div>
                                <div class="comment-pic" style="background: none">
                                    <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">GIF</span>
                                    <span style="cursor:pointer;" class="open_sticker_section" data-sticker-post-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                                        <img  src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/sticker.png" alt="">
                                    </span>

                                    <span style="cursor:pointer; margin-left:5px;" class="btn_post_media_attach">
                                        <i class="fa fa-paperclip btn_postmedia" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="font-size:18px;"></i>
                                    </span>

                                    <div class="upload_media_div" id="media_div_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="display:none;">
                                        <input type="file" name="upload_file" id="input_media_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="display: none !important;"/>
                                    </div>
                                </div>
                                <!--<button type="submit" class="btn btn-primary form-btn" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" title="Add Comment"><img src=""></button>-->
                                <button type="button" class="btn btn-primary form-btn btn_postcomment" style="cursor:pointer;" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" title="Add Comment">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/plane.png">
                                </button>
                            </form>
                            <div class="feed-comments feed_comments_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
 scrollbarContent feed-comments-main" style="display:none;">
                                <ul id="comments_list_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/comments.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('comments'=>$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['statistics']['comments']), 0, true);
?>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- GIF Section -->
                    <div class="main_gif_div_section gif_section_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                        <input type="text" id="searchInput_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" placeholder="Search for GIFs">
                        <a href="javascript:void(0);" class="close_gif_div_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                        <div class="gif_picker_div_cls" id="gifPicker_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
"></div>
                    </div>
                </div>
                </div>
                
            </div>
    <?php } else { ?>
    <?php $_smarty_tpl->tpl_vars['posttext_without_emoji'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posttext_without_emoji', 0);?>
    <?php $_smarty_tpl->tpl_vars['meta_posttext_without_emoji'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['text']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'meta_posttext_without_emoji', 0);?>
        <div class="video-dash-post mb-20 feed_item" id="feed_id_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                <div class="video-dash-post-heading">
                  <div class="video-dash-post-user">
                    <div class="video-dash-post-img">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
">
                        <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'] != '') {?>
                            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral') {?>
                                <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value == 'my_profile' && $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral' && $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Text') {?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file']) && strpos($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file'],'res.cloudinary.com') != false) {?>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php } else { ?>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php }?>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file']) && strpos($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file'],'res.cloudinary.com') != false) {?>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php }?>
                                
                                <?php }?>
                            <?php } else { ?>
                                <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value != 'other_profile') {?>
                                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                <?php } else { ?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                <?php }?>
                            <?php }?>
                        <?php } else { ?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                        <?php }?>
                    </a>
                    </div>
                    <div class="video-post-content">
                    <h5><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
" style="color: gray;"><?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
</a></h5>
                      <p title="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'];?>
">
                            
                            <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getLocalDateTime($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'],"M j, Y- g:i A");?>

                      </p>
                    </div>
                  </div>
                  <div class="video-post-icon">
                    <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value == 'my_profile' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'] == $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId')) {?>
                            <a class="dropdown-item edit_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['edit']->value;?>
</a>
                            <a class="dropdown-item delete_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['delete']->value;?>
</a>
                            <a class="dropdown-item" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" onclick="addToPlaylist(<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['add_to_playlist']->value;?>
</a>
                        <?php } else { ?>
                            <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['spam']->value;?>
</a>
                            <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['inappropriate']->value;?>
?</a>
                            <a class="dropdown-item block_user" data-userid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'];?>
" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['block']->value;?>
</a>
                            <a class="dropdown-item hide_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['hide_post']->value;?>
</a>
                            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_post_media'][0]['pm_media_type'] == 'Video') {?>
                                <a class="dropdown-item" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" onclick="addToPlaylist(<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
)"><?php echo $_smarty_tpl->tpl_vars['add_to_playlist']->value;?>
</a>
                            <?php }?>
                        <?php }?>
                    </div>
                  </div>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['link'] != '') {?>
                    <div class="video-post-content">
                        <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
</p><br>
                        <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['title'] != '') {?>
                            <p><?php echo nl2br($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['title']);?>
</p>
                        <?php }?>
                    </div>
                    <?php $_smarty_tpl->tpl_vars['post_media'] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post_media'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'post_media', 0);?>
                    <div class="video-post-vid">
                        <div class="video-wrapper">
                            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_post_media'][0]['pm_media_type'] == 'Video') {?>
                                <p class="view <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['is_impressed'] == 1) {?>active<?php }?> "><i class="fa-regular fa-eye"></i> &nbsp <?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['impression_count'];?>
</p>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['image'] != '') {?>
                                <?php if (strpos($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['link'],'http') === false) {?>
                                    <?php $_smarty_tpl->tpl_vars['protocol'] = new Smarty_Variable('http://', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'protocol', 0);?>
                                <?php } else { ?>
                                    <?php $_smarty_tpl->tpl_vars['protocol'] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'protocol', 0);?>
                                <?php }?>
                                <div class="video-container-2" id="video-container">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['image'];?>
">
                                    <div class="play-button-wrapper">
                                        <div title="Play video" class="play-gif" id="circle-play-b">
                                        <!-- SVG Play Button -->
                                        </div>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                <?php } else { ?>
                    
                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'LiveNow' && in_array(strtolower($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['ts_archive_status']),array('started','paused')) !== false) {?>
                        <div class="video-post-content">                     
                            <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext(removeEmoji($_smarty_tpl->tpl_vars['posttext_without_emoji']->value));?>
</p><br>
                        </div>
                        <div class="video-post-vid">
                            <div class="video-wrapper">
                                <p class="view"><i class="fa-regular fa-eye"></i> 12</p>
                                    <?php $_smarty_tpl->tpl_vars["live_thumb_path"] = new Smarty_Variable(((($_smarty_tpl->tpl_vars['this']->value->config->item('live_thumb_path')).("screenshot_")).($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'])).(".jpeg"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "live_thumb_path", 0);?>
                                    <?php $_smarty_tpl->tpl_vars["live_thumb_url"] = new Smarty_Variable(((($_smarty_tpl->tpl_vars['this']->value->config->item('live_thumb_url')).("screenshot_")).($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'])).(".jpeg"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "live_thumb_url", 0);?>
                                    <?php if (file_exists($_smarty_tpl->tpl_vars['live_thumb_path']->value)) {?>
                                        <div class="video-container-2" id="video-container">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['live_thumb_url']->value;?>
">
                                            <div class="play-button-wrapper">
                                                <div title="Play video" class="play-gif" id="circle-play-b">
                                                <!-- SVG Play Button -->
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                
                            </div>
                        </div>
                    <?php } elseif (($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'LiveNow' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Live') && in_array(strtolower($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['ts_archive_status']),array('stopped','uploaded')) !== false) {?>
                         <div class="video-post-content">
                            <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
</p><br>
                        </div>
                        <div class="video-post-vid">
                            <div class="video-wrapper">
                                <p class="view"><i class="fa-regular fa-eye"></i> </p>
                                    <?php $_smarty_tpl->tpl_vars["live_thumb_path"] = new Smarty_Variable(((($_smarty_tpl->tpl_vars['this']->value->config->item('live_thumb_path')).("screenshot_")).($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'])).(".jpeg"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "live_thumb_path", 0);?>
                                    <?php $_smarty_tpl->tpl_vars["live_thumb_url"] = new Smarty_Variable(((($_smarty_tpl->tpl_vars['this']->value->config->item('live_thumb_url')).("screenshot_")).($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'])).(".jpeg"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "live_thumb_url", 0);?>
                                <?php if (file_exists($_smarty_tpl->tpl_vars['live_thumb_path']->value)) {?>
                                    
                                    <?php if ($_smarty_tpl->tpl_vars['this']->value->general->get_archive_video($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['ts_archive_id']) !== false) {?>
                                        <div class="video-container-2" id="video-container">
                                            
                                            <?php $_smarty_tpl->tpl_vars["video_filename"] = new Smarty_Variable(pathinfo($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['live_video_url'],PATHINFO_FILENAME), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_filename", 0);?>
                                            <?php $_smarty_tpl->tpl_vars["video_extension"] = new Smarty_Variable(pathinfo($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['live_video_url'],PATHINFO_EXTENSION), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_extension", 0);?>
                                            
                                            <?php if (strpos($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['live_video_url'],'res.cloudinary.com') !== false) {?>

                                                <video
                                                    muted
                                                    data-cld-public-id="<?php echo $_smarty_tpl->tpl_vars['video_filename']->value;?>
"
                                                    class="cld-video-player cld-video-player-skin-light"
                                                    data-cld-autoplay-mode="on-scroll" st>
                                                </video>

                                            <?php } else { ?>

                                                <video controls="" id="video" preload="metadata" width="100%" height="100%" poster="<?php echo $_smarty_tpl->tpl_vars['live_thumb_url']->value;?>
">
                                                    <source src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['live_video_url'];?>
" type="video/mp4">
                                                </video>

                                            <?php }?>

                                            
                                            <div class="play-button-wrapper">
                                                <div title="Play video" class="play-gif" id="circle-play-b">
                                                <!-- SVG Play Button -->
                                                </div>
                                            </div>
                                        </div>
                                    <?php }?>
                                <?php }?>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="video-post-content">
                                <p ><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext(removeEmoji($_smarty_tpl->tpl_vars['posttext_without_emoji']->value));?>
</p> 
                        </div>
                        <div class="video-post-vid">
                            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media') {?> 
                                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Live') {?>
                                    <?php $_smarty_tpl->tpl_vars['post_media'] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_post_media'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'post_media', 0);?>
                                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_post_media'][0]['pm_media_type'] == 'Video') {?>
                                    <div class="video-wrapper">
                                        <p class="view <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['is_impressed'] == 1) {?>active<?php }?> "><i class="fa-regular fa-eye"></i> &nbsp <?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['impression_count'];?>
</p>
                                    </div>
                                    <?php }?>
                                        <div class=" owl-carousel owl-theme media-slider carousel<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                                            
                                            
                                            <?php
$__section_j_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_j']) ? $_smarty_tpl->tpl_vars['__section_j'] : false;
$__section_j_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['post_media']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_j_2_total = $__section_j_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_j'] = new Smarty_Variable(array());
if ($__section_j_2_total != 0) {
for ($__section_j_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] = 0; $__section_j_2_iteration <= $__section_j_2_total; $__section_j_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']++){
?>
                                                <div class="video-container-2" id="video-container" data-getmediaid="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_post_media_id'];?>
" data-getpostid="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['post_id'];?>
">
                                                    <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Image') {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file_orgh'] != '') {?>
                                                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file_org'];?>
" alt=""></a>
                                                        <?php } else { ?>
                                                            <img src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['display_image'];?>
" alt="">
                                                        <?php }?>
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Video') {?>

                                                        <?php if ($_smarty_tpl->tpl_vars['is_detail']->value == "Yes") {?>
                                                            <?php $_smarty_tpl->tpl_vars["video_url"] = new Smarty_Variable($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_url", 0);?>
                                                        <?php } else { ?>
                                                            <?php $_smarty_tpl->tpl_vars["video_url"] = new Smarty_Variable($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_upload_file'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_url", 0);?>
                                                        <?php }?>

                                                        <?php $_smarty_tpl->tpl_vars["video_filename"] = new Smarty_Variable(pathinfo($_smarty_tpl->tpl_vars['video_url']->value,PATHINFO_FILENAME), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_filename", 0);?>
                                                        <?php $_smarty_tpl->tpl_vars["video_extension"] = new Smarty_Variable(pathinfo($_smarty_tpl->tpl_vars['video_url']->value,PATHINFO_EXTENSION), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_extension", 0);?>

                                                        <!---->

                                                        <?php if (strpos($_smarty_tpl->tpl_vars['video_url']->value,'res.cloudinary.com') !== false) {?>
                                                        
                                                            <video
                                                                muted
                                                                data-cld-public-id="<?php echo $_smarty_tpl->tpl_vars['video_filename']->value;?>
"
                                                                class="cld-video-player cld-video-player-skin-light"
                                                                data-cld-autoplay-mode="on-scroll">
                                                            </video>

                                                        <?php } else { ?>

                                                            <video class="plyr-video playerembed video-btns" width="100%" height="100%" preload="metadata" controls data-poster="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['video_thumbnail_org'];?>
" muted>
                                                                <source src="<?php echo $_smarty_tpl->tpl_vars['video_url']->value;?>
" type="video/mp4">
                                                            </video>

                                                            <!-- The button will be displayed when the video ends -->
                                                            <div class="video-btn-overlay">
                                                                <button class="refresh-btn">
                                                                    <div style="margin-right: 100px;" class="btn_options">
                                                                    <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value == 'my_profile' || $_smarty_tpl->tpl_vars['posts_pgtype']->value == 'other_profile') {?>
                                                                        <a data-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']);?>
?pageType=Profile&userId=<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_user_id'];?>
">
                                                                    <?php } else { ?>
                                                                        <a data-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']);?>
">
                                                                    <?php }?>
                                                                            <i class="fa fa-toggle-right text-white"></i>
                                                                            <p class="btn_name text-white"><?php echo $_smarty_tpl->tpl_vars['see_more_in_video']->value;?>
</p>
                                                                        </a>
                                                                    </div>
                                                                    <div class="btn_options replay-btn">
                                                                        <i class="fa fa-refresh"></i>
                                                                        <p class="btn_name"><?php echo $_smarty_tpl->tpl_vars['replay']->value;?>
</p>
                                                                    </div>
                                                                </button>
                                                            </div>

                                                        <?php }?>

                                                    <?php }?>
                                                </div>
                                            <?php
}
}
if ($__section_j_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_j'] = $__section_j_2_saved;
}
?>
                                        </div>
                                <?php }?>
                            <?php }?>    
                        </div>
                    <?php }?>
                <?php }?>
                <div class="video-share-box-wrapper">
                  <div class="video-share-box" id="feed_action_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" >
                    <ul>
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/feed_actions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                    </ul>
                  </div>
                  <div class="video-photo">
                    <a href="#">
                      <i class="fa-regular fa-images"></i>
                    </a>
                        <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral') {?>
                            <div class="my-progress-bar" data-value="<?php echo time_left($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_added_date'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['expire_date']);?>
" data-thickness="4">
                                <span style="color: gray;"><?php echo hours_left($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['expire_date']);?>
</span>
                            </div>
                        <?php }?>
                  </div>
                </div>
                <div class="comment">
                    <div class="cmnt-pic">
                        <!--<img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">-->
                        <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'] != '') {?>
                            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral') {?>
                                <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value == 'my_profile' && $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['visibility'] == 'Viral' && $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Text') {?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file']) && strpos($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file'],'res.cloudinary.com') != false) {?>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php } else { ?>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php }?>
                                <?php } else { ?>
                                    <?php if (isset($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file']) && strpos($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pm_upload_file'],'res.cloudinary.com') != false) {?>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                    <?php }?> 
                                <?php }?>
                            <?php } else { ?>
                                <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value != 'other_profile') {?>
                                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                <?php } else { ?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                                <?php }?>
                            <?php }?>
                        <?php } else { ?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                        <?php }?>
                    </div>  
                    <div class="post-add-comment add-comments">                    
                        <div class="comment-text comment-text-new"style="padding-top: 11px !important;">
                            <form style="display: flex; height: 53px">
                                <div class="form-group">
                                <textarea class="form-control comment_post_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" 
                                    id="comment-box<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
"
                                    aria-describedby="emailHelp" 
                                    data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" 
                                    rows="1" 
                                    placeholder="Add Comment" 
                                    data-emojiable="true" 
                                    style="color:gray" 
                                    oninput="handleGif('<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
')"
                                    onchange="handleGif('<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
')"
                                    onkeydown="return handleCommentKeyDown(event, '<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
')">
                                </textarea>


                                    <span class="err_msg_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="font-size: 12px; color: #4e4c4c;" onkeydown="return handleCommentKeyDown(event, '<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
')"></span>
                                </div>
                                <div class="upload_media_div" id="media_div_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="display: none;">
                                    <input type="file" name="upload_file" id="input_media_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="display: none !important;">
                                </div>
                                <div class="comment-pic" style="background: none">
                                    <span style="cursor: pointer" class="btn_post_media_attach">
                                        <i class="fa fa-paperclip btn_postmedia" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="font-size: 16px !important"></i>
                                    </span>
                                    <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">GIF</span>
                                    <span style="cursor:pointer; " class="open_sticker_section" data-sticker-post-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                                        <img  src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/sticker.png" alt="">
                                    </span>

                                    <div class="upload_media_div" id="media_div_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                                        <input type="file" name="upload_file" id="input_media_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="display: none !important;" />
                                    </div>
                                </div>
                                <input type="hidden" name="post_comment_emoji" id="post_comment_emoji">
                               <button type="button" class="btn btn-primary form-btn btn_postcomment" style="cursor:pointer;" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" title="Add Comment"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/plane.png"></button>
                            </form><br>
                            <div class="feed-comments feed_comments_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
 scrollbarContent feed-comments-main" style="display:none;">
                                <ul id="comments_list_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/comments.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('comments'=>$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['statistics']['comments']), 0, true);
?>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- GIF Section -->
                       <div class="main_gif_div_section gif_section_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="display: none;">
                            <input type="text" id="searchInput_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" placeholder="Search for Stickers">
                            <a href="javascript:void(0);" class="close_gif_div_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" >
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a>
                            <div class="gif_picker_div_cls" id="gifPicker_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                            </div>    
                        </div>
                  </div>
                </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['count']->value%3 == 0) {?>
    <div class="banner-add" style="display: flex;">
        <div class="first-banner-add">
            <?php echo '<script'; ?>
 type="text/javascript">
                atOptions = {
                    'key' : '2fd09803d5d988416c78942dc800028d',
                    'format' : 'iframe',
                    'height' : 500,
                    'width' : 300,
                    'params' : {}
                };
            <?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 type="text/javascript" src="//www.topcreativeformat.com/2fd09803d5d988416c78942dc800028d/invoke.js"><?php echo '</script'; ?>
>
        </div>
        <div class="second-banner-add">
            <?php echo '<script'; ?>
 type="text/javascript">
                atOptions = {
                    'key' : '2fd09803d5d988416c78942dc800028d',
                    'format' : 'iframe',
                    'height' : 500,
                    'width' : 300,
                    'params' : {}
                };
            <?php echo '</script'; ?>
>
            <?php echo '<script'; ?>
 type="text/javascript" src="//www.topcreativeformat.com/2fd09803d5d988416c78942dc800028d/invoke.js"><?php echo '</script'; ?>
>
        </div>
    </div>
    <?php }?>
    <p style="display: none"><?php echo $_smarty_tpl->tpl_vars['count']->value++;?>
</p>
<?php }} else {
 ?>
    <p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;"><?php echo $_smarty_tpl->tpl_vars['no_post_available']->value;?>
</p>
<?php
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>


<div class="modal fade cmn-modal create-post-modal" id="reportPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Report Post</h5>
            </div>
            <form class="cmn-form" id="form_report" method='post'>
                <input type="hidden" name="report_post_id" id="report_post_id" value=""/>
                <div class="modal-body">
                    <div class="form-group input-group col-4">
                        <select class="form-control" id="eReprtType" name="eReprtType">
                            <option value="Spam">Spam</option>
                            <option value="InAppropriate">In Appropriate</option>
                        </select>
                    </div>
                    <div class="upload-text">
                        <textarea name="report_notes" id="report_notes" class="form-control" rows="5" placeholder="Notes (optional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_report_post" class="btn btn-primary" style="background: #8E65A1">Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade cmn-modal create-post-modal" id="sharePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Share This Post</h5>
            </div>
            <form id="form_share" method='post'>
                <input type="hidden" name="share_post_id" id="share_post_id" value=""/>
                <div class="modal-body">
                    <div class="upload-text">
                        <i class="cmn-user-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="">
                        </i>
                        <textarea name="share_post_text" id="share_post_text" class="form-control" rows="5" placeholder="What’s on your mind?"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="share_timeline" class="btn btn-primary" style="background: #8E65A1;">Share on My Timeline</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Playlist Modal --> 

<div class="modal fade cmn-modal" id="playlistModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center modal-header-common" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body">
                <div class="notifications-list scrollbarContent">
                    <ul id="notifications_list_container">
                        <ul>
                            <section class="video-sec">
                                <div class="container">
                                    <div class="row mb-40">
                                        <div class="col-md-12">
                                            <div class="video-grid" style="grid-template-columns: repeat(4, 1fr) !important ;">
                                                <?php
$_from = $_smarty_tpl->tpl_vars['posts']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_1_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_1_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_1_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_1_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
                                                <?php if (!empty($_smarty_tpl->tpl_vars['row']->value['get_post_media']) && $_smarty_tpl->tpl_vars['row']->value['post_type'] == 'Media' && $_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_media_type'] == 'Video') {?>
                                                    <?php $_smarty_tpl->tpl_vars['post_media'] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['get_post_media'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'post_media', 0);?>
                                                    <div class="video-item">
                                                        <div class="video-box">
                                                            <div class="video-img-box">
                                                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['row']->value['u_users_id'],$_smarty_tpl->tpl_vars['row']->value['u_name']);?>
">
                                                                <?php if ($_smarty_tpl->tpl_vars['post_media']->value[0]['pm_media_type'] == 'Video') {?>
                                                                    <!--<?php if ($_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vSourceType'] == 'aws') {?>
                                                                        <video controls="" id="plyr-video" class="playerembed" preload="metadata" width="100%" height="100%" data-poster="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_video_thumbnail_org'];?>
" controlsList="nodownload" muted>
                                                                            <source src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_upload_file'];?>
" type="video/mp4">
                                                                        </video>
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vSourceType'] == 'cld') {?>
                                                                        <video controls="" id="plyr-video" class="playerembed" preload="metadata" width="100%" height="100%" data-poster="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vCloudinary'];?>
" controlsList="nodownload" muted>
                                                                            <source src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vCloudinary'];?>
" type="video/mp4">
                                                                        </video>
                                                                    <?php }?>-->
                                                                    <video controls="" id="plyr-video" preload="metadata" width="100%" height="100%" data-poster="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_video_thumbnail'];?>
" controlsList="nodownload" muted style="min-height: 12rem; object-fit:cover;">
                                                                        <source src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['upload_file_org'];?>
" type="video/mp4">
                                                                    </video>
                                                                <?php }?>
                                                                </a>
                                                            </div>
                                                            <div class="video-content">
                                                                <div class="video-heading">
                                                                <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['post_text_emoji']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
                                                                <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,20), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
                                                                    <h3><?php echo $_smarty_tpl->tpl_vars['posted_text']->value;?>
</h3>
                                                                    <a href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                                </div>
                                                                <div class="follow-button">    
                                                                    <a href="#" class="btn btn-primary act_followuser" onclick="addToPlaylist(<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
)" style="background-color: #e8790a; border-color:#e8790a;">Add To Playlist</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } elseif (!empty($_smarty_tpl->tpl_vars['row']->value['get_actual_post']) && $_smarty_tpl->tpl_vars['row']->value['get_actual_post']['p_post_type'] == 'Media') {?>
                                                    <?php $_smarty_tpl->tpl_vars['post_media'] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['get_actual_post_media'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'post_media', 0);?>
                                                    <div class="video-item">
                                                        <div class="video-box">
                                                            <div class="video-img-box" >
                                                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['row']->value['u_users_id'],$_smarty_tpl->tpl_vars['row']->value['u_name']);?>
">
                                                                <?php if ($_smarty_tpl->tpl_vars['post_media']->value[0]['pm_media_type'] == 'Image') {?>
                                                                    <img class="search-image" src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['upload_file_org'];?>
" alt="" style="min-height: 12rem; object-fit:cover;">
                                                                <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[0]['pm_media_type'] == 'Video') {?>
                                                                    <?php if ($_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vSourceType'] == 'aws') {?>
                                                                        <img class="search-image" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_video_thumbnail_org'];?>
" alt="" style="min-height: 12rem; object-fit:cover;">
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vSourceType'] == 'cld') {?>
                                                                        <video controls="" id="plyr-video" preload="metadata" width="100%" height="100%" data-poster="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vCloudinary'];?>
" controlsList="nodownload" muted style="min-height: 12rem; object-fit:cover;">
                                                                            <source src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[0]['pm_vCloudinary'];?>
" type="video/mp4">
                                                                        </video>
                                                                    <?php }?>
                                                                <?php }?>
                                                                </a>
                                                            </div>
                                                            <div class="video-content">
                                                                <div class="video-heading"> 
                                                                    <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['get_actual_post']['p_post_text']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
                                                                    <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,10), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
                                                                    <h3><?php echo $_smarty_tpl->tpl_vars['posted_text']->value;?>
</h3>
                                                                    <!--<a href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>-->
                                                                </div>
                                                                <div class="follow-button">    
                                                                    <a href="#" class="btn btn-primary" onclick="addToPlaylist(<?php echo $_smarty_tpl->tpl_vars['row']->value['get_actual_post']['p_post_id'];?>
)" style="background-color: #e8790a; border-color:#e8790a;">Add To Playlist</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved_local_item;
}
}
if ($__foreach_row_1_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved_item;
}
?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

function handleGif(postId) {
    var textarea = document.getElementById("comment-box" + postId);
    var mainGifDiv = document.querySelector(".comment_post_" + postId);
    
    console.log("Main GIF Div:", mainGifDiv);
    
    if (textarea) {
        const gifLink = textarea.value.trim();

        if (/^https:\/\/media\d*\.giphy\.com\/media/.test(gifLink)) {
            console.log("GIF URL detected:", gifLink);

            textarea.value = "";  
            textarea.dispatchEvent(new Event("input"));
            $(".comment_post_" +  postId).html("");


            if (typeof jQuery !== "undefined") {
                $(textarea).val("").trigger("change").trigger("input"); 
            }

            $.ajax({
                url: "/add_comment",
                type: "POST",
                data: { comment_post_id: postId, comment: gifLink },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        console.log("GIF URL submitted successfully:", response.data);
                    } else {
                        console.error("Error submitting GIF:", response.message);
                    }
                    $("#comment_dots_" + postId).trigger("click");

                    // Ensure textarea remains empty
                    setTimeout(() => {
                        textarea.value = "";
                        if (typeof jQuery !== "undefined") {
                            $(textarea).val("").trigger("change").trigger("input");
                        }
                    }, 50);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error:", textStatus, errorThrown);
                }
            });

            textarea.blur();  // Remove focus from textarea
        } else {
            console.log("Post ID:", postId, "Content but in ELSE case:", gifLink);
        }
    } else {
        console.error("Textarea not found for post ID:", postId);
    }
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[class^='comment_post_']").forEach(div => {
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.type === "childList" || mutation.type === "characterData") {
                    let postId = div.getAttribute("data-postid"); // Get post ID
                    if (div.innerHTML.trim().startsWith("https://media")) {
                        handleGif(postId);
                    }
                }
            });
        });

        observer.observe(div, { childList: true, characterData: true, subtree: true });
    });
});



// function submitComment(postId) {
//     let form = document.querySelector(`#comment-box${postId}`).closest("form");

//     if (form) {
//         console.log("Submitting comment...");
//         form.submit();
//     }
// }
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    function addToPlaylist(postId) {
        console.log(postId);
        var url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/addToPlaylist');?>
"
        $.ajax({
            url: url,
            type: "POST",
            data: { postId: postId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    console.log("Video added to playlist successfully!");
                    var successMessage = document.createElement('div');
                    successMessage.textContent = "Video added to playlist successfully!";
                    successMessage.style.position = 'fixed';
                    successMessage.style.top = '20px';
                    successMessage.style.left = '50%';
                    successMessage.style.transform = 'translateX(-50%)';
                    successMessage.style.backgroundColor = '#dff0d8';
                    successMessage.style.padding = '10px';
                    successMessage.style.border = '1px solid #3c763d';
                    successMessage.style.borderRadius = '5px';
                    successMessage.style.zIndex = '9999';
                    
                    document.body.appendChild(successMessage);
                    
                    setTimeout(function() {
                        document.body.removeChild(successMessage);
                    }, 5000);
                } else {
                    console.error("Error adding video to playlist:", response.message);
                    var errorMessage = document.createElement('div');
                    errorMessage.textContent = "Video added to playlist successfully!";
                    errorMessage.style.position = 'fixed';
                    errorMessage.style.top = '20px';
                    errorMessage.style.left = '50%';
                    errorMessage.style.transform = 'translateX(-50%)';
                    errorMessage.style.backgroundColor = '#ff0000';
                    errorMessage.style.padding = '10px';
                    errorMessage.style.border = '1px solid #3c763d';
                    errorMessage.style.borderRadius = '5px';
                    errorMessage.style.zIndex = '9999';
                    
                    document.body.appendChild(errorMessage);
                    
                    setTimeout(function() {
                        document.body.removeChild(errorMessage);
                    }, 5000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        });
    }

    function showSuccessMessage(message) {
        alert(message);
    }


    // document.addEventListener('DOMContentLoaded', () => {
    //     const videos = document.querySelectorAll('#plyr-video');

    //     videos.forEach(video => {
    //         video.addEventListener('mouseenter', () => {
    //         video.play();
    //         });

    //         video.addEventListener('mouseleave', () => {
    //         video.pause();
    //         video.currentTime = 0;
    //         });
    //     });
    // });


    $(document).ready(function() {
        
    const videoElements = document.querySelectorAll('.video-container-2 video');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.play();
        } else {
            entry.target.pause();
        }
        });
    });

  videoElements.forEach(video => observer.observe(video));

  // Method 2: jQuery scroll event (alternative approach)
  /*
  var offsetRange = $(window).height() / 3,
      offsetTop = $(window).scrollTop() + offsetRange + $("#header").outerHeight(true),
      offsetBottom = offsetTop + offsetRange;

  $(window).scroll(function(e) {
    $(".video").each(function () { 
      var y1 = $(this).offset().top;
      var y2 = offsetTop;
      if (y1 + $(this).outerHeight(true) < y2 || y1 > offsetBottom) {
        this.pause(); 
      } else {
        this.play();
      }
    });
  });
  */
});

document.addEventListener('DOMContentLoaded', function() {
    var paperclipIcons = document.querySelectorAll('.fa-paperclip.btn_postmedia');
    
    paperclipIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            var postId = icon.getAttribute('data-postid');
            var fileInput = document.getElementById('input_media_' + postId);
            if (fileInput) {
                // Reset the input value to ensure the dialog opens every time
                fileInput.value = '';
                fileInput.click();
            }
        });
    });
});

<?php echo '</script'; ?>
>


<?php echo '<script'; ?>
>
    console.log('Script loaded');

    function handleCommentKeyDown(event, postId) {
        console.log('Function called');
        console.log('Key pressed:', event.key);
        console.log('Post ID:', postId);

        if (event.key === 'Enter' && !event.shiftKey) {
            console.log('Enter key pressed without Shift');
            event.preventDefault();
            
            const submitButton = document.querySelector(`.btn_postcomment[data-postid="${postId}"]`);
            
            if (submitButton) {
                console.log('Submit button found, clicking...');
                submitButton.click();
            } else {
                console.log('Submit button not found');
            }
            
            return false;
        }
        return true;
    }

    // Use event delegation
    document.addEventListener('keydown', function(event) {
        const target = event.target;
        if (target.matches('div[class*="comment_post_"]')) {
            const postId = target.className.match(/comment_post_(\d+)/)[1];
            handleCommentKeyDown(event, postId);
        }
    });

    console.log('Event delegation set up');
<?php echo '</script'; ?>
>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.top-playlist', {
        loop: true,
        slidesPerView: 3,   // Number of slides visible at once
        spaceBetween: 10,   // Space between slides in pixels
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        // pagination: {
        //     el: '.swiper-pagination',
        //     clickable: true,
        // },
        // navigation: {
        //     nextEl: '.swiper-button-next',
        //     prevEl: '.swiper-button-prev',
        // },
    });
});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
document.addEventListener("DOMContentLoaded", function() {
    // Select both class and id-based videos
    var videos = document.querySelectorAll(".plyr-video, #plyr-video");
    var overlays = document.querySelectorAll(".video-btn-overlay");

    videos.forEach(function(video, index) {
        var replayButton = overlays[index].querySelector('.replay-btn');
        
        // Show overlay when the video ends
        video.addEventListener('ended', function() {
            overlays[index].style.display = 'flex';
            console.log('Video ' + (index + 1) + ' ended');
        });

        // Replay the video when the replay button is clicked
        replayButton.addEventListener('click', function() {
            video.currentTime = 0; // Reset the video time to the start
            video.play();          // Play the video again
            overlays[index].style.display = 'none'; // Hide the overlay when replaying
        });
    });
});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
document.addEventListener('DOMContentLoaded', function() {
    function handleEmojiClick(event, postId) {
        const emoji = event.target.textContent;
        const commentBox = document.getElementById(`comment-box${postId}`);
        if (commentBox) {
            commentBox.value += emoji;
            const submitButton = document.querySelector(`.btn_postcomment[data-postid="${postId}"]`);
            if (submitButton) {
                submitButton.click();
            }
        }
    }

    const emojiElements = document.querySelectorAll('[data-emojiable="true"]');
    emojiElements.forEach(function(emojiElement) {
        emojiElement.addEventListener('click', function(event) {
            const postId = emojiElement.getAttribute('data-postid');
            handleEmojiClick(event, postId);
        });
    });
});



<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>


<?php echo '</script'; ?>
>
<?php }
}

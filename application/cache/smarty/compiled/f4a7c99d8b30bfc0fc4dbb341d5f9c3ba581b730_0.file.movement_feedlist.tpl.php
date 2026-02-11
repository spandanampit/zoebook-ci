<?php
/* Smarty version 3.1.28, created on 2025-01-23 06:07:00
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_feedlist.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67924d04e39405_80790679',
  'file_dependency' => 
  array (
    'f4a7c99d8b30bfc0fc4dbb341d5f9c3ba581b730' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_feedlist.tpl',
      1 => 1737641214,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/movement_post_comment.tpl' => 1,
  ),
),false)) {
function content_67924d04e39405_80790679 ($_smarty_tpl) {
?>

<style>
.share_mvt_posst {
    font-size: 16px;
    color: gray;
    padding: 8px;
    border: 1px solid #e0d9d9;
}
.mvt_post_sec {
    padding: 0px 0px 0px 0px;
}

.post_action_box {
    position: absolute;
    z-index: 29;
    right: 39px;
    border: 2px solid #80808073;
    /* widht: 116rem; */
    width: 7rem;
    background: white;
    padding: 0px;
    border-radius: 10px;
}

.dropdown-item {
    padding: 10px;
    font-size: 14px;
    height: 27px !important;
    min-height: 27px !important;
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
<?php if (!empty($_smarty_tpl->tpl_vars['movements_post']->value)) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['movements_post']->value;
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
    <!--<?php echo print_r($_smarty_tpl->tpl_vars['row']->value);?>
-->
    <div class="main pt-3">
        <div class="video-dash-post mb-20">
            <div class="video-dash-post-heading">
            <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_profile_image'];?>
" alt="">
                </div>
                <div class="video-post-content">
                <h5><?php echo $_smarty_tpl->tpl_vars['row']->value['user_name'];?>
</h5>
                    <p>
                        
                        <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getLocalDateTime($_smarty_tpl->tpl_vars['row']->value['added_date'],"Y-m-d H:i");?>

                    </p>
                </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['posted_user_id'] == $_smarty_tpl->tpl_vars['userinfo']->value['iUserId']) {?>
            <div class="video-post-icon">
                <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="dropdownMenuButton(<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
);">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="post_action_box dropdown-menu-right" aria-labelledby="dropdownMenuButton_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" id="dropdownMenuButton_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="display: none;">
                    <a class="dropdown-item edit_post" data-bs-toggle="modal" data-bs-target="#editPost_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['edit']->value;?>
</a>
                    <a class="dropdown-item delete_post" data-post-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
, <?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['delete']->value;?>
</a>
                </div>
            </div>
            <?php }?>
            
            </div>
            <div class="video-post-content">
            <p><?php echo $_smarty_tpl->tpl_vars['row']->value['post_text'];?>
</p>
            </div>

            <div class="video-post-vid  <?php if ($_smarty_tpl->tpl_vars['row']->value['post_type'] == 'Share') {?> share_mvt_posst <?php }?>">
                <?php if ($_smarty_tpl->tpl_vars['row']->value['post_type'] == 'Share') {?>
                    <div class="video-dash-post-user" style="padding: 5px;">
                        <div class="video-dash-post-img">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['share_user_info']['u_profile_image'];?>
" alt="">
                        </div>
                        <div class="video-post-content">
                        <h5><?php echo $_smarty_tpl->tpl_vars['row']->value['share_user_info']['u_name'];?>
</h5>
                        </div>
                    </div>
                    <div class="video-post-content" style="padding: 5px;">
                    <?php if ($_smarty_tpl->tpl_vars['row']->value['post_type'] == 'Share') {?>
                        <p><?php echo $_smarty_tpl->tpl_vars['row']->value['pm.post_text'];?>
</p>
                    <?php }?>
                    </div>
                <?php }?>
                <div class="video-wrapper <?php if ($_smarty_tpl->tpl_vars['row']->value['post_type'] == 'Share') {?> mvt_post_sec <?php }?>">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php
$_from = $_smarty_tpl->tpl_vars['row']->value['get_post_media'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_media_1_saved_item = isset($_smarty_tpl->tpl_vars['media']) ? $_smarty_tpl->tpl_vars['media'] : false;
$_smarty_tpl->tpl_vars['media'] = new Smarty_Variable();
$__foreach_media_1_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_media_1_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['media']->value) {
$__foreach_media_1_saved_local_item = $_smarty_tpl->tpl_vars['media'];
?>
                                <div class="swiper-slide">
                                    <?php if ($_smarty_tpl->tpl_vars['media']->value['pm_media_type'] == 'Video') {?>
                                        <div class="video-container-2" id="video-container">
                                            <?php if ($_smarty_tpl->tpl_vars['row']->value['post_type'] != 'Share') {?>
                                                <video controls="" id="video" preload="metadata" poster="<?php echo $_smarty_tpl->tpl_vars['media']->value['pm_video_thumbnail'];?>
">
                                                    <source src="<?php echo $_smarty_tpl->tpl_vars['media']->value['upload_file_org'];?>
" type="video/mp4">
                                                </video>
                                            <?php } else { ?>
                                                <?php if ($_smarty_tpl->tpl_vars['media']->value['pm_vSourceType'] == 'aws') {?>  
                                                <video controls="" id="video" preload="metadata" poster="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_video_thumbnail_org'];?>
">
                                                    <source src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_upload_file'];?>
" type="video/mp4">
                                                </video>
                                                <?php } else { ?>
                                                <video controls="" id="video" preload="metadata" poster="<?php echo $_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_vCloudinary'];?>
">
                                                    <source src="<?php echo $_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_vCloudinary'];?>
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
                                                    <a data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']);?>
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
                                    <?php } else { ?>
                                        <?php if ($_smarty_tpl->tpl_vars['row']->value['post_type'] != 'Share') {?>
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['media']->value['upload_file_org'];?>
" >
                                        <?php } else { ?>
                                            <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['media']->value['pm_user_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['media']->value['pm_upload_file_org'];?>
">
                                        <?php }?>
                                    <?php }?>
                                </div>
                            <?php
$_smarty_tpl->tpl_vars['media'] = $__foreach_media_1_saved_local_item;
}
}
if ($__foreach_media_1_saved_item) {
$_smarty_tpl->tpl_vars['media'] = $__foreach_media_1_saved_item;
}
?>
                        </div>

                        <!-- Add Pagination if needed -->
                        <div class="swiper-pagination"></div>

                        <!-- Add Navigation Arrows if needed -->
                        <!--<div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>-->
                    </div>
                </div>
            </div>

            
            <?php if ($_smarty_tpl->tpl_vars['isajax']->value == 'Yes') {?>
                <?php $_smarty_tpl->tpl_vars["is_like"] = new Smarty_Variable($_smarty_tpl->tpl_vars['islike']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "is_like", 0);?>
                <?php $_smarty_tpl->tpl_vars["likes_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['likescount']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "likes_count", 0);?>
                <?php $_smarty_tpl->tpl_vars["comment_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['commentcount']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "comment_count", 0);?>
                <?php $_smarty_tpl->tpl_vars["feed_action_postid"] = new Smarty_Variable($_smarty_tpl->tpl_vars['postid']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "feed_action_postid", 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["is_like"] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['is_like'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "is_like", 0);?>
                <?php $_smarty_tpl->tpl_vars["likes_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['likes_count'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "likes_count", 0);?>
                <?php $_smarty_tpl->tpl_vars["comment_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['comments_count'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "comment_count", 0);?>
                <?php $_smarty_tpl->tpl_vars["feed_action_postid"] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['post_id'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "feed_action_postid", 0);?>
            <?php }?>
            <?php $_smarty_tpl->tpl_vars["mediaid"] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['get_post_media'][0]['pm_post_media_id'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "mediaid", 0);?>

            <div class="video-share-box-wrapper">
                <div class="video-share-box">
                    <ul>
                        <!--<a id="like_<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" href="javascript:void(0)" data-postid="<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" class="<?php if ($_smarty_tpl->tpl_vars['is_like']->value == 1) {?>active <?php }?>like-post likepost_switch">
                            <i class="<?php if ($_smarty_tpl->tpl_vars['is_like']->value == 1) {?>fas<?php } else { ?>far<?php }?> fa-heart" style="color: red"></i>
                        </a>-->
                        <li>
                            <a href="javascript:void(0)" onclick="movement_post_like(<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
)">
                                <i id="heart-icon-<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" class="<?php if ($_smarty_tpl->tpl_vars['row']->value['is_post_like'] == 0) {?>far<?php } else { ?>fas<?php }?> fa-heart" style="color: red"></i>
                            </a>
                        </li>
                    <li class="video-comment">
                        <a href="javascript:void(0)" onclick="openComments(<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
)">
                            <i class="fa-regular fa-comment-dots"></i>
                            <p><?php echo count($_smarty_tpl->tpl_vars['row']->value['comment_details']);?>
</p>
                        </a>
                    </li>
                    <li class="video-comment">
                        <a href="javascript:void(0)" onclick="openModalWithPostId(<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
)">
                            <i class="fa-solid fa-share"></i>
                            <p></p>
                        </a>
                    </li>
                    <li>
                        <div class="video-info-box">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['post_id'],$_smarty_tpl->tpl_vars['row']->value['pm.post_text']);?>
"><i class="fa-solid fa-info"></i></a>
                        </div>
                    </li>
                    </ul>
                </div>

                <div class="video-photo">
                    <!-- <a href="#">
                    <i class="fa-regular fa-images"></i>
                    </a> -->
                </div>  
            </div>
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/movement_post_comment.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

        </div>

        <div class="modal fade create-post" id="editPost_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPostLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostLabel"><?php echo $_smarty_tpl->tpl_vars['edit_post']->value;?>
</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/edit_post');?>
">
                        <div class="modal-body">
                            <div class="create-post-comment">
                                <div class="textarea-img">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_profile_image'];?>
" alt="Profile Image">
                                </div>
                                <p class="lead emoji-picker-container w-100 emoji_postinfo">
                                    <textarea name="movement_post_text" id="movement_post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true" style="border: none;"><?php echo $_smarty_tpl->tpl_vars['row']->value['post_text'];?>
</textarea>
                                </p>
                            </div>
                            <div class="video-upload">
                                <input type="file" style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp">
                                <label for="upload_file" class="photo-btn" id="triggerFileUpload">
                                    <i class="fa-solid fa-camera"></i> <?php echo $_smarty_tpl->tpl_vars['photo']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['video']->value;?>

                                </label>

                                <?php if ($_smarty_tpl->tpl_vars['row']->value['post_type'] != 'Share') {?>
                                    <div id="preview" class="preview-container" style="display: flex;">
                                        <?php
$_from = $_smarty_tpl->tpl_vars['row']->value['get_post_media'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_media_2_saved_item = isset($_smarty_tpl->tpl_vars['media']) ? $_smarty_tpl->tpl_vars['media'] : false;
$_smarty_tpl->tpl_vars['media'] = new Smarty_Variable();
$__foreach_media_2_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_media_2_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['media']->value) {
$__foreach_media_2_saved_local_item = $_smarty_tpl->tpl_vars['media'];
?>
                                            <div class="media-item" style="max-width: 20%; min-width: 20%; margin: 8px;">
                                                <?php if ($_smarty_tpl->tpl_vars['media']->value['pm_media_type'] == "Image") {?>
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['media']->value['upload_file_org'];?>
" alt="Media Image" class="img-fluid" style="max-width: 100%; border-radius: 10px; object-fit: cover; min-height: 100px; max-height: 100px;"/>
                                                    <a href="" class="remove-media" data-file="<?php echo $_smarty_tpl->tpl_vars['media']->value['pm_post_media_id'];?>
" style="position: relative; bottom: 6rem; left: 6.5rem;"><i class="fa fa-trash-o" style="color: red;" ></i></a>

                                                <?php } else { ?>
                                                    <video controls="" id="video" preload="metadata" poster="<?php echo $_smarty_tpl->tpl_vars['media']->value['pm_video_thumbnail'];?>
" style="max-width: 100%; min-height: 100px; max-height: 100px; border-radius: 10px; object-fit: cover; ">
                                                        <source src="<?php echo $_smarty_tpl->tpl_vars['media']->value['upload_file_org'];?>
" type="video/mp4">
                                                    </video>
                                                    <div class="video-btn-overlay">
                                                        <button class="refresh-btn">
                                                            <div style="margin-right: 100px;" class="btn_options">
                                                                <a data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']);?>
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
                                                    <a href="" class="remove-media" data-file="<?php echo $_smarty_tpl->tpl_vars['media']->value['pm_post_media_id'];?>
" style="position: relative; bottom: 6rem; left: 6.5rem;"><i class="fa fa-trash-o" style="color: red;" ></i></a>
                                                <?php }?>
                                            </div>
                                        <?php
$_smarty_tpl->tpl_vars['media'] = $__foreach_media_2_saved_local_item;
}
}
if ($__foreach_media_2_saved_item) {
$_smarty_tpl->tpl_vars['media'] = $__foreach_media_2_saved_item;
}
?>
                                    </div>
                                <?php }?>
                            </div>

                            <div class="create-share-type">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visibility" id="visibility1" value="Movement" checked>
                                    <label class="form-check-label" for="visibility1"> <?php echo $_smarty_tpl->tpl_vars['movement']->value;?>
 </label>
                                </div>
                            </div>

                            <input type="hidden" name="movement_id" value="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
">
                            <input type="hidden" name="post_id" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
">
                            <input type="hidden" name="post_type" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_type'];?>
">

                            <div class="create-post-btn-box" style="padding-top:20px !important; padding-bottom: 0px !important;">
                                <button type="submit" class="post-btn" style="margin-left: 17%;"><?php echo $_smarty_tpl->tpl_vars['update']->value;?>
</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    
    <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
} else { ?>
    <div class="main pt-3">
        <div class="video-dash-post mb-20">
        <p><?php echo $_smarty_tpl->tpl_vars['post_not_found']->value;?>
</p>
        </div>
    </div>
<?php }?>

<?php echo '<script'; ?>
>
document.addEventListener("DOMContentLoaded", function() {
    // Select both class and id-based videos
    var videos = document.querySelectorAll("#video");
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
><?php }
}

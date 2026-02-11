<?php
/* Smarty version 3.1.28, created on 2024-06-14 01:34:59
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/hide_list.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_666c00b31b83c1_04221153',
  'file_dependency' => 
  array (
    '06d16caf7b3910e586fb3c5e836a3126c4f94370' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/hide_list.tpl',
      1 => 1718354095,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/feed_actions.tpl' => 2,
    'file:common/comments.tpl' => 1,
  ),
),false)) {
function content_666c00b31b83c1_04221153 ($_smarty_tpl) {
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['posts']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Share') {?>
    <div class="video-dash-post mb-20">
        <div class="video-dash-post-heading">
            <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                </div>
                <div class="video-post-content">
                <h5><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
"><?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
</a></h5>
                <p>12 hrs ago</p>
                </div>
            </div>
            <div class="video-post-icon feed-time" title="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'];?>
">
                <i class="fa-solid fa-ellipsis-vertical"></i>
                
                <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getLocalDateTime($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'],"F j, Y- g:i A");?>

            </div>
        </div>
        <div class="video-post-icon">
            <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <?php if ($_smarty_tpl->tpl_vars['posts_pgtype']->value == 'my_profile') {?>
                    <a class="dropdown-item edit_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://">Edit</a>
                    <a class="dropdown-item delete_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://">Delete</a>
                <?php } else { ?>
                    <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_id'];?>
" href="javascript://">Spam</a>
                    <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_id'];?>
" href="javascript://">Inappropriate ?</a>
                    <a class="dropdown-item block_user" data-userid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'];?>
" href="javascript://">Block</a>
                <?php }?>
            </div>
        </div>
        <div class="video-post-content">
            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['link'] != '') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
">
                    <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
</p>
                </a>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['title'] != '') {?>
                    <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
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
                    <p ><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_text']);?>
</p>
                </a>
            <?php }?>
        </div>

        
        <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_type'] == 'Live') {?>
            <div class="video-post-vid">
            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_post_type'] == 'Live') {?>
                <?php $_smarty_tpl->tpl_vars['post_media'] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post_media'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'post_media', 0);?>
                <div class="video-wrapper">
                    <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Video') {?>
                        <p class="view"><i class="fa-regular fa-eye"></i> <?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['impression_count'];?>
</p>
                    <?php }?>
                    <?php
$__section_j_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_j']) ? $_smarty_tpl->tpl_vars['__section_j'] : false;
$__section_j_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['post_media']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_j_1_total = $__section_j_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_j'] = new Smarty_Variable(array());
if ($__section_j_1_total != 0) {
for ($__section_j_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] = 0; $__section_j_1_iteration <= $__section_j_1_total; $__section_j_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']++){
?>
                        <div class="video-container-2" id="video-container">
                            <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Image') {?>   
                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file_org'];?>
" alt=""></a>
                            <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Video') {?>
                                <video id="plyr-video" preload="metadata" class="playerembed" width="100%" height="100%" controls data-poster="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['video_thumbnail_org'];?>
">
                                    <source src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_upload_file'];?>
" type="video/mp4">
                                </video>
                            <?php }?>
                            <div class="play-button-wrapper">
                                <div title="Play video" class="play-gif" id="circle-play-b">
                                <!-- SVG Play Button -->
                                </div>
                            </div>
                        </div>
                    <?php
}
}
if ($__section_j_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_j'] = $__section_j_1_saved;
}
?>
                </div>
            <?php }?>
            </div>
            <div class="video-share-box-wrapper">
                <div class="video-share-box">
                    <ul>
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/feed_actions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                    </ul>
                </div>
                <div class="video-photo">
                    <a href="#">
                        <i class="fa-regular fa-images"></i>
                    </a>
                    
                    <div class="my-progress-bar impression <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['is_impressed'] == 1) {?>active<?php }?>">
                        <p><?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['impression_count'];?>
</p>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['visibility'] == 'Viral') {?>
                        <div class="my-progress-bar" data-value="<?php echo time_left($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_added_date'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['expire_date']);?>
" data-thickness="4">
                            <p><span><?php echo hours_left($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['p_added_date'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_actual_post']['expire_date']);?>
</span></p>
                        </div>
                    <?php }?>
                </div>
            </div>
        <?php }?>


        <div class="comment">
            <div class="comment-pic">
                <img src="images/comment.png" alt="">
            </div>
            <div class="comment-text comment-text-new">
                <form>
                    <div class="form-group">
                    <input type="email" class="form-control" id="comment-box8" aria-describedby="emailHelp" placeholder="Add a Comment">
                    </div>
                    <button type="submit" class="btn btn-primary form-btn"><img src="images/plane.png"></button>
                </form>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="video-dash-post mb-20">
        <div class="video-dash-post-heading">
            <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
                </div>
                <div class="video-post-content">
                <h5><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
"><?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
</a><?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Live') {?> <span>was Live.</span><?php }?></h5>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'LiveNow') {?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayliveposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id']);?>
"><button type="button" class="btn feed-live-screen-btn">
                            <i class="fas fa-video"></i> Live
                        </button></a>
                <?php }?>
                <p class="feed-time" title="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'];?>
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
" href="javascript://">Edit</a>
                        <a class="dropdown-item delete_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://">Delete</a>
                    <?php } else { ?>
                        <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://">Spam</a>
                        <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://">Inappropriate ?</a>
                        <a class="dropdown-item block_user" data-userid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['posted_user_id'];?>
" href="javascript://">Block</a>
                        <a class="dropdown-item show_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" href="javascript://">Unhide Post</a>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="video-post-content">
            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['link'] != '') {?>
                <p><?php echo nl2br($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['text']);?>
</p>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['title'] != '') {?>
                    <p><?php echo nl2br($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['title']);?>
</p>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['image'] != '') {?>
                    <a target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['text']);?>
"><img style="width:100%;" src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_metadata']['image'];?>
"/></a>
                    <?php }?> 
                <?php } else { ?>
                <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'LiveNow') {?>
                    <a class="livenow-video-thumbnail" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayliveposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id']);?>
">
                        <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
</p>
                        <?php $_smarty_tpl->tpl_vars["live_thumb_path"] = new Smarty_Variable(((($_smarty_tpl->tpl_vars['this']->value->config->item('live_thumb_path')).("screenshot_")).($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'])).(".jpeg"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "live_thumb_path", 0);?>
                        <?php $_smarty_tpl->tpl_vars["live_thumb_url"] = new Smarty_Variable(((($_smarty_tpl->tpl_vars['this']->value->config->item('live_thumb_url')).("screenshot_")).($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'])).(".jpeg"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "live_thumb_url", 0);?>
                        <?php if (file_exists($_smarty_tpl->tpl_vars['live_thumb_path']->value)) {?>
                            <span title="Join"></span>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['live_thumb_url']->value;?>
" alt="" style="width:100%">
                        <?php }?>
                    </a>
                <?php } else { ?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
">
                        <p class="displayemoji_comment"><?php echo removeEmoji($_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']));?>
</p>
                    </a>
                <?php }?>
            <?php }?>
        </div>
        <div class="video-post-vid">
            <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Live') {?>
                <div class="video-wrapper">
                <p class="view"><i class="fa-regular fa-eye"></i> 12</p>
                    <?php if ($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Media' || $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_type'] == 'Live') {?>
                        <?php $_smarty_tpl->tpl_vars['post_media'] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_post_media'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'post_media', 0);?>
                        
                        <?php
$__section_j_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_j']) ? $_smarty_tpl->tpl_vars['__section_j'] : false;
$__section_j_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['post_media']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_j_2_total = $__section_j_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_j'] = new Smarty_Variable(array());
if ($__section_j_2_total != 0) {
for ($__section_j_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] = 0; $__section_j_2_iteration <= $__section_j_2_total; $__section_j_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']++){
?>
                            <div class="video-container-2" id="video-container">
                                <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Image') {?>
                                    <?php if ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file_org'] != '') {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text_emoji']);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file_org'];?>
" alt=""></a>
                                    <?php } else { ?>
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['display_image'];?>
" alt="">
                                    <?php }?>
                                <?php } elseif ($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_media_type'] == 'Video') {?>
                                    
                                    <video controls data-poster="<?php echo $_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['video_thumbnail_org'];?>
" id="plyr-video" preload="metadata" class="playerembed" width="100%" height="100%" >
                                        <?php $_smarty_tpl->tpl_vars["video_url"] = new Smarty_Variable($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['pm_upload_file'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_url", 0);?>
                                        <?php if ($_smarty_tpl->tpl_vars['is_detail']->value == "Yes") {?>
                                            <?php $_smarty_tpl->tpl_vars["video_url"] = new Smarty_Variable($_smarty_tpl->tpl_vars['post_media']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['upload_file'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "video_url", 0);?>
                                        <?php }?>
                                        <source src="<?php echo $_smarty_tpl->tpl_vars['video_url']->value;?>
" type="video/mp4">
                                    </video>
                                <?php }?>
                                <div class="play-button-wrapper">
                                    <div title="Play video" class="play-gif" id="circle-play-b">
                                    <!-- SVG Play Button -->
                                    </div>
                                </div>
                            </div>
                        <?php
}
}
if ($__section_j_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_j'] = $__section_j_2_saved;
}
?>
                        
                    <?php }?>
                </div>
            <?php }?>
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
                <div class="my-progress-bar">
                    <p>48</p>
                </div>
            </div>
        </div>
        <div class="comment">
            <div class="comment-pic">
                <img src="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
            </div>
            <div class="post-add-comment add-comments">                    
                <div class="comment-text comment-text-new"style="padding-top: 11px !important;">
                    <form style="display: flex; height: 53px">
                        <div class="form-group">
                        <textarea class="form-control comment_post_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" id="comment-box8" aria-describedby="emailHelp" data-postid="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" rows="1" placeholder="Add Comment" data-emojiable="true" style="color:gray"></textarea>
                        </div>
                        <div class="upload_media_div" id="media_div_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="display: none;">
                            <input type="file" name="upload_file" id="input_media_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                        </div>
                        <div class="comment-pic" style="background: none">
                            <span style="cursor: pointer" class="btn_post_media_attach">
                                <i class="fa fa-paperclip btn_postmedia" data-postid="142251" style="font-size: 16px !important"></i>
                            </span>
                            <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">GIF</span>
                            <span style="cursor:pointer; " class="open_sticker_section" data-sticker-post-id="<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                                <img  src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/sticker.png" alt="">
                            </span>
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
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
                <div class="gif_picker_div_cls" id="gifPicker_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
">
                    <img src="https://media1.giphy.com/media/9ywJxa5PASF6HBUSh7/giphy-downsized-medium.gif?cid=ca8ff4c416a6m7a5omqz1thbb97qwfygjzj2z51qo93v43oa&ep=v1_stickers_search&rid=giphy-downsized-medium.gif&ct=s" alt="">
                </div>    
            </div>
        </div>
    </div>
<?php }
}} else {
 ?>
<p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;">No posts available</p>
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
</div><?php }
}

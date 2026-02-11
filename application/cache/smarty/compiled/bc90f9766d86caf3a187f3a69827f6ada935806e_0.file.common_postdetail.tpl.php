<?php
/* Smarty version 3.1.28, created on 2024-04-10 17:35:51
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_postdetail.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_6616809f5b0711_04503908',
  'file_dependency' => 
  array (
    'bc90f9766d86caf3a187f3a69827f6ada935806e' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_postdetail.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/common_postcomment.tpl' => 1,
  ),
),false)) {
function content_6616809f5b0711_04503908 ($_smarty_tpl) {
?>
<div class="post-details-block">
    <div class="post-title-details">
        <div class="post-name">
            <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['postinfo']->value['post_text_emoji']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
            <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
            <h2><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>
</h2>
            <div class="view-time">
                <?php echo $_smarty_tpl->tpl_vars['viewcount']->value;?>
 views <span>•</span> <?php echo $_smarty_tpl->tpl_vars['postinfo']->value['impression_count'];?>
 impressions <span>•</span> <?php echo time_elapsed_string($_smarty_tpl->tpl_vars['postinfo']->value['added_date']);?>

            </div>
        </div>
        
        <div class="post-action">
            <ul>
                <li>
                    <a id="like_<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" href="javascript:void(0)" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
" class="<?php if ($_smarty_tpl->tpl_vars['islike']->value == 1) {?>active <?php }?>like-post act_likepost"><i class="fas fa-thumbs-up"></i></a>
                </li>
                <li style="margin-left:2px;">
                    <a href="javascript:" class="disp_postlikes" data-pageindex="" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
"  id="displike_<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
"><span data-likescount="<?php echo $_smarty_tpl->tpl_vars['likescount']->value;?>
" id="likes_count_<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['likescount']->value;?>
</span><span id="displiketext_<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
"><?php if ($_smarty_tpl->tpl_vars['likescount']->value == 1) {?>&nbsp;Like<?php } else { ?>&nbsp;Likes<?php }?></span></a>
                </li>
                <li>
                    <a href="<?php ob_start();
echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];
$_tmp1=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['postinfo']->value['post_text_emoji'];
$_tmp2=ob_get_clean();
echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_tmp1,$_tmp2);?>
#gotocomment"><i class="fas fa-comment-dots"></i><span id="calc_comment_count"><?php echo $_smarty_tpl->tpl_vars['commentcount']->value;?>
</span>&nbsp;Comment</a>
                </li>
                <li>
                    <a id="share_<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" href="javascript:void(0)" data-userid="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId');?>
" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" class="share_postdetail"><i class="fas fa-share-alt"></i> Share</a>
                </li>
                <li>
                    <div class="dropdown">
                        <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <!--<a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>-->
                            <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') != $_smarty_tpl->tpl_vars['postinfo']->value['posted_user_id']) {?>
                            <a class="dropdown-item report_postdetail" data-report_type="Spam" data-userid="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId');?>
"  data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" href="javascript://">Spam</a>
                            <a class="dropdown-item report_postdetail" data-report_type="InAppropriate" data-userid="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId');?>
"  data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" href="javascript://">Inappropriate ?</a>
                            <a class="dropdown-item block_user" data-userid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['posted_user_id'];?>
" href="javascript://">Block</a>
                            <?php } else { ?>
                            <a class="dropdown-item edit_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" href="javascript://">Edit</a>
                            <a class="dropdown-item delete_post" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" href="javascript://">Delete</a>
                            <?php }?>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="post-content" id="gotocomment">
        <i class="cmn-user-img">
            <img src="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['user_profile_image'];?>
" alt="">
        </i>
        <div class="post-text" <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') != $_smarty_tpl->tpl_vars['postinfo']->value['posted_user_id']) {?> style="width:80%;" <?php }?>>
            <h4><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['postinfo']->value['posted_user_id'],$_smarty_tpl->tpl_vars['postinfo']->value['user_name']);?>
"><?php echo $_smarty_tpl->tpl_vars['postinfo']->value['user_name'];?>
</h4></a>
            <span class="post-location" style="display:none;">
                <i class="fas fa-map-marker-alt"></i> Florida
            </span>
            <?php $_smarty_tpl->tpl_vars['posttext_without_emoji'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['postinfo']->value['post_text_emoji']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posttext_without_emoji', 0);?>
            <div id="displayedittext"><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext(removeEmoji($_smarty_tpl->tpl_vars['posttext_without_emoji']->value));?>
<!--<a href="javascript:" class="more-link">More.</a>--></div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') != $_smarty_tpl->tpl_vars['postinfo']->value['posted_user_id']) {?>
        <div class="follow-button" style="padding-left:15px">
            <?php if ($_smarty_tpl->tpl_vars['followerinfo']->value['pending_request_id'] != '' && $_smarty_tpl->tpl_vars['followerinfo']->value['is_follwing'] == 'Pending') {?>
                <a href="javascript:" class="btn btn-secondary act_cancelfollowrequest" data-id="<?php echo $_smarty_tpl->tpl_vars['followerinfo']->value['u_users_id'];?>
" data-pendingrequestid="<?php echo $_smarty_tpl->tpl_vars['followerinfo']->value['pending_request_id'];?>
">Cancel</a>
            <?php } elseif ($_smarty_tpl->tpl_vars['followerinfo']->value['is_follwing'] == 'Yes') {?>
                <a href="javascript:" class="btn btn-secondary act_unfollowuser" data-id="<?php echo $_smarty_tpl->tpl_vars['followerinfo']->value['u_users_id'];?>
" >Unfollow</a>
            <?php } else { ?>
                <a href="javascript:" class="btn btn-primary act_followuser"  data-id="<?php echo $_smarty_tpl->tpl_vars['followerinfo']->value['u_users_id'];?>
">Follow</a>
            <?php }?>
            <div id="followactionmsg_<?php echo $_smarty_tpl->tpl_vars['followerinfo']->value['u_users_id'];?>
"></div>
        </div>
        <?php }?>
    </div>
    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') != '') {?>
    <div class="post-add-comment" >
        <i class="fas fa-paper-plane act_postcomment" style="cursor:pointer;" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" title="Add Comment"></i>
        <!--<textarea name="commentadd" id="commentadd" class="form-control actkeypress_postcomment" rows="1" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" placeholder="Add comment"></textarea>-->

        <p class="lead emoji-picker-container w-100">
            <textarea name="commentadd" id="commentadd" class="form-control actkeypress_postcomment" rows="1" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" placeholder="Add comment" data-emojiable="true"></textarea>
        </p>
        <!--<div data-emojiarea data-type="unicode" data-global-picker="false" class="w-100">
            <div class="emoji-button" style="right:4px;padding-top:3px;"><i class="fa fa-smile-o" style="font-size:20px;"></i></div>
            <textarea name="commentadd" id="commentadd" class="form-control actkeypress_postcomment emojipadding" rows="1" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
" data-postid="<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
" placeholder="Add comment"></textarea>
        </div> -->
    </div>
    <?php }?>
</div>
<span id="errorcomment_disp" style="padding-top:10px;"></span>
<div class="<?php if (count($_smarty_tpl->tpl_vars['postcomment']->value) > 0) {?>cmn-white-block<?php }?> post-comments" >
    <div class="feed-comments">
        <ul id="comments_list_<?php echo $_smarty_tpl->tpl_vars['postinfo']->value['post_id'];?>
">
            <?php if (count($_smarty_tpl->tpl_vars['postcomment']->value) > 0) {?>
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/common_postcomment.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

           <?php }?>
        </ul>
    </div>
</div><?php }
}

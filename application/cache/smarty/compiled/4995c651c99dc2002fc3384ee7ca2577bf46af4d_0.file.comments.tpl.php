<?php
/* Smarty version 3.1.28, created on 2024-01-31 13:00:15
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/comments.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9f70798fc36_68204309',
  'file_dependency' => 
  array (
    '4995c651c99dc2002fc3384ee7ca2577bf46af4d' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/comments.tpl',
      1 => 1706091453,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/common_feed_replies.tpl' => 1,
  ),
),false)) {
function content_65b9f70798fc36_68204309 ($_smarty_tpl) {
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['comments']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
    <li>
        <div class="user-comments-row" id="showloader_<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
">
            <div class="comments-block">
                <div class="comments-user-row">
                    <div class="comments-user-details">
                        <i class="cmn-user-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['profile_image'];?>
" alt="">
                        </i>
                        <h6>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_id'],$_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
" class="name"><?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
</a>
                        </h6>
                    </div> 
                    <div class="comments-time" title="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date'];?>
">
                        <?php echo time_elapsed_string($_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date']);?>

                    </div>
                </div>
                <div class="user-comments">
                    
                    <?php $_smarty_tpl->tpl_vars['comment_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['comment']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'comment_text', 0);?>
                    <?php $_smarty_tpl->tpl_vars['comment_text_format'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['comment_text']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'comment_text_format', 0);?>
                    <p class="displayemoji_comment" style="display:none;"><?php echo nl2br($_smarty_tpl->tpl_vars['comment_text_format']->value);?>
</p>
                    <div class="like-reply-row">
                        <?php if ($_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['count_comment_likes'] == '') {?>
                            <?php $_smarty_tpl->tpl_vars['showpostlike'] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'showpostlike', 0);?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->tpl_vars['showpostlike'] = new Smarty_Variable($_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['count_comment_likes'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'showpostlike', 0);?>
                        <?php }?>
                        <div>
                            <a id="postlike_<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" href="javascript:void(0)" data-postid="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['is_comment_like'] == 1) {?>active <?php } else { ?>grey-link <?php }?> like-post act_likepostcomment" style="margin-right:7px;"><i class="fas fa-thumbs-up"></i></a> 
                            <a href="javascript:" class="disp_postcommentlikes" data-pageindex="" data-postid="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" ><span data-commentlikescount="<?php echo $_smarty_tpl->tpl_vars['showpostlike']->value;?>
" id="commentlikes_count_<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['showpostlike']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['showpostlike']->value == 1) {?> Like<?php } else { ?> Likes<?php }?></span></a>
                        </div>
                        <div class="all-comment">  
                            <?php $_smarty_tpl->tpl_vars['showpostreplyarr'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->get_replylist_comment($_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'],$_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'showpostreplyarr', 0);?>
                            <a href="javascript:" class="grey-link show_replies" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
">
                                <i class="fas fa-comment-dots"></i> <span id="disp_replycount_<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
"><?php echo count($_smarty_tpl->tpl_vars['showpostreplyarr']->value);?>
 <?php if (count($_smarty_tpl->tpl_vars['showpostreplyarr']->value) == 1) {?>Reply<?php } else { ?>Replies<?php }?></span>
                            </a>
                        </div>
                        <div class="reply-comments">
                            <a href="javascript:void(0);" class="postreply-link">Reply</a>
                        </div>
                        <div class="reply-comment-box" style="display:none;">
                            <textarea class="form-control reply_postcomment" rows="1" placeholder="Reply Comment" data-postid="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" name="replycommentad" id="replycommentad_<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
"></textarea>
                        </div>
                        <div class="feed-comments  scrollbarContent scrolldefineheight feed_replies_<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" style="width:97%;display: none;">
                            <ul id="replycommentshow_<?php echo $_smarty_tpl->tpl_vars['comments']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
">
                                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/common_feed_replies.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
<?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
}
}

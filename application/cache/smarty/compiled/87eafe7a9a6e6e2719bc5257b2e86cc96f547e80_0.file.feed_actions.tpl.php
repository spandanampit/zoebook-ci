<?php
/* Smarty version 3.1.28, created on 2024-01-31 13:00:15
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/feed_actions.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9f70796e905_58237214',
  'file_dependency' => 
  array (
    '87eafe7a9a6e6e2719bc5257b2e86cc96f547e80' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/feed_actions.tpl',
      1 => 1706091455,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9f70796e905_58237214 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['isajax']->value == 'Yes') {?>
    <?php $_smarty_tpl->tpl_vars["is_like"] = new Smarty_Variable($_smarty_tpl->tpl_vars['islike']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "is_like", 0);?>
    <?php $_smarty_tpl->tpl_vars["likes_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['likescount']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "likes_count", 0);?>
    <?php $_smarty_tpl->tpl_vars["comment_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['commentcount']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "comment_count", 0);?>
    <?php $_smarty_tpl->tpl_vars["feed_action_postid"] = new Smarty_Variable($_smarty_tpl->tpl_vars['postid']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "feed_action_postid", 0);
} else { ?>
    <?php $_smarty_tpl->tpl_vars["is_like"] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['statistics']['is_like'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "is_like", 0);?>
    <?php $_smarty_tpl->tpl_vars["likes_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['statistics']['likes_count'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "likes_count", 0);?>
    <?php $_smarty_tpl->tpl_vars["comment_count"] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['statistics']['comments_count'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "comment_count", 0);?>
    <?php $_smarty_tpl->tpl_vars["feed_action_postid"] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "feed_action_postid", 0);
}
$_smarty_tpl->tpl_vars["mediaid"] = new Smarty_Variable($_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['get_post_media'][0]['pm_post_media_id'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "mediaid", 0);?>
<div class="like-action">
    <a id="like_<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" href="javascript:void(0)" data-postid="<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" class="<?php if ($_smarty_tpl->tpl_vars['is_like']->value == 1) {?>active <?php }?>like-post likepost_switch">
        <i class="<?php if ($_smarty_tpl->tpl_vars['is_like']->value == 1) {?>fas<?php } else { ?>far<?php }?> fa-heart"></i>
    </a>
    <a href="javascript:" class="disp_postlikes" data-pageindex="" data-postid="<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
"  id="displike_<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
">
        <span data-likescount="<?php echo $_smarty_tpl->tpl_vars['likes_count']->value;?>
" id="likes_count_<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['likes_count']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['likes_count']->value == 1) {?>Like<?php } else { ?>Likes<?php }?></span>
    </a>
</div>
<div class="comments-action">
    <a href="javascript://" class="show_feed_comments" data-feedpostid="<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
"><i class="fas fa-comment-dots"></i> <span id="disp_comcount_<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['comment_count']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['comment_count']->value == 1) {?>Comment<?php } else { ?>Comments<?php }?></span></a>
</div>
<div class="share-action">
    <a id="share_<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" href="javascript:void(0)" data-postid="<?php echo $_smarty_tpl->tpl_vars['feed_action_postid']->value;?>
" class="share_post"><i class="fas fa-share-alt"></i> Share</a>
</div><?php }
}

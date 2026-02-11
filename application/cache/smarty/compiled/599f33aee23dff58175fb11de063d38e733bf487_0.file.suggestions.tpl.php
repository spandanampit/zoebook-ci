<?php
/* Smarty version 3.1.28, created on 2024-01-31 13:00:15
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/suggestions.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9f7079d3ee6_14036448',
  'file_dependency' => 
  array (
    '599f33aee23dff58175fb11de063d38e733bf487' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/common/suggestions.tpl',
      1 => 1706091457,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9f7079d3ee6_14036448 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/modifier.truncate.php';
?>
<style>
    .u-impression-count{float: right;}
    .user-listing ul li + li  {margin-top: 0px;}
    .user-online-video {height:auto;}
</style>
<ul class="scrollbarContent">
    <?php $_smarty_tpl->tpl_vars["suggestions"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->get_user_suggestions(), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "suggestions", 0);?>
    <?php if (count($_smarty_tpl->tpl_vars['suggestions']->value) > 0) {?>
    <?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['suggestions']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
        <?php $_smarty_tpl->tpl_vars['suggest_text'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'suggest_text', 0);?>
    <li class="suggestion-post-detail" data-id="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" data-href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']);?>
">
        <div class="user-content-old">
            <i class="cmn-user-img">
                <img src="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
            </i>
            <div class="name-position">
                <span class="u-name"><?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
</span>
            </div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_media_type'] == 'Video') {?>
        <div class="user-online-video">
            <span ><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['suggest_text']->value,18,"...",true);?>
</span>
            <div style="position:relative">
                <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;">
                </div>
                <div>
                <video width="100%" height="100%" preload="metadata" class="othervideoduration" data-poster="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_video_image'];?>
" preload="metadata">
                  <source src="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_upload_file'];?>
" type="video/mp4">
                </video>
                </div>
            </div>
            <span class="u-impression-count"><?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_views_count'];?>
 views</span>
        </div>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_media_type'] == 'Image') {?>
        <div class="user-online-video">
            <span><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['suggest_text']->value,18,"...",true);?>
</span>
            <img src="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_display_image'];?>
" alt="" class="img-fluid">
            <span class="u-impression-count"><?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['impression_count'];?>
 views</span>
        </div>
        <?php }?>

    </li>
    <?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>
    <?php } else { ?>
    <li>
        <span>No Suggestions for you</span>
    </li>
    <?php }?>
</ul>
<?php }
}

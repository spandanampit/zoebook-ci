<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:53:13
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/post/views/posts_tabs.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c45731aad986_59274982',
  'file_dependency' => 
  array (
    '5f991b973179481aec4eeb58a76f27ab0e537371' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/post/views/posts_tabs.tpl',
      1 => 1706090517,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c45731aad986_59274982 ($_smarty_tpl) {
?>
<ul class="nav nav-tabs module-tab-container">
    <li <?php if ($_smarty_tpl->tpl_vars['module_name']->value == "posts") {?> class="active" <?php }?>>
        <a class="tab-item item-posts" 
        <?php if ($_smarty_tpl->tpl_vars['mode']->value == "Update") {?>
            title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_EDIT');?>
 <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POSTS');?>
"
        <?php } else { ?>
            title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_ADD');?>
 <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POSTS');?>
"
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['module_name']->value == "posts") {?> 
            href="javascript://"
        <?php } else { ?> 
            href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
#<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('post/posts/add');?>
|mode|<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value['Update'];?>
|id|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['parID']->value);?>
" 
        <?php }?>
        >
        <?php if ($_smarty_tpl->tpl_vars['mode']->value == "Add") {?>
            <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_ADD');?>
 <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POSTS');?>

        <?php } else { ?>
            <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_EDIT');?>
 <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POSTS');?>

        <?php }?>
    </a>
</li>
<li <?php if ($_smarty_tpl->tpl_vars['module_name']->value == "post_media") {?> class="active" <?php }?>>
    <a class="tab-item item-post_media"  title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POST_MEDIA');?>
 <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_LIST');?>
" 
        <?php if ($_smarty_tpl->tpl_vars['module_name']->value == "post_media") {?> 
            href="javascript://"
        <?php } elseif ($_smarty_tpl->tpl_vars['module_name']->value == "posts") {?> 
            <?php if ($_smarty_tpl->tpl_vars['mode']->value == "Update") {?>
                href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
#<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('post/post_media/index');?>
|parMod|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('posts');?>
|parID|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['data']->value['iPostId']);?>
"
            <?php } else { ?>
                href="javascript://" aria-disabled="true" 
            <?php }?>                    
        <?php } else { ?> 
            href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
#<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('post/post_media/index');?>
|parMod|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('posts');?>
|parID|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['parID']->value);?>
" 
        <?php }?>
        >
        <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POST_MEDIA');?>

    </a>
</li>
<li <?php if ($_smarty_tpl->tpl_vars['module_name']->value == "post_comments") {?> class="active" <?php }?>>
    <a class="tab-item item-post_comments"  title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POST_COMMENTS');?>
 <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_LIST');?>
" 
        <?php if ($_smarty_tpl->tpl_vars['module_name']->value == "post_comments") {?> 
            href="javascript://"
        <?php } elseif ($_smarty_tpl->tpl_vars['module_name']->value == "posts") {?> 
            <?php if ($_smarty_tpl->tpl_vars['mode']->value == "Update") {?>
                href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
#<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('post/post_comments/index');?>
|parMod|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('posts');?>
|parID|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['data']->value['iPostId']);?>
"
            <?php } else { ?>
                href="javascript://" aria-disabled="true" 
            <?php }?>                    
        <?php } else { ?> 
            href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
#<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('post/post_comments/index');?>
|parMod|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('posts');?>
|parID|<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['parID']->value);?>
" 
        <?php }?>
        >
        <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POST_COMMENTS');?>

    </a>
</li>
</ul>            <?php }
}

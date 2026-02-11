<?php
/* Smarty version 3.1.28, created on 2024-02-29 16:12:00
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/admin/post/views/posts_index_strip.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65e05f7876bac4_81560403',
  'file_dependency' => 
  array (
    '1103ef86a02cc245f03f2f5070c7367c023f5c59' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/admin/post/views/posts_index_strip.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65e05f7876bac4_81560403 ($_smarty_tpl) {
?>
<div class="headingfix">
    <!-- Top Header Block -->
    <div class="heading" id="top_heading_fix">
		<!-- Top Strip Title Block -->
        <h3>
            <div class="screen-title">
                <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_LISTING');?>
 :: <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POSTS_POSTS');?>

            </div>        
        </h3>
		<!-- Top Strip Dropdown Block -->
        <div class="header-right-drops">
            
            
        </div>
    </div>
</div>    <?php }
}

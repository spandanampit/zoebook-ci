<?php
/* Smarty version 3.1.28, created on 2024-01-31 10:21:21
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/content/views/staticpage.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9d1c9743215_17832663',
  'file_dependency' => 
  array (
    '277cf8a0b55d90ca4127aa674207ff59087184f2' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/content/views/staticpage.tpl',
      1 => 1706090577,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:static/".((string)$_smarty_tpl->tpl_vars[\'page_code\']->value).".tpl' => 1,
  ),
),false)) {
function content_65b9d1c9743215_17832663 ($_smarty_tpl) {
?>
<div class="page-heading">
    <h2><?php echo $_smarty_tpl->tpl_vars['page_title']->value;?>
</h2>
</div>
<div class="page-content-row">
    <div class="container">
        <?php if ($_smarty_tpl->tpl_vars['display_lang']->value == 'en') {?>
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:static/".((string)$_smarty_tpl->tpl_vars['page_code']->value).".tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

        <?php } else { ?>
            <?php echo $_smarty_tpl->tpl_vars['page_content']->value;?>

        <?php }?>
    </div>
</div><?php }
}

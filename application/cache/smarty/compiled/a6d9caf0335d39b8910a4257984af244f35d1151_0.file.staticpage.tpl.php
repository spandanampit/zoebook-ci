<?php
/* Smarty version 3.1.28, created on 2024-03-15 16:56:05
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/staticpage.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65f4304def31d8_15293192',
  'file_dependency' => 
  array (
    'a6d9caf0335d39b8910a4257984af244f35d1151' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/staticpage.tpl',
      1 => 1710501957,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:static/".((string)$_smarty_tpl->tpl_vars[\'page_code\']->value).".tpl' => 1,
  ),
),false)) {
function content_65f4304def31d8_15293192 ($_smarty_tpl) {
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

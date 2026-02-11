<?php
/* Smarty version 3.1.28, created on 2024-09-11 01:15:07
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_description_box.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_66e1518b1efa01_64793533',
  'file_dependency' => 
  array (
    'c3918b75430cd2d41703abd9024f9196ad514b5a' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_description_box.tpl',
      1 => 1726042504,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66e1518b1efa01_64793533 ($_smarty_tpl) {
?>
<div class="col-lg-4 col-md-12" >
    <div class="sugested-video-box no-fixed  mt-3 movement-details-right" style="height: unset; position: sticky;">
    <h2 class="mb-2">Description</h2>
    <?php $_smarty_tpl->tpl_vars['posted_description_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['movement']->value['get_movements']['description']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description_withouemoji', 0);?>
    <?php $_smarty_tpl->tpl_vars['posted_description'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_description_withouemoji']->value,500), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description', 0);?>
    <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_description']->value);?>
</p>
    </div>
</div><?php }
}

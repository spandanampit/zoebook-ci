<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:52:53
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/views/libraries/dropdown.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c4571d21b131_12545577',
  'file_dependency' => 
  array (
    'e5e511173460367715ce38ca95345c8856e1ce5b' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/views/libraries/dropdown.tpl',
      1 => 1706087751,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c4571d21b131_12545577 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/function.html_options.php';
if ($_smarty_tpl->tpl_vars['options_only']->value == 1) {?>
    <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['combo_array']->value,'selected'=>$_smarty_tpl->tpl_vars['combo_selected']->value),$_smarty_tpl);?>

<?php } else { ?>
    <select name="<?php echo $_smarty_tpl->tpl_vars['combo_name']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['combo_id']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['combo_extra']->value;?>
>
        <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['combo_array']->value,'selected'=>$_smarty_tpl->tpl_vars['combo_selected']->value),$_smarty_tpl);?>

    </select>
<?php }
}
}

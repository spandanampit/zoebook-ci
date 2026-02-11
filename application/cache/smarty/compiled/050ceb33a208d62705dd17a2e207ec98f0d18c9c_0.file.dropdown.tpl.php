<?php
/* Smarty version 3.1.28, created on 2024-02-29 16:12:01
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/views/libraries/dropdown.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65e05f79a32802_27782406',
  'file_dependency' => 
  array (
    '050ceb33a208d62705dd17a2e207ec98f0d18c9c' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/views/libraries/dropdown.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65e05f79a32802_27782406 ($_smarty_tpl) {
if (!is_callable('smarty_function_html_options')) require_once '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/third_party/Smarty/plugins/function.html_options.php';
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

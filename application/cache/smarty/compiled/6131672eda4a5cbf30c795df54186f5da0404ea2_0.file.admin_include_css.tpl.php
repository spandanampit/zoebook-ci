<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:52:41
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_include_css.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c457119f82a8_08769721',
  'file_dependency' => 
  array (
    '6131672eda4a5cbf30c795df54186f5da0404ea2' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_include_css.tpl',
      1 => 1706087703,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c457119f82a8_08769721 ($_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['pPage']->value == "true") {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("admin/style.css","admin/icons.css","admin/font-awesome.css","bootstrap/bootstrap.css","bootstrap/bootstrap-responsive.css","misc/jquery.ui.pattern.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("jqueryui/jquery-ui-1.9.2.custom.min.css","forms/validate.css","misc/jquery.qtip.css","rating-master/jquery.raty.css","bootstrap/main.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_DISPLAY'))."/theme.css","theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_DISPLAY'))."/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN')));?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_CUSTOMIZE')),"admin/cform_generate.css");?>

<?php } else { ?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("admin/style.css","admin/icons.css","admin/font-awesome.css","bootstrap/bootstrap.css","bootstrap/bootstrap-responsive.css","misc/jquery.ui.pattern.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("jqueryui/jquery-ui-1.9.2.custom.min.css","chosen/chosen.css","jqGrid/jquery.multiselect.css","jqGrid/jquery.multiselect.filter.css","jqGrid/ui.jqgrid.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("datepicker/jquery.ui.datepicker.css","datepicker/jquery-ui-timepicker-addon.css","datepicker/daterangepicker.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("codemirror/codemirror.css","forms/validate.css","forms/jquery.inputlimiter.css","misc/jquery.qtip.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("misc/jquery.pnotify.default.css","stuhover/stuhover.css","x-editable/bootstrap-editable.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("colorpicker/colpick.css","paginate/jquery.paginate.css","rating-master/jquery.raty.css","autocomplete_token/token-input.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("autocomplete_token/token-input-facebook.css","autocomplete_token/token-input-mac.css","autocomplete_token/token-input-simple.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("fancybox/jquery.fancybox.css","gridster/jquery.gridster.css","bootstrap/main.css");?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_DISPLAY'))."/theme.css","theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_DISPLAY'))."/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN')));?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_common_css("theme/".((string)$_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_CUSTOMIZE')),"admin/cform_generate.css");?>

<?php }
}
}

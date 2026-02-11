<?php
/* Smarty version 3.1.28, created on 2024-02-29 18:34:45
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/webservice/views/top/top.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65e080edaca578_00353110',
  'file_dependency' => 
  array (
    '90ed9b7da7646dc7a33a703e2e09dc54b67df830' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/webservice/views/top/top.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65e080edaca578_00353110 ($_smarty_tpl) {
?>
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url();?>
" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('COMPANY_NAME');?>
"><?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('COMPANY_NAME');?>
</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1"></div>
    </div>
</nav><?php }
}

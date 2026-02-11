<?php
/* Smarty version 3.1.28, created on 2024-02-29 18:34:45
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/webservice/views/template.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65e080edabe386_12017666',
  'file_dependency' => 
  array (
    '106c5ccf3c88ddc2aef4c1cdb710bdd32fad20ee' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/webservice/views/template.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:top/top.tpl' => 1,
    'file:bottom/footer.tpl' => 1,
  ),
),false)) {
function content_65e080edabe386_12017666 ($_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <base href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
" />
        <title><?php if ($_smarty_tpl->tpl_vars['meta_title']->value != '') {
echo $_smarty_tpl->tpl_vars['meta_title']->value;
} else {
echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_TITLE');
}?></title>
        <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCompanyFavIconURL();?>
" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="<?php if ($_smarty_tpl->tpl_vars['meta_description']->value != '') {
echo $_smarty_tpl->tpl_vars['meta_description']->value;
} else {
echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_DESCRIPTION');
}?>" />
        <meta name="keywords" content="<?php if ($_smarty_tpl->tpl_vars['meta_keyword']->value != '') {
echo $_smarty_tpl->tpl_vars['meta_keyword']->value;
} else {
echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_KEYWORD');
}?>" />
        <?php if ($_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_OTHER') != '') {?>
            <?php echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('META_OTHER');?>

        <?php }?>    
        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("bootstrap3/bootstrap.min.css","style.css");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

        <?php echo '<script'; ?>
 type='text/javascript'>
            var site_url = '<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item("site_url");?>
';
        <?php echo '</script'; ?>
>
    </head>
    <body class="<?php echo $_smarty_tpl->tpl_vars['page_html_class']->value;?>
">
        <div id="top-container">
            <!--top-part start here-->
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:top/top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <!--top-part End here-->
        </div>
        <div id="midd-container" class="container <?php echo $_smarty_tpl->tpl_vars['page_html_class']->value;?>
">
            <!-- middle part start here-->
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, $_smarty_tpl->tpl_vars['include_script_template']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

            <!-- middle part end here-->
        </div>
        <div id="bott-container">
            <!--bottom link start here-->
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:bottom/footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <!--bottom part End here-->
        </div>
        <?php if (trim($_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('GOOGLE_ANALYTICS')) != '') {?>
            <?php echo '<script'; ?>
 type="text/javascript">
                <?php echo $_smarty_tpl->tpl_vars['this']->value->systemsettings->getSettings('GOOGLE_ANALYTICS');?>

            <?php echo '</script'; ?>
>
        <?php }?>
        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src();?>

    </body>
</html><?php }
}

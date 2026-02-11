<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:52:41
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_template_js.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c457119e3892_90179230',
  'file_dependency' => 
  array (
    '0354077192b2c282a950e464b334867bdc882bfe' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_template_js.tpl',
      1 => 1706087704,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c457119e3892_90179230 ($_smarty_tpl) {
echo '<script'; ?>
 type='text/javascript'>
    var site_url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
", admin_url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('admin_url');?>
";
    var style_url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('css_url');?>
", admin_style_url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('admin_style_url');?>
";
    var admin_js_url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('admin_js_url');?>
", admin_image_url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('admin_images_url');?>
";
    var el_tpl_settings = {
        container_div: "content_slide",
        main_wrapper_id: "grid_wrapper",
        main_grid_id: "list2",
        main_pager_id: "pager2",
        page_iframe: "<?php if ($_smarty_tpl->tpl_vars['tplmode']->value == 'frame') {?>true<?php } else { ?>false<?php }?>",
        close_iframe: "<?php if ($_smarty_tpl->tpl_vars['tplmode']->value == 'frame') {
echo $_smarty_tpl->tpl_vars['this']->value->general->closedFancyFrame();
} else { ?>false<?php }?>",
        enc_usr_var: "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getMD5EncryptString('JavaScript');?>
",
        is_app_cache_active: "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAppCacheStatus();?>
",
        is_enc_active: "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->isAdminEncodeActive();?>
",
        dashboard_auto_time: parseInt("<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_DASHBOARD_AUTO_UPDATE');?>
"),
        list_refresh_interval: parseInt("<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_LIST_REFRESH_INTERVAL');?>
"),
        form_save_draft_interval: parseInt("<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_FORM_SAVE_DRAFT_INTERVAL');?>
"),
        admin_theme: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_DISPLAY');?>
",
        menu_poistion: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('NAVIGATION_BAR');?>
",
        google_maps_key: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('GOOGLE_MAPS_API_KEY');?>
",
        is_admin_theme_create: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_CREATE');?>
",
        is_desk_notify_active: "<?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_DESKTOP_NOTIFICATIONS') == 'Y') {?>1<?php } else {
}?>",
        page_animation: "<?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('ANIMATION_REQUIRED') == 'Y') {?>1<?php } else {
}?>",
        multi_lingual_trans: "<?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('MULTI_LINGUAL_TRANSLATION') == 'N') {
} else { ?>1<?php }?>",
        grid_multiple_sorting: "<?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('GRID_MULTIPLE_SORTING') == 'N') {
} else { ?>1<?php }?>",
        grid_search_prefers: "<?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('GRID_SEARCH_PREFERENCES') == 'N') {
} else { ?>1<?php }?>",
        grid_search_expires: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('GRID_SEARCH_EXPIRE_TIME');?>
",
        grid_saved_search_enable: "<?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('GRID_SAVE_SEARCH_ENABLE') == 'Y') {?>1<?php } else {
}?>",
        js_libraries_url: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('js_lib_url');?>
",
        editor_js_url: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('editor_js_url');?>
",
        editor_css_url: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('editor_css_url');?>
",
        grid_column_width: parseInt("<?php echo intval($_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_GRID_MIN_WIDTH'));?>
"),
        grid_rec_limit: parseInt("<?php echo intval($_smarty_tpl->tpl_vars['this']->value->config->item('REC_LIMIT'));?>
"),
        grid_top_menu: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('LISTING_TOP_MENU');?>
",
        grid_bot_menu: "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('LISTING_BOTTOM_MENU');?>
",
        noimage_url: "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getNoImageURL();?>
",
        framework_vars: '<?php echo json_encode($_smarty_tpl->tpl_vars['this']->value->config->item("FRAMEWORK_VARS"));?>
',
        admin_formats: '<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminTPLFormats();?>
'
    };
    el_tpl_settings.is_desk_notify_active = (el_tpl_settings.is_desk_notify_active == "1") ? 1 : 0;
    el_tpl_settings.page_animation = (el_tpl_settings.page_animation == "1") ? 1 : 0;
    el_tpl_settings.multi_lingual_trans = (el_tpl_settings.multi_lingual_trans == "1") ? 1 : 0;
    el_tpl_settings.grid_multiple_sorting = (el_tpl_settings.grid_multiple_sorting == "1") ? 1 : 0;
    el_tpl_settings.grid_search_prefers = (el_tpl_settings.grid_search_prefers == "1") ? 1 : 0;
    el_tpl_settings.grid_saved_search_enable = (el_tpl_settings.grid_saved_search_enable == "1") ? 1 : 0;
    el_tpl_settings.dashboard_auto_time = (el_tpl_settings.dashboard_auto_time) ? el_tpl_settings.dashboard_auto_time : 3 * 60 * 1000;
    el_tpl_settings.list_refresh_interval = (el_tpl_settings.list_refresh_interval) ? el_tpl_settings.list_refresh_interval : 2 * 60 * 1000;
    el_tpl_settings.form_save_draft_interval = (el_tpl_settings.form_save_draft_interval) ? el_tpl_settings.form_save_draft_interval : 1 * 60 * 1000;
    var el_theme_settings = '<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getClientThemeJSON();?>
';
    <?php if ($_smarty_tpl->tpl_vars['tplmode']->value == 'cache') {?>
    var cus_enc_url_json = '<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCustomEncryptURL();?>
';
    var cus_enc_mode_json = '<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCustomEncryptMode();?>
';
    <?php } else { ?>
    var js_lang_label = {};
    <?php }
echo '</script'; ?>
><?php }
}

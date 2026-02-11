<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:52:41
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_template.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c457119c6770_43102008',
  'file_dependency' => 
  array (
    '45adcc96e24d8575f5c6de71a311c9229beb6387' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/admin_template.tpl',
      1 => 1706087704,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_template_js.tpl' => 1,
    'file:admin_include_css.tpl' => 1,
    'file:admin_include_js.tpl' => 1,
    'file:top/top.tpl' => 1,
    'file:top/top_left.tpl' => 1,
    'file:bottom/bottom.tpl' => 1,
  ),
),false)) {
function content_65c457119c6770_43102008 ($_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php $_smarty_tpl->tpl_vars["app_cache_active"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->getAppCacheStatus(), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "app_cache_active", 0);?>
<html xmlns="http://www.w3.org/1999/xhtml" <?php if ($_smarty_tpl->tpl_vars['app_cache_active']->value == "Yes") {?> manifest="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');
echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_APPCACHE_FILE');?>
" <?php }?> > 
    <head>
        <meta charset="utf-8" />
        <base href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
" />
        <title><?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('CPANEL_TITLE');?>
</title>
        <link rel="shortcut icon" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCompanyFavIconURL();?>
" />
        <meta http-equiv="content-type" content="text/cache-manifest; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin_template_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tplmode'=>"main"), 0, false);
?>

        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin_include_css.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_common_src("common");?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getJSLanguageLables();?>

        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin_include_js.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_common_src("common");?>

        <?php echo '<script'; ?>
 type='text/javascript'>
            var cus_enc_url_json = $.parseJSON('<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCustomEncryptURL();?>
');
            var cus_enc_mode_json = $.parseJSON('<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getCustomEncryptMode();?>
');
        <?php echo '</script'; ?>
>
    </head>
    <body>
        <div id="script_overlay"></div>
        <div id="script_progress" class="script-progress" style="display:none;"></div>
        <div id="script_download" class="circular-item script-download" title="Site Average Load Time" style="display:none;">
            <span class="icon icomoon-icon-busy"></span>
            <input type="text" value="Loading....." class="script-download-input" id="script_download_input" data-width="200" data-displayprevious=true data-readOnly=true/>
        </div>
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>
        <div id='grid_wrapper'>
            <div id="ajax-navigate">
                <div id="trtop_template">
                    <div>
                        <?php if ($_smarty_tpl->tpl_vars['this']->value->config->item("NAVIGATION_BAR") == 'Top') {?>
                            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:top/top.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                        <?php } else { ?>
                            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:top/top_left.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                        <?php }?>
                    </div>
                </div>
                <div id="trmid_template">
                    <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:none;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                    <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                    <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                    <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('success') != '') {?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable("alert-success", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable("success", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('success'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['this']->value->session->flashdata('failure') != '') {?>   
                        <?php $_smarty_tpl->tpl_vars["msg_box_style"] = new Smarty_Variable("display:block;", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_style", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_class"] = new Smarty_Variable("alert-error", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_class", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_close"] = new Smarty_Variable("error", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_close", 0);?>
                        <?php $_smarty_tpl->tpl_vars["msg_box_text"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->session->flashdata('failure'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "msg_box_text", 0);?>
                    <?php }?>    
                    <div class="errorbox-position" id="var_msg_cnt" style="<?php echo $_smarty_tpl->tpl_vars['msg_box_style']->value;?>
">
                        <div class="closebtn-errorbox <?php echo $_smarty_tpl->tpl_vars['msg_box_close']->value;?>
" id="closebtn_errorbox">
                            <a href="javascript://" onclick="Project.closeMessage();"><button class="close" type="button">×</button></a>
                        </div>
                        <div class="content-errorbox alert <?php echo $_smarty_tpl->tpl_vars['msg_box_class']->value;?>
" id="err_msg_cnt"><?php echo $_smarty_tpl->tpl_vars['msg_box_text']->value;?>
</div>
                    </div>
                    <div id="main_content_div" class="main-content-div">
                        <div class="clearfix content-loader <?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN_BODY');?>
" id="content">
                            <?php if (file_exists($_smarty_tpl->tpl_vars['include_script_template']->value)) {?>
                                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, $_smarty_tpl->tpl_vars['include_script_template']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

                            <?php } else { ?>
                                <div id="ajax_content_div" class="ajax-content-div box gradient">
                                    <div id="ajax_qLoverlay"></div>
                                    <div id="ajax_qLbar"></div>
                                    <div id="scrollable_content" class="scrollable-content"></div>
                                </div>
                            <?php }?>
                        </div>
                        <div class="clearfix content-loader cslide <?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN_BODY');?>
" id="content_slide"></div>
                    </div>
                </div>
                <div id="trbot_template">
                    <div>
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:bottom/bottom.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                    </div>
                </div>
            </div>
            <?php echo '<script'; ?>
 type='text/javascript'>
                $(document).ready(function() {
                    $.fn.raty.defaults.path = '<?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value["gen_rating_master"];?>
';
                    if ($(".chosen-select").length) {
                        initializejQueryChosenEvents();
                    }
                    Project.checkmsg();
                });
            <?php echo '</script'; ?>
>
        </div>
        <div id="ad_navig_log" class="ad-navig-log"></div>
        <div id="db_query_log" class="db-query-log"></div>
        <div id="db_error_log" class="db-error-log"></div>
    </body>
</html><?php }
}

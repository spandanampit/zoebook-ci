<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:55:10
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/bulk_mailer_index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c457a64e8eb3_94446704',
  'file_dependency' => 
  array (
    '39de474d1e808e754dcf17d1c238d42614ae3a75' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/bulk_mailer_index.tpl',
      1 => 1706090551,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:bulk_mailer_index_strip.tpl' => 1,
  ),
),false)) {
function content_65c457a64e8eb3_94446704 ($_smarty_tpl) {
if (!is_callable('smarty_block_javascript')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/block.javascript.php';
if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->clean_js();?>

<?php }?>
<div class="module-list-container">
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:bulk_mailer_index_strip.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
" data-list-name="<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
">
        <div id="ajax_content_div" class="ajax-content-div top-frm-spacing box gradient">
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content top-list-spacing">
                <div class="grid-data-container pad-calc-container">
                    <div class="top-list-tab-layout" id="top_list_grid_layout">
                    </div>
                    <table class="grid-table-view " width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <!-- Module Listing Block -->
                            <td id="grid_data_col" class="<?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['grid_search_toolbar'];?>
">
                                <div id="pager2"></div>
                                <table id="list2"></table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <input type="hidden" name="selAllRows" value="" id="selAllRows" />
    </div>
</div>
<!-- Module Listing Javascript -->
<?php $_smarty_tpl->smarty->_cache['tag_stack'][] = array('javascript', array()); $_block_repeat=true; echo smarty_block_javascript(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    $.jgrid.no_legacy_api = true; $.jgrid.useJSON = true;
    var el_grid_settings = {}, js_col_model_json = {}, js_col_name_json = {}; 
                    
    el_grid_settings['module_name'] = '<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
';
    el_grid_settings['extra_hstr'] = '<?php echo $_smarty_tpl->tpl_vars['extra_hstr']->value;?>
';
    el_grid_settings['extra_qstr'] = '<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['enc_location'] = '<?php echo $_smarty_tpl->tpl_vars['enc_loc_module']->value;?>
';
    el_grid_settings['par_module'] = '<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['parMod']->value);?>
';
    el_grid_settings['par_data'] = '<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['parID']->value);?>
';
    el_grid_settings['par_field'] = '<?php echo $_smarty_tpl->tpl_vars['parField']->value;?>
';
    el_grid_settings['par_type'] = 'parent';

    el_grid_settings['index_page_url'] = '<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["index"];?>
';
    el_grid_settings['add_page_url'] = '<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["add"];?>
'; 
    el_grid_settings['edit_page_url'] =  admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["inline_edit_action"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['listing_url'] = admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["listing"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['export_url'] =  admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["export"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['print_url'] =  admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["print_listing"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
        
    el_grid_settings['search_refresh_url'] = admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_left_search_content"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['search_autocomp_url'] = admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_search_auto_complete"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['ajax_data_url'] = admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_chosen_auto_complete"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['auto_complete_url'] = admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_token_auto_complete"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['subgrid_listing_url'] =  admin_url+'<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_subgrid_block"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_grid_settings['jparent_switchto_url'] = admin_url+'<?php echo $_smarty_tpl->tpl_vars['parent_switch_cit']->value["url"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    
    el_grid_settings['admin_rec_arr'] = $.parseJSON('<?php echo json_encode($_smarty_tpl->tpl_vars['hide_admin_rec']->value);?>
');;
    el_grid_settings['status_arr'] = $.parseJSON('<?php echo json_encode($_smarty_tpl->tpl_vars['status_array']->value);?>
');
    el_grid_settings['status_lang_arr'] = $.parseJSON('<?php echo json_encode($_smarty_tpl->tpl_vars['status_label']->value);?>
');
                
    el_grid_settings['hide_add_btn'] = '1';
    el_grid_settings['hide_del_btn'] = '1';
    el_grid_settings['hide_status_btn'] = '1';
    el_grid_settings['hide_export_btn'] = '1';
    el_grid_settings['hide_columns_btn'] = 'No';
    
    el_grid_settings['show_saved_search'] = 'No';
    el_grid_settings['hide_advance_search'] = 'No';
    el_grid_settings['hide_search_tool'] = 'No';
    el_grid_settings['hide_multi_select'] = '<?php echo $_smarty_tpl->tpl_vars['capabilities']->value['hide_multi_select'];?>
';
    el_grid_settings['hide_paging_btn'] = 'No';
    el_grid_settings['hide_refresh_btn'] = 'No';
    
    el_grid_settings['popup_add_form'] = 'No';
    el_grid_settings['popup_edit_form'] = 'No';
    el_grid_settings['popup_add_size'] = ['75%', '75%'];
    el_grid_settings['popup_edit_size'] = ['75%', '75%'];
    
    el_grid_settings['permit_add_btn'] = '<?php echo $_smarty_tpl->tpl_vars['add_access']->value;?>
';
    el_grid_settings['permit_del_btn'] = '<?php echo $_smarty_tpl->tpl_vars['del_access']->value;?>
';
    el_grid_settings['permit_edit_btn'] = '<?php echo $_smarty_tpl->tpl_vars['edit_access']->value;?>
';
    el_grid_settings['permit_view_btn'] = '<?php echo $_smarty_tpl->tpl_vars['view_access']->value;?>
';
    el_grid_settings['permit_expo_btn'] = '<?php echo $_smarty_tpl->tpl_vars['expo_access']->value;?>
';
    el_grid_settings['permit_print_btn'] = '<?php echo $_smarty_tpl->tpl_vars['print_access']->value;?>
';
        
    el_grid_settings['serial_number'] = 'No';
    el_grid_settings['group_search'] = '';
    el_grid_settings['default_sort'] = 'mlh_user_name';
    el_grid_settings['sort_order'] = 'asc';
    el_grid_settings['footer_row'] = 'No';
    el_grid_settings['grouping'] = 'No';
    el_grid_settings['group_attr'] = {};
    
    el_grid_settings['inline_add'] = 'No';
    el_grid_settings['rec_position'] = 'Top';
    el_grid_settings['auto_width'] = 'Yes';
    el_grid_settings['auto_refresh'] = 'No';
    el_grid_settings['lazy_loading'] = 'No';
    el_grid_settings['print_rec'] = 'No';
    el_grid_settings['print_list'] = 'No';
    
    el_grid_settings['subgrid'] = '<?php echo $_smarty_tpl->tpl_vars['capabilities']->value['subgrid'];?>
';
    el_grid_settings['colgrid'] = 'No';
    el_grid_settings['listview'] = 'list';
    el_grid_settings['rating_allow'] = 'No';
    el_grid_settings['global_filter'] = 'No';
    
    el_grid_settings['search_slug'] = '<?php echo $_smarty_tpl->tpl_vars['search_slug']->value;?>
';
    el_grid_settings['search_list'] = $.parseJSON('<?php echo json_encode($_smarty_tpl->tpl_vars['search_preferences']->value);?>
');
    el_grid_settings['filters_arr'] = $.parseJSON('<?php echo json_encode($_smarty_tpl->tpl_vars['default_filters']->value);?>
');
    el_grid_settings['top_filter'] = [];
    el_grid_settings['buttons_arr'] = [{
        "name": "add",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SEND_BULK_MAIL');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_ADD_NEW');?>
",
        "icon": "icomoon-icon-plus-2",
        "icon_only": "No"
    },
    {
        "name": "del",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DELETE');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DELETE_SELECTED_ROW');?>
",
        "icon": "icomoon-icon-remove-6",
        "icon_only": "No"
    },
    {
        "name": "search",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SEARCH');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_ADVANCE_SEARCH');?>
",
        "icon": "icomoon-icon-search-3",
        "icon_only": "No"
    },
    {
        "name": "refresh",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SHOW_ALL');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SHOW_ALL_LISTING_RECORDS');?>
",
        "icon": "icomoon-icon-loop-2",
        "icon_only": "No"
    },
    {
        "name": "columns",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_COLUMNS');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_HIDE_C47SHOW_COLUMNS');?>
",
        "icon": "silk-icon-columns",
        "icon_only": "No"
    },
    {
        "name": "export",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_EXPORT');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_EXPORT');?>
",
        "icon": "icomoon-icon-out",
        "icon_only": "No"
    },
    {
        "name": "print",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_PRINT');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_PRINT');?>
",
        "icon": "icomoon-icon-printer-2",
        "icon_only": "No"
    }];
    el_grid_settings['buttons_grp'] = [];
    el_grid_settings['callbacks'] = [];
    el_grid_settings['message_arr'] = {
        "delete_alert" : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->processMessageLabel('ACTION_PLEASE_SELECT_ANY_RECORD');?>
",
        "delete_popup" : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO_DELETE_THIS_RECORD_C63');?>
",
        "status_alert" : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->processMessageLabel('ACTION_PLEASE_SELECT_ANY_RECORD_TO__C35STATUS_C35');?>
",
        "status_popup" : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO__C35STATUS_C35_THIS_RECORDS_C63');?>
",
    };
    
    js_col_name_json = [{
        "name": "mlh_user_name",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['label_lang'];?>
"
    },
    {
        "name": "et_email_title",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['label_lang'];?>
"
    },
    {
        "name": "mlh_to_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['label_lang'];?>
"
    },
    {
        "name": "mlh_email_code",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['label_lang'];?>
"
    },
    {
        "name": "mlh_email_subject",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['label_lang'];?>
"
    },
    {
        "name": "mlh_massage_body",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['label_lang'];?>
"
    },
    {
        "name": "mlh_email_formate",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['label_lang'];?>
"
    },
    {
        "name": "mlh_frome_name",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['label_lang'];?>
"
    },
    {
        "name": "mlh_from_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['label_lang'];?>
"
    },
    {
        "name": "mlh_cc_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['label_lang'];?>
"
    },
    {
        "name": "mlh_mail_send_status",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['label_lang'];?>
"
    },
    {
        "name": "mlh_mail_sent_date",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['label_lang'];?>
"
    },
    {
        "name": "mlh_added_date",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['label_lang'];?>
"
    }];
    
    js_col_model_json = [{
        "name": "mlh_user_name",
        "index": "mlh_user_name",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['label_lang'];?>
",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "center",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_user_name",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_user_name",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_user_name']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "et_email_title",
        "index": "et_email_title",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "select",
        "editrules": {
            "required": true,
            "infoArr": {
                "required": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.BULK_MAILER_EMAIL_TEMPLATE)
                }
            }
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_email_template_id",
                "autocomplete": "off",
                "data-placeholder": " ",
                "class": "search-chosen-select",
                "multiple": "multiple"
            },
            "sopt": intSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataUrl": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["et_email_title"]["json"] == "Yes") {?>false<?php } else { ?>'<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=et_email_title&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Search"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
'<?php }?>,
            "value": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["et_email_title"]["json"] == "Yes") {?>$.parseJSON('<?php echo addslashes($_smarty_tpl->tpl_vars['count_arr']->value["et_email_title"]["data"]);?>
')<?php } else { ?>null<?php }?>,
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['et_email_title']['ajax'] == 'Yes') {?>initSearchGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["et_email_title"]["ajax"] == "Yes") {?>ajax-call<?php }?>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_template_id",
            "dataUrl": '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=et_email_title&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Update"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
',
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['et_email_title']['ajax'] == 'Yes') {?>initEditGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["et_email_title"] == "Yes") {?>ajax-call<?php }?>',
            "data-placeholder": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35','#FIELD#','BULK_MAILER_EMAIL_TITLE');?>
",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['et_email_title']['default'];?>
",
        "filterSopt": "in",
        "stype": "select"
    },
    {
        "name": "mlh_to_email",
        "index": "mlh_to_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_to_email",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_to_email",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_to_email']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_email_code",
        "index": "mlh_email_code",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_email_code",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_code",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_code']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_email_subject",
        "index": "mlh_email_subject",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_email_subject",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_subject",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_subject']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_massage_body",
        "index": "mlh_massage_body",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "textarea",
        "editrules": {
            "required": true,
            "infoArr": {
                "required": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.BULK_MAILER_MASSAGE)
                }
            }
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_massage_body",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_massage_body",
            "rows": "1",
            "placeholder": "",
            "dataInit": initEditGridElasticEvent,
            "class": "inline-edit-row inline-textarea-edit "
        },
        "ctrl_type": "textarea",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_massage_body']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_email_formate",
        "index": "mlh_email_formate",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_email_formate",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_formate",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_email_formate']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_frome_name",
        "index": "mlh_frome_name",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_frome_name",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_frome_name",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_frome_name']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_from_email",
        "index": "mlh_from_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_from_email",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_from_email",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_from_email']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_cc_email",
        "index": "mlh_cc_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_cc_email",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_cc_email",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_cc_email']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_mail_send_status",
        "index": "mlh_mail_send_status",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['label_lang'];?>
",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "center",
        "edittype": "select",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_mail_send_status",
                "autocomplete": "off",
                "data-placeholder": " ",
                "class": "search-chosen-select",
                "multiple": "multiple"
            },
            "sopt": intSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataUrl": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["mlh_mail_send_status"]["json"] == "Yes") {?>false<?php } else { ?>'<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=mlh_mail_send_status&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Search"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
'<?php }?>,
            "value": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["mlh_mail_send_status"]["json"] == "Yes") {?>$.parseJSON('<?php echo addslashes($_smarty_tpl->tpl_vars['count_arr']->value["mlh_mail_send_status"]["data"]);?>
')<?php } else { ?>null<?php }?>,
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['mlh_mail_send_status']['ajax'] == 'Yes') {?>initSearchGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["mlh_mail_send_status"]["ajax"] == "Yes") {?>ajax-call<?php }?>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_mail_send_status",
            "dataUrl": '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=mlh_mail_send_status&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Update"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
',
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['mlh_mail_send_status']['ajax'] == 'Yes') {?>initEditGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["mlh_mail_send_status"] == "Yes") {?>ajax-call<?php }?>',
            "data-placeholder": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35','#FIELD#','BULK_MAILER_STATUS');?>
",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_send_status']['default'];?>
",
        "filterSopt": "in",
        "stype": "select"
    },
    {
        "name": "mlh_mail_sent_date",
        "index": "mlh_mail_sent_date",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_mail_sent_date",
                "autocomplete": "off",
                "class": "search-inline-date",
                "aria-date-format": "YYYY-MM-DD"
            },
            "sopt": dateSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataInit": initSearchGridDateRangePicker
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_mail_sent_date",
            "aria-date-format": "yy-mm-dd",
            "aria-min": "",
            "aria-max": "",
            "placeholder": "",
            "class": "inline-edit-row inline-date-edit date-picker-icon dateOnly"
        },
        "ctrl_type": "date",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_mail_sent_date']['default'];?>
",
        "filterSopt": "bt"
    },
    {
        "name": "mlh_added_date",
        "index": "mlh_added_date",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "bulk_mailer",
                "aria-unique-name": "mlh_added_date",
                "autocomplete": "off",
                "class": "search-inline-date",
                "aria-date-format": "YYYY-MM-DD"
            },
            "sopt": dateSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataInit": initSearchGridDateRangePicker
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_added_date",
            "aria-date-format": "yy-mm-dd",
            "aria-min": "",
            "aria-max": "",
            "placeholder": "",
            "class": "inline-edit-row inline-date-edit date-picker-icon dateOnly"
        },
        "ctrl_type": "date",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['mlh_added_date']['default'];?>
",
        "filterSopt": "bt"
    }];
         
    initMainGridListing();
    createTooltipHeading();
    callSwitchToParent();
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_javascript(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_cache['tag_stack']);?>


<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("admin/custom/bulkMailer.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("custom/Bulk_Mailer.css");?>

<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src();?>

<?php }?> 
<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<?php }?> <?php }
}

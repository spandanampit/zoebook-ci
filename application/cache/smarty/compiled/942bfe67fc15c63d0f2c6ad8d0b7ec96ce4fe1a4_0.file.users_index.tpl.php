<?php
/* Smarty version 3.1.28, created on 2024-02-08 10:04:54
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/users_index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c459ee9e87c0_18388514',
  'file_dependency' => 
  array (
    '942bfe67fc15c63d0f2c6ad8d0b7ec96ce4fe1a4' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/users_index.tpl',
      1 => 1706090558,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:users_index_strip.tpl' => 1,
  ),
),false)) {
function content_65c459ee9e87c0_18388514 ($_smarty_tpl) {
if (!is_callable('smarty_block_javascript')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/block.javascript.php';
if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->clean_js();?>

<?php }?>
<div class="module-list-container">
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:users_index_strip.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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
                
    el_grid_settings['hide_add_btn'] = '';
    el_grid_settings['hide_del_btn'] = '1';
    el_grid_settings['hide_status_btn'] = '1';
    el_grid_settings['hide_export_btn'] = '';
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
    el_grid_settings['default_sort'] = 'u_profile_image';
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
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_ADD');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_ADD_NEW');?>
",
        "icon": "icomoon-icon-plus-2",
        "icon_only": "No"
    },
    {
        "name": "del",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_DELETE');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_DELETE_SELECTED_ROW');?>
",
        "icon": "icomoon-icon-remove-6",
        "icon_only": "No"
    },
    {
        "name": "status_active",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_ACTIVE');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_ACTIVE');?>
",
        "icon": "icomoon-icon-checkmark",
        "icon_only": "No"
    },
    {
        "name": "status_inactive",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_INACTIVE');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_INACTIVE');?>
",
        "icon": "icomoon-icon-blocked",
        "icon_only": "No"
    },
    {
        "name": "search",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_SEARCH');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_ADVANCE_SEARCH');?>
",
        "icon": "icomoon-icon-search-3",
        "icon_only": "No"
    },
    {
        "name": "refresh",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_SHOW_ALL');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_SHOW_ALL_LISTING_RECORDS');?>
",
        "icon": "icomoon-icon-loop-2",
        "icon_only": "No"
    },
    {
        "name": "columns",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_COLUMNS');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_HIDE_C47SHOW_COLUMNS');?>
",
        "icon": "silk-icon-columns",
        "icon_only": "No"
    },
    {
        "name": "export",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_EXPORT');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_EXPORT');?>
",
        "icon": "icomoon-icon-out",
        "icon_only": "No"
    },
    {
        "name": "print",
        "type": "default",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_PRINT');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_PRINT');?>
",
        "icon": "icomoon-icon-printer-2",
        "icon_only": "No"
    },
    {
        "name": "custom_btn_2",
        "type": "custom",
        "text": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_UNSUBSCRIBE_ALL_USERS_FOR_EMAIL');?>
",
        "title": "<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('USERS_UNSUBSCRIBE_ALL_USERS_FOR_EMAIL');?>
",
        "icon": "silk-icon-popout",
        "icon_only": "No",
        "confirm": {
            "type": "callback",
            "module": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('user\/users');?>
",
            "callback": "Unsubscribe"
        }
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
        "name": "u_profile_image",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['label_lang'];?>
"
    },
    {
        "name": "u_name",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_name']['label_lang'];?>
"
    },
    {
        "name": "u_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email']['label_lang'];?>
"
    },
    {
        "name": "u_facebook_id",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['label_lang'];?>
"
    },
    {
        "name": "u_google_id",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['label_lang'];?>
"
    },
    {
        "name": "u_apple_id",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['label_lang'];?>
"
    },
    {
        "name": "u_email_verified",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['label_lang'];?>
"
    },
    {
        "name": "u_added_date",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['label_lang'];?>
"
    },
    {
        "name": "u_status",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_status']['label_lang'];?>
"
    },
    {
        "name": "u_subscribe_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['label_lang'];?>
"
    }];
    
    js_col_model_json = [{
        "name": "u_profile_image",
        "index": "u_profile_image",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['width'];?>
",
        "search": false,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "file",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_profile_image",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_profile_image",
            "class": "inline-edit-row"
        },
        "ctrl_type": "file",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_profile_image']['default'];?>
",
        "filterSopt": "cn"
    },
    {
        "name": "u_name",
        "index": "u_name",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_name']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_name']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "required": true,
            "infoArr": {
                "required": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.USERS_NAME)
                }
            }
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_name",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_name']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_name",
            "placeholder": "",
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_name']['default'];?>
",
        "filterSopt": "bw",
        "formatter": formatAdminModuleEditLink,
        "unformat": unformatAdminModuleEditLink
    },
    {
        "name": "u_email",
        "index": "u_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "required": true,
            "email": true,
            "infoArr": {
                "required": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.USERS_EMAIL)
                },
                "email": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_VALID_EMAIL_ADDRESS_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.USERS_EMAIL)
                }
            }
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_email",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_email",
            "placeholder": "",
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "u_facebook_id",
        "index": "u_facebook_id",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_facebook_id",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_facebook_id",
            "placeholder": "",
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_facebook_id']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "u_google_id",
        "index": "u_google_id",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_google_id",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_google_id",
            "placeholder": "",
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_google_id']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "u_apple_id",
        "index": "u_apple_id",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_apple_id",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_apple_id",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_apple_id']['default'];?>
",
        "filterSopt": "bw"
    },
    {
        "name": "u_email_verified",
        "index": "u_email_verified",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['label_lang'];?>
",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "center",
        "edittype": "select",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_email_verified",
                "autocomplete": "off",
                "data-placeholder": " ",
                "class": "search-chosen-select",
                "multiple": "multiple"
            },
            "sopt": intSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataUrl": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_email_verified"]["json"] == "Yes") {?>false<?php } else { ?>'<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=u_email_verified&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Search"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
'<?php }?>,
            "value": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_email_verified"]["json"] == "Yes") {?>$.parseJSON('<?php echo addslashes($_smarty_tpl->tpl_vars['count_arr']->value["u_email_verified"]["data"]);?>
')<?php } else { ?>null<?php }?>,
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['u_email_verified']['ajax'] == 'Yes') {?>initSearchGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_email_verified"]["ajax"] == "Yes") {?>ajax-call<?php }?>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_email_verified",
            "dataUrl": '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=u_email_verified&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Update"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
',
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['u_email_verified']['ajax'] == 'Yes') {?>initEditGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_email_verified"] == "Yes") {?>ajax-call<?php }?>',
            "data-placeholder": null,
            "class": "inline-edit-row"
        },
        "ctrl_type": "radio_buttons",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_email_verified']['default'];?>
",
        "filterSopt": "in",
        "stype": "select"
    },
    {
        "name": "u_added_date",
        "index": "u_added_date",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['label_lang'];?>
",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_added_date",
                "autocomplete": "off",
                "class": "search-inline-date",
                "aria-date-format": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminJSMoments('date_and_time');?>
",
                "aria-enable-time": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminJSMoments('date_and_time','ampm');?>
"
            },
            "sopt": dateSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataInit": initSearchGridDateTimePicker
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_added_date",
            "aria-date-format": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminJSFormats('date_and_time','dateFormat');?>
",
            "aria-time-format": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminJSFormats('date_and_time','timeFormat');?>
",
            "aria-enable-sec": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminJSFormats('date_and_time','showSecond');?>
",
            "aria-enable-ampm": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminJSFormats('date_and_time','ampm');?>
",
            "aria-min-date": "",
            "aria-max-date": "",
            "placeholder": "",
            "class": "inline-edit-row inline-date-edit date-picker-icon dateTime"
        },
        "ctrl_type": "date_and_time",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_added_date']['default'];?>
",
        "filterSopt": "bt"
    },
    {
        "name": "u_status",
        "index": "u_status",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_status']['label_lang'];?>
",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_status']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "center",
        "edittype": "select",
        "editrules": {
            "required": true,
            "infoArr": {
                "required": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.USERS_STATUS)
                }
            }
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_status",
                "autocomplete": "off",
                "data-placeholder": " ",
                "class": "search-chosen-select",
                "multiple": "multiple"
            },
            "sopt": intSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_status']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataUrl": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_status"]["json"] == "Yes") {?>false<?php } else { ?>'<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=u_status&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Search"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
'<?php }?>,
            "value": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_status"]["json"] == "Yes") {?>$.parseJSON('<?php echo addslashes($_smarty_tpl->tpl_vars['count_arr']->value["u_status"]["data"]);?>
')<?php } else { ?>null<?php }?>,
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['u_status']['ajax'] == 'Yes') {?>initSearchGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_status"]["ajax"] == "Yes") {?>ajax-call<?php }?>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_status",
            "dataUrl": '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=u_status&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Update"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
',
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['u_status']['ajax'] == 'Yes') {?>initEditGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_status"] == "Yes") {?>ajax-call<?php }?>',
            "data-placeholder": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35','#FIELD#','USERS_STATUS');?>
",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_status']['default'];?>
",
        "filterSopt": "in",
        "stype": "select"
    },
    {
        "name": "u_subscribe_email",
        "index": "u_subscribe_email",
        "label": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['label_lang'];?>
",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['width'];?>
",
        "search": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['search'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "export": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['export'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "sortable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['sortable'] == 'No') {?>false<?php } else { ?>true<?php }?>,
        "hidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['hidden'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "hideme": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['hideme'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "addable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['addable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "editable": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['editable'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
        "align": "center",
        "edittype": "select",
        "editrules": {
            "required": true,
            "infoArr": {
                "required": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.USERS_SUBSCRIBE_EMAIL)
                }
            }
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "users",
                "aria-unique-name": "u_subscribe_email",
                "autocomplete": "off",
                "data-placeholder": " ",
                "class": "search-chosen-select",
                "multiple": "multiple"
            },
            "sopt": intSearchOpts,
            "searchhidden": <?php if ($_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['search'] == 'Yes') {?>true<?php } else { ?>false<?php }?>,
            "dataUrl": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_subscribe_email"]["json"] == "Yes") {?>false<?php } else { ?>'<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=u_subscribe_email&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Search"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
'<?php }?>,
            "value": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_subscribe_email"]["json"] == "Yes") {?>$.parseJSON('<?php echo addslashes($_smarty_tpl->tpl_vars['count_arr']->value["u_subscribe_email"]["data"]);?>
')<?php } else { ?>null<?php }?>,
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['u_subscribe_email']['ajax'] == 'Yes') {?>initSearchGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_subscribe_email"]["ajax"] == "Yes") {?>ajax-call<?php }?>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "users",
            "aria-unique-name": "u_subscribe_email",
            "dataUrl": '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["get_list_options"];?>
?alias_name=u_subscribe_email&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value["Update"];?>
&rformat=html<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
',
            "dataInit": <?php if ($_smarty_tpl->tpl_vars['count_arr']->value['u_subscribe_email']['ajax'] == 'Yes') {?>initEditGridAjaxChosenEvent<?php } else { ?>initGridChosenEvent<?php }?>,
            "ajaxCall": '<?php if ($_smarty_tpl->tpl_vars['count_arr']->value["u_subscribe_email"] == "Yes") {?>ajax-call<?php }?>',
            "data-placeholder": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35','#FIELD#','USERS_SUBSCRIBE_EMAIL');?>
",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<?php echo $_smarty_tpl->tpl_vars['list_config']->value['u_subscribe_email']['default'];?>
",
        "filterSopt": "in",
        "stype": "select"
    }];
         
    initMainGridListing();
    createTooltipHeading();
    callSwitchToParent();
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_javascript(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_cache['tag_stack']);?>


<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("admin/custom/Admin_user.js");?>

<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src();?>

<?php }?> 
<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<?php }?> <?php }
}

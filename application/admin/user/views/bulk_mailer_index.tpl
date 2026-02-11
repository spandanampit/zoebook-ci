<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-list-container">
    <%include file="bulk_mailer_index_strip.tpl"%>
    <div class="<%$module_name%>" data-list-name="<%$module_name%>">
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
                            <td id="grid_data_col" class="<%$rl_theme_arr['grid_search_toolbar']%>">
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
<%javascript%>
    $.jgrid.no_legacy_api = true; $.jgrid.useJSON = true;
    var el_grid_settings = {}, js_col_model_json = {}, js_col_name_json = {}; 
                    
    el_grid_settings['module_name'] = '<%$module_name%>';
    el_grid_settings['extra_hstr'] = '<%$extra_hstr%>';
    el_grid_settings['extra_qstr'] = '<%$extra_qstr%>';
    el_grid_settings['enc_location'] = '<%$enc_loc_module%>';
    el_grid_settings['par_module'] = '<%$this->general->getAdminEncodeURL($parMod)%>';
    el_grid_settings['par_data'] = '<%$this->general->getAdminEncodeURL($parID)%>';
    el_grid_settings['par_field'] = '<%$parField%>';
    el_grid_settings['par_type'] = 'parent';

    el_grid_settings['index_page_url'] = '<%$mod_enc_url["index"]%>';
    el_grid_settings['add_page_url'] = '<%$mod_enc_url["add"]%>'; 
    el_grid_settings['edit_page_url'] =  admin_url+'<%$mod_enc_url["inline_edit_action"]%>?<%$extra_qstr%>';
    el_grid_settings['listing_url'] = admin_url+'<%$mod_enc_url["listing"]%>?<%$extra_qstr%>';
    el_grid_settings['export_url'] =  admin_url+'<%$mod_enc_url["export"]%>?<%$extra_qstr%>';
    el_grid_settings['print_url'] =  admin_url+'<%$mod_enc_url["print_listing"]%>?<%$extra_qstr%>';
        
    el_grid_settings['search_refresh_url'] = admin_url+'<%$mod_enc_url["get_left_search_content"]%>?<%$extra_qstr%>';
    el_grid_settings['search_autocomp_url'] = admin_url+'<%$mod_enc_url["get_search_auto_complete"]%>?<%$extra_qstr%>';
    el_grid_settings['ajax_data_url'] = admin_url+'<%$mod_enc_url["get_chosen_auto_complete"]%>?<%$extra_qstr%>';
    el_grid_settings['auto_complete_url'] = admin_url+'<%$mod_enc_url["get_token_auto_complete"]%>?<%$extra_qstr%>';
    el_grid_settings['subgrid_listing_url'] =  admin_url+'<%$mod_enc_url["get_subgrid_block"]%>?<%$extra_qstr%>';
    el_grid_settings['jparent_switchto_url'] = admin_url+'<%$parent_switch_cit["url"]%>?<%$extra_qstr%>';
    
    el_grid_settings['admin_rec_arr'] = $.parseJSON('<%$hide_admin_rec|@json_encode%>');;
    el_grid_settings['status_arr'] = $.parseJSON('<%$status_array|@json_encode%>');
    el_grid_settings['status_lang_arr'] = $.parseJSON('<%$status_label|@json_encode%>');
                
    el_grid_settings['hide_add_btn'] = '1';
    el_grid_settings['hide_del_btn'] = '1';
    el_grid_settings['hide_status_btn'] = '1';
    el_grid_settings['hide_export_btn'] = '1';
    el_grid_settings['hide_columns_btn'] = 'No';
    
    el_grid_settings['show_saved_search'] = 'No';
    el_grid_settings['hide_advance_search'] = 'No';
    el_grid_settings['hide_search_tool'] = 'No';
    el_grid_settings['hide_multi_select'] = '<%$capabilities.hide_multi_select%>';
    el_grid_settings['hide_paging_btn'] = 'No';
    el_grid_settings['hide_refresh_btn'] = 'No';
    
    el_grid_settings['popup_add_form'] = 'No';
    el_grid_settings['popup_edit_form'] = 'No';
    el_grid_settings['popup_add_size'] = ['75%', '75%'];
    el_grid_settings['popup_edit_size'] = ['75%', '75%'];
    
    el_grid_settings['permit_add_btn'] = '<%$add_access%>';
    el_grid_settings['permit_del_btn'] = '<%$del_access%>';
    el_grid_settings['permit_edit_btn'] = '<%$edit_access%>';
    el_grid_settings['permit_view_btn'] = '<%$view_access%>';
    el_grid_settings['permit_expo_btn'] = '<%$expo_access%>';
    el_grid_settings['permit_print_btn'] = '<%$print_access%>';
        
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
    
    el_grid_settings['subgrid'] = '<%$capabilities.subgrid%>';
    el_grid_settings['colgrid'] = 'No';
    el_grid_settings['listview'] = 'list';
    el_grid_settings['rating_allow'] = 'No';
    el_grid_settings['global_filter'] = 'No';
    
    el_grid_settings['search_slug'] = '<%$search_slug%>';
    el_grid_settings['search_list'] = $.parseJSON('<%$search_preferences|@json_encode%>');
    el_grid_settings['filters_arr'] = $.parseJSON('<%$default_filters|@json_encode%>');
    el_grid_settings['top_filter'] = [];
    el_grid_settings['buttons_arr'] = [{
        "name": "add",
        "type": "default",
        "text": "<%$this->lang->line('BULK_MAILER_SEND_BULK_MAIL')%>",
        "title": "<%$this->lang->line('BULK_MAILER_ADD_NEW')%>",
        "icon": "icomoon-icon-plus-2",
        "icon_only": "No"
    },
    {
        "name": "del",
        "type": "default",
        "text": "<%$this->lang->line('BULK_MAILER_DELETE')%>",
        "title": "<%$this->lang->line('BULK_MAILER_DELETE_SELECTED_ROW')%>",
        "icon": "icomoon-icon-remove-6",
        "icon_only": "No"
    },
    {
        "name": "search",
        "type": "default",
        "text": "<%$this->lang->line('BULK_MAILER_SEARCH')%>",
        "title": "<%$this->lang->line('BULK_MAILER_ADVANCE_SEARCH')%>",
        "icon": "icomoon-icon-search-3",
        "icon_only": "No"
    },
    {
        "name": "refresh",
        "type": "default",
        "text": "<%$this->lang->line('BULK_MAILER_SHOW_ALL')%>",
        "title": "<%$this->lang->line('BULK_MAILER_SHOW_ALL_LISTING_RECORDS')%>",
        "icon": "icomoon-icon-loop-2",
        "icon_only": "No"
    },
    {
        "name": "columns",
        "type": "default",
        "text": "<%$this->lang->line('BULK_MAILER_COLUMNS')%>",
        "title": "<%$this->lang->line('BULK_MAILER_HIDE_C47SHOW_COLUMNS')%>",
        "icon": "silk-icon-columns",
        "icon_only": "No"
    },
    {
        "name": "export",
        "type": "default",
        "text": "<%$this->lang->line('BULK_MAILER_EXPORT')%>",
        "title": "<%$this->lang->line('BULK_MAILER_EXPORT')%>",
        "icon": "icomoon-icon-out",
        "icon_only": "No"
    },
    {
        "name": "print",
        "type": "default",
        "text": "<%$this->lang->line('BULK_MAILER_PRINT')%>",
        "title": "<%$this->lang->line('BULK_MAILER_PRINT')%>",
        "icon": "icomoon-icon-printer-2",
        "icon_only": "No"
    }];
    el_grid_settings['buttons_grp'] = [];
    el_grid_settings['callbacks'] = [];
    el_grid_settings['message_arr'] = {
        "delete_alert" : "<%$this->general->processMessageLabel('ACTION_PLEASE_SELECT_ANY_RECORD')%>",
        "delete_popup" : "<%$this->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO_DELETE_THIS_RECORD_C63')%>",
        "status_alert" : "<%$this->general->processMessageLabel('ACTION_PLEASE_SELECT_ANY_RECORD_TO__C35STATUS_C35')%>",
        "status_popup" : "<%$this->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO__C35STATUS_C35_THIS_RECORDS_C63')%>",
    };
    
    js_col_name_json = [{
        "name": "mlh_user_name",
        "label": "<%$list_config['mlh_user_name']['label_lang']%>"
    },
    {
        "name": "et_email_title",
        "label": "<%$list_config['et_email_title']['label_lang']%>"
    },
    {
        "name": "mlh_to_email",
        "label": "<%$list_config['mlh_to_email']['label_lang']%>"
    },
    {
        "name": "mlh_email_code",
        "label": "<%$list_config['mlh_email_code']['label_lang']%>"
    },
    {
        "name": "mlh_email_subject",
        "label": "<%$list_config['mlh_email_subject']['label_lang']%>"
    },
    {
        "name": "mlh_massage_body",
        "label": "<%$list_config['mlh_massage_body']['label_lang']%>"
    },
    {
        "name": "mlh_email_formate",
        "label": "<%$list_config['mlh_email_formate']['label_lang']%>"
    },
    {
        "name": "mlh_frome_name",
        "label": "<%$list_config['mlh_frome_name']['label_lang']%>"
    },
    {
        "name": "mlh_from_email",
        "label": "<%$list_config['mlh_from_email']['label_lang']%>"
    },
    {
        "name": "mlh_cc_email",
        "label": "<%$list_config['mlh_cc_email']['label_lang']%>"
    },
    {
        "name": "mlh_mail_send_status",
        "label": "<%$list_config['mlh_mail_send_status']['label_lang']%>"
    },
    {
        "name": "mlh_mail_sent_date",
        "label": "<%$list_config['mlh_mail_sent_date']['label_lang']%>"
    },
    {
        "name": "mlh_added_date",
        "label": "<%$list_config['mlh_added_date']['label_lang']%>"
    }];
    
    js_col_model_json = [{
        "name": "mlh_user_name",
        "index": "mlh_user_name",
        "label": "<%$list_config['mlh_user_name']['label_lang']%>",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<%$list_config['mlh_user_name']['width']%>",
        "search": <%if $list_config['mlh_user_name']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_user_name']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_user_name']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_user_name']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_user_name']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_user_name']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_user_name']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_user_name']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_user_name",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_user_name']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "et_email_title",
        "index": "et_email_title",
        "label": "<%$list_config['et_email_title']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['et_email_title']['width']%>",
        "search": <%if $list_config['et_email_title']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['et_email_title']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['et_email_title']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['et_email_title']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['et_email_title']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['et_email_title']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['et_email_title']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['et_email_title']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
            "dataUrl": <%if $count_arr["et_email_title"]["json"] eq "Yes" %>false<%else%>'<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=et_email_title&mode=<%$mod_enc_mode["Search"]%>&rformat=html<%$extra_qstr%>'<%/if%>,
            "value": <%if $count_arr["et_email_title"]["json"] eq "Yes" %>$.parseJSON('<%$count_arr["et_email_title"]["data"]|@addslashes%>')<%else%>null<%/if%>,
            "dataInit": <%if $count_arr['et_email_title']['ajax'] eq 'Yes' %>initSearchGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["et_email_title"]["ajax"] eq "Yes" %>ajax-call<%/if%>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_template_id",
            "dataUrl": '<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=et_email_title&mode=<%$mod_enc_mode["Update"]%>&rformat=html<%$extra_qstr%>',
            "dataInit": <%if $count_arr['et_email_title']['ajax'] eq 'Yes' %>initEditGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["et_email_title"] eq "Yes" %>ajax-call<%/if%>',
            "data-placeholder": "<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'BULK_MAILER_EMAIL_TITLE')%>",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<%$list_config['et_email_title']['default']%>",
        "filterSopt": "in",
        "stype": "select"
    },
    {
        "name": "mlh_to_email",
        "index": "mlh_to_email",
        "label": "<%$list_config['mlh_to_email']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_to_email']['width']%>",
        "search": <%if $list_config['mlh_to_email']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_to_email']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_to_email']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_to_email']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_to_email']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_to_email']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_to_email']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_to_email']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_to_email",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_to_email']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_email_code",
        "index": "mlh_email_code",
        "label": "<%$list_config['mlh_email_code']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_email_code']['width']%>",
        "search": <%if $list_config['mlh_email_code']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_email_code']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_email_code']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_email_code']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_email_code']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_email_code']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_email_code']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_email_code']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_code",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_email_code']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_email_subject",
        "index": "mlh_email_subject",
        "label": "<%$list_config['mlh_email_subject']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_email_subject']['width']%>",
        "search": <%if $list_config['mlh_email_subject']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_email_subject']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_email_subject']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_email_subject']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_email_subject']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_email_subject']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_email_subject']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_email_subject']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_subject",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_email_subject']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_massage_body",
        "index": "mlh_massage_body",
        "label": "<%$list_config['mlh_massage_body']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_massage_body']['width']%>",
        "search": <%if $list_config['mlh_massage_body']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_massage_body']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_massage_body']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_massage_body']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_massage_body']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_massage_body']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_massage_body']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_massage_body']['search'] eq 'Yes' %>true<%else%>false<%/if%>
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
        "default_value": "<%$list_config['mlh_massage_body']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_email_formate",
        "index": "mlh_email_formate",
        "label": "<%$list_config['mlh_email_formate']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_email_formate']['width']%>",
        "search": <%if $list_config['mlh_email_formate']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_email_formate']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_email_formate']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_email_formate']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_email_formate']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_email_formate']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_email_formate']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_email_formate']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_email_formate",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_email_formate']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_frome_name",
        "index": "mlh_frome_name",
        "label": "<%$list_config['mlh_frome_name']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_frome_name']['width']%>",
        "search": <%if $list_config['mlh_frome_name']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_frome_name']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_frome_name']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_frome_name']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_frome_name']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_frome_name']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_frome_name']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_frome_name']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_frome_name",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_frome_name']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_from_email",
        "index": "mlh_from_email",
        "label": "<%$list_config['mlh_from_email']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_from_email']['width']%>",
        "search": <%if $list_config['mlh_from_email']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_from_email']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_from_email']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_from_email']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_from_email']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_from_email']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_from_email']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_from_email']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_from_email",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_from_email']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_cc_email",
        "index": "mlh_cc_email",
        "label": "<%$list_config['mlh_cc_email']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_cc_email']['width']%>",
        "search": <%if $list_config['mlh_cc_email']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_cc_email']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_cc_email']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_cc_email']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_cc_email']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_cc_email']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_cc_email']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_cc_email']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_cc_email",
            "placeholder": null,
            "class": "inline-edit-row "
        },
        "ctrl_type": "textbox",
        "default_value": "<%$list_config['mlh_cc_email']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "mlh_mail_send_status",
        "index": "mlh_mail_send_status",
        "label": "<%$list_config['mlh_mail_send_status']['label_lang']%>",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<%$list_config['mlh_mail_send_status']['width']%>",
        "search": <%if $list_config['mlh_mail_send_status']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_mail_send_status']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_mail_send_status']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_mail_send_status']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_mail_send_status']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_mail_send_status']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_mail_send_status']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_mail_send_status']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
            "dataUrl": <%if $count_arr["mlh_mail_send_status"]["json"] eq "Yes" %>false<%else%>'<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=mlh_mail_send_status&mode=<%$mod_enc_mode["Search"]%>&rformat=html<%$extra_qstr%>'<%/if%>,
            "value": <%if $count_arr["mlh_mail_send_status"]["json"] eq "Yes" %>$.parseJSON('<%$count_arr["mlh_mail_send_status"]["data"]|@addslashes%>')<%else%>null<%/if%>,
            "dataInit": <%if $count_arr['mlh_mail_send_status']['ajax'] eq 'Yes' %>initSearchGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["mlh_mail_send_status"]["ajax"] eq "Yes" %>ajax-call<%/if%>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "bulk_mailer",
            "aria-unique-name": "mlh_mail_send_status",
            "dataUrl": '<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=mlh_mail_send_status&mode=<%$mod_enc_mode["Update"]%>&rformat=html<%$extra_qstr%>',
            "dataInit": <%if $count_arr['mlh_mail_send_status']['ajax'] eq 'Yes' %>initEditGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["mlh_mail_send_status"] eq "Yes" %>ajax-call<%/if%>',
            "data-placeholder": "<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'BULK_MAILER_STATUS')%>",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<%$list_config['mlh_mail_send_status']['default']%>",
        "filterSopt": "in",
        "stype": "select"
    },
    {
        "name": "mlh_mail_sent_date",
        "index": "mlh_mail_sent_date",
        "label": "<%$list_config['mlh_mail_sent_date']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_mail_sent_date']['width']%>",
        "search": <%if $list_config['mlh_mail_sent_date']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_mail_sent_date']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_mail_sent_date']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_mail_sent_date']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_mail_sent_date']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_mail_sent_date']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_mail_sent_date']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_mail_sent_date']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
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
        "default_value": "<%$list_config['mlh_mail_sent_date']['default']%>",
        "filterSopt": "bt"
    },
    {
        "name": "mlh_added_date",
        "index": "mlh_added_date",
        "label": "<%$list_config['mlh_added_date']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['mlh_added_date']['width']%>",
        "search": <%if $list_config['mlh_added_date']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['mlh_added_date']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['mlh_added_date']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['mlh_added_date']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['mlh_added_date']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['mlh_added_date']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['mlh_added_date']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
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
            "searchhidden": <%if $list_config['mlh_added_date']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
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
        "default_value": "<%$list_config['mlh_added_date']['default']%>",
        "filterSopt": "bt"
    }];
         
    initMainGridListing();
    createTooltipHeading();
    callSwitchToParent();
<%/javascript%>

<%$this->js->add_js("admin/custom/bulkMailer.js")%>
<%$this->css->add_css("custom/Bulk_Mailer.css")%>
<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
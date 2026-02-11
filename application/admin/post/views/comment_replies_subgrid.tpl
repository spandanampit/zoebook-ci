<div class="module-sublist-container">
                
    
    <!-- Module Expand-Listing Block -->
    <div class="jq-subgrid-block">
        <div id="<%$subgrid_pager_id%>"></div>
        <table id="<%$subgrid_table_id%>"></table>
    </div>
</div>
<!-- Module Expand-Listing Javascript -->
<%javascript%>
    var el_subgrid_settings = {}, sub_js_col_name_json = {}, sub_js_col_model_json = {};
           
    el_subgrid_settings['table_id'] = '<%$subgrid_table_id%>';
    el_subgrid_settings['pager_id'] = '<%$subgrid_pager_id%>';
    el_subgrid_settings['module_name'] = '<%$module_name%>';
    el_subgrid_settings['advanced_grid'] = '<%$exp_advanced_grid%>';
    el_subgrid_settings['extra_hstr'] = '<%$extra_hstr%>';
    el_subgrid_settings['extra_qstrs'] = '<%$extra_qstr%>';
    el_subgrid_settings['par_module'] = '<%$exp_module_name%>';
    el_subgrid_settings['par_data'] = '<%$exp_par_id%>';
    el_subgrid_settings['par_field'] = '<%$exp_par_field%>';
    el_subgrid_settings['par_type'] = 'grid';
            
    el_subgrid_settings['index_page_url'] = '<%$mod_enc_url["index"]%>';
    el_subgrid_settings['add_page_url'] = '<%$mod_enc_url["add"]%>'; 
    el_subgrid_settings['edit_page_url'] = admin_url+'<%$mod_enc_url["inline_edit_action"]%>?<%$extra_qstr%>';
    el_subgrid_settings['listing_url'] = admin_url+'<%$mod_enc_url["listing"]%>?<%$extra_qstr%>';
    el_subgrid_settings['print_url'] =  admin_url+'<%$mod_enc_url["print_listing"]%>?<%$extra_qstr%>';
    
    el_subgrid_settings['ajax_data_url'] = admin_url+'<%$mod_enc_url["get_chosen_auto_complete"]%>?<%$extra_qstr%>';
    el_subgrid_settings['auto_complete_url'] = admin_url+'<%$mod_enc_url["get_token_auto_complete"]%>?<%$extra_qstr%>';
    el_subgrid_settings['nesgrid_listing_url'] =  admin_url+'<%$mod_enc_url["get_subgrid_block"]%>?<%$extra_qstr%>';
    
    el_subgrid_settings['admin_rec_arr'] = $.parseJSON('<%$hide_admin_rec|@json_encode%>');;
    el_subgrid_settings['status_arr'] = $.parseJSON('<%$status_array|@json_encode%>');
    el_subgrid_settings['status_lang_arr'] = $.parseJSON('<%$status_label|@json_encode%>');
            
    el_subgrid_settings['hide_add_btn'] = '';
    el_subgrid_settings['hide_del_btn'] = '1';
    el_subgrid_settings['hide_status_btn'] = '1';
    el_subgrid_settings['hide_advance_search'] = 'No';
    el_subgrid_settings['hide_search_tool'] = 'No';
    el_subgrid_settings['hide_multi_select'] = 'No';
    el_subgrid_settings['hide_paging_btn'] = 'No';
    el_subgrid_settings['hide_refresh_btn'] = 'No';
    
    el_subgrid_settings['popup_add_form'] = 'No';
    el_subgrid_settings['popup_edit_form'] = 'No';
    el_subgrid_settings['popup_add_size'] = ['75%', '75%'];
    el_subgrid_settings['popup_edit_size'] = ['75%', '75%'];
    
    el_subgrid_settings['permit_add_btn'] = '<%$add_access%>';
    el_subgrid_settings['permit_del_btn'] = '<%$del_access%>';
    el_subgrid_settings['permit_edit_btn'] = '<%$edit_access%>';
    el_subgrid_settings['permit_view_btn'] = '<%$view_access%>';
    el_subgrid_settings['permit_print_btn'] = '<%$print_access%>';
    
    el_subgrid_settings['group_search'] = '';
    el_subgrid_settings['default_sort'] = 'u_name';
    el_subgrid_settings['sort_order'] = 'asc';
    el_subgrid_settings['footer_row'] = 'No';
    el_subgrid_settings['grouping'] = 'No';
    el_subgrid_settings['group_attr'] = {};
    
    el_subgrid_settings['inline_add'] = 'No';
    el_subgrid_settings['rec_position'] = 'Top';
    el_subgrid_settings['auto_width'] = 'Yes';
    el_subgrid_settings['print_rec'] = 'No';
    el_subgrid_settings['print_list'] = 'No';
    
    el_subgrid_settings['nesgrid'] = '<%$exp_nested_grid%>';
    el_subgrid_settings['listview'] = 'list';
    el_subgrid_settings['rating_allow'] = 'No';
    el_subgrid_settings['global_filter'] = 'No';
    
    el_subgrid_settings['top_filter'] = [];
    el_subgrid_settings['buttons_arr'] = [];
    el_subgrid_settings['callbacks'] = [];
    el_subgrid_settings['message_arr'] = {
        "delete_alert" : "<%$this->general->processMessageLabel('ACTION_PLEASE_SELECT_ANY_RECORD')%>",
        "delete_popup" : "<%$this->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO_DELETE_THIS_RECORD_C63')%>",
        "status_alert" : "<%$this->general->processMessageLabel('ACTION_PLEASE_SELECT_ANY_RECORD_TO__C35STATUS_C35')%>",
        "status_popup" : "<%$this->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO__C35STATUS_C35_THIS_RECORDS_C63')%>",
    };
    
    sub_js_col_name_json = [{
        "name": "u_name",
        "label": "<%$list_config['u_name']['label_lang']%>"
    },
    {
        "name": "pc_comment",
        "label": "<%$list_config['pc_comment']['label_lang']%>"
    },
    {
        "name": "pc_added_date",
        "label": "<%$list_config['pc_added_date']['label_lang']%>"
    },
    {
        "name": "pc_modified_date",
        "label": "<%$list_config['pc_modified_date']['label_lang']%>"
    },
    {
        "name": "pc_status",
        "label": "<%$list_config['pc_status']['label_lang']%>"
    }];

    sub_js_col_model_json = [{
        "name": "u_name",
        "index": "u_name",
        "label": "<%$list_config['u_name']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['u_name']['width']%>",
        "search": <%if $list_config['u_name']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['u_name']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['u_name']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['u_name']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['u_name']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['u_name']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['u_name']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "align": "left",
        "edittype": "select",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "comment_replies",
                "aria-unique-name": "pc_user_id",
                "autocomplete": "off",
                "data-placeholder": " ",
                "class": "search-chosen-select",
                "multiple": "multiple"
            },
            "sopt": intSearchOpts,
            "searchhidden": <%if $list_config['u_name']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
            "dataUrl": <%if $count_arr["u_name"]["json"] eq "Yes" %>false<%else%>'<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=u_name&mode=<%$mod_enc_mode["Search"]%>&rformat=html<%$extra_qstr%>'<%/if%>,
            "value": <%if $count_arr["u_name"]["json"] eq "Yes" %>$.parseJSON('<%$count_arr["u_name"]["data"]|@addslashes%>')<%else%>null<%/if%>,
            "dataInit": <%if $count_arr['u_name']['ajax'] eq 'Yes' %>initSearchGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["u_name"]["ajax"] eq "Yes" %>ajax-call<%/if%>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "comment_replies",
            "aria-unique-name": "pc_user_id",
            "dataUrl": '<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=u_name&mode=<%$mod_enc_mode["Update"]%>&rformat=html<%$extra_qstr%>',
            "dataInit": <%if $count_arr['u_name']['ajax'] eq 'Yes' %>initEditGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["u_name"] eq "Yes" %>ajax-call<%/if%>',
            "data-placeholder": "<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'COMMENT_REPLIES_REPLIED_BY')%>",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<%$list_config['u_name']['default']%>",
        "filterSopt": "in",
        "stype": "select"
    },
    {
        "name": "pc_comment",
        "index": "pc_comment",
        "label": "<%$list_config['pc_comment']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['pc_comment']['width']%>",
        "search": <%if $list_config['pc_comment']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['pc_comment']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['pc_comment']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['pc_comment']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['pc_comment']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['pc_comment']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['pc_comment']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "align": "left",
        "edittype": "textarea",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "comment_replies",
                "aria-unique-name": "pc_comment",
                "autocomplete": "off"
            },
            "sopt": strSearchOpts,
            "searchhidden": <%if $list_config['pc_comment']['search'] eq 'Yes' %>true<%else%>false<%/if%>
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "comment_replies",
            "aria-unique-name": "pc_comment",
            "rows": "1",
            "placeholder": "",
            "dataInit": initEditGridElasticEvent,
            "class": "inline-edit-row inline-textarea-edit "
        },
        "ctrl_type": "textarea",
        "default_value": "<%$list_config['pc_comment']['default']%>",
        "filterSopt": "bw"
    },
    {
        "name": "pc_added_date",
        "index": "pc_added_date",
        "label": "<%$list_config['pc_added_date']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['pc_added_date']['width']%>",
        "search": <%if $list_config['pc_added_date']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['pc_added_date']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['pc_added_date']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['pc_added_date']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['pc_added_date']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['pc_added_date']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['pc_added_date']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "comment_replies",
                "aria-unique-name": "pc_added_date",
                "autocomplete": "off",
                "class": "search-inline-date",
                "aria-date-format": "<%$this->general->getAdminJSMoments('date_and_time')%>",
                "aria-enable-time": "<%$this->general->getAdminJSMoments('date_and_time','ampm')%>"
            },
            "sopt": dateSearchOpts,
            "searchhidden": <%if $list_config['pc_added_date']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
            "dataInit": initSearchGridDateTimePicker
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "comment_replies",
            "aria-unique-name": "pc_added_date",
            "aria-date-format": "<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>",
            "aria-time-format": "<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>",
            "aria-enable-sec": "<%$this->general->getAdminJSFormats('date_and_time', 'showSecond')%>",
            "aria-enable-ampm": "<%$this->general->getAdminJSFormats('date_and_time', 'ampm')%>",
            "aria-min-date": "",
            "aria-max-date": "",
            "placeholder": "",
            "class": "inline-edit-row inline-date-edit date-picker-icon dateTime"
        },
        "ctrl_type": "date_and_time",
        "default_value": "<%$list_config['pc_added_date']['default']%>",
        "filterSopt": "bt"
    },
    {
        "name": "pc_modified_date",
        "index": "pc_modified_date",
        "label": "<%$list_config['pc_modified_date']['label_lang']%>",
        "labelClass": "header-align-left",
        "resizable": true,
        "width": "<%$list_config['pc_modified_date']['width']%>",
        "search": <%if $list_config['pc_modified_date']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['pc_modified_date']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['pc_modified_date']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['pc_modified_date']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['pc_modified_date']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['pc_modified_date']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['pc_modified_date']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "align": "left",
        "edittype": "text",
        "editrules": {
            "infoArr": []
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "comment_replies",
                "aria-unique-name": "pc_modified_date",
                "autocomplete": "off",
                "class": "search-inline-date",
                "aria-date-format": "<%$this->general->getAdminJSMoments('date_and_time')%>",
                "aria-enable-time": "<%$this->general->getAdminJSMoments('date_and_time','ampm')%>"
            },
            "sopt": dateSearchOpts,
            "searchhidden": <%if $list_config['pc_modified_date']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
            "dataInit": initSearchGridDateTimePicker
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "comment_replies",
            "aria-unique-name": "pc_modified_date",
            "aria-date-format": "<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>",
            "aria-time-format": "<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>",
            "aria-enable-sec": "<%$this->general->getAdminJSFormats('date_and_time', 'showSecond')%>",
            "aria-enable-ampm": "<%$this->general->getAdminJSFormats('date_and_time', 'ampm')%>",
            "aria-min-date": "",
            "aria-max-date": "",
            "placeholder": "",
            "class": "inline-edit-row inline-date-edit date-picker-icon dateTime"
        },
        "ctrl_type": "date_and_time",
        "default_value": "<%$list_config['pc_modified_date']['default']%>",
        "filterSopt": "bt"
    },
    {
        "name": "pc_status",
        "index": "pc_status",
        "label": "<%$list_config['pc_status']['label_lang']%>",
        "labelClass": "header-align-center",
        "resizable": true,
        "width": "<%$list_config['pc_status']['width']%>",
        "search": <%if $list_config['pc_status']['search'] eq 'No' %>false<%else%>true<%/if%>,
        "export": <%if $list_config['pc_status']['export'] eq 'No' %>false<%else%>true<%/if%>,
        "sortable": <%if $list_config['pc_status']['sortable'] eq 'No' %>false<%else%>true<%/if%>,
        "hidden": <%if $list_config['pc_status']['hidden'] eq 'Yes' %>true<%else%>false<%/if%>,
        "hideme": <%if $list_config['pc_status']['hideme'] eq 'Yes' %>true<%else%>false<%/if%>,
        "addable": <%if $list_config['pc_status']['addable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "editable": <%if $list_config['pc_status']['editable'] eq 'Yes' %>true<%else%>false<%/if%>,
        "align": "center",
        "edittype": "select",
        "editrules": {
            "required": true,
            "infoArr": {
                "required": {
                    "message": ci_js_validation_message(js_lang_label.GENERIC_PLEASE_ENTER_A_VALUE_FOR_THE__C35FIELD_C35_FIELD_C46 ,"#FIELD#",js_lang_label.COMMENT_REPLIES_STATUS)
                }
            }
        },
        "searchoptions": {
            "attr": {
                "aria-grid-id": el_tpl_settings.main_grid_id,
                "aria-module-name": "comment_replies",
                "aria-unique-name": "pc_status",
                "autocomplete": "off",
                "data-placeholder": " ",
                "class": "search-chosen-select",
                "multiple": "multiple"
            },
            "sopt": intSearchOpts,
            "searchhidden": <%if $list_config['pc_status']['search'] eq 'Yes' %>true<%else%>false<%/if%>,
            "dataUrl": <%if $count_arr["pc_status"]["json"] eq "Yes" %>false<%else%>'<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=pc_status&mode=<%$mod_enc_mode["Search"]%>&rformat=html<%$extra_qstr%>'<%/if%>,
            "value": <%if $count_arr["pc_status"]["json"] eq "Yes" %>$.parseJSON('<%$count_arr["pc_status"]["data"]|@addslashes%>')<%else%>null<%/if%>,
            "dataInit": <%if $count_arr['pc_status']['ajax'] eq 'Yes' %>initSearchGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["pc_status"]["ajax"] eq "Yes" %>ajax-call<%/if%>',
            "multiple": true
        },
        "editoptions": {
            "aria-grid-id": el_tpl_settings.main_grid_id,
            "aria-module-name": "comment_replies",
            "aria-unique-name": "pc_status",
            "dataUrl": '<%$admin_url%><%$mod_enc_url["get_list_options"]%>?alias_name=pc_status&mode=<%$mod_enc_mode["Update"]%>&rformat=html<%$extra_qstr%>',
            "dataInit": <%if $count_arr['pc_status']['ajax'] eq 'Yes' %>initEditGridAjaxChosenEvent<%else%>initGridChosenEvent<%/if%>,
            "ajaxCall": '<%if $count_arr["pc_status"] eq "Yes" %>ajax-call<%/if%>',
            "data-placeholder": "<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'COMMENT_REPLIES_STATUS')%>",
            "class": "inline-edit-row chosen-select"
        },
        "ctrl_type": "dropdown",
        "default_value": "<%$list_config['pc_status']['default']%>",
        "filterSopt": "in",
        "stype": "select"
    }];
                  
    initSubGridListing();
<%/javascript%>
    
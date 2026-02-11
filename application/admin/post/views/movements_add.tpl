<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-form-container">
    <%include file="movements_add_strip.tpl"%>
    <div class="<%$module_name%>" data-form-name="<%$module_name%>">
        <div id="ajax_content_div" class="ajax-content-div top-frm-spacing" >
            <input type="hidden" id="projmod" name="projmod" value="movements" />
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Module Tabs & Top Detail View -->
            <div class="top-frm-tab-layout" id="top_frm_tab_layout">
            </div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content popup-content top-block-spacing ">
                <div id="movements" class="frm-module-block frm-elem-block frm-stand-view">
                    <!-- Module Form Block -->
                    <form name="frmaddupdate" id="frmaddupdate" action="<%$admin_url%><%$mod_enc_url['add_action']%>?<%$extra_qstr%>" method="post"  enctype="multipart/form-data">
                        <!-- Form Hidden Fields Unit -->
                        <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                        <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                        <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                        <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                        <input type="hidden" id="draft_uniq_id" name="draft_uniq_id" value="<%$draft_uniq_id%>" />
                        <input type="hidden" id="extra_hstr" name="extra_hstr" value="<%$extra_hstr%>" />
                        <!-- Form Dispaly Fields Unit -->
                        <div class="main-content-block " id="main_content_block">
                            <div style="width:98%" class="frm-block-layout pad-calc-container">
                                <div class="box gradient <%$rl_theme_arr['frm_stand_content_row']%> <%$rl_theme_arr['frm_stand_border_view']%>">
                                    <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('MOVEMENTS_MOVEMENTS')%></h4></div>
                                    <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                        <div class="form-row row-fluid " id="cc_sh_m_movement_name">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_movement_name']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <input type="text" placeholder="" value="<%$data['m_movement_name']|@htmlentities%>" name="m_movement_name" id="m_movement_name" title="<%$this->lang->line('MOVEMENTS_MOVEMENT_NAME')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_movement_nameErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_description">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_description']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <textarea placeholder=""  name="m_description" id="m_description" title="<%$this->lang->line('MOVEMENTS_DESCRIPTION')%>"  data-ctrl-type='textarea'  class='elastic frm-size-medium'  ><%$data['m_description']%></textarea>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_descriptionErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_theme">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_theme']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['m_theme']%>
                                                <%$this->dropdown->display("m_theme","m_theme","  title='<%$this->lang->line('MOVEMENTS_THEME')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'MOVEMENTS_THEME')%>'  ", "|||", "", $opt_selected,"m_theme")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_themeErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_visibility">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_visibility']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['m_visibility']%>
                                                <%$this->dropdown->display("m_visibility","m_visibility","  title='<%$this->lang->line('MOVEMENTS_VISIBILITY')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'MOVEMENTS_VISIBILITY')%>'  ", "|||", "", $opt_selected,"m_visibility")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_visibilityErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_user_id">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_user_id']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['m_user_id']%>
                                                <%$this->dropdown->display("m_user_id","m_user_id","  title='<%$this->lang->line('MOVEMENTS_USER_ID')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'MOVEMENTS_USER_ID')%>'  ", "|||", "", $opt_selected,"m_user_id")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_user_idErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_status">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_status']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['m_status']%>
                                                <%$this->dropdown->display("m_status","m_status","  title='<%$this->lang->line('MOVEMENTS_STATUS')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'MOVEMENTS_STATUS')%>'  ", "|||", "", $opt_selected,"m_status")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_statusErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_device_group_token">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_device_group_token']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <textarea placeholder=""  name="m_device_group_token" id="m_device_group_token" title="<%$this->lang->line('MOVEMENTS_DEVICE_GROUP_TOKEN')%>"  data-ctrl-type='textarea'  class='elastic frm-size-medium'  ><%$data['m_device_group_token']%></textarea>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_device_group_tokenErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_added_date">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_added_date']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  input-append text-append-prepend  ">
                                                <input type="text" value="<%$this->general->dateDefinedFormat('Y-m-d',$data['m_added_date'])%>" placeholder="" name="m_added_date" id="m_added_date" title="<%$this->lang->line('MOVEMENTS_ADDED_DATE')%>"  data-ctrl-type='date'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='yy-mm-dd'  aria-format-type='date'  />
                                                <span class='add-on text-addon date-append-class icomoon-icon-calendar'></span>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_added_dateErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_m_modified_date">
                                            <label class="form-label span3 ">
                                                <%$form_config['m_modified_date']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  input-append text-append-prepend  ">
                                                <input type="text" value="<%$this->general->dateDefinedFormat('Y-m-d',$data['m_modified_date'])%>" placeholder="" name="m_modified_date" id="m_modified_date" title="<%$this->lang->line('MOVEMENTS_MODIFIED_DATE')%>"  data-ctrl-type='date'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='yy-mm-dd'  aria-format-type='date'  />
                                                <span class='add-on text-addon date-append-class icomoon-icon-calendar'></span>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='m_modified_dateErr'></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="frm-bot-btn <%$rl_theme_arr['frm_stand_action_bar']%> <%$rl_theme_arr['frm_stand_action_btn']%> popup-footer">
                                <%if $rl_theme_arr['frm_stand_ctrls_view'] eq 'No'%>
                                    <%assign var='rm_ctrl_directions' value=true%>
                                <%/if%>
                                <%include file="movements_add_buttons.tpl"%>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Module Form Javascript -->
<%javascript%>
            
    var el_form_settings = {}, elements_uni_arr = {}, child_rules_arr = {}, google_map_json = {}, pre_cond_code_arr = [];
    el_form_settings['module_name'] = '<%$module_name%>'; 
    el_form_settings['extra_hstr'] = '<%$extra_hstr%>';
    el_form_settings['extra_qstr'] = '<%$extra_qstr%>';
    el_form_settings['upload_form_file_url'] = admin_url+"<%$mod_enc_url['upload_form_file']%>?<%$extra_qstr%>";
    el_form_settings['get_chosen_auto_complete_url'] = admin_url+"<%$mod_enc_url['get_chosen_auto_complete']%>?<%$extra_qstr%>";
    el_form_settings['token_auto_complete_url'] = admin_url+"<%$mod_enc_url['get_token_auto_complete']%>?<%$extra_qstr%>";
    el_form_settings['tab_wise_block_url'] = admin_url+"<%$mod_enc_url['get_tab_wise_block']%>?<%$extra_qstr%>";
    el_form_settings['parent_source_options_url'] = "<%$mod_enc_url['parent_source_options']%>?<%$extra_qstr%>";
    el_form_settings['jself_switchto_url'] =  admin_url+'<%$switch_cit["url"]%>';
    el_form_settings['callbacks'] = [];
    
    google_map_json = $.parseJSON('<%$google_map_arr|@json_encode%>');
    child_rules_arr = {};
            
    <%if $auto_arr|@is_array && $auto_arr|@count gt 0%>
        setTimeout(function(){
            <%foreach name=i from=$auto_arr item=v key=k%>
                if($("#<%$k%>").is("select")){
                    $("#<%$k%>").ajaxChosen({
                        dataType: "json",
                        type: "POST",
                        url: el_form_settings.get_chosen_auto_complete_url+"&unique_name=<%$k%>&mode=<%$mod_enc_mode[$mode]%>&id=<%$enc_id%>"
                        },{
                        loadingImg: admin_image_url+"chosen-loading.gif"
                    });
                }
            <%/foreach%>
        }, 500);
    <%/if%>        
    el_form_settings['jajax_submit_func'] = '';
    el_form_settings['jajax_submit_back'] = '';
    el_form_settings['jajax_action_url'] = '<%$admin_url%><%$mod_enc_url["add_action"]%>?<%$extra_qstr%>';
    el_form_settings['save_as_draft'] = 'No';
    el_form_settings['multi_lingual_trans'] = 'Yes';
    el_form_settings['buttons_arr'] = [];
    el_form_settings['message_arr'] = {
        "delete_message" : "<%$this->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO_DELETE_THIS_RECORD_C63')%>",
    };
    
    
    callSwitchToSelf();
<%/javascript%>
<%$this->js->add_js('admin/movements_add_js.js')%>

<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
<%javascript%>
    Project.modules.movements.callEvents();
<%/javascript%>
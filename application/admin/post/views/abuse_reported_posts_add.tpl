<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-form-container">
    <%include file="abuse_reported_posts_add_strip.tpl"%>
    <div class="<%$module_name%>" data-form-name="<%$module_name%>">
        <div id="ajax_content_div" class="ajax-content-div top-frm-spacing" >
            <input type="hidden" id="projmod" name="projmod" value="abuse_reported_posts" />
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Module Tabs & Top Detail View -->
            <div class="top-frm-tab-layout" id="top_frm_tab_layout">
            </div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content top-block-spacing ">
                <div id="abuse_reported_posts" class="frm-module-block frm-elem-block frm-stand-view">
                    <!-- Module Form Block -->
                    <form name="frmaddupdate" id="frmaddupdate" action="<%$admin_url%><%$mod_enc_url['add_action']%>?<%$extra_qstr%>" method="post"  enctype="multipart/form-data">
                        <!-- Form Hidden Fields Unit -->
                        <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                        <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                        <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                        <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                        <input type="hidden" id="draft_uniq_id" name="draft_uniq_id" value="<%$draft_uniq_id%>" />
                        <input type="hidden" id="extra_hstr" name="extra_hstr" value="<%$extra_hstr%>" />
                        <input type="hidden" name="pra_post_comment_id" id="pra_post_comment_id" value="<%$data['pra_post_comment_id']%>"  class='ignore-valid ' />
                        <input type="hidden" name="pra_report_on" id="pra_report_on" value="<%$data['pra_report_on']%>"  class='ignore-valid ' />
                        <input type="hidden" name="pra_modified_date" id="pra_modified_date" value="<%$this->general->dateTimeSystemFormat($data['pra_modified_date'])%>"  class='ignore-valid '  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                        <!-- Form Dispaly Fields Unit -->
                        <div class="main-content-block" id="main_content_block">
                            <div style="width:98%" class="frm-block-layout pad-calc-container">
                                <div class="box gradient <%$rl_theme_arr['frm_stand_content_row']%> <%$rl_theme_arr['frm_stand_border_view']%>">
                                    <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('ABUSE_REPORTED_POSTS_ABUSE_REPORTED_POSTS')%></h4></div>
                                    <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                        <div class="form-row row-fluid " id="cc_sh_pra_post_id">
                                            <label class="form-label span3 ">
                                                <%$form_config['pra_post_id']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                <%assign var="opt_selected" value=$data['pra_post_id']%>
                                                <%if $mode eq "Update"%>
                                                    <input type="hidden" name="pra_post_id" id="pra_post_id" value="<%$data['pra_post_id']%>" class="ignore-valid"/>
                                                    <%assign var="combo_arr" value=$opt_arr["pra_post_id"]%>
                                                    <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                    <strong>
                                                        <%if $opt_display neq ""%>
                                                            <%$opt_display%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <%$this->dropdown->display("pra_post_id","pra_post_id","  title='<%$this->lang->line('ABUSE_REPORTED_POSTS_POST_TEXT')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'ABUSE_REPORTED_POSTS_POST_TEXT')%>'  ", "|||", "", $opt_selected,"pra_post_id")%>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pra_post_idErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pra_report_notes">
                                            <label class="form-label span3 ">
                                                <%$form_config['pra_report_notes']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                <%if $mode eq "Update"%>
                                                    <textarea style="display:none;" class="ignore-valid" name="pra_report_notes" id="pra_report_notes"><%$data['pra_report_notes']%></textarea>
                                                    <strong>
                                                        <%if $data['pra_report_notes'] neq ""%>
                                                            <%$data['pra_report_notes']%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <textarea placeholder=""  name="pra_report_notes" id="pra_report_notes" title="<%$this->lang->line('ABUSE_REPORTED_POSTS_REPORT_NOTES')%>"  data-ctrl-type='textarea'  class='elastic frm-size-medium'  ><%$data['pra_report_notes']%></textarea>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pra_report_notesErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pra_reported_by">
                                            <label class="form-label span3 ">
                                                <%$form_config['pra_reported_by']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                <%assign var="opt_selected" value=$data['pra_reported_by']%>
                                                <%if $mode eq "Update"%>
                                                    <input type="hidden" name="pra_reported_by" id="pra_reported_by" value="<%$data['pra_reported_by']%>" class="ignore-valid"/>
                                                    <%assign var="combo_arr" value=$opt_arr["pra_reported_by"]%>
                                                    <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                    <strong>
                                                        <%if $opt_display neq ""%>
                                                            <%$opt_display%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <%$this->dropdown->display("pra_reported_by","pra_reported_by","  title='<%$this->lang->line('ABUSE_REPORTED_POSTS_REPORTED_BY')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'ABUSE_REPORTED_POSTS_REPORTED_BY')%>'  ", "|||", "", $opt_selected,"pra_reported_by")%>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pra_reported_byErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pra_added_date">
                                            <label class="form-label span3 ">
                                                <%$form_config['pra_added_date']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%> ">
                                                <%if $mode eq "Update"%>
                                                    <input type="hidden" name="pra_added_date" id="pra_added_date" value="<%$this->general->dateTimeSystemFormat($data['pra_added_date'])%>" class="ignore-valid view-label-only"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                                                    <%assign var="display_date_time" value=$this->general->dateTimeSystemFormat($data['pra_added_date'])%>
                                                    <strong>
                                                        <%if $display_date_time neq ""%>
                                                            <%$display_date_time%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <input type="text" value="<%$this->general->dateTimeSystemFormat($data['pra_added_date'])%>" name="pra_added_date" placeholder=""  id="pra_added_date" title="<%$this->lang->line('ABUSE_REPORTED_POSTS_REPORTED_ON')%>"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                                    <span class='add-on text-addon date-time-append-class icomoon-icon-calendar'></span>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pra_added_dateErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pra_status">
                                            <label class="form-label span3 ">
                                                <%$form_config['pra_status']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['pra_status']%>
                                                <%$this->dropdown->display("pra_status","pra_status","  title='<%$this->lang->line('ABUSE_REPORTED_POSTS_STATUS')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'ABUSE_REPORTED_POSTS_STATUS')%>'  ", "|||", "", $opt_selected,"pra_status")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pra_statusErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pra_type">
                                            <label class="form-label span3 ">
                                                <%$form_config['pra_type']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['pra_type']%>
                                                <%$this->dropdown->display("pra_type","pra_type","  title='<%$this->lang->line('ABUSE_REPORTED_POSTS_TYPE')%>'  aria-chosen-valid='Yes'  class='chosen-select'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'ABUSE_REPORTED_POSTS_TYPE')%>'  ", "", "", $opt_selected,"pra_type")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pra_typeErr'></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="frm-bot-btn <%$rl_theme_arr['frm_stand_action_bar']%> <%$rl_theme_arr['frm_stand_action_btn']%>">
                                <%if $rl_theme_arr['frm_stand_ctrls_view'] eq 'No'%>
                                    <%assign var='rm_ctrl_directions' value=true%>
                                <%/if%>
                                <%include file="abuse_reported_posts_add_buttons.tpl"%>
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
    el_form_settings['buttons_arr'] = [];
    el_form_settings['message_arr'] = {
        "delete_message" : "<%$this->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO_DELETE_THIS_RECORD_C63')%>"
    };
    
    callSwitchToSelf();
<%/javascript%>
<%$this->js->add_js('admin/abuse_reported_posts_add_js.js')%>

<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
<%javascript%>
    Project.modules.abuse_reported_posts.callEvents();
<%/javascript%>
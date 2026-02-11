<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-form-container">
    <%include file="comment_replies_add_strip.tpl"%>
    <div class="<%$module_name%>" data-form-name="<%$module_name%>">
        <div id="ajax_content_div" class="ajax-content-div top-frm-spacing" >
            <input type="hidden" id="projmod" name="projmod" value="comment_replies" />
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Module Tabs & Top Detail View -->
            <div class="top-frm-tab-layout" id="top_frm_tab_layout">
            </div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content top-block-spacing ">
                <div id="comment_replies" class="frm-module-block frm-elem-block frm-stand-view">
                    <!-- Module Form Block -->
                    <form name="frmaddupdate" id="frmaddupdate" action="<%$admin_url%><%$mod_enc_url['add_action']%>?<%$extra_qstr%>" method="post"  enctype="multipart/form-data">
                        <!-- Form Hidden Fields Unit -->
                        <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                        <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                        <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                        <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                        <input type="hidden" id="draft_uniq_id" name="draft_uniq_id" value="<%$draft_uniq_id%>" />
                        <input type="hidden" id="extra_hstr" name="extra_hstr" value="<%$extra_hstr%>" />
                        <input type="hidden" name="pc_parent_id" id="pc_parent_id" value="<%$data['pc_parent_id']%>"  class='ignore-valid ' />
                        <!-- Form Dispaly Fields Unit -->
                        <div class="main-content-block" id="main_content_block">
                            <div style="width:98%" class="frm-block-layout pad-calc-container">
                                <div class="box gradient <%$rl_theme_arr['frm_stand_content_row']%> <%$rl_theme_arr['frm_stand_border_view']%>">
                                    <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('COMMENT_REPLIES_COMMENT_REPLIES')%></h4></div>
                                    <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                        <div class="form-row row-fluid " id="cc_sh_pc_post_id">
                                            <label class="form-label span3 ">
                                                <%$form_config['pc_post_id']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['pc_post_id']%>
                                                <%$this->dropdown->display("pc_post_id","pc_post_id","  title='<%$this->lang->line('COMMENT_REPLIES_POST_ID')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'COMMENT_REPLIES_POST_ID')%>'  ", "|||", "", $opt_selected,"pc_post_id")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pc_post_idErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pc_user_id">
                                            <label class="form-label span3 ">
                                                <%$form_config['pc_user_id']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                <%assign var="opt_selected" value=$data['pc_user_id']%>
                                                <%if $mode eq "Update"%>
                                                    <input type="hidden" name="pc_user_id" id="pc_user_id" value="<%$data['pc_user_id']%>" class="ignore-valid"/>
                                                    <%assign var="combo_arr" value=$opt_arr["pc_user_id"]%>
                                                    <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                    <strong>
                                                        <%if $opt_display neq ""%>
                                                            <%$opt_display%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <%$this->dropdown->display("pc_user_id","pc_user_id","  title='<%$this->lang->line('COMMENT_REPLIES_COMMENTED_BY')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'COMMENT_REPLIES_COMMENTED_BY')%>'  ", "|||", "", $opt_selected,"pc_user_id")%>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pc_user_idErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pc_comment">
                                            <label class="form-label span3 ">
                                                <%$form_config['pc_comment']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                <%if $mode eq "Update"%>
                                                    <textarea style="display:none;" class="ignore-valid" name="pc_comment" id="pc_comment"><%$data['pc_comment']%></textarea>
                                                    <strong>
                                                        <%if $data['pc_comment'] neq ""%>
                                                            <%$data['pc_comment']%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <textarea placeholder=""  name="pc_comment" id="pc_comment" title="<%$this->lang->line('COMMENT_REPLIES_COMMENT')%>"  data-ctrl-type='textarea'  class='elastic frm-size-medium'  ><%$data['pc_comment']%></textarea>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pc_commentErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pc_added_date">
                                            <label class="form-label span3 ">
                                                <%$form_config['pc_added_date']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%> ">
                                                <%if $mode eq "Update"%>
                                                    <input type="hidden" name="pc_added_date" id="pc_added_date" value="<%$this->general->dateTimeSystemFormat($data['pc_added_date'])%>" class="ignore-valid view-label-only"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                                                    <%assign var="display_date_time" value=$this->general->dateTimeSystemFormat($data['pc_added_date'])%>
                                                    <strong>
                                                        <%if $display_date_time neq ""%>
                                                            <%$display_date_time%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <input type="text" value="<%$this->general->dateTimeSystemFormat($data['pc_added_date'])%>" name="pc_added_date" placeholder=""  id="pc_added_date" title="<%$this->lang->line('COMMENT_REPLIES_ADDED_DATE')%>"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                                    <span class='add-on text-addon date-time-append-class icomoon-icon-calendar'></span>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pc_added_dateErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pc_modified_date">
                                            <label class="form-label span3 ">
                                                <%$form_config['pc_modified_date']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%> ">
                                                <%if $mode eq "Update"%>
                                                    <input type="hidden" name="pc_modified_date" id="pc_modified_date" value="<%$this->general->dateTimeSystemFormat($data['pc_modified_date'])%>" class="ignore-valid view-label-only"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                                                    <%assign var="display_date_time" value=$this->general->dateTimeSystemFormat($data['pc_modified_date'])%>
                                                    <strong>
                                                        <%if $display_date_time neq ""%>
                                                            <%$display_date_time%>
                                                        <%else%>
                                                        <%/if%>
                                                    </strong>
                                                <%else%>
                                                    <input type="text" value="<%$this->general->dateTimeSystemFormat($data['pc_modified_date'])%>" name="pc_modified_date" placeholder=""  id="pc_modified_date" title="<%$this->lang->line('COMMENT_REPLIES_MODIFIED_DATE')%>"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                                    <span class='add-on text-addon date-time-append-class icomoon-icon-calendar'></span>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pc_modified_dateErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_pc_status">
                                            <label class="form-label span3 ">
                                                <%$form_config['pc_status']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['pc_status']%>
                                                <%$this->dropdown->display("pc_status","pc_status","  title='<%$this->lang->line('COMMENT_REPLIES_STATUS')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'COMMENT_REPLIES_STATUS')%>'  ", "|||", "", $opt_selected,"pc_status")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='pc_statusErr'></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="frm-bot-btn <%$rl_theme_arr['frm_stand_action_bar']%> <%$rl_theme_arr['frm_stand_action_btn']%>">
                                <%if $rl_theme_arr['frm_stand_ctrls_view'] eq 'No'%>
                                    <%assign var='rm_ctrl_directions' value=true%>
                                <%/if%>
                                <%include file="comment_replies_add_buttons.tpl"%>
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
<%$this->js->add_js('admin/comment_replies_add_js.js')%>

<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
<%javascript%>
    Project.modules.comment_replies.callEvents();
<%/javascript%>
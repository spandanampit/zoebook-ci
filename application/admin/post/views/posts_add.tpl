<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-form-container">
    <%include file="posts_add_strip.tpl"%>
    <div class="<%$module_name%>" data-form-name="<%$module_name%>">
        <div id="ajax_content_div" class="ajax-content-div top-frm-tab-spacing" >
            <input type="hidden" id="projmod" name="projmod" value="posts" />
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Module Tabs & Top Detail View -->
            <div class="top-frm-tab-layout" id="top_frm_tab_layout">
                <!-- Relational Module Tabs -->
                <div id="ad_form_outertab" class="module-navigation-tabs">
                    <%if $tabing_allow eq true%>
                        <%include file="posts_tabs.tpl" %>
                    <%/if%>
                </div>
            </div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content top-block-spacing top-frm-block-spacing">
                <div id="posts" class="frm-module-block frm-elem-block frm-stand-view">
                    <!-- Module Form Block -->
                    <form name="frmaddupdate" id="frmaddupdate" action="<%$admin_url%><%$mod_enc_url['add_action']%>?<%$extra_qstr%>" method="post"  enctype="multipart/form-data">
                        <!-- Form Hidden Fields Unit -->
                        <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                        <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                        <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                        <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                        <input type="hidden" id="draft_uniq_id" name="draft_uniq_id" value="<%$draft_uniq_id%>" />
                        <input type="hidden" id="extra_hstr" name="extra_hstr" value="<%$extra_hstr%>" />
                        <input type="hidden" name="like_count" id="like_count" value="<%$data['like_count']|@htmlentities%>"  class='ignore-valid ' />
                        <input type="hidden" name="comment_count" id="comment_count" value="<%$data['comment_count']|@htmlentities%>"  class='ignore-valid ' />
                        <input type="hidden" name="p_draft" id="p_draft" value="<%$data['p_draft']%>"  class='ignore-valid ' />
                        <input type="hidden" name="p_actual_post_id" id="p_actual_post_id" value="<%$data['p_actual_post_id']|@htmlentities%>"  class='ignore-valid ' />
                        <!-- Form Dispaly Fields Unit -->
                        <div class="main-content-block popup-content" id="main_content_block">
                            <div style="width:98%" class="frm-block-layout pad-calc-container">
                                <div class="box gradient <%$rl_theme_arr['frm_stand_content_row']%> <%$rl_theme_arr['frm_stand_border_view']%>">
                                    <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('POSTS_POSTS')%></h4></div>
                                    <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                        <div class="form-row row-fluid " id="cc_sh_p_user_id">
                                            <label class="form-label span3 ">
                                                <%$form_config['p_user_id']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                <%assign var="opt_selected" value=$data['p_user_id']%>
                                                <%if $mode eq "Update"%>
                                                    <input type="hidden" name="p_user_id" id="p_user_id" value="<%$data['p_user_id']%>" class="ignore-valid"/>
                                                    <%assign var="combo_arr" value=$opt_arr["p_user_id"]%>
                                                    <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                    <span class="frm-data-label">
                                                        <strong>
                                                            <%if $opt_display neq ""%>
                                                                <%$opt_display%>
                                                            <%else%>
                                                            <%/if%>
                                                        </strong></span>
                                                    <%else%>
                                                        <%$this->dropdown->display("p_user_id","p_user_id","  title='<%$this->lang->line('POSTS_POSTED_BY')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'POSTS_POSTED_BY')%>'  ", "|||", "", $opt_selected,"p_user_id")%>
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='p_user_idErr'></label></div>
                                            </div>
                                            <div class="form-row row-fluid " id="cc_sh_p_post_type">
                                                <label class="form-label span3 ">
                                                    <%$form_config['p_post_type']['label_lang']%>
                                                </label> 
                                                <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                    <%assign var="opt_selected" value=$data['p_post_type']%>
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" name="p_post_type" id="p_post_type" value="<%$data['p_post_type']%>" class="ignore-valid"/>
                                                        <%assign var="combo_arr" value=$opt_arr["p_post_type"]%>
                                                        <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $opt_display neq ""%>
                                                                    <%$opt_display%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong></span>
                                                        <%else%>
                                                            <%$this->dropdown->display("p_post_type","p_post_type","  title='<%$this->lang->line('POSTS_POST_TYPE')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'POSTS_POST_TYPE')%>'  ", "|||", "", $opt_selected,"p_post_type")%>
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='p_post_typeErr'></label></div>
                                                </div>
                                                <div class="form-row row-fluid " id="cc_sh_p_post_text">
                                                    <label class="form-label span3 ">
                                                        <%$form_config['p_post_text']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                        <%if $mode eq "Update"%>
                                                            <textarea style="display:none;" class="ignore-valid" name="p_post_text" id="p_post_text"><%$data['p_post_text']%></textarea>
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $data['p_post_text'] neq ""%>
                                                                        <%$data['p_post_text']%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong></span>
                                                            <%else%>
                                                                <textarea placeholder=""  name="p_post_text" id="p_post_text" title="<%$this->lang->line('POSTS_POST_TEXT')%>"  data-ctrl-type='textarea'  class='elastic frm-size-medium'  ><%$data['p_post_text']%></textarea>
                                                            <%/if%>
                                                        </div>
                                                        <div class="error-msg-form "><label class='error' id='p_post_textErr'></label></div>
                                                    </div>
                                                    <div class="form-row row-fluid " id="cc_sh_p_visibility">
                                                        <label class="form-label span3 ">
                                                            <%$form_config['p_visibility']['label_lang']%>
                                                        </label> 
                                                        <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                            <%assign var="opt_selected" value=$data['p_visibility']%>
                                                            <%if $mode eq "Update"%>
                                                                <input type="hidden" name="p_visibility" id="p_visibility" value="<%$data['p_visibility']%>" class="ignore-valid"/>
                                                                <%assign var="combo_arr" value=$opt_arr["p_visibility"]%>
                                                                <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                                <span class="frm-data-label">
                                                                    <strong>
                                                                        <%if $opt_display neq ""%>
                                                                            <%$opt_display%>
                                                                        <%else%>
                                                                        <%/if%>
                                                                    </strong></span>
                                                                <%else%>
                                                                    <%$this->dropdown->display("p_visibility","p_visibility","  title='<%$this->lang->line('POSTS_VISIBILITY')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'POSTS_VISIBILITY')%>'  ", "|||", "", $opt_selected,"p_visibility")%>
                                                                <%/if%>
                                                            </div>
                                                            <div class="error-msg-form "><label class='error' id='p_visibilityErr'></label></div>
                                                        </div>
                                                        <div class="form-row row-fluid " id="cc_sh_p_impression_count">
                                                            <label class="form-label span3 ">
                                                                <%$form_config['p_impression_count']['label_lang']%>
                                                            </label> 
                                                            <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                                <%if $mode eq "Update"%>
                                                                    <input type="hidden" class="ignore-valid" name="p_impression_count" id="p_impression_count" value="<%$data['p_impression_count']|@htmlentities%>" />
                                                                    <span class="frm-data-label">
                                                                        <strong>
                                                                            <%if $data['p_impression_count'] neq ""%>
                                                                                <%$data['p_impression_count']%>
                                                                            <%else%>
                                                                            <%/if%>
                                                                        </strong></span>
                                                                    <%else%>
                                                                        <input type="text" placeholder="" value="<%$data['p_impression_count']|@htmlentities%>" name="p_impression_count" id="p_impression_count" title="<%$this->lang->line('POSTS_IMPRESSION_COUNT')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                                    <%/if%>
                                                                </div>
                                                                <div class="error-msg-form "><label class='error' id='p_impression_countErr'></label></div>
                                                            </div>
                                                            <div class="form-row row-fluid " id="cc_sh_p_added_date">
                                                                <label class="form-label span3 ">
                                                                    <%$form_config['p_added_date']['label_lang']%>
                                                                </label> 
                                                                <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%> ">
                                                                    <%if $mode eq "Update"%>
                                                                        <input type="hidden" name="p_added_date" id="p_added_date" value="<%$this->general->dateTimeSystemFormat($data['p_added_date'])%>" class="ignore-valid view-label-only"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                                                                        <%assign var="display_date_time" value=$this->general->dateTimeSystemFormat($data['p_added_date'])%>
                                                                        <span class="frm-data-label">
                                                                            <strong>
                                                                                <%if $display_date_time neq ""%>
                                                                                    <%$display_date_time%>
                                                                                <%else%>
                                                                                <%/if%>
                                                                            </strong></span>
                                                                        <%else%>
                                                                            <input type="text" value="<%$this->general->dateTimeSystemFormat($data['p_added_date'])%>" name="p_added_date" placeholder=""  id="p_added_date" title="<%$this->lang->line('POSTS_ADDED_DATE')%>"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                                                            <span class='add-on text-addon date-time-append-class icomoon-icon-calendar'></span>
                                                                        <%/if%>
                                                                    </div>
                                                                    <div class="error-msg-form "><label class='error' id='p_added_dateErr'></label></div>
                                                                </div>
                                                                <div class="form-row row-fluid " id="cc_sh_p_modified_date">
                                                                    <label class="form-label span3 ">
                                                                        <%$form_config['p_modified_date']['label_lang']%>
                                                                    </label> 
                                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%> ">
                                                                        <%if $mode eq "Update"%>
                                                                            <input type="hidden" name="p_modified_date" id="p_modified_date" value="<%$this->general->dateTimeSystemFormat($data['p_modified_date'])%>" class="ignore-valid view-label-only"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                                                                            <%assign var="display_date_time" value=$this->general->dateTimeSystemFormat($data['p_modified_date'])%>
                                                                            <span class="frm-data-label">
                                                                                <strong>
                                                                                    <%if $display_date_time neq ""%>
                                                                                        <%$display_date_time%>
                                                                                    <%else%>
                                                                                    <%/if%>
                                                                                </strong></span>
                                                                            <%else%>
                                                                                <input type="text" value="<%$this->general->dateTimeSystemFormat($data['p_modified_date'])%>" name="p_modified_date" placeholder=""  id="p_modified_date" title="<%$this->lang->line('POSTS_MODIFIED_DATE')%>"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                                                                <span class='add-on text-addon date-time-append-class icomoon-icon-calendar'></span>
                                                                            <%/if%>
                                                                        </div>
                                                                        <div class="error-msg-form "><label class='error' id='p_modified_dateErr'></label></div>
                                                                    </div>
                                                                    <div class="form-row row-fluid " id="cc_sh_p_status">
                                                                        <label class="form-label span3 ">
                                                                            <%$form_config['p_status']['label_lang']%> <em>*</em> 
                                                                        </label> 
                                                                        <div class="form-right-div  ">
                                                                            <%assign var="opt_selected" value=$data['p_status']%>
                                                                            <%$this->dropdown->display("p_status","p_status","  title='<%$this->lang->line('POSTS_STATUS')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'POSTS_STATUS')%>'  ", "|||", "", $opt_selected,"p_status")%>
                                                                        </div>
                                                                        <div class="error-msg-form "><label class='error' id='p_statusErr'></label></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear"></div>
                                                        <div class="frm-bot-btn <%$rl_theme_arr['frm_stand_action_bar']%> <%$rl_theme_arr['frm_stand_action_btn']%> popup-footer">
                                                            <%if $rl_theme_arr['frm_stand_ctrls_view'] eq 'No'%>
                                                                <%assign var='rm_ctrl_directions' value=true%>
                                                            <%/if%>
                                                            <%include file="posts_add_buttons.tpl"%>
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
<%$this->js->add_js('admin/posts_add_js.js')%>

<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
<%javascript%>
    Project.modules.posts.callEvents();
<%/javascript%>
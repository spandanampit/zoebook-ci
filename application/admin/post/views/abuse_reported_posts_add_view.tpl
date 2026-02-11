<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-view-container">
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
                <!-- Module View Block -->
                <div id="abuse_reported_posts" class="frm-module-block frm-view-block frm-stand-view">
                    <!-- Form Hidden Fields Unit -->
                    <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                    <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                    <input type="hidden" id="ctrl_flow" name="ctrl_flow" value="<%$ctrl_flow%>" />
                    <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                    <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                    <input type="hidden" name="pra_post_comment_id" id="pra_post_comment_id" value="<%$data['pra_post_comment_id']%>"  class='ignore-valid ' />
                    <input type="hidden" name="pra_report_on" id="pra_report_on" value="<%$data['pra_report_on']%>"  class='ignore-valid ' />
                    <input type="hidden" name="pra_modified_date" id="pra_modified_date" value="<%$this->general->dateTimeSystemFormat($data['pra_modified_date'])%>"  class='ignore-valid '  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                    <!-- Form Display Fields Unit -->
                    <div class="main-content-block" id="main_content_block">
                        <div style="width:98%;" class="frm-block-layout pad-calc-container">
                            <div class="box gradient <%$rl_theme_arr['frm_stand_content_row']%> <%$rl_theme_arr['frm_stand_border_view']%>">
                                <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('ABUSE_REPORTED_POSTS_ABUSE_REPORTED_POSTS')%></h4></div>
                                <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                    <div class="form-row row-fluid " id="cc_sh_pra_post_id">
                                        <label class="form-label span3">
                                            <%$form_config['pra_post_id']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>">
                                            <strong><%$this->general->displayKeyValueData($data['pra_post_id'], $opt_arr['pra_post_id'])%></strong>
                                        </div>
                                    </div>
                                    <div class="form-row row-fluid " id="cc_sh_pra_report_notes">
                                        <label class="form-label span3">
                                            <%$form_config['pra_report_notes']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>">
                                            <strong><%$data['pra_report_notes']%></strong>
                                        </div>
                                    </div>
                                    <div class="form-row row-fluid " id="cc_sh_pra_reported_by">
                                        <label class="form-label span3">
                                            <%$form_config['pra_reported_by']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>">
                                            <strong><%$this->general->displayKeyValueData($data['pra_reported_by'], $opt_arr['pra_reported_by'])%></strong>
                                        </div>
                                    </div>
                                    <div class="form-row row-fluid " id="cc_sh_pra_added_date">
                                        <label class="form-label span3">
                                            <%$form_config['pra_added_date']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%>">
                                            <strong><%$this->general->dateTimeSystemFormat($data['pra_added_date'])%></strong>
                                        </div>
                                    </div>
                                    <div class="form-row row-fluid " id="cc_sh_pra_status">
                                        <label class="form-label span3">
                                            <%$form_config['pra_status']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div ">
                                            <strong><%$this->general->displayKeyValueData($data['pra_status'], $opt_arr['pra_status'])%></strong>
                                        </div>
                                    </div>
                                    <div class="form-row row-fluid " id="cc_sh_pra_type">
                                        <label class="form-label span3">
                                            <%$form_config['pra_type']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div ">
                                            <strong><%$this->general->displayKeyValueData($data['pra_type'], $opt_arr['pra_type'])%></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

    callSwitchToSelf();
<%/javascript%>

<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 

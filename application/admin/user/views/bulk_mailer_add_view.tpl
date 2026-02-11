<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-view-container">
    <%include file="bulk_mailer_add_strip.tpl"%>
    <div class="<%$module_name%>" data-form-name="<%$module_name%>">
        <div id="ajax_content_div" class="ajax-content-div top-frm-spacing" >
            <input type="hidden" id="projmod" name="projmod" value="bulk_mailer" />
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Module Tabs & Top Detail View -->
            <div class="top-frm-tab-layout" id="top_frm_tab_layout">
            </div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content popup-content top-block-spacing ">
                <!-- Module View Block -->
                <div id="bulk_mailer" class="frm-module-block frm-view-block frm-stand-view">
                    <!-- Form Hidden Fields Unit -->
                    <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                    <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                    <input type="hidden" id="ctrl_flow" name="ctrl_flow" value="<%$ctrl_flow%>" />
                    <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                    <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                    <textarea style="display:none;" name="mlh_massage_body" id="mlh_massage_body"  class='ignore-valid ' ><%$data['mlh_massage_body']%></textarea>
                    <input type="hidden" name="mlh_mail_send_status" id="mlh_mail_send_status" value="<%$data['mlh_mail_send_status']%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_added_date" id="mlh_added_date" value="<%$this->general->dateDefinedFormat('Y-m-d',$data['mlh_added_date'])%>"  class='ignore-valid '  aria-date-format='yy-mm-dd'  aria-format-type='date' />
                    <input type="hidden" name="mlh_mail_sent_date" id="mlh_mail_sent_date" value="<%$this->general->dateDefinedFormat('Y-m-d',$data['mlh_mail_sent_date'])%>"  class='ignore-valid '  aria-date-format='yy-mm-dd'  aria-format-type='date' />
                    <input type="hidden" name="mlh_email_code" id="mlh_email_code" value="<%$data['mlh_email_code']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_frome_name" id="mlh_frome_name" value="<%$data['mlh_frome_name']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_from_email" id="mlh_from_email" value="<%$data['mlh_from_email']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_cc_email" id="mlh_cc_email" value="<%$data['mlh_cc_email']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_email_formate" id="mlh_email_formate" value="<%$data['mlh_email_formate']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_email_subject" id="mlh_email_subject" value="<%$data['mlh_email_subject']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_to_email" id="mlh_to_email" value="<%$data['mlh_to_email']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="mlh_user_name" id="mlh_user_name" value="<%$data['mlh_user_name']|@htmlentities%>"  class='ignore-valid ' />
                    <!-- Form Display Fields Unit -->
                    <div class="main-content-block " id="main_content_block">
                        <div style="width:98%;" class="frm-block-layout pad-calc-container">
                            <div class="box gradient <%$rl_theme_arr['frm_stand_content_row']%> <%$rl_theme_arr['frm_stand_border_view']%>">
                                <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('BULK_MAILER_BULK_MAILER')%></h4></div>
                                <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                    <div class="form-row row-fluid " id="cc_sh_selectusers">
                                        <label class="form-label span3">
                                            <%$form_config['selectusers']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div frm-elements-div">
                                            <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['selectusers'], $opt_arr['selectusers'])%></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-row row-fluid " id="cc_sh_mlh_userid">
                                        <label class="form-label span3">
                                            <%$form_config['mlh_userid']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div ">
                                            <span class="frm-data-label"><strong><%$this->general->displayKeyValueData(explode(",",$data['mlh_userid']), $opt_arr['mlh_userid'])%></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-row row-fluid " id="cc_sh_mlh_email_template_id">
                                        <label class="form-label span3">
                                            <%$form_config['mlh_email_template_id']['label_lang']%>
                                        </label> 
                                        <div class="form-right-div frm-elements-div ">
                                            <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['mlh_email_template_id'], $opt_arr['mlh_email_template_id'])%></strong></span>
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

<%$this->css->add_css("custom/Bulk_Mailer_Add_From.css")%>
<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 

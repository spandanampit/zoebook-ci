<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-view-container">
    <%include file="users_add_strip.tpl"%>
    <div class="<%$module_name%>" data-form-name="<%$module_name%>">
        <div id="ajax_content_div" class="ajax-content-div top-frm-spacing" >
            <input type="hidden" id="projmod" name="projmod" value="users" />
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Module Tabs & Top Detail View -->
            <div class="top-frm-tab-layout" id="top_frm_tab_layout">
            </div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content popup-content top-block-spacing ">
                <!-- Module View Block -->
                <div id="users" class="frm-module-block frm-view-block frm-thclm-view">
                    <!-- Form Hidden Fields Unit -->
                    <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                    <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                    <input type="hidden" id="ctrl_flow" name="ctrl_flow" value="<%$ctrl_flow%>" />
                    <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                    <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                    <input type="hidden" name="u_password" id="u_password" value="<%$data['u_password']%>"  class='ignore-valid ' />
                    <textarea style="display:none;" name="u_about_me" id="u_about_me"  class='ignore-valid ' ><%$data['u_about_me']%></textarea>
                    <input type="hidden" name="u_latitude" id="u_latitude" value="<%$data['u_latitude']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_longtitude" id="u_longtitude" value="<%$data['u_longtitude']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_modified_date" id="u_modified_date" value="<%$this->general->dateDefinedFormat('Y-m-d',$data['u_modified_date'])%>"  class='ignore-valid '  aria-date-format='yy-mm-dd'  aria-format-type='date' />
                    <input type="hidden" name="u_temp_password" id="u_temp_password" value="<%$data['u_temp_password']%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_device_token" id="u_device_token" value="<%$data['u_device_token']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_cover_photo" id="u_cover_photo" value="<%$data['u_cover_photo']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_d_ob" id="u_d_ob" value="<%$this->general->dateDefinedFormat('',$data['u_d_ob'])%>"  class='ignore-valid '  aria-format-type='date' />
                    <input type="hidden" name="u_gender" id="u_gender" value="<%$data['u_gender']%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_cover_ydimention" id="u_cover_ydimention" value="<%$data['u_cover_ydimention']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_cover_video" id="u_cover_video" value="<%$data['u_cover_video']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_apple_id" id="u_apple_id" value="<%$data['u_apple_id']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_vp_update_date" id="u_vp_update_date" value="<%$this->general->dateDefinedFormat('',$data['u_vp_update_date'])%>"  class='ignore-valid '  aria-format-type='date' />
                    <input type="hidden" name="u_my_feed_update_date" id="u_my_feed_update_date" value="<%$this->general->dateDefinedFormat('',$data['u_my_feed_update_date'])%>"  class='ignore-valid '  aria-format-type='date' />
                    <input type="hidden" name="u_cv_height" id="u_cv_height" value="<%$data['u_cv_height']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_cv_width" id="u_cv_width" value="<%$data['u_cv_width']|@htmlentities%>"  class='ignore-valid ' />
                    <input type="hidden" name="u_unsubscribe_reasons_id" id="u_unsubscribe_reasons_id" value="<%$data['u_unsubscribe_reasons_id']%>"  class='ignore-valid ' />
                    <!-- Form Display Fields Unit -->
                    <div class="main-content-block " id="main_content_block">
                        <div style="width:98%;" class="frm-block-layout pad-calc-container">
                            <div class="box gradient <%$rl_theme_arr['frm_twclm_content_row']%> <%$rl_theme_arr['frm_twclm_border_view']%>">
                                <div class="title <%$rl_theme_arr['frm_twclm_titles_bar']%>"><h4><%$this->lang->line('USERS_USERS')%></h4></div>
                                <div class="content two-column-block <%$rl_theme_arr['frm_twclm_label_align']%>">
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_sys_static_field_1"> <div class="form-right-div frm-elements-div form-static-div"><span style="font-size:19px; color:#000; border-bottom:1px solid #dadada; display:block; overflow:hidden; padding-bottom:10px; margin-bottom:15px;">Personal Details</span></div></div><div class="two-block-view " id="cc_sh_sys_static_field_2"> <div class="form-right-div frm-elements-div form-static-div"><span style="font-size:19px; color:#000; border-bottom:1px solid #dadada; display:block; overflow:hidden; padding-bottom:10px; margin-bottom:15px;">App Settings</span></div></div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_profile_image"> 
                                            <label class="form-label span3"><%$form_config['u_profile_image']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <%$img_html['u_profile_image']%>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_notification_pref"> 
                                            <label class="form-label span3"><%$form_config['u_notification_pref']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div frm-elements-div" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['u_notification_pref'], $opt_arr['u_notification_pref'])%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_name"> 
                                            <label class="form-label span3"><%$form_config['u_name']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$data['u_name']%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_privacy"> 
                                            <label class="form-label span3"><%$form_config['u_privacy']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div frm-elements-div" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['u_privacy'], $opt_arr['u_privacy'])%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_email"> 
                                            <label class="form-label span3"><%$form_config['u_email']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$data['u_email']%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_device_type"> 
                                            <label class="form-label span3"><%$form_config['u_device_type']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['u_device_type'], $opt_arr['u_device_type'])%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_facebook_id"> 
                                            <label class="form-label span3"><%$form_config['u_facebook_id']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$data['u_facebook_id']%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_device_name"> 
                                            <label class="form-label span3"><%$form_config['u_device_name']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$data['u_device_name']%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_google_id"> 
                                            <label class="form-label span3"><%$form_config['u_google_id']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$data['u_google_id']%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_device_os"> 
                                            <label class="form-label span3"><%$form_config['u_device_os']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$data['u_device_os']%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_phone"> 
                                            <label class="form-label span3"><%$form_config['u_phone']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->getPhoneMaskedView($this->general->getAdminPHPFormats('phone'),$data['u_phone'])%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_app_version"> 
                                            <label class="form-label span3"><%$form_config['u_app_version']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$data['u_app_version']%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_email_verified"> 
                                            <label class="form-label span3"><%$form_config['u_email_verified']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div frm-elements-div" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['u_email_verified'], $opt_arr['u_email_verified'])%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_added_date"> 
                                            <label class="form-label span3"><%$form_config['u_added_date']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->dateTimeSystemFormat($data['u_added_date'])%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_status"> 
                                            <label class="form-label span3"><%$form_config['u_status']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div " style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['u_status'], $opt_arr['u_status'])%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view " id="cc_sh_u_last_login"> 
                                            <label class="form-label span3"><%$form_config['u_last_login']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%>" style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->dateTimeSystemFormat($data['u_last_login'])%></strong></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column-view-parent form-row row-fluid">
                                        <div class="two-block-view " id="cc_sh_u_subscribe_email"> 
                                            <label class="form-label span3"><%$form_config['u_subscribe_email']['label_lang']%></label>
                                            <div class="form-right-div frm-elements-div " style="width:60%!important">
                                                <span class="frm-data-label"><strong><%$this->general->displayKeyValueData($data['u_subscribe_email'], $opt_arr['u_subscribe_email'])%></strong></span>
                                            </div>
                                        </div>
                                        <div class="two-block-view tab-focus-element">&nbsp;</div>
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

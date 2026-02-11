<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-form-container">
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
                <div id="users" class="frm-module-block frm-elem-block frm-thclm-view">
                    <!-- Module Form Block -->
                    <form name="frmaddupdate" id="frmaddupdate" action="<%$admin_url%><%$mod_enc_url['add_action']%>?<%$extra_qstr%>" method="post"  enctype="multipart/form-data">
                        <!-- Form Hidden Fields Unit -->
                        <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                        <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                        <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                        <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                        <input type="hidden" id="draft_uniq_id" name="draft_uniq_id" value="<%$draft_uniq_id%>" />
                        <input type="hidden" id="extra_hstr" name="extra_hstr" value="<%$extra_hstr%>" />
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
                        <!-- Form Dispaly Fields Unit -->
                        <div class="main-content-block " id="main_content_block">
                            <div style="width:98%" class="frm-block-layout pad-calc-container">
                                <div class="box gradient <%$rl_theme_arr['frm_twclm_content_row']%> <%$rl_theme_arr['frm_twclm_border_view']%>">
                                    <div class="title <%$rl_theme_arr['frm_twclm_titles_bar']%>"><h4><%$this->lang->line('USERS_USERS')%></h4></div>
                                    <div class="content two-column-block tab-focus-parent <%$rl_theme_arr['frm_twclm_label_align']%>">
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_sys_static_field_1"> <div class="form-right-div form-static-div"><span style="font-size:19px; color:#000; border-bottom:1px solid #dadada; display:block; overflow:hidden; padding-bottom:10px; margin-bottom:15px;">Personal Details</span></div></div><div class="two-block-view tab-focus-element " id="cc_sh_sys_static_field_2"> <div class="form-right-div form-static-div"><span style="font-size:19px; color:#000; border-bottom:1px solid #dadada; display:block; overflow:hidden; padding-bottom:10px; margin-bottom:15px;">App Settings</span></div></div>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_profile_image"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_profile_image']['label_lang']%>
                                                </label> 
                                                <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                    <%if $mode eq "Add"%>
                                                        <div  class='btn-uploadify frm-size-medium' >
                                                            <input type="hidden" value="<%$data['u_profile_image']%>" name="old_u_profile_image" id="old_u_profile_image" />
                                                            <input type="hidden" value="<%$data['u_profile_image']%>" name="u_profile_image" id="u_profile_image"  aria-extensions="gif,png,jpg,jpeg,jpe,bmp,ico" aria-valid-size="<%$this->lang->line('GENERIC_LESS_THAN')%> (<) 100 MB"/>
                                                            <input type="hidden" value="<%$data['u_profile_image']%>" name="temp_u_profile_image" id="temp_u_profile_image"  />
                                                            <div id="upload_drop_zone_u_profile_image" class="upload-drop-zone"></div>
                                                            <div class="uploader upload-src-zone">
                                                                <input type="file" name="uploadify_u_profile_image" id="uploadify_u_profile_image" title="<%$this->lang->line('USERS_PROFILE_IMAGE')%>" />
                                                                <span class="filename" id="preview_u_profile_image">
                                                                    <%if $data['u_profile_image'] neq ''%>
                                                                        <%$data['u_profile_image']%>
                                                                    <%else%>
                                                                        <%$this->lang->line('GENERIC_DROP_FILES_HERE_OR_CLICK_TO_UPLOAD')%>
                                                                    <%/if%>
                                                                </span>
                                                                <span class="action">Choose File</span>
                                                            </div>
                                                        </div>
                                                    <%else%>    
                                                        <input type="hidden" value="<%$data['u_profile_image']%>" name="u_profile_image" id="u_profile_image"  />
                                                    <%/if%>
                                                    <div class='upload-image-btn'>
                                                        <%$img_html['u_profile_image']%>
                                                    </div>
                                                    <span class="input-comment">
                                                        <a href="javascript://" style="text-decoration: none;" class="tipR" title="<%$this->lang->line('GENERIC_VALID_EXTENSIONS')%> : gif, png, jpg, jpeg, jpe, bmp, ico.<br><%$this->lang->line('GENERIC_VALID_SIZE')%> : <%$this->lang->line('GENERIC_LESS_THAN')%> (<) 100 MB."><span class="icomoon-icon-help"></span></a>
                                                    </span>
                                                    <div class='clear upload-progress' id='progress_u_profile_image'>
                                                        <div class='upload-progress-bar progress progress-striped active'>
                                                            <div class='bar' id='practive_u_profile_image'></div>
                                                        </div>
                                                        <div class='upload-cancel-div'><a class='upload-cancel' href='javascript://'>Cancel</a></div>
                                                        <div class='clear'></div>
                                                    </div>
                                                    <div class='clear'></div>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_profile_imageErr'></label></div>
                                            </div>
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_notification_pref"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_notification_pref']['label_lang']%>
                                                </label> 
                                                <div class="form-right-div frm-elements-div ">
                                                    <%assign var="opt_selected" value=$data['u_notification_pref']%>
                                                    <%assign var="combo_arr" value=$opt_arr["u_notification_pref"]%>
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" name="u_notification_pref" id="u_notification_pref" value="<%$data['u_notification_pref']%>" class="ignore-valid"/>
                                                        <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $opt_display neq ""%>
                                                                    <%$opt_display%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong>
                                                        </span>
                                                    <%else%>
                                                        <%if $combo_arr|@is_array && $combo_arr|@count gt 0 %>
                                                            <%foreach name=i from=$combo_arr item=v key=k%>
                                                                <input type="radio" value="<%$k%>" name="u_notification_pref" id="u_notification_pref_<%$k%>" title="<%$v%>" <%if $opt_selected eq  $k %> checked=true <%/if%>  class='regular-radio'  />
                                                                <label for="u_notification_pref_<%$k%>" class="frm-horizon-row frm-column-layout">&nbsp;</label>
                                                                <label for="u_notification_pref_<%$k%>" class="frm-horizon-row frm-column-layout"><%$v%></label>&nbsp;&nbsp;
                                                            <%/foreach%>
                                                        <%/if%>
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_notification_prefErr'></label></div>
                                            </div>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_name"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_name']['label_lang']%> <em>*</em> 
                                                </label> 
                                                <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" class="ignore-valid" name="u_name" id="u_name" value="<%$data['u_name']|@htmlentities%>" />
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $data['u_name'] neq ""%>
                                                                    <%$data['u_name']%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong>
                                                        </span>
                                                    <%else%>
                                                        <input type="text" placeholder="" value="<%$data['u_name']|@htmlentities%>" name="u_name" id="u_name" title="<%$this->lang->line('USERS_NAME')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_nameErr'></label></div>
                                            </div>
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_privacy"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_privacy']['label_lang']%>
                                                </label> 
                                                <div class="form-right-div frm-elements-div ">
                                                    <%assign var="opt_selected" value=$data['u_privacy']%>
                                                    <%assign var="combo_arr" value=$opt_arr["u_privacy"]%>
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" name="u_privacy" id="u_privacy" value="<%$data['u_privacy']%>" class="ignore-valid"/>
                                                        <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $opt_display neq ""%>
                                                                    <%$opt_display%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong>
                                                        </span>
                                                    <%else%>
                                                        <%if $combo_arr|@is_array && $combo_arr|@count gt 0 %>
                                                            <%foreach name=i from=$combo_arr item=v key=k%>
                                                                <input type="radio" value="<%$k%>" name="u_privacy" id="u_privacy_<%$k%>" title="<%$v%>" <%if $opt_selected eq  $k %> checked=true <%/if%>  class='regular-radio'  />
                                                                <label for="u_privacy_<%$k%>" class="frm-horizon-row frm-column-layout">&nbsp;</label>
                                                                <label for="u_privacy_<%$k%>" class="frm-horizon-row frm-column-layout"><%$v%></label>&nbsp;&nbsp;
                                                            <%/foreach%>
                                                        <%/if%>
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_privacyErr'></label></div>
                                            </div>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_email"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_email']['label_lang']%> <em>*</em> 
                                                </label> 
                                                <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" class="ignore-valid" name="u_email" id="u_email" value="<%$data['u_email']|@htmlentities%>" />
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $data['u_email'] neq ""%>
                                                                    <%$data['u_email']%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong>
                                                        </span>
                                                    <%else%>
                                                        <input type="text" placeholder="" value="<%$data['u_email']|@htmlentities%>" name="u_email" id="u_email" title="<%$this->lang->line('USERS_EMAIL')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_emailErr'></label></div>
                                            </div>
                                            <%if $mode eq "Update"%>
                                                <div class="two-block-view tab-focus-element " id="cc_sh_u_device_type"> 
                                                    <label class="form-label span3 ">
                                                        <%$form_config['u_device_type']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                        <%assign var="opt_selected" value=$data['u_device_type']%>
                                                        <%if $mode eq "Update"%>
                                                            <input type="hidden" name="u_device_type" id="u_device_type" value="<%$data['u_device_type']%>" class="ignore-valid"/>
                                                            <%assign var="combo_arr" value=$opt_arr["u_device_type"]%>
                                                            <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $opt_display neq ""%>
                                                                        <%$opt_display%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong>
                                                            </span>
                                                        <%else%>
                                                            <%$this->dropdown->display("u_device_type","u_device_type","  title='<%$this->lang->line('USERS_DEVICE_TYPE')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'USERS_DEVICE_TYPE')%>'  ", "|||", "", $opt_selected,"u_device_type")%>
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='u_device_typeErr'></label></div>
                                                </div>
                                            <%else%>
                                                <input type="hidden" name="u_device_type" id="u_device_type" value="<%$data['u_device_type']%>"  class='ignore-valid'  />
                                            <%/if%>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <%if $mode eq "Update"%>
                                                <div class="two-block-view tab-focus-element " id="cc_sh_u_facebook_id"> 
                                                    <label class="form-label span3 ">
                                                        <%$form_config['u_facebook_id']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                        <%if $mode eq "Update"%>
                                                            <input type="hidden" class="ignore-valid" name="u_facebook_id" id="u_facebook_id" value="<%$data['u_facebook_id']|@htmlentities%>" />
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $data['u_facebook_id'] neq ""%>
                                                                        <%$data['u_facebook_id']%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong>
                                                            </span>
                                                        <%else%>
                                                            <input type="text" placeholder="" value="<%$data['u_facebook_id']|@htmlentities%>" name="u_facebook_id" id="u_facebook_id" title="<%$this->lang->line('USERS_FACEBOOK_ID')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='u_facebook_idErr'></label></div>
                                                </div>
                                            <%else%>
                                                <input type="hidden" name="u_facebook_id" id="u_facebook_id" value="<%$data['u_facebook_id']|@htmlentities%>"  class='ignore-valid'  />
                                            <%/if%>
                                            <%if $mode eq "Update"%>
                                                <div class="two-block-view tab-focus-element " id="cc_sh_u_device_name"> 
                                                    <label class="form-label span3 ">
                                                        <%$form_config['u_device_name']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                        <%if $mode eq "Update"%>
                                                            <input type="hidden" class="ignore-valid" name="u_device_name" id="u_device_name" value="<%$data['u_device_name']|@htmlentities%>" />
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $data['u_device_name'] neq ""%>
                                                                        <%$data['u_device_name']%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong>
                                                            </span>
                                                        <%else%>
                                                            <input type="text" placeholder="" value="<%$data['u_device_name']|@htmlentities%>" name="u_device_name" id="u_device_name" title="<%$this->lang->line('USERS_DEVICE_NAME')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='u_device_nameErr'></label></div>
                                                </div>
                                            <%else%>
                                                <input type="hidden" name="u_device_name" id="u_device_name" value="<%$data['u_device_name']|@htmlentities%>"  class='ignore-valid'  />
                                            <%/if%>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <%if $mode eq "Update"%>
                                                <div class="two-block-view tab-focus-element " id="cc_sh_u_google_id"> 
                                                    <label class="form-label span3 ">
                                                        <%$form_config['u_google_id']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                        <%if $mode eq "Update"%>
                                                            <input type="hidden" class="ignore-valid" name="u_google_id" id="u_google_id" value="<%$data['u_google_id']|@htmlentities%>" />
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $data['u_google_id'] neq ""%>
                                                                        <%$data['u_google_id']%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong>
                                                            </span>
                                                        <%else%>
                                                            <input type="text" placeholder="" value="<%$data['u_google_id']|@htmlentities%>" name="u_google_id" id="u_google_id" title="<%$this->lang->line('USERS_GOOGLE_ID')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='u_google_idErr'></label></div>
                                                </div>
                                            <%else%>
                                                <input type="hidden" name="u_google_id" id="u_google_id" value="<%$data['u_google_id']|@htmlentities%>"  class='ignore-valid'  />
                                            <%/if%>
                                            <%if $mode eq "Update"%>
                                                <div class="two-block-view tab-focus-element " id="cc_sh_u_device_os"> 
                                                    <label class="form-label span3 ">
                                                        <%$form_config['u_device_os']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                        <%if $mode eq "Update"%>
                                                            <input type="hidden" class="ignore-valid" name="u_device_os" id="u_device_os" value="<%$data['u_device_os']|@htmlentities%>" />
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $data['u_device_os'] neq ""%>
                                                                        <%$data['u_device_os']%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong>
                                                            </span>
                                                        <%else%>
                                                            <input type="text" placeholder="" value="<%$data['u_device_os']|@htmlentities%>" name="u_device_os" id="u_device_os" title="<%$this->lang->line('USERS_DEVICE_OS')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='u_device_osErr'></label></div>
                                                </div>
                                            <%else%>
                                                <input type="hidden" name="u_device_os" id="u_device_os" value="<%$data['u_device_os']|@htmlentities%>"  class='ignore-valid'  />
                                            <%/if%>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_phone"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_phone']['label_lang']%>
                                                </label> 
                                                <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" name="u_phone" id="u_phone" value="<%$data['u_phone']%>" class="ignore-valid"/>
                                                        <%assign var="display_phone" value=$this->general->getPhoneMaskedView($this->general->getAdminPHPFormats('phone'),$data['u_phone'])%>
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $display_phone neq ""%>
                                                                    <%$display_phone%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong>
                                                        </span>
                                                    <%else%>
                                                        <input type="text" format="<%$this->general->getAdminPHPFormats('phone')%>" value="<%$data['u_phone']%>" name="u_phone" id="u_phone" title="<%$this->lang->line('USERS_PHONE')%>"  data-ctrl-type='phone_number'  class='frm-phone-number frm-size-medium'  style='width:auto;' />
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_phoneErr'></label></div>
                                            </div>
                                            <%if $mode eq "Update"%>
                                                <div class="two-block-view tab-focus-element " id="cc_sh_u_app_version"> 
                                                    <label class="form-label span3 ">
                                                        <%$form_config['u_app_version']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%/if%> ">
                                                        <%if $mode eq "Update"%>
                                                            <input type="hidden" class="ignore-valid" name="u_app_version" id="u_app_version" value="<%$data['u_app_version']|@htmlentities%>" />
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $data['u_app_version'] neq ""%>
                                                                        <%$data['u_app_version']%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong>
                                                            </span>
                                                        <%else%>
                                                            <input type="text" placeholder="" value="<%$data['u_app_version']|@htmlentities%>" name="u_app_version" id="u_app_version" title="<%$this->lang->line('USERS_APP_VERSION')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='u_app_versionErr'></label></div>
                                                </div>
                                            <%else%>
                                                <input type="hidden" name="u_app_version" id="u_app_version" value="<%$data['u_app_version']|@htmlentities%>"  class='ignore-valid'  />
                                            <%/if%>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_email_verified"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_email_verified']['label_lang']%>
                                                </label> 
                                                <div class="form-right-div frm-elements-div ">
                                                    <%assign var="opt_selected" value=$data['u_email_verified']%>
                                                    <%assign var="combo_arr" value=$opt_arr["u_email_verified"]%>
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" name="u_email_verified" id="u_email_verified" value="<%$data['u_email_verified']%>" class="ignore-valid"/>
                                                        <%assign var="opt_display" value=$this->general->displayKeyValueData($opt_selected, $combo_arr)%>
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $opt_display neq ""%>
                                                                    <%$opt_display%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong>
                                                        </span>
                                                    <%else%>
                                                        <%if $combo_arr|@is_array && $combo_arr|@count gt 0 %>
                                                            <%foreach name=i from=$combo_arr item=v key=k%>
                                                                <input type="radio" value="<%$k%>" name="u_email_verified" id="u_email_verified_<%$k%>" title="<%$v%>" <%if $opt_selected eq  $k %> checked=true <%/if%>  class='regular-radio'  />
                                                                <label for="u_email_verified_<%$k%>" class="frm-horizon-row frm-column-layout">&nbsp;</label>
                                                                <label for="u_email_verified_<%$k%>" class="frm-horizon-row frm-column-layout"><%$v%></label>&nbsp;&nbsp;
                                                            <%/foreach%>
                                                        <%/if%>
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_email_verifiedErr'></label></div>
                                            </div>
                                            <%if $mode eq "Update"%>
                                                <div class="two-block-view tab-focus-element " id="cc_sh_u_added_date"> 
                                                    <label class="form-label span3 ">
                                                        <%$form_config['u_added_date']['label_lang']%>
                                                    </label> 
                                                    <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%> ">
                                                        <%if $mode eq "Update"%>
                                                            <input type="hidden" name="u_added_date" id="u_added_date" value="<%$this->general->dateTimeSystemFormat($data['u_added_date'])%>" class="ignore-valid view-label-only"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                                                            <%assign var="display_date_time" value=$this->general->dateTimeSystemFormat($data['u_added_date'])%>
                                                            <span class="frm-data-label">
                                                                <strong>
                                                                    <%if $display_date_time neq ""%>
                                                                        <%$display_date_time%>
                                                                    <%else%>
                                                                    <%/if%>
                                                                </strong>
                                                            </span>
                                                        <%else%>
                                                            <input type="text" value="<%$this->general->dateTimeSystemFormat($data['u_added_date'])%>" name="u_added_date" placeholder=""  id="u_added_date" title="<%$this->lang->line('USERS_REGISTERED_DATE')%>"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                                            <span class='add-on text-addon date-time-append-class icomoon-icon-calendar'></span>
                                                        <%/if%>
                                                    </div>
                                                    <div class="error-msg-form "><label class='error' id='u_added_dateErr'></label></div>
                                                </div>
                                            <%else%>
                                                <input type="hidden" name="u_added_date" id="u_added_date" value="<%$this->general->dateTimeSystemFormat($data['u_added_date'])%>"  class='ignore-valid'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                            <%/if%>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_status"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_status']['label_lang']%> <em>*</em> 
                                                </label> 
                                                <div class="form-right-div  ">
                                                    <%assign var="opt_selected" value=$data['u_status']%>
                                                    <%$this->dropdown->display("u_status","u_status","  title='<%$this->lang->line('USERS_STATUS')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'USERS_STATUS')%>'  ", "|||", "", $opt_selected,"u_status")%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_statusErr'></label></div>
                                            </div>
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_last_login"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_last_login']['label_lang']%>
                                                </label> 
                                                <div class="form-right-div  <%if $mode eq 'Update'%>frm-elements-div<%else%>input-append text-append-prepend<%/if%> ">
                                                    <%if $mode eq "Update"%>
                                                        <input type="hidden" name="u_last_login" id="u_last_login" value="<%$this->general->dateTimeSystemFormat($data['u_last_login'])%>" class="ignore-valid view-label-only"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime' />
                                                        <%assign var="display_date_time" value=$this->general->dateTimeSystemFormat($data['u_last_login'])%>
                                                        <span class="frm-data-label">
                                                            <strong>
                                                                <%if $display_date_time neq ""%>
                                                                    <%$display_date_time%>
                                                                <%else%>
                                                                <%/if%>
                                                            </strong>
                                                        </span>
                                                    <%else%>
                                                        <input type="text" value="<%$this->general->dateTimeSystemFormat($data['u_last_login'])%>" name="u_last_login" placeholder=""  id="u_last_login" title="<%$this->lang->line('USERS_LAST_LOGIN')%>"  data-ctrl-type='date_and_time'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='<%$this->general->getAdminJSFormats('date_and_time', 'dateFormat')%>'  aria-time-format='<%$this->general->getAdminJSFormats('date_and_time', 'timeFormat')%>'  aria-format-type='datetime'  />
                                                        <span class='add-on text-addon date-time-append-class icomoon-icon-calendar'></span>
                                                    <%/if%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_last_loginErr'></label></div>
                                            </div>
                                        </div>
                                        <div class="column-view-parent form-row row-fluid tab-focus-child">
                                            <div class="two-block-view tab-focus-element " id="cc_sh_u_subscribe_email"> 
                                                <label class="form-label span3 ">
                                                    <%$form_config['u_subscribe_email']['label_lang']%> <em>*</em> 
                                                </label> 
                                                <div class="form-right-div  ">
                                                    <%assign var="opt_selected" value=$data['u_subscribe_email']%>
                                                    <%$this->dropdown->display("u_subscribe_email","u_subscribe_email","  title='<%$this->lang->line('USERS_SUBSCRIBE_EMAIL')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'USERS_SUBSCRIBE_EMAIL')%>'  ", "|||", "", $opt_selected,"u_subscribe_email")%>
                                                </div>
                                                <div class="error-msg-form "><label class='error' id='u_subscribe_emailErr'></label></div>
                                            </div>
                                            <div class="two-block-view tab-focus-element">&nbsp;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="frm-bot-btn <%$rl_theme_arr['frm_twclm_action_bar']%> <%$rl_theme_arr['frm_twclm_action_btn']%> popup-footer">
                                <%if $rl_theme_arr['frm_twclm_ctrls_view'] eq 'No'%>
                                    <%assign var='rm_ctrl_directions' value=true%>
                                <%/if%>
                                <%include file="users_add_buttons.tpl"%>
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
<%$this->js->add_js('admin/users_add_js.js')%>

<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
<%javascript%>
    Project.modules.users.callEvents();
<%/javascript%>
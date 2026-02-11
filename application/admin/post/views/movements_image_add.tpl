<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-form-container">
    <%include file="movements_image_add_strip.tpl"%>
    <div class="<%$module_name%>" data-form-name="<%$module_name%>">
        <div id="ajax_content_div" class="ajax-content-div top-frm-spacing" >
            <input type="hidden" id="projmod" name="projmod" value="movements_image" />
            <!-- Page Loader -->
            <div id="ajax_qLoverlay"></div>
            <div id="ajax_qLbar"></div>
            <!-- Module Tabs & Top Detail View -->
            <div class="top-frm-tab-layout" id="top_frm_tab_layout">
            </div>
            <!-- Middle Content -->
            <div id="scrollable_content" class="scrollable-content popup-content top-block-spacing ">
                <div id="movements_image" class="frm-module-block frm-elem-block frm-stand-view">
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
                                    <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('MOVEMENTS_IMAGE_MOVEMENTS_IMAGE')%></h4></div>
                                    <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                        <div class="form-row row-fluid " id="cc_sh_mi_movements_id">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_movements_id']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['mi_movements_id']%>
                                                <%$this->dropdown->display("mi_movements_id","mi_movements_id","  title='<%$this->lang->line('MOVEMENTS_IMAGE_MOVEMENTS_ID')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'MOVEMENTS_IMAGE_MOVEMENTS_ID')%>'  ", "|||", "", $opt_selected,"mi_movements_id")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_movements_idErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_media_type">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_media_type']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['mi_media_type']%>
                                                <%$this->dropdown->display("mi_media_type","mi_media_type","  title='<%$this->lang->line('MOVEMENTS_IMAGE_MEDIA_TYPE')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'MOVEMENTS_IMAGE_MEDIA_TYPE')%>'  ", "|||", "", $opt_selected,"mi_media_type")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_media_typeErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_upload_file">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_upload_file']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <input type="text" placeholder="" value="<%$data['mi_upload_file']|@htmlentities%>" name="mi_upload_file" id="mi_upload_file" title="<%$this->lang->line('MOVEMENTS_IMAGE_UPLOAD_FILE')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_upload_fileErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_video_tumbnail">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_video_tumbnail']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <input type="text" placeholder="" value="<%$data['mi_video_tumbnail']|@htmlentities%>" name="mi_video_tumbnail" id="mi_video_tumbnail" title="<%$this->lang->line('MOVEMENTS_IMAGE_VIDEO_TUMBNAIL')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_video_tumbnailErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_mheight">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_mheight']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <input type="text" placeholder="" value="<%$data['mi_mheight']|@htmlentities%>" name="mi_mheight" id="mi_mheight" title="<%$this->lang->line('MOVEMENTS_IMAGE_MHEIGHT')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_mheightErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_mwidth">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_mwidth']['label_lang']%>
                                            </label> 
                                            <div class="form-right-div  ">
                                                <input type="text" placeholder="" value="<%$data['mi_mwidth']|@htmlentities%>" name="mi_mwidth" id="mi_mwidth" title="<%$this->lang->line('MOVEMENTS_IMAGE_MWIDTH')%>"  data-ctrl-type='textbox'  class='frm-size-medium'  />
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_mwidthErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_added_date">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_added_date']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  input-append text-append-prepend  ">
                                                <input type="text" value="<%$this->general->dateDefinedFormat('Y-m-d',$data['mi_added_date'])%>" placeholder="" name="mi_added_date" id="mi_added_date" title="<%$this->lang->line('MOVEMENTS_IMAGE_ADDED_DATE')%>"  data-ctrl-type='date'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='yy-mm-dd'  aria-format-type='date'  />
                                                <span class='add-on text-addon date-append-class icomoon-icon-calendar'></span>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_added_dateErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_modified_date">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_modified_date']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  input-append text-append-prepend  ">
                                                <input type="text" value="<%$this->general->dateDefinedFormat('Y-m-d',$data['mi_modified_date'])%>" placeholder="" name="mi_modified_date" id="mi_modified_date" title="<%$this->lang->line('MOVEMENTS_IMAGE_MODIFIED_DATE')%>"  data-ctrl-type='date'  class='frm-datepicker ctrl-append-prepend frm-size-medium'  aria-date-format='yy-mm-dd'  aria-format-type='date'  />
                                                <span class='add-on text-addon date-append-class icomoon-icon-calendar'></span>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_modified_dateErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mi_status">
                                            <label class="form-label span3 ">
                                                <%$form_config['mi_status']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['mi_status']%>
                                                <%$this->dropdown->display("mi_status","mi_status","  title='<%$this->lang->line('MOVEMENTS_IMAGE_STATUS')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'MOVEMENTS_IMAGE_STATUS')%>'  ", "|||", "", $opt_selected,"mi_status")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mi_statusErr'></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="frm-bot-btn <%$rl_theme_arr['frm_stand_action_bar']%> <%$rl_theme_arr['frm_stand_action_btn']%> popup-footer">
                                <%if $rl_theme_arr['frm_stand_ctrls_view'] eq 'No'%>
                                    <%assign var='rm_ctrl_directions' value=true%>
                                <%/if%>
                                <%include file="movements_image_add_buttons.tpl"%>
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
<%$this->js->add_js('admin/movements_image_add_js.js')%>

<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
<%javascript%>
    Project.modules.movements_image.callEvents();
<%/javascript%>
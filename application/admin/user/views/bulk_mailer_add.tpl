<%if $this->input->is_ajax_request()%>
    <%$this->js->clean_js()%>
<%/if%>
<div class="module-form-container">
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
                <div id="bulk_mailer" class="frm-module-block frm-elem-block frm-stand-view">
                    <!-- Module Form Block -->
                    <form name="frmaddupdate" id="frmaddupdate" action="<%$admin_url%><%$mod_enc_url['add_action']%>?<%$extra_qstr%>" method="post"  enctype="multipart/form-data">
                        <!-- Form Hidden Fields Unit -->
                        <input type="hidden" id="id" name="id" value="<%$enc_id%>" />
                        <input type="hidden" id="mode" name="mode" value="<%$mod_enc_mode[$mode]%>" />
                        <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<%$next_prev_records['prev']['id']%>" />
                        <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<%$next_prev_records['next']['id']%>" />
                        <input type="hidden" id="draft_uniq_id" name="draft_uniq_id" value="<%$draft_uniq_id%>" />
                        <input type="hidden" id="extra_hstr" name="extra_hstr" value="<%$extra_hstr%>" />
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
                        <!-- Form Dispaly Fields Unit -->
                        <div class="main-content-block " id="main_content_block">
                            <div style="width:98%" class="frm-block-layout pad-calc-container">
                                <div class="box gradient <%$rl_theme_arr['frm_stand_content_row']%> <%$rl_theme_arr['frm_stand_border_view']%>">
                                    <div class="title <%$rl_theme_arr['frm_stand_titles_bar']%>"><h4><%$this->lang->line('BULK_MAILER_BULK_MAILER')%></h4></div>
                                    <div class="content <%$rl_theme_arr['frm_stand_label_align']%>">
                                        <div class="form-row row-fluid " id="cc_sh_selectusers">
                                            <label class="form-label span3 ">
                                                <%$form_config['selectusers']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div frm-elements-div ">
                                                <%assign var="opt_selected" value=$data['selectusers']%>
                                                <%assign var="combo_arr" value=$opt_arr["selectusers"]%>
                                                <%if $combo_arr|@is_array && $combo_arr|@count gt 0 %>
                                                    <%foreach name=i from=$combo_arr item=v key=k%>
                                                        <input type="radio" value="<%$k%>" name="selectusers" id="selectusers_<%$k%>" title="<%$v%>" <%if $opt_selected eq  $k %> checked=true <%/if%>  class='regular-radio'  />
                                                        <label for="selectusers_<%$k%>" class="frm-horizon-row frm-column-layout">&nbsp;</label>
                                                        <label for="selectusers_<%$k%>" class="frm-horizon-row frm-column-layout"><%$v%></label>&nbsp;&nbsp;
                                                    <%/foreach%>
                                                <%/if%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='selectusersErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mlh_userid">
                                            <label class="form-label span3 ">
                                                <%$form_config['mlh_userid']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="combo_arr" value=$opt_arr["mlh_userid"]%>
                                                <div  data-ctrl-type='autocomplete'  class='frm-token-autocomplete frm-size-medium'  id="autocomp_mlh_userid"><input type="text" aria-token-json='<%$this->general->getTokenKeyValueJSON($data["mlh_userid"], $combo_arr)%>' value="<%$data['mlh_userid']%>" name="mlh_userid" id="mlh_userid" title="<%$this->lang->line('BULK_MAILER_SELECT_USERS')%>"  data-ctrl-type='autocomplete'  class='frm-token-autocomplete frm-size-medium'  /></div>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mlh_useridErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mlh_email_template_id">
                                            <label class="form-label span3 ">
                                                <%$form_config['mlh_email_template_id']['label_lang']%> <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <%assign var="opt_selected" value=$data['mlh_email_template_id']%>
                                                <%$this->dropdown->display("mlh_email_template_id","mlh_email_template_id","  title='<%$this->lang->line('BULK_MAILER_EMAIL_TEMPLATE')%>'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='<%$this->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35' ,'#FIELD#', 'BULK_MAILER_EMAIL_TEMPLATE')%>'  ", "|||", "", $opt_selected,"mlh_email_template_id")%>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mlh_email_template_idErr'></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="frm-bot-btn <%$rl_theme_arr['frm_stand_action_bar']%> <%$rl_theme_arr['frm_stand_action_btn']%> popup-footer">
                                <%if $rl_theme_arr['frm_stand_ctrls_view'] eq 'No'%>
                                    <%assign var='rm_ctrl_directions' value=true%>
                                <%/if%>
                                <%include file="bulk_mailer_add_buttons.tpl"%>
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
    el_form_settings['buttons_arr'] = {
        "custom_btn_add_1": {
            "name": "custom_btn_add_1",
            "confirm": {
                "type": "callback",
                "module": "<%$this->general->getAdminEncodeURL('user\/bulk_mailer')%>",
                "callback": "SendNow"
            }
        },
        "custom_btn_add_2": {
            "name": "custom_btn_add_2",
            "confirm": {
                "type": "callback",
                "module": "<%$this->general->getAdminEncodeURL('user\/bulk_mailer')%>",
                "callback": "SaveNow"
            }
        }
    };
    el_form_settings['message_arr'] = {
        "delete_message" : "<%$this->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO_DELETE_THIS_RECORD_C63')%>",
    };
    
    
    callSwitchToSelf();
<%/javascript%>
<%$this->js->add_js('admin/bulk_mailer_add_js.js')%>

<%$this->css->add_css("custom/Bulk_Mailer_Add_From.css")%>
<%if $this->input->is_ajax_request()%>
    <%$this->js->js_src()%>
<%/if%> 
<%if $this->input->is_ajax_request()%>
    <%$this->css->css_src()%>
<%/if%> 
<%javascript%>
    Project.modules.bulk_mailer.callEvents();
<%/javascript%>
<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:55:14
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/bulk_mailer_add.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c457aa9e1bf8_34134269',
  'file_dependency' => 
  array (
    'c388e9c08397805c2f2a53370ca5b8a09bd29f8a' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/bulk_mailer_add.tpl',
      1 => 1706090549,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:bulk_mailer_add_strip.tpl' => 1,
    'file:bulk_mailer_add_buttons.tpl' => 1,
  ),
),false)) {
function content_65c457aa9e1bf8_34134269 ($_smarty_tpl) {
if (!is_callable('smarty_block_javascript')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/block.javascript.php';
if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->clean_js();?>

<?php }?>
<div class="module-form-container">
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:bulk_mailer_add_strip.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div class="<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
" data-form-name="<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
">
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
                    <form name="frmaddupdate" id="frmaddupdate" action="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['add_action'];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
" method="post"  enctype="multipart/form-data">
                        <!-- Form Hidden Fields Unit -->
                        <input type="hidden" id="id" name="id" value="<?php echo $_smarty_tpl->tpl_vars['enc_id']->value;?>
" />
                        <input type="hidden" id="mode" name="mode" value="<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value[$_smarty_tpl->tpl_vars['mode']->value];?>
" />
                        <input type="hidden" id="ctrl_prev_id" name="ctrl_prev_id" value="<?php echo $_smarty_tpl->tpl_vars['next_prev_records']->value['prev']['id'];?>
" />
                        <input type="hidden" id="ctrl_next_id" name="ctrl_next_id" value="<?php echo $_smarty_tpl->tpl_vars['next_prev_records']->value['next']['id'];?>
" />
                        <input type="hidden" id="draft_uniq_id" name="draft_uniq_id" value="<?php echo $_smarty_tpl->tpl_vars['draft_uniq_id']->value;?>
" />
                        <input type="hidden" id="extra_hstr" name="extra_hstr" value="<?php echo $_smarty_tpl->tpl_vars['extra_hstr']->value;?>
" />
                        <textarea style="display:none;" name="mlh_massage_body" id="mlh_massage_body"  class='ignore-valid ' ><?php echo $_smarty_tpl->tpl_vars['data']->value['mlh_massage_body'];?>
</textarea>
                        <input type="hidden" name="mlh_mail_send_status" id="mlh_mail_send_status" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['mlh_mail_send_status'];?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_added_date" id="mlh_added_date" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->dateDefinedFormat('Y-m-d',$_smarty_tpl->tpl_vars['data']->value['mlh_added_date']);?>
"  class='ignore-valid '  aria-date-format='yy-mm-dd'  aria-format-type='date' />
                        <input type="hidden" name="mlh_mail_sent_date" id="mlh_mail_sent_date" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->dateDefinedFormat('Y-m-d',$_smarty_tpl->tpl_vars['data']->value['mlh_mail_sent_date']);?>
"  class='ignore-valid '  aria-date-format='yy-mm-dd'  aria-format-type='date' />
                        <input type="hidden" name="mlh_email_code" id="mlh_email_code" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_email_code']);?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_frome_name" id="mlh_frome_name" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_frome_name']);?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_from_email" id="mlh_from_email" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_from_email']);?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_cc_email" id="mlh_cc_email" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_cc_email']);?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_email_formate" id="mlh_email_formate" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_email_formate']);?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_email_subject" id="mlh_email_subject" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_email_subject']);?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_to_email" id="mlh_to_email" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_to_email']);?>
"  class='ignore-valid ' />
                        <input type="hidden" name="mlh_user_name" id="mlh_user_name" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['data']->value['mlh_user_name']);?>
"  class='ignore-valid ' />
                        <!-- Form Dispaly Fields Unit -->
                        <div class="main-content-block " id="main_content_block">
                            <div style="width:98%" class="frm-block-layout pad-calc-container">
                                <div class="box gradient <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_stand_content_row'];?>
 <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_stand_border_view'];?>
">
                                    <div class="title <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_stand_titles_bar'];?>
"><h4><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_BULK_MAILER');?>
</h4></div>
                                    <div class="content <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_stand_label_align'];?>
">
                                        <div class="form-row row-fluid " id="cc_sh_selectusers">
                                            <label class="form-label span3 ">
                                                <?php echo $_smarty_tpl->tpl_vars['form_config']->value['selectusers']['label_lang'];?>
 <em>*</em> 
                                            </label> 
                                            <div class="form-right-div frm-elements-div ">
                                                <?php $_smarty_tpl->tpl_vars["opt_selected"] = new Smarty_Variable($_smarty_tpl->tpl_vars['data']->value['selectusers'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "opt_selected", 0);?>
                                                <?php $_smarty_tpl->tpl_vars["combo_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['opt_arr']->value["selectusers"], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "combo_arr", 0);?>
                                                <?php if (is_array($_smarty_tpl->tpl_vars['combo_arr']->value) && count($_smarty_tpl->tpl_vars['combo_arr']->value) > 0) {?>
                                                    <?php
$_from = $_smarty_tpl->tpl_vars['combo_arr']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_i_0_saved_item = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v'] : false;
$__foreach_i_0_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable();
$__foreach_i_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_i_0_total) {
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$__foreach_i_0_saved_local_item = $_smarty_tpl->tpl_vars['v'];
?>
                                                        <input type="radio" value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" name="selectusers" id="selectusers_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['opt_selected']->value == $_smarty_tpl->tpl_vars['k']->value) {?> checked=true <?php }?>  class='regular-radio'  />
                                                        <label for="selectusers_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" class="frm-horizon-row frm-column-layout">&nbsp;</label>
                                                        <label for="selectusers_<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" class="frm-horizon-row frm-column-layout"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</label>&nbsp;&nbsp;
                                                    <?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_i_0_saved_local_item;
}
}
if ($__foreach_i_0_saved_item) {
$_smarty_tpl->tpl_vars['v'] = $__foreach_i_0_saved_item;
}
if ($__foreach_i_0_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_i_0_saved_key;
}
?>
                                                <?php }?>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='selectusersErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mlh_userid">
                                            <label class="form-label span3 ">
                                                <?php echo $_smarty_tpl->tpl_vars['form_config']->value['mlh_userid']['label_lang'];?>
 <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <?php $_smarty_tpl->tpl_vars["combo_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['opt_arr']->value["mlh_userid"], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "combo_arr", 0);?>
                                                <div  data-ctrl-type='autocomplete'  class='frm-token-autocomplete frm-size-medium'  id="autocomp_mlh_userid"><input type="text" aria-token-json='<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getTokenKeyValueJSON($_smarty_tpl->tpl_vars['data']->value["mlh_userid"],$_smarty_tpl->tpl_vars['combo_arr']->value);?>
' value="<?php echo $_smarty_tpl->tpl_vars['data']->value['mlh_userid'];?>
" name="mlh_userid" id="mlh_userid" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SELECT_USERS');?>
"  data-ctrl-type='autocomplete'  class='frm-token-autocomplete frm-size-medium'  /></div>
                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mlh_useridErr'></label></div>
                                        </div>
                                        <div class="form-row row-fluid " id="cc_sh_mlh_email_template_id">
                                            <label class="form-label span3 ">
                                                <?php echo $_smarty_tpl->tpl_vars['form_config']->value['mlh_email_template_id']['label_lang'];?>
 <em>*</em> 
                                            </label> 
                                            <div class="form-right-div  ">
                                                <?php $_smarty_tpl->tpl_vars["opt_selected"] = new Smarty_Variable($_smarty_tpl->tpl_vars['data']->value['mlh_email_template_id'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "opt_selected", 0);?>
                                                <?php echo $_smarty_tpl->tpl_vars['this']->value->dropdown->display("mlh_email_template_id","mlh_email_template_id","  title='".((string)$_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_EMAIL_TEMPLATE'))."'  aria-chosen-valid='Yes'  class='chosen-select frm-size-medium'  data-placeholder='".((string)$_smarty_tpl->tpl_vars['this']->value->general->parseLabelMessage('GENERIC_PLEASE_SELECT__C35FIELD_C35','#FIELD#','BULK_MAILER_EMAIL_TEMPLATE'))."'  ","|||",'',$_smarty_tpl->tpl_vars['opt_selected']->value,"mlh_email_template_id");?>

                                            </div>
                                            <div class="error-msg-form "><label class='error' id='mlh_email_template_idErr'></label></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="frm-bot-btn <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_stand_action_bar'];?>
 <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_stand_action_btn'];?>
 popup-footer">
                                <?php if ($_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_stand_ctrls_view'] == 'No') {?>
                                    <?php $_smarty_tpl->tpl_vars['rm_ctrl_directions'] = new Smarty_Variable(true, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'rm_ctrl_directions', 0);?>
                                <?php }?>
                                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:bulk_mailer_add_buttons.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

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
<?php $_smarty_tpl->smarty->_cache['tag_stack'][] = array('javascript', array()); $_block_repeat=true; echo smarty_block_javascript(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

            
    var el_form_settings = {}, elements_uni_arr = {}, child_rules_arr = {}, google_map_json = {}, pre_cond_code_arr = [];
    el_form_settings['module_name'] = '<?php echo $_smarty_tpl->tpl_vars['module_name']->value;?>
'; 
    el_form_settings['extra_hstr'] = '<?php echo $_smarty_tpl->tpl_vars['extra_hstr']->value;?>
';
    el_form_settings['extra_qstr'] = '<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_form_settings['upload_form_file_url'] = admin_url+"<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['upload_form_file'];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
";
    el_form_settings['get_chosen_auto_complete_url'] = admin_url+"<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['get_chosen_auto_complete'];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
";
    el_form_settings['token_auto_complete_url'] = admin_url+"<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['get_token_auto_complete'];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
";
    el_form_settings['tab_wise_block_url'] = admin_url+"<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['get_tab_wise_block'];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
";
    el_form_settings['parent_source_options_url'] = "<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['parent_source_options'];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
";
    el_form_settings['jself_switchto_url'] =  admin_url+'<?php echo $_smarty_tpl->tpl_vars['switch_cit']->value["url"];?>
';
    el_form_settings['callbacks'] = [];
    
    google_map_json = $.parseJSON('<?php echo json_encode($_smarty_tpl->tpl_vars['google_map_arr']->value);?>
');
    child_rules_arr = {};
            
    <?php if (is_array($_smarty_tpl->tpl_vars['auto_arr']->value) && count($_smarty_tpl->tpl_vars['auto_arr']->value) > 0) {?>
        setTimeout(function(){
            <?php
$_from = $_smarty_tpl->tpl_vars['auto_arr']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_i_1_saved_item = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v'] : false;
$__foreach_i_1_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable();
$__foreach_i_1_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_i_1_total) {
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$__foreach_i_1_saved_local_item = $_smarty_tpl->tpl_vars['v'];
?>
                if($("#<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
").is("select")){
                    $("#<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
").ajaxChosen({
                        dataType: "json",
                        type: "POST",
                        url: el_form_settings.get_chosen_auto_complete_url+"&unique_name=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
&mode=<?php echo $_smarty_tpl->tpl_vars['mod_enc_mode']->value[$_smarty_tpl->tpl_vars['mode']->value];?>
&id=<?php echo $_smarty_tpl->tpl_vars['enc_id']->value;?>
"
                        },{
                        loadingImg: admin_image_url+"chosen-loading.gif"
                    });
                }
            <?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_i_1_saved_local_item;
}
}
if ($__foreach_i_1_saved_item) {
$_smarty_tpl->tpl_vars['v'] = $__foreach_i_1_saved_item;
}
if ($__foreach_i_1_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_i_1_saved_key;
}
?>
        }, 500);
    <?php }?>        
    el_form_settings['jajax_submit_func'] = '';
    el_form_settings['jajax_submit_back'] = '';
    el_form_settings['jajax_action_url'] = '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["add_action"];?>
?<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
';
    el_form_settings['save_as_draft'] = 'No';
    el_form_settings['multi_lingual_trans'] = 'Yes';
    el_form_settings['buttons_arr'] = {
        "custom_btn_add_1": {
            "name": "custom_btn_add_1",
            "confirm": {
                "type": "callback",
                "module": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('user\/bulk_mailer');?>
",
                "callback": "SendNow"
            }
        },
        "custom_btn_add_2": {
            "name": "custom_btn_add_2",
            "confirm": {
                "type": "callback",
                "module": "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('user\/bulk_mailer');?>
",
                "callback": "SaveNow"
            }
        }
    };
    el_form_settings['message_arr'] = {
        "delete_message" : "<?php echo $_smarty_tpl->tpl_vars['this']->value->general->processMessageLabel('ACTION_ARE_YOU_SURE_WANT_TO_DELETE_THIS_RECORD_C63');?>
",
    };
    
    
    callSwitchToSelf();
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_javascript(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_cache['tag_stack']);?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js('admin/bulk_mailer_add_js.js');?>


<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("custom/Bulk_Mailer_Add_From.css");?>

<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src();?>

<?php }?> 
<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<?php }?> 
<?php $_smarty_tpl->smarty->_cache['tag_stack'][] = array('javascript', array()); $_block_repeat=true; echo smarty_block_javascript(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    Project.modules.bulk_mailer.callEvents();
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_javascript(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_cache['tag_stack']);
}
}

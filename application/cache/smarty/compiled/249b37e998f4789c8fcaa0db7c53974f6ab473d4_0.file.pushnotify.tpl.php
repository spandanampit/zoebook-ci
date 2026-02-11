<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:55:30
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/tools/views/pushnotify.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c457ba3d6366_93850612',
  'file_dependency' => 
  array (
    '249b37e998f4789c8fcaa0db7c53974f6ab473d4' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/tools/views/pushnotify.tpl',
      1 => 1706090535,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:pushnotify_strip.tpl' => 1,
  ),
),false)) {
function content_65c457ba3d6366_93850612 ($_smarty_tpl) {
if (!is_callable('smarty_block_javascript')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/block.javascript.php';
if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->clean_js();?>

<?php }?>  
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js('admin/misc/sew/jquery.caretposition.min.js');?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js('admin/misc/sew/jquery.sew.min.js');?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js('admin/admin/js_push_notify.js');?>

<div class='custom-bulkemail-container'>
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:pushnotify_strip.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div id="ajax_content_div" class="ajax-content-div top-frm-spacing">
        <div id="ajax_qLoverlay"></div>
        <div id="ajax_qLbar"></div>
        <div id="scrollable_content" class="scrollable-content">
            <div id="pushnotify" class="frm-elem-block frm-stand-view">
                <form name="frmpushnotifyadd" id="frmpushnotifyadd" action="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['pushnotify_action'];?>
" method="post"  enctype="multipart/form-data">
                    <input type="hidden" id="mode" name="mode" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->input->get_post('mode');?>
">
                    <div class="main-content-block" id="main_content_block">
                        <div style="width:98%" class="frm-block-layout pad-calc-container">
                            <div class="box gradient <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_content_row'];?>
 <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_border_view'];?>
">
                                <div class="title <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_titles_bar'];?>
"><h4><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY');?>
</h4></div>
                                <div class="content <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_label_align'];?>
">
                                    <div class="form-row row-fluid">
                                        <label class="form-label span3"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_SENDTO');?>
 <em>*</em> :</label> 
                                        <div class="form-right-div">
                                            <select id="vSendTo" name="vSendTo" class="frm-size-large chosen-select">
                                                <optgroup label="Other">
                                                    <option selected="selected" value="Other">Other</option>
                                                </optgroup>
                                                <?php if (is_array($_smarty_tpl->tpl_vars['db_module']->value) && count($_smarty_tpl->tpl_vars['db_module']->value) > 0) {?>
                                                    <?php
$_from = $_smarty_tpl->tpl_vars['db_module']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v_0_saved_item = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v'] : false;
$__foreach_v_0_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable();
$__foreach_v_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_v_0_total) {
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$__foreach_v_0_saved_local_item = $_smarty_tpl->tpl_vars['v'];
?>
                                                        <optgroup label="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
">
                                                            <?php
$_from = $_smarty_tpl->tpl_vars['v']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_val_1_saved_item = isset($_smarty_tpl->tpl_vars['val']) ? $_smarty_tpl->tpl_vars['val'] : false;
$__foreach_val_1_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['val'] = new Smarty_Variable();
$__foreach_val_1_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_val_1_total) {
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['val']->value) {
$__foreach_val_1_saved_local_item = $_smarty_tpl->tpl_vars['val'];
?>
                                                                <option value="Mod@@<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                                            <?php
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_1_saved_local_item;
}
}
if ($__foreach_val_1_saved_item) {
$_smarty_tpl->tpl_vars['val'] = $__foreach_val_1_saved_item;
}
if ($__foreach_val_1_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_val_1_saved_key;
}
?>
                                                        </optgroup>
                                                    <?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_0_saved_local_item;
}
}
if ($__foreach_v_0_saved_item) {
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_0_saved_item;
}
if ($__foreach_v_0_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_v_0_saved_key;
}
?>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="error-msg-form" ><label class="error" id="vSendToErr"></label></div>
                                    </div>
                                    <div class="form-row row-fluid" id="div_module_other">
                                        <label class="form-label span3"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_ENTER_DEVICE_ID');?>
 <em>*</em> :</label> 
                                        <div class="form-right-div">
                                            <textarea title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_ENTER_DEVICE_ID');?>
" id="iDeviceId" name="iDeviceId" class="elastic frm-size-large"></textarea>
                                            <a class="tipR" style="text-decoration: none;" href="javascript://" oldtitle="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_HELP_DEVICE_ID');?>
" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_HELP_DEVICE_ID');?>
" aria-describedby="ui-tooltip-2">
                                                <span class="icomoon-icon-help"></span>
                                            </a>
                                        </div>
                                        <div class="error-msg-form"><label class="error" id="iDeviceIdErr"></label></div>
                                    </div>
                                    <div class="form-row row-fluid">
                                        <label class="form-label span3"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_CODE');?>
 <em>*</em> :</label> 
                                        <div class="form-right-div">
                                            <select id="vCode" name="vCode" class="frm-size-large chosen-select">
                                                <?php if (is_array($_smarty_tpl->tpl_vars['db_notify_code']->value) && count($_smarty_tpl->tpl_vars['db_notify_code']->value) > 0) {?>
                                                    <?php
$_from = $_smarty_tpl->tpl_vars['db_notify_code']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v_2_saved_item = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v'] : false;
$__foreach_v_2_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable();
$__foreach_v_2_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_v_2_total) {
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$__foreach_v_2_saved_local_item = $_smarty_tpl->tpl_vars['v'];
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                                    <?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_2_saved_local_item;
}
}
if ($__foreach_v_2_saved_item) {
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_2_saved_item;
}
if ($__foreach_v_2_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_v_2_saved_key;
}
?>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="error-msg-form" ><label class="error" id="vCodeErr"></label></div>
                                    </div>
                                    <div class="form-row row-fluid">
                                        <label class="form-label span3"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_SOUND');?>
 <em>*</em> :</label> 
                                        <div class="form-right-div">
                                            <select id="vSound" name="vSound" class="frm-size-large chosen-select">
                                                <?php if (is_array($_smarty_tpl->tpl_vars['sound_arr']->value) && count($_smarty_tpl->tpl_vars['sound_arr']->value) > 0) {?>
                                                    <?php
$_from = $_smarty_tpl->tpl_vars['sound_arr']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_v_3_saved_item = isset($_smarty_tpl->tpl_vars['v']) ? $_smarty_tpl->tpl_vars['v'] : false;
$__foreach_v_3_saved_key = isset($_smarty_tpl->tpl_vars['k']) ? $_smarty_tpl->tpl_vars['k'] : false;
$_smarty_tpl->tpl_vars['v'] = new Smarty_Variable();
$__foreach_v_3_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_v_3_total) {
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
$__foreach_v_3_saved_local_item = $_smarty_tpl->tpl_vars['v'];
?>
                                                        <option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
                                                    <?php
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_3_saved_local_item;
}
}
if ($__foreach_v_3_saved_item) {
$_smarty_tpl->tpl_vars['v'] = $__foreach_v_3_saved_item;
}
if ($__foreach_v_3_saved_key) {
$_smarty_tpl->tpl_vars['k'] = $__foreach_v_3_saved_key;
}
?>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="error-msg-form" ><label class="error" id="vSoundErr"></label></div>
                                    </div>
                                    <div class="form-row row-fluid">
                                        <label class="form-label span3"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_BADGE');?>
 :</label> 
                                        <div class="form-right-div">
                                            <input type="text" class="frm-size-large"  title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_BADGE');?>
" id="vBadge" value="" name="vBadge">
                                        </div>
                                        <div class="error-msg-form" ><label class="error" id="vBadgeErr"></label></div>
                                    </div>
                                    <div class="form-row row-fluid">
                                        <label class="form-label span3"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_BUTTON_TITLE');?>
 <em>*</em> :</label> 
                                        <div class="form-right-div">
                                            <input type="text" class="frm-size-large"  title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_BUTTON_TITLE');?>
" id="vButtonTitle" value="" name="vButtonTitle">
                                        </div>
                                        <div class="error-msg-form" ><label class="error" id="vButtonTitleErr"></label></div>
                                    </div>
                                    <div class="form-row row-fluid">
                                        <label class="form-label span3"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_MESSAGE');?>
 <em>*</em> :</label> 
                                        <div class="form-right-div">
                                            <textarea title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_MESSAGE');?>
" id="vMessage" name="vMessage" class="elastic frm-size-large"></textarea>
                                            <a class="tipR" style="text-decoration: none;" href="javascript://" oldtitle="Response parameters should be precede and followed by '#' symbol <br> Example:- #field_name#" title="Response parameters should be precede and followed by '#' symbol <br> Example:- #field_name#" aria-describedby="ui-tooltip-2">
                                                <span class="icomoon-icon-help"></span>
                                            </a>
                                        </div>
                                        <div class="error-msg-form" ><label class="error" id="vMessageErr"></label></div>
                                    </div>
                                    <div class="form-row row-fluid">
                                        <div class="box form-child-table">
                                            <div class="title">
                                                <h4>
                                                    <span class="icon12 icomoon-icon-equalizer-2"></span>
                                                    <span><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_VARIABLES');?>
</span>
                                                    <div class="box-addmore right">
                                                        <a onclick="Project.modules.pushnotify.getVariableDescriptionTable()" href="javascript://" class="btn btn-success">
                                                            <span class="icon14 icomoon-icon-plus-2"></span>
                                                            <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_ADD_NEW');?>

                                                        </a>
                                                    </div>
                                                </h4>
                                                <a style="display: none;" class="minimize" href="javascript://"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_MINIMIZE');?>
</a>
                                            </div>
                                            <div class="content noPad push-notify-vars">
                                                <table id="tbl_child_module" class="responsive table table-bordered">
                                                    <thead>    
                                                        <tr>
                                                            <th width='3%'>#</th>
                                                            <th width='25%'><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_VARIABLES');?>
</th>
                                                            <th width='50%'><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_DESCRIPTION');?>
</th>
                                                            <th width='12%'><div align="center"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_COMPULSORY');?>
</div></th>
                                                            <th width='10%'><div align="center"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_ACTIONS');?>
</div></th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <table width="100%" border="0" cellpadding='0' cellspacing="0">
                                                    <tr>
                                                        <td id='mails_fields_list'>
                                                            <table width='100%' cellspacing='0' cellpadding='0' border="0" class="responsive table table-bordered field-sortable">
                                                                <tr id="tr_child_row_0">
                                                                    <td class="row-num-child" width='3%'>1</td>
                                                                    <td width='25%'>
                                                                        <div class="">                                                                    
                                                                            <input type="text" class="frm-size-large valid-variable" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_VARIABLES');?>
" id="push_notify_variable_0" name="push_notify_variable[0]" value="<?php echo $_smarty_tpl->tpl_vars['db_email_vars']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_k']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_k']->value['index'] : null)]['vVarName'];?>
">
                                                                        </div>
                                                                        <div>
                                                                            <label id="push_notify_variable_0Err" class="error"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td width='50%'>
                                                                        <div style="float:left;width:52%">
                                                                            <select class='chosen-select frm-size-full_width' name='push_notify_value[0]' id='push_notify_value_0' onchange='changeParameters(this)'>
                                                                                <?php if (is_array($_smarty_tpl->tpl_vars['field_arr']->value) && count($_smarty_tpl->tpl_vars['field_arr']->value) > 0) {?>
                                                                                    <optgroup label="List Fields">
                                                                                        <?php
$_from = $_smarty_tpl->tpl_vars['field_arr']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_V_4_saved_item = isset($_smarty_tpl->tpl_vars['V']) ? $_smarty_tpl->tpl_vars['V'] : false;
$__foreach_V_4_saved_key = isset($_smarty_tpl->tpl_vars['K']) ? $_smarty_tpl->tpl_vars['K'] : false;
$_smarty_tpl->tpl_vars['V'] = new Smarty_Variable();
$__foreach_V_4_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_V_4_total) {
$_smarty_tpl->tpl_vars['K'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['K']->value => $_smarty_tpl->tpl_vars['V']->value) {
$__foreach_V_4_saved_local_item = $_smarty_tpl->tpl_vars['V'];
?>
                                                                                            <option value='<?php echo $_smarty_tpl->tpl_vars['V']->value["name"];?>
'><?php echo $_smarty_tpl->tpl_vars['V']->value['label'];?>
</option>
                                                                                        <?php
$_smarty_tpl->tpl_vars['V'] = $__foreach_V_4_saved_local_item;
}
}
if ($__foreach_V_4_saved_item) {
$_smarty_tpl->tpl_vars['V'] = $__foreach_V_4_saved_item;
}
if ($__foreach_V_4_saved_key) {
$_smarty_tpl->tpl_vars['K'] = $__foreach_V_4_saved_key;
}
?>
                                                                                    </optgroup>
                                                                                <?php }?>
                                                                                <optgroup label="Other">
                                                                                    <option selected="selected" value="Other">Other</option>
                                                                                </optgroup>
                                                                            </select>

                                                                        </div>
                                                                        <div style="float:left;width:44%;">
                                                                            <input type="text" class="frm-size-full_width" id="push_notify_value_0_Other" name='push_notify_value_other[]'>
                                                                        </div>
                                                                        <div>
                                                                            <label id="push_notify_value_0Err" class="error"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td align="center" width='12%'>
                                                                        <div class="center">
                                                                            <input type="checkbox" class="regular-checkbox" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_COMPULSORY');?>
" id="push_notify_value_compulsory_0" name="push_notify_compulsory[0]" value="Yes">
                                                                            <label for="push_notify_value_compulsory_0">&nbsp;</label>
                                                                        </div>
                                                                    </td>
                                                                    <td align="center" width='10%'>
                                                                        <div class="controls center">                                                                    
                                                                            <a class="tipR" href="javascript://" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_DELETE');?>
" onclick="Project.modules.pushnotify.deletePushnotifyVariableRow('1')">
                                                                                <span class="icon12 icomoon-icon-remove"></span>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="frm-bot-btn <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_action_bar'];?>
 <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_action_btn'];?>
">
                            <div class="action-btn-align">
                                <input value="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_BUTTON');?>
" name="ctrladd" type="submit" class='btn btn-info' onclick="return Project.modules.pushnotify.getValidatePushNotify()"/>&nbsp;&nbsp;
                                <input type="button" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PUSH_NOTIFY_DISCARD');?>
" class='btn' onclick="loadAdminSiteMapPage()">
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $_smarty_tpl->smarty->_cache['tag_stack'][] = array('javascript', array()); $_block_repeat=true; echo smarty_block_javascript(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
                                               
    var $push_notify_variables = '<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["pushnotify_variables"];?>
';
    var $pushnotify_module_fields = '<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["pushnotify_module_fields"];?>
';
    var $pushnotify_select_fields = '<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value["pushnotify_select_fields"];?>
';
    var inc_no = '1', dis_no = '2';
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_javascript(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_cache['tag_stack']);?>
 
<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src();?>

<?php }?> <?php }
}

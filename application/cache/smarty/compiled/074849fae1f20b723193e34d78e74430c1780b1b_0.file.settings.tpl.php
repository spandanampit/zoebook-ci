<?php
/* Smarty version 3.1.28, created on 2024-03-18 15:57:29
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/admin/tools/views/settings.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65f81711808400_81559101',
  'file_dependency' => 
  array (
    '074849fae1f20b723193e34d78e74430c1780b1b' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/admin/tools/views/settings.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:settings_strip.tpl' => 1,
  ),
),false)) {
function content_65f81711808400_81559101 ($_smarty_tpl) {
if (!is_callable('smarty_block_javascript')) require_once '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/third_party/Smarty/plugins/block.javascript.php';
$_smarty_tpl->tpl_vars["upload_event_arr"] = new Smarty_Variable(array(), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "upload_event_arr", 0);
$_smarty_tpl->tpl_vars["editor_event_arr"] = new Smarty_Variable(array(), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "editor_event_arr", 0);
$_smarty_tpl->tpl_vars["upload_event_str"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "upload_event_str", 0);
$_smarty_tpl->tpl_vars["editor_event_str"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "editor_event_str", 0);
if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->clean_js();?>

<?php }?>
<div class='custom-settings-container'>
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:settings_strip.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div id="ajax_content_div" class="ajax-content-div top-frm-spacing settings-class">
        <div id="ajax_qLoverlay"></div>
        <div id="ajax_qLbar"></div>
        <div class="frm-elem-block">
            <form id="frmsettingslist" name="frmsettingslist" method="post" action="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;
echo $_smarty_tpl->tpl_vars['action_url']->value;?>
">
                <input type="hidden" name="mode" value="Update" />
                <input type="hidden" name="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
" />
                <?php if (is_array($_smarty_tpl->tpl_vars['db_total']->value) && count($_smarty_tpl->tpl_vars['db_total']->value) > 0) {?>            
                    <div style="width:98%" class="frm-block-layout pad-calc-container">
                    <?php $_smarty_tpl->tpl_vars['db_group'] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_total']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'db_group', 0);?>
                        <div class="box">
                            <div class="title"><h4><span><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</span></h4></div>
                            <div class="content clearfix">
                            <?php
$_from = $_smarty_tpl->tpl_vars['db_group']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_value_0_saved_item = isset($_smarty_tpl->tpl_vars['value']) ? $_smarty_tpl->tpl_vars['value'] : false;
$__foreach_value_0_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['value'] = new Smarty_Variable();
$__foreach_value_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_value_0_total) {
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['value']->value) {
$__foreach_value_0_saved_local_item = $_smarty_tpl->tpl_vars['value'];
?>
                                <?php $_smarty_tpl->tpl_vars['db_res'] = new Smarty_Variable($_smarty_tpl->tpl_vars['value']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'db_res', 0);?>
                                <?php if ($_smarty_tpl->tpl_vars['group_count']->value > 1) {?>
                                    <fieldset class="settings-fieldset-border">
                                    <legend class="settings-legend-border"><?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</legend>                                        
                                <?php } elseif (!is_array($_smarty_tpl->tpl_vars['db_res']->value) || count($_smarty_tpl->tpl_vars['db_res']->value) == 0) {?>
                                    <?php $_smarty_tpl->tpl_vars['db_res'] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_group']->value['General'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'db_res', 0);?>
                                <?php }?>
                                <?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['db_res']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
                                    <?php $_smarty_tpl->tpl_vars['fieldName'] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["vName"], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'fieldName', 0);?>
                                    <?php $_smarty_tpl->tpl_vars['fieldDesc'] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["vDesc"], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'fieldDesc', 0);?>
                                    <?php $_smarty_tpl->tpl_vars['fieldType'] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eDisplayType"], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'fieldType', 0);?>
                                    <?php if (trim($_smarty_tpl->tpl_vars['lang_data']->value[$_smarty_tpl->tpl_vars['prlang']->value][$_smarty_tpl->tpl_vars['fieldName']->value]) != '') {?>
                                        <?php $_smarty_tpl->tpl_vars['fieldValue'] = new Smarty_Variable($_smarty_tpl->tpl_vars['lang_data']->value[$_smarty_tpl->tpl_vars['prlang']->value][$_smarty_tpl->tpl_vars['fieldName']->value], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'fieldValue', 0);?>
                                    <?php } else { ?>
                                        <?php $_smarty_tpl->tpl_vars['fieldValue'] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["vValue"], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'fieldValue', 0);?>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['fieldType']->value == 'hidden') {?>  
                                        <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" class="settings-width" value="<?php echo $_smarty_tpl->tpl_vars['fieldValue']->value;?>
">
                                    <?php } else { ?>          
                                        <div class="settings-main" >
                                            <div class="settings-left form-label">
                                                <?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>

                                            </div>
                                            <div class="settings-right <?php if ($_smarty_tpl->tpl_vars['fieldType']->value == 'editor') {?>frm-editor-layout<?php }?>">
                                                <?php if ($_smarty_tpl->tpl_vars['fieldType']->value == 'readonly') {?>
                                                    <?php echo $_smarty_tpl->tpl_vars['fieldValue']->value;?>

                                                <?php } elseif ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eConfigType"] == "Prices") {?>    
                                                    <select style="width:12%" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
[eSelectType]"  title="Increase / Decrease">
                                                        <option value="Plus" <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSelectType"] == 'Plus') {?>selected=true <?php }?> >+</option>
                                                        <option value="Minus"  <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSelectType"] == 'Minus') {?>selected=true <?php }?> >-</option>
                                                    </select>
                                                    &nbsp;&nbsp;
                                                    <input style="width:25%" type="text" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
[Value]" title="<?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
" value="<?php echo trim($_smarty_tpl->tpl_vars['fieldValue']->value);?>
" />
                                                    &nbsp;&nbsp;
                                                    <select style="width:25%" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
[eSource]"  title="Value / Percent">
                                                        <option value="Value" <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSource"] == 'Value') {?>selected=true <?php }?> >Value (Eg. 10)</option>
                                                        <option value="Percent" <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSource"] == 'Percent') {?>selected=true <?php }?> >Percent (Eg. 10%)</option>
                                                    </select>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'text') {?>
                                                    <input type="text" id="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
" class="settings-width" value="<?php echo htmlentities((trim($_smarty_tpl->tpl_vars['fieldValue']->value)));?>
" <?php echo $_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['_langAttribute'];?>
 />
                                                <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'textarea') {?>   
                                                    <textarea row="3"  id="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" cols="5" class="settings-width elastic" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['_langAttribute'];?>
><?php echo trim($_smarty_tpl->tpl_vars['fieldValue']->value);?>
</textarea>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'checkbox') {?>  
                                                    <input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" class="noinput regular-checkbox" <?php if ($_smarty_tpl->tpl_vars['fieldValue']->value == 'Y') {?>checked="true"<?php }?> />
                                                    <label for="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
">&nbsp;</label>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'password') {?>
                                                    <input type="password" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
" class="settings-width" value="<?php echo htmlentities($_smarty_tpl->tpl_vars['fieldValue']->value);?>
" />
                                                <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'selectbox') {?> 
                                                    <?php $_smarty_tpl->tpl_vars["multiAttr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['_multiAttr'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "multiAttr", 0);?>
                                                    <?php $_smarty_tpl->tpl_vars["nameAttr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['_nameAttr'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "nameAttr", 0);?>
                                                    <?php $_smarty_tpl->tpl_vars["pairValue"] = new Smarty_Variable(explode('|',$_smarty_tpl->tpl_vars['fieldValue']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "pairValue", 0);?>
                                                    <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSource"] == 'List') {?>
                                                        <?php $_smarty_tpl->tpl_vars["sourceValue"] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['_listSourceValue'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "sourceValue", 0);?>
                                                        <select class="settings-width chosen-select" name="<?php echo $_smarty_tpl->tpl_vars['nameAttr']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['multiAttr']->value;?>
 data-placeholder='<< Select <?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
 >>'>
                                                            <option value="-9"></option>
                                                            <?php
$__section_j_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_j']) ? $_smarty_tpl->tpl_vars['__section_j'] : false;
$__section_j_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['sourceValue']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_j_1_total = $__section_j_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_j'] = new Smarty_Variable(array());
if ($__section_j_1_total != 0) {
for ($__section_j_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] = 0; $__section_j_1_iteration <= $__section_j_1_total; $__section_j_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']++){
?>
                                                                <?php $_smarty_tpl->tpl_vars["listPairs"] = new Smarty_Variable(explode('::',$_smarty_tpl->tpl_vars['sourceValue']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "listPairs", 0);?>
                                                                <?php $_smarty_tpl->tpl_vars["listPairKey"] = new Smarty_Variable($_smarty_tpl->tpl_vars['listPairs']->value[0], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "listPairKey", 0);?>
                                                                <?php $_smarty_tpl->tpl_vars["listPairVal"] = new Smarty_Variable($_smarty_tpl->tpl_vars['listPairs']->value[1], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "listPairVal", 0);?>
                                                                <?php $_smarty_tpl->tpl_vars["selectedVal"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selectedVal", 0);?>

                                                                <?php if (($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['eConfigType'] == 'Formats' && in_array($_smarty_tpl->tpl_vars['fieldName']->value,$_smarty_tpl->tpl_vars['date_format_config']->value))) {?>
                                                                    <?php $_smarty_tpl->tpl_vars["listPairVal"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->getDateTimeDropdownLabel($_smarty_tpl->tpl_vars['fieldName']->value,$_smarty_tpl->tpl_vars['listPairKey']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "listPairVal", 0);?>
                                                                <?php }?>
                                                                <?php if ($_smarty_tpl->tpl_vars['listPairVal']->value == '') {?>
                                                                    <?php $_smarty_tpl->tpl_vars["listPairVal"] = new Smarty_Variable($_smarty_tpl->tpl_vars['listPairKey']->value, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "listPairVal", 0);?>
                                                                <?php }?>

                                                                <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSelectType"] == 'Multiple' && in_array($_smarty_tpl->tpl_vars['listPairKey']->value,$_smarty_tpl->tpl_vars['pairValue']->value)) {?>
                                                                    <?php $_smarty_tpl->tpl_vars["selectedVal"] = new Smarty_Variable("selected='selected'", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selectedVal", 0);?>
                                                                <?php } elseif ($_smarty_tpl->tpl_vars['listPairKey']->value == $_smarty_tpl->tpl_vars['fieldValue']->value) {?>
                                                                    <?php $_smarty_tpl->tpl_vars["selectedVal"] = new Smarty_Variable("selected='selected'", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selectedVal", 0);?>
                                                                <?php }?>   
                                                                <option value="<?php echo $_smarty_tpl->tpl_vars['listPairKey']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['selectedVal']->value;?>
><?php echo $_smarty_tpl->tpl_vars['listPairVal']->value;?>
</option>
                                                            <?php
}
}
if ($__section_j_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_j'] = $__section_j_1_saved;
}
?>   
                                                        </select>
                                                    <?php }?>
                                                    <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSource"] == 'Query') {?>
                                                        <?php $_smarty_tpl->tpl_vars["querySourceValue"] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['_querySourceValue'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "querySourceValue", 0);?>
                                                        <select class="settings-width chosen-select" name="<?php echo $_smarty_tpl->tpl_vars['nameAttr']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['multiAttr']->value;?>
 data-placeholder='<< Select <?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
 >>'>
                                                            <option value="-9"></option>
                                                            <?php
$__section_j_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_j']) ? $_smarty_tpl->tpl_vars['__section_j'] : false;
$__section_j_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['querySourceValue']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_j_2_total = $__section_j_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_j'] = new Smarty_Variable(array());
if ($__section_j_2_total != 0) {
for ($__section_j_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] = 0; $__section_j_2_iteration <= $__section_j_2_total; $__section_j_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']++){
?>
                                                                <?php $_smarty_tpl->tpl_vars["selectedVal"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selectedVal", 0);?>
                                                                <?php if ($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["eSelectType"] == 'Multiple' && in_array($_smarty_tpl->tpl_vars['querySourceValue']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['id'],$_smarty_tpl->tpl_vars['pairValue']->value)) {?>
                                                                    <?php $_smarty_tpl->tpl_vars["selectedVal"] = new Smarty_Variable("selected='selected'", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selectedVal", 0);?>
                                                                <?php } elseif ($_smarty_tpl->tpl_vars['querySourceValue']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['id'] == $_smarty_tpl->tpl_vars['fieldValue']->value) {?>
                                                                    <?php $_smarty_tpl->tpl_vars["selectedVal"] = new Smarty_Variable("selected='selected'", null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "selectedVal", 0);?>
                                                                <?php }?> 
                                                                <option value="<?php echo $_smarty_tpl->tpl_vars['querySourceValue']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['id'];?>
" <?php echo $_smarty_tpl->tpl_vars['selectedVal']->value;?>
><?php echo $_smarty_tpl->tpl_vars['querySourceValue']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['val'];?>
</option>
                                                            <?php
}
}
if ($__section_j_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_j'] = $__section_j_2_saved;
}
?>    
                                                        </select>
                                                    <?php }?>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'editor') {?>
                                                    <?php $_smarty_tpl->tpl_vars["editorName"] = new Smarty_Variable(("editor_").($_smarty_tpl->tpl_vars['fieldName']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "editorName", 0);?>
                                                    <?php $_smarty_tpl->tpl_vars["editor_event_arr"] = new Smarty_Variable(array_merge($_smarty_tpl->tpl_vars['editor_event_arr']->value,array($_smarty_tpl->tpl_vars['editorName']->value)), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "editor_event_arr", 0);?>
                                                    <textarea title="<?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['editorName']->value;?>
" value="" name="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" style="width:100%;min-height:300px;"><?php echo stripslashes($_smarty_tpl->tpl_vars['fieldValue']->value);?>
</textarea>
                                                <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'file') {?>
                                                    <?php $_smarty_tpl->tpl_vars["fileData"] = new Smarty_Variable($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]["_fileData"], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "fileData", 0);?>
                                                    <?php $_smarty_tpl->tpl_vars["upload_event_arr"] = new Smarty_Variable(array_merge($_smarty_tpl->tpl_vars['upload_event_arr']->value,array($_smarty_tpl->tpl_vars['fileData']->value)), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "upload_event_arr", 0);?>
                                                    <div>
                                                        <div class="btn-uploadify frm-size-small">
                                                            <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['fieldValue']->value;?>
' name='old_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' id='old_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' />
                                                            <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['fieldValue']->value;?>
' name='<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' id='<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' />
                                                            <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['fieldValue']->value;?>
' name='temp_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' id='temp_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' />
                                                            <div id="upload_drop_zone_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" class="upload-drop-zone"></div>
                                                            <div class="uploader upload-src-zone">
                                                                <input type='file' name='uploadify_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' id='uploadify_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
' title='<?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
' />
                                                                <span class="filename" id="preview_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
">
                                                                    <?php if ($_smarty_tpl->tpl_vars['fieldValue']->value != '') {?>
                                                                        <?php echo $_smarty_tpl->tpl_vars['fieldValue']->value;?>

                                                                    <?php } else { ?>
                                                                        <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_UPLOAD_FILE');?>

                                                                    <?php }?>
                                                                </span>
                                                                <span class="action">Choose File</span>
                                                            </div>
                                                        </div>
                                                        <div class="upload-image-btn">
                                                            <div id="img_buttons_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" class="img-inline-display">
                                                                <div id="img_view_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" class="img-view-section">
                                                                    <?php if ($_smarty_tpl->tpl_vars['fileExisted']->value == '0') {?>
                                                                        <span class="errormsg">Not Available</span>
                                                                    <?php }?>
                                                                </div>
                                                                <div id="img_del_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
" class="img-del-section"></div>
                                                            </div>
                                                        </div>
                                                        <div class="clear upload-progress" id="progress_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
">
                                                            <div class="upload-progress-bar progress progress-striped active">
                                                                <div class="bar" id="practive_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php }?>   
                                                <?php if (trim($_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['tHelpText']) != '') {?>
                                                    <span class="input-comment">
                                                        <a href="javascript://"  class="tipR" title="<?php echo $_smarty_tpl->tpl_vars['db_res']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['tHelpText'];?>
">
                                                            <span class="icomoon-icon-help"></span>
                                                        </a>
                                                    </span>
                                                <?php }?>
                                                <label id="<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
Err" class="error"></label>
                                            </div>
                                            <?php if (is_array($_smarty_tpl->tpl_vars['lang_fields']->value) && count($_smarty_tpl->tpl_vars['lang_fields']->value) > 0) {?>
                                                <?php if (in_array($_smarty_tpl->tpl_vars['fieldName']->value,$_smarty_tpl->tpl_vars['lang_fields']->value)) {?>
                                                    <?php if (is_array($_smarty_tpl->tpl_vars['exlang_arr']->value) && count($_smarty_tpl->tpl_vars['exlang_arr']->value) > 0) {?>
                                                        <?php
$__section_ml_3_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_ml']) ? $_smarty_tpl->tpl_vars['__section_ml'] : false;
$__section_ml_3_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['exlang_arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_ml_3_total = $__section_ml_3_loop;
$_smarty_tpl->tpl_vars['__smarty_section_ml'] = new Smarty_Variable(array());
if ($__section_ml_3_total != 0) {
for ($__section_ml_3_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_ml']->value['index'] = 0; $__section_ml_3_iteration <= $__section_ml_3_total; $__section_ml_3_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_ml']->value['index']++){
?>
                                                            <?php $_smarty_tpl->tpl_vars["exlang"] = new Smarty_Variable($_smarty_tpl->tpl_vars['exlang_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_ml']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_ml']->value['index'] : null)], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "exlang", 0);?>
                                                            <div class="clear" id="lnsh_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['exlang']->value;?>
" style="<?php if ($_smarty_tpl->tpl_vars['exlang']->value != $_smarty_tpl->tpl_vars['dflang']->value) {?>display:none;<?php }?>">
                                                                <div class="settings-left form-label">
                                                                    <?php echo $_smarty_tpl->tpl_vars['fieldDesc']->value;?>
 [<?php echo $_smarty_tpl->tpl_vars['lang_info']->value[$_smarty_tpl->tpl_vars['exlang']->value]['vLangTitle'];?>
]
                                                                </div>
                                                                <div class="settings-right <?php if ($_smarty_tpl->tpl_vars['fieldType']->value == 'editor') {?>frm-editor-layout<?php }?>">
                                                                    <?php if ($_smarty_tpl->tpl_vars['fieldType']->value == 'text') {?>
                                                                        <input type="text" name="lang<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['exlang']->value;?>
]" id="lang_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['exlang']->value;?>
" class="settings-width" value="<?php echo trim($_smarty_tpl->tpl_vars['lang_data']->value[$_smarty_tpl->tpl_vars['exlang']->value][$_smarty_tpl->tpl_vars['fieldName']->value]);?>
" />
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'textarea') {?>   
                                                                        <textarea placeholder="" name="lang<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['exlang']->value;?>
]" id="lang_<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['exlang']->value;?>
" class='elastic settings-width'><?php echo $_smarty_tpl->tpl_vars['lang_data']->value[$_smarty_tpl->tpl_vars['exlang']->value][$_smarty_tpl->tpl_vars['fieldName']->value];?>
</textarea>
                                                                    <?php } elseif ($_smarty_tpl->tpl_vars['fieldType']->value == 'editor') {?>
                                                                        <?php $_smarty_tpl->tpl_vars["temp_elename"] = new Smarty_Variable(($_smarty_tpl->tpl_vars['fieldName']->value).($_smarty_tpl->tpl_vars['exlang']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "temp_elename", 0);?>
                                                                        <?php $_smarty_tpl->tpl_vars["lang_elename"] = new Smarty_Variable(("lang_editor_").($_smarty_tpl->tpl_vars['temp_elename']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "lang_elename", 0);?>
                                                                        <?php $_smarty_tpl->tpl_vars["editor_event_arr"] = new Smarty_Variable(array_merge($_smarty_tpl->tpl_vars['editor_event_arr']->value,array($_smarty_tpl->tpl_vars['lang_elename']->value)), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "editor_event_arr", 0);?>
                                                                        <textarea id="<?php echo $_smarty_tpl->tpl_vars['lang_elename']->value;?>
" name="lang<?php echo $_smarty_tpl->tpl_vars['fieldName']->value;?>
[<?php echo $_smarty_tpl->tpl_vars['exlang']->value;?>
]" style="width:100%;min-height:300px;"><?php echo $_smarty_tpl->tpl_vars['lang_data']->value[$_smarty_tpl->tpl_vars['exlang']->value][$_smarty_tpl->tpl_vars['fieldName']->value];?>
</textarea>
                                                                    <?php }?>    
                                                                </div>
                                                            </div>
                                                        <?php
}
}
if ($__section_ml_3_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_ml'] = $__section_ml_3_saved;
}
?>
                                                        <div class="clear none"></div>
                                                        <div class="lang-flag-css" style="margin-left:35%!important">
                                                            <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminLangFlagHTML($_smarty_tpl->tpl_vars['fieldName']->value,$_smarty_tpl->tpl_vars['exlang_arr']->value,$_smarty_tpl->tpl_vars['lang_info']->value);?>

                                                        </div>
                                                    <?php }?>
                                                <?php }?>
                                            <?php }?> 
                                            <div class="clear"></div>
                                        </div>
                                    <?php }?>       
                                <?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>
                            <?php if ($_smarty_tpl->tpl_vars['group_count']->value > 1) {?>
                            </fieldset>
                            <?php }?>
                        <?php
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_local_item;
}
}
if ($__foreach_value_0_saved_item) {
$_smarty_tpl->tpl_vars['value'] = $__foreach_value_0_saved_item;
}
if ($__foreach_value_0_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_value_0_saved_key;
}
?> 
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <?php if ($_smarty_tpl->tpl_vars['edit_access']->value == '1') {?>
                        <div class="frm-bot-btn <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_action_bar'];?>
 <?php echo $_smarty_tpl->tpl_vars['rl_theme_arr']->value['frm_gener_action_btn'];?>
">
                            <div class="action-btn-align">
                                <input type="submit" value="Save" onclick="return Project.modules.settings.getAdminSettingsValidate()" class='btn btn-info'>&nbsp;&nbsp;
                                <input type="button" value="Discard" class='btn' onclick="loadAdminSiteMapPage()">
                            </div>
                        </div>
                    <?php }?>
                <?php } else { ?>
                    <div class="errormsg" align="center">No records found</div>
                <?php }?>
            </form>
        </div>
    </div>
</div>
<?php if (is_array($_smarty_tpl->tpl_vars['editor_event_arr']->value) && count($_smarty_tpl->tpl_vars['editor_event_arr']->value) > 0) {?>
    <?php $_smarty_tpl->tpl_vars["editor_event_str"] = new Smarty_Variable(json_encode($_smarty_tpl->tpl_vars['editor_event_arr']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "editor_event_str", 0);?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js('admin/forms/tinymce/tinymce.min.js');?>

<?php }
if (is_array($_smarty_tpl->tpl_vars['upload_event_arr']->value) && count($_smarty_tpl->tpl_vars['upload_event_arr']->value) > 0) {?>
    <?php $_smarty_tpl->tpl_vars["upload_event_str"] = new Smarty_Variable(json_encode($_smarty_tpl->tpl_vars['upload_event_arr']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "upload_event_str", 0);
}
$_smarty_tpl->smarty->_cache['tag_stack'][] = array('javascript', array()); $_block_repeat=true; echo smarty_block_javascript(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
 
    var editor_events_arr = "", upload_events_arr = "";
    var $upload_form_file = admin_url+'<?php echo $_smarty_tpl->tpl_vars['upload_url']->value;?>
';
    <?php if (trim($_smarty_tpl->tpl_vars['editor_event_str']->value) != '') {?>   
        editor_events_arr = $.parseJSON('<?php echo $_smarty_tpl->tpl_vars['editor_event_str']->value;?>
');
    <?php }?>

    <?php if (trim($_smarty_tpl->tpl_vars['upload_event_str']->value) != '') {?>   
        upload_events_arr = $.parseJSON('<?php echo $_smarty_tpl->tpl_vars['upload_event_str']->value;?>
');
    <?php }?>

    $(function(){
        $('#frmsettingslist').validate({
            <?php echo $_smarty_tpl->tpl_vars['validate_rules']->value;?>

        });
    });
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_javascript(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_cache['tag_stack']);?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js('admin/validate/addon.validation.js','admin/admin/js_settings_page.js');?>

<?php if ($_smarty_tpl->tpl_vars['this']->value->input->is_ajax_request()) {?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->js->js_src();?>

    <?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<?php }?>

<?php $_smarty_tpl->smarty->_cache['tag_stack'][] = array('javascript', array()); $_block_repeat=true; echo smarty_block_javascript(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    Project.modules.settings.init();
    var prime_lang_code = '<?php echo $_smarty_tpl->tpl_vars['prlang']->value;?>
';
    var other_lang_JSON = '<?php echo json_encode($_smarty_tpl->tpl_vars['exlang_arr']->value);?>
';
    intializeLanguageAutoEntry(prime_lang_code, other_lang_JSON);
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_javascript(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_cache['tag_stack']);
}
}

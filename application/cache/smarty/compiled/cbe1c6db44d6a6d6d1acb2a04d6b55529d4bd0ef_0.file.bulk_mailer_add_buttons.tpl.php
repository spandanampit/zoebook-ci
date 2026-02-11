<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:55:14
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/bulk_mailer_add_buttons.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c457aaa0ed48_03547688',
  'file_dependency' => 
  array (
    'cbe1c6db44d6a6d6d1acb2a04d6b55529d4bd0ef' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/user/views/bulk_mailer_add_buttons.tpl',
      1 => 1706090549,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c457aaa0ed48_03547688 ($_smarty_tpl) {
?>
<!-- Form Redirection Control Unit -->
<?php if ($_smarty_tpl->tpl_vars['controls_allow']->value == false || $_smarty_tpl->tpl_vars['rm_ctrl_directions']->value == true) {?>
    <input value="<?php echo $_smarty_tpl->tpl_vars['ctrl_flow']->value;?>
" id="ctrl_flow_stay" name="ctrl_flow" type="hidden" />
<?php } else { ?>
    <div class='action-dir-align'>
        <?php if ($_smarty_tpl->tpl_vars['prev_link_allow']->value == true) {?>
            <input value="Prev" id="ctrl_flow_prev" name="ctrl_flow" class="regular-radio" type="radio" <?php if ($_smarty_tpl->tpl_vars['ctrl_flow']->value == 'Prev') {?> checked=true <?php }?> />
            <label for="ctrl_flow_prev">&nbsp;</label><label for="ctrl_flow_prev" class="inline-elem-margin"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_PREV_SHORT');?>
</label>&nbsp;&nbsp;
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['next_link_allow']->value == true || $_smarty_tpl->tpl_vars['mode']->value == 'Add') {?>
            <input value="Next" id="ctrl_flow_next" name="ctrl_flow" class="regular-radio" type="radio" <?php if ($_smarty_tpl->tpl_vars['ctrl_flow']->value == 'Next') {?> checked=true <?php }?> />
            <label for="ctrl_flow_next">&nbsp;</label><label for="ctrl_flow_next" class="inline-elem-margin"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_NEXT_SHORT');?>
</label>&nbsp;&nbsp;
        <?php }?>
        <input value="List" id="ctrl_flow_list" name="ctrl_flow" class="regular-radio" type="radio" <?php if ($_smarty_tpl->tpl_vars['ctrl_flow']->value == 'List') {?> checked=true <?php }?> />
        <label for="ctrl_flow_list">&nbsp;</label><label for="ctrl_flow_list" class="inline-elem-margin"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_LIST_SHORT');?>
</label>&nbsp;&nbsp;
        <input value="Stay" id="ctrl_flow_stay" name="ctrl_flow" class="regular-radio" type="radio" <?php if ($_smarty_tpl->tpl_vars['ctrl_flow']->value == '' || $_smarty_tpl->tpl_vars['ctrl_flow']->value == 'Stay') {?> checked=true <?php }?> />
        <label for="ctrl_flow_stay">&nbsp;</label><label for="ctrl_flow_stay" class="inline-elem-margin"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_STAY_SHORT');?>
</label>
    </div>
<?php }?>
<!-- Form Action Control Unit -->
<?php if ($_smarty_tpl->tpl_vars['controls_allow']->value == false) {?>
    <div class="clear"></div>
<?php }?>
<div class="action-btn-align" id="action_btn_container">
    <?php if ($_smarty_tpl->tpl_vars['mode']->value == 'Update') {?>
        <?php if ($_smarty_tpl->tpl_vars['update_allow']->value == true) {?>
                                <button title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_UPDATE');?>
" name="ctrlupdate" type="submit" id="frmbtn_update" class="btn btn-info"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_UPDATE');?>
</button>&nbsp;&nbsp;
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['delete_allow']->value == true) {?>
                                <button title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DELETE');?>
" name="ctrldelete" type="button" id="frmbtn_delete" class="btn btn-danger" onclick="return deleteAdminRecordData('<?php echo $_smarty_tpl->tpl_vars['enc_id']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['index'];?>
','<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['inline_edit_action'];?>
', '<?php echo $_smarty_tpl->tpl_vars['extra_qstr']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['extra_hstr']->value;?>
');"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DELETE');?>
</button>&nbsp;&nbsp;
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['discard_allow']->value == true) {?>
                                <button title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DISCARD');?>
" name="ctrldiscard" type="button" id="frmbtn_discard" class="btn" onclick="return loadAdminModuleListing('<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['index'];?>
', '<?php echo $_smarty_tpl->tpl_vars['extra_hstr']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DISCARD');?>
</button>&nbsp;&nbsp;
                            <?php }?>
                            
    <?php } else { ?>
        <button title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SAVE');?>
" name="ctrladd" type="submit" id="frmbtn_add" class="btn btn-info"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SAVE');?>
</button>&nbsp;&nbsp;
                        <?php if ($_smarty_tpl->tpl_vars['discard_allow']->value == true) {?>
                            <button title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DISCARD');?>
" name="ctrldiscard" type="button" id="frmbtn_discard" class="btn" onclick="return loadAdminModuleListing('<?php echo $_smarty_tpl->tpl_vars['mod_enc_url']->value['index'];?>
', '<?php echo $_smarty_tpl->tpl_vars['extra_hstr']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_DISCARD');?>
</button>&nbsp;&nbsp;
                        <?php }?>
                        <button title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SEND_NOW');?>
" name="ctrlcustom" type="button" id="frmbtn_custom_custom_btn_add_1" aria-btn-name="custom_btn_add_1" class="btn ctrl-custom-btn"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SEND_NOW');?>
</button>&nbsp;&nbsp;
                        <button title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SAVE_NOW');?>
" name="ctrlcustom" type="button" id="frmbtn_custom_custom_btn_add_2" aria-btn-name="custom_btn_add_2" class="btn ctrl-custom-btn"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('BULK_MAILER_SAVE_NOW');?>
</button>&nbsp;&nbsp;
                        
    <?php }?>
</div>            <?php }
}

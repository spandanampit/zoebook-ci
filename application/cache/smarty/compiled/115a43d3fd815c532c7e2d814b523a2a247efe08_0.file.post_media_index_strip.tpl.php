<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:53:18
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/post/views/post_media_index_strip.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c45736cdc5d4_26876867',
  'file_dependency' => 
  array (
    '115a43d3fd815c532c7e2d814b523a2a247efe08' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/post/views/post_media_index_strip.tpl',
      1 => 1706090521,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c45736cdc5d4_26876867 ($_smarty_tpl) {
?>
<div class="headingfix">
    <!-- Top Header Block -->
    <div class="heading" id="top_heading_fix">
		<!-- Top Strip Title Block -->
        <h3>
            <div class="screen-title">
                <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_LISTING');?>
 :: 
                <?php if ($_smarty_tpl->tpl_vars['parent_switch_combo']->value[$_smarty_tpl->tpl_vars['parID']->value] != '') {?>
                    <?php echo $_smarty_tpl->tpl_vars['parent_switch_combo']->value[$_smarty_tpl->tpl_vars['parID']->value];?>
 :: 
                <?php }?>
                <?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('POST_MEDIA_POST_MEDIA');?>

            </div>        
        </h3>
		<!-- Top Strip Dropdown Block -->
        <div class="header-right-drops">
            
            <!-- Parent Module SwitchTo Dropdown -->
            <?php if ($_smarty_tpl->tpl_vars['parMod']->value != '' && $_smarty_tpl->tpl_vars['parID']->value != '') {?>
                
                <?php if ($_smarty_tpl->tpl_vars['parMod']->value == "posts") {?>     
                    <div class="frm-back-to frm-list-back">
                        <a hijacked="yes" href="<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
#<?php echo $_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL('post/posts/index');
echo $_smarty_tpl->tpl_vars['extra_hstr']->value;?>
" class="backlisting-link" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->parseLabelMessage('GENERIC_BACK_TO_MODULE_LISTING','#MODULE_HEADING#','POSTS_POSTS');?>
">
                            <span class="icon16 minia-icon-arrow-left"></span>
                        </a>
                    </div>
                <?php }?>
                <div class="frm-switch-drop frm-list-switch">
                    <?php if (is_array($_smarty_tpl->tpl_vars['parent_switch_combo']->value) && count($_smarty_tpl->tpl_vars['parent_switch_combo']->value) > 0) {?>
                        <?php $_smarty_tpl->tpl_vars["enc_parID"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->getAdminEncodeURL($_smarty_tpl->tpl_vars['parID']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "enc_parID", 0);?>
                        <?php echo $_smarty_tpl->tpl_vars['this']->value->dropdown->display("vParentSwitchPage","vParentSwitchPage","style='width:100%;' aria-switchto-parent='".((string)$_smarty_tpl->tpl_vars['parent_switch_cit']->value['param'])."' class='chosen-select' onchange='return loadAdminModuleListingSwitch(\"".((string)$_smarty_tpl->tpl_vars['mod_enc_url']->value['index'])."\", this.value, \"".((string)$_smarty_tpl->tpl_vars['extra_hstr']->value)."\")'",'','',$_smarty_tpl->tpl_vars['enc_parID']->value);?>

                    <?php }?>
                </div>
            <?php }?>
            
        </div>
    </div>
</div>    <?php }
}

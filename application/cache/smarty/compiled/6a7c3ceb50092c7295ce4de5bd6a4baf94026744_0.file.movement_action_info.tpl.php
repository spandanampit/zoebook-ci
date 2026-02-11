<?php
/* Smarty version 3.1.28, created on 2025-01-23 06:07:00
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_action_info.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67924d04de90a4_02924990',
  'file_dependency' => 
  array (
    '6a7c3ceb50092c7295ce4de5bd6a4baf94026744' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_action_info.tpl',
      1 => 1737641217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67924d04de90a4_02924990 ($_smarty_tpl) {
?>
<div class="group-box">
  <div class="group-content-box">
  <?php $_smarty_tpl->tpl_vars['movement_name_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['movement']->value['get_movements']['movement_name']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'movement_name_withouemoji', 0);?>
  <?php $_smarty_tpl->tpl_vars['movement_name'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['movement_name_withouemoji']->value,100), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'movement_name', 0);?>
    <h3><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['movement_name']->value);?>
</h3>
    <div class="harmony-box">
      <p><?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['total_members'];?>
 <?php echo $_smarty_tpl->tpl_vars['members']->value;?>
</p>
      <ul class="friends-harmonic">
        <?php
$_from = $_smarty_tpl->tpl_vars['movement_follower']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
        <li>
          <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['row']->value['user_details']['iUserId'],$_smarty_tpl->tpl_vars['row']->value['user_details']['u_name']);?>
">
            <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_details']['u_profile_image'];?>
" alt="friend">
          </a>
        </li>
        <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
?>
        
      </ul>
    </div>
  </div>
  <div class="group-btn-box">
    <ul>
    <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['iUserId'] != $_smarty_tpl->tpl_vars['movement']->value['get_movements']['users_id']) {?>
    <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/leave');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
" class="yellow-text"><?php echo $_smarty_tpl->tpl_vars['leave']->value;?>
</a></li>
    <?php }?>
      <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/invitefriends');?>
?movementId=<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
" class="purple-text"><?php echo $_smarty_tpl->tpl_vars['invite']->value;?>
</a></li>
      <li><a href="javascript:void(0)" class="orange-text" onclick="openShareModal(<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
, <?php echo $_smarty_tpl->tpl_vars['userinfo']->value['iUserId'];?>
)"><?php echo $_smarty_tpl->tpl_vars['share']->value;?>
</a></li>
    </ul>
  </div>
</div><?php }
}

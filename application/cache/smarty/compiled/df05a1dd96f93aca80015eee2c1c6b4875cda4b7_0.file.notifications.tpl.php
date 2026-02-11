<?php
/* Smarty version 3.1.28, created on 2024-01-31 13:07:18
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/notifications.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9f8ae12a200_45772132',
  'file_dependency' => 
  array (
    'df05a1dd96f93aca80015eee2c1c6b4875cda4b7' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/notifications.tpl',
      1 => 1706090584,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9f8ae12a200_45772132 ($_smarty_tpl) {
?>

<?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['notifications']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
    <li id="notification_<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['notification_id'];?>
">
        <div class="cmn-user">
            <i class="cmn-user-img">
                <img src="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
" alt="">
            </i>
            <?php $_smarty_tpl->tpl_vars["notification_link"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "notification_link", 0);?>
            <?php if ($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_type'] == 'Live' && $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'] > 0) {?>
                <?php $_smarty_tpl->tpl_vars["notification_link"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->setdiplayliveposturl($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "notification_link", 0);?>
            <?php } elseif ($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'] > 0) {?>
                <?php $_smarty_tpl->tpl_vars["notification_link"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],"post"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "notification_link", 0);?>
            <?php }?>
            <div class="cmn-user-name">
                <?php if ($_smarty_tpl->tpl_vars['notification_link']->value != '') {?><a href="<?php echo $_smarty_tpl->tpl_vars['notification_link']->value;?>
"><?php }?>
                <h6><span><?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_notification_text'];?>
</span></h6>
                <?php if ($_smarty_tpl->tpl_vars['notification_link']->value != '') {?></a><?php }?>
            </div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_type'] == 'Follow') {?>
            <div class="follow_block_<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pending_request_id'];?>
">
                <a href="javascript://" data-notificationid="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['notification_id'];?>
" data-follow_request_id="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pending_request_id'];?>
" class="btn btn-primary accept_frequest">Accept</a>
                <a href="javascript://" data-notificationid="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['notification_id'];?>
" data-follow_request_id="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pending_request_id'];?>
" class="btn btn-secondary reject_frequest">Reject</a>
            </div>
        <?php }?>
        <div><span class="notifi-time"><?php echo time_elapsed_string($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_added_date']);?>
</span></div>
    </li>
<?php }} else {
 ?>
    <p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;">No notifications at the moment</p>
<?php
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
}
}

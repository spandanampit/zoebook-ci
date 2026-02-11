<?php
/* Smarty version 3.1.28, created on 2024-01-31 13:07:22
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/block_users.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9f8b2529fb8_28470939',
  'file_dependency' => 
  array (
    '9c08bb9cebf101a53b906237fdc61fefd84db28e' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/block_users.tpl',
      1 => 1706090583,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9f8b2529fb8_28470939 ($_smarty_tpl) {
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['block_users']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
    <li id="block_<?php echo $_smarty_tpl->tpl_vars['block_users']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['u_users_id'];?>
">
        <div class="cmn-user">
            <i class="cmn-user-img">
                <img src="<?php echo $_smarty_tpl->tpl_vars['block_users']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['u_profile_image'];?>
" alt="User profile picture">
            </i>
            <h6><span><?php echo $_smarty_tpl->tpl_vars['block_users']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['u_name'];?>
</span></h6>
            
        </div>       
        <div class="cmn-user-name">
                <h6><span><?php echo $_smarty_tpl->tpl_vars['block_users']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['u_email'];?>
</span></h6>
            </div> 
        <div><span><a class="btn btn-danger unblock_user" href="javascript:void(0);" data-userid="<?php echo $_smarty_tpl->tpl_vars['block_users']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['u_users_id'];?>
" data-nm="<?php echo $_smarty_tpl->tpl_vars['block_users']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['u_name'];?>
">unblock</a></span></div>
    </li>
<?php }} else {
 ?>
    <p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;">No Blocked Users.</p>
<?php
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
}
}

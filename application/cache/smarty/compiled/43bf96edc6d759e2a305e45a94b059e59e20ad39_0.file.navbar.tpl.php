<?php
/* Smarty version 3.1.28, created on 2025-01-22 06:47:09
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/navbar.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_679104ed7c5fb6_71810512',
  'file_dependency' => 
  array (
    '43bf96edc6d759e2a305e45a94b059e59e20ad39' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/navbar.tpl',
      1 => 1737557217,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_679104ed7c5fb6_71810512 ($_smarty_tpl) {
?>
<div class="sidebar">              
<div class="sidebar-user">
  <div class="sidebar-close">
    <i class="fa-solid fa-xmark"></i>
  </div>
  <div class="sidebar-user-img">
    <?php if ($_smarty_tpl->tpl_vars['page']->value != 'movementDetails') {?>
    <img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="">
    <?php } else { ?>
    <img src="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['users_profile_image'];?>
" alt="">
    <?php }?>
  </div>
  <div class="sidebar-user-title">
    <?php if ($_smarty_tpl->tpl_vars['page']->value != 'movementDetails') {?>
      <h3><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_name'];?>
</h3>
    <?php } else { ?>
    <h3><?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['users_name'];?>
</h3>
    <?php }?>
    <!--<p>15k Followers</p>-->
  </div>
</div>
<div class="sidebar-nav">
  <div class="scroll-content-button">
    <ul>
      <li class="sidebar-nav-item">
        <a class="vid-yellow-bg" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/popularmovement');?>
"><?php echo $_smarty_tpl->tpl_vars['popular_movements']->value;?>
</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="vid-green-bg" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/mymovement');?>
"><?php echo $_smarty_tpl->tpl_vars['my_movements']->value;?>
</a>
      </li>
      <li class="sidebar-nav-item">
        <a class="vid-purple-bg" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/addmovement');?>
"><?php echo $_smarty_tpl->tpl_vars['create']->value;?>
</a>
      </li>
    </ul>
  </div>
</div>
</div><?php }
}

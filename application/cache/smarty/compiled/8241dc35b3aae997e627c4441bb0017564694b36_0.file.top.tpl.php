<?php
/* Smarty version 3.1.28, created on 2024-01-31 04:37:26
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/views/top/top.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9ce8678f504_11655804',
  'file_dependency' => 
  array (
    '8241dc35b3aae997e627c4441bb0017564694b36' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/views/top/top.tpl',
      1 => 1706090593,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9ce8678f504_11655804 ($_smarty_tpl) {
?>
<div class="new_loader" style="display:none;"></div>
<div class="container">
    <div class="header-inner">
        <div class="search-header">
            <div class="logo-block">
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/logo.png" alt="" class="img-fluid">
                </a>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') > 0) {?>
                <div class="search-block">
                    <div class="form-group">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" placeholder="Search" id="searchfriends" name="searchfriends">
                    </div>
                </div>
            <?php }?>
        </div>
        <div class="menu-block">
            <nav class="main-menu">
                <div class="navbar-toggler">
                    <span></span><span></span><span></span>
                </div>
                <ul>
                    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') > 0) {?>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
home.html">Home</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/home/my_profile');?>
" title="My Dashboard">My Dashboard</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
golive-start.html" class="link-btn chat-btn">Go Live</a></li>
                        <li><a id="logout_btn" href="javascript:;" data-href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/user/logout');?>
" title="Logout">Logout</a></li>
                    <?php } else { ?>

                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/staticpage','','code:aboutus');?>
">About Us</a></li>
                        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/contactus');?>
" title="Contact Us">Contact Us</a></li>
                    <?php }?>
                </ul>
            </nav>
        </div>
    </div>
</div>
<?php }
}

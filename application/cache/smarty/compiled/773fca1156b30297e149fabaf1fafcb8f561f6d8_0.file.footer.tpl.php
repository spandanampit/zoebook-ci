<?php
/* Smarty version 3.1.28, created on 2024-01-31 04:37:26
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/views/bottom/footer.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9ce867a1951_35206012',
  'file_dependency' => 
  array (
    '773fca1156b30297e149fabaf1fafcb8f561f6d8' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/views/bottom/footer.tpl',
      1 => 1706090593,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65b9ce867a1951_35206012 ($_smarty_tpl) {
?>
<div class="container">
  <div class="row align-items-center">
    <div class="col-xl-4 col-lg-4 col-md-12 mb-md-2 mb-lg-0 mb-xl-0">
      <p><?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('COPYRIGHTED_TEXT');?>
</p>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 mb-md-2 mb-lg-0 mb-xl-0">
      <ul class="footer-menu-link">
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/staticpage','','code:privacypolicy');?>
" title="Privacy Policy">Privacy Policy</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/staticpage','','code:termsconditions');?>
" title="Terms & Conditions">Terms & Conditions</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/staticpage','','code:faq');?>
">FAQ</a></li>
        <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/contactus');?>
" title="Contact Us">Contact Us</a></li>
      </ul>
    </div>
    <div class="col-xl-4 col-lg-3 col-md-12">
      <div class="social-link">
        <ul>
          <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('FACEBOOK_LINK');?>
" target="_blank" class="fb" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
          <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('TWITTERLINK');?>
" target="_blank" class="tw" title="Twitter"><i class="fab fa-twitter"></i></a></li>
          <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('LINKEDINLINK');?>
" class="in" title="Linkedin"><i class="fab fa-linkedin-in"></i></a></li>
          <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('GOOGLE_PLUS_LINK');?>
" target="_blank"  class="em" title="Email"><i class="fas fa-envelope"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</div><?php }
}

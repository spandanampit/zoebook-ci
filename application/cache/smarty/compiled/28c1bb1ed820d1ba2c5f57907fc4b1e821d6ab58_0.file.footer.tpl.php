<?php
/* Smarty version 3.1.28, created on 2024-06-24 23:39:25
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/views/bottom/footer.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_667a661d879503_36915186',
  'file_dependency' => 
  array (
    '28c1bb1ed820d1ba2c5f57907fc4b1e821d6ab58' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/views/bottom/footer.tpl',
      1 => 1719297555,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_667a661d879503_36915186 ($_smarty_tpl) {
?>

<?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') > 0) {?>
  <footer class="second-footer">
    <div class="container container-2">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="footer-text-2">
            <p><?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('COPYRIGHTED_TEXT');?>
</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="footer-social d-flex justify-content-end">
              <ul>
                <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li>
              </ul>
            </div>
        </div>
      </div>
    </div>
  </footer>
<?php } else { ?>
  <div class="footer-sticky sticky-bottom">
  <!-- footer section start -->
    <footer class="footer-sec">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="footer-logo">
              <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/logo.png" alt="">
            </div>
            <div class="footer-link">
              <ul>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/privacypolicy');?>
">Privacy Policy</a></li>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/termsconditions');?>
">Terms & Condition</a></li>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/aboutus');?>
">About us</a></li>
                <!--<li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/staticpage','','code:faq');?>
">FAQ</a></li>-->
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/contactus');?>
">Contact Us</a></li>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/homepage');?>
">Home</a></li>
                
              </ul>
            </div>
            <div class="footer-social">
              <ul>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('FACEBOOK_LINK');?>
" target="_blank" class="fb" title="Facebook" ><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="" target="_blank" class="tw" title="Twitter"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('LINKEDINLINK');?>
" class="in" title="Linkedin"><i class="fa-brands fa-linkedin-in"></i></a></li>
                <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('TWITTERLINK');?>
" target="_blank" class="tw" title="Twitter" ><i class="fa-brands fa-twitter"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  <!-- footer section end -->
    <div class="footer-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="footer-text">
              <p><?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('COPYRIGHTED_TEXT');?>
</p>
            </div>              
          </div>
        </div>
      </div>
    </div>
  </div>
<?php }?>

<?php echo '<script'; ?>
>
    document.addEventListener('DOMContentLoaded', function() {
        const searchTermsInput = document.getElementById('search-terms');
        const searchFriendsInput = document.getElementById('searchfriends');
        const mobileSearchIcon = document.querySelector('.mobile-search .search-toggle .icon-search');
        const desktopSearchIcon = document.querySelector('.desktop-search .header-search-btn');

        function toggleSearchIcon(input, icon) {
            input.addEventListener('input', function() {
                if (input.value.length > 0) {
                    icon.style.display = 'none';
                } else {
                    icon.style.display = 'inline-block';
                }
            });
        }

        if (searchTermsInput && mobileSearchIcon) {
            toggleSearchIcon(searchTermsInput, mobileSearchIcon);
        }

        if (searchFriendsInput && desktopSearchIcon) {
            toggleSearchIcon(searchFriendsInput, desktopSearchIcon);
        }
    });
<?php echo '</script'; ?>
><?php }
}

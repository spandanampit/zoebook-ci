<?php
/* Smarty version 3.1.28, created on 2024-04-30 20:10:45
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/contactus.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_663102ed62e102_69891449',
  'file_dependency' => 
  array (
    '1799012724dd0f7aefcdb9e1951d4a67ee1e1b54' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/contactus.tpl',
      1 => 1714488012,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_663102ed62e102_69891449 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<section class="inner-banner-sec">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="inner-banner">
          <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/inner-banner.png" alt="">
          <div class="inner-banner-content">
            <h2>Contact Us</h2>
            <ul class="breadcum">
              <li><a href="#">Home</a></li>
              <li><a href="#">Contact Us</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- contact form sec strat -->
<section class="contact-sec">
  <div class="container">
    <div class="row">
      <div class="col-lg-4">
        <div class="contact-address-box">
          <h3>Contact Us</h3>
          <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected.</p>
          <div class="contact-list-box">
            <div class="contact-list-item call-box">
              <div class="contact-icon">
                <i class="fa-solid fa-phone-volume"></i>
              </div>
              <div class="contact-content">
                <p>Call us</p>
                <h5>+1012 3456 789</h5>
              </div>
            </div>
            <div class="contact-list-item">
              <div class="contact-icon">
                <i class="fa-solid fa-envelope"></i>
              </div>
              <div class="contact-content">
                <a href="#">zoebook@dummy.com</a>
              </div>
            </div>
            <div class="contact-list-item">
              <div class="contact-icon">
                <i class="fa-solid fa-location-dot"></i>
              </div>
              <div class="contact-content">
                <p>zoebook@dummy.com</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="contact-form">
          <form class="row g-3">
            <div class="col-md-6">
              <label class="vContactName">First Name</label>
              <input type="text" class="form-control" id="vContactName" name="vContactName" placeholder="First Name">
              <div class="error-msg-form" id='vContactNameErr'></div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Last Name</label>
              <input type="text" class="form-control" placeholder="Last Name">
            </div>
            <div class="col-md-6">
              <label class="vContactEmail">Email</label>
              <input type="email" class="form-control email-input" id="vContactEmail" name="vContactEmail" aria-describedby="emailHelp" placeholder="john@zoebook.com">
              <div class="error-msg-form" id='vContactEmailErr'></div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number</label>
              <input type="text" class="form-control" placeholder="Phone Number">
            </div>
            <div class="col-12">
                <label class="vContactMessage">Message</label>
                <textarea class="form-control" id="vContactMessage" name="vContactMessage" maxlength="999" rows="3" style="resize:none" placeholder="Message"></textarea>
                <div class="error-msg-form" id='vContactMessageErr'></div>
            </div>

            <div class="g-recaptcha" data-sitekey="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('GOOGLE_CAPTCHA_SITE_KEY');?>
"></div>
            <div style="padding-bottom:10px;"></div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary form-btn w-100" id="submitcontact" name="submitcontact">Submit Now</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- contact form sec end -->
<a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/posts.js");?>

<?php }
}

<?php
/* Smarty version 3.1.28, created on 2025-01-31 03:21:05
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/homepage.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_679cb221e98ee8_18851246',
  'file_dependency' => 
  array (
    'e6fdf83f7afa34ebb1174ebe9e13355bfc5e3921' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/homepage.tpl',
      1 => 1738322419,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_679cb221e98ee8_18851246 ($_smarty_tpl) {
?>
<!-- banner-section strat -->
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<section class="banner-sec">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="banner-content">
        <h1><?php echo $_smarty_tpl->tpl_vars['your_social']->value;?>
 <span><?php echo $_smarty_tpl->tpl_vars['media_solutions']->value;?>
</span></h1>
        <p><?php echo $_smarty_tpl->tpl_vars['home_description']->value;?>
</p>
      </div>
      <div class="banner-img">
        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/cross.png" class="ban-1">
        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/dot.png" class="ban-2">
        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/yellow-circle.png" class="ban-3">
        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/green-circle.png" class="ban-4">
        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/banner-img.png" class="main-img" alt="">
        <div class="banner-msg-box">
          <form>
            <div class="form-group">
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-primary form-btn"><img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/plane.png"></button>
          </form>
        </div>  
      </div>
      <div class="banner-reach">
        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/reach-img.png" alt="">
        <h3><?php echo $_smarty_tpl->tpl_vars['reach_almost']->value;?>
 <br><?php echo $_smarty_tpl->tpl_vars['every_user_in']->value;?>
 <span><?php echo $_smarty_tpl->tpl_vars['48hours']->value;?>
</span></h3>
      </div>
    </div>
  </div>
</div>
</section>
<!-- banner-section end -->

<!-- filter section start -->
<section class="filter-sec">
<div class="container">
  <div class="row align-items-center">
    <div class="col-lg-5">
      <div class="filter-img-box">
        <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/filter-img.png" alt="">
      </div>
    </div>
    <div class="col-lg-7">
      <div class="filter-content">
        <h3><?php echo $_smarty_tpl->tpl_vars['filter_available_on_the_mobile_application']->value;?>
</h3>
        <p><?php echo $_smarty_tpl->tpl_vars['filter_description']->value;?>
</p>
        <div class="filter-store">
          <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('PLAY_STORE_LINK');?>
" target="_blank">
            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/play-store.png" alt="">
          </a>
          <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('APP_STORE_LINK');?>
" target="_blank">
            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/apple-store.png" alt="">
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!-- filter section end -->

<!-- feature section start -->
<section class="feture-sec">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="title-heading mb-75">
        <h2><?php echo $_smarty_tpl->tpl_vars['various_kind_of']->value;?>
 <span> <?php echo $_smarty_tpl->tpl_vars['features']->value;?>
</span></h2>
        <p><?php echo $_smarty_tpl->tpl_vars['features_description']->value;?>
</p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6">
      <div class="feature-box">
        <div class="feature-img">
          <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/filter-1.png" alt="">
        </div>
        <div class="feature-content">
          <h3><?php echo $_smarty_tpl->tpl_vars['chat_with_friends']->value;?>
</h3>
          <div class="divider"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
      <div class="feature-box">
        <div class="feature-img">
          <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/filter-2.png" alt="">
        </div>
        <div class="feature-content">
          <h3><?php echo $_smarty_tpl->tpl_vars['watch_interesting_videos']->value;?>
</h3>
          <div class="divider"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
      <div class="feature-box">
        <div class="feature-img">
          <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/filter-3.png" alt="">
        </div>
        <div class="feature-content">
          <h3><?php echo $_smarty_tpl->tpl_vars['watching_post']->value;?>
</h3>
          <div class="divider"></div>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!-- feature section end -->

<!-- cta section start -->
<section class="cta-sec">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/leaf-1.png" class="leaft-1" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/leaf-2.png" class="leaft-2" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/leaf-3.png" class="leaft-3" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/leaf-4.png" class="leaft-4" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/green-circle.png" class="leaft-6" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/flower-1.png" class="leaft-7" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/flower-2.png" class="leaft-8" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/cross.png" class="leaft-9" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/dot.png" class="leaft-10" alt="">
<img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/flower-2.png" class="leaft-11" alt="">
<div class="container">
  <div class="row">
    <div class="col-lg-7">
      <div class="cta-content">
        <h3><?php echo $_smarty_tpl->tpl_vars['movement_feature']->value;?>
</h3>
        <p><?php echo $_smarty_tpl->tpl_vars['movement_description']->value;?>
</p>
        <div class="btn-box">
          <a href="#" class="site-btn"><?php echo $_smarty_tpl->tpl_vars['learn_more']->value;?>
</a>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
    </div>
  </div>
</div>
</section>
<!-- cta section end -->
<a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/posts.js");
}
}

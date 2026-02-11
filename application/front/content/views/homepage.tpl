<!-- banner-section strat -->
<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
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
        <h1><%$your_social%> <span><%$media_solutions%></span></h1>
        <p><%$home_description%></p>
      </div>
      <div class="banner-img">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/cross.png" class="ban-1">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/dot.png" class="ban-2">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/yellow-circle.png" class="ban-3">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/green-circle.png" class="ban-4">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/banner-img.png" class="main-img" alt="">
        <div class="banner-msg-box">
          <form>
            <div class="form-group">
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <button type="submit" class="btn btn-primary form-btn"><img src="<%$this->config->item('images_url')%>front/new-front-image/plane.png"></button>
          </form>
        </div>  
      </div>
      <div class="banner-reach">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/reach-img.png" alt="">
        <h3><%$reach_almost%> <br><%$every_user_in%> <span><%$48hours%></span></h3>
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
        <img src="<%$this->config->item('images_url')%>front/new-front-image/filter-img.png" alt="">
      </div>
    </div>
    <div class="col-lg-7">
      <div class="filter-content">
        <h3><%$filter_available_on_the_mobile_application%></h3>
        <p><%$filter_description%></p>
        <div class="filter-store">
          <a href="<%$this->config->item('PLAY_STORE_LINK')%>" target="_blank">
            <img src="<%$this->config->item('images_url')%>front/new-front-image/play-store.png" alt="">
          </a>
          <a href="<%$this->config->item('APP_STORE_LINK')%>" target="_blank">
            <img src="<%$this->config->item('images_url')%>front/new-front-image/apple-store.png" alt="">
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
        <h2><%$various_kind_of%> <span> <%$features%></span></h2>
        <p><%$features_description%></p>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-6">
      <div class="feature-box">
        <div class="feature-img">
          <img src="<%$this->config->item('images_url')%>front/new-front-image/filter-1.png" alt="">
        </div>
        <div class="feature-content">
          <h3><%$chat_with_friends%></h3>
          <div class="divider"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
      <div class="feature-box">
        <div class="feature-img">
          <img src="<%$this->config->item('images_url')%>front/new-front-image/filter-2.png" alt="">
        </div>
        <div class="feature-content">
          <h3><%$watch_interesting_videos%></h3>
          <div class="divider"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6">
      <div class="feature-box">
        <div class="feature-img">
          <img src="<%$this->config->item('images_url')%>front/new-front-image/filter-3.png" alt="">
        </div>
        <div class="feature-content">
          <h3><%$watching_post%></h3>
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
<img src="<%$this->config->item('images_url')%>front/new-front-image/leaf-1.png" class="leaft-1" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/leaf-2.png" class="leaft-2" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/leaf-3.png" class="leaft-3" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/leaf-4.png" class="leaft-4" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/green-circle.png" class="leaft-6" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/flower-1.png" class="leaft-7" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/flower-2.png" class="leaft-8" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/cross.png" class="leaft-9" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/dot.png" class="leaft-10" alt="">
<img src="<%$this->config->item('images_url')%>front/new-front-image/flower-2.png" class="leaft-11" alt="">
<div class="container">
  <div class="row">
    <div class="col-lg-7">
      <div class="cta-content">
        <h3><%$movement_feature%></h3>
        <p><%$movement_description%></p>
        <div class="btn-box">
          <a href="#" class="site-btn"><%$learn_more%></a>
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
<%$this->js->add_js("front/posts.js")%>
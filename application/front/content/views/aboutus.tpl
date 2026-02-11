<!-- inner banner section start -->
<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
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
        <img src="<%$this->config->item('images_url')%>front/new-front-image/about-bg.png" alt="">
        <div class="inner-banner-content">
          <h2><%$about_us%></h2>
          <ul class="breadcum">
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!-- inner banner section end -->

<!-- about banner section strat -->
<section class="inner-content-sec">
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-9 col-md-12">
      <div class="about-top-content">
        <h3><%$about_us_one%></h3>
      </div>
    </div>
  </div>
  <div class="row align-items-center mb-120">
    <div class="col-lg-5">
      <div class="about-img-box">
        <div class="about-img">
          <img src="<%$this->config->item('images_url')%>front/new-front-image/abt-img.png" alt="">
        </div>
      </div>
    </div>
    <div class="col-lg-7">
      <div class="about-content">
        <!--<h3>There are many variations of passages</h3>-->
        <h5><%$about_us_two%></h5>
        <p><%$about_us_three%></p>
        <div class="abt-btn-box">
          <a href="#" class="site-btn-2"><%$learn_more%></a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="banner-reach">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/reach-img.png" alt="">
        <h3><%$its_almost_impossible%> <br> <%$not_to_make_it_happen_in%> <br><%$only_48_hours%></h3>
      </div>
    </div>
  </div>
</div>
</section>
<!-- about banner section end -->

<!-- inner-map section start -->
<section class="map-sec">
<div class="container">
  <div class="row align-items-center">
    <div class="col-lg-6">
      <div class="map-content">
        <h2><%$zoebook_is_in_all_platforms%></h2>
        <p><%$zoebook_is_in_all_platforms_desc%></p>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="map-image">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/map.png" alt="">
      </div>
    </div>
  </div>
</div>
</section>
<!-- inner-map section end -->

<!-- inner move section start -->
<section class="move-sec">
<div class="container">
  <img src="<%$this->config->item('images_url')%>front/new-front-image/cross.png" alt="" class="move-1">
  <img src="<%$this->config->item('images_url')%>front/new-front-image/yellow-circle.png" alt="" class="move-2">
  <img src="<%$this->config->item('images_url')%>front/new-front-image/green-circle.png" alt="" class="move-3">
  <img src="<%$this->config->item('images_url')%>front/new-front-image/dot.png" alt="" class="move-4">
  <div class="row align-items-center">
    <div class="col-lg-6">
      <div class="move-img-box">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/move-img.png" alt="">
      </div>
    </div>
    <div class="col-lg-6">
      <div class="move-content-box">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/spring.png" alt="">
        <h3> <%$a_quick_post_moves%><span><%$the_world_upward%></span></h3>
        <p><%$the_world_upword_desc%></p>
      </div>
    </div>
  </div>
</div>
</section>
<!-- inner move section end -->

<!-- inner cta section start -->
<section class="inner-cta-sec">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="inner-cta-content-box">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/cta-img.png" alt="">
        <div class="inner-cta-content">
          <h3><%$zoebook_is_everywhere%></h3>
          <p><%$zoebook_is_everywhere_desc%> </p>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<!-- inner cta section end -->

<!-- inner store section start -->
<section class="store-sec">
<div class="container">
  <div class="row align-items-center">
    <div class="col-lg-6">
      <div class="store-content">
        <h5><%$goal%></h5>
        <h2><span>2.5 Billion </span><br><%$app_downloads%> <br><%$in_five_years%></h2>
        <p><%$goal_last_desc%></p>
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
    <div class="col-lg-6">
      <div class="store-img-box">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/store-img.png" class="main-store-img" alt="">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/like.png" class="store-1" alt="">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/green-circle.png" class="store-2" alt="">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/dot.png" class="store-3" alt="">
      </div>
    </div>
  </div>
</div>
</section>
<!-- inner store section end -->

<!-- inner-stor bottom section start -->
<section class="store-bottom-sec">
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="store-bottom-box">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/heart.png" alt="" class="store-bottom-1">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/message.png" alt="" class="store-bottom-2">
        <img src="<%$this->config->item('images_url')%>front/new-front-image/like-white.png" alt="" class="store-bottom-3">
        <h3><%$about_us_last_desc%> <br><%$welcome_message%></h3>
      </div>
    </div>
  </div>
</div>
</section>
<!-- inner-stor bottom section end -->

<a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
<%$this->js->add_js("front/posts.js")%>
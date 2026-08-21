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
          <img src="<%$this->config->item('images_url')%>front/new-front-image/inner-banner.png" alt="">
          <div class="inner-banner-content">
            <h2><%$contact_us%></h2>
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
          <h3><%$contact_us%></h3>
          <p><%$home_description%></p>
          <div class="contact-list-box">
            <div class="contact-list-item call-box">
              <div class="contact-icon">
                <i class="fa-solid fa-phone-volume"></i>
              </div>
              <div class="contact-content">
                <p><%$contact_us%></p>
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
              <label class="vContactName"><%$first_name%></label>
              <input type="text" class="form-control" id="vContactName" name="vContactName" placeholder="<%$first_name%>">
              <div class="error-msg-form" id='vContactNameErr'></div>
            </div>
            <div class="col-md-6">
              <label class="form-label"><%$last_name%></label>
              <input type="text" class="form-control" placeholder="<%$last_name%>">
            </div>
            <div class="col-md-6">
              <label class="vContactEmail"><%$email%></label>
              <input type="email" class="form-control email-input" id="vContactEmail" name="vContactEmail" aria-describedby="emailHelp" placeholder="john@zoebook.com">
              <div class="error-msg-form" id='vContactEmailErr'></div>
            </div>
            <div class="col-md-6">
              <label class="form-label"><%$mobile_number%></label>
              <input type="text" class="form-control" placeholder="<%$mobile_number%>">
            </div>
            <div class="col-12">
                <label class="vContactMessage"><%$message%></label>
                <textarea class="form-control" id="vContactMessage" name="vContactMessage" maxlength="999" rows="3" style="resize:none" placeholder="<%$message%>"></textarea>
                <div class="error-msg-form" id='vContactMessageErr'></div>
            </div>

            <div class="g-recaptcha" data-sitekey="<%$this->config->item('GOOGLE_CAPTCHA_SITE_KEY')%>"></div>
            <div style="padding-bottom:10px;"></div>

            <div class="col-12">
              <button type="submit" class="btn btn-primary form-btn w-100" id="submitcontact" name="submitcontact"><%$submit%></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- contact form sec end -->
<a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
<%$this->js->add_js("front/posts.js")%>

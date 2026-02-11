<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<section class="login-sec">
    <div class="container-fluid p-0">
      <div class="row gx-0">
        <div class="col-lg-6 col-md-12">
          <div class="log-in-img">
            <img src="<%$this->config->item('images_url')%>front/new-front-image/logo.png" class="login" alt="">
            <h3><%$welcome%></h3>
            <p><%$login_text%></p>
            <div class="filter-store">
                <a href="<%$this->config->item('PLAY_STORE_LINK')%>" target="_blank">
                  <img src="<%$this->config->item('images_url')%>front/new-front-image/play-store.png" alt="">
                </a>
                <a href="<%$this->config->item('APP_STORE_LINK')%>">
                  <img src="<%$this->config->item('images_url')%>front/new-front-image/apple-store.png" alt="">
                </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 custom-scroll">
          <div class="login-form-box">
            <div class="login-form-heading">
              <h3><%$login%></h3>
              <p><%$its_quick_and_easy%></p>
            </div>
            <div class="login-form">
              <form class="cmn-form" id="frmlogin" name="frmlogin" action="<%$this->url->make('user/login_action')%>">
                <div class="form-group">
                  <label for="vLoginEmail"><%$email%></label>
                  <input type="email" class="form-control email-input" id="vLoginEmail" aria-describedby="emailHelp" placeholder="email@domain.com" name="User[vLoginEmail]">
                </div>
                <div class="error-msg-form" id='vLoginEmailErr'></div>
                
                <div class="form-group">
                  <label for="vLoginPassword"><%$password%></label>
                  <input type="password" class="form-control" id="vLoginPassword" name="User[vLoginPassword]" placeholder="Password">
                </div>
                <div class="error-msg-form" id='vLoginPasswordErr'></div>

                <div class="form-forgot">
                  <a href="javascript:void(0)" class="forgot-linkk" data-toggle="modal" data-target="#forgotModal"><%$forgot_password%>?</a>
                </div>
                <button type="submit" class="btn btn-primary form-btn"><%$submit%></button>
              </form>
            </div>
            <div class="form-divider">
              <p>Or</p>
            </div>
            <div class="form-social">
              <ul>
                <li><a href="<%$fbauthURL%>" class="fblogin" title="Facebook" data-id="<%$this->config->item('FB_APP_ID')%>"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="<%$googleloginURL%>" title="Google" class="googlelogin"><i class="fa-brands fa-google-plus-g"></i></a></li>
              </ul>
            </div>
            <div class="signup-box">
              <p><%$dont_have_an_account%>? <a href="javascript:void(0)" data-toggle="modal" data-target="#signupModal"><%$sign_up%></a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
   </section>

   <script>
    $(".box-switch").on("click", () => {
            $("body").toggleClass("dark");
         });
   </script>
   <%$this->js->add_js("front/posts.js")%>
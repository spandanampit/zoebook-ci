<section class="login-sec">
    <div class="container-fluid p-0">
      <div class="row gx-0">
        <div class="col-lg-6 col-md-12">
          <div class="log-in-img">
            <img src="<%$this->config->item('images_url')%>front/new-front-image/logo.png" class="login" alt="">
            <h3><%$welcome%></h3>
            <p><%$distraction_fact%></p>
            <div class="filter-store">
                <a href="<%$this->config->item('PLAY_STORE_LINK')%>">
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
              <h3><%$sign_up%></h3>
              <p><%$its_quick_and_easy%></p>
            </div>
            <div class="login-form">
              <form name="frmregister" id="frmregister" method="post" action="<%$this->url->make('user/register_action')%>" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="vEmail"><%$email%></label>
                  <input type="email" class="form-control email-input" aria-describedby="emailHelp" id="vEmail" name="User[vEmail]" placeholder="email@domain.com">
                </div>
                <div class="error-msg-form" id='vEmailErr'></div>

                <div class="form-group">
                  <label for="vName"><%$name%></label>
                  <input type="text" class="form-control" id="vName" name="User[vName]" placeholder="Name">
                </div>
                <div class="error-msg-form" id='vNameErr'></div>
                <div class="form-group">
                  <label for="vPassword"><%$password%></label>
                  <input type="password" class="form-control" id="vPassword" name="User[vPassword]" placeholder="Password">
                </div>
                <div class="error-msg-form" id='vPasswordErr'></div>

                <div class="form-group">
                  <label for="vConfirmPassword"><%$confirm_password%></label>
                  <input type="password" class="form-control" id="vConfirmPassword" name="User[vConfirmPassword]" placeholder="Password">
                </div>
                <div class="error-msg-form" id='vConfirmPasswordErr'></div>

                <div class="form-group">
                  <label for="vPhone"><%$mobile_number%></label>
                  <input type="text" class="form-control" id="vPhone" name="User[vPhone]" placeholder="+915879252558">
                </div>
                <div class="error-msg-form" id='vPhoneErr'></div> 

                <div class="form-group">
                  <label for="dDOB"><%$birthday%></label>
                  <input type="date" class="form-control" id="dDOB" name="User[dDOB]" placeholder="Date">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1"><%$gender%></label>
                  <select class="form-control" id="eGender" name="User[eGender]">
                    <option value="Male"><%$male%></option>
                    <option value="Female"><%$female%></option>
                    <option value="Others"><%$others%></option>
                  </select>
                </div>
                
                <div class="form-group" style="margin-top: 35px;">
                  <div class="g-recaptcha" data-sitekey="6Lc35isqAAAAAE2lVb0PercbNSgIAEt-K1t5V2-E"></div>
                </div>

                <div class="form-forgot">
                  <a href="javascript:void(0)" class="forgot-linkk" data-toggle="modal" data-target="#forgotModal"><%$forgot_password%>?</a>
                </div>

                <!--<input type="text" class="form-control d-none" id="sendMail" name="User[vSendMail]" placeholder="Send email">-->

                <input type="text" name="websiteUrl"  id="websiteUrl" class="form-control d-none" style="display:none">


                <button type="submit" class="btn btn-primary form-btn" title="Sign Up" id="signup"><%$submit%></button>
              </form>
            </div>
            <div class="form-divider">
              <p>Or</p>
            </div>
            <div class="form-social">
              <ul>
                <li><a href="<%$fbauthURL%>" class="fblogin" title="Facebook" data-id="<%$this->config->item('FB_APP_ID')%>"><i class="fa-brands fa-facebook-f"></i></a></li>
                <li><a href="<%$googleloginURL%>" title="Google" class="googlelogin" ><i class="fa-brands fa-google-plus-g"></i></a></li>
              </ul>
            </div>
            <div class="signup-box">
              <p><%$dont_have_an_account%>? <a href="<%$this->url->make('content/content/index')%>">Login</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
   </section>
  <!--<script src="https://www.google.com/recaptcha/api.js" async defer></script>-->

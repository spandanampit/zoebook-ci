<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
    <head>
        <%strip%>
        <meta charset="utf-8" />
        <base href="<%$this->config->item('site_url')%>" />
        <%/strip%>
        <meta name="msvalidate.01" content="E76B2755F941FF54A8179D2B34122508" />
        <title><%if $meta_info|is_array && $meta_info['title'] neq ''%><%$meta_info['title']%><%else%><%$this->systemsettings->getSettings('META_TITLE')%><%/if%></title>
        <link rel="shortcut icon" href="<%$this->general->getCompanyFavIconURL()%>" />
        <meta name="description" content="<%if $meta_info|is_array && $meta_info['description'] neq ''%><%$meta_info['description']%><%else%><%$this->systemsettings->getSettings('META_DESCRIPTION')%><%/if%>" />
        <meta name="keywords" content="<%if $meta_info|is_array && $meta_info['keywords'] neq ''%><%$meta_info['keywords']%><%else%><%$this->systemsettings->getSettings('META_KEYWORD')%><%/if%>" />
        <%if $meta_info|is_array && $meta_info['other']|is_array%>
            <%assign var="meta_other" value=$meta_info['other']%>
            <%section name=i loop=$meta_other%>
                <meta <%$meta_other[i]['key']%>="<%$meta_other[i]['value']%>" content="<%$meta_other[i]['content']%>" />
            <%/section%>
        <%else%>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <%if $this->systemsettings->getSettings('META_OTHER') neq ''%>
                <%$this->systemsettings->getSettings('META_OTHER')%>
            <%/if%>
        <%/if%>
        <%$this->css->add_css("front/bootstrap/bootstrap.min.css","front/font-awesome/icons.css","front/reset.css","front/owl/owl.carousel.min.css","front/owl/owl.theme.default.min.css","front/animate.css","front/style.css","front/jquery.scrollSections.css","front/media.css")%>
        <%$this->css->css_src()%>
        <script type='text/javascript'>
            var site_url = '<%$this->config->item("site_url")%>';
            var fb_url = '';
        </script>
        <%$this->general->getJSLanguageLables()%>
        <%$this->js->add_js("front/jquery-2.2.4.js","front/bootstrap/bootstrap.min.js","front/owl/owl.carousel.min.js","front/wow/wow.min.js","front/plugins.js","customslider/jquery_007.js","front/customslider/jquery_002.js","front/customslider/custom-slider.js","front/jquery.scrollSections.js","front/jquery.scrollSections.js","front/bootstrap-material/material.min.js","front/custom-designer.js","front/vendor/modernizr-2.5.3.min.js")%>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>
        <nav id="scrollsections-navigation">
          <div class="container">
            <div class="navbar-header">
              <button id="ChangeToggle" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
              <div id="navbar-close" class="hidden"> <span class="glyphicon glyphicon-remove"></span> </div>
              <a class="navbar-brand " data-scroll-nav="1" href="#home" title=""><img src="<%$admin_image_url%>public/images/front/logo-z-shrink.png"  alt=""></a> </div>
            <div class="collapse navbar-collapse hdrht" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <!--<li><a href="#home" title="">Home</a></li>-->
                <li><a href="#about" title="">Our Features </a></li>
                <li><a href="#achievegoal" title="">Screenshot </a></li>
                <li><a href="#achieveaboutus" title="">About Us</a></li>
                <li><a href="#achievecom" title="">Contact Us</a></li>
              </ul>
            </div>
          </div>
        </nav>
        <div id="midd-container" class="middle-section">
            <!-- middle part start here-->
            <%include file=$include_script_template%>
            <!-- middle part end here-->
        </div>
        <footer class="ft">
         <div class="container">
        <div class="row">
          <div class=" col-md-12">
            <div class="btm-logo wow zoomInUp"><a  href="index.html"><img src="<%$admin_image_url%>public/images/front/logo-z.png"  alt=""></a> </div>
            <div class="btm-storbtn wow fadeInDown">
              <div class="android-app"><a href="<%$this->config->item('PLAY_STORE_LINK')%>" target="_blank">
                <figure><img src="<%$admin_image_url%>public/images/front/btn-goggleplay.png" alt="google-play"></figure>
                </a></div>
              <div class="ios-app"><a href="<%$this->config->item('APP_STORE_LINK')%>" target="_blank">
                <figure><img src="<%$admin_image_url%>public/images/front/btn-appstore.png" alt="apple-store"></figure>
                </a></div>
                <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
         <div class="social-icons wow fadeInUp">
          <div class="container">
            <div class="row">
              <div class="cpy">© 2018 Zoebook</div>
              <div class="scl-icons-sec">
                <ul>
                  <li><a href="<%$this->config->item('FACEBOOK_LINK')%>" target="_blank"><i class="sprites ico-fb"></i></a></li>
                  <li><a href="<%$this->config->item('GOOGLE_PLUS_LINK')%>" target="_blank"><i class="sprites ico-gpl"></i></a></li>
                </ul>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
        </footer>
        <%if $this->systemsettings->getSettings('GOOGLE_ANALYTICS')|@trim neq ''%>
            <script type="text/javascript">
                <%$this->systemsettings->getSettings('GOOGLE_ANALYTICS')%>
            </script>
        <%/if%>
        <%$this->css->css_src()%>
        <%$this->js->js_src()%>
        <script type='text/javascript'>
            $(document).ready(function () {
                Project.init();
            });
        </script>
    </body>
</html>

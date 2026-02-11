<!DOCTYPE html>
<html lang="en">
    <head>
        <%strip%>
            <meta charset="utf-8" />
            <base href="<%$this->config->item('site_url')%>" />
        <%/strip%>
        <title><%$this->session->flashdata('failure')%><%if $meta_info|is_array && $meta_info['title'] neq ''%><%$meta_info['title']%><%else%><%$this->systemsettings->getSettings('META_TITLE')%><%/if%></title>
        <link rel="shortcut icon" href="<%$this->general->getCompanyFavIconURL()%>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<%if $meta_info|is_array && $meta_info['description'] neq ''%><%$meta_info['description']%><%else%><%$this->systemsettings->getSettings('META_DESCRIPTION')%><%/if%>" />
        <meta name="keywords" content="<%if $meta_info|is_array && $meta_info['keywords'] neq ''%><%$meta_info['keywords']%><%else%><%$this->systemsettings->getSettings('META_KEYWORD')%><%/if%>" />

        <meta property="og:title" content="<%$ogTitle|html_entity_decode|strip_tags%>"/>
        <meta property="og:type" content="<%$ogType%>"/>
        <meta property="og:description" content="<%$ogDescription|html_entity_decode|strip_tags%>"/>
        <meta property="og:site_name" content="Zoebook"/>
        <meta property="og:locale" content="en_GB" />
        <meta property="article:author" content="https://zoebook.com/contactus.html" />
        <meta property="article:section" content="India" />
        <meta property="og:url" content="<%$ogUrl%>"/>
        <meta property="og:image" content="<%$ogImage%>"/>
        <meta property="og:image:alt" content="Zoebook. Post from user" />
<%*        <meta property="og:title" content="God is good \ud83d\ude4f\ud83d\ude4c"/>
        <meta property="og:type" content="website"/>
        <meta property="og:description" content="God is good \ud83d\ude4f\ud83d\ude4c"/>
        <meta property="og:site_name" content="Zoebook"/>
        <meta property="og:locale" content="en_GB" />
        <meta property="article:author" content="https://zoebook.com/contactus.html" />
        <meta property="article:section" content="India" />
        <meta property="og:url" content="<%$ogUrl%>"/>
        <meta property="og:image" content="https://zoebook.s3.amazonaws.com/post_media/11/File0-20200613200614588008.png"/>
        <meta property="og:image:alt" content="Zoebook. Post from user" />*%>

        <meta property="fb:app_id" content="<%$this->systemsettings->getSettings('FB_APP_ID')%>"/>

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

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <%$this->css->add_css("custom-scrollbar/css/jquery.mCustomScrollbar.css","front/bootstrap.min.css","front/font-awesome/css/all.min.css", "front/owl.carousel.min.css", "front/jquery.mCustomScrollbar.css","front/jquery-ui.css","front/font-face.css", "front/style.css", "front/custom-designer.css", "front/custom-developer.css", "front/media.css","front/bootstrap_datepicker.css", "front/dev.css")%>
        <%$this->css->add_css("custom-scrollbar/css/jquery.mCustomScrollbar.css", "front/new-css/bootstrap.min.css", "front/new-css/all.min.css", "front/new-css/owl.carousel.min.css", "front/new-css/owl.theme.default.min.css", "front/new-css/responsive.css", "front/new-css/style.css")%>
        <%$this->css->add_css("libraries/emoji_picker/emoji.css")%>
        <%$this->css->css_src()%>
        <script type='text/javascript'>
            var site_url = '<%$this->config->item("site_url")%>';
        </script>
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <%$this->general->getJSLanguageLables()%>
        <%$this->js->add_js("front/jquery.min.js","front/jquery-ui.js","front/popper.min.js","front/bootstrap.min.js", "front/owl.carousel.js", "front/jquery.mCustomScrollbar.concat.min.js", "front/circle-progress.js", "front/bootbox.min.js", "front/custom-designer.js")%>

        <%$this->js->add_js("front/custom-developer.js")%>

        <%$this->js->add_js("libraries/emoji_picker/config.js","libraries/emoji_picker/util.js","libraries/emoji_picker/jquery.emojiarea.js","libraries/emoji_picker/emoji-picker.js")%>

        <%$this->js->add_js("validate/jquery.validate.min.js","validate/additional-methods.min.js","common.js","front/bootstrap-datepicker.js","blockui/jquery.blockUI.min.js","custom-scrollbar/js/jquery.mCustomScrollbar.concat.min.js")%>
        <%$this->js->add_js("front/firebase/firebase-app.js")%>
        <%$this->js->add_js("front/firebase/firebase-database.js")%>
        <%$this->js->add_js("front/firebase/firebase-analytics.js")%>
        <%$this->js->add_js("front/firebase/firebase-auth.js")%>
        <%$this->js->add_js("front/firebase-config.js")%>
        <%$this->js->add_js("front/sweetalert.min.js")%>
    </head>
    <body class="<%if $islandinglcass eq 'yes'%>landing-page<%/if%>  loggedin">
        <div id="main-container" class="main-container">
            <div id="inner-container" class="inner-container">
                <header>
                    <!--top-part start here-->
                    <%include file="top/top.tpl"%>
                    <!--top-part End here-->
                </header>
                <main>
                    <%assign var="msg_box_style" value="display:none;"%>
                    <%assign var="msg_box_class" value=""%>
                    <%assign var="msg_box_close" value=""%>
                    <%assign var="msg_box_text" value=""%>
                    <%if $this->session->flashdata('success') neq ''%>
                        <%assign var="msg_box_style" value="display:block;"%>
                        <%assign var="msg_box_class" value="alert-success"%>
                        <%assign var="msg_box_close" value="success"%>
                        <%assign var="msg_box_text" value=$this->session->flashdata('success')%>
                    <%elseif $this->session->flashdata('failure') neq ''%>
                        <%assign var="msg_box_style" value="display:block;"%>
                        <%assign var="msg_box_class" value="alert-error"%>
                        <%assign var="msg_box_close" value="error"%>
                        <%assign var="msg_box_text" value=$this->session->flashdata('failure')%>
                    <%elseif $this->session->flashdata('warning') neq ''%>
                        <%assign var="msg_box_style" value="display:block;"%>
                        <%assign var="msg_box_class" value="alert-warning"%>
                        <%assign var="msg_box_close" value="warning"%>
                        <%assign var="msg_box_text" value=$this->session->flashdata('warning')%>
                    <%elseif $this->session->flashdata('info') neq ''%>
                        <%assign var="msg_box_style" value="display:block;"%>
                        <%assign var="msg_box_class" value="alert-info"%>
                        <%assign var="msg_box_close" value="info"%>
                        <%assign var="msg_box_text" value=$this->session->flashdata('info')%>
                    <%/if%>
                    <div class="errorbox-position" id="var_msg_cnt" style="<%$msg_box_style%>">
                        <div class="closebtn-errorbox <%$msg_box_close%>" id="closebtn_errorbox">
                            <a href="javascript:void(0);" onClick="Project.closeMessage();"><button class="close" type="button">×</button></a>
                        </div>
                        <div class="content-errorbox alert <%$msg_box_class%>" id="err_msg_cnt"><%$msg_box_text%></div>
                    </div>

                    <!-- middle part start here-->
                    <%include file=$include_script_template%>
                    <!-- middle part end here-->
                </main>
            </div>
            <footer>
                <!--footer-part start here-->
                <%include file="bottom/footer.tpl"%>
                <!--footer-part End here-->
            </footer>

        <%if $islandinglcass eq 'yes'%>
        <!-- Signup Modal Popup -->
        <%include file="../user/views/register_modal.tpl"%>

        <!-- for Modal Popup -->
        <%include file="../user/views/forgot_modal.tpl"%>
        <%/if%>

  <%if $this->session->userdata('iUserId') neq ''%>
  <div class="modal fade cmn-modal" id="browseprofile" tabindex="-1" role="dialog" aria-labelledby="browseprofileLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title text-center" id="browseprofileLabel" >Browse Profiles</h5>
              </div>
              <div class="modal-body">
                  <div class="follow-friend-block scrollbarContent" id="modalfollowuser">
                      <input type="hidden" name="setuserid" id="setuserid" value="<%$this->session->userdata('iUserId')%>">
                      <div class="follow-friend-list" id="listbrowseprofile" style="text-align: center;">
                          <i class="fas fa-spinner mr-2"></i> Loading Please Wait ..
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>

    <div class="modal fade cmn-modal" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center modal-header-common" id="exampleModalLabel"></h5>
                </div>
                <div class="modal-body">
                    <div class="notifications-list scrollbarContent">
                        <ul id="notifications_list_container">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <%/if%>


        </div>
        <%if $this->session->userdata('iUserId') > 0 %>
            <!--Chat Popup Start-->
            <%include file="../home/views/common/chat_popup.tpl" %>
            <!--Chat Popup End-->
        <%/if%>
        
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-170794673-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-170794673-1');
        </script>
        
        <%$this->css->css_src()%>
        <%$this->js->js_src()%>
        <script type='text/javascript'>
            var sess_user_id = '<%$this->session->userdata("iUserId")%>';
            is_logged = "No";
            if(sess_user_id > 0){
                is_logged = "Yes";
            }
            $(document).ready(function () {
                Project.init();
            });
        </script>

    </body>
</html>

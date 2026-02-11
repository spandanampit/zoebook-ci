<!DOCTYPE html>
<html lang="en">
<head>
  <%strip%>
  <meta charset="utf-8" />
  <base href="<%$this->config->item('site_url')%>" />
  <%/strip%>
  <title><%$this->session->flashdata('failure')%> <%if $meta_info|is_array && $meta_info['title'] neq ''%><%$meta_info['title']%><%else%><%$this->systemsettings->getSettings('META_TITLE')%><%/if%></title>
  <link rel="shortcut icon" href="<%$this->general->getCompanyFavIconURL()%>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <%$this->css->add_css("front/bootstrap.min.css","front/font-awesome/css/all.min.css", "front/owl.carousel.min.css", "front/font-face.css", "front/style.css", "front/custom-designer.css", "front/custom-developer.css", "front/media.css","front/bootstrap_datepicker.css")%>
        <%$this->css->css_src()%>
        <script type='text/javascript'>
            var site_url = '<%$this->config->item("site_url")%>';
        </script>
        <%$this->general->getJSLanguageLables()%>
        <%$this->js->add_js("front/jquery.min.js","front/popper.min.js","front/bootstrap.min.js", "front/owl.carousel.js", "front/circle-progress.js", "front/custom-designer.js", "front/custom-developer.js")%>
        <%$this->js->add_js("validate/jquery.validate.min.js","validate/additional-methods.min.js","common.js","front/bootstrap-datepicker.js","blockui/jquery.blockUI.min.js")%>

</head>
<body class="landing-page">
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

    <!-- Signup Modal Popup -->
    <%include file="../user/views/register_modal.tpl"%>

    <!-- for Modal Popup -->
    <%include file="../user/views/forgot_modal.tpl"%>

  </div>
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

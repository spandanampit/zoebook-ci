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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.min.css" />

        <meta property="fb:app_id" content="<%$this->systemsettings->getSettings('FB_APP_ID')%>"/>
        <!--<meta name="google-adsense-account" content="ca-pub-5186045650038047">-->
        <meta name="monetag" content="0687985c90cfcc4b623f9f205c95d8d7">

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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" crossorigin="anonymous">
        <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">


        <%$this->css->add_css("custom-scrollbar/css/jquery.mCustomScrollbar.css","front/bootstrap.min.css","front/font-awesome/css/all.min.css", "front/owl.carousel.min.css", "front/jquery.mCustomScrollbar.css","front/jquery-ui.css", "front/style.css", "front/media.css","front/bootstrap_datepicker.css", "front/dev.css")%>
        <%$this->css->add_css("front/new-css/bootstrap.min.css", "front/new-css/owl.carousel.min.css", "front/new-css/owl.theme.default.min.css", "front/new-css/responsive.css", "front/new-css/style-new.css", "front/new-css/all.min.css")%>
        <%if $page_type eq 'movement'%>
            <%$this->css->add_css("front/movement-css/style.css")%>
        <%/if%>
        <%$this->css->add_css("libraries/emoji_picker/emoji.css")%>
        <%$this->css->css_src()%>

        <link href="https://unpkg.com/cloudinary-video-player/dist/cld-video-player.css" rel="stylesheet">

        <script type='text/javascript'>
            var site_url = '<%$this->config->item("site_url")%>';
        </script>
        <script src='https://www.google.com/recaptcha/api.js' async defer></script>
        <%$this->general->getJSLanguageLables()%>
        <%$this->js->add_js("front/jquery-ui.js","front/popper.min.js","front/bootstrap.min.js", "front/owl.carousel.js", "front/jquery.mCustomScrollbar.concat.min.js", "front/circle-progress.js", "front/bootbox.min.js", "front/custom-designer.js", "front/userprofile.js", "front/new-js/jquery.min.js", "front/new-js/owl.carousel.js", "front/new-js/custom.js")%>
        <%$this->js->add_js("front/custom-developer.js")%>

        <%if $page_type eq 'movement'%>
            <%$this->js->add_js("front/movement-js/custom.js", "front/movement-js/jquery.min.js", "front/movement-js/posts.js")%>
        <%/if%>

        <%$this->js->add_js("libraries/emoji_picker/config.js","libraries/emoji_picker/util.js","libraries/emoji_picker/jquery.emojiarea.js","libraries/emoji_picker/emoji-picker.js")%>

        <%$this->js->add_js("validate/jquery.validate.min.js","validate/additional-methods.min.js","common.js","front/bootstrap-datepicker.js","blockui/jquery.blockUI.min.js","custom-scrollbar/js/jquery.mCustomScrollbar.concat.min.js")%>
        <%$this->js->add_js("front/firebase/firebase-app.js")%>
        <%$this->js->add_js("front/firebase/firebase-database.js")%>
        <%$this->js->add_js("front/firebase/firebase-analytics.js")%>
        <%$this->js->add_js("front/firebase/firebase-auth.js")%>
        <%$this->js->add_js("front/firebase/firebase-storage.js")%>
        <%$this->js->add_js("front/firebase-config.js")%>
        <%$this->js->add_js("front/sweetalert.min.js")%>
        <!--<script src="https://alwingulla.com/88/tag.min.js" data-zone="75134" async data-cfasync="false"></script>-->
    </head>
    <body class="<%if $islandinglcass eq 'yes'%>landing-page<%/if%>">
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

        <div class="modal fade cmn-modal" id="browseprofile" tabindex="-1" role="dialog" aria-labelledby="browseprofileLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 78%">
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

  <%if $this->session->userdata('iUserId') neq ''%>
  <!-- notification popup start -->
  <div class="modal fade notification-popup" id="notificationModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center modal-header-common" id="staticBackdropLabel">Notification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeNotification()"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <div class="modal-body">
        <div class="notification-active notifications-list scrollbarContent">
          <ul id="notifications_list_container">
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- notification popup end -->

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

        <script type="text/javascript">
            //open_sticker_section

            $(document).on('click', '.open_gif_section', function(){
                var postId = $(this).data('gif-post-id');
                runGifStickerProgram('gifs',postId);
            });

            $('.open_sticker_section').on('click', function(){
                var postId = $(this).data('sticker-post-id');
                runGifStickerProgram('stickers',postId);
            });

            function runGifStickerProgram(types,post_Id){

                var type = types;

                var postId = post_Id;

                $('.gif_section_'+postId).show();

                $('.close_gif_div_'+postId).on('click', function(){
                    $('.gif_section_'+postId).hide();
                    $('#searchInput_'+postId).val('');
                });

                if(type=='gifs')
                {
                    $('#searchInput_'+postId).attr('placeholder','Search for GIFs');
                }
                if(type=='stickers'){
                    $('#searchInput_'+postId).attr('placeholder','Search for Stickers');
                }

                searchGifs();

                function displayGifs(gifs) {
                    const gifPicker = $('#gifPicker_'+postId);
                    gifPicker.empty();
                    gifs.forEach(gif => {
                        const img = $('<img>').attr('src', gif.images.downsized_medium.url).attr('alt', gif.title).click(() => {
                            $('#selectedGifUrl_'+postId).val(gif.images.original.url);
                            $('div.comment_post_'+postId).append(gif.images.original.url);
                            $('div.comment_post_'+postId).focus();
                            $('.close_gif_div_'+postId).trigger('click');
                            gifPicker.empty();
                        });
                        gifPicker.append(img);
                    });
                }

                function searchGifs(query) {
                    $.ajax({
                        url: `https://api.giphy.com/v1/${type}/search?api_key=${apiKey}&q=${query}&limit=50`,
                        method: 'GET',
                        success: (response) => {
                            const gifs = response.data;
                            displayGifs(gifs);
                        },
                        error: (xhr, status, error) => {
                            console.error(error);
                        }
                    });
                }

                $('#searchInput_'+postId).on('input', (e) => {
                    const searchTerm = e.target.value.trim();
                    if (searchTerm !== '') {
                        searchGifs(searchTerm);
                    }else{
                        searchGifs();
                    }
                });
            }

        </script>

        <script>

            const apiKey = 'ipXu0ONVnGDpzTs7wdxLFQvCYL8EYzm6';

            $(document).on('click', '.open_reply_gif_section', function () {

                //alert('dfdsf');

                var postId = $(this).data('gif-postid');
                var postCommentId = $(this).data('gif-postcommentid'); 

                runReplyGifStickerProgram('gifs', postId, postCommentId);

            });

            $(document).on('click', '.open_reply_sticker_section', function () {

                //alert('dfdsf');

                var postId = $(this).data('sticker-postid');
                var postCommentId = $(this).data('sticker-postcommentid'); 

                runReplyGifStickerProgram('stickers', postId, postCommentId);

            });

            function runReplyGifStickerProgram(types,post_Id, post_CommentId){

                //alert('sdfdsf');

                var type = types;

                var postId = post_Id;
                var postCommentId = post_CommentId;

                $('.reply_gif_section_'+postId).show();

                $('.reply_close_gif_div_'+postId).on('click', function(){
                    $('.reply_gif_section_'+postId).hide();
                    $('#reply_searchInput_'+postId).val('');
                });

                if(type=='gifs')
                {
                    $('#reply_searchInput_'+postId).attr('placeholder','Search for GIFs');
                }
                if(type=='stickers'){
                    $('#reply_searchInput_'+postId).attr('placeholder','Search for Stickers');
                }

                replySearchGifs();

                function replyDisplayGifs(gifs) {
                    const gifPicker = $('#reply_gifPicker_'+postId);
                    gifPicker.empty();
                    gifs.forEach(gif => {
                        const img = $('<img>').attr('src', gif.images.downsized_medium.url).attr('alt', gif.title).click(() => {
                            // alert(postId);
                            // alert(gif.images.original.url);
                            $('#replycommentad_'+postCommentId).val(gif.images.original.url);
                            $('div.reply_comment_post_'+postId).append(gif.images.original.url);
                            $('div.reply_comment_post_'+postId).focus();
                            $('.reply_close_gif_div_'+postId).trigger('click');
                            gifPicker.empty();
                        });
                        gifPicker.append(img);
                    });
                }

                function replySearchGifs(query) {
                    $.ajax({
                        url: `https://api.giphy.com/v1/${type}/search?api_key=${apiKey}&q=${query}&limit=50`,
                        method: 'GET',
                        success: (response) => {
                            const gifs = response.data;
                            replyDisplayGifs(gifs);
                        },
                        error: (xhr, status, error) => {
                            console.error(error);
                        }
                    });
                }

                $('#reply_searchInput_'+postId).on('input', (e) => {
                    const searchTerm = e.target.value.trim();
                    if (searchTerm !== '') {
                        replySearchGifs(searchTerm);
                    }else{
                        replySearchGifs();
                    }
                });
            }
        </script>

        <script>
        
            $('.chat_open_gif_section').on('click', function(){
                runChatGifStickerProgram('gifs');
            });

            $('.chat_open_sticker_section').on('click', function(){
                runChatGifStickerProgram('stickers');
            });

            function runChatGifStickerProgram(types){

                var type = types;

                $('.chat_gif_section').fadeIn(400);

                $('.chat_close_gif_div').on('click', function(){
                    $('.chat_gif_section').fadeOut(400);
                    $('#chat_searchInput').val('');
                });

                if(type=='gifs')
                {
                    $('#chat_searchInput').attr('placeholder','Search for GIFs');
                }
                if(type=='stickers'){
                    $('#chat_searchInput').attr('placeholder','Search for Stickers');
                }

                chatSearchGifs();

                function chatDisplayGifs(gifs) {
                    const gifPicker = $('#chat_gifPicker');
                    gifPicker.empty();
                    gifs.forEach(gif => {
                        const img = $('<img style="width: auto !important;">').attr('src', gif.images.downsized_medium.url).attr('alt', gif.title).click(() => {
                            //alert(gif.images.original.url);
                            $('#message_input').val(gif.images.original.url);
                            $('div.message-input').append(gif.images.original.url);
                            // $('div.comment_post_'+postId).focus();
                            // $('.close_gif_div_'+postId).trigger('click');
                            // gifPicker.empty();
                        });
                        gifPicker.append(img);
                    });
                }

                function chatSearchGifs(query) {
                    $.ajax({
                        url: `https://api.giphy.com/v1/${type}/search?api_key=${apiKey}&q=${query}&limit=50`,
                        method: 'GET',
                        success: (response) => {
                            const gifs = response.data;
                            chatDisplayGifs(gifs);
                        },
                        error: (xhr, status, error) => {
                            console.error(error);
                        }
                    });
                }

                $('#chat_searchInput').on('input', (e) => {
                    const searchTerm = e.target.value.trim();
                    if (searchTerm !== '') {
                        chatSearchGifs(searchTerm);
                    }else{
                        chatSearchGifs();
                    }
                });
            }
        </script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/cloudinary-core/2.3.0/cloudinary-core-shrinkwrap.js"></script>
        <script type="text/javascript" src="https://unpkg.com/cloudinary-video-player/dist/cld-video-player.js"></script>
        <script type="text/javascript">
            var cld = cloudinary.Cloudinary.new({ cloud_name: 'dmiqh8jar' });

            // Initialize players
            var players = cld.videoPlayers('.cld-video-player', {
            autoplay: true,
            controls: true,
            showLogo: false,
            fluid: true,
            aiHighlightsGraph: true,
            colors: {
                base: '#0C0C0C',
                accent: '#0D6EFF',
                text: '#F1EBF1'
            },
            fontFace: 'Handlee',
            transformation: { width: 500, crop: 'limit' }
            });
        </script>

<script>
function closeNotification() {
  $('#notificationModal').modal('hide');
}
</script>
    </body>
</html>

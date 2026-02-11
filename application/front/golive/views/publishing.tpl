
<style type="text/css">
    #videos {
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: auto;
    margin-right: auto;
}

#publisher {
    position: absolute;
    width: 98%;
    height: calc(100vh - 306px) !important;
    top: 3%;
    bottom: 9%;
    left: 1%;
    left: 1%;
    z-index: 100;
    border: 3px solid white;
    border-radius: 14px;
}
h3{
    color: #fff;
    margin: 0 auto;
    padding: 9px;
    font-size: 21px;
}
.live-user-comment{
    z-index: 1111;
    height: auto;
}
.stream-msg-history{
    max-height: 500px;
    overflow: auto;
}
.btn{
    margin-bottom: 10px !important;
}

</style>
<div class="golive-page dashboard-sec">
    <div class="container">
        <div class="live-screen">
            <div class="live-streaming">
                <h3>&nbsp;You are live <%$get_post_details['user_name']%></h3>
                <div id="videos">
                    <div id="publisher"></div>
                </div>
                <div class="live-timer">
                    <div class="impression" style="background-color: transparent !important;">
                    </div>
                </div>
                <div class="live-user-comment">
                    <ul class="msg-header">
                        <li class="frist-li">
                            <div class="cmn-user">
                                <i class="cmn-user-img">
                                    <img src="<%$get_post_details['user_profile_image']%>" alt="<%$get_post_details['user_name']%>">
                                </i>
                                <div class="cmn-user-name">
                                    <h6><a href="#"><%$get_post_details['user_name']%></a></h6>
                                    <p><%$get_post_details['post_text']%></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="stream-msg-history">
                    </ul>
                    <ul class="message-text">
                        <li class="type-live-msg">
                            <textarea rows="2" class="form-control stream-message-input" placeholder="Write your message" onkeypress="onTextChange();"></textarea>
                        </li>
                    </ul>
                </div>
                <div class="finish-btn-row">
                    <div class="live-timer">
                        <div class="timer">
                            <span><i class="fas fa-circle"></i> Live</span>
                            <span id="down_timer" style="color:#fff !important">00:00:00</span>
                        </div>
                    </div>
                    <button type="button" class="btn finish-stream" ><i class='fas fa-phone-slash' style='color:white'></i> Finish</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var apiKey = "<%$this->config->item('TOKBOX_PROJECT_API_KEY')%>";
var sessionId = '<%$session_id%>';
var tokbox_session_id = '<%$tokbox_session_id%>';
var token = "<%$token%>";
// const live_token = "<%$token%>";
console.log('tokennnnnnnn'+ token);
var startStamp = '<%$start_date_time%>';
var profile_name = "<%$this->session->userdata('vName')%>" ;
var profile_image = "<%$this->session->userdata('vProfileImage')%>";

</script>
<script>

    $(document).ready(function() {
        // Initialize Emoji Picker
        $('.stream-message-input').emojiPicker({
            width: '300px',
            height: 'auto',
            button: false
        });

        // Emoji Picker Toggle on click
        $('.stream-message-input').click(function() {
            $(this).emojiPicker('toggle');
        });

        // Open GIF section
        $('.open_gif_section').click(function() {
            var postId = $(this).data('gif-post-id');
            $('.gif_section_' + postId).show();
        });

        // Close GIF section
        $('.close_gif_div_').click(function() {
            var postId = $(this).data('gif-post-id');
            $('.gif_section_' + postId).hide();
        });

        // Handle file upload (for stickers/GIFs)
        $('.btn_post_media_attach').click(function() {
            var postId = $(this).find('.btn_postmedia').data('postid');
            $('#input_media_' + postId).click();
        });

        // Handle sticker selection (example placeholder)
        $('.open_sticker_section').click(function() {
            var postId = $(this).data('sticker-post-id');
            alert('Sticker selected for post ID: ' + postId);
        });
    });
</script>
<%$this->js->add_js("front/opentok/opentok.min.js")%>
<%$this->js->add_js("front/opentok/publish.js")%>
<%$this->js->add_js("front/chat-count.js")%>




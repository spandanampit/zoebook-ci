<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
<style type="text/css">
    #videos {
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: auto;
    margin-right: auto;
}

#subscriber {
    position: absolute;
    width: 98%;
    height: 83%;
    top: 3%;
    bottom: 5%;
    left: 1%;
    left: 1%;
    z-index: 100;
    border: 3px solid white;
    border-radius: 3px;
}
h3{
    color: #fff;
    margin: 0 auto;
}
.live-user-comment{
    z-index: 1111;
    height: auto;
}
.stream-msg-history{
    max-height: 500px;
    overflow: auto;
}
</style>
<div class="golive-page">
    <div class="container">
        <div class="live-screen">
            <div class="live-streaming">
            <h3><%$get_post_details['user_name']%> is live now @ "<%$get_post_details['post_text']%>"</h3>
            <div id="videos">
                <div id="subscriber"></div>
            </div>
                <div class="live-timer">
                    <div class="timer">
                        <span><i class="fas fa-circle"></i> Live</span>
                        <span id="down_timer">00:00:00</span>
                    </div>
                    <div class="impression">
                    </div>
                </div>
                <div class="live-user-comment">
                    <ul class="msg-header">
                        <li class="frist-li">
                            <div class="cmn-user">
                                <i class="cmn-user-img">
                                    <img src="<%$get_post_details['user_profile_image']%>" alt="<%$get_post_details['user_name']%><">
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
                            <textarea rows="2" class="form-control stream-message-input" placeholder="Write your message text" onkeypress="onTextChange();"></textarea>
                        </li>
                    </ul>
                </div>
                <div class="finish-btn-row">
                    <button type="button" class="btn leave-stream" ><i class="fas fa-sign-out-alt"></i> Leave</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
var apiKey = "<%$this->config->item('TOKBOX_PROJECT_API_KEY')%>";
var sessionId = '<%$session_id%>';
var token = "<%$token%>";
console.log('stream token:'+ token);
var startStamp = '<%$start_date_time%>';
var profile_name = "<%$this->session->userdata('vName')%>" ;
var profile_image = "<%$this->session->userdata('vProfileImage')%>";
</script>
<%$this->js->add_js("front/opentok/opentok.min.js")%>
<%$this->js->add_js("front/opentok/stream.js")%>
<%$this->js->add_js("front/chat-count.js")%>


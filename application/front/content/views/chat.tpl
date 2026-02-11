<style type="text/css">
    .chat-block{display: none;}
</style>
<%$this->js->add_js("front/chat.js")%>
<div class="post-pages chat-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="cmn-white-block left-panel online-people-block">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <input type="hidden" name="firebase_token" id="firebase_token" value="<%$this->session->userdata('firebase_token')%>">
                            <input type="hidden" name="user_id" id="user_id" value="<%$this->session->userdata('iUserId')%>">
                            <input type="hidden" name="username" id="username" value="<%$this->session->userdata('vName')%>">
                            <input type="hidden" name="email" id="email" value="<%$this->session->userdata('vEmail')%>">
                            <input type="hidden" name="profile_image" id="profile_image" value="<%$this->session->userdata('vProfileImage')%>">
                            <div>Friends</div>
                            <div class="search-friend">
                                <div class="ui-widget">
                                    <span class="fa fa-search"></span>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="search" placeholder="Search">
                        </div>
                        <div class="inbox_chat_list">
                            <ul>
                                <span>Connecting.....! </span><br>
                                <span>Please wait while we fetch your chats..!</span>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="cmn-white-block">
                    <div class="message-user">

                    </div>
                    <div class="messaging">
                        <div class="inbox_msg">
                            <div class="mesgs">
                                <div class="msg_history">
                                <h3>Welcome to Zoebook Chat.</h3>
                                <h4>Lets Connect to the World.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="message-type hide">
                        <div class="input_msg_write">
                            <input type="text" class="form-control message-input" id="message_input" placeholder="Type a message" autofocus/>
                            <button class="msg_send_btn" type="button"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



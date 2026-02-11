<%$this->js->add_js("front/chat-count.js")%>
<style>
.badge{
    position: relative;
    background: red;
    top: -11px;
    right: 13px;
    border-radius: 22px;
}
</style>

<div class="col-xl-3 col-md-12">
    <div class="sidebar" style="margin-left: -43px;"> 
    <form class="cmn-form" name="frmprofilepic" id="frmprofilepic" method="post" action="<%$this->url->make('home/myprofile_action')%>" enctype="multipart/form-data">
        <input type="hidden" name="selprofilepic" id="selprofilepic" value="profilepic">

            <%if $profile_type ne 'my_profile'%>
                <div class="sidebar-user">
                    <div class="sidebar-user-img avatar-edit" id="changeprofilepic_block">
                        <div id="form-image">
                            <input type='file' id="profile_image" name="profile_image" style="display:none;" accept=".png, .jpg, .jpeg" />
                            <label for="profile_image">
                                <!--<a href="#" style="z-index: 1"><i class="fa-solid fa-pen" ></i></a>-->
                            </label>
                        </div>
                        <img id="imagePreviewProfile" src="<%$userinfo.u_profile_image%>" alt="User profile picture" style = "position:relative; bottom: 24px;">
                    </div>
                    <div class="sidebar-user-img avatar-edit" id="saveprofilepic_block" style="display:none;">
                        <div id="form-image">
                            <input type='hidden' id="saved_profile_photo" name="saved_profile_photo" />
                            <label>
                                <div id="saveprofilepic" style="display:none;cursor:pointer;"><i class="fas fa-save"></i></div>
                            </label>
                        </div>
                    </div>
                    <div class="sidebar-user-title">
                        <h3><%$userinfo.u_name%></h3>
                    </div>
                </div>
            <%/if%>
            <%assign var=profileImage1 value=<%$this->config->item('site_url')%>|cat:'public/images/noimage.gif'%>
            <%assign var=profileImage2 value=<%$this->config->item('site_url')%>|cat:'public/images/noimage_1000x320.png'%>
            <input type="hidden" name="profilesrc" id="profilesrc" value="<%if $getuserid neq $followuserid%><%$userinfo.u_profile_image|replace:$profileImage1:$profileImage2%><%else%><%$userinfo.u_profile_image|replace:$profileImage1:$profileImage%><%/if%>">
        </form>
        <div class="sidebar-nav">
            <div class="scroll-content">
                <ul>
                    <li class="sidebar-nav-item">
                        <a href="viral-posts.html" class="<%if $this->router->fetch_method() eq 'viral_posts'%>active<%/if%>"><img src="<%$this->config->item('images_url')%>front/new-front-image/viral.png" alt=""><%$viral_post%></a>
                    </li>
                    <!--<li class="sidebar-nav-item">
                        <a href="home.html" class="<%if $this->router->fetch_class() eq 'home' && $this->router->fetch_method() eq 'index'%>active<%/if%>"><img src="<%$this->config->item('images_url')%>front/new-front-image/feed.png" alt=""> <%$home%></a>
                    </li>-->
                    <li class="sidebar-nav-item">
                        <a href="music.html" class="<%if $this->router->fetch_class() eq 'home' && $this->router->fetch_method() eq 'index'%>active<%/if%>"><i class="fa-solid fa-music"></i> Music</a>
                    </li>
                    <li class="sidebar-nav-item">
                        <%if $profile_type eq 'user_profile'%>
                            <a href="<%$this->url->make('content/content/playlist')%>?user_id=<%$userinfo.u_users_id%>&profile_type=user_profile"><img src="<%$this->config->item('images_url')%>front/new-front-image/music.png" alt=""> <%$my_playlist%></a>
                        <%else%>
                            <a href="<%$this->url->make('content/content/playlist')%>?user_id=<%$pl_userId%>&profile_type=my_profile"><img src="<%$this->config->item('images_url')%>front/new-front-image/music.png" alt=""> <%$my_playlist%></a>
                        <%/if%>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="<%$this->url->make('content/content/watchvideo')%>"><img src="<%$this->config->item('images_url')%>front/new-front-image/viral.png" alt=""> <%$viral_post_plus%></a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="hidden-posts.html" class="<%if $this->router->fetch_class() eq 'home' && $this->router->fetch_method() eq 'hide_posts'%>active<%/if%>"><img src="<%$this->config->item('images_url')%>front/new-front-image/hidden.png" alt=""> <%$hidden_post%></a>
                    </li>
                    <li class="sidebar-nav-item">
                        <a href="javascript:;" class="chat-link" ><img src="<%$this->config->item('images_url')%>front/new-front-image/chat.png" alt="" > <%$chat%></a>
                    </li>
                    <%if $profile_type ne 'my_profile'%>
                        <%if $this->router->fetch_method() neq 'user_profile'%>
                            <li class="sidebar-nav-item">
                                <a href="#" id="notificationNewLink" data-bs-toggle="modal" data-bs-target="#notificationNewModal" style="gap: 0px !important;">
                                    <img src="<%$this->config->item('images_url')%>front/new-front-image/notification.png" alt="">
                                    <span class="badge"><%$total_notification%></span> <%$notification%>
                                </a>
                            </li>
                    
                            <li class="sidebar-nav-item">
                                <a href="#" id="blockUserNewModalTrigger" data-bs-toggle="modal" data-bs-target="#blockUserNewModal">
                                    <img src="<%$this->config->item('images_url')%>front/new-front-image/block.png" alt=""> <%$blocked_users%>
                                </a>
                            </li>
                        <%/if%>
                    <%/if%>    
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('notifications_modal').addEventListener('click', function() {
        var myModal = new bootstrap.Modal(document.getElementById('notificationNew'));
        myModal.show();
    });
</script>

<script>
//     var logged_in_user_id = "<%$pl_userId%>";
//     console.log("Logged-in User ID:", logged_in_user_id); 
</script>
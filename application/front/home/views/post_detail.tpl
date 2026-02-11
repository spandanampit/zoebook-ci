<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}

    .plyr__play-large{
        display: none !important;
    }
    .comment-container {
        display: flex;
        margin: 15px 0;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .comment-container img {
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 15px;
    }

    .comment-content {
        flex: 1;
    }

    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comment-header .username {
        font-weight: bold;
        font-size: 1rem;
    }

    .comment-header .added-date {
        font-size: 0.8rem;
        color: #888;
    }

    .comment-text {
        margin: 10px 0;
    }

    .comment-actions {
        display: flex;
        gap: 10px;
        font-size: 0.9rem;
        color: #007bff;
        cursor: pointer;
    }

    .comment-actions span {
        display: inline-flex;
        align-items: center;
    }

    .comment-actions span i {
        margin-right: 5px;
    }

    #captionContainer {
        display: flex;
    }

    #moreBtn {
        margin-bottom: 6px; 
    }

    #read-more {
        color: #007bff;
        cursor: pointer;
        font-size: 14px;
    }

</style>
<%$this->css->css_src()%>
<section class="video-detail-sec">
      <div class="container">
        <div class="row">
            <%if $errormsg neq ''%>
                <div style="width:74%;font-size:25px;color:red;text-align:center;padding-top:100px;">
                    <%$errormsg%>
                </div>
            <%else%>
            <div class="col-md-12">
            <%if $postmedia|@count gt 0%>
                <div class="video-widget-box">
                    <div class="video-wrapper">
                        <%foreach item=row key=i from=$postmedia%>
                            <div class="video-container" id="video-container">
                                <%if $row['pm_media_type'] eq 'Video'%>
                                    <video class="plyr-video othervideoduration main-video-player" id="main-video" width="100%" height="100%" controls preload="metadata" data-poster="<%$row['pm_video_thumbnail']%>" autoplay muted>
                                        <source src="<%$row['upload_file']%>" type="video/mp4">
                                    </video>
                                <%else%>
                                    <img src="<%$row['upload_file']%>" alt="">
                                <%/if%>
                                <div class="play-button-wrapper">
                                    <div title="Play video" class="play-gif" id="circle-play-b">
                                    </div>
                                </div>
                            </div>
                        <%/foreach%>
                    </div>
                </div>
            <%/if%>
        </div>
        <%/if%>
        </div>
      </div>
    </section>
    <!-- video detail section end -->

    <!-- video related section start -->
    <section class="video-related-sec" id="scrool_view">
      <div class="container" id="gotocomment">
        <div class="row">
          <div class="col-xl-8">
            <div class="video-post-wrapper">
              <div class="video-posts-data">
                <div class="video-post-title">
                  <a href="<%$this->general->setdiplayprofileurl($postinfo.posted_user_id,$postinfo.user_name)%>">
                    <div class="video-post-img">
                      <img src="<%$postinfo.user_profile_image%>" alt="">
                    </div>
                  </a>
                  <div class="video-post-info">
                    <div class="video-post-info-content" id="post_username">
                      <a href="<%$this->general->setdiplayprofileurl($postinfo.posted_user_id,$postinfo.user_name)%>">
                          <h3><%$postinfo.user_name%></h3>
                      </a>
                      <div class="dot-2"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="video-post-button">
                <ul>
                    <%if $this->session->userdata('iUserId') neq $postinfo.posted_user_id%>
                        <li class="follow-button">
                            <%if $followerinfo.pending_request_id neq '' && $followerinfo.is_follwing eq 'Pending'%>
                                <a href="javascript:" class="site-btn-2 green-bg act_cancelfollowrequest" data-id="<%$followerinfo.u_users_id%>" data-pendingrequestid="<%$followerinfo.pending_request_id%>"><%$cancel%></a>
                            <%else if $followerinfo.is_follwing eq 'Yes'%>
                                <a href="javascript:" class="site-btn-2 green-bg act_unfollowuser" data-id="<%$followerinfo.u_users_id%>"><%$unfollow%></a>
                            <%else%>
                                <a href="javascript:" class="site-btn-2 green-bg act_followuser" data-id="<%$followerinfo.u_users_id%>"><%$follow%></a>
                            <%/if%>
                            <div id="followactionmsg_<%$followerinfo.u_users_id%>"></div>
                        </li>
                    <%/if%>
                  <li><a id="share_<%$postinfo.post_id%>" href="javascript:void(0)" data-userid="<%$this->session->userdata('iUserId')%>" data-postid="<%$postinfo.post_id%>" class="site-btn-2 white-bg share_postdetail"><%$share%></a></li>
                  <li><a id="like_<%$postinfo.post_id%>" href="javascript:void(0)" data-postid="<%$postinfo.post_id%>" data-mediaid="<%$mediaid%>" class="<%if $islike eq 1%>active <%/if%>like-post act_likepost site-btn-2 orange-bg" ><%$liked%></a></li>
                  <li>
                    <div class="dropdown">
                            <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <!--<a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>-->
                                <%if $this->session->userdata('iUserId') neq $postinfo.posted_user_id%>
                                <a class="dropdown-item report_postdetail" data-report_type="Spam" data-userid="<%$this->session->userdata('iUserId')%>"  data-postid="<%$postinfo.post_id%>" href="javascript://"><%$spam%></a>
                                <a class="dropdown-item report_postdetail" data-report_type="InAppropriate" data-userid="<%$this->session->userdata('iUserId')%>"  data-postid="<%$postinfo.post_id%>" href="javascript://"><%$inappropriate%> ?</a>
                                <a class="dropdown-item block_user" data-userid="<%$postinfo.posted_user_id%>" href="javascript://"><%$block%></a>
                                <a class="dropdown-item" data-userid="<%$postinfo.posted_user_id%>" onclick="addToPlaylist(<%$postinfo.post_id%>)"><%$add_to_playlist%></a>
                                <%else%>
                                <a class="dropdown-item edit_post" data-postid="<%$postinfo.post_id%>" href="javascript://"><%$edit%></a>
                                <a class="dropdown-item delete_post" data-postid="<%$postinfo.post_id%>" href="javascript://"><%$delete%></a>
                                <%/if%>
                            </div>
                        </div>
                    </li>
                </ul>
              </div>
            </div>
            <div class="video-post-counter">
              <div class="video-view-box">
                <div class="video-view-icon vid-purple-bg">
                  <i class="fa-solid fa-eye"></i>
                </div>
                <div class="video-view-text views">
                  <h3><%$viewcount%> <%$views%></h3>
                </div>
              </div>
              <div class="video-view-box">
                <div class="video-view-icon vid-yellow-bg">
                  <i class="fa-solid fa-thumbs-up"></i>
                </div>
                <div class="video-view-text">
                <a href="javascript:" class="disp_postlikes" data-pageindex="" data-postid="<%$postinfo.post_id%>"  id="displike_<%$postinfo.post_id%>" data-mediaid="<%$mediaid%>" style="display: flex;"><span data-likescount="<%$likescount%>" id="likes_count_<%$postinfo.post_id%>"><%$likescount%>&nbsp;</span><h3 id="displiketext_<%$postinfo.post_id%>"><%if $likescount eq 1%><%$like%><%else%><%$likes%><%/if%></h3></a>
                </div>
              </div>
              <div class="video-view-box">
                <div class="video-view-icon vid-green-bg">
                  <i class="fa-solid fa-bell"></i>
                </div>
                <div class="video-view-text added_date">
                  <h3><%time_elapsed_string($postinfo.added_date)%></h3>
                </div>
              </div>
            </div>
            <div class="post-divider"></div>
            <div class="video-post-text">
                <%assign var=posted_text_withouemoji value=removeEmoji($postinfo.post_text_emoji)%>
                <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,120)%>
                <%assign var=posted_text_full value=$this->general->truncateChars($posted_text_withouemoji,2000)%>
                <%assign var=word_count value=str_word_count(strip_tags($posted_text_full))%>
                <h3 style="display: none;" id="full-text"><%$this->general->displayposttext($posted_text_full)%></h3>   
              <h3 id="half-description"><%$this->general->displayposttext($posted_text)%></h3>
              <%if $word_count gt 15%><h3 id="read-more" onclick="toggleText()">Read More</h3><%/if%>
              <!--<h3><%$word_count%></h3>-->
                <div id="captionContainer">
                    <h3 id="captionText"></h3>
                    <button id="moreBtn" style="display: none; background: none; color: rgb(3, 3, 226); border: none; cursor: pointer;"><%$more%> More</button>
                </div>
            </div>
            <div class="post-divider"></div> 
            <div class="video-posts-comments">
              <ul class="comments-list">
                <li>
                <%if $this->session->userdata('iUserId') neq ''%>
                  <div class="comment">
                    <div class="comment-pic">
                      <img src="<%$postinfo.user_profile_image%>" alt="" style = "width: 46% !important; height: 50px !important; border-radius: 39px; object-fit: cover;" class="pst-dtl-img">
                    </div>
                    <div class="comment-text comment-text-new" >
                      <form class="post-details-coment-from" style ="42rem !important">
                        <div class="form-group lead emoji-picker-container w-100" style = "box-shadow: 0px 15px 34px 0px rgba(0, 0, 0, 0.07); height: 56px; border-radius: 11px;">
                          <textarea name="commentadd" id="commentadd" id="exampleInputEmail1" aria-describedby="emailHelp" class="form-control actkeypress_postcomment comment_post_<%$posts[i]['post_id']%>" rows="1" data-mediaid="<%$mediaid%>" data-postid="<%$postinfo.post_id%>" placeholder="Add comment" data-emojiable="true" oninput="sendGifPostDetail('<%$postinfo.post_id%>', '<%$mediaid%>')"></textarea>
                          <span class="err_msg_<%$posts[i]['post_id']%>" style="font-size: 12px; color: #4e4c4c;"></span>
                        </div>
                        <div class="upload_media_div" id="media_div_<%$postinfo.post_id%>" style="display: none !important;">
                            <input type="file" name="upload_file" id="input_media_<%$postinfo.post_id%>">
                        </div>
                        <div class="comment-pic pst-dtl-cmnt-gif" style="background: none">
                            <span style="cursor: pointer" class="btn_post_media_attach">
                                <i class="fa fa-paperclip btn_postmedia" data-postid="<%$postinfo.post_id%>" style="font-size: 16px !important"></i>
                            </span>
                            <span style="cursor:pointer;" class="open_gif_section cmt-gif-image" data-gif-post-id="<%$posts[i]['post_id']%>">GIF</span>
                            <span style="cursor:pointer; " class="open_sticker_section" data-sticker-post-id="<%$posts[i]['post_id']%>">
                                <img  src="<%$this->config->item('images_url')%>front/sticker.png" alt="">
                            </span>
                        </div>
                        <input type="hidden" name="post_comment_emoji" id="post_comment_emoji">
                        <button type="button" class="btn btn-primary form-btn act_postcomment" style="cursor:pointer; right: -37px !important;" data-mediaid="<%$mediaid%>" data-postid="<%$postinfo.post_id%>" title="Add Comment"><img src="<%$this->config->item('images_url')%>front/plane.png"></button>
                      </form>
                    </div>
                    <!-- GIF Section -->
                        <div class="main_gif_div_section gif_section_<%$posts[i]['post_id']%>" style="display: none;">
                            <input type="text" id="searchInput_<%$posts[i]['post_id']%>" placeholder="Search for Stickers">
                            <a href="javascript:void(0);" class="close_gif_div_<%$posts[i]['post_id']%>" >
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a>
                            <div class="gif_picker_div_cls" id="gifPicker_<%$posts[i]['post_id']%>">
                                <img src="https://media1.giphy.com/media/9ywJxa5PASF6HBUSh7/giphy-downsized-medium.gif?cid=ca8ff4c416a6m7a5omqz1thbb97qwfygjzj2z51qo93v43oa&ep=v1_stickers_search&rid=giphy-downsized-medium.gif&ct=s" alt="">
                            </div>    
                        </div>
                  </div>
                <%/if%>
                </li>

                <div id="comments-section">
                    <%include file="common/common_postcomment.tpl"%> 
                </div>
                
              </ul>
            </div>           
          </div>
          <div class="col-xl-4" style = "position: relative;">
            <div class="related-videos">
              <h3><%$related_videos%></h3>
              <%include file="common/common_otherpost.tpl"%>           
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- video related section end -->
  
    <a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
    <div class="modal fade cmn-modal create-post-modal" id="reportPostdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="new_loader" style="display:none;"></div>
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel"><%$report_post%></h5>
                </div>
                <form class="cmn-form" id="form_report_postdetail" method='post'>
                    <input type="hidden" name="report_post_id" id="report_post_id" value=""/>
                    <div class="modal-body">
                        <div class="form-group input-group col-4">
                            <select class="form-control" id="eReprtType" name="eReprtType">
                                <option value="Spam"><%$spam%></option>
                                <option value="InAppropriate"><%$inappropriate%></option>
                            </select>
                        </div>
                        <div class="upload-text">
                            <textarea name="report_notes" id="report_notes" class="form-control" rows="5" placeholder="Notes (optional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submit_report_postdetail" class="btn btn-primary"><%$report%></button>
                    </div>
                </form>            
            </div>
        </div>
    </div>
<div class="modal fade cmn-modal create-post-modal" id="sharePostdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel"><%$share_this_post%></h5>
            </div>
            <form id="form_share_postdetail" method='post'>
                <input type="hidden" name="share_post_id" id="share_post_id" value=""/>
                <div class="modal-body">
                    <div class="upload-text">
                        <i class="cmn-user-img">
                            <img src="<%$userinfo.u_profile_image%>" alt="">
                        </i>
                        <textarea name="share_post_text" id="share_post_text" class="form-control" rows="5" placeholder="What’s on your mind?"></textarea>
                    </div>
                    <div class="error-msg-form" id='share_post_textErr'></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="share_timeline_postdetail" class="btn btn-primary"><%$share_on_my_timeline%></button>
                </div>
            </form>            
        </div>
    </div>
</div>
<%include file="common/common_editpost.tpl" %>
<%$this->js->add_js("front/post_detail.js")%>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

function sendGifPostDetail(postId, mediaId) {
    var textarea = document.getElementById("commentadd");
    var mainGifDiv = document.querySelector(".comment_post_");
    
    console.log('postId =>', postId);
    
    console.log("Main GIF Div:", mainGifDiv);
    
    if (textarea) {
        const gifLink = textarea.value.trim();
        console.log('giflink ::::', gifLink);
        
        if (/^https:\/\/media\d*\.giphy\.com\/media/.test(gifLink)) {
            console.log("GIF URL detected:", gifLink);

            textarea.value = "";  
            textarea.dispatchEvent(new Event("input"));
            $(".comment_post_").html("");


            if (typeof jQuery !== "undefined") {
                $(textarea).val("").trigger("change").trigger("input"); 
            }

            $.ajax({
                url: "/add_comment",
                type: "POST",
                data: { comment_post_id: postId, comment: gifLink, post_media_id: mediaId},
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        console.log("GIF URL submitted successfully:", response.data);
                        

                    } else {
                        console.error("Error submitting GIF:", response.message);
                    }

                    setTimeout(() => {
                        textarea.value = "";
                        if (typeof jQuery !== "undefined") {
                            $(textarea).val("").trigger("change").trigger("input");
                        }
                    }, 50);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX error:", textStatus, errorThrown);
                }
            });

            textarea.blur();  // Remove focus from textarea
        } else {
            console.log("Post ID:", postId, "Content but in ELSE case:", gifLink);
        }
    } else {
        console.error("Textarea not found for post ID:", postId);
    }

    setTimeout(() => {
      window.location.reload();
}, 500);
}

document.querySelectorAll(".gif_picker_div_cls").forEach(gifContainer => {
    gifContainer.addEventListener("click", function (event) {
        let selectedGif = event.target.closest("img");
        if (!selectedGif) return;

        let gifUrl = selectedGif.src;
        let postId = this.getAttribute("data-gif-post-id");
        let mediaId = document.querySelector(`#commentadd[data-postid="${postId}"]`)?.getAttribute("data-mediaid");

        let textarea = document.getElementById("commentadd");
        if (textarea) {
            textarea.value = gifUrl; 
            textarea.dispatchEvent(new Event("input")); 

            setTimeout(() => {
                sendGifPostDetail(postId, mediaId);
            }, 50);
        }

        let gifSection = document.querySelector(`.gif_section_${postId}`);
        if (gifSection) gifSection.style.display = "none";
    });
});


</script>

<script>
function addToPlaylist(postId) {
        console.log(postId);
        var url = "<%$this->url->make('content/content/addToPlaylist')%>"
        $.ajax({
            url: url,
            type: "POST",
            data: { postId: postId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    console.log("Video added to playlist successfully!");
                    var successMessage = document.createElement('div');
                    successMessage.textContent = "Video added to playlist successfully!";
                    successMessage.style.position = 'fixed';
                    successMessage.style.top = '20px';
                    successMessage.style.left = '50%';
                    successMessage.style.transform = 'translateX(-50%)';
                    successMessage.style.backgroundColor = '#dff0d8';
                    successMessage.style.padding = '10px';
                    successMessage.style.border = '1px solid #3c763d';
                    successMessage.style.borderRadius = '5px';
                    successMessage.style.zIndex = '9999';
                    
                    document.body.appendChild(successMessage);
                    
                    setTimeout(function() {
                        document.body.removeChild(successMessage);
                    }, 5000);
                } else {
                    console.error("Error adding video to playlist:", response.message);
                    var errorMessage = document.createElement('div');
                    errorMessage.textContent = "Video added to playlist successfully!";
                    errorMessage.style.position = 'fixed';
                    errorMessage.style.top = '20px';
                    errorMessage.style.left = '50%';
                    errorMessage.style.transform = 'translateX(-50%)';
                    errorMessage.style.backgroundColor = '#ff0000';
                    errorMessage.style.padding = '10px';
                    errorMessage.style.border = '1px solid #3c763d';
                    errorMessage.style.borderRadius = '5px';
                    errorMessage.style.zIndex = '9999';
                    
                    document.body.appendChild(errorMessage);
                    
                    setTimeout(function() {
                        document.body.removeChild(errorMessage);
                    }, 5000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        });
    }

    function showSuccessMessage(message) {
        alert(message);
    }

    document.addEventListener('DOMContentLoaded', function() {
        var videos = document.querySelectorAll('.othervideoduration');
        
        videos.forEach(function(video) {
            // Restart video playback when it ends
            video.addEventListener('ended', function() {
                video.currentTime = 0; // Reset video to the beginning
                video.play(); // Start playing the video again
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    var paperclipIcons = document.querySelectorAll('.fa-paperclip.btn_postmedia');
    
    paperclipIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            var postId = icon.getAttribute('data-postid');
            var fileInput = document.getElementById('input_media_' + postId);
            if (fileInput) {
                // Reset the input value to ensure the dialog opens every time
                fileInput.value = '';
                fileInput.click();
            }
        });
    });
});
</script>
<script>
    window.onload = function() {
        const scrollThreshold = 600;
        let loading = false;
        let pageIndex = 1;

        function enableVideoHoverAutoplay() {
            const relatedVideos = document.querySelectorAll('.related-video');

            relatedVideos.forEach(video => {
                video.addEventListener('mouseenter', () => {
                    video.play();
                });

                video.addEventListener('mouseleave', () => {
                    video.pause();
                    video.currentTime = 0;
                });
            });
        }

        enableVideoHoverAutoplay();

        window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;

            const scrolledHeight = scrollTop + windowHeight;

            if ((documentHeight - scrolledHeight) <= scrollThreshold && !loading) {
                loading = true;
                console.log('User is near the bottom. Triggering AJAX call...');
                const params = {
                    page_index: pageIndex,
                    viral_feed: 1,
                    post_id: <%$postinfo.post_id%>,
                };
                
                $.ajax({
                    url: '/other_posts',
                    method: 'GET',
                    dataType: 'json',
                    data: params,
                    success: function(data) {
                        console.log(data);
                        pageIndex++;
                        loading = false;
                        
                        if (data.other_post && data.other_post.length > 0) {
                            let htmlContent = '';
                            data.other_post.forEach(function(row) {
                                const timeElapsed = timeElapsedString(row.p_added_date);
                                const postTitle = decodeUnicodeSurrogates(row.p_post_text);
                                if (row.um_media_type == 'Video' && row.p_video_thumbnail != null) {
                                    htmlContent += `
                                        <div class="related-list">
                                            <a href="post-detail-${row.p_post_id}.html" class="otherpost_act" data-otherpostid="${row.p_post_id}">
                                                <div style="position:relative">
                                                    <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;">
                                                    </div>
                                                    <div class="related-list-img">
                                                        <video class="related-video" data-video-id="${row.p_post_id}" data-video-src="${row.um_upload_file}" width="160" height="90" preload="metadata" poster="${row.p_video_thumbnail}" muted> 
                                                            <source src="${row.um_upload_file}#t=0.30" type="video/mp4">
                                                        </video>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="related-list-content">
                                                <h4><a href="post-detail-${row.p_post_id}.html" class="otherpost_act" data-otherpostid="${row.p_post_id}">${postTitle}</a></h4>
                                                <p>${timeElapsed}</p>
                                                <div class="related-list-like">
                                                    <ul>
                                                        <li class="yellow-color">${row.p_impression_count} views</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    `;
                                }
                            });

                            $('#related-videos').append(htmlContent);

                            enableVideoHoverAutoplay();
                        } else {
                            console.log('No other posts found.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading data:', error);
                        loading = false;
                    }
                });
            }
        });
    };

</script>
<script>
function toggleText() {
    var halfDescription = document.getElementById('half-description');
    var fullText = document.getElementById('full-text');
    var captionText = document.getElementById('captionText');
    var moreBtn = document.getElementById('read-more');

    if (halfDescription.style.display === 'none') {
        halfDescription.style.display = 'block';
        fullText.style.display = 'none';
        captionText.textContent = '';
        moreBtn.textContent = 'Read More';
    } else {
        halfDescription.style.display = 'none';
        fullText.style.display = 'block';
        moreBtn.textContent = 'Read Less';
    }
}
</script>
<script>
let cdn = document.getElementById('commentadd');
console.log('cdn', cdn);

</script>
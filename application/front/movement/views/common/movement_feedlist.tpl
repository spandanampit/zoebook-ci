
<style>
.share_mvt_posst {
    font-size: 16px;
    color: gray;
    padding: 8px;
    border: 1px solid #e0d9d9;
}
.mvt_post_sec {
    padding: 0px 0px 0px 0px;
}

.post_action_box {
    position: absolute;
    z-index: 29;
    right: 39px;
    border: 2px solid #80808073;
    /* widht: 116rem; */
    width: 7rem;
    background: white;
    padding: 0px;
    border-radius: 10px;
}

.dropdown-item {
    padding: 10px;
    font-size: 14px;
    height: 27px !important;
    min-height: 27px !important;
}
/* Container for the button and background */
.video-btn-overlay {
    display: none; /* Hidden initially */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7); /* Dark semi-transparent background */
    backdrop-filter: blur(5px); /* Blur effect */
    justify-content: center;
    align-items: center;
    z-index: 10; /* Make sure it appears above the video */
}

/* Button styling */
.refresh-btn {
    background-color: transparent; /* Button background */
    border: none;
    color: white;
    padding: 10px 20px;
    font-size: 26px;
    cursor: pointer;
    border-radius: 5px;
    width: 60%;
    display: flex;
}

.refresh-btn i {
    margin-right: 5px;
}

.btn_name{
    text-align: center;
    font-size: 14px;
}
/* Ensure the video is styled properly */
#plyr-video {
    position: relative; /* To ensure the overlay is positioned correctly */
}
</style>

<%if !empty($movements_post)%>
    <%foreach item=row from=$movements_post%>
    <div class="main pt-3">
        <div class="video-dash-post mb-20">
            <div class="video-dash-post-heading">
            <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <img src="<%$row['user_profile_image']%>" alt="">
                </div>
                <div class="video-post-content">
                <h5><%$row['user_name']%></h5>
                    <p>
                        <%*time_elapsed_string($row['added_date'])*%>
                        <%$this->general->getLocalDateTime($row['added_date'], "Y-m-d H:i")%>
                    </p>
                </div>
            </div>
            <%if $row['posted_user_id'] eq $userinfo['iUserId']%>
            <div class="video-post-icon">
                <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="dropdownMenuButton(<%$row['post_id']%>);">
                    <i class="fa fa-ellipsis-v"></i>
                </button>
                <div class="post_action_box dropdown-menu-right" aria-labelledby="dropdownMenuButton_<%$row['post_id']%>" id="dropdownMenuButton_<%$row['post_id']%>" style="display: none;">
                    <a class="dropdown-item edit_post" data-bs-toggle="modal" data-bs-target="#editPost_<%$row['post_id']%>"><%$edit%></a>
                    <a class="dropdown-item delete_post" data-post-id="<%$row['post_id']%>, <%$movement['get_movements']['movements_id']%>"><%$delete%></a>
                </div>
            </div>
            <%/if%>
            
            </div>
            <div class="video-post-content">
            <p><%$row['post_text']%></p>
            </div>

            <div class="video-post-vid  <%if $row['post_type'] eq 'Share'%> share_mvt_posst <%/if%>">
                <%if $row['post_type'] eq 'Share'%>
                    <div class="video-dash-post-user" style="padding: 5px;">
                        <div class="video-dash-post-img">
                        <img src="<%$row['share_user_info']['u_profile_image']%>" alt="">
                        </div>
                        <div class="video-post-content">
                        <h5><%$row['share_user_info']['u_name']%></h5>
                        </div>
                    </div>
                    <div class="video-post-content" style="padding: 5px;">
                    <%if $row['post_type'] eq 'Share'%>
                        <p><%$row['pm.post_text']%></p>
                    <%/if%>
                    </div>
                <%/if%>
                <div class="video-wrapper <%if $row['post_type'] eq 'Share'%> mvt_post_sec <%/if%>">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <%foreach item=media from=$row['get_post_media']%>
                            <div class="swiper-slide">
                                    <%if $media['pm_media_type'] eq 'Video'%>
                                          <div class="video-wrapper">
                                                <p class="view" style="position: fixed;"><i class="fa-regular fa-eye"></i> &nbsp; <%$media['pm_views_count']%></p>
                                          </div>
                                        <div class="video-container-2" id="video-container">
                                        
                                            <%if $row['post_type'] neq 'Share'%>
                                                <video controls="" id="video" preload="metadata" poster="<%$media['pm_video_thumbnail']%>">
                                                    <source src="<%$media['upload_file_org']%>" type="video/mp4">
                                                </video>
                                            <%else%>
                                                <%if $media['pm_vSourceType'] eq 'aws'%>  
                                                <video controls="" id="video" preload="metadata" poster="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$row['get_post_media'][0]['pm_user_id']%>/<%$row['get_post_media'][0]['pm_video_thumbnail_org']%>">
                                                    <source src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$row['get_post_media'][0]['pm_user_id']%>/<%$row['get_post_media'][0]['pm_upload_file']%>" type="video/mp4">
                                                </video>
                                                <%else%>
                                                <video controls="" id="video" preload="metadata" poster="<%$row['get_post_media'][0]['pm_vCloudinary']%>">
                                                    <source src="<%$row['get_post_media'][0]['pm_vCloudinary']%>" type="video/mp4">
                                                </video>
                                                <%/if%>
                                            <%/if%>
                                                
                                            <div class="play-button-wrapper">
                                                <div title="Play video" class="play-gif" id="circle-play-b">
                                                    <!-- SVG Play Button -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="video-btn-overlay">
                                            <button class="refresh-btn">
                                                <div style="margin-right: 100px;" class="btn_options">
                                                    <a data-id="<%$row['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($row['post_id'],$posts[i]['post_text'])%>">
                                                        <i class="fa fa-toggle-right text-white"></i>
                                                        <p class="btn_name text-white"><%$see_more_in_video%></p>
                                                    </a>
                                                </div>
                                                <div class="btn_options replay-btn">
                                                    <i class="fa fa-refresh"></i>
                                                    <p class="btn_name"><%$replay%></p>
                                                </div>
                                            </button>
                                        </div>
                                    <%else%>
                                        <%if $row['post_type'] neq 'Share'%>
                                            <img src="<%$media['upload_file_org']%>" >
                                        <%else%>
                                            <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$media['pm_user_id']%>/<%$media['pm_upload_file_org']%>">
                                        <%/if%>
                                    <%/if%>
                                </div>
                            <%/foreach%>
                        </div>

                        <!-- Add Pagination if needed -->
                        <div class="swiper-pagination"></div>

                        <!-- Add Navigation Arrows if needed -->
                        <!--<div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>-->
                    </div>
                </div>
            </div>

            
            <%if $isajax eq 'Yes'%>
                <%assign var="is_like" value=$islike%>
                <%assign var="likes_count" value=$likescount%>
                <%assign var="comment_count" value=$commentcount%>
                <%assign var="feed_action_postid" value=$postid%>
            <%else%>
                <%assign var="is_like" value=$row['is_like']%>
                <%assign var="likes_count" value=$row['likes_count']%>
                <%assign var="comment_count" value=$row['comments_count']%>
                <%assign var="feed_action_postid" value=$row['post_id']%>
            <%/if%>
            <%assign var="mediaid" value=$row['get_post_media'][0]['pm_post_media_id']%>

            <div class="video-share-box-wrapper">
                <div class="video-share-box">
                    <ul>
                        <!--<a id="like_<%$feed_action_postid%>" href="javascript:void(0)" data-postid="<%$feed_action_postid%>" class="<%if $is_like eq 1%>active <%/if%>like-post likepost_switch">
                            <i class="<%if $is_like eq 1%>fas<%else%>far<%/if%> fa-heart" style="color: red"></i>
                        </a>-->
                  <li>
                        <a href="javascript:void(0)" onclick="movement_post_like(<%$feed_action_postid%>)">
                              <i id="heart-icon-<%$feed_action_postid%>" class="<%if $row['is_post_like'] eq 0%>far<%else%>fas<%/if%> fa-heart" style="color: red"></i>
                              <p id="like-post-<%$feed_action_postid%>"><%$row['is_post_like']%></p>
                        </a>
                  </li>
                    <li class="video-comment">
                        <a href="javascript:void(0)" onclick="openComments(<%$row['post_id']%>)">
                            <i class="fa-regular fa-comment-dots"></i>
                            <p><%count($row['comment_details'])%></p>
                        </a>
                    </li>
                    <li class="video-comment">
                        <a href="javascript:void(0)" onclick="openModalWithPostId(<%$row['post_id']%>)">
                            <i class="fa-solid fa-share"></i>
                            <p></p>
                        </a>
                    </li>
                    <li>
                        <div class="video-info-box">
                            <a href="<%$this->general->setdiplayposturl($row['post_id'],$row['pm.post_text'])%>"><i class="fa-solid fa-info"></i></a>
                        </div>
                    </li>
                    </ul>
                </div>

                <div class="video-photo">
                    <!-- <a href="#">
                    <i class="fa-regular fa-images"></i>
                    </a> -->
                </div>  
            </div>
            <%include file="common/movement_post_comment.tpl"%>
        </div>

        <div class="modal fade create-post" id="editPost_<%$row['post_id']%>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPostLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostLabel"><%$edit_post%></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <form method="post" enctype="multipart/form-data" action="<%$this->url->make('movement/movement/edit_post')%>">
                        <div class="modal-body">
                            <div class="create-post-comment">
                                <div class="textarea-img">
                                    <img src="<%$row['user_profile_image']%>" alt="Profile Image">
                                </div>
                                <p class="lead emoji-picker-container w-100 emoji_postinfo">
                                    <textarea name="movement_post_text" id="movement_post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true" style="border: none;"><%$row['post_text']%></textarea>
                                </p>
                            </div>
                            <div class="video-upload">
                                <input type="file" style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp">
                                <label for="upload_file" class="photo-btn" id="triggerFileUpload">
                                    <i class="fa-solid fa-camera"></i> <%$photo%>/<%$video%>
                                </label>

                                <%if $row['post_type'] neq 'Share'%>
                                    <div id="preview" class="preview-container" style="display: flex;">
                                        <%foreach item=media from=$row['get_post_media']%>
                                            <div class="media-item" style="max-width: 20%; min-width: 20%; margin: 8px;">
                                                <%if $media['pm_media_type'] eq "Image"%>
                                                    <img src="<%$media['upload_file_org']%>" alt="Media Image" class="img-fluid" style="max-width: 100%; border-radius: 10px; object-fit: cover; min-height: 100px; max-height: 100px;"/>
                                                    <a href="" class="remove-media" data-file="<%$media['pm_post_media_id']%>" style="position: relative; bottom: 6rem; left: 6.5rem;"><i class="fa fa-trash-o" style="color: red;" ></i></a>

                                                <%else%>
                                                    <video controls="" id="video" preload="metadata" poster="<%$media['pm_video_thumbnail']%>" style="max-width: 100%; min-height: 100px; max-height: 100px; border-radius: 10px; object-fit: cover; ">
                                                        <source src="<%$media['upload_file_org']%>" type="video/mp4">
                                                    </video>
                                                    <div class="video-btn-overlay">
                                                        <button class="refresh-btn">
                                                            <div style="margin-right: 100px;" class="btn_options">
                                                                <a data-id="<%$row['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($row['post_id'],$posts[i]['post_text'])%>">
                                                                    <i class="fa fa-toggle-right text-white"></i>
                                                                    <p class="btn_name text-white"><%$see_more_in_video%></p>
                                                                </a>
                                                            </div>
                                                            <div class="btn_options replay-btn">
                                                                <i class="fa fa-refresh"></i>
                                                                <p class="btn_name"><%$replay%></p>
                                                            </div>
                                                        </button>
                                                    </div>
                                                    <a href="" class="remove-media" data-file="<%$media['pm_post_media_id']%>" style="position: relative; bottom: 6rem; left: 6.5rem;"><i class="fa fa-trash-o" style="color: red;" ></i></a>
                                                <%/if%>
                                            </div>
                                        <%/foreach%>
                                    </div>
                                <%/if%>
                            </div>

                            <div class="create-share-type">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="visibility" id="visibility1" value="Movement" checked>
                                    <label class="form-check-label" for="visibility1"> <%$movement%> </label>
                                </div>
                            </div>

                            <input type="hidden" name="movement_id" value="<%$movement['get_movements']['movements_id']%>">
                            <input type="hidden" name="post_id" value="<%$row['post_id']%>">
                            <input type="hidden" name="post_type" value="<%$row['post_type']%>">

                            <div class="create-post-btn-box" style="padding-top:20px !important; padding-bottom: 0px !important;">
                                <button type="submit" class="post-btn" style="margin-left: 17%;"><%$update%></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    
    <%/foreach%>
<%else%>
    <div class="main pt-3">
        <div class="video-dash-post mb-20">
        <p><%$post_not_found%></p>
        </div>
    </div>
<%/if%>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select both class and id-based videos
    var videos = document.querySelectorAll("#video");
    var overlays = document.querySelectorAll(".video-btn-overlay");

    videos.forEach(function(video, index) {
        var replayButton = overlays[index].querySelector('.replay-btn');
        
        // Show overlay when the video ends
        video.addEventListener('ended', function() {
            overlays[index].style.display = 'flex';
            console.log('Video ' + (index + 1) + ' ended');
        });

        // Replay the video when the replay button is clicked
        replayButton.addEventListener('click', function() {
            video.currentTime = 0; // Reset the video time to the start
            video.play();          // Play the video again
            overlays[index].style.display = 'none'; // Hide the overlay when replaying
        });
    });
});


</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let videos = document.querySelectorAll("video");

    let observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.play();
                } else {
                    entry.target.pause();
                }
            });
        },
        { threshold: 0.5 } // 50% of the video must be visible
    );

    videos.forEach((video) => {
        observer.observe(video);
    });
});
</script>
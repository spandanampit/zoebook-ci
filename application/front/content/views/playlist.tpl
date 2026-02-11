<!-- inner banner section start -->
<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
        /* Custom Styles for Navigation Arrows */
        .carousel-prev-btn,
        .carousel-next-btn {
            position: absolute;
            top: 70%;
            transform: translateY(-50%);
            z-index: 10;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 50%;
            padding: 10px;
            font-size: 20px;
            color: #333;
            cursor: pointer;
        }

        .carousel-prev-btn {
            left: 20px;
        }

        .carousel-next-btn {
            right: 20px;
        }

        .liked {
            color: red !important;
        }

        .unliked {
            color: rgb(254, 254, 254) !important;
        }
        .plyr .plyr__play-large{
            display: none !important;
        }
        #myVideo {
            max-height: 32rem;
        }
        #playlist-carousel .plyr__controls {
            display: none;
        }
        
        .playlist-video_box {
            position: absolute; /* Keep this for positioning */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            padding: 10px;
            color: #fff;
            height: 100%;
            background-color: #33333388;
            z-index: 10; /* Make sure this is below the video thumbnails */
            pointer-events: none; /* This ensures the filter does not block clicks */
        }

        .item {
            position: relative; /* Ensure the video item has a reference for z-index */
        }

        .video-thumbnail {
            position: relative;
            z-index: 20; /* Ensure the video thumbnails are clickable */
            pointer-events: auto; /* Allow interaction with the video thumbnails */
        }

        .eye-btn {
            /* float: right; */
            padding-right: 14px;
        }

        .views-number {
            /* text-align: right; */
            padding-left: 9px;
            width: 97%;
        }

        .video_description{
            font-size: 18px;
            padding-top: 20px;
        }

        .save-btn {
            margin-left: 20px;
        }

        .playlist-share-form {
            height: 68px;
            border: 2px solid;
            border-color: #8e65a17a;
            border-radius: 25px;
            flex-basis: 75%;
        }

        .modal-dialog {
            height: 300px;
        }

        .modal-body{
            padding-top: 200px;
        }

        .btn_postcomment{
            background-color:#8e65a1 !important;
        }

        .btn_postcomment:hovar {
            background-color:#8e65a1bd !important;
        }
        .emoji-picker {
            transform: none !important;
        }
        .views {
            width: 12% !important;
        }

        #messageIcon {
            color: white;
            padding-top: 20px;
        }

        .modal-dialog {
            height: 300px;
        }

        .modal-body{
            padding-top: 20px;
            border-top: 2px solid;
            border-color: #8e65a1;
        }

        .btn_postcomment{
            background-color:#8e65a1 !important;
        }

        .btn_postcomment:hovar {
            background-color:#8e65a1bd !important;
        }
        .emoji-picker {
            transform: none !important;
        }

        .comment-picture {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
        }


        .time{
            font-size: 12px;
        }

        .comment-headers {
            width: 30%;
            display: flex;
            justify-content: space-between;
        }

        .comment {
            display: flex;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #fff; /* White background for the comment */
            border-radius: 8px; /* Rounded corners */
            border: 1px solid #e0e0e0; /* Light border for separation */
            align-items: flex-start; /* Align items to the start */
        }

        .comment-image {
            margin-right: 12px; /* Space between the image and the text */
        }

        .comment-picture {
            width: 40px; /* Set image size */
            height: 40px;
            border-radius: 50%; /* Make the image circular */
            object-fit: cover; /* Ensure the image covers the area without distortion */
        }

        .comment-headers {
            display: flex;
            flex-direction: column;
            justify-content: center; /* Align name and time vertically */
        }

        .name {
            font-weight: bold;
            font-size: 14px;
            color: #333;
        }

        .time {
            font-size: 12px;
            color: #888;
        }

        .comment-text {
            margin-top: 5px;
            font-size: 14px;
            color: #333;
            line-height: 1.5; /* Make the text more readable */
        }


        form {
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 10px;
            position: relative;
            padding: 10px 0;
            margin-top: auto; /* Pushes the form to the bottom */
        }

        textarea {
            width: 100%;
            resize: none;
            padding-right: 40px; /* Space for emoji button */
        }

        #emoji-btn-<%$playlist_posts[0]['iPostId']%> {
            position: absolute;
            right: 10px;
            top: 5px;
            cursor: pointer;
        }

        .form-btn {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            padding: 10px 0;
        }

        #comments {
            height: 180px;
            overflow: auto;
        }



    </style>
    
<section class="playlist-tab watch-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="video-widget-box">
                    <div class="banner-box">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="banner-content-2">
                                <%assign var=posted_text_withouemoji value=removeEmoji($playlist_posts[0].post_details.0.tPostTextEmoji)%>
                                    <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                                    <P id="video-description"><%$this->general->displayposttext($posted_text)%></P>
                                </div>
                                <div class="banner-content-2" id="action-feed">
                                    <div class="banner-like-box">
                                        <ul id="like-comment-share">
                                            <li onclick="playlistLike(<%$playlist_details[0].id%>, 1)" style="display: flex;">
                                                <i class="fa-solid fa-thumbs-up"></i> &nbsp; &nbsp;<p class="like-count"><%$likeCount%></p> 
                                            </li>
                                            
                                            <li onclick="playlistLike(<%$playlist_details[0].id%>, 2)" style="display: flex;">
                                                <i class="fa-solid fa-thumbs-down" style="display: flex;"></i> &nbsp; &nbsp;<p class="unlike-count"><%$unlikeCount%></p>
                                            </li>
                                            
                                            <li>
                                                <i class="fa-solid fa-share" onclick="generateShareLink(<%$playlist_details[0].id%>, <%$playlist_details[0].user_id%>)"></i> <%$share%>
                                            </li>
                                            <i class='far fa-comment' id="messageIcon" style='font-size:36px'></i>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4" id="banner-button-container">
                                <div class="banner-button-box">
                                    <button data_src="play" id="vidplay" type="button">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                        <i class="fa fa-pause" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <video id="myVideo" class="playerembed" width="100%" height="100%" controls data-poster="<%$playlist_posts[0].full_thumbnail_url%>" autoplay muted>
                        <source src="<%$playlist_posts[0].full_video_url%>" type="video/mp4">
                    </video>
                    <div class="videoId" id="<%$playlist_posts[0]['iPostId']%>"></div>

                </div>
            </div>

                <div class="col-md-10">
                    <div id="messageModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 600px; padding: 20px; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 1000; border-radius: 12px;">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><%$add_comments%>😊</h5>
                                    <i class="fa fa-close" style="font-size:36px; text-align:right;" id="closeModal"></i>
                                </div>
                                <div class="modal-body">

                                    <div id="comments"></div>

                                    <form style="grid-template-columns: auto auto;/* display: flex; */height: 53px;display: grid;/* grid-auto-columns: auto auto; */">
                                        <div style="position: relative; width: 31rem;">
                                            <textarea class="form-control comment_post_<%$playlist_posts[0]['iPostId']%>" 
                                                id="comment-box<%$playlist_posts[0]['iPostId']%>"
                                                data-postid="<%$playlist_posts[0]['iPostId']%>" 
                                                rows="2" 
                                                placeholder="Add Comment">
                                            </textarea>
                                            <span id="emoji-btn-<%$playlist_posts[0]['iPostId']%>" style="position: absolute; right: 10px; top: 5px; cursor: pointer;" onclick="openEmoji()">😀</span> 
                                            <!--<span id="emoji-btn-<%$playlist_posts[0]['iPostId']%>" style="position: absolute; right: 10px; top: 5px; cursor: pointer;" onclick="openEmoji(<%$playlist_posts[0]['iPostId']%>)">😀</span>-->
                                            <div id="emoji-picker-container" class="emoji-picker" style="display: none;"></div>
                                        </div>
                                        <input type="hidden" name="post_comment_emoji" id="post_comment_emoji">
                                        <button type="button" class="btn btn-primary form-btn btn_postcomment" style="cursor:pointer; width:100%;" data-postid="<%$playlist_posts[0].iPostId%>" title="Add Comment"><img  src="<%$this->config->item('images_url')%>front/plane.png"></button>
                                    </form><br>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Overlay -->
                    <div id="modalOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;"></div>
                </div>
        </div>
    </div>
</section>

<section class="playlist-sec">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12" style="display: flex; flex-wrap: wrap;">
                <div class="owl-carousel owl-theme" id="playlist-carousel">
                    <%assign var="suggestions" value=$this->general->get_user_suggestions()%>
                    <%foreach item=row from=$playlist_posts%>
                        <div class="item" style="min-width: 22rem">
                            <div class="playlist-box">
                                <%if $u_user_id eq $this->session->userdata('iUserId')%>
                                    <div class="video-post-icon">
                                        <button class="btn playlist-action" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" data-postid="<%$row.iPostId%>" onclick="remove(<%$row.iPostId%>)">Remove</a>
                                        </div>
                                    </div>
                                <%/if%>
                                <div class="playlist-item">
                                    <%if $row.eMediaType eq 'Image'%>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$row.iUserId%>/<%$row.vUploadFile%>" class="img-fluid" alt="" />
                                    <%else%>
                                        <video id="playlist-video<%$row.iPostMediaId%>" class="playerembed" width="100%" height="100%" preload="auto" data-poster="<%$row.full_thumbnail_url%>" onclick="showVideo('<%$row.full_video_url%>', '<%$row.full_thumbnail_url%>')" muted controlslist="">
                                            <source src="<%$row.full_video_url%>" type="video/mp4">
                                        </video>
                                    <%/if%>
                                    <%assign var=posted_text_withouemoji value=removeEmoji($row.post_details.0.tPostTextEmoji)%>
                                    <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>

                                    <div class="playlist-video_box">
                                        <div class="views"><i style='font-size:24px' class='fas eye-btn'>&#xf06e;</i></br><h5 class="views-number"><%$row.iViewsCount%></h5></div>
                                        <h4 class="video_description"><%$this->general->displayposttext($posted_text)%></h4>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <%/foreach%>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Navigation Arrows for Owl Carousel -->
<button class="carousel-prev-btn"><i class="fa fa-chevron-left"></i></button>
<button class="carousel-next-btn"><i class="fa fa-chevron-right"></i></button>

<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shareModalLabel">Share Playlist</h5>
        <button type="button" class="btn-close" aria-label="Close" onclick="closeModal()"></button>
      </div>
      <div class="modal-body">
        <p>Share this playlist with the following link:</p>
        <div class="input-group mb-3">
          <input type="text" class="form-control" id="shareableLinkInput" readonly>
          <button class="btn btn-primary" type="button" id="copyLinkButton" onclick="copyLink()">Copy</button>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
      </div>
    </div>
  </div>
</div>

<%$this->js->add_js("front/posts.js")%>
<script src="path/to/owl.carousel.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('exampleModal');
        var header = document.querySelector('.modal-header');

        var isDragging = false;
        var offset = { x: 0, y: 0 };

        header.addEventListener('mousedown', function(e) {
            isDragging = true;
            offset = {
                x: e.clientX - modal.getBoundingClientRect().left,
                y: e.clientY - modal.getBoundingClientRect().top
            };
        });

        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            modal.style.left = e.pageX - offset.x + 'px';
            modal.style.top = e.pageY - offset.y + 'px';
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
        });
    });

</script>
<!-- Include jQuery (required for Owl Carousel) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script>
   $(document).ready(function() {
    var videoElement = document.getElementById('myVideo');
    var buttonContainer = document.getElementById('banner-button-container');

    // Hide the button when the video starts playing
    videoElement.addEventListener('play', function() {
        console.log('display none');
        buttonContainer.style.display = 'none';
    });

    // Show the button when the video is paused
    videoElement.addEventListener('pause', function() {
        console.log('display pause');
        buttonContainer.style.display = 'block';
    });
    var owl = $('#playlist-carousel');

    owl.owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: false
            }
        },
        autoplay: false, // Disable autoplay
        lazyLoad: true,
        muted: true,
        responsiveRefreshRate: 100,
        onInitialized: startVideoOnLoad,
        onChanged: startVideoOnSlideChange
    });

    // Custom Navigation Events
    $('.carousel-next-btn').click(function() {
        owl.trigger('next.owl.carousel');
    });

    $('.carousel-prev-btn').click(function() {
        owl.trigger('prev.owl.carousel');
    });

    // Function to start video playback when initialized
    function startVideoOnLoad(event) {
        playCurrentVideo(event);
    }

    // Function to start video playback when slide changes
    function startVideoOnSlideChange(event) {
        playCurrentVideo(event);
    }

    // Function to play current video and pause others
    function playCurrentVideo(event) {
        var items = event.item.count;
        var item = event.item.index;
        var currentVideo = $(event.target).find('.owl-item').eq(item).find('video')[0];

        // Pause all other videos
        $(event.target).find('video').each(function(index, video) {
            if (video !== currentVideo) {
                video.pause();
                video.removeEventListener('ended', onVideoEnded);
            }
        });

        // Play the current video and log its src and data-poster
        if (currentVideo) {

            var currentVideoId = currentVideo.id;
            var postId = currentVideoId.match(/\d+$/)[0];
            console.log('postId:',postId);

            var textarea = document.querySelector(`[id^="comment-box"][data-postid]`);
            if (textarea) {
                textarea.setAttribute('id', `comment-box${postId}`);
                textarea.setAttribute('data-postid', postId);
                textarea.className = `form-control comment_post_${postId}`;
            }

            var videoIdDiv = document.querySelector('.videoId');
            if (videoIdDiv) {
                videoIdDiv.setAttribute('id', postId);
            }

            var emojiBtn = document.querySelector(`[id^="emoji-btn"]`);
            if (emojiBtn) {
                emojiBtn.setAttribute('id', `emoji-btn-${postId}`);
                emojiBtn.setAttribute('onclick', `openEmoji(${postId})`);
            }

            currentVideo.muted = true;
            currentVideo.play();
            currentVideo.addEventListener('ended', onVideoEnded);
            var currentVideoSrc = currentVideo.querySelector('source').src;
            var currentVideoPoster = currentVideo.getAttribute('data-poster');

            // Retrieve and display the video description
            var currentVideoId = currentVideo.id.replace('playlist-video', '');
            var descriptionElement = document.getElementById('playlist-title' + currentVideoId);
            var description = descriptionElement ? descriptionElement.textContent : '';
            setNewVideoSrcAndPoster(currentVideoSrc, currentVideoPoster, description);
        }
    }

    // Function to handle video ended event
    function onVideoEnded() {
        owl.trigger('next.owl.carousel');
    }

    // Function to set new src and data-poster for the current video
    function setNewVideoSrcAndPoster(newSrc, newPoster, description) {
        var video = document.getElementById('myVideo');
        var videoDescription = document.getElementById('video-description');
        video.setAttribute('src', newSrc);
        video.setAttribute('data-poster', newPoster);
        videoDescription.textContent = description;
        video.load();
        video.play();
    }

    // Add click event listeners to videos
    $('#playlist-carousel').on('click', 'video', function() {
        var clickedIndex = $(this).closest('.owl-item').index();
        console.log('clickIndex :' + clickedIndex);
        // Ensure the clicked index is within the visible range
        var visibleIndex = owl.find('.owl-item.active').index($(this).closest('.owl-item'));
        console.log('Ensure the clicked index is within the visible range :' + visibleIndex);
        // Slide to the clicked video
        owl.trigger('to.owl.carousel', [visibleIndex, 300, true]);

        // Pause all other videos in the slider
        $('#playlist-carousel').find('video').each(function() {
            this.pause();
        });

        // Update and play the external player with the clicked video's details
        var clickedVideo = $(this).get(0);
        var videoSrc = clickedVideo.querySelector('source').src;
        var videoPoster = clickedVideo.getAttribute('data-poster');
        var videoId = clickedVideo.id.replace('playlist-video', '');
        var descriptionElement = document.getElementById('playlist-title' + videoId);
        var description = descriptionElement ? descriptionElement.textContent : '';
        setNewVideoSrcAndPoster(videoSrc, videoPoster, description);
        
        // Play the clicked video in the slider
        clickedVideo.muted = true; // Ensure the clicked video is muted
        clickedVideo.play();
    });
});

// Function to get currently playing video information
const videoElement = document.getElementById('myVideo');
const videoSection = document.querySelector('.playlist-sec');
// Add description
const videoDescription = document.getElementById('video-description');
// console.log(videoDescription);
function getPlayingVideoInfo() {
    var sourceElement = videoElement.querySelector('source');

    var videosrc = sourceElement.getAttribute('src');
    var videoPoster = videoElement.getAttribute('data-poster');

    if(videoElement) {
        var sourceElement = videoElement.querySelector('source');
        if(sourceElement) {
            sourceElement.setAttribute('src', videosrc);
            videoElement.load();
        }
        videoElement.setAttribute('data-poster', videoPoster);
        videoElement.play();

    }else {
        console.error('Video element not found!');
    }
//   if (videoElement && videosrc) {
//     return {
//         src: videosrc,
//         poster: videoPoster,
//     };
//   } else {
//     return null;
//   }
}

const copyLinkButton = document.getElementById("copyLinkButton");
const shareableLinkInput = document.getElementById("shareableLinkInput");

copyLinkButton.addEventListener("click", function() {
    
  shareableLinkInput.select();
  
  if (navigator.clipboard) {
    navigator.clipboard.writeText(shareableLinkInput.value).then(() => {
        alert('Link copied to clipboard');
      console.log("Link copied to clipboard!");
    }, (err) => {
      console.error("Failed to copy link:", err);
    });
  } else {
    console.warn("navigator.clipboard is not supported. Consider using a library like Clipboard.js for older browsers.");
  }
});

function generateShareLink(playlist_id, user_id) {
    const playlist = playlist_id;
    const userId = user_id;
    const uniqueId = Math.random().toString(36).slice(2, 15);
    var shareableUrl = "<%$this->url->make('content/content/playlistshare')%>?playlistId=" + playlist + "&userId=" + userId;
    document.getElementById("shareableLinkInput").value = shareableUrl;
//   $("#shareModal").modal("show");
  openModal();
}


function closeModal() {
  var modal = document.getElementById('shareModal');
  modal.classList.remove('show');
  modal.style.display = 'none';
  var modalBackdrop = document.getElementsByClassName('modal-backdrop');
  document.body.removeChild(modalBackdrop[0]);
}

function openModal() {
  var modal = document.getElementById('shareModal');
  modal.classList.add('show');
  modal.style.display = 'block';
  var backdrop = document.createElement('div');
  backdrop.classList.add('modal-backdrop', 'fade', 'show');
  document.body.appendChild(backdrop);
}
// document.querySelector("a.fa-solid.fa-share").addEventListener("click", generateShareLink);

function remove(postId) {
        console.log(postId);
        var url = "<%$this->url->make('content/content/removePlaylistPost')%>"
        $.ajax({
            url: url,
            type: "POST",
            data: { postId: postId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    console.log("Video added to playlist successfully!");
                    var successMessage = document.createElement('div');
                    successMessage.textContent = "Video removed successfully! from playlist";
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

                    window.location.reload();
                } else {
                    console.error("Error remove video from playlist:", response.message);
                    var errorMessage = document.createElement('div');
                    errorMessage.textContent = "Error remove video from playlist.";
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

    function playlistLike(playlistId, likeId) {
        var url = "<%$this->url->make('content/content/playlistLike')%>"
        $.ajax({
            type: 'POST',
            url: url,
            data: { playlistId: playlistId, likeId: likeId },
            success: function(response) {
                console.log(response);
                // Parse the response as JSON
                var jsonResponse = JSON.parse(response);

                // Check the 'success' property of the jsonResponse
                if (jsonResponse.success) {
                    // Update like count on the frontend
                    var newCount = jsonResponse.newLikeCount;
                    var newUnlikeCount = jsonResponse.unlikeCount;
                    var likeId = jsonResponse.likeId;
                    $('.like-count').text(newCount);
                    $('.unlike-count').text(newUnlikeCount);
                    console.log(jsonResponse.data);
                    if (likeId == 1) {
                        $('i.fa-solid.fa-thumbs-up').addClass('liked').removeClass('unliked');
                        $('i.fa-solid.fa-thumbs-down').addClass('unliked').removeClass('liked');
                    } else {
                        $('i.fa-solid.fa-thumbs-down').addClass('liked').removeClass('unliked');
                        $('i.fa-solid.fa-thumbs-up').addClass('unliked').removeClass('liked');
                    }
                } else {
                    alert('Failed to like: ' + jsonResponse.message);
                }
            }
        });
    }
</script>

<script>
closeModal.addEventListener('click', () => {
    console.log('hitting');
    
  messageModal.style.display = 'none';
  modalOverlay.style.display = 'none';
});

// Close when clicking overlay
modalOverlay.addEventListener('click', () => {
    console.log('hitting');

  messageModal.style.display = 'none';
  modalOverlay.style.display = 'none';
});

const messageIcon = document.getElementById('messageIcon');
const messageModal = document.getElementById('messageModal');
const modalOverlay = document.getElementById('modalOverlay');
const closeModal = document.getElementById('closeModal');

// Open modal
messageIcon.addEventListener('click', () => {
    messageModal.style.display = 'block';
    modalOverlay.style.display = 'block';
      var videos = document.querySelectorAll("video");
    videos.forEach(video => video.play());
});


// Close modal
closeModal.addEventListener('click', () => {
  messageModal.style.display = 'none';
  modalOverlay.style.display = 'none';
    var videos = document.querySelectorAll("video");
    videos.forEach(video => video.play());
});

// Close when clicking overlay
modalOverlay.addEventListener('click', () => {
  messageModal.style.display = 'none';
  modalOverlay.style.display = 'none';
});
</script>

<script>
document.getElementById('messageIcon').addEventListener('click', function() {
    document.getElementById('messageModal').style.display = 'block';

    var videos = document.querySelectorAll("video");
    videos.forEach(video => video.pause());
    
    var divElement = document.querySelector('.videoId');
    if (divElement) {
        var postId = divElement.id;
    }
    const params = {
        post_id: postId,
    };

    $('#comment-box' + postId).val('');

    $.ajax({
        url: '/get_comments',
        method: 'GET',
        dataType: 'json',
        data: params,
        success: function(response) {
            $('#comments').empty();
            response.data.forEach(comment => {
                const commentHtml = `
                    <div class="comment">
                        <span class="comment-image">
                            <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/${comment.profile_image}" alt="${comment.user_name}" class="comment-picture">
                        </span>
                        <div class="comment-headers">
                            <h4 class="name">${comment.user_name}</h4>
                            <h4 class="time">${formatTime(comment.added_date)}</h4>
                        </div>
                        <h4 class="comment-text">${comment.comment}</h4>
                    </div>
                `;

                $('#comments').append(commentHtml);
            });
            

        },
        error: function(xhr, status, error) {
            console.error('Error loading data:', error);
        },
        complete: function() {
            loading = false;
        }
    });

    function formatTime(dateString) {
        const commentDate = new Date(dateString);
        const now = new Date();
        const diff = Math.abs(now - commentDate);
        const diffMinutes = Math.floor(diff / (1000 * 60));
        const diffHours = Math.floor(diffMinutes / 60);
        const diffDays = Math.floor(diffHours / 24);

        if (diffMinutes < 60) {
            return `${diffMinutes} minutes ago`;
        } else if (diffHours < 24) {
            return `${diffHours} hours ago`;
        } else {
            return `${diffDays} days ago`;
        }
    }
});

document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('messageModal').style.display = 'none';
    var videos = document.querySelectorAll("video");
        videos.forEach(video => video.play());
});
</script>
<script>
$(document).ready(function() {
    $('.btn_postcomment').click(function() {
        var divElement = document.querySelector('.videoId');

        if (divElement) {
            var postId = divElement.id;
        }
        var commentContent = $('#comment-box' + postId).val();
        
        $.ajax({
            url: '/add_comments',
            method: 'POST',
            data: { 
                post_id: postId,
                comment: commentContent
            },
            success: function(response) {
                console.log(response);
                $('#comment-box' + postId).val('');
                
            },
            error: function(xhr, status, error) {
                console.error('Error: ' + error);
            }
        });
        messageModal.style.display = 'none';
        modalOverlay.style.display = 'none';
        var videos = document.querySelectorAll("video");
        videos.forEach(video => video.play());
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/emoji-button@latest/dist/index.min.js"></script>
<script>

function openEmoji() {
    var divElement = document.querySelector('.videoId');
    if (divElement) {
        var postId = divElement.id;
    }

    const button = document.querySelector(`#emoji-btn-${postId}`);
    const commentBox = document.querySelector(`#comment-box${postId}`);

    console.log('openEmoji',button);


    const picker = new EmojiButton({
        rootElement: document.querySelector(`#messageModal`), // Attach picker to modal
    });

    // Show picker
    picker.showPicker(button);

    picker.on('emoji', emoji => {
        commentBox.value += emoji;
        commentBox.focus();
    });
}

</script>

<script>
function showVideo(videoUrl, posterUrl) {
    var mainVideo = document.getElementById("myVideo");
    var videoSource = mainVideo.getElementsByTagName('source')[0];

    videoSource.src = videoUrl;
    mainVideo.setAttribute('data-poster', posterUrl);

    var videoIdDiv = document.getElementById(postId);
    videoIdDiv.innerHTML = "Video ID: " + postId;

    mainVideo.load();
    mainVideo.play();
}
</script>
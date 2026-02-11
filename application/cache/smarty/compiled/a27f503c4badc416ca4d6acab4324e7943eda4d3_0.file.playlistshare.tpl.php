<?php
/* Smarty version 3.1.28, created on 2025-01-27 04:30:20
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/playlistshare.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67977c5c8c8732_92463051',
  'file_dependency' => 
  array (
    'a27f503c4badc416ca4d6acab4324e7943eda4d3' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/playlistshare.tpl',
      1 => 1737980998,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67977c5c8c8732_92463051 ($_smarty_tpl) {
?>
<!-- inner banner section start -->
<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

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
    float: right;
    padding-right: 14px;
}

.views-number {
    text-align: right;
    width: 97%;
}

.video_description{
    font-size: 18px;
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

#emoji-btn-<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
 {
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

#messageIcon {
    color: white;
    padding-top: 20px;
}   


</style>
<section class="playlist-tab watch-sec">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                <div class="back-btn">
                    <a href="dashboard.html"><i class="fa-solid fa-arrow-left"></i></a>  
                </div>
                <div class="section-profile">
                    <figure>
                        <?php ob_start();
echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];
$_tmp1=ob_get_clean();
if ($_tmp1 != '') {?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="">
                        <?php } else { ?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/alex.png" alt="">
                        <?php }?>
                    </figure>
                    <h4><?php echo $_smarty_tpl->tpl_vars['user']->value[0]['vName'];?>
</h4>
                    <h5><?php echo $_smarty_tpl->tpl_vars['following']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value[0]['following'];?>
 <?php echo $_smarty_tpl->tpl_vars['followers_lang']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['user']->value[0]['followers'];?>
</h5>
                    <h6><?php echo $_smarty_tpl->tpl_vars['share_playlist']->value;?>
</h6>
                    <i class='far fa-comment' id="messageIcon" style='font-size:36px'></i>
                    
                </div>
            </div>
            <div class="col-md-10">
                <div class="video-widget-box">
                    <div class="banner-box">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="banner-content-2">
                                <P id="video-description"><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>
</P>
                                
                                </div>
                            </div>
                            <div class="col-lg-4" id="banner-button-container">
                            
                                <div class="banner-button-box">
                                <button data_src="pause" id="vidplay" type="button">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                    <i class="fa fa-pause" aria-hidden="true"></i>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <video id="myVideo" class="playerembed" width="100%" height="100%" controls data-poster="<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['full_thumbnail_url'];?>
" autoplay muted>
                        <source src="<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['full_video_url'];?>
" type="video/mp4">
                    </video>
                    <div class="videoId" id="<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
"></div>

                </div>
            </div>

            <!--<?php echo print_r($_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId']);?>
-->
            <div class="col-md-10">
                <div id="messageModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 600px; padding: 20px; background: white; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 1000; border-radius: 12px;">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add Comments😊</h5>
                                <i class="fa fa-close" style="font-size:36px; text-align:right;" id="closeModal"></i>
                            </div>
                            <div class="modal-body">

                                <div id="comments"></div>

                                <form style="grid-template-columns: auto auto;/* display: flex; */height: 53px;display: grid;/* grid-auto-columns: auto auto; */">
                                    <div style="position: relative; width: 31rem;">
                                        <textarea class="form-control comment_post_<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
" 
                                            id="comment-box<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
"
                                            data-postid="<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
" 
                                            rows="2" 
                                            placeholder="Add Comment">
                                        </textarea>
                                        <!--<span id="emoji-btn-<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
" style="position: absolute; right: 10px; top: 5px; cursor: pointer;" onclick="openEmoji(<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
)">😀</span>-->
                                        <span id="emoji-btn-<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
" style="position: absolute; right: 10px; top: 5px; cursor: pointer;" onclick="openEmoji()">😀</span> 
                                        <div id="emoji-picker-container" class="emoji-picker" style="display: none;"></div>
                                    </div>
                                    <input type="hidden" name="post_comment_emoji" id="post_comment_emoji">
                                    <button type="button" class="btn btn-primary form-btn btn_postcomment" style="cursor:pointer; width:100%;" data-postid="<?php echo $_smarty_tpl->tpl_vars['playlist_posts']->value[0]['iPostId'];?>
" title="Add Comment"><img  src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/plane.png"></button>
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

<!-- <pre>
    <?php echo print_r($_smarty_tpl->tpl_vars['playlist_posts']->value);?>

</pre> -->

<section class="playlist-sec">
    <div class="container-fluid">
        <div class="row" style="height: 370px;">
            <div class="col-md-12" style="display: flex; flex-wrap: wrap;">
                <div class="owl-carousel owl-theme" id="playlist-carousel">
                    <?php $_smarty_tpl->tpl_vars["suggestions"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->get_user_suggestions(), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "suggestions", 0);?>
                    <?php
$_from = $_smarty_tpl->tpl_vars['playlist_posts']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
                        <div class="item" style="min-width: 22rem">
                            <div class="playlist-box">
                                <div class="playlist-item">
                                    <?php if ($_smarty_tpl->tpl_vars['row']->value['eMediaType'] == 'Image') {?>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['row']->value['iUserId'];?>
/<?php echo $_smarty_tpl->tpl_vars['row']->value['vUploadFile'];?>
" class="img-fluid" alt="" />
                                    <?php } else { ?>
                                        <?php $_smarty_tpl->tpl_vars['postId'] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['iPostMediaId'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'postId', 0);?>
                                        <video id="playlist-video<?php echo $_smarty_tpl->tpl_vars['row']->value['iPostMediaId'];?>
" class="playerembed" width="100%" height="100%" muted preload="auto" data-poster="<?php echo $_smarty_tpl->tpl_vars['row']->value['full_thumbnail_url'];?>
" onclick="showVideo('<?php echo $_smarty_tpl->tpl_vars['row']->value['full_video_url'];?>
', '<?php echo $_smarty_tpl->tpl_vars['row']->value['full_thumbnail_url'];?>
')" style="object-fit: cover;" autoplay muted>
                                            <source src="<?php echo $_smarty_tpl->tpl_vars['row']->value['full_video_url'];?>
" type="video/mp4">
                                        </video>
                                    <?php }?>
                                    <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['post_details'][0]['tPostTextEmoji']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
                                    <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
                                    <div class="playlist-video_box">
                                        <div class="views"><i style='font-size:24px' class='fas eye-btn'>&#xf06e;</i></br><h5 class="views-number"><?php echo $_smarty_tpl->tpl_vars['row']->value['iViewsCount'];?>
</h5></div>
                                        <h4 class="video_description"><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>
</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
?>
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
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <p style="padding: 18px;">Share this playlist with the following link:</p>
      <div class="modal-body" style="display: flex;">
        <input type="text" class="form-control" id="shareableLinkInput" readonly>
        <button type="button" class="btn btn-primary" id="copyLinkButton">Copy</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/posts.js");?>

<?php echo '<script'; ?>
 src="path/to/owl.carousel.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
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

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"><?php echo '</script'; ?>
>
{* <!-- Include Owl Carousel JS --> *}
<?php echo '<script'; ?>
 src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
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

    function startVideoOnSlideChange(event) {
        playCurrentVideo(event);
    }

    function playCurrentVideo(event) {
        var items = event.item.count;
        var item = event.item.index;
        var currentVideo = $(event.target).find('.owl-item').eq(item).find('video')[0];

        $(event.target).find('video').each(function(index, video) {
            if (video !== currentVideo) {
                video.pause();
                video.removeEventListener('ended', onVideoEnded);
            }
        });

        if (currentVideo) {
            currentVideo.muted = true;
            currentVideo.play();
            currentVideo.addEventListener('ended', onVideoEnded);
            
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

            var currentVideoSrc = currentVideo.querySelector('source').src;
            var currentVideoPoster = currentVideo.getAttribute('data-poster');

            var currentVideoId = currentVideo.id.replace('playlist-video', '');
            var descriptionElement = document.getElementById('playlist-title' + currentVideoId);
            var description = descriptionElement ? descriptionElement.textContent : '';
            setNewVideoSrcAndPoster(currentVideoSrc, currentVideoPoster, description);
        }
    }

    function onVideoEnded() {
        owl.trigger('next.owl.carousel');
    }

    function setNewVideoSrcAndPoster(newSrc, newPoster, description) {
        var video = document.getElementById('myVideo');
        var videoDescription = document.getElementById('video-description');
        video.setAttribute('src', newSrc);
        video.setAttribute('data-poster', newPoster);
        videoDescription.textContent = description;
        video.load();
        video.play();
    }

    $('#playlist-carousel').on('click', 'video', function() {
        var clickedIndex = $(this).closest('.owl-item').index();
        console.log('clickIndex :' + clickedIndex);
        var visibleIndex = owl.find('.owl-item.active').index($(this).closest('.owl-item'));
        console.log('Ensure the clicked index is within the visible range :' + visibleIndex);
        owl.trigger('to.owl.carousel', [visibleIndex, 300, true]);

        $('#playlist-carousel').find('video').each(function() {
            this.pause();
        });

        var clickedVideo = $(this).get(0);
        var videoSrc = clickedVideo.querySelector('source').src;
        var videoPoster = clickedVideo.getAttribute('data-poster');
        var videoId = clickedVideo.id.replace('playlist-video', '');
        var descriptionElement = document.getElementById('playlist-title' + videoId);
        var description = descriptionElement ? descriptionElement.textContent : '';
        setNewVideoSrcAndPoster(videoSrc, videoPoster, description);
        
        clickedVideo.muted = true;
        clickedVideo.play();
    });
});

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

const messageIcon = document.getElementById('messageIcon');
const messageModal = document.getElementById('messageModal');
const modalOverlay = document.getElementById('modalOverlay');
const closeModal = document.getElementById('closeModal');

// Open modal
messageIcon.addEventListener('click', () => {
    
    messageModal.style.display = 'block';
    modalOverlay.style.display = 'block';

    var videos = document.querySelectorAll("video");
    videos.forEach(video => video.pause());
    
    console.log('video',video);
    
    
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
  var videos = document.querySelectorAll("video");
    videos.forEach(video => video.play());
});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/emoji-button@latest/dist/index.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

function openEmoji() {
    var divElement = document.querySelector('.videoId');
    if (divElement) {
        var postId = divElement.id;
    }

    const button = document.querySelector(`#emoji-btn-${postId}`);
    const commentBox = document.querySelector(`#comment-box${postId}`);


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

<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    function showVideo(videoUrl, posterUrl) {
        var mainVideo = document.getElementById("myVideo");
        var videoSource = mainVideo.getElementsByTagName('source')[0];
        var poster = mainVideo.getAttribute('data-poster');

        // Update the video source and poster
        videoSource.src = videoUrl;
        mainVideo.setAttribute('data-poster', posterUrl);

        // Reload the video to play the new source
        mainVideo.load();
        mainVideo.play();
    }
<?php echo '</script'; ?>
><?php }
}

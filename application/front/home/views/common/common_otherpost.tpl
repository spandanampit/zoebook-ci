<!--<%$otherpost|print_r%> -->
<%if $otherpost|@count gt 0%>
<%assign var="count" value=0%>
<%assign var="videoIndex" value=0%> <!-- Initialize index for videos -->
<script type="text/javascript">
    atOptions = {
        'key' : '6214f5b373178054cad7ebc30f7984a4',
        'format' : 'iframe',
        'height' : 300,
        'width' : 160,
        'params' : {}
    };
</script>
<script type="text/javascript" src="//www.topcreativeformat.com/6214f5b373178054cad7ebc30f7984a4/invoke.js"></script>

<style>
    .related-videos {
        overflow-x:hidden
    }
    .related-videos::-webkit-scrollbar{
        display: none;
    }
</style>

<div class="related-videos" id="related-videos">
  
    <%foreach item=row key=i from=$otherpost%>
    <%$this->general->updateotherpost_impression(<%$row['p_post_id']%>,<%$row['p_user_id']%>)%>
    <%if $row['um_media_type'] eq 'Video'%>
    
    <div class="related-list">
        <%if $row['page_type'] eq 'profile'%>

        <a href="<%$this->general->setdiplayposturl($row['p_post_id'],$row['p_post_text'])%>?pageType=Profile&userId=<%$row['p_user_id']%>" class="otherpost_act" data-otherpostid="<%$row['p_post_id']%>" >
            <div style="position:relative">
                <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;">
                </div>
                <div class="related-list-img">
                    <video class="related-video" 
                        data-likes="<%$row['likes_count']%>" 
                        data-time="<%$row['p_added_date']%>" 
                        data-user-id="<%$row['p_user_id']%>" 
                        data-views="<%$row['views_count']%>" 
                        data-video-id="<%$row['p_post_id']%>" 
                        data-video-src="<%$row['um_upload_file']%>" 
                        width="160" 
                        height="90" 
                        preload="metadata" 
                        poster="<%$row['p_video_thumbnail']%>" 
                        data-username="<%$row['u_name']%>"
                        data-user-image="<%$row['u_profile_image']%>" 
                        data-caption="<%$row['p_post_text']%>"
                        data-post-mediaId = "<%$row['post_media_id']%>"
                        muted>
                        <source src="<%$row['um_upload_file']%>#t=0.30" type="video/mp4">
                    </video>

                </div>
            </div>
        </a>
        <%else%>

        <a href="<%$this->general->setdiplayposturl($row['p_post_id'],$row['p_post_text'])%>" class="otherpost_act" data-otherpostid="<%$row['p_post_id']%>" >
            <div style="position:relative">
                <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;">
                </div>
                <div class="related-list-img">
                    <video class="related-video" 
                        data-likes="<%$row['likes_count']%>" 
                        data-time="<%$row['p_added_date']%>" 
                        data-user-id="<%$row['p_user_id']%>" 
                        data-views="<%$row['views_count']%>" 
                        data-video-id="<%$row['p_post_id']%>" 
                        data-video-src="<%$row['um_upload_file']%>" 
                        width="160" 
                        height="90" 
                        preload="metadata" 
                        poster="<%$row['p_video_thumbnail']%>" 
                        data-username="<%$row['u_name']%>"
                        data-user-image="<%$row['u_profile_image']%>" 
                        data-caption="<%$row['p_post_text']%>"
                        data-post-mediaId= "<%$row['post_media_id']%>"
                        muted>
                        <source src="<%$row['um_upload_file']%>#t=0.30" type="video/mp4">
                    </video>

                </div>
            </div>
        </a>
        <%/if%>

        <div class="related-list-content">
            <%assign var=posted_text value=$this->general->truncateChars(removeEmoji($row['p_post_text']), 80)%>
            <h4>
            <%if $row['page_type'] eq 'profile'%>
                <a href="<%$this->general->setdiplayposturl($row['p_post_id'],$row['p_post_text'])%>?pageType=Profile&userId=<%$row['p_user_id']%>" class="otherpost_act" data-otherpostid="<%$row['p_post_id']%>" ><%$this->general->displayposttext($posted_text)%></a>
            <%else%>
                <a href="<%$this->general->setdiplayposturl($row['p_post_id'],$row['p_post_text'])%>" class="otherpost_act" data-otherpostid="<%$row['p_post_id']%>" ><%$this->general->displayposttext($posted_text)%></a>
            <%/if%>
            </h4>
            <p><%time_elapsed_string($row['p_added_date'])%></p>
            <div class="related-list-like">
                <ul>
                    <li class="yellow-color"><%$row['p_impression_count']%> <%$views%></li>
                </ul>
            </div>
        </div>
    </div>
    <%assign var="videoIndex" value=$videoIndex + 1%>
    <%/if%>
    <%/foreach%>
</div>

<%else%>
<li><%$noPostAvailable%></li>
<%/if%>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("Auto feed related video");
        var mainVideo = document.getElementById('main-video'); 
        var relatedVideos = document.querySelectorAll('.related-video');
        var currentIndex = 0; 
        
        var usernameElement = document.querySelector('.video-post-info-content h3');
        var userProfile = document.querySelector('.video-post-info-content a');
        var currentHref = userProfile.getAttribute('href');

        var profileImageElement = document.querySelector('.video-post-img img');

        var viewsElement = document.querySelector('.views h3');
        var likeElement = document.querySelector('.disp_postlikes');
        var added_date = document.querySelector('.added_date h3');
        var captionElement = document.querySelector('.video-post-text h3');
        var commentImage = document.querySelector('.pst-dtl-img');
        var sendBtn = document.querySelector('.act_postcomment');
        var preDescription = document.getElementById('half-description');
        var fullDescription = document.getElementById('full-text');
        var readMore = document.getElementById('read-more');
        
        
        mainVideo.addEventListener('ended', function() {
            preDescription.style.display = 'none';
            preDescription.classList.add('hidden');
            playNextVideo();
        });
        
        function playNextVideo() {
            if (currentIndex < relatedVideos.length) {
                var nextVideo = relatedVideos[currentIndex];
                var nextVideoSrc = nextVideo.getAttribute('data-video-src');
                var newUserName = nextVideo.getAttribute('data-username');
                var newUserProfileImage = nextVideo.getAttribute('data-user-image');
                var newLikes = nextVideo.getAttribute('data-likes');
                var time = nextVideo.getAttribute('data-time');
                var userId = nextVideo.getAttribute('data-user-id');
                var views = nextVideo.getAttribute('data-views');
                var videoId = nextVideo.getAttribute('data-video-id');
                var caption = nextVideo.getAttribute('data-caption');
                var mediaId = nextVideo.getAttribute('data-post-mediaId');
                var decodedCaption = typeof caption === 'string' ? decodeURIComponent(escape(caption)) : caption;

                var textarea = document.querySelector('textarea[data-postid]');
                var uploadFile = document.querySelector(`[id^='media_div']`);
                
                
                console.log('preDescription:',preDescription, 'fullDescription',fullDescription, 'readMore',readMore);

                
                
                uploadFile.setAttribute('id',`media_div_${videoId}`);
                textarea.setAttribute('data-postid', videoId);
                sendBtn.setAttribute('data-postid', videoId);
                sendBtn.setAttribute('data-mediaid', mediaId);

                if (preDescription && fullDescription && readMore) {
                    
                    fullDescription.style.display = 'none';
                    readMore.style.display = 'none';
                }

                console.log('userProfile',userProfile);

                var formattedUserName = newUserName.toLowerCase().replace(/\s+/g, '');
                console.log('formattedUserName',formattedUserName);
                userProfile.setAttribute('href', `https://zoebook.mydevfactory.com/user-profile-${userId}-${formattedUserName}.html`);
                //userProfile.setAttribute('href', `https://zoebook.com/user-profile-${userId}-${formattedUserName}.html`);
                
                var source = mainVideo.querySelector('source');
                source.setAttribute('src', nextVideoSrc);
                
                if (usernameElement) {
                    usernameElement.textContent = newUserName;
                }

                if (profileImageElement) {
                    profileImageElement.setAttribute('src', newUserProfileImage);
                    commentImage.setAttribute('src', newUserProfileImage);
                }

                if (viewsElement) {
                    viewsElement.textContent = views;
                }

                if (added_date) {
                    var modified_time = timeElapsedString(time)
                    added_date.textContent = modified_time;
                }

                if (captionElement) {
                    var decodedCaption = decodeUnicodeSurrogates(caption);
                    captionElement.textContent = displayCaptionWithMoreButton(decodedCaption);
                }

                var likesCountElement = likeElement.querySelector('span[data-likescount]');
                if (likesCountElement) {
                    likesCountElement.setAttribute('data-likescount', newLikes);
                    likesCountElement.innerHTML = newLikes + '&nbsp;';
                }

                likeElement.setAttribute('data-postid', videoId);

                mainVideo.load();
                mainVideo.play();

                const params = {
                    post_id: videoId,
                };
                
                $.ajax({
                    url: '/post_detail_comments',
                    method: 'POST',
                    dataType: 'json',
                    data: params,
                    success: function(data) {
                        if (data.success) {
                            const comments = data.postcomment;
                            renderComments(comments);
                            console.log(data);
                            
                        } else {
                            console.error('Failed to load comments');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading data:', error);
                        loading = false;
                    }
                });
                currentIndex++;
            } else {
                console.log("No more related videos.");
            }
        }
    });

    function renderComments(comments) {
        const commentsSection = document.getElementById("comments-section");
        console.log(commentsSection);
        
        commentsSection.innerHTML = "";

        comments.forEach((comment) => {
            const commentHTML = `
                <div class="comment-container">
                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/${comment.profile_image}" alt="${comment.user_name}'s profile picture" />
                    <div class="comment-content">
                        <div class="comment-header">
                            <span class="username">${comment.user_name}</span>
                            <span class="added-date">${comment.added_date}</span>
                        </div>
                        <div class="comment-text">${decodeUnicodeSurrogates(comment.comment)}</div>
                    </div>
                </div>
            `;
            commentsSection.insertAdjacentHTML("beforeend", commentHTML);
        });
    }
</script>

<script>
function timeElapsedString(date) {
    const now = new Date();
    const seconds = Math.floor((now - new Date(date)) / 1000);
    let interval = seconds / 31536000;

    if (interval > 1) return Math.floor(interval) + " years ago";
    interval = seconds / 2592000;
    if (interval > 1) return Math.floor(interval) + " months ago";
    interval = seconds / 86400;
    if (interval > 1) return Math.floor(interval) + " days ago";
    interval = seconds / 3600;
    if (interval > 1) return Math.floor(interval) + " hours ago";
    interval = seconds / 60;
    if (interval > 1) return Math.floor(interval) + " minutes ago";
    return Math.floor(seconds) + " seconds ago";
}

function decodeUnicodeSurrogates(str) {
    return str.replace(/\\u([\dA-Fa-f]{4})/g, function (match, grp) {
        return String.fromCharCode(parseInt(grp, 16));
    });
}

const relatedVideos = document.querySelectorAll('.related-video');

relatedVideos.forEach(video => {
    video.addEventListener('mouseenter', () => {
        video.setAttribute('autoplay', 'autoplay');
        video.play();
    });

    video.addEventListener('mouseleave', () => {
        video.removeAttribute('autoplay');
        video.pause();
        video.currentTime = 0;
    });
});

function displayCaptionWithMoreButton(caption) {
    const captionElement = document.getElementById('captionText');
    const moreBtn = document.getElementById('moreBtn');

    const decodedCaption = decodeUnicodeSurrogates(caption);
    const words = decodedCaption.split(' ');
    // console.log('words.length',words.length);
    

    if (words.length > 10) {
        const shortText = words.slice(0, 10).join(' ') + '...';
        captionElement.textContent = shortText;
        moreBtn.style.display = 'inline';

        let isExpanded = false;
        moreBtn.addEventListener('click', function () {
            if (isExpanded) {
                captionElement.textContent = shortText;
                moreBtn.textContent = 'Read more';
            } else {
                captionElement.textContent = decodedCaption;
                moreBtn.textContent = 'Read less';
            }
            isExpanded = !isExpanded;
        });
    } else {
        captionElement.textContent = decodedCaption;
    }
}
</script>
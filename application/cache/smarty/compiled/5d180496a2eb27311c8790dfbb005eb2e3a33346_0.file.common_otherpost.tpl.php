<?php
/* Smarty version 3.1.28, created on 2025-02-05 03:34:43
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_otherpost.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67a34cd3434b71_64298525',
  'file_dependency' => 
  array (
    '5d180496a2eb27311c8790dfbb005eb2e3a33346' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_otherpost.tpl',
      1 => 1738755224,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67a34cd3434b71_64298525 ($_smarty_tpl) {
?>
<!--<?php echo print_r($_smarty_tpl->tpl_vars['otherpost']->value);?>
 -->
<?php if (count($_smarty_tpl->tpl_vars['otherpost']->value) > 0) {
$_smarty_tpl->tpl_vars["count"] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "count", 0);
$_smarty_tpl->tpl_vars["videoIndex"] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "videoIndex", 0);?> <!-- Initialize index for videos -->
<?php echo '<script'; ?>
 type="text/javascript">
    atOptions = {
        'key' : '6214f5b373178054cad7ebc30f7984a4',
        'format' : 'iframe',
        'height' : 300,
        'width' : 160,
        'params' : {}
    };
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="//www.topcreativeformat.com/6214f5b373178054cad7ebc30f7984a4/invoke.js"><?php echo '</script'; ?>
>

<style>
    .related-videos {
        overflow-x:hidden
    }
    .related-videos::-webkit-scrollbar{
        display: none;
    }
</style>

<div class="related-videos" id="related-videos">
  
    <?php
$_from = $_smarty_tpl->tpl_vars['otherpost']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$__foreach_row_0_saved_key = isset($_smarty_tpl->tpl_vars['i']) ? $_smarty_tpl->tpl_vars['i'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_0_total) {
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
    <?php ob_start();
echo $_smarty_tpl->tpl_vars['row']->value['p_post_id'];
$_tmp1=ob_get_clean();
ob_start();
echo $_smarty_tpl->tpl_vars['row']->value['p_user_id'];
$_tmp2=ob_get_clean();
echo $_smarty_tpl->tpl_vars['this']->value->general->updateotherpost_impression($_tmp1,$_tmp2);?>

    <?php if ($_smarty_tpl->tpl_vars['row']->value['um_media_type'] == 'Video') {?>
    
    <div class="related-list">
        <?php if ($_smarty_tpl->tpl_vars['row']->value['page_type'] == 'profile') {?>

        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['p_post_id'],$_smarty_tpl->tpl_vars['row']->value['p_post_text']);?>
?pageType=Profile&userId=<?php echo $_smarty_tpl->tpl_vars['row']->value['p_user_id'];?>
" class="otherpost_act" data-otherpostid="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_id'];?>
" >
            <div style="position:relative">
                <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;">
                </div>
                <div class="related-list-img">
                    <video class="related-video" 
                        data-likes="<?php echo $_smarty_tpl->tpl_vars['row']->value['likes_count'];?>
" 
                        data-time="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_added_date'];?>
" 
                        data-user-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_user_id'];?>
" 
                        data-views="<?php echo $_smarty_tpl->tpl_vars['row']->value['views_count'];?>
" 
                        data-video-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_id'];?>
" 
                        data-video-src="<?php echo $_smarty_tpl->tpl_vars['row']->value['um_upload_file'];?>
" 
                        width="160" 
                        height="90" 
                        preload="metadata" 
                        poster="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_video_thumbnail'];?>
" 
                        data-username="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_name'];?>
"
                        data-user-image="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_profile_image'];?>
" 
                        data-caption="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_text'];?>
"
                        data-post-mediaId = "<?php echo $_smarty_tpl->tpl_vars['row']->value['post_media_id'];?>
"
                        muted>
                        <source src="<?php echo $_smarty_tpl->tpl_vars['row']->value['um_upload_file'];?>
#t=0.30" type="video/mp4">
                    </video>

                </div>
            </div>
        </a>
        <?php } else { ?>

        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['p_post_id'],$_smarty_tpl->tpl_vars['row']->value['p_post_text']);?>
" class="otherpost_act" data-otherpostid="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_id'];?>
" >
            <div style="position:relative">
                <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;">
                </div>
                <div class="related-list-img">
                    <video class="related-video" 
                        data-likes="<?php echo $_smarty_tpl->tpl_vars['row']->value['likes_count'];?>
" 
                        data-time="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_added_date'];?>
" 
                        data-user-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_user_id'];?>
" 
                        data-views="<?php echo $_smarty_tpl->tpl_vars['row']->value['views_count'];?>
" 
                        data-video-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_id'];?>
" 
                        data-video-src="<?php echo $_smarty_tpl->tpl_vars['row']->value['um_upload_file'];?>
" 
                        width="160" 
                        height="90" 
                        preload="metadata" 
                        poster="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_video_thumbnail'];?>
" 
                        data-username="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_name'];?>
"
                        data-user-image="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_profile_image'];?>
" 
                        data-caption="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_text'];?>
"
                        data-post-mediaId= "<?php echo $_smarty_tpl->tpl_vars['row']->value['post_media_id'];?>
"
                        muted>
                        <source src="<?php echo $_smarty_tpl->tpl_vars['row']->value['um_upload_file'];?>
#t=0.30" type="video/mp4">
                    </video>

                </div>
            </div>
        </a>
        <?php }?>

        <div class="related-list-content">
            <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars(removeEmoji($_smarty_tpl->tpl_vars['row']->value['p_post_text']),80), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
            <h4>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['page_type'] == 'profile') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['p_post_id'],$_smarty_tpl->tpl_vars['row']->value['p_post_text']);?>
?pageType=Profile&userId=<?php echo $_smarty_tpl->tpl_vars['row']->value['p_user_id'];?>
" class="otherpost_act" data-otherpostid="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>
</a>
            <?php } else { ?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['p_post_id'],$_smarty_tpl->tpl_vars['row']->value['p_post_text']);?>
" class="otherpost_act" data-otherpostid="<?php echo $_smarty_tpl->tpl_vars['row']->value['p_post_id'];?>
" ><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>
</a>
            <?php }?>
            </h4>
            <p><?php echo time_elapsed_string($_smarty_tpl->tpl_vars['row']->value['p_added_date']);?>
</p>
            <div class="related-list-like">
                <ul>
                    <li class="yellow-color"><?php echo $_smarty_tpl->tpl_vars['row']->value['p_impression_count'];?>
 <?php echo $_smarty_tpl->tpl_vars['views']->value;?>
</li>
                </ul>
            </div>
        </div>
    </div>
    <?php $_smarty_tpl->tpl_vars["videoIndex"] = new Smarty_Variable($_smarty_tpl->tpl_vars['videoIndex']->value+1, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "videoIndex", 0);?>
    <?php }?>
    <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
if ($__foreach_row_0_saved_key) {
$_smarty_tpl->tpl_vars['i'] = $__foreach_row_0_saved_key;
}
?>
</div>

<?php } else { ?>
<li><?php echo $_smarty_tpl->tpl_vars['noPostAvailable']->value;?>
</li>
<?php }?>

<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
><?php }
}

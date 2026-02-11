<%assign var="count" value=0%>
<style>
.swiper-container {
    width: 100%;
    height: auto;
    overflow: hidden;
    }
.top-usename {
    width: 9rem;
    color: white;
    text-align: center;
    position: relative;
    right: 31px;
    margin-top: 5px;
    font-weight: bold;
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

#plyr-video {
    position: relative;
}

.custom-slider-nav {
      width: 8% !important;
      background: #ffffff;
      height: 63px !important;
      border-radius: 30px;
}

.slider-nav {
      position: relative;
      bottom: 20rem;
}

.custom-slider-nav::after {
      color: rgb(0, 0, 0);
}


.item {
    position: relative;
}
.play-button-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.play-gif {
    width: 70px;
    height: 70px;
    background: rgba(0,0,0,0.65);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.3s ease;
}

.play-gif svg {
    position: absolute;
    transition: opacity 0.2s ease;
}

.icon-pause {
    opacity: 0;
}

.play-gif.pause .icon-play {
    opacity: 0;
}

.play-gif.pause .icon-pause {
    opacity: 1;
}



</style>


<!-- Home Page Posts -->
<%if $posts_pgtype neq 'my_profile' && $posts_pgtype neq 'other_profile'%>
      <%include file="common/top_play_list.tpl"%>
<%/if%>

<%if $new_page neq 'false'  && $posts_pgtype eq 'my_profile'%>
      <div class="welcome-message" style="max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #f9f9f9; text-align: center;">
            <h2 style="color: #333;">No Post Found!</h2>
            <p style="font-size: 16px; color: #555;">
                  🚀 <strong>Welcome to Zoebook!</strong> 🎉<br> 
                  It looks like you haven’t shared anything yet. Why not make your first post today? 📝✨
                  Tell your friends what’s on your mind, share a fun moment 📸, or drop a GIF that matches your vibe! 😃🔥
                  Start connecting and let your voice be heard! 💬🌍
            </p>
            <div style="margin-top: 20px;">
                  <button style="padding: 10px 20px; font-size: 16px; border: none; background-color: #007bff; color: #fff; border-radius: 5px; cursor: pointer;"><a href="<%$this->config->item('site_url')%>viral-posts.html" style="color: white;">Let's Gooo!</a></button>
            </div>
      </div>
<%/if%>


<%section name=i loop=$posts%>
    <%if $posts[i]['post_type'] eq 'Share'%>
        <%assign var=posttext_without_emoji value=$this->general->linkify($posts[i]['post_text'])%>
        <%assign var=meta_posttext_without_emoji value=$this->general->linkify($posts[i]['post_metadata']['text'])%>
        <div class="video-dash-post mb-20 feed_item" id="feed_id_<%$posts[i]['post_id']%>">
            <div class="video-dash-post-heading">
                <div class="video-dash-post-user">
                <div class="video-dash-post-img">

                    <a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>">
                    <%if $posts[i]['user_profile_image'] neq ''%>
                        <%if $posts[i]['post_type'] eq 'Media' || $posts[i]['visibility'] eq 'Viral'%>
                            <img src="<%$posts[i]['user_profile_image']%>" alt="">
                        <%else%>
                            <%if $posts_pgtype neq 'other_profile'%>
                                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                            <%else%>
                                <img src="<%$posts[i]['user_profile_image']%>" alt="">
                            <%/if%>
                        <%/if%>
                    <%else%>
                        <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                    <%/if%>
                    </a>
                </div>
                <div class="video-post-content">
                    <h5><a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>" style="color: gray;"><%$posts[i]['user_name']%></a></h5>
                    <p title="<%$posts[i]['added_date']%>">
                        <%*time_elapsed_string($posts[i]['added_date'])*%>
                        <%$this->general->getLocalDateTime($posts[i]['added_date'], "Y-m-d H:i")%>
                    </p>
                </div>
                </div>
                <div class="video-post-icon">
                <a href="#">
                   <i class="fa fa-ellipsis-v"></i>
                </a>
                </div>
            </div>
            <div class="video-post-content">
                <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>">
                    <p><%$this->general->displayposttext(removeEmoji($posttext_without_emoji))%></p>
                </a>

                <%if $posts[i]['post_metadata']['link'] neq ''%>
                    <p class="displayemoji_comment">
                    <%$this->general->displayposttext(removeEmoji($meta_posttext_without_emoji))%>
                    </p>
                    <%if $posts[i]['post_metadata']['title'] neq ''%>
                        <p class="displayemoji_comment"><%$posts[i]['post_metadata']['title']|nl2br%></p>
                    <%/if%>
                    <%if $posts[i]['post_metadata']['image'] neq ''%>
                        <a target="_blank" href="<%$posts[i]['post_metadata']['link']%>"><img style="width:100%;" src="<%$posts[i]['post_metadata']['image']%>"/></a>
                    <%/if%>
                <%else%>
                    <a href="<%$this->general->setdiplayposturl($posts[i]['get_actual_post']['p_post_id'],$posts[i]['get_actual_post']['p_post_text'])%>">
                    <p class="displayemoji_comment"><%$this->general->displayposttext($posts[i]['get_actual_post']['p_post_text'])%></p>
                    </a>
                <%/if%>
            </div>
            <div class="video-post-vid">
                <div class="video-wrapper">
                <p class="view <%if $posts[i]['is_impressed'] eq 1%>active<%/if%>"><i class="fa-regular fa-eye"></i> &nbsp <%$posts[i]['impression_count']%> </p>
                <%if $posts[i]['get_actual_post']['p_post_type'] eq 'Media' or $posts[i]['get_actual_post']['p_post_type'] eq 'Live'%>
                    <%assign var=post_media value=$posts[i]['get_actual_post_media']%>
                    <%section name=j loop=$post_media%>
                        <div class="video-container-2 owl-carousel owl-theme media-slider media_slider" data-getmediaid="<%$post_media[j]['pm_post_media_id']%>" data-getpostid="<%$post_media[j]['pm_post_id']%>" id="video-container" style="display: block !important;">
                            <%if $post_media[j]['pm_media_type'] eq 'Image'%>
                                <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>"><img src="<%$post_media[j]['upload_file_org']%>" alt=""></a>
                            <%elseif $post_media[j]['pm_media_type'] eq 'Video'%>
                                <%if $post_media[j]['pm_vSourceType'] eq 'aws'%>
                                    <video controls="" id="plyr-video" class="playerembed autoplay-video" preload="metadata" width="100%" height="100%" controls data-poster="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$post_media[j]['pm_user_id']%>/<%$post_media[j]['pm_video_thumbnail_org']%>" controlsList="nodownload" muted>
                                        <source src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$post_media[j]['pm_user_id']%>/<%$post_media[j]['pm_upload_file']%>" type="video/mp4">
                                    </video>
                                <%elseif $post_media[j]['pm_vSourceType'] eq 'cld'%>
                                    <video controls="" id="plyr-video" class="playerembed autoplay-video" preload="metadata" width="100%" height="100%" controls data-poster="<%$post_media[j]['pm_vCloudinary']%>" controlsList="nodownload" muted>
                                        <source src="<%$post_media[j]['pm_vCloudinary']%>" type="video/mp4">
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
                                    <a data-id="<%$posts[i]['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>">
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
                    <%/section%>
                <%/if%>
                </div>
            </div>
            <div class="video-share-box-wrapper">
                <div class="video-share-box" id="feed_action_<%$posts[i]['post_id']%>">
                <ul>
                    <%include file="common/feed_actions.tpl"%>
                </ul>
                </div>
                <div class="video-photo">
                <a href="#">
                    <i class="fa-regular fa-images"></i>
                </a>
                <%if $posts_pgtype eq 'my_profile'%>
                <%if $posts[i]['visibility'] eq 'Viral'%>
                    <div class="my-progress-bar" data-value="<%time_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%>" data-thickness="4">
                        <span style="color: gray"><%hours_left($posts[i]['added_date'],$posts[i]['expire_date'])%></span>
                    </div>
                <%/if%>
                <%/if%>
                
                </div>
            </div>
            <div class="comment">
                <div class="cmnt-pic">
                    <%if $posts[i]['user_profile_image'] neq ''%>
                        <%if $posts[i]['post_type'] eq 'Media' || $posts[i]['visibility'] eq 'Viral'%>
                            <img src="<%$posts[i]['user_profile_image']%>" alt="">
                        <%else%>
                            <%if $posts_pgtype neq 'other_profile'%>
                                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                            <%else%>
                                <img src="<%$posts[i]['user_profile_image']%>" alt="">
                            <%/if%>
                        <%/if%>
                    <%else%>
                        <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                    <%/if%>
                </div>
                <div class="comment-text comment-text-new">
                    <div class="post-add-comment add-comments">                    
                        <div class="comment-text comment-text-new" style="padding-top: 11px !important;">
                            <form style="display: flex; height: 53px">
                                <div class="form-group">
                                    <textarea class="form-control comment_post comment_post_<%$posts[i]['post_id']%>" id="comment-box9"  data-postid="<%$posts[i]['post_id']%>" rows="1" placeholder="Add Comment" data-emojiable="true"></textarea>
                                    <span class="err_msg_<%$posts[i]['post_id']%>" style="font-size: 12px; color: #4e4c4c;"></span>
                                    <input type="hidden" name="post_comment_emoji" id="post_comment_emoji">
                                </div>
                                <div class="comment-pic" style="background: none">
                                    <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<%$posts[i]['post_id']%>">GIF</span>
                                    <span style="cursor:pointer;" class="open_sticker_section" data-sticker-post-id="<%$posts[i]['post_id']%>">
                                        <img  src="<%$this->config->item('images_url')%>front/sticker.png" alt="">
                                    </span>

                                    <span style="cursor:pointer; margin-left:5px;" class="btn_post_media_attach">
                                        <i class="fa fa-paperclip btn_postmedia" data-postid="<%$posts[i]['post_id']%>" style="font-size:18px;"></i>
                                    </span>

                                    <div class="upload_media_div" id="media_div_<%$posts[i]['post_id']%>" style="display:none;">
                                        <input type="file" name="upload_file" id="input_media_<%$posts[i]['post_id']%>" style="display: none !important;"/>
                                    </div>
                                </div>
                                <!--<button type="submit" class="btn btn-primary form-btn" data-postid="<%$posts[i]['post_id']%>" title="Add Comment"><img src=""></button>-->
                                <button type="button" class="btn btn-primary form-btn btn_postcomment" style="cursor:pointer;" data-postid="<%$posts[i]['post_id']%>" title="Add Comment">
                                    <img src="<%$this->config->item('images_url')%>front/plane.png">
                                </button>
                            </form>
                            <div class="feed-comments feed_comments_<%$posts[i]['post_id']%> scrollbarContent feed-comments-main" style="display:none;">
                                <ul id="comments_list_<%$posts[i]['post_id']%>">
                                    <%include file="common/comments.tpl" comments=$posts[i]['statistics']['comments']%>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- GIF Section -->
                    <div class="main_gif_div_section gif_section_<%$posts[i]['post_id']%>">
                        <input type="text" id="searchInput_<%$posts[i]['post_id']%>" placeholder="Search for GIFs">
                        <a href="javascript:void(0);" class="close_gif_div_<%$posts[i]['post_id']%>"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                        <div class="gif_picker_div_cls" id="gifPicker_<%$posts[i]['post_id']%>"></div>
                    </div>
                </div>
                </div>
                
            </div>
    <%else%>
    <!---------changes---------->
    <%assign var=posttext_without_emoji value=$this->general->linkify($posts[i]['post_text'])%>
    <%assign var=meta_posttext_without_emoji value=$this->general->linkify($posts[i]['post_metadata']['text'])%>
        <div class="video-dash-post mb-20 feed_item" id="feed_id_<%$posts[i]['post_id']%>">
                <div class="video-dash-post-heading">
                  <div class="video-dash-post-user">
                    <div class="video-dash-post-img">
                    <a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>">
                        <%if $posts[i]['user_profile_image'] neq ''%>
                            <%if $posts[i]['post_type'] eq 'Media' || $posts[i]['visibility'] eq 'Viral'%>
                                <%if $posts_pgtype eq 'my_profile' && $posts[i]['visibility'] eq 'Viral' && $posts[i]['post_type'] eq 'Text'%>
                                    <%if isset($posts[i]['pm_upload_file']) && strpos($posts[i]['pm_upload_file'], 'res.cloudinary.com') != false%>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                    <%else%>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                    <%/if%>
                                <%else%>
                                    <%if isset($posts[i]['pm_upload_file']) && strpos($posts[i]['pm_upload_file'], 'res.cloudinary.com') != false%>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                    <%else%>
                                        <img src="<%$posts[i]['user_profile_image']%>" alt="">
                                    <%/if%>
                                
                                <%/if%>
                            <%else%>
                                <%if $posts_pgtype neq 'other_profile'%>
                                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                <%else%>
                                    <img src="<%$posts[i]['user_profile_image']%>" alt="">
                                <%/if%>
                            <%/if%>
                        <%else%>
                            <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                        <%/if%>
                    </a>
                    </div>
                    <div class="video-post-content">
                    <h5><a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>" style="color: gray;"><%$posts[i]['user_name']%></a></h5>
                      <p title="<%$posts[i]['added_date']%>">
                            <%*time_elapsed_string($posts[i]['added_date'])*%>
                            <%$this->general->getLocalDateTime($posts[i]['added_date'], "M j, Y- g:i A")%>
                      </p>
                    </div>
                  </div>
                  <div class="video-post-icon">
                    <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                        <%if $posts_pgtype eq 'my_profile' || $posts[i]['posted_user_id'] eq $this->session->userdata('iUserId')%>
                            <a class="dropdown-item edit_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://"><%$edit%></a>
                            <a class="dropdown-item delete_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://"><%$delete%></a>
                            <a class="dropdown-item" data-postid="<%$posts[i]['post_id']%>" onclick="addToPlaylist(<%$posts[i]['post_id']%>)"><%$add_to_playlist%></a>
                        <%else%>
                            <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<%$posts[i]['post_id']%>" href="javascript://"><%$spam%></a>
                            <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<%$posts[i]['post_id']%>" href="javascript://"><%$inappropriate%>?</a>
                            <a class="dropdown-item block_user" data-userid="<%$posts[i]['posted_user_id']%>" href="javascript://"><%$block%></a>
                            <a class="dropdown-item hide_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://"><%$hide_post%></a>
                            <%if $posts[i]['get_post_media'][0]['pm_media_type'] eq 'Video'%>
                                <a class="dropdown-item" data-postid="<%$posts[i]['post_id']%>" onclick="addToPlaylist(<%$posts[i]['post_id']%>)"><%$add_to_playlist%></a>
                            <%/if%>
                        <%/if%>
                    </div>
                  </div>
                </div>
                <%if $posts[i]['post_metadata']['link'] neq ''%>
                    <div class="video-post-content">
                        <p><%$this->general->displayposttext($posts[i]['post_text_emoji'])%></p><br>
                        <%if $posts[i]['post_metadata']['title'] neq ''%>
                            <p><%$posts[i]['post_metadata']['title']|nl2br%></p>
                        <%/if%>
                    </div>
                    <%assign var=post_media value=$posts[i]['get_actual_post_media']%>
                    <div class="video-post-vid">
                        <div class="video-wrapper">
                            <%if $posts[i]['get_post_media'][0]['pm_media_type'] eq 'Video'%>
                                <p class="view <%if $posts[i]['is_impressed'] eq 1%>active<%/if%> "><i class="fa-regular fa-eye"></i> &nbsp <%$posts[i]['impression_count']%></p>
                            <%/if%>
                            <%if $posts[i]['post_metadata']['image'] neq ''%>
                                <%if strpos($posts[i]['post_metadata']['link'],'http')=== false%>
                                    <%assign var='protocol' value='http://'%>
                                <%else%>
                                    <%assign var='protocol' value=''%>
                                <%/if%>
                                <div class="video-container-2" id="video-container">
                                    <img src="<%$posts[i]['post_metadata']['image']%>">
                                    <div class="play-button-wrapper">
                                        <div title="Play video" class="play-gif" id="circle-play-b">
                                        <!-- SVG Play Button -->
                                        </div>
                                    </div>
                                </div>
                            <%/if%><%*$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_metadata']['text'])*%>
                        </div>
                    </div>
                <%else%>
                    <%*$posts[i]|pr*%>
                    <%if $posts[i]['post_type'] eq 'LiveNow' AND in_array(strtolower($posts[i]['ts_archive_status']),array('started','paused')) !== false %>
                        <div class="video-post-content">                     
                            <p><%$this->general->displayposttext(removeEmoji($posttext_without_emoji))%></p><br>
                        </div>
                        <div class="video-post-vid">
                            <div class="video-wrapper">
                                <p class="view"><i class="fa-regular fa-eye"></i> 12</p>
                                    <%assign var="live_thumb_path" value=$this->config->item('live_thumb_path')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                                    <%assign var="live_thumb_url" value=$this->config->item('live_thumb_url')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                                    <%if $live_thumb_path|@file_exists%>
                                        <div class="video-container-2" id="video-container">
                                            <img src="<%$live_thumb_url%>">
                                            <div class="play-button-wrapper">
                                                <div title="Play video" class="play-gif" id="circle-play-b">
                                                <!-- SVG Play Button -->
                                                </div>
                                            </div>
                                        </div>
                                    <%/if%>
                                <%*$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_metadata']['text'])*%>
                            </div>
                        </div>
                    <%elseif ($posts[i]['post_type'] eq 'LiveNow' OR $posts[i]['post_type'] eq 'Live' ) AND in_array(strtolower($posts[i]['ts_archive_status']),array('stopped','uploaded')) !==false %>
                         <div class="video-post-content">
                            <p><%$this->general->displayposttext($posts[i]['post_text_emoji'])%></p><br>
                        </div>
                        <div class="video-post-vid">
                            <div class="video-wrapper">
                                <p class="view"><i class="fa-regular fa-eye"></i> </p>
                                    <%assign var="live_thumb_path" value=$this->config->item('live_thumb_path')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                                    <%assign var="live_thumb_url" value=$this->config->item('live_thumb_url')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                                <%if $live_thumb_path|@file_exists%>
                                    <%*$this->general->get_archive_video($posts[i]['ts_archive_id'])*%>
                                    <%if $this->general->get_archive_video($posts[i]['ts_archive_id']) !==false %>
                                        <div class="video-container-2" id="video-container">
                                            <%*<video controls="" id="video" preload="metadata" width="100%" height="100%" poster="<%$live_thumb_url%>">
                                                <source src="<%$posts[i]['live_video_url']%>" type="video/mp4">
                                            </video>*%>
                                            <%assign var="video_filename" value=pathinfo($posts[i]['live_video_url'], PATHINFO_FILENAME)%>
                                            <%assign var="video_extension" value=pathinfo($posts[i]['live_video_url'], PATHINFO_EXTENSION)%>
                                            
                                            <%if strpos($posts[i]['live_video_url'], 'res.cloudinary.com') !== false%>

                                                <video
                                                    muted
                                                    data-cld-public-id="<%$video_filename%>"
                                                    class="cld-video-player cld-video-player-skin-light"
                                                    data-cld-autoplay-mode="on-scroll" st>
                                                </video>

                                            <%else%>

                                                <video controls="" id="video" preload="metadata" width="100%" height="100%" poster="<%$live_thumb_url%>">
                                                    <source src="<%$posts[i]['live_video_url']%>" type="video/mp4">
                                                </video>

                                            <%/if%>

                                            <%*$this->general->get_archive_video($posts[i]['ts_archive_id'])*%>
                                            <div class="play-button-wrapper">
                                                <div title="Play video" class="play-gif" id="circle-play-b">
                                                <!-- SVG Play Button -->
                                                </div>
                                            </div>
                                        </div>
                                    <%/if%>
                                <%/if%>
                            </div>
                        </div>
                    <%else%>
                        <div class="video-post-content">
                                <p ><%$this->general->displayposttext(removeEmoji($posttext_without_emoji))%></p> 
                        </div>
                        <div class="video-post-vid">
                            <%if $posts[i]['post_type'] eq 'Media'%> 
                                <%if $posts[i]['post_type'] eq 'Media' or $posts[i]['post_type'] eq 'Live'%>
                                    <%assign var=post_media value=$posts[i]['get_post_media']%>
                                    <%if $posts[i]['get_post_media'][0]['pm_media_type'] eq 'Video'%>
                                    <div class="video-wrapper">
                                        <p class="view <%if $posts[i]['is_impressed'] eq 1%>active<%/if%> "><i class="fa-regular fa-eye"></i> &nbsp <%$posts[i]['impression_count']%></p>
                                    </div>
                                    <%/if%>
                                        <div class=" owl-carousel owl-theme media-slider carousel<%$posts[i]['post_id']%>" style="display: block !important;">
                                            <%*$this->general->get_archive_video($posts[i]['ts_archive_id'])*%>
                                            
                                            <%section name=j loop=$post_media%>
                                                <div class="video-container-2" id="video-container" data-getmediaid="<%$post_media[j]['pm_post_media_id']%>" data-getpostid="<%$post_media[j]['post_id']%>">
                                                    <%if $post_media[j]['pm_media_type'] eq 'Image'%>
                                                        <%if $post_media[j]['upload_file_orgh'] neq ''%>
                                                            <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>"><img src="<%$post_media[j]['upload_file_org']%>" alt=""></a>
                                                        <%else%>
                                                            <img src="<%$post_media[j]['display_image']%>" alt="">
                                                        <%/if%>
                                                    <%elseif $post_media[j]['pm_media_type'] eq 'Video'%>

                                                        <%if $is_detail eq "Yes"%>
                                                            <%assign var="video_url" value=$post_media[j]['upload_file']%>
                                                        <%else%>
                                                            <%assign var="video_url" value=$post_media[j]['pm_upload_file']%>
                                                        <%/if%>

                                                        <%assign var="video_filename" value=pathinfo($video_url, PATHINFO_FILENAME)%>
                                                        <%assign var="video_extension" value=pathinfo($video_url, PATHINFO_EXTENSION)%>

                                                        <!--<%*<video id="plyr-video" class="playerembed" width="100%" height="100%" preload="metadata" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>" muted>
                                                            <%assign var="video_url" value=$post_media[j]['pm_upload_file']%>
                                                            <%if $is_detail eq "Yes"%>
                                                                <%assign var="video_url" value=$post_media[j]['upload_file']%>
                                                            <%/if%>
                                                            <source src="<%$video_url%>" type="video/mp4">
                                                        </video>*%>-->

                                                        <%if strpos($video_url, 'res.cloudinary.com') !== false%>
                                                        
                                                            <video
                                                                muted
                                                                data-cld-public-id="<%$video_filename%>"
                                                                class="cld-video-player cld-video-player-skin-light"
                                                                data-cld-autoplay-mode="on-scroll">
                                                            </video>

                                                        <%else%>

                                                            <video class="plyr-video playerembed video-btns" width="100%" height="100%" preload="metadata" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>" muted>
                                                                <source src="<%$video_url%>" type="video/mp4">
                                                            </video>

                                                            <!-- The button will be displayed when the video ends -->
                                                            <div class="video-btn-overlay">
                                                                <button class="refresh-btn">
                                                                    <div style="margin-right: 100px;" class="btn_options">
                                                                    <%if $posts_pgtype eq 'my_profile' || $posts_pgtype eq 'other_profile'%>
                                                                        <a data-id="<%$posts[i]['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>?pageType=Profile&userId=<%$post_media[0]['pm_user_id']%>">
                                                                    <%else%>
                                                                        <a data-id="<%$posts[i]['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>">
                                                                    <%/if%>
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

                                                        <%/if%>

                                                    <%/if%>
                                                </div>
                                            <%/section%>
                                        </div>
                                <%/if%>
                            <%/if%> 

                            <!--<%if $posts[i]['post_type'] eq 'Music'%>
                                <%assign var=music value=$posts[i]['music_track']%>
                                <div class="video-container-2 owl-carousel owl-theme media-slider media_slider" data-getmediaid="<%$music['pm_post_media_id']%>" data-getpostid="<%$music['pm_post_id']%>" id="video-container" style="display: block !important;">
                                    <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>"><img src="<%$music['thumbnail_url']%>" alt=""></a>
                                    
                                    <div class="play-button-wrapper">
                                        <div title="Play video" class="play-gif" id="circle-play-b">
                                        </div>
                                    </div>
                                </div>
                            <%/if%> -->

                            <%if $posts[i]['post_type'] eq 'Music'%>
                                <%assign var=music value=$posts[i]['music_track']%>

                                <div class="video-container-2 owl-carousel owl-theme media-slider media_slider"
                                    style="display:block !important;">

                                    <div class="item" style="position:relative; cursor:pointer;" onclick="playMusic(this)">
                                        
                                        <img src="<%$music['thumbnail_url']%>" alt="music-thumbnail">

                                        <!-- Hidden Audio -->
                                        <audio class="music-audio" preload="none">
                                            <source src="<%$music['audio_url']%>" type="audio/mpeg">
                                        </audio>

                                        <div class="play-button-wrapper">
                                            <div class="play-gif">
                                                <svg class="icon-play" viewBox="0 0 24 24" width="28" height="28">
                                                    <path fill="white" d="M8 5v14l11-7z"/>
                                                </svg>

                                                <svg class="icon-pause" viewBox="0 0 24 24" width="28" height="28">
                                                    <path fill="white" d="M6 5h4v14H6zm8 0h4v14h-4z"/>
                                                </svg>
                                            </div>
                                        </div>


                                    </div>

                                </div>
                            <%/if%>


                        </div>
                    <%/if%>
                <%/if%>
                <div class="video-share-box-wrapper">
                  <div class="video-share-box" id="feed_action_<%$posts[i]['post_id']%>" >
                    <ul>
                        <%include file="common/feed_actions.tpl"%>
                    </ul>
                  </div>
                  <div class="video-photo">
                    <a href="#">
                      <i class="fa-regular fa-images"></i>
                    </a>
                        <%if $posts[i]['visibility'] eq 'Viral'%>
                            <div class="my-progress-bar" data-value="<%time_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%>" data-thickness="4">
                                <span style="color: gray;"><%hours_left($posts[i]['added_date'],$posts[i]['expire_date'])%></span>
                            </div>
                        <%/if%>
                  </div>
                </div>
                <div class="comment">
                    <div class="cmnt-pic">
                        <!--<img src="<%$posts[i]['user_profile_image']%>" alt="">-->
                        <%if $posts[i]['user_profile_image'] neq ''%>
                            <%if $posts[i]['post_type'] eq 'Media' || $posts[i]['visibility'] eq 'Viral'%>
                                <%if $posts_pgtype eq 'my_profile' && $posts[i]['visibility'] eq 'Viral' && $posts[i]['post_type'] eq 'Text'%>
                                    <%if isset($posts[i]['pm_upload_file']) && strpos($posts[i]['pm_upload_file'], 'res.cloudinary.com') != false%>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                    <%else%>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                    <%/if%>
                                <%else%>
                                    <%if isset($posts[i]['pm_upload_file']) && strpos($posts[i]['pm_upload_file'], 'res.cloudinary.com') != false%>
                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                    <%else%>
                                        <img src="<%$posts[i]['user_profile_image']%>" alt="">
                                    <%/if%> 
                                <%/if%>
                            <%else%>
                                <%if $posts_pgtype neq 'other_profile'%>
                                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$posts[i]['user_profile_image']%>" alt="">
                                <%else%>
                                    <img src="<%$posts[i]['user_profile_image']%>" alt="">
                                <%/if%>
                            <%/if%>
                        <%else%>
                            <img src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture">
                        <%/if%>
                    </div>  
                    <div class="post-add-comment add-comments">                    
                        <div class="comment-text comment-text-new"style="padding-top: 11px !important;">
                            <form style="display: flex; height: 53px">
                                <div class="form-group">
                                <textarea class="form-control comment_post_<%$posts[i]['post_id']%>" 
                                    id="comment-box<%$posts[i]['post_id']%>"
                                    aria-describedby="emailHelp" 
                                    data-postid="<%$posts[i]['post_id']%>" 
                                    rows="1" 
                                    placeholder="Add Comment" 
                                    data-emojiable="true" 
                                    style="color:gray" 
                                    oninput="handleGif_another('<%$posts[i]['post_id']%>')"
                                    onchange="handleGif_another('<%$posts[i]['post_id']%>')"
                                    onkeydown="return handleCommentKeyDown(event, '<%$posts[i]['post_id']%>')">
                                </textarea>


                                    <span class="err_msg_<%$posts[i]['post_id']%>" style="font-size: 12px; color: #4e4c4c;" onkeydown="return handleCommentKeyDown(event, '<%$posts[i]['post_id']%>')"></span>
                                </div>
                                <div class="upload_media_div" id="media_div_<%$posts[i]['post_id']%>" style="display: none;">
                                    <input type="file" name="upload_file" id="input_media_<%$posts[i]['post_id']%>" style="display: none !important;">
                                </div>
                                <div class="comment-pic" style="background: none">
                                    <span style="cursor: pointer" class="btn_post_media_attach">
                                        <i class="fa fa-paperclip btn_postmedia" data-postid="<%$posts[i]['post_id']%>" style="font-size: 16px !important"></i>
                                    </span>
                                    <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<%$posts[i]['post_id']%>">GIF</span>
                                    <span style="cursor:pointer; " class="open_sticker_section" data-sticker-post-id="<%$posts[i]['post_id']%>">
                                        <img  src="<%$this->config->item('images_url')%>front/sticker.png" alt="">
                                    </span>

                                    <div class="upload_media_div" id="media_div_<%$posts[i]['post_id']%>">
                                        <input type="file" name="upload_file" id="input_media_<%$posts[i]['post_id']%>" style="display: none !important;" />
                                    </div>
                                </div>
                                <input type="hidden" name="post_comment_emoji" id="post_comment_emoji">
                               <button type="button" class="btn btn-primary form-btn btn_postcomment" style="cursor:pointer;" data-postid="<%$posts[i]['post_id']%>" title="Add Comment"><img src="<%$this->config->item('images_url')%>front/plane.png"></button>
                            </form><br>
                            <div class="feed-comments feed_comments_<%$posts[i]['post_id']%> scrollbarContent feed-comments-main" style="display:none;">
                                <ul id="comments_list_<%$posts[i]['post_id']%>">
                                    <%include file="common/comments.tpl" comments=$posts[i]['statistics']['comments']%>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- GIF Section -->
                       <div class="main_gif_div_section gif_section_<%$posts[i]['post_id']%>" style="display: none;">
                            <input type="text" id="searchInput_<%$posts[i]['post_id']%>" placeholder="Search for Stickers">
                            <a href="javascript:void(0);" class="close_gif_div_<%$posts[i]['post_id']%>" >
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </a>
                            <div class="gif_picker_div_cls" id="gifPicker_<%$posts[i]['post_id']%>">
                            </div>    
                        </div>
                  </div>
                </div>
    <%/if%>
    <%if $count % 3 == 0 %>
    <div class="banner-add" style="display: flex;">
        <div class="first-banner-add">
            <script type="text/javascript">
                atOptions = {
                    'key' : '2fd09803d5d988416c78942dc800028d',
                    'format' : 'iframe',
                    'height' : 500,
                    'width' : 300,
                    'params' : {}
                };
            </script>
            <script type="text/javascript" src="//www.topcreativeformat.com/2fd09803d5d988416c78942dc800028d/invoke.js"></script>
        </div>
        <div class="second-banner-add">
            <script type="text/javascript">
                atOptions = {
                    'key' : '2fd09803d5d988416c78942dc800028d',
                    'format' : 'iframe',
                    'height' : 500,
                    'width' : 300,
                    'params' : {}
                };
            </script>
            <script type="text/javascript" src="//www.topcreativeformat.com/2fd09803d5d988416c78942dc800028d/invoke.js"></script>
        </div>
    </div>
    <%/if%>
    <p style="display: none"><%$count++%></p>
<%sectionelse%>
    <p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;"><%$no_post_available%></p>
<%/section%>


<div class="modal fade cmn-modal create-post-modal" id="reportPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Report Post</h5>
            </div>
            <form class="cmn-form" id="form_report" method='post'>
                <input type="hidden" name="report_post_id" id="report_post_id" value=""/>
                <div class="modal-body">
                    <div class="form-group input-group col-4">
                        <select class="form-control" id="eReprtType" name="eReprtType">
                            <option value="Spam">Spam</option>
                            <option value="InAppropriate">In Appropriate</option>
                        </select>
                    </div>
                    <div class="upload-text">
                        <textarea name="report_notes" id="report_notes" class="form-control" rows="5" placeholder="Notes (optional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_report_post" class="btn btn-primary" style="background: #8E65A1">Report</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade cmn-modal create-post-modal" id="sharePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Share This Post</h5>
            </div>
            <form id="form_share" method='post'>
                <input type="hidden" name="share_post_id" id="share_post_id" value=""/>
                <div class="modal-body">
                    <div class="upload-text">
                        <i class="cmn-user-img">
                            <img src="<%$userinfo.u_profile_image%>" alt="">
                        </i>
                        <textarea name="share_post_text" id="share_post_text" class="form-control" rows="5" placeholder="What’s on your mind?"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="share_timeline" class="btn btn-primary" style="background: #8E65A1;">Share on My Timeline</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Playlist Modal --> 

<div class="modal fade cmn-modal" id="playlistModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="max-width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center modal-header-common" id="exampleModalLabel"></h5>
            </div>
            <div class="modal-body">
                <div class="notifications-list scrollbarContent">
                    <ul id="notifications_list_container">
                        <ul>
                            <section class="video-sec">
                                <div class="container">
                                    <div class="row mb-40">
                                        <div class="col-md-12">
                                            <div class="video-grid" style="grid-template-columns: repeat(4, 1fr) !important ;">
                                                <%foreach item=row from=$posts%>
                                                <%if !empty($row['get_post_media']) && $row['post_type'] eq 'Media' && $row['get_post_media'][0]['pm_media_type'] eq 'Video'%>
                                                    <%assign var=post_media value=$row['get_post_media']%>
                                                    <div class="video-item">
                                                        <div class="video-box">
                                                            <div class="video-img-box">
                                                                <a href="<%$this->general->setdiplayprofileurl($row['u_users_id'], $row['u_name'])%>">
                                                                <%if $post_media[0]['pm_media_type'] eq 'Video'%>
                                                                    <!--<%if $post_media[0]['pm_vSourceType'] eq 'aws'%>
                                                                        <video controls="" id="plyr-video" class="playerembed" preload="metadata" width="100%" height="100%" data-poster="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$post_media[0]['pm_user_id']%>/<%$post_media[0]['pm_video_thumbnail_org']%>" controlsList="nodownload" muted>
                                                                            <source src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$post_media[0]['pm_user_id']%>/<%$post_media[0]['pm_upload_file']%>" type="video/mp4">
                                                                        </video>
                                                                    <%elseif $post_media[0]['pm_vSourceType'] eq 'cld'%>
                                                                        <video controls="" id="plyr-video" class="playerembed" preload="metadata" width="100%" height="100%" data-poster="<%$post_media[0]['pm_vCloudinary']%>" controlsList="nodownload" muted>
                                                                            <source src="<%$post_media[0]['pm_vCloudinary']%>" type="video/mp4">
                                                                        </video>
                                                                    <%/if%>-->
                                                                    <video controls="" id="plyr-video" preload="metadata" width="100%" height="100%" data-poster="<%$post_media[0]['pm_video_thumbnail']%>" controlsList="nodownload" muted style="min-height: 12rem; object-fit:cover;">
                                                                        <source src="<%$post_media[0]['upload_file_org']%>" type="video/mp4">
                                                                    </video>
                                                                <%/if%>
                                                                </a>
                                                            </div>
                                                            <div class="video-content">
                                                                <div class="video-heading">
                                                                <%assign var=posted_text_withouemoji value=removeEmoji($row['post_text_emoji'])%>
                                                                <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,20)%>
                                                                    <h3><%$posted_text%></h3>
                                                                    <a href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                                </div>
                                                                <div class="follow-button">    
                                                                    <a href="#" class="btn btn-primary act_followuser" onclick="addToPlaylist(<%$row['post_id']%>)" style="background-color: #e8790a; border-color:#e8790a;">Add To Playlist</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <%elseif !empty($row['get_actual_post']) && $row['get_actual_post']['p_post_type'] eq 'Media'%>
                                                    <%assign var=post_media value=$row['get_actual_post_media']%>
                                                    <div class="video-item">
                                                        <div class="video-box">
                                                            <div class="video-img-box" >
                                                                <a href="<%$this->general->setdiplayprofileurl($row['u_users_id'], $row['u_name'])%>">
                                                                <%if $post_media[0]['pm_media_type'] eq 'Image'%>
                                                                    <img class="search-image" src="<%$post_media[0]['upload_file_org']%>" alt="" style="min-height: 12rem; object-fit:cover;">
                                                                <%elseif $post_media[0]['pm_media_type'] eq 'Video'%>
                                                                    <%if $post_media[0]['pm_vSourceType'] eq 'aws'%>
                                                                        <img class="search-image" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$post_media[0]['pm_user_id']%>/<%$post_media[0]['pm_video_thumbnail_org']%>" alt="" style="min-height: 12rem; object-fit:cover;">
                                                                    <%elseif $post_media[0]['pm_vSourceType'] eq 'cld'%>
                                                                        <video controls="" id="plyr-video" preload="metadata" width="100%" height="100%" data-poster="<%$post_media[0]['pm_vCloudinary']%>" controlsList="nodownload" muted style="min-height: 12rem; object-fit:cover;">
                                                                            <source src="<%$post_media[0]['pm_vCloudinary']%>" type="video/mp4">
                                                                        </video>
                                                                    <%/if%>
                                                                <%/if%>
                                                                </a>
                                                            </div>
                                                            <div class="video-content">
                                                                <div class="video-heading"> 
                                                                    <%assign var=posted_text_withouemoji value=removeEmoji($row['get_actual_post'].p_post_text)%>
                                                                    <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,10)%>
                                                                    <h3><%$posted_text%></h3>
                                                                    <!--<a href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>-->
                                                                </div>
                                                                <div class="follow-button">    
                                                                    <a href="#" class="btn btn-primary" onclick="addToPlaylist(<%$row['get_actual_post']['p_post_id']%>)" style="background-color: #e8790a; border-color:#e8790a;">Add To Playlist</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <%/if%>
                                                <%/foreach%>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
let playlistLoaderInitialized = false;

      window.onload = function () {
            if (playlistLoaderInitialized) return;
            playlistLoaderInitialized = true;

            let pageIndex = 2;
            let globalIndex = $('#playlist-wrapper .swiper-slide').length; // count existing slides
            let swiperInstance = new Swiper('.swiper-container.top-playlist', {
            slidesPerView: 3,
            spaceBetween: 10,
            navigation: {
                  nextEl: '.swiper-button-next',
                  prevEl: '.swiper-button-prev',
            },
            pagination: {
                  el: '.swiper-pagination',
                  clickable: true,
            },
            autoplay: {
                  delay: 3000,
                  disableOnInteraction: false, 
            },
            loop: false,
            });

            const intervalId = setInterval(() => {
                  $.ajax({
                        url: '/getMorePlaylist',
                        method: 'POST',
                        contentType: 'application/x-www-form-urlencoded',
                        dataType: 'json',
                        data: { pageIndex: pageIndex },
                        success: function (data) {
                        if (!data || !Array.isArray(data) || data.length === 0) {
                              clearInterval(intervalId);
                              return;
                        }

                        const newSlides = [];

                        for (let i = 0; i < data.length; i++) {
                              const post = data[i];
                              const media = post.main_media?.[0] || {};
                              const thumbnail = media.full_thumbnail_url || '';
                              const videoSrc = media.vUploadFile || '';
                              const profileImage = media.u_profile_image || '';
                              const userName = media.u_name || '';

                              const postHtml = `
                                    <div class="swiper-slide item" style="margin-right: 0px !important;" role="group" aria-label="${globalIndex + 1} / 800">
                                    <div class="tp-playlist-media" style="height: 29rem;">
                                    <a href="content/content/playlistshare?playlistId=${post.playlist_id}&userId=${post.playlist_userId}">
                                          <video width="100%" height="100%" preload="auto" poster="${thumbnail}" style="object-fit: cover;" muted ${thumbnail ? '' : `><source src="${videoSrc}" type="video/mp4">`} </video>
                                    </a>
                                    </div>
                                    <div class="tp-user-image">
                                    <img src="${profileImage}">
                                    <h6 class="top-usename">${userName}</h6>
                                    </div>
                                    </div>`;

                              newSlides.push(postHtml);
                              globalIndex++;
                        }

                        // Append new slides using Swiper API
                        swiperInstance.appendSlide(newSlides);
                        swiperInstance.update();

                        if (!swiperInstance.autoplay.running) {
                              swiperInstance.autoplay.start();
                        }

                              pageIndex++;
                        },
                        error: function (xhr, status, error) {
                              console.error('AJAX error:', error);
                              clearInterval(intervalId);
                        }
                  });
            }, 5000);
      };
</script>


<!-- Swiper CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>

function playMusic(container) {
    let audio = container.querySelector(".music-audio");
    let button = container.querySelector(".play-gif");

    document.querySelectorAll(".music-audio").forEach(function(a){
        if(a !== audio){
            a.pause();
            a.currentTime = 0;
            let parent = a.closest('.item');
            if(parent){
                parent.querySelector('.play-gif').classList.remove('pause');
            }
        }
    });

    if (audio.paused) {
        audio.play();
        button.classList.add("pause");
    } else {
        audio.pause();
        button.classList.remove("pause");
    }

    audio.onended = function() {
        button.classList.remove("pause");
    };
}



function handleGif_another(postId) {
      console.log('hoice vai' , postId);
      
    var textarea = document.getElementById("comment-box" + postId);
    var mainGifDiv = document.querySelector(".comment_post_" + postId);
    
    console.log("Main GIF Div:", mainGifDiv);
    
    if (textarea) {
        const gifLink = textarea.value.trim();

        if (/^https:\/\/media\d*\.giphy\.com\/media/.test(gifLink)) {
            console.log("GIF URL detected:", gifLink);

            textarea.value = "";  
            textarea.dispatchEvent(new Event("input"));
            $(".comment_post_" +  postId).html("");


            if (typeof jQuery !== "undefined") {
                $(textarea).val("").trigger("change").trigger("input"); 
            }

            $.ajax({
                url: "/add_comment",
                type: "POST",
                data: { comment_post_id: postId, comment: gifLink },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        console.log("GIF URL submitted successfully:", response.data);
                    } else {
                        console.error("Error submitting GIF:", response.message);
                    }
                    $("#comment_dots_" + postId).trigger("click");

                    // Ensure textarea remains empty
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
    
}

document.querySelectorAll(".gif_picker_div_cls").forEach(gifContainer => {
    gifContainer.addEventListener("click", function (event) {
        let selectedGif = event.target.closest("img"); 
        if (!selectedGif) return;

        let gifUrl = selectedGif.src;
        let postId = this.id.replace("gifPicker_", "");

        let textarea = document.getElementById(`comment-box${postId}`);
        if (textarea) {
            textarea.value = gifUrl;
            textarea.dispatchEvent(new Event("input"));
            
            setTimeout(() => {
                handleGif_another(postId);
            }, 50);
        }

        let gifSection = document.querySelector(`.gif_section_${postId}`);
        if (gifSection) gifSection.style.display = "none";
    });
});


// function submitComment(postId) {
//     let form = document.querySelector(`#comment-box${postId}`).closest("form");

//     if (form) {
//         console.log("Submitting comment...");
//         form.submit();
//     }
// }
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


    // document.addEventListener('DOMContentLoaded', () => {
    //     const videos = document.querySelectorAll('#plyr-video');

    //     videos.forEach(video => {
    //         video.addEventListener('mouseenter', () => {
    //         video.play();
    //         });

    //         video.addEventListener('mouseleave', () => {
    //         video.pause();
    //         video.currentTime = 0;
    //         });
    //     });
    // });


    $(document).ready(function() {
        
    const videoElements = document.querySelectorAll('.video-container-2 video');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.play();
        } else {
            entry.target.pause();
        }
        });
    });

  videoElements.forEach(video => observer.observe(video));

  // Method 2: jQuery scroll event (alternative approach)
  /*
  var offsetRange = $(window).height() / 3,
      offsetTop = $(window).scrollTop() + offsetRange + $("#header").outerHeight(true),
      offsetBottom = offsetTop + offsetRange;

  $(window).scroll(function(e) {
    $(".video").each(function () { 
      var y1 = $(this).offset().top;
      var y2 = offsetTop;
      if (y1 + $(this).outerHeight(true) < y2 || y1 > offsetBottom) {
        this.pause(); 
      } else {
        this.play();
      }
    });
  });
  */
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
    console.log('Script loaded');

    function handleCommentKeyDown(event, postId) {
        console.log('Function called');
        console.log('Key pressed:', event.key);
        console.log('Post ID:', postId);

        if (event.key === 'Enter' && !event.shiftKey) {
            console.log('Enter key pressed without Shift');
            event.preventDefault();
            
            const submitButton = document.querySelector(`.btn_postcomment[data-postid="${postId}"]`);
            
            if (submitButton) {
                console.log('Submit button found, clicking...');
                submitButton.click();
            } else {
                console.log('Submit button not found');
            }
            
            return false;
        }
        return true;
    }

    // Use event delegation
    document.addEventListener('keydown', function(event) {
        const target = event.target;
        if (target.matches('div[class*="comment_post_"]')) {
            const postId = target.className.match(/comment_post_(\d+)/)[1];
            handleCommentKeyDown(event, postId);
        }
    });

    console.log('Event delegation set up');
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.top-playlist', {
        loop: true,
        slidesPerView: 3,   // Number of slides visible at once
        spaceBetween: 10,   // Space between slides in pixels
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        // pagination: {
        //     el: '.swiper-pagination',
        //     clickable: true,
        // },
        // navigation: {
        //     nextEl: '.swiper-button-next',
        //     prevEl: '.swiper-button-prev',
        // },
    });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Select both class and id-based videos
    var videos = document.querySelectorAll(".plyr-video, #plyr-video");
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
document.addEventListener('DOMContentLoaded', function() {
    function handleEmojiClick(event, postId) {
        const emoji = event.target.textContent;
        const commentBox = document.getElementById(`comment-box${postId}`);
        if (commentBox) {
            commentBox.value += emoji;
            const submitButton = document.querySelector(`.btn_postcomment[data-postid="${postId}"]`);
            if (submitButton) {
                submitButton.click();
            }
        }
    }

    const emojiElements = document.querySelectorAll('[data-emojiable="true"]');
    emojiElements.forEach(function(emojiElement) {
        emojiElement.addEventListener('click', function(event) {
            const postId = emojiElement.getAttribute('data-postid');
            handleEmojiClick(event, postId);
        });
    });
});
</script>

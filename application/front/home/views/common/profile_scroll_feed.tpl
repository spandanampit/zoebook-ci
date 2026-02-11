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
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    justify-content: center;
    align-items: center;
    z-index: 10;
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

.single-item {
    display: block; /* Ensures a single item is displayed even without carousel */
}

.owl-nav {
    display: none;
}
.blockUI.blockMsg.blockElement{
    display: none !important;
}

</style>

<%section name=i loop=$posts%>
    <%if $posts[i]['post_type'] eq 'Share'%>
        <%assign var=posttext_without_emoji value=$this->general->linkify($posts[i]['post_text_emoji'])%>
        <%assign var=meta_posttext_without_emoji value=$this->general->linkify($posts[i]['post_metadata']['text'])%>
        <div class="video-dash-post mb-20 feed_item" id="feed_id_<%$posts[i]['post_id']%>">
            <div class="video-dash-post-heading">
                <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <!--<%$posts_pgtype%>-->
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
                    <p class="displayemoji_comment"><!-- <%$posts[i]['post_metadata']['text']|nl2br%> -->
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
            <%if $posts[i][post_type] neq 'Text'%>
                <div class="video-post-vid">
                    <div class="video-wrapper">
                    <p class="view <%if $posts[i]['is_impressed'] eq 1%>active<%/if%>"><i class="fa-regular fa-eye"></i> &nbsp <%$posts[i]['impression_count']%> </p>
                    <%if $posts[i]['get_actual_post']['p_post_type'] eq 'Media' or $posts[i]['get_actual_post']['p_post_type'] eq 'Live'%>
                        <%assign var=post_media value=$posts[i]['get_actual_post_media']%>
                        <%section name=j loop=$post_media%>

                        
                            <div class="video-container-2 owl-carousel owl-theme media-slider media_slider" data-getmediaid="<%$post_media[j]['pm_post_media_id']%>" data-getpostid="<%$post_media[j]['pm_post_id']%>" id="video-container" style="display: block;">
                                <%if $post_media[j]['pm_media_type'] eq 'Image'%>
                                    <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>"><img src="<%$post_media[j]['upload_file_org']%>" alt=""></a>
                                <%elseif $post_media[j]['pm_media_type'] eq 'Video'%>
                                    <%if $post_media[j]['pm_vSourceType'] eq 'aws'%>
                                        <video controls="" id="plyr-video plyr-video-<%$post_media[j]['pm_post_media_id']%>" class="playerembed autoplay-video plyr-video" preload="metadata" width="100%" height="100%" controls data-poster="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$post_media[j]['pm_user_id']%>/<%$post_media[j]['pm_video_thumbnail_org']%>" controlsList="nodownload" muted >
                                            <source src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$post_media[j]['pm_user_id']%>/<%$post_media[j]['pm_upload_file']%>" type="video/mp4">
                                        </video>
                                    <%elseif $post_media[j]['pm_vSourceType'] eq 'cld'%>
                                        <video controls="" id="plyr-video plyr-video-<%$post_media[j]['pm_post_media_id']%>" class="playerembed autoplay-video plyr-video" preload="metadata" width="100%" height="100%" controls data-poster="<%$post_media[j]['pm_vCloudinary']%>" controlsList="nodownload" muted>
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
                                            <p class="btn_name text-white">See More In Video</p>
                                        </a>
                                    </div>
                                    <div class="btn_options replay-btn">
                                        <i class="fa fa-refresh"></i>
                                        <p class="btn_name">Replay</p>
                                    </div>
                                </button>
                            </div>
                        <%/section%>
                    <%/if%>
                    </div>
                </div>
            <%/if%>
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
    <%assign var=posttext_without_emoji value=$this->general->linkify($posts[i]['post_text_emoji'])%>
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
                            <a class="dropdown-item edit_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Edit</a>
                            <a class="dropdown-item delete_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Delete</a>
                            <a class="dropdown-item" data-postid="<%$posts[i]['post_id']%>" onclick="addToPlaylist(<%$posts[i]['post_id']%>)">Add To Playlist</a>
                        <%else%>
                            <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Spam</a>
                            <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Inappropriate ?</a>
                            <a class="dropdown-item block_user" data-userid="<%$posts[i]['posted_user_id']%>" href="javascript://">Block</a>
                            <a class="dropdown-item hide_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Hide Post</a>
                            <%if $posts[i]['get_post_media'][0]['pm_media_type'] eq 'Video'%>
                                <a class="dropdown-item" data-postid="<%$posts[i]['post_id']%>" onclick="addToPlaylist(<%$posts[i]['post_id']%>)">Add To Playlist</a>
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
                                        <div class=" owl-carousel owl-theme media-slider media_slider carousel<%$posts[i]['post_id']%>" style="display: block;">
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

                                                        <%assign var="video_url" value=$post_media[j]['pm_upload_file']%>
                                                        <%if $is_detail eq "Yes"%>
                                                            <%assign var="video_url" value=$post_media[j]['upload_file']%>
                                                        <%/if%>

                                                        <%assign var="video_filename" value=pathinfo($video_url, PATHINFO_FILENAME)%>
                                                        <%assign var="video_extension" value=pathinfo($video_url, PATHINFO_EXTENSION)%>

                                                        <%*<video id="plyr-video" class="playerembed" width="100%" height="100%" preload="metadata" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>" muted>
                                                            <%assign var="video_url" value=$post_media[j]['pm_upload_file']%>
                                                            <%if $is_detail eq "Yes"%>
                                                                <%assign var="video_url" value=$post_media[j]['upload_file']%>
                                                            <%/if%>
                                                            <source src="<%$video_url%>" type="video/mp4">
                                                        </video>*%>

                                                        <%if strpos($video_url, 'res.cloudinary.com') !== false%>

                                                            <video width="640" height="360" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>" id="plyr-video">
                                                                <source src="<%$video_url%>" type="video/mp4">
                                                                <source src="movie.webm" type="video/webm">
                                                            </video>

                                                        <%else%>

                                                            <video class="plyr-video playerembed video-btns" id="plyr-video" width="100%" height="100%" preload="metadata" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>" muted>
                                                                <source src="<%$video_url%>" type="video/mp4">
                                                            </video>

                                                            <!-- The button will be displayed when the video ends -->
                                                            <div class="video-btn-overlay" style="display: none;">
                                                                <button class="refresh-btn">
                                                                    <div style="margin-right: 100px;" class="btn_options">
                                                                        <%if $posts_pgtype eq 'my_profile' || $posts_pgtype eq 'other_profile'%>
                                                                            <a data-id="<%$posts[i]['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>?pageType=Profile&userId=<%$post_media[0]['pm_user_id']%>">
                                                                        <%else%>
                                                                            <a data-id="<%$posts[i]['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>">
                                                                        <%/if%>
                                                                                <i class="fa fa-toggle-right text-white"></i>
                                                                                <p class="btn_name text-white">See More In Video</p>
                                                                            </a>
                                                                        </div>
                                                                    <div class="btn_options replay-btn">
                                                                        <i class="fa fa-refresh"></i>
                                                                        <p class="btn_name">Replay</p>
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
                            <div class="feed-comments feed_comments_<%$posts[i]['post_id']%> scrollbarContent feed-comments-main" style="display:none">
                                <ul id="comments_list_<%$posts[i]['post_id']%>">                                
                                    <%include file="common/comments.tpl" comments=$posts[i]['statistics']['comments']['data']%>
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
                                <img src="https://media1.giphy.com/media/9ywJxa5PASF6HBUSh7/giphy-downsized-medium.gif?cid=ca8ff4c416a6m7a5omqz1thbb97qwfygjzj2z51qo93v43oa&ep=v1_stickers_search&rid=giphy-downsized-medium.gif&ct=s" alt="">
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
    <p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;">No posts available</p>
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

<div class="modal fade cmn-modal create-post-modal" id="editPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Edit Post</h5>
            </div>
            <form id="form_edit_post" method='post' enctype="multipart/form-data">
                <input type="hidden" name="edit_post_id" id="edit_post_id" value="" />
                <input type="hidden" name="edit_post_detailpage" id="edit_post_detailpage" value="" />
                <div class="modal-body">
                    <div class="upload-text">
                        <i class="cmn-user-img">
                            <img src="<%$userinfo.u_profile_image%>" alt="">
                        </i>
                        <!--<textarea name="edit_post_text" id="edit_post_text" class="form-control" rows="5" placeholder="What’s on your mind?"></textarea>-->
                        <p class="lead emoji-picker-container w-100 emoji_postinfo">
                          <textarea name="edit_post_text" id="edit_post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true"></textarea>
                          <input type="hidden" name="post_text_emoji" id="post_text_emoji">
                        </p>
                    </div>
                    <div class="multiple-photo preview_media"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="upload-photos">
                        <div class="upload-img-vod">
                            <input type='file' style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".png, .jpg, .jpeg" />
                            <label for="upload_file">
                                <i class="fas fa-camera"></i> Photo/Video
                            </label>                        
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="edit_visibility_Public" checked value="Public" />
                            <label for="edit_visibility_Public"> <i class="fas fa-eye"></i> Public</label>
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="edit_visibility_Private" value="Private" />
                            <label for="edit_visibility_Private"> <i class="fas fa-eye-slash"></i> Private</label>
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="edit_visibility_Viral" value="Viral" />
                            <label for="edit_visibility_Viral"> <i class="fas fa-eye-slash"></i> Viral</label>
                        </div>
                    </div>
                    <button type="button" id="submit_edit_post" class="btn btn-primary">Update</button>
                </div>
            </form>            
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js"></script>


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
function waitForOwlCarousel(callback) {
    if (typeof $.fn.owlCarousel !== 'undefined') {
        callback();
    } else {
        setTimeout(function() {
            waitForOwlCarousel(callback);
        }, 100);
    }
}

$(document).ready(function() {
    waitForOwlCarousel(function() {
        // Your initializeOwlCarousel function here
        function initializeOwlCarousel() {
            $('.owl-carousel').each(function() {
                if ($(this).hasClass('owl-loaded')) {
                    $(this).trigger('destroy.owl.carousel');
                    $(this).removeClass('owl-loaded');
                }
                $(this).owlCarousel({
                    items: 1,
                    loop: true,
                    margin: 10,
                    nav: true,
                    video: true,
                    autoplay: false,
                    autoplayTimeout: 3000,
                    autoplayHoverPause: false
                });
            });
        }

        initializeOwlCarousel();
        $(document).on('newContentLoaded', initializeOwlCarousel);
        $('.owl-carousel').trigger('refresh.owl.carousel');
    });

    // Comment section toggle
    $('[id^="comment_dots_"]').on('click', function(event) {
        const postId = $(this).data('feedpostid');
        console.log("Comment icon clicked for post ID:", postId);
        $('.feed_comments_' + postId).css('display', 'block');
    });
});
</script>
<script>

document.addEventListener('DOMContentLoaded', () => {
    console.log('as6e');
    const video = document.getElementById('plyr-video');
        if (video) {
            video.addEventListener('ended', () => {
                console.log('Video ended');
            });
        } else {
            console.error('Video element not found!');
        }
    });



    // console.log(document.querySelectorAll("#plyr-video"));
    // console.log(video.closest('.video-container-2'));

    // document.addEventListener("DOMContentLoaded", function () {
    //     var videos = document.querySelectorAll("#plyr-video");

    //     videos.forEach(function (video, index) {
    //         // Log when the video ends
    //         video.addEventListener("ended", function () {
    //             console.log(`Video ${index + 1} with ID: ${video.id} has ended.`);
    //         });
    //     });
    // });


    // document.addEventListener("DOMContentLoaded", function() {
    //     var videos = document.querySelectorAll("#plyr-video");
        
        
    //     videos.forEach(function(video, index) {
    //         var overlay = video.closest('.video-container-2').querySelector('.video-btn-overlay');
    //         var replayButton = overlay.querySelector('.replay-btn');

    //         video.addEventListener('ended', function() {
    //             overlay.style.display = 'flex'; // Display the overlay
    //             console.log(`Video ${index + 1} ended`);
    //         });

    //         // Replay the video when the replay button is clicked
    //         replayButton.addEventListener('click', function() {
    //             video.currentTime = 0; // Reset video time to the start
    //             video.play();          // Play the video again
    //             overlay.style.display = 'none'; // Hide overlay while replaying
    //         });
    //     });
    // });
</script>
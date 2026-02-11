<%section name=i loop=$posts%>
<%if $posts[i]['post_type'] eq 'Share'%>
    <div class="video-dash-post mb-20">
        <div class="video-dash-post-heading">
            <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <img src="<%$posts[i]['user_profile_image']%>" alt="">
                </div>
                <div class="video-post-content">
                <h5><a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>"><%$posts[i]['user_name']%></a></h5>
                <p>12 hrs ago</p>
                </div>
            </div>
            <div class="video-post-icon feed-time" title="<%$posts[i]['added_date']%>">
                <i class="fa-solid fa-ellipsis-vertical"></i>
                <%*time_elapsed_string($posts[i]['added_date'])*%>
                <%$this->general->getLocalDateTime($posts[i]['added_date'], "F j, Y- g:i A")%>
            </div>
        </div>
        <div class="video-post-icon">
            <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <%if $posts_pgtype eq 'my_profile'%>
                    <a class="dropdown-item edit_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Edit</a>
                    <a class="dropdown-item delete_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Delete</a>
                <%else%>
                    <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<%$posts[i]['get_actual_post']['p_post_id']%>" href="javascript://">Spam</a>
                    <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<%$posts[i]['get_actual_post']['p_post_id']%>" href="javascript://">Inappropriate ?</a>
                    <a class="dropdown-item block_user" data-userid="<%$posts[i]['posted_user_id']%>" href="javascript://">Block</a>
                <%/if%>
            </div>
        </div>
        <div class="video-post-content">
            <%if $posts[i]['post_metadata']['link'] neq ''%>
                <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>">
                    <p><%$this->general->displayposttext($posts[i]['post_text_emoji'])%></p>
                </a>
                <%if $posts[i]['post_metadata']['title'] neq ''%>
                    <p><%$this->general->displayposttext($posts[i]['post_text_emoji'])%></p>
                <%/if%>
                <%if $posts[i]['post_metadata']['image'] neq ''%>
                <a target="_blank" href="<%$posts[i]['post_metadata']['link']%>"><img style="width:100%;" src="<%$posts[i]['post_metadata']['image']%>"/></a>
                <%/if%>
            <%else%>
                <a href="<%$this->general->setdiplayposturl($posts[i]['get_actual_post']['p_post_id'],$posts[i]['get_actual_post']['p_post_text'])%>">
                    <p ><%$this->general->displayposttext($posts[i]['get_actual_post']['p_post_text'])%></p>
                </a>
            <%/if%>
        </div>

        
        <%if $posts[i]['get_actual_post']['p_post_type'] eq 'Media' or $posts[i]['get_actual_post']['p_post_type'] eq 'Live'%>
            <div class="video-post-vid">
            <%if $posts[i]['get_actual_post']['p_post_type'] eq 'Media' or $posts[i]['get_actual_post']['p_post_type'] eq 'Live'%>
                <%assign var=post_media value=$posts[i]['get_actual_post_media']%>
                <div class="video-wrapper">
                    <%if $post_media[j]['pm_media_type'] eq 'Video'%>
                        <p class="view"><i class="fa-regular fa-eye"></i> <%$posts[i]['get_actual_post']['impression_count']%></p>
                    <%/if%>
                    <%section name=j loop=$post_media%>
                        <div class="video-container-2" id="video-container">
                            <%if $post_media[j]['pm_media_type'] eq 'Image'%>   
                                <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>"><img src="<%$post_media[j]['upload_file_org']%>" alt=""></a>
                            <%elseif $post_media[j]['pm_media_type'] eq 'Video'%>
                                <video id="plyr-video" preload="metadata" class="playerembed" width="100%" height="100%" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>">
                                    <source src="<%$post_media[j]['pm_upload_file']%>" type="video/mp4">
                                </video>
                            <%/if%>
                            <div class="play-button-wrapper">
                                <div title="Play video" class="play-gif" id="circle-play-b">
                                <!-- SVG Play Button -->
                                </div>
                            </div>
                        </div>
                    <%/section%>
                </div>
            <%/if%>
            </div>
            <div class="video-share-box-wrapper">
                <div class="video-share-box">
                    <ul>
                        <%include file="common/feed_actions.tpl"%>
                    </ul>
                </div>
                <div class="video-photo">
                    <a href="#">
                        <i class="fa-regular fa-images"></i>
                    </a>
                    
                    <div class="my-progress-bar impression <%if $posts[i]['get_actual_post']['is_impressed'] eq 1%>active<%/if%>">
                        <p><%$posts[i]['get_actual_post']['impression_count']%></p>
                    </div>
                    <%if $posts[i]['get_actual_post']['visibility'] eq 'Viral'%>
                        <div class="my-progress-bar" data-value="<%time_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%>" data-thickness="4">
                            <p><span><%hours_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%></span></p>
                        </div>
                    <%/if%>
                </div>
            </div>
        <%/if%>


        <div class="comment">
            <div class="comment-pic">
                <img src="images/comment.png" alt="">
            </div>
            <div class="comment-text comment-text-new">
                <form>
                    <div class="form-group">
                    <input type="email" class="form-control" id="comment-box8" aria-describedby="emailHelp" placeholder="Add a Comment">
                    </div>
                    <button type="submit" class="btn btn-primary form-btn"><img src="images/plane.png"></button>
                </form>
            </div>
        </div>
    </div>
<%else%>
    <div class="video-dash-post mb-20">
        <div class="video-dash-post-heading">
            <div class="video-dash-post-user">
                <div class="video-dash-post-img">
                <img src="<%$posts[i]['user_profile_image']%>" alt="">
                </div>
                <div class="video-post-content">
                <h5><a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>"><%$posts[i]['user_name']%></a><%if $posts[i]['post_type'] eq 'Live'%> <span>was Live.</span><%/if%></h5>
                <%if $posts[i]['post_type'] eq 'LiveNow'%>
                    <a href="<%$this->general->setdiplayliveposturl($posts[i]['post_id'])%>"><button type="button" class="btn feed-live-screen-btn">
                            <i class="fas fa-video"></i> Live
                        </button></a>
                <%/if%>
                <p class="feed-time" title="<%$posts[i]['added_date']%>">
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
                    <%else%>
                        <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Spam</a>
                        <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Inappropriate ?</a>
                        <a class="dropdown-item block_user" data-userid="<%$posts[i]['posted_user_id']%>" href="javascript://">Block</a>
                        <a class="dropdown-item show_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Unhide Post</a>
                    <%/if%>
                </div>
            </div>
        </div>
        <div class="video-post-content">
            <%if $posts[i]['post_metadata']['link'] neq ''%>
                <p><%$posts[i]['post_metadata']['text']|nl2br%></p>
                <%if $posts[i]['post_metadata']['title'] neq ''%>
                    <p><%$posts[i]['post_metadata']['title']|nl2br%></p>
                <%/if%>
                <%if $posts[i]['post_metadata']['image'] neq ''%>
                    <a target="_blank" href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_metadata']['text'])%>"><img style="width:100%;" src="<%$posts[i]['post_metadata']['image']%>"/></a>
                    <%/if%> <%*$posts[i]['post_metadata']['link']*%>
                <%else%>
                <%if $posts[i]['post_type'] eq 'LiveNow'%>
                    <a class="livenow-video-thumbnail" href="<%$this->general->setdiplayliveposturl($posts[i]['post_id'])%>">
                        <p><%$this->general->displayposttext($posts[i]['post_text_emoji'])%></p>
                        <%assign var="live_thumb_path" value=$this->config->item('live_thumb_path')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                        <%assign var="live_thumb_url" value=$this->config->item('live_thumb_url')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                        <%if $live_thumb_path|@file_exists%>
                            <span title="Join"></span>
                            <img src="<%$live_thumb_url%>" alt="" style="width:100%">
                        <%/if%>
                    </a>
                <%else%>
                    <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>">
                        <p class="displayemoji_comment"><%removeEmoji($this->general->displayposttext($posts[i]['post_text_emoji']))%></p>
                    </a>
                <%/if%>
            <%/if%>
        </div>
        <div class="video-post-vid">
            <%if $posts[i]['post_type'] eq 'Media' or $posts[i]['post_type'] eq 'Live'%>
                <div class="video-wrapper">
                <p class="view"><i class="fa-regular fa-eye"></i> 12</p>
                    <%if $posts[i]['post_type'] eq 'Media' or $posts[i]['post_type'] eq 'Live'%>
                        <%assign var=post_media value=$posts[i]['get_post_media']%>
                        <%*<a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>">*%>
                        <%section name=j loop=$post_media%>
                            <div class="video-container-2" id="video-container">
                                <%if $post_media[j]['pm_media_type'] eq 'Image'%>
                                    <%if $post_media[j]['upload_file_org'] neq ''%>
                                        <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text_emoji'])%>"><img src="<%$post_media[j]['upload_file_org']%>" alt=""></a>
                                    <%else%>
                                        <img src="<%$post_media[j]['display_image']%>" alt="">
                                    <%/if%>
                                <%elseif $post_media[j]['pm_media_type'] eq 'Video'%>
                                    
                                    <video controls data-poster="<%$post_media[j]['video_thumbnail_org']%>" id="plyr-video" preload="metadata" class="playerembed" width="100%" height="100%" >
                                        <%assign var="video_url" value=$post_media[j]['pm_upload_file']%>
                                        <%if $is_detail eq "Yes"%>
                                            <%assign var="video_url" value=$post_media[j]['upload_file']%>
                                        <%/if%>
                                        <source src="<%$video_url%>" type="video/mp4">
                                    </video>
                                <%/if%>
                                <div class="play-button-wrapper">
                                    <div title="Play video" class="play-gif" id="circle-play-b">
                                    <!-- SVG Play Button -->
                                    </div>
                                </div>
                            </div>
                        <%/section%>
                        <%*</a>*%>
                    <%/if%>
                </div>
            <%/if%>
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
                <div class="my-progress-bar">
                    <p>48</p>
                </div>
            </div>
        </div>
        <div class="comment">
            <div class="comment-pic">
                <img src="<%$posts[i]['user_profile_image']%>" alt="">
            </div>
            <div class="post-add-comment add-comments">                    
                <div class="comment-text comment-text-new"style="padding-top: 11px !important;">
                    <form style="display: flex; height: 53px">
                        <div class="form-group">
                        <textarea class="form-control comment_post_<%$posts[i]['post_id']%>" id="comment-box8" aria-describedby="emailHelp" data-postid="<%$posts[i]['post_id']%>" rows="1" placeholder="Add Comment" data-emojiable="true" style="color:gray"></textarea>
                        </div>
                        <div class="upload_media_div" id="media_div_<%$posts[i]['post_id']%>" style="display: none;">
                            <input type="file" name="upload_file" id="input_media_<%$posts[i]['post_id']%>">
                        </div>
                        <div class="comment-pic" style="background: none">
                            <span style="cursor: pointer" class="btn_post_media_attach">
                                <i class="fa fa-paperclip btn_postmedia" data-postid="142251" style="font-size: 16px !important"></i>
                            </span>
                            <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<%$posts[i]['post_id']%>">GIF</span>
                            <span style="cursor:pointer; " class="open_sticker_section" data-sticker-post-id="<%$posts[i]['post_id']%>">
                                <img  src="<%$this->config->item('images_url')%>front/sticker.png" alt="">
                            </span>
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
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>
                <div class="gif_picker_div_cls" id="gifPicker_<%$posts[i]['post_id']%>">
                    <img src="https://media1.giphy.com/media/9ywJxa5PASF6HBUSh7/giphy-downsized-medium.gif?cid=ca8ff4c416a6m7a5omqz1thbb97qwfygjzj2z51qo93v43oa&ep=v1_stickers_search&rid=giphy-downsized-medium.gif&ct=s" alt="">
                </div>    
            </div>
        </div>
    </div>
<%/if%>
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
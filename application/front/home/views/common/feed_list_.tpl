<%section name=i loop=$posts%>
    <%if $posts[i]['post_type'] eq 'Share'%>
        <div class="cmn-white-block feed_item" id="feed_id_<%$posts[i]['post_id']%>">
            <div class="feed-user-row">
                <div class="feed-content">
                    <div class="feed-user">
                        <div class="feed-user-details">
                            <div class="user-img-name">
                                <i class="cmn-user-img">
                                    <img src="<%$posts[i]['user_profile_image']%>" alt="">
                                </i>
                                <h6><a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>"><%$posts[i]['user_name']%></a></h6>
                            </div>
                            <div class="feed-time" title="<%$posts[i]['added_date']%>">
                                <%*time_elapsed_string($posts[i]['added_date'])*%>
                                <%$posts[i]['added_date']%>
                            </div>
                        </div>
                        <div class="feed-text">
                            <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>"><p><%$posts[i]['post_text']|nl2br%></p></a>
                        </div>
                    </div>
                </div>
                <div class="share-post">
                    <div class="feed-content">
                        <div class="feed-user">
                            <div class="feed-user-details">
                                <div class="user-img-name">
                                    <i class="cmn-user-img">
                                        <img src="<%$posts[i]['get_actual_post']['user_profile_image']%>" alt="">
                                    </i>
                                    <h6><a href="<%$this->general->setdiplayprofileurl($posts[i]['get_actual_post']['p_user_id'],$posts[i]['get_actual_post']['user_name'])%>"><%$posts[i]['get_actual_post']['user_name']%></a></h6>
                                </div>
                                <div class="feed-time" title="<%$posts[i]['get_actual_post']['p_added_date']%>">
                                    <%*time_elapsed_string($posts[i]['get_actual_post']['p_added_date'])*%>
                                    <%$posts[i]['get_actual_post']['p_added_date']%>
                                </div>
                            </div>
                            <div class="feed-text">
                                <%if $posts[i]['post_metadata']['link'] neq ''%>
                                    <p><%$posts[i]['post_metadata']['text']|nl2br%></p>
                                    <%if $posts[i]['post_metadata']['title'] neq ''%>
                                    <p><%$posts[i]['post_metadata']['title']|nl2br%></p>
                                    <%/if%>
                                    <%if $posts[i]['post_metadata']['image'] neq ''%>
                                    <a target="_blank" href="<%$posts[i]['post_metadata']['link']%>"><img style="width:100%;" src="<%$posts[i]['post_metadata']['image']%>"/></a>
                                    <%/if%>
                                    <%else%>
                                    <a href="<%$this->general->setdiplayposturl($posts[i]['get_actual_post']['p_post_id'],$posts[i]['get_actual_post']['p_post_text'])%>"><p><%$posts[i]['get_actual_post']['p_post_text']|nl2br%></p></a>
                                        <%/if%>
                            </div>
                        </div>
                        <%if $posts[i]['get_actual_post']['p_post_type'] eq 'Text'%>
                            <div class="bottom-row">
                                <div class="impression <%if $posts[i]['get_actual_post']['is_impressed'] eq 1%>active<%/if%>">
                                    <i class="far fa-eye"></i> <%$posts[i]['get_actual_post']['impression_count']%> Impression’s
                                </div>
                                <%if $posts[i]['get_actual_post']['visibility'] eq 'Viral'%>
                                    <div class="circle-view">
                                        <div class="post-circle" data-value="<%time_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%>" data-thickness="4">
                                            <span><%hours_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%></span>
                                        </div>
                                    </div>
                                <%/if%>
                            </div>
                        <%/if%>
                    </div>
                    <div class="feed-media">
                        <%if $posts[i]['get_actual_post']['p_post_type'] eq 'Media'%>
                            <div class="feed-img">
                                <%if $posts[i]['get_actual_post']['p_post_type'] eq 'Media'%>
                                    <%assign var=post_media value=$posts[i]['get_actual_post_media']%>
                                    <div class="feed-media-slider">
                                        <div class="owl-carousel owl-theme media-slider media_slider">
                                            <%section name=j loop=$post_media%>
                                                <div class="item" data-getmediaid="<%$post_media[j]['pm_post_media_id']%>" data-getpostid="<%$post_media[j]['pm_post_id']%>">
                                                    <%if $post_media[j]['pm_media_type'] eq 'Image'%>
                                                        <img src="<%$post_media[j]['upload_file_org']%>" alt="">
                                                    <%elseif $post_media[j]['pm_media_type'] eq 'Video'%>
                                                        <div class="top-row">
                                                            <div class="impression">
                                                                <i class="far fa-eye"></i> <%$post_media[j]['pm_views_count']%>
                                                            </div>
                                                        </div>
                                                        <video id="plyr-video" width="100%" height="100%" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>">
                                                            <source src="<%$post_media[j]['pm_upload_file']%>" type="video/mp4">
                                                        </video>
                                                    <%/if%>
                                                </div>
                                            <%/section%>
                                        </div>
                                    </div>
                                <%/if%>
                                <div class="bottom-row">
                                    <div class="impression <%if $posts[i]['get_actual_post']['is_impressed'] eq 1%>active<%/if%>">
                                        <i class="far fa-eye"></i> <%$posts[i]['get_actual_post']['impression_count']%> Impression’s
                                    </div>
                                    <%if $posts[i]['get_actual_post']['visibility'] eq 'Viral'%>
                                        <div class="circle-view">
                                            <div class="post-circle" data-value="<%time_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%>" data-thickness="4">
                                                <span><%hours_left($posts[i]['get_actual_post']['p_added_date'],$posts[i]['get_actual_post']['expire_date'])%></span>
                                            </div>
                                        </div>
                                    <%/if%>
                                </div>
                            </div>
                        <%/if%>
                    </div>
                </div>
                <div class="feed-like-row">
                    <div class="feed-action" id="feed_action_<%$posts[i]['post_id']%>">
                        <%include file="common/feed_actions.tpl"%>
                    </div>
                    <div class="other-action">
                        <div class="dropdown">
                            <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <%if $posts_pgtype eq 'my_profile'%>
                                    <a class="dropdown-item edit_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Edit</a>
                                    <a class="dropdown-item delete_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Delete</a>
                                <%else%>
                                    <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<%$posts[i]['get_actual_post']['p_post_id']%>" href="javascript://">Spam</a>
                                    <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<%$posts[i]['get_actual_post']['p_post_id']%>" href="javascript://">Inappropriate ?</a>
                                <%/if%>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feed-comments feed_comments_<%$posts[i]['post_id']%> scrollbarContent feed-comments-main" style="display:none;">
                    <ul id="comments_list_<%$posts[i]['post_id']%>">
                        <%*include file="common/comments.tpl" comments=$posts[i]['statistics']['comments']*%>
                    </ul>
                </div>
                <div class="post-add-comment add-comments">
                    <i class="fas fa-paper-plane btn_postcomment" style="cursor:pointer;" data-postid="<%$posts[i]['get_actual_post']['p_post_id']%>" title="Add Comment"></i>
                    <textarea class="form-control comment_post comment_post_<%$posts[i]['get_actual_post']['p_post_id']%>" data-postid="<%$posts[i]['get_actual_post']['p_post_id']%>" rows="1" placeholder="Add Comment"></textarea>
                </div>
            </div>
        </div>
    <%else%>
        <div class="cmn-white-block feed_item" id="feed_id_<%$posts[i]['post_id']%>">
            <div class="feed-user-row">
                <div class="feed-content">
                    <div class="feed-user">
                        <div class="feed-user-details">
                            <div class="user-img-name">
                                <i class="cmn-user-img">
                                    <img src="<%$posts[i]['user_profile_image']%>" alt="">
                                </i>
                                <h6><a href="<%$this->general->setdiplayprofileurl($posts[i]['posted_user_id'],$posts[i]['user_name'])%>"><%$posts[i]['user_name']%></a></h6>
                                    <%if $posts[i]['post_type'] eq 'LiveNow'%>
                                    <a href="<%$this->general->setdiplayliveposturl($posts[i]['post_id'])%>"><button type="button" class="btn feed-live-screen-btn">
                                            <i class="fas fa-video"></i> Live
                                        </button></a>
                                    <%/if%>
                            </div>
                            <div class="feed-time" title="<%$posts[i]['added_date']%>">
                                <%*time_elapsed_string($posts[i]['added_date'])*%>
                                <%$posts[i]['added_date']%>
                            </div>
                        </div>
                        <div class="feed-text">
                            <%if $posts[i]['post_metadata']['link'] neq ''%>
                                <p><%$posts[i]['post_metadata']['text']|nl2br%></p>
                                <%if $posts[i]['post_metadata']['title'] neq ''%>
                                    <p><%$posts[i]['post_metadata']['title']|nl2br%></p>
                                <%/if%>
                                <%if $posts[i]['post_metadata']['image'] neq ''%>
                                    <a target="_blank" href="<%$posts[i]['post_metadata']['link']%>"><img style="width:100%;" src="<%$posts[i]['post_metadata']['image']%>"/></a>
                                    <%/if%>
                                <%else%>
                                <%if $posts[i]['post_type'] eq 'LiveNow'%>
                                <a class="livenow-video-thumbnail" href="<%$this->general->setdiplayliveposturl($posts[i]['post_id'])%>">
                                        <p><%$posts[i]['post_text']|nl2br%></p>
                                        <%assign var="live_thumb_path" value=$this->config->item('live_thumb_path')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                                        <%assign var="live_thumb_url" value=$this->config->item('live_thumb_url')|@cat:"screenshot_"|@cat:$posts[i]['post_id']|@cat:".jpeg"%>
                                        <%if $live_thumb_path|@file_exists%>
                                            <span title="Join"></span>
                                            <img src="<%$live_thumb_url%>" alt="">
                                        <%/if%>
                                    </a>
                                <%else%>
                                    <a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>"><p><%$posts[i]['post_text']|nl2br%></p></a>
                                <%/if%>
                                    <%/if%>
                        </div>
                    </div>
                    <%if $posts[i]['post_type'] eq 'Text'%>
                        <div class="bottom-row">
                            <div class="impression <%if $posts[i]['is_impressed'] eq 1%>active<%/if%>">
                                <i class="far fa-eye"></i> <%$posts[i]['impression_count']%> Impression’s
                            </div>
                            <%if $posts[i]['visibility'] eq 'Viral'%>
                                <div class="circle-view">
                                    <div class="post-circle" data-value="<%time_left($posts[i]['added_date'],$posts[i]['expire_date'])%>" data-thickness="4">
                                        <span><%hours_left($posts[i]['added_date'],$posts[i]['expire_date'])%></span>
                                    </div>
                                </div>
                            <%/if%>
                        </div>
                    <%/if%>
                </div>
                <div class="feed-media">
                    <%if $posts[i]['post_type'] eq 'Media'%>
                        <div class="feed-img">
                            <%if $posts[i]['post_type'] eq 'Media'%>
                                <%assign var=post_media value=$posts[i]['get_post_media']%>
                                <%*<a href="<%$this->general->setdiplayposturl($posts[i]['post_id'],$posts[i]['post_text'])%>">*%>
                                <div class="feed-media-slider">
                                    <div class="owl-carousel owl-theme media-slider media_slider carousel<%$posts[i]['post_id']%>">
                                        <%section name=j loop=$post_media%>
                                            <div class="item" data-getmediaid="<%$post_media[j]['pm_post_media_id']%>" data-getpostid="<%$post_media[j]['post_id']%>">
                                                <%if $post_media[j]['pm_media_type'] eq 'Image'%>
                                                    <%if $post_media[j]['upload_file_org'] neq ''%>
                                                        <img src="<%$post_media[j]['upload_file_org']%>" alt="">
                                                    <%else%>
                                                        <img src="<%$post_media[j]['display_image']%>" alt="">
                                                    <%/if%>
                                                <%elseif $post_media[j]['pm_media_type'] eq 'Video'%>
                                                    <div class="top-row">
                                                        <div class="impression">
                                                            <i class="far fa-eye"></i> <%$post_media[j]['pm_views_count']%>
                                                        </div>
                                                    </div>
                                                    <video id="plyr-video" width="100%" height="100%" controls data-poster="<%$post_media[j]['video_thumbnail_org']%>">
                                                        <%assign var="video_url" value=$post_media[j]['pm_upload_file']%>
                                                        <%if $is_detail eq "Yes"%>
                                                            <%assign var="video_url" value=$post_media[j]['upload_file']%>
                                                        <%/if%>
                                                        <source src="<%$video_url%>" type="video/mp4">
                                                    </video>
                                                <%/if%>
                                            </div>
                                        <%/section%>
                                    </div>
                                </div>
                                    <%*</a>*%>
                            <%/if%>
                            <div class="bottom-row">
                                <div class="impression <%if $posts[i]['is_impressed'] eq 1%>active<%/if%>">
                                    <i class="far fa-eye"></i> <%$posts[i]['impression_count']%> Impression’s
                                </div>
                                <%if $posts[i]['visibility'] eq 'Viral'%>
                                    <div class="circle-view">
                                        <div class="post-circle" data-value="<%time_left($posts[i]['added_date'],$posts[i]['expire_date'])%>" data-thickness="4">
                                            <span><%hours_left($posts[i]['added_date'],$posts[i]['expire_date'])%></span>
                                        </div>
                                    </div>
                                <%/if%>
                            </div>
                        </div>
                    <%/if%>
                </div>
                <div class="feed-like-row">
                    <div class="feed-action" id="feed_action_<%$posts[i]['post_id']%>">
                        <%include file="common/feed_actions.tpl"%>
                    </div>
                    <div class="other-action">
                        <div class="dropdown">
                            <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <%if $posts_pgtype eq 'my_profile' || $posts[i]['posted_user_id'] eq $this->session->userdata('iUserId')%>
                                    <a class="dropdown-item edit_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Edit</a>
                                    <a class="dropdown-item delete_post" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Delete</a>
                                <%else%>
                                    <a class="dropdown-item report_post" data-report_type="Spam" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Spam</a>
                                    <a class="dropdown-item report_post" data-report_type="InAppropriate" data-postid="<%$posts[i]['post_id']%>" href="javascript://">Inappropriate ?</a>
                                <%/if%>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="feed-comments feed_comments_<%$posts[i]['post_id']%> scrollbarContent feed-comments-main" style="display:none;">
                    <ul id="comments_list_<%$posts[i]['post_id']%>">
                        <%include file="common/comments.tpl" comments=$posts[i]['statistics']['comments']%>
                    </ul>
                </div>
                <div class="post-add-comment add-comments">
                    <i class="fas fa-paper-plane btn_postcomment" style="cursor:pointer;" data-postid="<%$posts[i]['post_id']%>" title="Add Comment"></i>
                    <textarea class="form-control comment_post comment_post_<%$posts[i]['post_id']%>" data-postid="<%$posts[i]['post_id']%>" rows="1" placeholder="Add Comment"></textarea>
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
                    <button type="button" id="submit_report_post" class="btn btn-primary">Report</button>
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
                    <button type="button" id="share_timeline" class="btn btn-primary">Share on My Timeline</button>
                </div>
            </form>
        </div>
    </div>
</div>

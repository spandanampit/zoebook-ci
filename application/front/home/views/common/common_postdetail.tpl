<div class="post-details-block">
    <div class="post-title-details">
        <div class="post-name">
            <%assign var=posted_text_withouemoji value=removeEmoji($postinfo.post_text_emoji)%>
            <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
            <h2><%$this->general->displayposttext($posted_text)%></h2>
            <div class="view-time">
                <%$viewcount%> views <span>•</span> <%$postinfo.impression_count%> impressions <span>•</span> <%time_elapsed_string($postinfo.added_date)%>
            </div>
        </div>
        
        <div class="post-action">
            <ul>
                <li>
                    <a id="like_<%$postinfo.post_id%>" href="javascript:void(0)" data-postid="<%$postinfo.post_id%>" data-mediaid="<%$mediaid%>" class="<%if $islike eq 1%>active <%/if%>like-post act_likepost"><i class="fas fa-thumbs-up"></i></a>
                </li>
                <li style="margin-left:2px;">
                    <a href="javascript:" class="disp_postlikes" data-pageindex="" data-postid="<%$postinfo.post_id%>"  id="displike_<%$postinfo.post_id%>" data-mediaid="<%$mediaid%>"><span data-likescount="<%$likescount%>" id="likes_count_<%$postinfo.post_id%>"><%$likescount%></span><span id="displiketext_<%$postinfo.post_id%>"><%if $likescount eq 1%>&nbsp;Like<%else%>&nbsp;Likes<%/if%></span></a>
                </li>
                <li>
                    <a href="<%$this->general->setdiplayposturl(<%$postinfo.post_id%>,<%$postinfo.post_text_emoji%>)%>#gotocomment"><i class="fas fa-comment-dots"></i><span id="calc_comment_count"><%$commentcount%></span>&nbsp;Comment</a>
                </li>
                <li>
                    <a id="share_<%$postinfo.post_id%>" href="javascript:void(0)" data-userid="<%$this->session->userdata('iUserId')%>" data-postid="<%$postinfo.post_id%>" class="share_postdetail"><i class="fas fa-share-alt"></i> Share</a>
                </li>
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
                            <a class="dropdown-item report_postdetail" data-report_type="Spam" data-userid="<%$this->session->userdata('iUserId')%>"  data-postid="<%$postinfo.post_id%>" href="javascript://">Spam</a>
                            <a class="dropdown-item report_postdetail" data-report_type="InAppropriate" data-userid="<%$this->session->userdata('iUserId')%>"  data-postid="<%$postinfo.post_id%>" href="javascript://">Inappropriate ?</a>
                            <a class="dropdown-item block_user" data-userid="<%$postinfo.posted_user_id%>" href="javascript://">Block</a>
                            <%else%>
                            <a class="dropdown-item edit_post" data-postid="<%$postinfo.post_id%>" href="javascript://">Edit</a>
                            <a class="dropdown-item delete_post" data-postid="<%$postinfo.post_id%>" href="javascript://">Delete</a>
                            <%/if%>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="post-content" id="gotocomment">
        <i class="cmn-user-img">
            <img src="<%$postinfo.user_profile_image%>" alt="">
        </i>
        <div class="post-text" <%if $this->session->userdata('iUserId') neq $postinfo.posted_user_id%> style="width:80%;" <%/if%>>
            <h4><a href="<%$this->general->setdiplayprofileurl($postinfo.posted_user_id,$postinfo.user_name)%>"><%$postinfo.user_name%></h4></a>
            <span class="post-location" style="display:none;">
                <i class="fas fa-map-marker-alt"></i> Florida
            </span>
            <%assign var=posttext_without_emoji value=$this->general->linkify($postinfo.post_text_emoji)%>
            <div id="displayedittext"><%$this->general->displayposttext(removeEmoji($posttext_without_emoji))%><!--<a href="javascript:" class="more-link">More.</a>--></div>
        </div>
        <%if $this->session->userdata('iUserId') neq $postinfo.posted_user_id%>
        <div class="follow-button" style="padding-left:15px">
            <%if $followerinfo.pending_request_id neq '' && $followerinfo.is_follwing eq 'Pending'%>
                <a href="javascript:" class="btn btn-secondary act_cancelfollowrequest" data-id="<%$followerinfo.u_users_id%>" data-pendingrequestid="<%$followerinfo.pending_request_id%>">Cancel</a>
            <%else if $followerinfo.is_follwing eq 'Yes'%>
                <a href="javascript:" class="btn btn-secondary act_unfollowuser" data-id="<%$followerinfo.u_users_id%>" >Unfollow</a>
            <%else%>
                <a href="javascript:" class="btn btn-primary act_followuser"  data-id="<%$followerinfo.u_users_id%>">Follow</a>
            <%/if%>
            <div id="followactionmsg_<%$followerinfo.u_users_id%>"></div>
        </div>
        <%/if%>
    </div>
    <%if $this->session->userdata('iUserId') neq ''%>
    <div class="post-add-comment" >
        <i class="fas fa-paper-plane act_postcomment" style="cursor:pointer;" data-mediaid="<%$mediaid%>" data-postid="<%$postinfo.post_id%>" title="Add Comment"></i>
        <!--<textarea name="commentadd" id="commentadd" class="form-control actkeypress_postcomment" rows="1" data-mediaid="<%$mediaid%>" data-postid="<%$postinfo.post_id%>" placeholder="Add comment"></textarea>-->

        <p class="lead emoji-picker-container w-100">
            <textarea name="commentadd" id="commentadd" class="form-control actkeypress_postcomment" rows="1" data-mediaid="<%$mediaid%>" data-postid="<%$postinfo.post_id%>" placeholder="Add comment" data-emojiable="true"></textarea>
        </p>
        <!--<div data-emojiarea data-type="unicode" data-global-picker="false" class="w-100">
            <div class="emoji-button" style="right:4px;padding-top:3px;"><i class="fa fa-smile-o" style="font-size:20px;"></i></div>
            <textarea name="commentadd" id="commentadd" class="form-control actkeypress_postcomment emojipadding" rows="1" data-mediaid="<%$mediaid%>" data-postid="<%$postinfo.post_id%>" placeholder="Add comment"></textarea>
        </div> -->
    </div>
    <%/if%>
</div>
<span id="errorcomment_disp" style="padding-top:10px;"></span>
<div class="<%if $postcomment|@count gt 0%>cmn-white-block<%/if%> post-comments" >
    <div class="feed-comments">
        <ul id="comments_list_<%$postinfo.post_id%>">
            <%if $postcomment|@count gt 0%>
                <%include file="common/common_postcomment.tpl"%>
           <%/if%>
        </ul>
    </div>
</div>
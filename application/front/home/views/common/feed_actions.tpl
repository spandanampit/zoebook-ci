<%if $isajax eq 'Yes'%>
    <%assign var="is_like" value=$islike%>
    <%assign var="likes_count" value=$likescount%>
    <%assign var="comment_count" value=$commentcount%>
    <%assign var="feed_action_postid" value=$postid%>
<%else%>
    <%assign var="is_like" value=$posts[i]['statistics']['is_like']%>
    <%assign var="likes_count" value=$posts[i]['statistics']['likes_count']%>
    <%assign var="comment_count" value=$posts[i]['statistics']['comments_count']%>
    <%assign var="feed_action_postid" value=$posts[i]['post_id']%>
<%/if%>
<%assign var="mediaid" value=$posts[i]['get_post_media'][0]['pm_post_media_id']%>
<!--<pre>
<%$posts|print_r%>
</pre>-->

<div class="like-action">
    <a id="like_<%$feed_action_postid%>" href="javascript:void(0)" data-postid="<%$feed_action_postid%>" class="<%if $is_like eq 1%>active <%/if%>like-post likepost_switch">
        <i class="<%if $is_like eq 1%>fas<%else%>far<%/if%> fa-heart" style="color: red"></i>
    </a>
    <a href="javascript:" class="disp_postlikes" data-pageindex="" data-postid="<%$feed_action_postid%>"  id="displike_<%$feed_action_postid%>" data-mediaid="<%$mediaid%>">
        <span data-likescount="<%$likes_count%>" id="likes_count_<%$feed_action_postid%>" style="color: gray"><%$likes_count%></span>
    </a>
</div>
<div class="comments-action">
    <a href="javascript:void(0);" class="show_feed_comments" data-feedpostid="<%$feed_action_postid%>" data-mediaid="<%$posts[i]['get_post_media'][0]['pm_post_media_id']%>" id="comment_dots_<%$feed_action_postid%>">
        <i class="far fa-comment-dots" style="color: grey"></i>
        <span id="disp_comcount_<%$feed_action_postid%>" style="color: gray"><%$comment_count%></span>
    </a>
</div>
<div class="share-action">
    <a id="share_<%$feed_action_postid%>" href="javascript:void(0)" data-postid="<%$feed_action_postid%>" class="share_post"><i class="fa fa-share" style="color: grey"></i></a>
</div>
<div class="video-info-box">
    <a data-id="<%$feed_action_postid%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($feed_action_postid,$posts[i]['post_text'])%>">
        <i class="fa fa-info"></i>
    </a>
</div>
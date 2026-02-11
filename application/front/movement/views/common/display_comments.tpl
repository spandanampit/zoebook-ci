
<style>
.gif-grid-css {
    display: grid;
    grid-template-columns: auto auto auto;
    overflow-y: scroll;
    width: 100%;
    height: 11rem;
    background: white;
}

.comment-image {
    max-width: 31%;
    max-height: 84px;
    object-fit: cover;
    border-radius: 10px;
}
</style>
<%foreach item=comment from=$comments%>
    <li>
        <div class="user-comments-row" id="showloader_<%$row['post_id']%>">
            <div class="comments-block">
                <div class="comments-user-row">
                    <div class="comments-user-details">
                        <i class="cmn-user-img">
                            <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$comment['profile_image']%>" alt="">
                        </i>
                        <h6>
                            <a href="#" class="name"><%$comment['user_name']%></a>
                        </h6>
                    </div> 
                    <div class="comments-time" title="">
                    <%time_elapsed_string($comment['added_date'])%>
                    </div>
                </div>
                <div class="user-comments">
                    
                  <%if preg_match('/^https:.*\.(jpg|jpeg|png|gif)(\?.*)?$/i', $comment['comment'])%>
                  <img src="<%$comment['comment']%>" alt="" style="width: 20%;">
                  <%else%>
                  <p class="displayemoji_comment" style="display:block;"><%$comment['comment']%></p>
                  <%/if%>



                    <%if $comment['upload_file'] neq ''%>
                    <img src="<%$comment['upload_file']%>" class="comment-image">
                    <%/if%>
                    <div class="like-reply-row">
                        
                        <div>
                            <a id="postlike_<%$comment['post_comment_id']%>" href="javascript:void(0)" data-postid="<%$comment['post_comment_id']%>" data-postcommentid="<%$comment['post_comment_id']%>" class="grey-link like-post act_likepostcomment" style="margin-right:7px;" onclick="like_postcomment(<%$row['post_id']%>, <%$comment['post_comment_id']%>)"><i class="fas fa-thumbs-up" data-comment-id="<%$comment['post_comment_id']%>"></i></a> 
                            <a href="javascript:" class="disp_postcommentlikes" data-pageindex="" data-postid="<%$comment['post_comment_id']%>" data-postcommentid="<%$comment['post_comment_id']%>" ><span data-commentlikescount="<%$showpostlike%>" id="commentlikes_count_<%$comment['post_comment_id']%>">Likes</span></a>
                        </div>

                        <div class="all-comment">
                            <a href="javascript:" class="grey-link show_replies" data-postcommentid="<%$comment['post_comment_id']%>">
                                <i class="fas fa-comment-dots"></i> <span id="disp_replycount_<%$comment['post_comment_id']%>" onclick="open_reply(<%$comment['post_comment_id']%>, 'reply_comments')">reply</span>
                            </a>
                        </div>
                        
                        <div class="reply-comments">
                            <a href="javascript:void(0);" class="postreply-link" onclick="open_reply(<%$comment['post_comment_id']%>, 'reply_form')">Reply</a>
                        </div>
                        
                        <div class="reply-comment-box" id="reply_comment_<%$comment['post_comment_id']%>" style="display:none;">
                            <textarea class="form-control reply_postcomment reply_comment_post" rows="1" placeholder="Reply Comment"
                                data-postid="<%$comment['post_comment_id']%>" 
                                data-postcommentid="<%$comment['post_comment_id']%>" 
                                name="replycommentad" 
                                id="replycommentad_<%$comment['post_comment_id']%>"
                                onkeydown="checkEnter(event, '<%$comment['post_comment_id']%>')"></textarea>
                            
                            <span class="err_msg_" style="font-size: 12px; color: #4e4c4c;"></span>

                            <span style="cursor:pointer;" class="open_reply_gif_section" data-gif-postid="<%$comment['post_comment_id']%>" data-gif-postcommentid="<%$comment['post_comment_id']%>">GIF</span>
                            <span style="cursor:pointer;" class="open_reply_sticker_section" data-sticker-postid="<%$comment['post_comment_id']%>" data-sticker-postcommentid="<%$comment['post_comment_id']%>">
                                Sticker
                            </span>

                            <span style="cursor:pointer; margin-left:5px;" class="btn_post_media_attach">
                                <i class="fa fa-paperclip btn_reply_postmedia" data-postid="<%$row['post_id']%>" data-postcommentid="<%$row['post_id']%>" style="font-size:18px;"></i>
                            </span>

                            <div class="upload_media_div" id="reply_media_div_<%$row['post_id']%>" style="display:none;">
                                <input type="file" name="upload_file" class="upload_media_input" data-post-id="<%$row['post_id']%>" id="reply_input_media_<%$row['post_id']%>" />
                            </div>
                            <input type="hidden" name="post_id" id="reply_postId_<%$comment['post_comment_id']%>" value="<%$row['post_id']%>">
                            <div class="main_reply_gif_div_section reply_gif_section_<%$comment['post_comment_id']%>">
                                <input type="text" id="reply_searchInput_<%$comment['post_comment_id']%>" placeholder="Search for GIFs">
                                <a href="javascript:void(0);" class="reply_close_gif_div_<%$comment['post_comment_id']%>"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                <div class="reply_gif_picker_div_cls gif-grid-css" id="reply_gifPicker_<%$comment['post_comment_id']%>"></div>
                            </div>
                        </div>

                        <div class="feed-comments scrollbarContent scrolldefineheight feed_replies_<%$comment['post_comment_id']%>" id="feed_replies_<%$comment['post_comment_id']%>" style="width:97%; display: none;">
                            <ul id="replycommentshow_<%$comment['post_comment_id']%>" style="margin-left: 30px !important">
                                <%include file="common/comments_replies.tpl" comments=$row%>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <%/foreach%>
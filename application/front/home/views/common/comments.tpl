<%section name=i loop=$comments%>
    <li>
        <div class="user-comments-row" id="showloader_<%$comments[i]['post_comment_id']%>">
            <div class="comments-block">
                <div class="comments-user-row">
                    <div class="comments-user-details">
                        <!--<pre><%$comments|print_r%></pre>-->
                        <i class="cmn-user-img">
                            <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$comments[i]['profile_image']%>" alt="">
                        </i>
                        <h6>
                            <a href="<%$this->general->setdiplayprofileurl($comments[i]['user_id'],$comments[i]['user_name'])%>" class="name"><%$comments[i]['user_name']%></a>
                        </h6>
                    </div> 
                    <div class="comments-time" title="<%$comments[i]['added_date']%>">
                        <%time_elapsed_string($comments[i]['added_date'])%>
                    </div>
                </div>
                <div class="user-comments">
                    <%*<%assign var=comment_text value=$this->general->makehttpclickable($comments[i]['comment'])%>*%>
                    <%assign var=comment_text value=$this->general->linkify($comments[i]['comment'])%>
                    <%assign var=comment_text_format value=removeEmoji($comment_text)%>

                    <%if strpos($comments[i]['comment'], 'giphy.com') !== false%>
                        <img src="<%$comments[i]['comment']%>" height="auto" width="100px" style="width: 31%;" alt="">
                    <%else%>
                        <%if $comments[i]['upload_file'] neq ''%>
                            <%*<img src="<%$comments[i]['upload_file']%>" class="upld_img" alt="">*%>
                            <%assign var=fileExt value=pathinfo($comments[i]['upload_file'], PATHINFO_EXTENSION)%>
                            <%if $fileExt == 'mp4' || $fileExt == 'avi' || $fileExt == 'mkv' || $fileExt == 'mov'%>
                                <video controls height="auto" width="300px">
                                    <source src="<%$comments[i]['upload_file']%>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <%elseif $fileExt == 'png' || $fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'svg'%>
                                <img src="<%$comments[i]['upload_file']%>" class="upld_img" width="300px" style="width: 31%;" alt="">
                            <%/if%>
                        <%/if%>
                        <p class="displayemoji_comment" style="display:block;"><%$comment_text_format|nl2br%></p>
                    <%/if%>

                    <!--<p class="displayemoji_comment" style="display:none;"><%$comment_text_format|nl2br%></p>-->

                    <div class="like-reply-row">
                        <%if $comments[i]['count_comment_likes'] eq ''%>
                            <%assign var=showpostlike value=0%>
                        <%else%>
                            <%assign var=showpostlike value=$comments[i]['count_comment_likes']%>
                        <%/if%>
                        <div>
                            <a id="postlike_<%$comments[i]['post_comment_id']%>" href="javascript:void(0)" data-postid="<%$comments[i]['post_id']%>" data-postcommentid="<%$comments[i]['post_comment_id']%>" class="<%if $comments[i]['is_comment_like'] eq 1%>active <%else%>grey-link <%/if%> like-post act_likepostcomment" style="margin-right:7px;"><i class="fas fa-thumbs-up"></i></a> 
                            <a href="javascript:" class="disp_postcommentlikes" data-pageindex="" data-postid="<%$comments[i]['post_id']%>" data-postcommentid="<%$comments[i]['post_comment_id']%>" ><span data-commentlikescount="<%$showpostlike%>" id="commentlikes_count_<%$comments[i]['post_comment_id']%>"><%$showpostlike%> <%if $showpostlike eq 1%> Like<%else%> Likes<%/if%></span></a>
                        </div>
                        <div class="all-comment">  
                            <%assign var=showpostreplyarr value=$this->general->get_replylist_comment($comments[i]['post_comment_id'], $comments[i]['post_id'])%>
                            <a href="javascript:" class="grey-link show_replies" data-postcommentid="<%$comments[i]['post_comment_id']%>">
                                <i class="fas fa-comment-dots"></i> <span id="disp_replycount_<%$comments[i]['post_comment_id']%>"><%$showpostreplyarr|@count%> <%if $showpostreplyarr|@count eq 1%>Reply<%else%>Replies<%/if%></span>
                            </a>
                        </div>
                        <div class="reply-comments">
                            <a href="javascript:void(0);" class="postreply-link">Reply</a>
                        </div>
                        <div class="reply-comment-box" style="display:none;">
                            <textarea class="form-control reply_postcomment reply_comment_post_<%$comments[i]['post_id']%>" rows="1" placeholder="Reply Comment" data-postid="<%$comments[i]['post_id']%>" data-postcommentid="<%$comments[i]['post_comment_id']%>" name="replycommentad" id="replycommentad_<%$comments[i]['post_comment_id']%>"></textarea>
                            <span class="err_msg_<%$comments[i]['post_id']%>" style="font-size: 12px; color: #4e4c4c;"></span>

                            <span style="cursor:pointer;" class="open_reply_gif_section" data-gif-postid="<%$comments[i]['post_id']%>" data-gif-postcommentid="<%$comments[i]['post_comment_id']%>">GIF</span>
                            <span style="cursor:pointer;" class="open_reply_sticker_section" data-sticker-postid="<%$comments[i]['post_id']%>" data-sticker-postcommentid="<%$comments[i]['post_comment_id']%>">
                                sticker
                            </span>

                            <span style="cursor:pointer; margin-left:5px;" class="btn_post_media_attach">
                                <i class="fa fa-paperclip btn_reply_postmedia" data-postid="<%$comments[i]['post_id']%>" data-postcommentid="<%$comments[i]['post_comment_id']%>" style="font-size:18px;"></i>
                            </span>

                            <div class="upload_media_div" id="reply_media_div_<%$comments[i]['post_id']%>" style="display:none;">
                                <input type="file" name="upload_file" class="upload_media_input" data-post-id="<%$comments[i]['post_id']%>" id="reply_input_media_<%$comments[i]['post_id']%>" />
                            </div>

                            <div class="main_reply_gif_div_section reply_gif_section_<%$comments[i]['post_id']%>">
                                <input type="text" id="reply_searchInput_<%$comments[i]['post_id']%>" placeholder="Search for GIFs">
                                <a href="javascript:void(0);" class="reply_close_gif_div_<%$comments[i]['post_id']%>"><i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                <div class="reply_gif_picker_div_cls" id="reply_gifPicker_<%$comments[i]['post_id']%>"></div>
                            </div>
                        </div>
                        <div class="feed-comments  scrollbarContent scrolldefineheight feed_replies_<%$comments[i]['post_comment_id']%>" style="width:97%;display: none;">
                            <ul id="replycommentshow_<%$comments[i]['post_comment_id']%>">
                                <%include file="common/common_feed_replies.tpl"%>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
<%/section%>
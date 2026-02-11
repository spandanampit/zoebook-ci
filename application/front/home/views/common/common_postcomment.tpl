
<style>
.cmt-img {
    height: 50px !important;
    width: 50px !important;
    object-fit: cover;
    border-radius: 50px;
}
</style>

<%section name=i loop=$postcomment%>
<li class="child">
  <div class="comment">
    <div class="comment-pics">
      <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$postcomment[i]['profile_image']%>" alt="" style="height: 50px !important;" class="cmt-img"> 
    </div>
    <div class="comment-text">
      <div class="coment-heading">
        <a href="<%$this->general->setdiplayprofileurl($postcomment[i]['user_id'],$postcomment[i]['user_name'])%>" class="name"><h5><%$postcomment[i]['user_name']%></h5></a>
        <p><%time_elapsed_string($postcomment[i]['added_date'])%></p>
      </div>
      <%if $postcomment[i].user_id eq $this->session->userdata('iUserId') || $postinfo.posted_user_id eq $this->session->userdata('iUserId')%>
        <div style="width:7%;">
          <a href="javascript:" class="deletepostcomment" data-postid="<%$postcomment[i]['post_id']%>" data-postcommentid="<%$postcomment[i]['post_comment_id']%>" title="Delete"><i class="fas fa-trash"></i></a>
        </div>
      <%/if%>
      <div class="comment-text-wrap">
          <%*<%assign var=comment_text value=$this->general->makehttpclickable($postcomment[i]['comment'])%>*%>
          <%assign var=comment_text value=$this->general->linkify($postcomment[i]['comment'])%>
          <%assign var=comment_text_format value=removeEmoji($comment_text)%>

          <!-- Display GIF below the comment text -->
          <%if strpos($postcomment[i]['comment'], 'giphy.com') !== false%>
              <img src="<%$postcomment[i]['comment']%>" height="auto" width="33% !important" alt="" style="width: 33% !important">
          <%else%>
              <%if $postcomment[i]['upload_file'] neq ''%>
                  <img src="<%$postcomment[i]['upload_file']%>" class="upld_img" alt="">
                  <%assign var=fileExt value=pathinfo($postcomment[i]['upload_file'], PATHINFO_EXTENSION)%>
                  <%if $fileExt == 'mp4' || $fileExt == 'avi' || $fileExt == 'mkv' || $fileExt == 'mov'%>
                      <video controls height="auto" width="300px">
                          <source src="<%$postcomment[i]['upload_file']%>" type="video/mp4">
                          Your browser does not support the video tag.
                      </video>
                  <%elseif $fileExt == 'png' || $fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'svg'%>
                      <img src="<%$postcomment[i]['upload_file']%>" class="upld_img" width="300px" alt="">
                  <%/if%>
              <%/if%>
              <p class="displayemoji_comment"><%$comment_text_format|nl2br%></p> 
          <%/if%>
      </div>

      <div class="comment-like-reply">
        <%if $postcomment[i]['count_comment_likes'] eq ''%>
          <%assign var=showpostlike value=0%>
        <%else%>
          <%assign var=showpostlike value=$postcomment[i]['count_comment_likes']%>
        <%/if%>
        <ul class = "ul-comment-sec">
          <li>
            <a id="postlike_<%$postcomment[i]['post_comment_id']%>" href="javascript:void(0)" data-postid="<%$postcomment[i]['post_id']%>" data-postcommentid="<%$postcomment[i]['post_comment_id']%>" class="<%if $postcomment[i]['is_comment_like'] eq 1%>active <%else%>grey-link <%/if%> like-post act_likepostcomment" style="margin-right:7px;"><i class="fa-solid fa-thumbs-up"></i> 
              <a href="javascript:" class="disp_postcommentlikes" data-pageindex="" data-postid="<%$postcomment[i]['post_id']%>" data-postcommentid="<%$postcomment[i]['post_comment_id']%>" ><span data-commentlikescount="<%$showpostlike%>" id="commentlikes_count_<%$postcomment[i]['post_comment_id']%>"><%$showpostlike%></span><%if $showpostlike eq 1%><%$like%><%else%><%$likes%><%/if%></a>
            </a>
          </li>
          <%if $this->session->userdata('iUserId') neq ''%>     
            <div class="reply-comments">
                  <a href="javascript:void(0);" class="postreply-link"><%$reply%></a>
            </div>
          <%/if%>
              <div class="reply-comment-box" style="display:none; color:grey">
                <textarea class="form-control reply_postcomment" rows="1" placeholder="Reply Comment" data-postid="<%$postcomment[i]['post_id']%>" data-postcommentid="<%$postcomment[i]['post_comment_id']%>" data-mediaid="<%$mediaid%>" name="replycommentad" id="replycommentad_<%$postcomment[i]['post_comment_id']%>"></textarea>
                <span class="err_msg_<%$posts[i]['post_id']%>" style="font-size: 12px; color: #4e4c4c;"></span>
                <span style="font-size:15px;"><%$press_enter_to_reply%></span>
              </div>
        </ul>
        <div class="feed-comments  scrollbarContent scrolldefineheight" style="width:97%">
          <ul id="replycommentshow_<%$postcomment[i]['post_comment_id']%>">
            <%include file="common/common_replycomment.tpl"%>
          </ul>
        </div> 
      </div>
    </div>
  </div>
</li>
<%/section%>

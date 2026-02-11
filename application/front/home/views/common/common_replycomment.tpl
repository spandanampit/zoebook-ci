<style>
.img-fluid {
    height: 50px !important;
    width: 50px !important;
    object-fit: cover;
    border-radius: 50px;
}
</style>

<%section name=in loop=$showpostreplyarr%>
<li id="showreplyloader_<%$showpostreplyarr[in]['reply_id']%>" style="margin-right:14rem;">
  <div class="user-comments-row">
    <div class="comments-block">
      <div class="comments-user-row">
          <div class="comments-user-details">
              <i class="cmn-user-img">
                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$showpostreplyarr[in].profile_image%>" alt="" class="img-fluid">
              </i>
              <h6>
                  <a href="<%$this->general->setdiplayprofileurl($showpostreplyarr[in].user_id,$showpostreplyarr[in].user_name)%>" class="name"><%$showpostreplyarr[in].user_name%></a>

                  <div class="comments-time">
                    <%time_elapsed_string($showpostreplyarr[in].added_date)%>
                </div>
              </h6>
          </div> 
          <%if $showpostreplyarr[in].user_id eq $this->session->userdata('iUserId') || $postinfo.posted_user_id eq $this->session->userdata('iUserId')%>
          <div>
                <a href="javascript:" class="deletereplycomment" data-postid="<%$showpostreplyarr[in]['post_id']%>" data-postcommentid="<%$showpostreplyarr[in]['reply_id']%>" title="Delete"><i class="fas fa-trash"></i></a>
          </div>
          <%/if%>
      </div>
      <div class="user-comments">
        <%assign var=reply_text value=$this->general->linkify($showpostreplyarr[in].comment)%>
        <%assign var=reply_text_format value=removeEmoji($reply_text)%>
        <p><%$reply_text_format|nl2br%></p>
      </div>
    </div>
  </div>
</li>
<%/section%>
<%section name=in loop=$showpostreplyarr%>
    <li id="showreplyloader_<%$showpostreplyarr[in]['reply_id']%>" style="margin-right:25px;">
        <div class="user-comments-row">
            <div class="comments-block">
                <div class="comments-user-row">
                    <div class="comments-user-details">
                        <i class="cmn-user-img">
                            <a href="<%$this->general->setdiplayprofileurl($showpostreplyarr[in].user_id,$showpostreplyarr[in].user_name)%>" class="name">
                                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$showpostreplyarr[in].profile_image%>" alt="" class="img-fluid">
                            </a>
                        </i>
                        <h6>
                            <a href="<%$this->general->setdiplayprofileurl($showpostreplyarr[in].user_id,$showpostreplyarr[in].user_name)%>" class="name"><%$showpostreplyarr[in].user_name%></a>

                            <div class="comments-time">
                                <%time_elapsed_string($showpostreplyarr[in].added_date)%>
                            </div>
                        </h6>
                    </div>
                </div>
                <div class="user-comments">
                    <%assign var=reply_text value=$this->general->linkify($showpostreplyarr[in].comment)%>
                    <%assign var=reply_text_format value=removeEmoji($reply_text)%>

                    <%*<%if strpos($showpostreplyarr[in].comment, 'giphy.com') !== false%>
                        <img src="<%$showpostreplyarr[in].comment%>" height="auto" width="100px" alt="">
                    <%else%>
                        <p><%$reply_text_format|nl2br%></p>
                    <%/if%>*%>

                    <%if strpos($showpostreplyarr[in].comment, 'giphy.com') !== false%>
                        <img src="<%$showpostreplyarr[in].comment%>" height="auto" width="100px" alt="">
                    <%else%>
                        
                        <%if $showpostreplyarr[in].upload_file neq ''%>
                            
                            <%assign var=fileExt value=pathinfo($showpostreplyarr[in].upload_file, PATHINFO_EXTENSION)%>

                            <%if $fileExt == 'mp4' || $fileExt == 'avi' || $fileExt == 'mkv' || $fileExt == 'mov'%>
                                <video controls height="auto" width="300px">
                                    <source src="<%$showpostreplyarr[in].upload_file%>" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <%elseif $fileExt == 'png' || $fileExt == 'jpg' || $fileExt == 'jpeg' || $fileExt == 'svg'%>
                                <img src="<%$showpostreplyarr[in].upload_file%>" class="upld_img" width="300px" alt="">
                            <%/if%>

                        <%/if%>

                        <p><%$reply_text_format|nl2br%></p>
                        
                        
                    <%/if%>

                    
                </div>
            </div>
        </div>
    </li>
<%/section%>
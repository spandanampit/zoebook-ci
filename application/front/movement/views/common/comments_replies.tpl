<%foreach item=reply from=$comment['reply_details']%>
                                <li id="showreplyloader" style="margin-right:25px;">
                                <div class="user-comments-row">
                                    <div class="comments-block">
                                        <div class="comments-user-row">
                                            <div class="comments-user-details">
                                                <i class="cmn-user-img" style="min-width: 37px !important; height: 39px !important; width: 0px !important;">
                                                    <a href="" class="name">
                                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<%$reply['profile_image']%>" alt="" class="img-fluid" style="height: 4rem !important;">
                                                    </a>
                                                </i>
                                                <h6 style="display: flex;">
                                                    <a href="" class="name"><%$reply['user_name']%></a>
                            
                                                    <div class="comments-time"><%time_elapsed_string($reply['added_date'])%></div>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="user-comments">
                                            <p><%$reply['comment']%></p>
                                                <!--<video controls height="auto" width="300px">
                                                    <source src="" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>-->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <%/foreach%>
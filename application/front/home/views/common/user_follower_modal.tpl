<style>
.search-image {
    min-height: 12rem;
    max-height: 12rem; 
    object-fit: cover;
}
</style>

<ul> 
<%if $followarr|@count gt 0%>
<%if $isfromsearch neq ''%>
    <li style="font-size: 20px;color: green;font-weight: 500;">Search result for : "<%$isfromsearch%>"</li>
<%/if%>
<!--<%$row|print_r%>-->
        <section class="video-sec">
            <div class="container">
                <div class="row mb-40">
                    <div class="col-md-12">
                        <div class="video-grid">

                            <%foreach item=row key=i from=$browseprofile%>
                                <%if isset($row['iPostId'])%>
                                    <div class="video-item">
                                        <div class="video-box">
                                            <%assign var=jsonData value=$this->general->getSearchPostThumbnail($row['iPostId'])%>
                                            <%assign var=vUploadFile  value=substr($jsonData, strpos($jsonData, '"vUploadFile":"') + strlen('"vUploadFile":"'), strpos($jsonData, '"', strpos($jsonData, '"vUploadFile":"') + strlen('"vUploadFile":"')) - strpos($jsonData, '"vUploadFile":"') - strlen('"vUploadFile":"'))%>
                                            <%assign var=eMediaType  value=substr($jsonData, strpos($jsonData, '"eMediaType":"') + strlen('"eMediaType":"'), strpos($jsonData, '"', strpos($jsonData, '"eMediaType":"') + strlen('"eMediaType":"')) - strpos($jsonData, '"eMediaType":"') - strlen('"eMediaType":"'))%>
                                            <%assign var=vVideoThumbnail  value=substr($jsonData, strpos($jsonData, '"vVideoThumbnail":"') + strlen('"vVideoThumbnail":"'), strpos($jsonData, '"', strpos($jsonData, '"vVideoThumbnail":"') + strlen('"vVideoThumbnail":"')) - strpos($jsonData, '"vVideoThumbnail":"') - strlen('"vVideoThumbnail":"'))%>
                                            <%assign var=vCloudinary  value=substr($jsonData, strpos($jsonData, '"vCloudinary":"') + strlen('"vCloudinary":"'), strpos($jsonData, '"', strpos($jsonData, '"vCloudinary":"') + strlen('"vCloudinary":"')) - strpos($jsonData, '"vCloudinary":"') - strlen('"vCloudinary":"'))%>
                                            <%assign var=iUserId  value=substr($jsonData, strpos($jsonData, '"iUserId":"') + strlen('"iUserId":"'), strpos($jsonData, '"', strpos($jsonData, '"iUserId":"') + strlen('"iUserId":"')) - strpos($jsonData, '"iUserId":"') - strlen('"iUserId":"'))%>
                                            <%assign var=vSourceType  value=substr($jsonData, strpos($jsonData, '"vSourceType":"') + strlen('"vSourceType":"'), strpos($jsonData, '"', strpos($jsonData, '"vSourceType":"') + strlen('"vSourceType":"')) - strpos($jsonData, '"vSourceType":"') - strlen('"vSourceType":"'))%>

                                            <div class="video-img-box">
                                                <a href="<%$this->general->setdiplayposturl($row['iPostId'],$row['tPostTextEmoji'])%>">
                                                    <%if $eMediaType eq 'Image'%>
                                                        <img class="search-image" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$iUserId%>/<%$vUploadFile%>" alt="Image 1" >
                                                    <%elseif $eMediaType eq 'Video'%>
                                                        <%if $vSourceType eq 'aws'%>
                                                            <%assign var=vVideoThumbnailExtension value=substr($vVideoThumbnail, strrpos($vVideoThumbnail, '.') + 1)%>
                                                            <%if $vVideoThumbnailExtension eq 'mp4'%>
                                                                <img class="search-image " src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture Image 2">
                                                            <%else%>
                                                                <img class="search-image " src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<%$iUserId%>/<%$vVideoThumbnail%>" alt="Image 2">
                                                            <%/if%>
                                                        <%elseif $vSourceType eq 'cld' %>
                                                            <img class="search-image" src="<%$vCloudinary%>" alt="">
                                                        <%else%>
                                                            <img class="search-image" src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture Image 3">
                                                        <%/if%>
                                                    <%else%>
                                                        <img class="search-image" src="<%$this->config->item('images_url')%>noimage.gif" alt="Default profile picture ">
                                                    <%/if%>
                                                </a>
                                            </div>
                                            <div class="video-content">
                                                <a style="line-height: 43px;" data-id="<%$row['iPostId']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($row['iPostId'],$row['tPostText'])%>">
                                                    <%assign var=posted_text_withouemoji value=removeEmoji($row['tPostTextEmoji'])%>
                                                    <%assign var=posted_sub_text value=$this->general->truncateChars($posted_text_withouemoji,30)%>
                                                    <p><%$this->general->displayposttext($posted_sub_text)%></p>
                                                </a>
                                                <div class="video-view">
                                                    <ul>
                                                    <li class="yellow-color"><%$row.iImpressionCount%> Views</li>
                                                    <li class="dot"></li>                                          
                                                    <li class="sub-color"><%time_elapsed_string($row.dAddedDate)%></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <%else%>
                                    <div class="video-item">
                                        <div class="video-box">
                                            <div class="video-img-box" style="border-radius: 50%; height: 12rem; width: 88%">
                                                <a href="<%$this->general->setdiplayprofileurl($row['u_users_id'], $row['u_name'])%>">
                                                    <img class="search-image" src="<%$row['u_profile_image']%>" alt="">
                                                </a>
                                            </div>
                                            <div class="video-content">
                                                <!--<div class="video-heading">
                                                    <h3>It is a long established</h3>
                                                    <a href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                </div>-->
                                                <a href="<%$this->general->setdiplayprofileurl($row['u_users_id'], $row['u_name'])%>">
                                                    <p><strong><%$row['u_name']%></strong></p>
                                                    <p class="follower-tilte"style="color:#e8790a"><strong>Followers: <%$row['follower_count']%></strong></p>
                                                    <p class="follower-tilte"style="color:#e8790a"><strong>Following: <%$row['following_count']%></strong></p>
                                                </a>
                                                <div class="follow-button">
                                                    <%if $row['u_users_id'] neq $this->session->userdata('iUserId')%>
                                                        <%if $row['pending_request_id'] neq '' && $userinfo.is_follwing eq 'Pending'%>
                                                            <a href="javascript:" class="btn btn-secondary act_cancelfollowrequest" data-id="<%$row['u_users_id']%>" data-pendingrequestid="<%$row['pending_request_id']%>">Cancel</a>
                                                        <%else if $row['pending_request_id'] neq ''%>
                                                            <a href="javascript:" class="btn btn-secondary act_unfollowuser" data-id="<%$row['u_users_id']%>" >Unfollow</a>
                                                        <%else%>
                                                            <a href="javascript:" class="btn btn-primary act_followuser" data-id="<%$row['u_users_id']%>" style="background-color: #e8790a; border-color:#e8790a;">Follow</a>
                                                        <%/if%>
                                                        <div id="followactionmsg_<%$row['u_users_id']%>"></div>
                                                    <%else%>
                                                        <span style="color:white;">Follow not needed</span>
                                                    <%/if%>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <%/if%>
                            <%/foreach%>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<%if $currentpage eq 1 && $nextpage neq 0%>
<li  style="padding-left:285px;padding-bottom:30px;" id="loadmoreresult" data-currentpage="<%$getindex%>">
    <!--<a href="javascript:" class="btn btn-secondary">Load More Results ..</a>-->
    <br>
</li>
<%/if%>
<%else%>
<li>
    <div style="text-align:center;width:100%;color:green;">No user found in the list</div>
</li>
<%/if%>
</ul>
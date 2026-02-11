<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<%$this->css->css_src()%>
<div class="post-pages post-details-page" id="post_detailpage">
    <div class="container">
        <div class="row">
            <%if $errormsg neq ''%>
                <div style="width:74%;font-size:25px;color:red;text-align:center;padding-top:100px;">
                    <%$errormsg%>
                </div>
            <%else%>
            <div class="col-lg-9">
                <%if $postmedia|@count gt 0%>
                <div class="images-slider-block autoheight">
                    <div id="media-slider" class="owl-carousel owl-theme media-slider">
                         <%foreach item=row key=i from=$postmedia%>
                         <div class="item" data-getmediaid="<%$row['post_media_id']%>" data-getpostid="<%$row['post_id']%>">
                             <%if $row['pm_media_type'] eq 'Video'%>
                                <video class="plyr-video" width="100%" height="100%" controls data-poster="<%$row['pm_video_thumbnail']%>"> 
                                    <source src="<%$row['upload_file']%>" type="video/mp4">
                                </video>
                             <%else%>
                             <img src="<%$row['upload_file']%>" alt="">
                             <%/if%>
                         </div>
                         <%/foreach%>
                    </div>
                </div>
                <%/if%>
                <span id="inner_postdetail">
                <%include file="common/common_postdetail.tpl"%>
                </span>
            </div>
            <%/if%>

            <div class="col-lg-3">
                <div class="block-title">Other</div>
                <div class="post-listing">
                    <ul>
                        <%if $otherpost|@count gt 0%>
                        <%foreach item=row key=i from=$otherpost%>
                        <%$this->general->updateotherpost_impression(<%$row['p_post_id']%>,<%$row['p_user_id']%>)%>
                        <li>
                            <i>
                            <%if $row['um_media_type'] eq 'Image'%>
                                <a href="<%$this->general->setdiplayposturl($row['p_post_id'],$row['p_post_text'])%>" class="otherpost_act" data-otherpostid="<%$row['p_post_id']%>" >
                                <img src="<%$row['um_upload_file']%>" alt="">
                                </a>
                            <%else if $row['um_media_type'] eq 'Video'%>
                            <a href="<%$this->general->setdiplayposturl($row['p_post_id'],$row['p_post_text'])%>" class="otherpost_act" data-otherpostid="<%$row['p_post_id']%>" >
                                <div style="position:relative">
                                    <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;">
                                    </div>
                                    <div>
                                        <video class="plyr-video-1 othervideoduration withlink" width="100%" height="100%"  preload="metadata"> 
                                            <source src="<%$row['um_upload_file']%>#t=0.30" type="video/mp4">
                                        </video>
                                    </div>
                                </div>
                                </a>
                            <%else%>
                                <img src="public/images/noimage-small.gif" alt="">
                            <%/if%>
                            </i>
                            <div class="small-post-details">
                                <%assign var=posted_text value=$this->general->truncateChars(removeEmoji($row['p_post_text']), 80)%>
                                <h5><a href="<%$this->general->setdiplayposturl($row['p_post_id'],$row['p_post_text'])%>" class="otherpost_act" data-otherpostid="<%$row['p_post_id']%>" ><%$this->general->displayposttext($posted_text)%></a></h5>
                                <h6><%time_elapsed_string($row['p_added_date'])%></h6>
                                <div class="time-view"><%$row['p_impression_count']%> views</div>
                            </div>
                        </li>
                        <%/foreach%>
                        <%else%>
                        <li>
                            Not found any other post
                        </li>
                        <%/if%>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade cmn-modal create-post-modal" id="reportPostdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Report Post</h5>
            </div>
            <form class="cmn-form" id="form_report_postdetail" method='post'>
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
                    <button type="button" id="submit_report_postdetail" class="btn btn-primary">Report</button>
                </div>
            </form>            
        </div>
    </div>
</div>
<div class="modal fade cmn-modal create-post-modal" id="sharePostdetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Share This Post</h5>
            </div>
            <form id="form_share_postdetail" method='post'>
                <input type="hidden" name="share_post_id" id="share_post_id" value=""/>
                <div class="modal-body">
                    <div class="upload-text">
                        <i class="cmn-user-img">
                            <img src="<%$userinfo.u_profile_image%>" alt="">
                        </i>
                        <textarea name="share_post_text" id="share_post_text" class="form-control" rows="5" placeholder="What’s on your mind?"></textarea>
                    </div>
                    <div class="error-msg-form" id='share_post_textErr'></div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="share_timeline_postdetail" class="btn btn-primary">Share on My Timeline</button>
                </div>
            </form>            
        </div>
    </div>
</div>
<%include file="common/common_editpost.tpl" %>
<%$this->js->add_js("front/post_detail.js")%>
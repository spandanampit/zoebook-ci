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
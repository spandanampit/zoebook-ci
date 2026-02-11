<div class="video-dash-post mb-20 feed_item" style="height: 34rem;">
      <div class="top-playlist-heading">
            <p class="create-text">
                  <a style="color: #FF8D00;" href="#" data-toggle="modal" data-target="#playlistModal"><%$create%></a>
            </p>
            <p style="color: #FF8D00;"><%$top_play_list%></p>
      </div>
      <div class="swiper-container top-playlist">
            <div class="swiper-wrapper" id="playlist-wrapper">
                  <%foreach item=row from=$playlist_post%>
                        <div class="swiper-slide item" style="margin-right: 0px !important;">
                              <div class="tp-playlist-media" style="height: 29rem;">
                                    <a href="<%$this->url->make('content/content/playlistshare')%>?playlistId=<%$row['playlist_id']%>&userId=<%$row['playlist_userId']%>">
                                          <%if $row['main_media'][0]['full_thumbnail_url'] %>
                                                <video width="100%" height="100%" preload="auto" poster="<%$row['main_media'][0]['full_thumbnail_url']%>" style="object-fit: cover;"muted>
                                                </video>
                                          <%else%>
                                                <video width="100%" height="100%" preload="auto" poster="<%$row['main_media'][0]['full_thumbnail_url']%>" style="object-fit: cover;"muted>
                                                      <source src="<%$row['main_media'][0]['vUploadFile']%>" type="video/mp4">
                                                </video>
                                          <%/if%>
                                    </a>
                              </div>
                              <div class="tp-user-image">
                                    <img src="<%$row['main_media'][0]['u_profile_image']%>">
                                    <h6 class="top-usename"><%$row['main_media'][0]['u_name']%></h6>
                              </div>
                        </div>
                  <%/foreach%>
            </div>
      </div>
      <div class="slider-nav">
            <div class="swiper-button-prev custom-slider-nav"></div>
            <div class="swiper-button-next custom-slider-nav"></div>
      </div>
      
      <div class="swiper-pagination"></div>
</div>


<!--Feed_list.tpl, top_play_list.tpl, home.php, routes.php, Playlist_model.php !>
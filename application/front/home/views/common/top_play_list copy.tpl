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
            <div class="swiper-pagination"></div>
      </div>
</div>

<script>
let playlistLoaderInitialized = false;

window.onload = function () {
    if (playlistLoaderInitialized) return;
    playlistLoaderInitialized = true;

    let pageIndex = 2;
    let globalIndex = 5;
    let swiperInstance;
    
    const intervalId = setInterval(function () {
        console.log('Hitting AJAX with pageIndex:', pageIndex);

        $.ajax({
            url: '/getMorePlaylist',
            method: 'POST',
            contentType: 'application/x-www-form-urlencoded',
            dataType: 'json',
            data: { pageIndex: pageIndex },
            success: function (data) {
                console.log('Response for pageIndex', pageIndex, data);

                if (!data || !Array.isArray(data) || data.length === 0) {
                    console.log('No more data or invalid. Clearing interval.');
                    clearInterval(intervalId);
                    return;
                }

                for (let i = 0; i < data.length; i++) {
                    const post = data[i];
                    const media = post.main_media?.[0] || {};
                    const thumbnail = media.full_thumbnail_url || '';
                    const videoSrc = media.vUploadFile || '';
                    const profileImage = media.u_profile_image || '';
                    const userName = media.u_name || '';

                    const ariaLabel = `${globalIndex + 1} / 800`;
                    const postHtml = `
                        <div class="swiper-slide item" style="width: 172px; margin-right: 10px;" role="group" aria-label="${ariaLabel}" data-swiper-slide-index="${globalIndex}">
                            <div class="tp-playlist-media" style="height: 29rem;">
                                <a href="content/content/playlistshare?playlistId=${post.playlist_id}&userId=${post.playlist_userId}">
                                    <video width="100%" height="100%" preload="auto" poster="${thumbnail}" style="object-fit: cover;" muted ${thumbnail ? '' : `><source src="${videoSrc}" type="video/mp4">`} </video>
                                </a>
                            </div>
                            <div class="tp-user-image">
                                <img src="${profileImage}">
                                <h6 class="top-usename">${userName}</h6>
                            </div>
                        </div>`;

                    $('#playlist-wrapper').append(postHtml);
                    globalIndex++;
                }
                pageIndex++;
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', error);
                clearInterval(intervalId);
            }
        });
    }, 5000); // 5 seconds
};
</script>
<!--Feed_list.tpl, top_play_list.tpl, home.php, routes.php, Playlist_model.php !>
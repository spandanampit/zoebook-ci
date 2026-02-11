
<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}

    .fade-in {
      animation: fadeIn 3s;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .plyr__controls {
      display: none;
    }

    .plyr__play-large {
      display: none !important;
    }

    .playerembed {
      min-height: 12rem;
      max-height: 12rem;
    }
    .swiper-pagination-bullet {
      background-color: white;
    }

    .swiper-pagination-bullet-active {
      background-color: white;
    }

    .swiper-button-next, .swiper-button-prev {
      color: white; 
    }

    .swiper-slide {
      position: relative;
    }


    .swiper-slide::before,
    .swiper-slide::after {
      content: '';
      position: absolute;
      top: 0;
      bottom: 0;
      width: 590px; /* Adjust width as needed */
      z-index: 2;
    }

    .swiper-slide::before {
      left: 0;
      background: linear-gradient(to right, rgba(0, 0, 0, 1), transparent); /* Increase the alpha value for higher opacity */
    }

    .swiper-slide::after {
      right: 0;
      background: linear-gradient(to left, rgba(0, 0, 0, 1), transparent); /* Increase the alpha value for higher opacity */
    }
    .swiper-slide::top,
    .swiper-slide::bottom {
      left: 0;
      right: 0;
      height: 100px; 
      position: absolute;
    }

    .swiper-slide::top {
      top: 0;
      background: linear-gradient(to bottom, rgba(0, 0, 0, 0.9), transparent);
    }

    .swiper-slide::bottom {
      bottom: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
    }

    .text_post {
      position: absolute;
      top: 17rem;
      z-index: 4;
      width: 50%;
      left: 13%;
      font-size: 23px;
      color: white;
    }

    .video-watch {
      position: absolute;
      top: 21rem;
      z-index: 4;
      width: 10%;
      left: 13%;
    }
</style>


<section class="watch-sec" style="background: black;">
  <div class="container">
    <%assign var="suggestions" value=$this->general->get_user_suggestions()%>
    <%assign var="count" value=0%>

    <!-- Swiper -->
    <div class="swiper-container">
      <div class="swiper-wrapper">
        <%foreach item=row from=$most_views_video%>
          <%if $count < 10 %>
          <div class="swiper-slide" data-post-id="<%$row.post_id%>">
            <a href="<%$row.link%>" class="swiper-slide-link">
              <div class="swiper-slide-inner">
                <div class="item">
                  <div class="video-widget-box">
                    <div class="banner-box">
                      <div class="row align-items-center">
                        <div class="col-lg-8">
                          <div class="banner-content-2">
                            <%assign var=posted_text_withouemoji value=removeEmoji($row.post_details.0.tPostTextEmoji)%>
                            <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                            <h3 id="post-title" style="font-size: 28px; display: none;"><%$this->general->displayposttext($posted_text)%></h3>
                          </div>
                        </div>
                        
                        <div class="col-lg-4">
                          <!-- Optional content for the right column can go here -->
                        </div>
                      </div>
                    </div>
                    <video class="playlist-video" width="100%" height="100%" muted preload="auto" data-poster="<%$row.video_thumbnail%>" style="object-fit: cover;">
                      <source src="<%$row.upload_file%>" type="video/mp4">
                    </video>
                  </div>
                </div>
              </div>
            </a>
          </div>
          <p style="display: none"><%$count++%></p>
          <%/if%>
        <%/foreach%>
      </div>
      <!-- Add Pagination -->
      <div class="swiper-pagination"></div>
      <!-- Add Navigation -->
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
      <%assign var=posted_text_withouemoji value=removeEmoji($most_views_video.0.post_details.0.tPostTextEmoji)%>
      <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
      <div class="text_post" ><%$this->general->displayposttext($posted_text)%></div>
      <!-- Watch button (updated dynamically by JavaScript) -->
      <a href="https://zoebook.com/post-detail-<%$most_views_video.0.post_id%>.html" class="btn-watch"><div class="btn btn-warning video-watch"><%$watch%></div></a>
    </div>
  </div>
</section>




   <!-- video section start -->
   <section class="video-sec">
    <div class="container">
      <div class="row align-items-center mb-35">
        <div class="col-md-8 col-7">
          <div class="title-heading-2">
            <h2><%$most_viewd_videos%></h2>
          </div>
        </div>
      </div>
      <div class="row mb-40">
        <div class="col-md-12">
          <div class="video-grid">
          <%assign var="suggestions" value=$this->general->get_user_suggestions()%>
          <%assign var="count" value=0%>
          <%foreach item=row from=$most_views_video%>
            <%if $count < 10 %>
            <div class="video-item">
            <!--<%$row.post_id%>
            <%$row['post_details'][0]['tPostText']%>-->
              <a data-id="<%$row.post_id%>" data-loop="<%$row%>" href="<%$this->general->setdiplayposturl(<%$row.post_id%>,$row['post_details'][0]['tPostText'])%>">
                <div class="video-box">
                  <div class="video-img-box">
                  <%if $row.media_type eq 'Image'%>
                    <img src="<%$row.upload_file%>" alt="">
                  <%else%>
                  <video class="playerembed" width="100%" height="100%" preload="metadata" data-poster="<%$row.video_thumbnail%>" style="object-fit: cover;" controls muted>
                      <source src="<%$row.upload_file%>" type="video/mp4">
                      Your browser does not support the video tag.
                  </video>
                  <%/if%>
                  </div>
                  <div class="video-content">
                    <div class="video-heading">
                      <%assign var=posted_text_withouemoji value=removeEmoji($row.post_details.0.tPostTextEmoji)%>
                      <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                      <h3><%$this->general->displayposttext($posted_text)%></h3>
                      
                      <%if $this->session->userdata('iUserId')%>
                        <%if $row.media_type eq 'Video'%>
                          <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" data-postid="<%$row.post_id%>" onclick="addToPlaylist(<%$row.post_id%>)"><%$add_to_playlist%></a>
                        </div>
                        <%/if%>
                      <%/if%>
                      </div>
                      <%assign var=posted_sub_text value=$this->general->truncateChars($posted_text_withouemoji,60)%>
                      <div class="video-view">
                        <ul>
                          <li class="yellow-color"><%$row.views_count%> <%$views%></li>
                        <li class="dot"></li>                                          
                          <li class="sub-color"><%time_elapsed_string($row.added_date)%></li>
                        </ul>
                    </div>
                  </div>
                </div>
              </a>
            </div>
            <p style="display: none"><%$count++%></p>
            <%/if%>
          <%/foreach%>
          </div>
        </div>
      </div>


      <div class="row align-items-center mb-35">
        <div class="col-md-8 col-7">
          <div class="title-heading-2">
            <h2><%$newest_video%></h2>
          </div>
        </div>
      </div>
      <div class="row mb-40">
        <div class="col-md-12">
          <div class="video-grid">
          <%assign var="suggestions" value=$this->general->get_user_suggestions()%>
          <%assign var="count" value=0%>
          <%foreach item=row from=$recent_videos%>
          <%if $count < 10 %>
            <div class="video-item">
            <a data-id="<%$row.post_id%>" data-loop="<%$row%>" href="<%$this->general->setdiplayposturl(<%$row.post_id%>,$row['post_details'][0]['tPostText'])%>">
              <div class="video-box">
                <div class="video-img-box">
                  <%if $row.media_type eq 'Image'%>
                    <img src="<%$row.upload_file%>" alt="">
                  <%else%>
                    <video id="playlist-video<%$row.iPostMediaId%>" class="playerembed" width="100%" height="100%" preload="auto" data-poster="<%$row.video_thumbnail%>" style="object-fit: cover;"loop muted>
                        <source src="<%$row.upload_file%>" type="video/mp4">
                    </video>
                  <%/if%>
                </div>
                <div class="video-content">
                  <div class="video-heading">
                  <%assign var=posted_text_withouemoji value=removeEmoji($row.post_details.0.tPostTextEmoji)%>
                  <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                  <h3><%$this->general->displayposttext($posted_text)%></h3>
                  <%if $this->session->userdata('iUserId')%>
                    <%if $row.media_type eq 'Video'%>
                      <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" data-postid="<%$row.post_id%>" onclick="addToPlaylist(<%$row.post_id%>)"><%$add_to_playlist%></a>
                    </div>
                    <%/if%>
                  <%/if%>
                  </div>
                  <div class="video-view">
                    <ul>
                      <li class="yellow-color"><%$row.views_count%> <%$views%></li>
                      <li class="dot"></li>
                      <li class="sub-color" ><%time_elapsed_string($row.added_date)%></li>
                    </ul>
                  </div>
                </div>
              </div>
            </a>
            </div>
            <p style="display: none"><%$count++%></p>
            <%/if%>
          <%/foreach%>
          </div>
        </div>
      </div>
      <div class="row align-items-center mb-35">
        <div class="col-md-8">
          <div class="title-heading-2">
            <h2>Trending</h2>
          </div>
        </div>
        <div class="col-md-4">
        </div>
      </div>
      <div class="row mb-30">
        <div class="col-lg-8">
          <div class="trend-box">
            <video id="playlist-video<%$row.iPostMediaId%>" class="" width="100%" height="100%" muted preload="auto" data-poster="<%$vp_video[1]['video_thumbnail']%>" style="object-fit: cover;" muted>
                <source src="<%$vp_video[1]['upload_file']%>" type="video/mp4">
            </video>
            <div class="trend-content">
              <%assign var=posted_text_withouemoji value=removeEmoji($vp_video[1]['post_details'][0].tPostTextEmoji)%>
              <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
              <%assign var=posted_sub_text value=$this->general->truncateChars($posted_text_withouemoji,60)%>
              <h3><%$this->general->displayposttext($posted_text)%></h3>
              <a href="#">Explore the Collection</a>
              <div class="col-lg-8">
                  <div class="banner-content-2" id="action-feed">
                      <div class="banner-like-box">
                          <ul id="like-comment-share">
                              <li onclick="postlike(<%$vp_video[1]['post_id']%>)" style="display: flex;">
                                  <i class="fa-solid fa-thumbs-up"></i> &nbsp; &nbsp;<p class="like-count"><%$likeCount%> 1</p> 
                              </li>
                              
                              <li onclick="postlike(<%$vp_video[1]['post_id']%>, 1)" style="display: flex;">
                                  <i class="fa-solid fa-thumbs-down" style="display: flex;"></i> &nbsp; &nbsp;<p class="unlike-count"><%$unlikeCount%></p>
                              </li>
                              
                              <li>
                                  <i class="fa-solid fa-share" onclick="generateShareLink(<%$playlist_details[0].id%>, <%$playlist_details[0].user_id%>)"></i> <%$share%>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
            </div>
            
          </div>
        </div>
        <div class="col-lg-4">
          <div class="trend-list-box">
          <%assign var="suggestions" value=$this->general->get_user_suggestions()%>
          <%assign var="count" value=0%>
          <%foreach item=row from=$vp_video%>
            <%if $count < 4 %>
            <div class="trend-list">
            <a data-id="<%$row['post_id']%>" data-loop="<%$row%>" href="<%$this->general->setdiplayposturl($row['post_id'],$row['post_details'][0]['tPostText'])%>">
              <div class="trend-list-img">
                <video id="playlist-video<%$row.post_media_id%>" class="playerembed" width="100%" height="100%" muted preload="auto"  data-poster="<%$row['video_thumbnail']%>" style="object-fit: cover;" muted>
                  <source src="<%$row['upload_file']%>" type="video/mp4">
                </video>
              </div>
            </a>
              <div class="trend-list-content">
                <%assign var=posted_text_withouemoji value=removeEmoji($row['post_details'][0].tPostTextEmoji)%>
                <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                <%assign var=posted_sub_text value=$this->general->truncateChars($posted_text_withouemoji,60)%>
                <h4><%$this->general->displayposttext($posted_text)%></h4>
                <div class="video-view">
                    <ul>
                      <li class="yellow-color"><%$row.views_count%> <%$views%></li>
                    <li class="dot"></li>                                          
                      <li class="sub-color"><%time_elapsed_string($row.added_date)%></li>
                    </ul>
                  </div>
              </div>
            </div>
            <p style="display: none"><%$count++%></p>
            <%/if%>
          <%/foreach%>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="video-grid">
          <%foreach item=row from=$vp_video%>
            <div class="video-item content">
            <a data-id="<%$row.post_id%>" data-loop="<%$row%>" href="<%$this->general->setdiplayposturl(<%$row.post_id%>,$row['post_details'][0]['tPostText'])%>">
              <div class="video-box">
                <div class="video-img-box">
                <video id="playlist-video<%$row.post_media_id%>" class="playerembed trending-video" width="100%" height="100%" muted preload="auto" data-poster="<%$row['video_thumbnail']%>" style="object-fit: cover;" muted>
                  <source src="<%$row['upload_file']%>" type="video/mp4">
                </video>
                </div>
                <div class="video-content">
                  <div class="video-heading">
                  <%assign var=posted_text_withouemoji value=removeEmoji($row['post_details'][0].tPostTextEmoji)%>
                  <%assign var=posted_text value=$this->general->truncateChars($posted_text_withouemoji,40)%>
                  <%assign var=posted_sub_text value=$this->general->truncateChars($posted_text_withouemoji,60)%>
                    <h3><%$this->general->displayposttext($posted_text)%></h3>
                    <%if $this->session->userdata('iUserId')%>
                    <%if $row.media_type eq 'Video'%>
                      <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" data-postid="<%$row.post_id%>" onclick="addToPlaylist(<%$row.post_id%>)"><%$add_to_playlist%></a>
                    </div>
                    <%/if%>
                  <%/if%>
                  </div>
                  <div class="video-view">
                    <ul>
                      <li class="yellow-color"><%$row.views_count%> <%$views%></li>
                    <li class="dot"></li>                                          
                      <li class="sub-color"><%time_elapsed_string($row.added_date)%></li>
                    </ul>
                  </div>
                </div>
              </div>
            </a>
            </div>
          <%/foreach%>
          </div>
          <div class="load-more-box">
            <a href="#" id="loadMore" class="load-btn"><%$view_more%>...</a>
          </div>
        </div>
      </div>
    </div>
   </section>
  <%$this->js->add_js("front/posts.js")%>

   <!-- video section end -->
    <a href="#" class="scrollToTop"><i class="fa-solid fa-angle-up"></i></a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      effect: 'fade',
      fadeEffect: {
        crossFade: true
      },
      speed: 3000, // Set transition duration to 2000ms (2 seconds)
      autoplay: {
        delay: 3000, // Set autoplay delay to 3000ms (3 seconds)
        disableOnInteraction: false // Continue autoplay after user interactions
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      breakpoints: {
        640: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        768: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
        1024: {
          slidesPerView: 1,
          spaceBetween: 0,
        },
      },
      on: {
        slideChange: function () {
          var activeSlide = this.slides[this.activeIndex];
          var postId = activeSlide.getAttribute('data-post-id');

          var watchButton = document.querySelector('.btn-watch');
          var anchorTag = watchButton.querySelector('a');
          watchButton.href = '/post-detail-' + postId + '.html';

          var postText = activeSlide.querySelector('#post-title').textContent.trim(); 
          var text_post = document.querySelector('.text_post');
          text_post.textContent = postText; 
        }
      }
    });
  });
</script>

<script>
    $(document).ready(function(){
        $('.slider').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 2000,
            dots: true,
            arrows: true
        });

        console.log('hefffllo');
    });
    function addToPlaylist(postId) {
        console.log(postId);
        var url = "<%$this->url->make('content/content/addToPlaylist')%>"
        $.ajax({
            url: url,
            type: "POST",
            data: { postId: postId },
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    console.log("Video added to playlist successfully!");
                    var successMessage = document.createElement('div');
                    successMessage.textContent = "Video added to playlist successfully!";
                    successMessage.style.position = 'fixed';
                    successMessage.style.top = '20px';
                    successMessage.style.left = '50%';
                    successMessage.style.transform = 'translateX(-50%)';
                    successMessage.style.backgroundColor = '#dff0d8';
                    successMessage.style.padding = '10px';
                    successMessage.style.border = '1px solid #3c763d';
                    successMessage.style.borderRadius = '5px';
                    successMessage.style.zIndex = '9999';
                    
                    document.body.appendChild(successMessage);
                    
                    setTimeout(function() {
                        document.body.removeChild(successMessage);
                    }, 5000);
                } else {
                    console.error("Error adding video to playlist:", response.message);
                    var errorMessage = document.createElement('div');
                    errorMessage.textContent = "Video added to playlist successfully!";
                    errorMessage.style.position = 'fixed';
                    errorMessage.style.top = '20px';
                    errorMessage.style.left = '50%';
                    errorMessage.style.transform = 'translateX(-50%)';
                    errorMessage.style.backgroundColor = '#ff0000';
                    errorMessage.style.padding = '10px';
                    errorMessage.style.border = '1px solid #3c763d';
                    errorMessage.style.borderRadius = '5px';
                    errorMessage.style.zIndex = '9999';
                    
                    document.body.appendChild(errorMessage);
                    
                    setTimeout(function() {
                        document.body.removeChild(errorMessage);
                    }, 5000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const videos = document.querySelectorAll('.playerembed');

        videos.forEach(video => {
            video.addEventListener('mouseenter', () => {
            video.play();
            });

            video.addEventListener('mouseleave', () => {
            video.pause();
            video.currentTime = 0;
            });
        });
    });
    
    // document.addEventListener('DOMContentLoaded', function() {
      
    // var suggestions = <%json_encode($vp_video)%>;
    // var base_url = "https://zoebook.com/post-detail";
    // console.log('Suggestions:', suggestions);

    // var currentIndex = 0;

    // function changeVideoAttributes() {
    //     var videoLink = document.getElementById('video-link');
    //     var videoElement = document.getElementById('playlist-video');
    //     var sourceElement = document.getElementById('video-source');
    //     var postTitle = document.getElementById('post-title');

    //     var currentVideo = suggestions[currentIndex];
    //     // console.log('Current Video:', currentVideo);

    //     var postDetails = currentVideo.post_details[0];
    //     var postText = encodeURIComponent(postDetails.tPostText);
    //     var truncatedPostText = postText.length > 40 ? postText.substring(0, 30) + '...' : postText;
    //     // var urlDecodedText = safeDecodeURIComponent(truncatedPostText);
    //     var postId = currentVideo.post_id;
    //     var displayImage = currentVideo.display_image;
    //     var videoSrc = currentVideo.src;
        
    //     var encodedPostId = btoa(postId); // Base64 encoding

    //     videoLink.setAttribute('data-id', postId);
    //     // console.log(`${base_url}-${postId}.html`);
    //     videoLink.href = `${base_url}-${postId}.html`;

    //     // postTitle.innerHTML = urlDecodedText.replace(/\\u([\dA-F]{4})/gi, 
    //     // (match, grp) => String.fromCharCode(parseInt(grp, 16)));

    //     postTitle.innerHTML = safeDecodeAndReplaceUnicode(truncatedPostText);

    //     videoElement.setAttribute('poster', displayImage);
    //     sourceElement.src = videoSrc;

    //     videoElement.classList.remove('fade-in');
    //     void videoElement.offsetWidth; // Trigger reflow to restart the animation
    //     videoElement.classList.add('fade-in');

    //     videoElement.load(); // Reload the video element to reflect the new source

    //     currentIndex = (currentIndex + 1) % suggestions.length;
    // }

    // // function safeDecodeAndReplaceUnicode(encodedText) {
    // //     let urlDecodedText = decodeURIComponent(encodedText);
    // //     let fullyDecodedText = urlDecodedText.replace(/\\u([\dA-F]{4})/gi, 
    // //         (match, grp) => String.fromCharCode(parseInt(grp, 16)));
    // //     return fullyDecodedText;
    // // }

    // function safeDecodeAndReplaceUnicode(encodedText) {
    //     let urlDecodedText = encodedText;
    //     try {
    //         let previousText;
    //         do {
    //             previousText = urlDecodedText;
    //             urlDecodedText = decodeURIComponent(urlDecodedText);
    //         } while (previousText !== urlDecodedText);
    //     } catch (e) {
    //         console.error("Error decoding URI component:", e);
    //     }
        
    //     let fullyDecodedText = urlDecodedText.replace(/\\u([\dA-F]{4})/gi, 
    //         (match, grp) => String.fromCharCode(parseInt(grp, 16)));
            
    //     let tempDiv = document.createElement("div");
    //     tempDiv.innerHTML = fullyDecodedText;
    //     fullyDecodedText = tempDiv.innerText || tempDiv.textContent;

    //     return fullyDecodedText;
    // }

    // setInterval(changeVideoAttributes, 4000);

    // document.querySelectorAll('video').forEach(video => {
    //     video.removeAttribute('controls');
    // });
  // });

    function postlike(postId=0) {
      console.log(postId);
        var url = "<%$this->url->make('content/content/playlistLike')%>"
        $.ajax({
            type: 'POST',
            url: url,
            data: { playlistId: playlistId, likeId: likeId },
            success: function(response) {
                console.log(response);
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    var newCount = jsonResponse.newLikeCount;
                    var newUnlikeCount = jsonResponse.unlikeCount;
                    var likeId = jsonResponse.likeId;
                    $('.like-count').text(newCount);
                    $('.unlike-count').text(newUnlikeCount);
                    console.log(jsonResponse.data);
                    if (likeId == 1) {
                        $('i.fa-solid.fa-thumbs-up').addClass('liked').removeClass('unliked');
                        $('i.fa-solid.fa-thumbs-down').addClass('unliked').removeClass('liked');
                    } else {
                        $('i.fa-solid.fa-thumbs-down').addClass('liked').removeClass('unliked');
                        $('i.fa-solid.fa-thumbs-up').addClass('unliked').removeClass('liked');
                    }
                } else {
                    alert('Failed to like: ' + jsonResponse.message);
                }
            }
        });
    }
</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Slick JS -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.watch-sec .container').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      dots: true,
      autoplay: true,
      autoplaySpeed: 3000,
    });
  });
</script>

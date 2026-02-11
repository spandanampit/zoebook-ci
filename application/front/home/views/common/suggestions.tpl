<style>
    .u-impression-count{float: right;}
    .user-listing ul li + li  {margin-top: 0px;}
    .user-online-video {height:auto;}
</style>
<ul class="scrollbarContent">
    <%assign var="suggestions" value=$this->general->get_user_suggestions()%>
    <%if $suggestions|@count > 0 %>
    <div id="container-d17783d3679df95414c4ee84ca0ec1f9"></div>
      <%section name=i loop=$suggestions%>
            <%if $suggestions[i]['final_media_type'] == 'Video' %>
                  <div class="sugested-video-list">
                  <%assign var=suggest_text value=removeEmoji($suggestions[i]['post_text'])%>
                        <div class="sugested-video">
                              <a data-id="<%$suggestions[i]['post_id']%>" data-loop="<%$i%>" href="<%$this->general->setdiplayposturl($suggestions[i]['post_id'],$suggestions[i]['post_text'])%>">
                              <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;"></div>
                              <video width="100%" height="100%" preload="metadata" class="othervideoduration" data-poster="<%$suggestions[i]['final_video_image']%>" muted>
                                    <source src="<%$suggestions[i]['final_upload_file']%>" type="video/mp4">
                              </video>
                              </a>
                        </div>
                  <div class="suggested-heading-box">
                        <div class="suggested-user">
                              <div class="suggested-user-img">
                              <!-- Note: ID should be unique per suggestion -->
                              <%if $suggestions[i]['user_profile_image'] neq ''%>
                              <a href="<%$this->general->setdiplayprofileurl($suggestions[i]['user_id'],$suggestions[i]['user_name'])%>">
                                    <img id="profileImage<%$suggestions[i]['post_id']%>" src="" alt="Profile Image" width="100" height="100">
                              </a>
                              <input type="hidden" id="base64Image<%$suggestions[i]['post_id']%>" value="<%$suggestions[i]['user_profile_image']%>">
                              <%else%>
                              <img src="<%$this->config->item('images_url')%>noimage.gif" alt="">
                              <%/if%>
                              </div>
                              <div class="suggested-user-content">
                              <a href="<%$this->general->setdiplayprofileurl($suggestions[i]['user_id'],$suggestions[i]['user_name'])%>">
                                    <h5> <%$suggestions[i]['user_name']%> </h5>
                              </a>
                              </div>
                        </div>
                        <div class="suggested-view">
                              <p><%$suggestions[i]['final_views_count']%></p>
                        </div>
                  </div>
                  </div>
            <%/if%>
      <%/section%>

    <%else%>
        <div class="sugested-video">
            <span><%$suggestionNotFound%></span>
        </div>
    <%/if%>
</ul>
<script async="async" data-cfasync="false" src="//pl23652013.highrevenuenetwork.com/d17783d3679df95414c4ee84ca0ec1f9/invoke.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var videos = document.querySelectorAll('.othervideoduration');

        videos.forEach(function(video) {
            // Restart video playback when it ends
            video.addEventListener('ended', function() {
                video.currentTime = 0; // Reset video to the beginning
                video.play(); // Start playing the video again
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
    // Function to get the value of a URL parameter
    function getParameterByName(name, url) {
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    // Function to decode Base64 and set the image URL
    function setProfileImage(base64ImageId, profileImageId) {
        // console.log('function');
        // console.log(base64ImageId);
        const inputElement = document.getElementById(base64ImageId);
        // console.log(inputElement);

        if (inputElement) {
            const dynamicUrl = inputElement.value;
            // console.log(dynamicUrl);
            if (dynamicUrl) {
                // console.log(`Dynamic URL for ${base64ImageId}:`, dynamicUrl);
                const encodedString = getParameterByName('pic', dynamicUrl);
                if (encodedString) {
                    // console.log(`Encoded Base64 String for ${base64ImageId}:`, encodedString);
                    const decodedUrl = atob(encodedString);
                    // console.log(`Decoded URL for ${base64ImageId}:`, decodedUrl);
                    const profileImage = document.getElementById(profileImageId);
                    if (profileImage) {
                        profileImage.src = decodedUrl;
                    } else {
                        console.error(`Profile image element not found: ${profileImageId}`);
                    }
                } else {
                    console.error(`No encoded string found in the URL for ${base64ImageId}`);
                }
            } else {
                console.error(`No dynamic URL found for ${base64ImageId}`);
            }
        } else {
            console.error(`Input element not found: ${base64ImageId}`);
        }
    }

    // Loop through each suggestion and set the profile image
    const base64Elements = document.querySelectorAll("[id^='base64Image']");
    base64Elements.forEach(element => {
        const postId = element.id.replace('base64Image', ''); // Extract post_id from the id
        setProfileImage(`base64Image${postId}`, `profileImage${postId}`);
    });
});

</script>

<script>
    const videos = document.querySelectorAll('.othervideoduration');

    videos.forEach(video => {
        video.addEventListener('mouseenter', () => {
            video.play();
        });

        video.addEventListener('mouseleave', () => {
            video.pause();
            video.currentTime = 0;
        });
    });
</script>
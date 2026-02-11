<div class="comment">
    <div class="comment-pic">
        <img src="<%$row['user_profile_image']%>" alt=""
            style="width:50px !important; height: 50px !important; border-radius: 50%">
    </div>
    <div class="comment-text movement-details-comment">
    <form style="display: flex; height: auto; position: relative; top: 12px;">
        <!-- Comment Text Area -->
        <div class="form-group" style="margin-top: 10px; width: 63% !important; position: relative;">
            <!-- Wrapper around the textarea and emoji button -->
            <div style="position: relative;">
                <textarea class="form-control comment_post_<%$row['post_id']%>" 
                    id="comment-box<%$row['post_id']%>"
                    data-postid="<%$row['post_id']%>" 
                    data-mediaid="<%$row['get_post_media'][0]['pm_post_media_id']%>"
                    rows="2" 
                    placeholder="Add Comment">
                </textarea>
                <!-- Emoji Button -->
                <span id="emoji-btn-<%$row['post_id']%>" style="position: absolute; right: 10px; top: 5px; cursor: pointer;" onclick="openEmoji(<%$row['post_id']%>)">😀</span> 
                <!-- Emoji Picker -->
                <div id="emoji-picker-container" class="emoji-picker" style="display: none;"></div>
            </div>

            <!-- Error Message -->
            <span class="err_msg_<%$row['post_id']%>" style="font-size: 12px; color: #4e4c4c;" 
                onkeydown="return handleCommentKeyDown(event, '<%$row['post_id']%>')"></span>

            <!-- Display selected image here -->
            <div id="selected-image-container_<%$row['post_id']%>" style="margin-top: 10px; display: none;">
                <img id="selected-image_<%$row['post_id']%>" src="" alt="Selected Image" style="max-width: 40%; height: 70px; border: 1px solid #ddd; padding: 5px; object-fit: cover;">
                <span style="cursor: pointer; color: red;" onclick="removeSelectedImage('<%$row['post_id']%>')">Remove</span>
            </div>
        </div>

        <!-- Media Attachments Section -->
        <div class="comment-pic" style="background: none; display: flex; gap: 10px; margin-top: 14px">
            <!-- Hidden File Input for Media Attachment -->
            <input type="file" id="fileInput_<%$row['post_id']%>" style="display: none;" accept="image/*" />

            <!-- Media Attachment Icon -->
            <span style="cursor: pointer" class="btn_post_media_attach" onclick="triggerFileInput('<%$row['post_id']%>')">
                <i class="fa fa-paperclip btn_postmedia" data-postid="<%$row['post_id']%>" style="font-size: 16px !important"></i>
            </span>
            
            <!-- GIF Button -->
            <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<%$row['post_id']%>">GIF</span>

            <!-- Sticker Button -->
            <span style="cursor:pointer;" class="open_sticker_section" data-sticker-post-id="<%$row['post_id']%>">
                <img src="<%$this->config->item('images_url')%>front/sticker.png" alt="Sticker">
            </span>
        </div>

        <!-- Submit Comment Button -->
        <button type="button" class="btn btn-primary form-btn btn_postcomment" 
            data-postid="<%$row['post_id']%>" title="Add Comment"
            onclick="movement_post_comment(<%$row['post_id']%>, <%$row['get_post_media'][0]['pm_post_media_id']%>)">
            <img src="<%$this->config->item('images_url')%>front/plane.png">
        </button>
    </form>
  
        <br>
        <div id="getComments_<%$row['post_id']%>"></div>
        <div class="feed-comments feed_comments_<%$row['post_id']%> scrollbarContent feed-comments-main" id="openComment_<%$row['post_id']%>" style="display:none;">
            <ul id="comments_list_<%$row['post_id']%>">
                <%include file="common/comments_show.tpl" comments=$row%>
            </ul>
        </div>
    </div>
    <!-- GIF Section -->
    <div class="main_gif_div_section gif_section_<%$row['post_id']%>" style="display: none;">
        <input type="text" id="searchInput_<%$row['post_id']%>" placeholder="Search for Stickers">
        <a href="javascript:void(0);" class="close_gif_div_<%$row['post_id']%>">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
        </a>

        <div class="main_picker" id= "main_picker_<%$row['post_id']%>">
            <div class="gif_picker_div_cls" id="gifPicker_<%$row['post_id']%>" data-mediaid="<%$row['get_post_media'][0]['pm_post_media_id']%>">
            </div>
        </div>
    </div>
</div>

<!-- Include jQuery from CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function triggerFileInput(postId) {
        document.getElementById('fileInput_' + postId).click();
    }

    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function(e) {
            var postId = this.id.split('_')[1]; // Get the post id from file input id
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageContainer = document.getElementById('selected-image-container_' + postId);
                    var imageElement = document.getElementById('selected-image_' + postId);
                    imageElement.src = e.target.result; // Set image source
                    imageContainer.style.display = 'block'; // Show the image container
                }
                reader.readAsDataURL(file); // Read file as data URL
            }
        });
    });

    // Function to remove the selected image
    function removeSelectedImage(postId) {
        var fileInput = document.getElementById('fileInput_' + postId);
        var imageContainer = document.getElementById('selected-image-container_' + postId);
        var imageElement = document.getElementById('selected-image_' + postId);

        fileInput.value = ''; // Reset the file input
        imageElement.src = ''; // Clear the image source
        imageContainer.style.display = 'none'; // Hide the image container
    }

    // Optional: Handle comment key down event if needed
    function handleCommentKeyDown(event, postId) {
        // Handle 'Enter' key for submitting comments if desired
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            movement_post_comment(postId);
        }
    }
</script>

<script>
// document.addEventListener("DOMContentLoaded", function () {
//     let clickedGifs = new Set();

//     document.querySelectorAll(".gif_picker_div_cls").forEach((gifPicker) => {
//         gifPicker.addEventListener("click", function (event) {
//             if (event.target.tagName === "IMG") {
//                 const gifUrl = event.target.src;
                
//                 if (!clickedGifs.has(gifUrl)) {
//                     clickedGifs.add(gifUrl);

//                     const postId = this.closest(".main_gif_div_section").className.match(/gif_section_(\d+)/)[1];
//                     const textarea = document.querySelector(`#comment-box${postId}`);
                    
//                     if (textarea) {
//                         textarea.value = gifUrl;
//                         textarea.focus();
//                     }
//                 }
//             }
//         });
//     });
// });



function movementGifManager(postId, media_id) {
      var textarea = document.getElementById("comment-box" + postId);
      var mainGifDiv = document.querySelector(".comment_post_" + postId);
      
      console.log('comment', textarea ? textarea.value.trim() : "Textarea not found");

      if (textarea) {
            const gifLink = textarea.value.trim();

            if (/^https:\/\/media\d*\.giphy\.com\/media/.test(gifLink)) {

                  textarea.value = "";
                  textarea.dispatchEvent(new Event("input"));
                  $(".comment_post_" + postId).html("");

                  if (typeof jQuery !== "undefined") {
                  $(textarea).val("").trigger("change").trigger("input");
                  }

                  submitGifComment(postId, gifLink, media_id)
                  .then(() => {
                  })
                  .catch(error => {
                        console.error("Failed to submit GIF comment:", error);
                  });

                  textarea.blur();
            }
      }
}


function submitGifComment(postId, gifLink, media_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "/movement_post_comment",
            type: "POST",
            data: { post_id: postId, comment: gifLink, mediaId: media_id },
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    console.log("GIF URL submitted successfully:", response.comments);

                    let commentSection = document.getElementById("openComment_"+postId);
                    commentSection.style.display = "block"
                    document.getElementById("comments_list_" + postId).innerHTML = "";
                    document.getElementById("comments_list_" + postId).innerHTML = response.comments;

                    resolve(response);
                } else {
                    console.error("Error submitting GIF:", response.message);
                    reject(response.message); 
                }

                setTimeout(() => {
                    let textarea = document.getElementById(`comment-box${postId}`);
                    if (textarea) {
                        textarea.value = "";
                        if (typeof jQuery !== "undefined") {
                            $(textarea).val("").trigger("change").trigger("input");
                        }
                    }
                }, 50);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
                reject(errorThrown);
            }
        });
    });
}



document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".main_picker").forEach(mainPicker => {
        mainPicker.addEventListener("click", function (event) {
            let selectedGif = event.target.closest("img");
            if (!selectedGif) return;

            let gifUrl = selectedGif.src;
            let postId = this.id.replace("main_picker_", "");

            let gifPickerDiv = this.querySelector(".gif_picker_div_cls");
            let mediaId = gifPickerDiv ? gifPickerDiv.getAttribute("data-mediaid") : null;

            let textarea = document.getElementById(`comment-box${postId}`);
            if (textarea) {
                if (textarea.dataset.gifProcessing === "true") return;
                textarea.dataset.gifProcessing = "true";

                textarea.value = gifUrl;
                textarea.dispatchEvent(new Event("input"));

                setTimeout(() => {
                    console.log("Calling movementGifManager...");
                    movementGifManager(postId, mediaId);
                    textarea.dataset.gifProcessing = "false"; // Reset flag
                }, 50);
            }

            let gifSection = document.querySelector(`.gif_section_${postId}`);
            if (gifSection) gifSection.style.display = "none";
        });
    });
});



</script>   
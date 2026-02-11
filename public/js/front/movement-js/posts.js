//     document.getElementById('upload_file').addEventListener('change', function(event) {
//     const files = event.target.files;
//     const previewContainer = document.getElementById('preview');
//     previewContainer.innerHTML = '';

//     Array.from(files).forEach((file, index) => {
//         if (file.type.startsWith('image/')) {
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 const wrapper = document.createElement('div');
//                 wrapper.style.display = 'inline-block';
//                 wrapper.style.position = 'relative';
//                 wrapper.style.margin = '5px';
//                 wrapper.style.width = '120px';
//                 wrapper.style.height = '120px';
//                 wrapper.style.overflow = 'hidden';

//                 const img = document.createElement('img');
//                 img.src = e.target.result;
//                 img.style.width = '100%';
//                 img.style.height = '100%';
//                 img.style.objectFit = 'cover';
//                 img.style.borderRadius = '10px';

//                 const removeBtn = document.createElement('span');
//                 removeBtn.innerHTML = '&times;';
//                 removeBtn.style.position = 'absolute';
//                 removeBtn.style.top = '5px';
//                 removeBtn.style.right = '5px';
//                 removeBtn.style.background = 'rgba(0, 0, 0, 0.5)';
//                 removeBtn.style.color = '#fff';
//                 removeBtn.style.cursor = 'pointer';
//                 removeBtn.style.padding = '2px 5px';
//                 removeBtn.style.borderRadius = '50%';
//                 removeBtn.style.fontSize = '14px';

//                 removeBtn.addEventListener('click', function() {
//                     previewContainer.removeChild(wrapper);
//                 });

//                 wrapper.appendChild(img);
//                 wrapper.appendChild(removeBtn);
//                 previewContainer.appendChild(wrapper);
//             }
//             reader.readAsDataURL(file);
//         }
//     });
// });

var swiper = new Swiper(".swiper-container", {
        loop: true, // Enable looping
        navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
        },
        pagination: {
                el: ".swiper-pagination",
                clickable: true,
        },
        // autoplay: {
        //     delay: 5000,
        //     disableOnInteraction: false,
        // },
});

function movement_post_like(post_id) {
        console.log(post_id);
        var url = "movement/like_post";
        console.log("url : " + url);
        console.log("ei malta");
        let likeCount = parseInt($("#like-post-" + post_id).text()) || 0;
        likeCount += 1;

        $("#like-post-" + post_id).text(likeCount);

        console.log("Updated likeCount:", likeCount);

        $.ajax({
                url: url,
                type: "POST",
                data: {
                        post_id: post_id,
                        status: 1,
                },
                dataType: "json",
                success: function (response) {
                        console.log("Parsed response:", response);

                        if (response.success == 1) {
                                $("#heart-icon-" + post_id)
                                        .removeClass("far")
                                        .addClass("fas");
                        } else {
                                $("#heart-icon-" + post_id)
                                        .removeClass("fas")
                                        .addClass("far");
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                        console.log("Full jqXHR object:", jqXHR);
                        console.log("Response text:", jqXHR.responseText);
                },
        });
}

function movement_post_comment(post_id, mediaId) {
        var formData = new FormData();

        var commentText = $("#comment-box" + post_id).val();
        formData.append("comment_text", commentText);
        var formData = new FormData();
        var fileInput = $("#fileInput_" + post_id)[0];
        // console.log(fileInput.files[0]);
        if (fileInput && fileInput.files.length > 0) {
                // Append the selected file to the formData
                formData.append("upload_file", fileInput.files[0]);
        } else {
                console.log("No file selected.");
        }
        formData.append("comment", commentText);
        formData.append("post_id", post_id);
        formData.append("mediaId", mediaId);

        //   console.log(formData);
        $("#comment-box" + post_id).val("");

        // Add the AJAX request here
        var url = "movement/comment";

        $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (response) {
                        if (response.success == 1) {
                                $(`#comments_list_${response.post_id}`).empty();
                                response.comments.forEach(function (comment) {
                                        let newCommentHtml = `
                            <li>
                                <div class="user-comments-row" id="showloader_${
                                        response.post_id
                                }">
                                    <div class="comments-block">
                                        <div class="comments-user-row">
                                            <div class="comments-user-details">
                                                <i class="cmn-user-img">
                                                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/${
                                                            comment.profile_image
                                                    }" alt="">
                                                </i>
                                                <h6>
                                                    <a href="#" class="name">${
                                                            comment.user_name
                                                    }</a>
                                                </h6>
                                            </div> 
                                            <div class="comments-time" title="">
                                                ${timeElapsedString(
                                                        comment.added_date
                                                )}
                                            </div>
                                        </div>
                                        <div class="user-comments">
                                            <p class="displayemoji_comment" style="display:block;">${
                                                    comment.comment
                                            }</p>
                                            ${
                                                    comment.upload_file
                                                            ? `<img src="${comment.upload_file}" class="comment-image">`
                                                            : ""
                                            }
                                            <div class="like-reply-row">
                                                <div>
                                                    <a href="javascript:void(0)" class="grey-link like-post act_likepostcomment" style="margin-right:7px;">
                                                        <i class="fas fa-thumbs-up"></i>
                                                    </a> 
                                                    <span id="commentlikes_count_${
                                                            comment.post_comment_id
                                                    }">
                                                        ${
                                                                comment.count_comment_likes
                                                                        ? comment.count_comment_likes
                                                                        : 0
                                                        } Likes
                                                    </span>
                                                </div>
                                                <div class="all-comment">  
                                                    <a href="javascript:" class="grey-link show_replies" data-postcommentid="${
                                                            comment.post_comment_id
                                                    }">
                                                        <i class="fas fa-comment-dots"></i> Reply
                                                    </a>
                                                </div>
                                                <div class="reply-comments">
                                                    <a href="javascript:void(0);" class="postreply-link">Reply</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>`;

                                        $(
                                                `#comments_list_${response.post_id}`
                                        ).append(newCommentHtml);
                                });

                                $(`#openComment_${response.post_id}`).show();
                                $(`#comment-box_${response.post_id}`).val("");
                        } else {
                                console.error("Error: " + response.message);
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                        console.log("Full jqXHR object:", jqXHR);
                        console.log("Response text:", jqXHR.responseText);
                },
        });
}

function timeElapsedString(dateString) {
        const timeAgo = new Date(dateString).getTime();
        const now = Date.now();
        const diff = Math.floor((now - timeAgo) / 1000);

        if (diff < 60) return `${diff} seconds ago`;
        else if (diff < 3600) return `${Math.floor(diff / 60)} minutes ago`;
        else if (diff < 86400) return `${Math.floor(diff / 3600)} hours ago`;
        else return `${Math.floor(diff / 86400)} days ago`;
}

function openModalWithPostId(postId) {
        document.getElementById("modal_post_id").value = postId;

        var myModal = new bootstrap.Modal(
                document.getElementById("postShare"),
                {
                        backdrop: "static",
                        keyboard: false,
                }
        );
        myModal.show();
}

function openComments(post_id) {
        var commentSection = document.getElementById("openComment_" + post_id);
        if (commentSection.style.display === "block") {
                commentSection.style.display = "none";
        } else {
                commentSection.style.display = "block";
        }
}

function open_reply(post_id, type) {
        if (type == "reply_form") {
                var commentSection = document.getElementById(
                        "reply_comment_" + post_id
                );
                if (commentSection.style.display === "block") {
                        commentSection.style.display = "none";
                } else {
                        commentSection.style.display = "block";
                }
        } else {
                var commentSection = document.getElementById(
                        "feed_replies_" + post_id
                );
                if (commentSection.style.display === "block") {
                        commentSection.style.display = "none";
                } else {
                        commentSection.style.display = "block";
                }
        }
}

function openEmoji(postId) {
        console.log("openEmoji function called for post:", postId);
        const button = document.querySelector(`#emoji-btn-${postId}`);
        const commentBox = document.querySelector(`#comment-box${postId}`);
        const picker = new EmojiButton();
        picker.showPicker(button);

        picker.on("emoji", (emoji) => {
                commentBox.value += emoji;
        });
}

function like_postcomment(postid, postCommentId) {
        console.log("post id :" + postid);
        console.log("post comment id" + postCommentId);

        var url = "movement/like_postcomment";

        $.ajax({
                url: url,
                type: "POST",
                data: {
                        postCommentId: postCommentId,
                        postId: postid,
                },
                dataType: "json",
                success: function (response) {
                        if (response.success == 1) {
                                console.log(
                                        "Comment like is successfully completed"
                                );
                                $(
                                        'i[data-comment-id="' +
                                                response.postCommentId +
                                                '"]'
                                ).css("color", "rgb(44, 176, 242)");
                        }
                        console.log(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                        console.log("Full jqXHR object:", jqXHR);
                        console.log("Response text:", jqXHR.responseText);
                },
        });
}

$(document).ready(function () {
        $(".delete_post").click(function () {
                console.log("alkfakbf;fb qhouqhff foqiehdq");
                var postId = $(this).data("post-id");
                delete_post(postId);
        });
});

function delete_post(postId, movementId) {
        // console.log('Delete Post Id: '+ postId);
        alert("Are you sure you want to delete this post? ");
        const url = "movement/deletePost";
        $.ajax({
                url: url,
                type: "POST",
                data: {
                        postId: postId,
                        movementid: movementId,
                },
                dataType: "json",
                success: function (response) {
                        if (response.success == 1) {
                                console.log(response.Success);
                        }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                        console.log("Full jqXHR object:", jqXHR);
                        console.log("Response text:", jqXHR.responseText);
                },
        });
}

// Get Post Details
function get_post(postId) {
        console.log("Get Post Id: " + postId);
        const url = "movement/get_post";
        $.ajax({
                url: "/your/api/endpoint",
                type: "POST",
                data: yourData,
                success: function (result) {
                        if (result.success === 1) {
                                let postDetails = result.post_details;

                                const modalHtml = `
                    <div class="modal fade create-post" id="editPost" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPostLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPostLabel">Edit Post</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                </div>
                                <form method="post" enctype="multipart/form-data" action="/movement/movement/add_post">
                                    <div class="modal-body">
                                        <div class="create-post-comment">
                                            <div class="textarea-img">
                                                <img src="${
                                                        postDetails.user_profile_image
                                                }" alt="Profile Image">
                                            </div>
                                            <p class="lead emoji-picker-container w-100 emoji_postinfo">
                                                <textarea name="movement_post_text" id="movement_post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true" style="border: none;">${
                                                        postDetails.post_text_emoji
                                                }</textarea>
                                            </p>
                                        </div>
                                        <div class="video-upload">
                                            <input type="file" style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp">
                                            <label for="upload_file" class="photo-btn" id="triggerFileUpload">
                                                <i class="fa-solid fa-camera"></i> Photo/Video
                                            </label>
                                            <div id="preview" class="preview-container">
                                                ${postDetails.get_post_media
                                                        .map(
                                                                (media) => `
                                                    <div class="media-preview">
                                                        <img src="${media.upload_file}" alt="Post Media" style="max-width: 100%;">
                                                    </div>
                                                `
                                                        )
                                                        .join("")}
                                            </div>
                                        </div>
                                        <div class="create-share-type">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="visibility" id="visibility1" value="Movement" ${
                                                        postDetails.visibility ===
                                                        "Movement"
                                                                ? "checked"
                                                                : ""
                                                }>
                                                <label class="form-check-label" for="visibility1"> Movement </label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="movement_id" value="${
                                                postDetails.post_id
                                        }">
                                        <div class="create-post-btn-box" style="padding-top:20px !important; padding-bottom: 0px !important;">
                                            <button type="submit" class="post-btn" style="margin-left: 17%;">Post</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>`;

                                // Insert modal HTML into a container (make sure #modal-container exists in your DOM)
                                $("#modal-container").html(modalHtml);

                                // Use Bootstrap 5 Modal API to show the modal
                                var myModal = new bootstrap.Modal(
                                        document.getElementById("editPost"),
                                        {
                                                keyboard: false,
                                        }
                                );
                                myModal.show();
                        } else {
                                console.log(result.message);
                        }
                },
                error: function (xhr, status, error) {
                        console.error("An error occurred: " + error);
                },
        });
}

function dropdownMenuButton(postId) {
        var itemElement = document.getElementById(
                "dropdownMenuButton_" + postId
        );
        if (itemElement.style.display == "none") {
                console.log(itemElement.style.display);
                itemElement.style.display = "block";
        } else {
                console.log(itemElement.style.display);
                itemElement.style.display = "none";
        }
}

document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".remove-media").forEach(function (
                removeLink
        ) {
                removeLink.addEventListener("click", function (event) {
                        event.preventDefault();

                        const mediaId = this.getAttribute("data-file");
                        const mediaItem = this.closest(".media-item");
                        if (mediaItem) {
                                mediaItem.remove();
                        }
                });
        });
});

// Store selected files (initially empty)
let selectedFiles = [];

document.getElementById("upload_file").addEventListener(
        "change",
        previewSelectedFiles
);

function previewSelectedFiles(event) {
        const files = Array.from(event.target.files);
        const previewContainer = document.getElementById("preview");

        selectedFiles = [...selectedFiles, ...files];

        previewContainer.innerHTML = "";

        selectedFiles.forEach((file, index) => {
                const fileReader = new FileReader();
                const mediaItem = document.createElement("div");
                mediaItem.classList.add("media-item");
                mediaItem.style.maxWidth = "20%";
                mediaItem.style.margin = "8px";
                mediaItem.style.minWidth = "20%";

                fileReader.onload = function (e) {
                        if (file.type.startsWith("image")) {
                                // For image files
                                const img = document.createElement("img");
                                img.src = e.target.result;
                                img.style.maxWidth = "100%";
                                img.style.borderRadius = "10px";
                                img.style.objectFit = "cover";
                                img.style.minHeight = "100px";
                                img.style.maxHeight = "100px";

                                mediaItem.appendChild(img);
                        } else if (file.type.startsWith("video")) {
                                // For video files
                                const video = document.createElement("video");
                                video.controls = true;
                                video.src = e.target.result;
                                video.style.maxWidth = "100%";
                                video.style.borderRadius = "10px";
                                video.style.objectFit = "cover";
                                video.style.minHeight = "100px";
                                video.style.maxHeight = "100px";

                                mediaItem.appendChild(video);
                        }

                        const removeButton = document.createElement("a");
                        removeButton.href = "#";
                        removeButton.classList.add("remove-media");
                        removeButton.innerHTML =
                                '<i class="fa fa-trash-o" style="color: red;"></i>';
                        removeButton.style.position = "relative";
                        removeButton.style.bottom = "6rem";
                        removeButton.style.left = "6.5rem";

                        removeButton.addEventListener(
                                "click",
                                function (event) {
                                        event.preventDefault();
                                        selectedFiles.splice(index, 1);
                                        previewSelectedFiles({
                                                target: { files: [] },
                                        });
                                }
                        );

                        mediaItem.appendChild(removeButton);
                        previewContainer.appendChild(mediaItem);
                };

                fileReader.readAsDataURL(file);
        });

        event.target.value = "";
}

// For Share Movement
function openShareModal(movement_id, user_id) {
        console.log("Share Movement");
        var shareUrl =
                "https://zoebook.mydevfactory.com/movementdetails?movement_id=" +
                movement_id +
                "&user_id=" +
                user_id;

        document.getElementById("share-url").value = shareUrl;

        // Open the Bootstrap modal
        var myModal = new bootstrap.Modal(document.getElementById("myModal"));
        myModal.show();
}

function copyToClipboard() {
        // Get the URL input field
        var copyText = document.getElementById("share-url");

        // Select the text in the input field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the input field
        document.execCommand("copy");

        // Alert the copied text (you can customize this alert)
        // alert("Copied the link: " + copyText.value);
}

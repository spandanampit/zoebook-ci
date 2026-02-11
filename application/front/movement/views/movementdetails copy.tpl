<!--<%$movement|print_r%>-->
<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
<style>
.preview-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.preview-item {
    position: relative;
    width: 100px;
    height: 100px;
}

.preview-item img,
.preview-item video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.preview-item .remove-btn {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #ff0000;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}



.video-post-vid {
    width: 100%;
    overflow: hidden;
}

.video-wrapper {
    width: 100%;
    overflow: hidden;
}

.swiper-container {
    width: 100%;
    height: auto; /* Allows height to be adjusted */
    overflow: hidden;
}

.swiper-wrapper {
    display: flex;
}

.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto; /* Allows slide height to be determined by content */
}

.video-container-2 {
    position: relative;
    width: 100%;
    height: auto; /* Allows container height to adjust */
    overflow: hidden;
}

img, video {
    width: 100%;
    height: auto; /* Maintain aspect ratio */
    display: block; /* Ensures no extra space around images */
}




</style>

  <section class="dashboard-sec movement-sec">
    <div class="container customContainer">
      <div class="row">
        <div class="col-xl-3 col-md-12">
            <%include file="common/navbar.tpl"%>  
        </div>
        <div class=" col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
          <div class="main">
            <div class="comment-img-box">
              <img src="<%$movement['get_movements_file'][0]['mi_upload_file']%>" alt="">
            </div>
            
            <%include file="common/movement_action_info.tpl"%>  


          </div>
          <div class="row">
          <%if $userinfo['iUserId'] eq $movement['get_movements']['users_id'] %>
            <div class="col-lg-2 col-md-1 text-end">
              <button class="btn addnew-btn mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>
          <%/if%>
            <div class="col-lg-6 col-md-11">
              

            <%include file="common/movement_feedlist.tpl"%>  

            </div>
            <%include file="common/movement_description_box.tpl"%> 
          </div>
        </div>
      </div>
    </div>
  </section>

  <%include file="common/create_post_modal.tpl"%>      

<%$this->js->add_js("front/posts.js")%>
<%$this->js->add_js('public/js/front/movement-js/posts.js')%>

<!-- dashboard section end -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/emoji-button@latest/dist/index.min.js"></script>

<script src="js/front/movement-js/posts.js"></script>
  <script>
    document.getElementById('upload_file').addEventListener('change', function(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('preview');
    previewContainer.innerHTML = '';

    Array.from(files).forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.style.display = 'inline-block';
                wrapper.style.position = 'relative';
                wrapper.style.margin = '5px';
                wrapper.style.width = '120px';
                wrapper.style.height = '120px';
                wrapper.style.overflow = 'hidden';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '10px';

                const removeBtn = document.createElement('span');
                removeBtn.innerHTML = '&times;';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '5px';
                removeBtn.style.right = '5px';
                removeBtn.style.background = 'rgba(0, 0, 0, 0.5)';
                removeBtn.style.color = '#fff';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.padding = '2px 5px';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.fontSize = '14px';

                removeBtn.addEventListener('click', function() {
                    previewContainer.removeChild(wrapper);
                });

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            }
            reader.readAsDataURL(file);
        }
    });
});


var swiper = new Swiper('.swiper-container', {
    loop: true, // Enable looping
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    // autoplay: {
    //     delay: 5000,
    //     disableOnInteraction: false,
    // },
});

    function movement_post_like(post_id) {
    console.log(post_id);
    var url = "<%$this->url->make('movement/movement/like_post')%>";
    console.log("url : "+url)

        $.ajax({
            url: url,
            type: "POST",
            data: { 
                post_id: post_id,
                status: 1,
            },
            dataType: "json",
            success: function(response) {
                console.log("Parsed response:", response);
                
                if (response.success == 1) {
                    $('#heart-icon-' + post_id).removeClass('far').addClass('fas');
                } else {
                    $('#heart-icon-' + post_id).removeClass('fas').addClass('far');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
                console.log("Full jqXHR object:", jqXHR);
                console.log("Response text:", jqXHR.responseText);
            }
        });
    }

    
    

    function movement_post_comment(post_id) {
        var formData = new FormData();

        var commentText = $('#comment-box' + post_id).val();
        formData.append('comment_text', commentText);
        console.log(commentText);

        // var fileInput = $('#input_media_' + post_id)[0];
        // if (fileInput.files.length > 0) {
        //     formData.append('upload_file', fileInput.files[0]);
        // }

        var emoji = $('#post_comment_emoji').val();
        formData.append('post_comment_emoji', emoji);

        formData.append('post_id', post_id);

        // Add the AJAX request here
        var url = "<%$this->url->make('movement/movement/comment')%>";

        $.ajax({
            url: url,
            type: "POST",
            data: { 
                commentText: commentText,
                postId: post_id,
            },
            dataType: "json",
            success: function(response) {
                if (response.success == 1) {
                    $(`#comments_list_${response.post_id}`).empty();
                    response.comments.forEach(function(comment) {
                        let newCommentHtml = `
                            <li>
                                <div class="user-comments-row" id="showloader_${response.post_id}">
                                    <div class="comments-block">
                                        <div class="comments-user-row">
                                            <div class="comments-user-details">
                                                <i class="cmn-user-img">
                                                    <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/${comment.profile_image}" alt="">
                                                </i>
                                                <h6>
                                                    <a href="#" class="name">${comment.user_name}</a>
                                                </h6>
                                            </div> 
                                            <div class="comments-time" title="">
                                                ${timeElapsedString(comment.added_date)}
                                            </div>
                                        </div>
                                        <div class="user-comments">
                                            <p class="displayemoji_comment" style="display:block;">${comment.comment}</p>
                                            <div class="like-reply-row">
                                                <div>
                                                    <a href="javascript:void(0)" class="grey-link like-post act_likepostcomment" style="margin-right:7px;">
                                                        <i class="fas fa-thumbs-up"></i>
                                                    </a> 
                                                    <span id="commentlikes_count_${comment.post_comment_id}">
                                                        ${comment.count_comment_likes ? comment.count_comment_likes : 0} Likes
                                                    </span>
                                                </div>
                                                <div class="all-comment">  
                                                    <a href="javascript:" class="grey-link show_replies" data-postcommentid="${comment.post_comment_id}">
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

                        $(`#comments_list_${response.post_id}`).append(newCommentHtml);
                    });
                    
                    $(`#openComment_${response.post_id}`).show();
                    $(`#comment-box_${response.post_id}`).val('');
                } else {
                    console.error("Error: " + response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
                console.log("Full jqXHR object:", jqXHR);
                console.log("Response text:", jqXHR.responseText);
            }
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
        
        document.getElementById('modal_post_id').value = postId;
        
        var myModal = new bootstrap.Modal(document.getElementById('postShare'), {
            backdrop: 'static',
            keyboard: false
        });
        myModal.show();
    }

    function openComments(post_id) {
        var commentSection = document.getElementById('openComment_'+post_id);
        if (commentSection.style.display === 'block') {
            commentSection.style.display = 'none';
        } else {
            commentSection.style.display = 'block';
        }
    }

    function open_reply(post_id, type) {

        if(type == 'reply_form') {
            var commentSection = document.getElementById('reply_comment_'+post_id);
            if (commentSection.style.display === 'block') {
                commentSection.style.display = 'none';
            } else {
                commentSection.style.display = 'block';
            }
        } else {
            var commentSection = document.getElementById('feed_replies_'+post_id);
            if (commentSection.style.display === 'block') {
                commentSection.style.display = 'none';
            } else {
                commentSection.style.display = 'block';
            }
        }   
    }
     
    function openEmoji(postId) {
        console.log("openEmoji function called for post:", postId);
        const button = document.querySelector(`#emoji-btn-${postId}`);
        const commentBox = document.querySelector(`#comment-box${postId}`);
        const picker = new EmojiButton();
        picker.showPicker(button);

        picker.on('emoji', emoji => {
            commentBox.value += emoji;
        });
    }

    function like_postcomment(postid, postCommentId) {
        console.log('post id :' + postid);
        console.log('post comment id'+ postCommentId);

        var url = "<%$this->url->make('movement/movement/like_postcomment')%>";

        $.ajax({
            url: url,
            type: "POST",
            data: { 
                postCommentId: postCommentId,
                postId: postid,
            },
            dataType: "json",
            success: function(response) {

                if(response.success == 1) {
                    console.log('Comment like is successfully completed');
                    $('i[data-comment-id="' + response.postCommentId + '"]').css('color', 'rgb(44, 176, 242)');
                }
                console.log(response);
                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("AJAX error:", textStatus, errorThrown);
                console.log("Full jqXHR object:", jqXHR);
                console.log("Response text:", jqXHR.responseText);
            }
        });
    }

    $(document).ready(function() {
        $('.delete_post').click(function() {
            console.log('alkfakbf;fb qhouqhff foqiehdq');
            var postId = $(this).data('post-id'); // Use data attribute for post ID
            delete_post(postId);
        });
    });

    function delete_post(postId){
        alert('Delete');
        console.log('Delete Post Id: '+ postId);
    }
</script>

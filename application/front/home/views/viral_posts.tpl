<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DLV476FTS6"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-DLV476FTS6'); </script>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
.bg-gray{
    background-color: #0c0c0ca6;
}
.thumbnail-text{
    font-size: 16px;
    color: #6b646c;
    font-weight: 600;
}

.add-thumbnail {
    padding-top: 20px;
    width: 25%;
    margin-left: 75%;
}

.modal-title {
    font-weight: 700;
    color: #433f44;
}


.loader { 
  margin:0 auto;
  border-radius:10px;
  border:4px solid #00000070;
  position:relative;
  padding:1px;
  height: 15px;
  margin-bottom: 12px;    
}
.loader:before {
  content:'';
  border:1px solid #fff; 
  border-radius:10px;
  position:absolute;
  top:-4px; 
  right:-4px; 
  bottom:-4px; 
  left:-4px;
}
.loader .loaderBar { 
  position:absolute;
  border-radius:10px;
  top:0;
  right:100%;
  bottom:0;
  left:0;
  background: #1dd31d;
  width:0;
  animation:borealisBar 2s linear infinite;
}

@keyframes borealisBar {
  0% {
    left:0%;
    right:100%;
    width:0%;
  }
  10% {
    left:0%;
    right:75%;
    width:25%;
  }
  90% {
    right:0%;
    left:75%;
    width:25%;
  }
  100% {
    left:100%;
    right:0%;
    width:0%;
  }
}

.modal-backdrop.fade.show {
    display: none !important;
}

.music-btn{
    border-radius: 70px;
    background: #bb72dd;
    color: var(--sub-color);
    font-size: 18px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    padding: 8px;
    height: 55px;
    display: flex;
    align-items: center;
    width: 182px;
    gap: 10px;
}
.music-btn:hover{
    color: var(--sub-color);
}
.music-btn i{
    width: 40px;
    height: 40px;
    border-radius: 50px;
    justify-content: center;
    align-items: center;
    background: #8e65a1;
    color: var(--white-color);
    display: flex;
}

/* Custom Modal Styling */
.custom-modal {
    border-radius: 20px;
    border: none;
    box-shadow: 0 15px 50px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Upload Zone (Drop Area) */
.upload-zone {
    border: 2px dashed #e0e0e0;
    border-radius: 15px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    background: #fcfcfc;
    position: relative;
    cursor: pointer;
}

.upload-zone:hover {
    border-color: #6366f1;
    background: #f8f9ff;
}

.upload-icon {
    font-size: 2rem;
    color: #6366f1;
    margin-bottom: 10px;
}

/* Thumbnail Preview Box */
.thumbnail-preview-box {
    width: 100%;
    aspect-ratio: 1/1;
    background: #f0f0f0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: #bdbdbd;
    font-size: 1.5rem;
}

.thumbnail-preview-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Styled Inputs & Buttons */
.custom-input {
    border-radius: 8px;
    border: 1px solid #eee;
    padding: 8px 12px;
}

.btn-gradient {
    background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    transition: transform 0.2s ease;
}

.btn-gradient:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(99, 102, 241, 0.4);
}

.extra-small { font-size: 0.8rem; }
.upload-zone {
    border: 2px dashed #e5e7eb;
    border-radius: 14px;
    padding: 22px;
    cursor: pointer;
    transition: 0.2s ease;
}

.upload-zone:hover {
    background: #f9fafb;
}

.audio-icon {
    width: 48px;
    height: 48px;
    background: #eef2ff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<div class="post-pages dashboard-sec">
    <div class="container" style="margin-top: 0px !important">
        <div class="row">
            <div class="col-lg-3 user-info-block">
                <div class="user-open" style="display:none;">
                    <i class="far fa-user"></i>
                </div>
                <!--User info start here-->
                <%include file="common/user_info.tpl" %>
                <!--User info End here-->
            </div>
            <div class="col-xl-6 col-lg-8 col-md-7">
                <input type="hidden" id="cr_pg" value="<%$cr_pg%>"/>
                <input type="hidden" id="nx_pg" value="<%$nx_pg%>"/>
                <input type="hidden" id="page_type" name="page_type" value="viral"/>

                    <div class="main">
                        <div class="create-post-box mb-20" data-toggle="modal" data-target="#createPost">
                            <div class="create-post-box mb-20">
                                <div class="create-post-heading">
                                    <div class="create-post-heading-icon">
                                        <i class="fa-regular fa-file-lines"></i>                    
                                    </div>
                                    <div class="create-post-heading-content">
                                        <h3><%$create_post%></h3>
                                    </div>
                                    </div>
                                    <div class="create-post-comment">
                                    <div class="textarea-img">
                                        <img src="<%$userinfo.u_profile_image%>" alt="">
                                    </div>
                                    <form>
                                        <textarea id="comment-box7" placeholder="<%$whats_on_your_mind%>"></textarea>
                                        <!-- <div class="smile-icon">
                                        <i class="fa-regular fa-face-smile"></i>                      
                                        </div> -->
                                    </form>
                                    </div>
                                    <div class="create-post-upload">
                                        <div class="video-upload">
                                            
                                            <div class="upload-img-vod photo-btn">
                                                <i class="fa fa-camera" style="clor: white;"></i> <%$photo%>/<%$video%>
                                            </div>
                                            
                                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel"><%$photo%>/<%$video%></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ...
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><%$close%></button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    <div class="upload-visiblity music-btn"
                                       data-bs-toggle="modal"
                                        data-bs-target="#musicModal"
                                        data-bs-dismiss="modal"

                                        onclick="event.stopPropagation();">
                                        <i class="fa-solid fa-music"></i> Music
                                    </div>
                                    <div class="upload-visiblity visibility-btn">
                                        <i class="fa fa-eye" style="color:white;"></i> <%$visiblity%>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>

                    <div id="result-container"></div>

                <!-- loader -->
                    <div id="loader-container" style="display: none;text-align: center;width: 100%;margin: 0 auto;position: static;z-index: 9999;background: #fff;padding: 10px; border-radius: 15px; margin-bottom: 16px;">
                        <p style="text-align: left;font-size: 18px;font-weight: 600;color: #000000c7;"><%$uploading%></p>
                        <div class="loader">
                            <div class="loaderBar" style="background: #efd933 !important;"></div>
                        </div> 
                    </div>
                <!-- end -->

                <!-- loader processing -->
                    <div id="loader-container-processing" style="display: none;text-align: center;width: 100%;margin: 0 auto;position: static;z-index: 9999;background: #fff;padding: 10px; border-radius: 15px; margin-bottom: 16px;">
                        <p style="text-align: left;font-size: 18px;font-weight: 600;color: #000000c7;">Processing ...</p>
                        <div class="loader">
                            <div class="loaderBar"></div>
                        </div> 
                    </div>
                <!-- end -->



                <!--Feed list start here-->
                <div id="feed_list">
                  <%include file="common/feed_list.tpl"%>
                </div>

                <!--Feed list End here-->
            </div>
            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6">
                <div class="sugested-video-box right-panel" style="border-radius: 15px;">
                    <h3><%$suggested%> </h3>  
                    <div class="suggested-wrapper user-listing">
                        <!--suggestions start here-->
                        <%include file="common/suggestions.tpl"%>
                        <!--suggestions End here-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--modal-->
<div class="modal fade create-post" id="createPost" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><%$create_post%></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <p class="error_msg"></p>
            <form id="post_data" method='post' enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="create-post-comment">
                        <div class="textarea-img">
                            <img src="<%$userinfo.u_profile_image%>" alt="">
                        </div>
                        <p class="lead emoji-picker-container w-100 emoji_postinfo">
                          <!--<textarea class="form-control textarea-control" rows="3" placeholder="Textarea with emoji image input" data-emojiable="true"></textarea>-->
                          <textarea name="post_text" id="post_text" class="form-control textarea-control" rows="5" placeholder="<%$whats_on_your_mind%>" data-emojiable="true"></textarea>
                          <input type="hidden" name="post_text_emoji" id="post_text_emoji">
                        </p>
                    </div>
                    <div class="multiple-photo preview_media"></div>
                    <div class="create-post-upload">
                        <div class="video-upload">
                            <input type='file' style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp" />

                            <label for="upload_file" class="photo-btn">
                                <i class="fa-solid fa-camera"></i> <%$photo%>/<%$video%></a>
                            </label>
                        </div>
                    </div>
                    <div class="create-share-type">
                        <div class="form-check">
                            <input class= "form-check-input" type="radio" name="visibility" id="visibility1" value="Public" />
                            <label class="form-check-label" for="visibility1"> <i class="fas fa-eye"></i> <%$public%></label>
                        </div>
                        <div class="form-check">
                            <input class= "form-check-input" type="radio" name="visibility" id="visibility2" value="Private" />
                            <label class="form-check-label" for="visibility2"> <i class="fas fa-eye-slash"></i> <%$private%></label>
                        </div>
                        <div class="form-check">
                            <input class= "form-check-input" type="radio" name="visibility" id="visibility3" checked value="Viral" />
                            <label class="form-check-label" for="visibility3"> <i class="fas fa-eye"></i> <%$viral%></label>
                        </div>
                    </div> 
                    <div class="create-post-btn-box">
                    <button type="button" id="submit_post" class="post-btn" style="background: #8E65A1 !important; border: none; margin-left: 6rem;"disabled="disabled"><%$post%></button>
                    </div> 
                </div>
            </form> 
        </div>
    </div>
</div>

<!--modal-->
<div class="modal fade bg-gray" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle"><%$add_custom_thumbnail%></h5>
        </div>
        <form id="thumbnail_data" method='post' enctype="multipart/form-data">
            <div class="modal-body">
                <div class="thumbnail-form">
                    <h4 class="thumbnail-text"><%$add_a_custom_thumbnail_to_give_your_videos_a_unique_and_personalized_touch%>!✨</br> <%$let_your_creativity_shine%>!</h4>

                    <div class="add-thumbnail">
                        <input type='file' style="display: none;" id="thumbnail" name="thumbnail" multiple accept=".jpg, .jpeg, .png, .gif,.webp" />
                        <label for="thumbnail" class="photo-btn">
                            <i class="fa-solid fa-camera"></i> <%$photo%></a>
                        </label>
                    </div>
                </div>
                <div id="preview-container" style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;"></div>
                <div id="file-info"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel-button"><%$cancel%></button>
                <button type="submit" class="btn btn-primary"  data-dismiss="modal"><%$go%>!😀</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!---Music Modal--->
    <div class="modal fade" id="musicModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content custom-modal">
            
                <div class="modal-header border-0 pb-0">
                    <div class="header-content">
                        <h4 class="modal-title fw-bold" id="musicModalTitle">New Release</h4>
                        <p class="text-muted small mb-0">Share your music with the world.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form id="musicUploadForm">
                    <div class="modal-body py-4">
                        
                        <div class="upload-zone mb-4" id="audio-drop-zone">
                            <div id="audio-placeholder" class="text-center">
                                <div class="upload-icon">
                                    <i class="fa-solid fa-upload"></i>
                                </div>
                                <div class="upload-text" style="display: block; margin-right: 0;">
                                    <label for="music_file" class="stretched-link">
                                        <strong>Click to upload audio</strong>
                                    </label>
                                </div>
                                <p class="text-muted extra-small">WAV, MP3, or FLAC (Max 20MB)</p>
                            </div>

                            <div id="audio-preview" class="d-none w-100">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="audio-icon"><i class="fa-solid fa-music"></i></div>  
                                    <div class="flex-grow-1">
                                        <div class="fw-semibold small" id="audio-name"></div>
                                        <div class="text-muted extra-small" id="audio-size"></div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-light" id="remove-audio">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <input type="file" id="music_file" class="d-none" accept="audio/*">
                        </div>

                        <div class="mb-3">
                            <label for="music_title" class="form-label fw-bold small">Track Title</label>
                            <input type="text" id="music_title" class="form-control custom-input" placeholder="Enter track title" required>
                        </div>

                        <div class="mb-4">
                            <label for="music_description" class="form-label fw-bold small">Description</label>
                            <textarea id="music_description" class="form-control custom-input" rows="3" placeholder="Describe your music..."></textarea>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-4">
                                <div class="music-preview-container" id="preview-box" style="aspect-ratio: 1/1; border: 1px dashed #ddd; display: flex; align-items: center; justify-content: center; border-radius: 8px; overflow: hidden;">
                                    <i class="bi bi-image" id="placeholder-icon"></i>
                                    <img id="image-element" src="" class="d-none" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-8">
                                <label class="form-label fw-bold small">Cover Art</label>
                                <input type="file" id="music_thumbnail" class="form-control form-control-sm custom-input" accept="image/*">
                                <small class="text-muted" style="font-size: 0.75rem;">Recommended: 1000x1000px</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-link text-decoration-none text-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" id="musicSubmit" class="btn btn-gradient px-4 shadow-sm">Publish Track</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<!---End--->


<!-- notification popup start -->
<%include file="common/notification_modal.tpl"%>
<!-- notification popup end -->

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>

<%include file="common/common_editpost.tpl" %>
<%$this->js->add_js("front/posts.js")%>
<%$this->js->add_js("front/music.js")%>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="path/to/jquery.min.js"></script>
<script src="path/to/jquery.emojiarea.js"></script>
<script src="path/to/emoji-picker.js"></script>


<script>
      let loading = false;
      let pageIndex = 2;
      const scrollThreshold = 5000;

      window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrolledHeight = scrollTop + windowHeight;
            
            // Check if the user is near the bottom of the page
            if ((documentHeight - scrolledHeight) <= scrollThreshold && !loading) {
                  loading = true;
                  console.log('User is near the bottom. Triggering AJAX call...');
                  
                  const params = {
                  page_index: pageIndex,
                  viral_feed: 1,
                  };
                  
                  $.ajax({
                  url: '/viral_post_scrolled_posts',
                  method: 'GET',
                  dataType: 'json',
                  data: params,
                  success: function(response) {
                        if (response.success) {
                              $('#feed_list').append(response.html_content);
                              $(document).trigger('newContentLoaded');
                              pageIndex++;
                        } else {
                              console.log(response.message);
                        }
                  loading = false;

                  },
                  error: function(xhr, status, error) {
                        console.error('Error loading data:', error);
                  },
                  complete: function() {
                        loading = false;
                  }
                  });
            }
      });
</script>

<script>
    function closeModal() {
        var modal = document.getElementById('createPost');
        modal.classList.remove('show');
        modal.style.display = 'none';
        var modalBackdrop = document.getElementsByClassName('modal-backdrop');
        document.body.removeChild(modalBackdrop[0]);
    }
</script>
<script>
document.getElementById("upload_file").addEventListener("change", function (event) {
    const file = event.target.files[0];
    
    if (!file) {
        console.log("No file selected.");
        return;
    }
    
    const fileType = file.type;

    if (fileType.startsWith("image/")) {
    } else if (fileType.startsWith("video/")) {
        const modal = new bootstrap.Modal(document.getElementById('exampleModalCenter'));
        modal.show();
    }
});

document.getElementById('thumbnail').addEventListener('change', function (event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('preview-container');

    previewContainer.innerHTML = '';

    if (files) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '400px';
                    img.style.height = 'auto';
                    img.style.objectFit = 'contain';
                    img.style.borderRadius = '5px';
                    img.style.border = '3px solid #c6cccc';
                    previewContainer.appendChild(img);
                };

                reader.readAsDataURL(file);
            } else {
                console.log(`${file.name} is not an image file.`);
            }
        });
    }
});

document.getElementById('cancel-button').addEventListener('click', function () {
    const fileInput = document.getElementById('thumbnail');
    const previewContainer = document.getElementById('preview-container');

    fileInput.value = '';
    previewContainer.innerHTML = '';
});

</script>
<script>
    $('#cancel-button').on('click', function () {
        const fileInput = $('#thumbnail');
        if (fileInput[0].files.length > 0) {
            fileInput.val('');
        }
    });
</script>
<script>
    document.getElementById('thumbnail').addEventListener('change', function (event) {
        const files = event.target.files;
        const fileInfoContainer = document.getElementById('file-info');
        
        fileInfoContainer.innerHTML = '';

        if (files.length > 0) {
            Array.from(files).forEach(file => {
                const fileInfo = document.createElement('p');
                fileInfo.textContent = `File Name: ${file.name}, Size: ${file.size} bytes`;
                fileInfoContainer.appendChild(fileInfo);
            });
        }
    });
</script>
<script>
document.getElementById('music_thumbnail').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;

    const img = document.getElementById('image-element');
    const previewBox = document.getElementById('preview-box');

    const reader = new FileReader();
    reader.onload = function (event) {
        img.src = event.target.result;
        img.classList.remove('d-none');
        previewBox.querySelector('i')?.classList.add('d-none'); // hide icon
    };

    reader.readAsDataURL(file);
});

</script>
<script>
    const musicInput = document.getElementById('music_file');
    const placeholder = document.getElementById('audio-placeholder');
    const preview = document.getElementById('audio-preview');
    const nameEl = document.getElementById('audio-name');
    const sizeEl = document.getElementById('audio-size');
    const removeBtn = document.getElementById('remove-audio');

    musicInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const sizeMB = (file.size / 1024 / 1024).toFixed(2);

        nameEl.innerText = file.name;
        sizeEl.innerText = `${sizeMB} MB • Audio file`;

        placeholder.classList.add('d-none');
        preview.classList.remove('d-none');
    });

    // Remove / reset audio
    removeBtn.addEventListener('click', function () {
        musicInput.value = '';
        preview.classList.add('d-none');
        placeholder.classList.remove('d-none');
    });
</script>
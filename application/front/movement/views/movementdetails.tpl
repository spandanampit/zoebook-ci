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
    height: auto;
    overflow: hidden;
}

.swiper-wrapper {
    display: flex;
}

.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
}

.video-container-2 {
    position: relative;
    width: 100%;
    height: auto;
    overflow: hidden;
}

img, video {
    width: 100%;
    height: auto;
    display: block;
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
            <div class="col-lg-2 col-md-1 text-end">
              <button class="btn addnew-btn mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>
            <div class="col-lg-6 col-md-11" id="movement-feed-list"  data-id ="<%$movement_id%>">
                  <%include file="common/movement_feedlist.tpl"%>  
            </div>
            <%include file="common/movement_description_box.tpl"%> 
          </div>
        </div>
      </div>
    </div>
  </section>

  <%include file="common/create_post_modal.tpl"%>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel"><%$share_movement%></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <p><%$copy_movement%></p>
              <div class="field d-flex align-items-center justify-content-between">
                  <span class="fas fa-link text-center"></span>
                  <input type="text" id="share-url" value="some.com/share" readonly>
                  <button onclick="copyToClipboard()"><%$copy%></button>
              </div>
          </div>
      </div>
    </div>
</div>


<script>
      let loading = false;
      let pageIndex = 2;
      const scrollThreshold = 2000;
      const movement_id = document.getElementById('movement-feed-list').getAttribute('data-id');

      window.addEventListener('scroll', function() {
            const scrollTop = window.scrollY;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrolledHeight = scrollTop + windowHeight;
            
            if ((documentHeight - scrolledHeight) <= scrollThreshold && !loading) {
                  loading = true;
                  console.log('User is near the bottom. Triggering AJAX call...');
                  
                  const params = {
                        page_index: pageIndex,
                        movement_id: movement_id,
                  };
                  
                  $.ajax({
                  url: '/get_movement_posts',
                  method: 'GET',
                  dataType: 'json',
                  data: params,
                  success: function(response) {
                        if (response.success) {
                              $('#movement-feed-list').append(response.html_content);
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/emoji-button@latest/dist/index.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>

<script>
new Vue({
    el: '#app',
    data: {
        userProfileImage: '<%$userinfo['u_profile_image']%>',
        postText: '',
        files: [],
        movementId: '<%$movement['get_movements']['movements_id']%>',
        submitUrl: '<%$this->url->make('movement/movement/add_post')%>',
    },
    methods: {
        previewFiles(event) {
            const selectedFiles = event.target.files;
            this.files = []; 
            Array.from(selectedFiles).forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.files.push({
                        src: e.target.result,
                        type: file.type,
                        file: file
                    });
                };
                reader.readAsDataURL(file);
            });
        },
        removeFile(index) {
            this.files.splice(index, 1);
        },
        submitPost() {
    const formData = new FormData();
    formData.append('movement_post_text', this.postText);
    formData.append('movement_id', this.movementId);

    if (this.files.length > 0) {
        this.files.forEach((fileObj, index) => {
            formData.append(`upload_file[]`, fileObj.file);
        });
    }

    fetch(this.submitUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
            return response.json();
        } else {
            return response.text(); 
        }
    })
    .then(data => {
        if (typeof data === 'object' && data.settings && data.settings.success == 1) {
            console.log('Success:', data);

            const modalElement = document.getElementById('staticBackdrop');
            const modal = bootstrap.Modal.getInstance(modalElement);
            
            if (modal) {
                console.log("Modal instance found, attempting to hide...");
                modal.hide();
            } else {
                console.error("Modal instance not found!");
            }

            setTimeout(() => {
                location.reload();
            }, 500);
        } else {
            setTimeout(() => {
                location.reload();
            }, 500); 
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
    });
}

    }
});
</script>

<script src="public/js/front/movement-js/posts.js"></script>
  

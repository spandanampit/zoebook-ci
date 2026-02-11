<%$this->js->add_js("front/plyr.js")%>
<%$this->css->add_css("front/plyr.css")%>
<%$this->css->css_src()%>
<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
    <!-- dashboard section start -->
    <section class="dashboard-sec movement-sec">
      <div class="container customContainer">
        <div class="row">
          <div class="col-xl-3 col-md-12">
          <%include file="common/navbar.tpl"%>
          </div>
          <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="main">
              <div class="movement-form">                
                <form method="post" action="<%$this->url->make('movement/movement/savemovement')%>" enctype="multipart/form-data">
                  <div class="movement-form-heading">
                  <h3><%$create_movement%></h3>
                </div>
                <div class="form-group">
                  <label><%$movement_name%></label>
                  <input type="text" class="form-control" size="50" placeholder="<%$movement_name%>" name="movement_name" fdprocessedid="3wef0s">
                </div>
                <div class="form-group">
                  <label><%$description%> <span>(<%$goal_or_objective%>)</span></label>
                  <textarea type="text" class="form-control" size="500" placeholder="<%$description%>" name="movement_description"></textarea>
                </div>
                <div class="form-group">
                  <label><%$upload_cover_photo%></label>
                  <div class="file-wrapper">
                    <input type="file" class="form-control" id="coverPhotoInput" name="upload_file" placeholder="<%$movement_name%>">                    
                  </div>
                  <img id="coverPhotoPreview" src="" class="movement-image">
                </div>
                <div class="form-group">
                  <label><%$Visibility%></label>  
                  <div class="radio-box">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="movement_visibility" id="movement_visibility" value="Public" checked="">
                      <label class="form-check-label" for="flexRadioDefault1">
                        <%$public%>
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="movement_visibility" value="Private" id="movement_visibility">
                      <label class="form-check-label" for="flexRadioDefault2">
                        <%$private%>
                      </label>
                    </div>
                  </div>
                </div>  
                <button type="submit" class="btn btn-primary form-btn" fdprocessedid="z448m8"><%$save%></button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>    
    <!-- dashboard section end -->

    <script>
      document.getElementById('coverPhotoInput').addEventListener('change', function(event) {
          const file = event.target.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  const preview = document.getElementById('coverPhotoPreview');
                  preview.src = e.target.result;
                  preview.style.display = 'block';
              };
              reader.readAsDataURL(file);
          }
      });
    </script>
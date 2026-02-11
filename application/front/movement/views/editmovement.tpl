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
                <a href="<%$this->url->make('movement/movement/deactivate')%>?movement_id=<%$movement['get_movements']['movements_id']%>">               
                  <button class="btn btn-danger form-btn" fdprocessedid="z448m8" style="position: relative; width: 22%; float: right"><%$deactivateMovement%></button>
                </a>
                <form method="POST" action="<%$this->url->make('movement/movement/updatemovement')%>" enctype="multipart/form-data">
                  <div class="movement-form-heading">
                    <h3><%$editMovement%></h3>
                  </div>
                <div class="form-group">
                  <label><%$movement_name%></label>
                  <input type="text" class="form-control" size="50" placeholder="<%$movement_name%>" name="movement_name" fdprocessedid="3wef0s" value="<%$movement['get_movements']['movement_name']%>">
                </div>
                <div class="form-group">
                  <%assign var=movement_description_withouemoji value=removeEmoji($movement['get_movements']['description'])%>
                  <%assign var=movement_description value=$this->general->truncateChars($movement_description_withouemoji,200)%>
                  <label><%$description%> <span>(<%$goal_or_objective%>)</span></label>
                  <textarea type="text" class="form-control" size="500" placeholder="Edit Movement" name="movement_description"><%$this->general->displayposttext($movement_description)%></textarea>
                </div>
                <div class="form-group">
                  <label><%$upload_cover_photo%> <span><%$upto_five_photo%></span></label>
                  <div class="file-wrapper">
                  <input type="file" id="coverPhotoInput" class="form-control" placeholder="<%$movement_name%>" name="movement_image">                    
                  </div>
                  <img id="coverPhotoPreview" src="<%$movement['get_movements_file']['0']['mi_upload_file']%>" class="movement-image">
                </div>
                <div class="form-group">
                  <label><%$Visibility%></label>  
                  <div class="radio-box">
                    <div class="form-check">
                    
                      <input class="form-check-input" type="radio" name="movement_visibility" id="flexRadioDefault1" value="Public" <%if $movement['get_movements']['visibility'] == 'Public'%> checked <%/if%>>
                      <label class="form-check-label" for="flexRadioDefault1">
                        <%$public%>
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="movement_visibility" id="flexRadioDefault2" value="Private" <%if $movement['get_movements']['visibility'] == 'Private'%> checked <%/if%>>
                      <label class="form-check-label" for="flexRadioDefault2">
                        <%$private%>
                      </label>
                    </div>
                  </div>
                </div>  
                <input type="hidden" name="movement_id" value="<%$movement['get_movements']['movements_id']%>">
                <input type="hidden" name="movement_image_id" value="<%$movement['get_movements_file'][0]['mi_movement_images_id']%>">
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
                  console.log(preview);
                  preview.src = e.target.result;
                  preview.style.display = 'block';
              };
              reader.readAsDataURL(file);
          }
      });

      $(document).ready(function() {
        $('.movement-link').on('click', function() {
            var movementId = $(this).data('id');
            
            // Show the data you want
            console.log('Movement ID:', movementId);

            // Deactivate an alert message (if an alert is shown somewhere)
            alertMessage = ''; // Or set the alert message visibility to hidden, depending on your logic

            // Example to hide an alert
            $('#alertMessage').hide(); // Assuming your alert has an id of 'alertMessage'
        });
      });
    </script>


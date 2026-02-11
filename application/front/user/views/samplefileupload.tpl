<div class="page-heading">
  <h2>Sample File Upload</h2>
</div> 
<div class="page-content-row">
  <div class="container">
    <div class="contact-form-block">
        <form class="cmn-form" id="frmsample" name="frmsample" method="post"  enctype="multipart/form-data">
            <div class="row">
              <div class="col-lg-12 col-md-12">
                <div class="form-group input-group">
                  
                  <div>
                      <input type="hidden" name="@@err" value="true" />
                    <input type='file'  id="upload_file" name="upload_file[]" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp" />  
                  </div>
              </div>
            <div style="padding-bottom:10px;"></div>
            <input type="submit" class="btn btn-primary w-100" id="submitcontact" name="submitcontact" value="Post">
        </form>
    </div>
  </div>
</div>
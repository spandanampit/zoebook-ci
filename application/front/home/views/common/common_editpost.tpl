<div class="modal fade cmn-modal create-post-modal" id="editPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Edit Post</h5>
            </div>
            <form id="form_edit_post" method='post' enctype="multipart/form-data">
                <input type="hidden" name="edit_post_id" id="edit_post_id" value="" />
                <input type="hidden" name="edit_post_detailpage" id="edit_post_detailpage" value="" />
                <div class="modal-body">
                    <div class="upload-text">
                        <i class="cmn-user-img">
                            <img src="<%$userinfo.u_profile_image%>" alt="">
                        </i>
                        <!--<textarea name="edit_post_text" id="edit_post_text" class="form-control" rows="5" placeholder="What’s on your mind?"></textarea>-->
                        <p class="lead emoji-picker-container w-100 emoji_postinfo">
                          <textarea name="edit_post_text" id="edit_post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true"></textarea>
                          <input type="hidden" name="post_text_emoji" id="post_text_emoji">
                        </p>
                    </div>
                    <div class="multiple-photo preview_media"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="upload-photos">
                        <div class="upload-img-vod">
                            <input type='file' style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".png, .jpg, .jpeg" />
                            <label for="upload_file">
                                <i class="fas fa-camera"></i> Photo/Video
                            </label>                        
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="edit_visibility_Public" checked value="Public" />
                            <label for="edit_visibility_Public"> <i class="fas fa-eye"></i> Public</label>
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="edit_visibility_Private" value="Private" />
                            <label for="edit_visibility_Private"> <i class="fas fa-eye-slash"></i> Private</label>
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="edit_visibility_Viral" value="Viral" />
                            <label for="edit_visibility_Viral"> <i class="fas fa-eye-slash"></i> Viral</label>
                        </div>
                    </div>
                    <button type="button" id="submit_edit_post" class="btn btn-primary">Update</button>
                </div>
            </form>            
        </div>
    </div>
</div>
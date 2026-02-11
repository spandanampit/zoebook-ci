<?php
/* Smarty version 3.1.28, created on 2024-09-26 15:15:23
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/create_post_modal.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_66f5dcfb73b0a8_23228031',
  'file_dependency' => 
  array (
    'a2c217e00529931b177934c2773cb012e1352464' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/create_post_modal.tpl',
      1 => 1727388850,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66f5dcfb73b0a8_23228031 ($_smarty_tpl) {
?>
<!--<div class="modal fade create-post" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form method="post" enctype="multipart/form-data" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/add_post');?>
">
                <div class="modal-body">
                    <div class="create-post-comment">
                        <div class="textarea-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="">
                        </div>
                        <p class="lead emoji-picker-container w-100 emoji_postinfo">
                            <textarea name="movement_post_text" id="movement_post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true" style="border: none;"></textarea>
                            <input type="hidden" name="movement_post_text_emoji" id="movement_post_text_emoji">
                        </p>
                    </div>
                    <div class="video-upload">
                        <input type="file" style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp">
                        <label for="upload_file" class="photo-btn" id="triggerFileUpload">
                            <i class="fa-solid fa-camera"></i> Photo/Video
                        </label>
                        <div id="preview" class="preview-container"></div>
                    </div>
                    <div class="create-share-type">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" id="visibility1" value="Movement">
                            <label class="form-check-label" for="visibility1"> Movement </label>
                        </div>
                    </div>
                    <input type="hidden" name="movement_id" value="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
">
                    <div class="create-post-btn-box" style="padding-top:20px !important; padding-bottom: 0px !important;">
                        <button type="submit" class="post-btn" style="margin-left: 17%;">Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>-->


<!-- Post Share Modal-->
<div class="modal fade create-post" id="postShare" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="postShare" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postShare">Create Post</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/sharePost');?>
">
                <div class="modal-body">
                    <div class="create-post-comment">
                        <div class="textarea-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="">
                        </div>
                        <p class="lead emoji-picker-container w-100 emoji_postinfo">
                            <textarea name="movement_post_text" id="movement_post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true" style="border: none;"></textarea>
                            <input type="hidden" name="movement_post_text_emoji" id="movement_post_text_emoji">
                        </p>
                        <input type="hidden" name="post_id" id="modal_post_id" value="">
                    </div>

                    <div class="create-share-type">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="visibility" id="visibility1" value="Movement" checked>
                            <label class="form-check-label" for="visibility1"> Movement </label>
                        </div>
                    </div>
                    <input type="hidden" name="movement_id" value="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
">
                    <div class="create-post-btn-box" style="padding-top:20px !important; padding-bottom: 0px !important;">
                        <button type="submit" class="post-btn" style="margin-left: 17%;">Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="app">
    <div class="modal fade create-post" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <form @submit.prevent="submitPost" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="create-post-comment">
                            <div class="textarea-img">
                                <img :src="userProfileImage" alt="">
                            </div>
                            <p class="lead emoji-picker-container w-100 emoji_postinfo">
                                <textarea name="movement_post_text" v-model="postText" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" style="border: none;"></textarea>
                            </p>
                        </div>

                        <div class="video-upload">
                            <input type="file" style="display: none;" @change="previewFiles" ref="fileInput" accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp" multiple>
                            <label for="upload_file" class="photo-btn" @click="$refs.fileInput.click()">
                                <i class="fa-solid fa-camera"></i> Photo/Video
                            </label>
                            <div id="preview" class="preview-container">
                                <div v-for="(file, index) in files" :key="index" class="preview-item">
                                    <img v-if="file.type.startsWith('image/')" :src="file.src" />
                                    <video v-else controls :src="file.src"></video>
                                    <span @click="removeFile(index)">&times;</span>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="movement_id" :value="movementId">
                        <div class="create-post-btn-box" style="padding-top:20px !important; padding-bottom: 0px !important;">
                            <button type="submit" class="post-btn" style="margin-left: 17%;">Post</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php }
}

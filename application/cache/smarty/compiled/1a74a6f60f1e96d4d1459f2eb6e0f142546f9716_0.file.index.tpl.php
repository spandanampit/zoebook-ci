<?php
/* Smarty version 3.1.28, created on 2024-01-31 13:07:08
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65b9f8a466e9f5_79760409',
  'file_dependency' => 
  array (
    '1a74a6f60f1e96d4d1459f2eb6e0f142546f9716' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/home/views/index.tpl',
      1 => 1706090584,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/user_info.tpl' => 1,
    'file:common/feed_list.tpl' => 1,
    'file:common/suggestions.tpl' => 1,
    'file:common/common_editpost.tpl' => 1,
  ),
),false)) {
function content_65b9f8a466e9f5_79760409 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
</style>
<div class="post-pages">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 user-info-block">
                <div class="user-open" style="display:none;">
                    <i class="far fa-user"></i>
                </div>
                <!--User info start here-->
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/user_info.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <!--User info End here-->
            </div>
            <div class="col-lg-6 col-md-7">
                <input type="hidden" id="cr_pg" value="<?php echo $_smarty_tpl->tpl_vars['cr_pg']->value;?>
"/>
                <input type="hidden" id="nx_pg" value="<?php echo $_smarty_tpl->tpl_vars['nx_pg']->value;?>
"/>
                <input type="hidden" id="page_type" name="page_type" value="feed"/>
                <div class="cmn-white-block" data-toggle="modal" data-target="#createPost">
                    <div class="post-upload-row">
                        <div class="upload-text">
                            <i class="cmn-user-img">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="">
                            </i>
                            What’s on your mind?
                        </div>
                        <div class="upload-photos">
                            <div class="upload-img-vod">
                                <i class="fas fa-camera"></i> Photo/Video
                            </div>
                            <div class="upload-visiblity">
                                <i class="fas fa-eye"></i> Visiblity
                            </div>
                        </div>
                    </div>
                </div>

                <!--Feed list start here-->
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/feed_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <!--Feed list End here-->
            </div>
            <div class="col-lg-3 col-md-5">
                <div class="cmn-white-block right-panel">
                    <div class="block-title">Suggestions for you</div>
                    <div class="user-listing">
                        <!--suggestions start here-->
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/suggestions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                        <!--suggestions End here-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade cmn-modal create-post-modal" id="createPost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="new_loader" style="display:none;"></div>
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Create Post</h5>
            </div>
            <form id="post_data" method='post' enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="upload-text">
                        <i class="cmn-user-img">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="">
                        </i>
                        <!--<textarea name="post_text" id="post_text" class="form-control" rows="5" placeholder="What’s on your mind?"></textarea>-->

                        <p class="lead emoji-picker-container w-100 emoji_postinfo">
                          <!--<textarea class="form-control textarea-control" rows="3" placeholder="Textarea with emoji image input" data-emojiable="true"></textarea>-->
                          <textarea name="post_text" id="post_text" class="form-control textarea-control" rows="5" placeholder="What’s on your mind?" data-emojiable="true"></textarea>
                          <input type="hidden" name="post_text_emoji" id="post_text_emoji">
                        </p>
                    </div>
                    <div class="multiple-photo preview_media"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div class="upload-photos">
                        <div class="upload-img-vod">
                            <input type='file' style="display: none;" id="upload_file" name="upload_file[]" multiple accept=".jpg, .jpeg, .png, .gif, .mp4, .mov, .wmv, .avi, .3gp, .webp" />
                            <label for="upload_file">
                                <i class="fas fa-camera"></i> Photo/Video
                            </label>
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="visibility1" checked value="Public" />
                            <label for="visibility1"> <i class="fas fa-eye"></i> Public</label>
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="visibility2" value="Private" />
                            <label for="visibility2"> <i class="fas fa-eye-slash"></i> Private</label>
                        </div>
                        <div class="upload-visiblity">
                            <input type="radio" name="visibility" id="visibility3" value="Viral" />
                            <label for="visibility3"> <i class="fas fa-eye-slash"></i> Viral</label>
                        </div>
                        
                    </div>
                    <button type="button" id="submit_post" class="btn btn-primary" disabled="disabled">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/common_editpost.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/posts.js");?>

<?php }
}

<?php
/* Smarty version 3.1.28, created on 2024-10-25 01:57:02
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_post_comment.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_671b5d5eb85c08_65383408',
  'file_dependency' => 
  array (
    '06906aa610939f83f1cf5805fd0cf90ad0ba79b6' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/movement_post_comment.tpl',
      1 => 1729846615,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/comments_show.tpl' => 1,
  ),
),false)) {
function content_671b5d5eb85c08_65383408 ($_smarty_tpl) {
?>
<div class="comment">
    <div class="comment-pic">
        <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_profile_image'];?>
" alt=""
            style="width:50px !important; height: 50px !important; border-radius: 50%">
    </div>
    <div class="comment-text movement-details-comment">
    <form style="display: flex; height: auto; position: relative; top: 12px;">
        <!-- Comment Text Area -->
        <div class="form-group" style="margin-top: 10px; width: 63% !important; position: relative;">
            <!-- Wrapper around the textarea and emoji button -->
            <div style="position: relative;">
                <textarea class="form-control comment_post_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" 
                    id="comment-box<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
"
                    data-postid="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" 
                    rows="2" 
                    placeholder="Add Comment">
                </textarea>
                <!-- Emoji Button -->
                <span id="emoji-btn-<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="position: absolute; right: 10px; top: 5px; cursor: pointer;" onclick="openEmoji(<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
)">😀</span> 
                <!-- Emoji Picker -->
                <div id="emoji-picker-container" class="emoji-picker" style="display: none;"></div>
            </div>

            <!-- Error Message -->
            <span class="err_msg_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="font-size: 12px; color: #4e4c4c;" 
                onkeydown="return handleCommentKeyDown(event, '<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
')"></span>

            <!-- Display selected image here -->
            <div id="selected-image-container_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="margin-top: 10px; display: none;">
                <img id="selected-image_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" src="" alt="Selected Image" style="max-width: 40%; height: 70px; border: 1px solid #ddd; padding: 5px; object-fit: cover;">
                <span style="cursor: pointer; color: red;" onclick="removeSelectedImage('<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
')">Remove</span>
            </div>
        </div>

        <!-- Media Attachments Section -->
        <div class="comment-pic" style="background: none; display: flex; gap: 10px; margin-top: 14px">
            <!-- Hidden File Input for Media Attachment -->
            <input type="file" id="fileInput_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="display: none;" accept="image/*" />

            <!-- Media Attachment Icon -->
            <span style="cursor: pointer" class="btn_post_media_attach" onclick="triggerFileInput('<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
')">
                <i class="fa fa-paperclip btn_postmedia" data-postid="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="font-size: 16px !important"></i>
            </span>
            
            <!-- GIF Button -->
            <span style="cursor:pointer;" class="open_gif_section" data-gif-post-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
">GIF</span>

            <!-- Sticker Button -->
            <span style="cursor:pointer;" class="open_sticker_section" data-sticker-post-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
">
                <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/sticker.png" alt="Sticker">
            </span>
        </div>

        <!-- Submit Comment Button -->
        <button type="button" class="btn btn-primary form-btn btn_postcomment" 
            data-postid="<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" title="Add Comment"
            onclick="movement_post_comment(<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
)">
            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/plane.png">
        </button>
    </form>
  
        <br>
        <div class="feed-comments feed_comments_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
 scrollbarContent feed-comments-main" id="openComment_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="display:none;">
            <ul id="comments_list_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
">
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/comments_show.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('comments'=>$_smarty_tpl->tpl_vars['row']->value), 0, false);
?>

            </ul>
        </div>
    </div>
    <!-- GIF Section -->
    <div class="main_gif_div_section gif_section_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" style="display: none;">
        <input type="text" id="searchInput_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
" placeholder="Search for Stickers">
        <a href="javascript:void(0);" class="close_gif_div_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
">
            <i class="fa fa-times-circle" aria-hidden="true"></i>
        </a>
        <div class="gif_picker_div_cls" id="gifPicker_<?php echo $_smarty_tpl->tpl_vars['row']->value['post_id'];?>
">
            <img src="https://media1.giphy.com/media/9ywJxa5PASF6HBUSh7/giphy-downsized-medium.gif?cid=ca8ff4c416a6m7a5omqz1thbb97qwfygjzj2z51qo93v43oa&ep=v1_stickers_search&rid=giphy-downsized-medium.gif&ct=s"
                alt="GIF" style="cursor: pointer;">
        </div>
    </div>
</div>

<!-- Include jQuery from CDN -->
<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    function triggerFileInput(postId) {
        document.getElementById('fileInput_' + postId).click();
    }

    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        input.addEventListener('change', function(e) {
            var postId = this.id.split('_')[1]; // Get the post id from file input id
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageContainer = document.getElementById('selected-image-container_' + postId);
                    var imageElement = document.getElementById('selected-image_' + postId);
                    imageElement.src = e.target.result; // Set image source
                    imageContainer.style.display = 'block'; // Show the image container
                }
                reader.readAsDataURL(file); // Read file as data URL
            }
        });
    });

    // Function to remove the selected image
    function removeSelectedImage(postId) {
        var fileInput = document.getElementById('fileInput_' + postId);
        var imageContainer = document.getElementById('selected-image-container_' + postId);
        var imageElement = document.getElementById('selected-image_' + postId);

        fileInput.value = ''; // Reset the file input
        imageElement.src = ''; // Clear the image source
        imageContainer.style.display = 'none'; // Hide the image container
    }

    // Optional: Handle comment key down event if needed
    function handleCommentKeyDown(event, postId) {
        // Handle 'Enter' key for submitting comments if desired
        if (event.key === 'Enter' && !event.shiftKey) {
            event.preventDefault();
            movement_post_comment(postId);
        }
    }
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
function displayConsoleDataInTextarea(data) {
    const textarea = document.getElementById("selectedGifUrl");
    if (textarea) {
        textarea.value = data;
    }
}

document.querySelectorAll('.gif_picker_div_cls').forEach(div => {
    div.addEventListener('click', function(event) {
        if (event.target.tagName === 'IMG') {
            // let url = event.target.src;
            let url = 'This is a url';
            displayConsoleDataInTextarea(consoleData);
            console.log('GIF URL:', url);
        }
    });
});
<?php echo '</script'; ?>
><?php }
}

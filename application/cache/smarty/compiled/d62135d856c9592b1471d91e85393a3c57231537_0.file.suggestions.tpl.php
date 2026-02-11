<?php
/* Smarty version 3.1.28, created on 2025-01-20 06:31:33
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/suggestions.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_678e5e45acb826_63973446',
  'file_dependency' => 
  array (
    'd62135d856c9592b1471d91e85393a3c57231537' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/suggestions.tpl',
      1 => 1737383478,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_678e5e45acb826_63973446 ($_smarty_tpl) {
?>
<style>
    .u-impression-count{float: right;}
    .user-listing ul li + li  {margin-top: 0px;}
    .user-online-video {height:auto;}
</style>
<ul class="scrollbarContent">
    <?php $_smarty_tpl->tpl_vars["suggestions"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->get_user_suggestions(), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "suggestions", 0);?>
    <?php if (count($_smarty_tpl->tpl_vars['suggestions']->value) > 0) {?>
    <div id="container-d17783d3679df95414c4ee84ca0ec1f9"></div>
    <?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['suggestions']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
        <?php if ($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_media_type'] == 'Video') {?>
            <div class="sugested-video-list">
                <?php $_smarty_tpl->tpl_vars['suggest_text'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'suggest_text', 0);?>
                <!--<pre><?php echo print_r($_smarty_tpl->tpl_vars['suggestions']->value);?>
</pre>-->
                    <div class="sugested-video">
                        <a data-id="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],$_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_text']);?>
">
                            <div class="dispduration" style="font-size:10px;position:absolute;right:2px;bottom:10px;background:black;color:white;padding:3px;display:none;"></div>
                            <video width="100%" height="100%" preload="metadata" class="othervideoduration" data-poster="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_video_image'];?>
" muted>
                                <source src="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_upload_file'];?>
" type="video/mp4">
                            </video>
                        </a>
                    </div>
                <div class="suggested-heading-box">
                    <div class="suggested-user">
                        <div class="suggested-user-img">
                            <!-- Note: ID should be unique per suggestion -->
                            <?php if ($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'] != '') {?>
                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_id'],$_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
">
                                <img id="profileImage<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" src="" alt="Profile Image" width="100" height="100">
                            </a>
                            <input type="hidden" id="base64Image<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
">
                            <?php } else { ?>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="">
                            <?php }?>
                        </div>
                        <div class="suggested-user-content">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_id'],$_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
">
                                <h5> <?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
 </h5>
                            </a>
                        </div>
                    </div>
                    <div class="suggested-view">
                        <p><?php echo $_smarty_tpl->tpl_vars['suggestions']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['final_views_count'];?>
</p>
                    </div>
                </div>
            </div>
        <?php }?>
    <?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>

    <?php } else { ?>
        <div class="sugested-video">
            <span><?php echo $_smarty_tpl->tpl_vars['suggestionNotFound']->value;?>
</span>
        </div>
    <?php }?>
</ul>
<?php echo '<script'; ?>
 async="async" data-cfasync="false" src="//pl23652013.highrevenuenetwork.com/d17783d3679df95414c4ee84ca0ec1f9/invoke.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    document.addEventListener('DOMContentLoaded', function() {
        var videos = document.querySelectorAll('.othervideoduration');

        videos.forEach(function(video) {
            // Restart video playback when it ends
            video.addEventListener('ended', function() {
                video.currentTime = 0; // Reset video to the beginning
                video.play(); // Start playing the video again
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
    // Function to get the value of a URL parameter
    function getParameterByName(name, url) {
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    // Function to decode Base64 and set the image URL
    function setProfileImage(base64ImageId, profileImageId) {
        // console.log('function');
        // console.log(base64ImageId);
        const inputElement = document.getElementById(base64ImageId);
        // console.log(inputElement);

        if (inputElement) {
            const dynamicUrl = inputElement.value;
            // console.log(dynamicUrl);
            if (dynamicUrl) {
                // console.log(`Dynamic URL for ${base64ImageId}:`, dynamicUrl);
                const encodedString = getParameterByName('pic', dynamicUrl);
                if (encodedString) {
                    // console.log(`Encoded Base64 String for ${base64ImageId}:`, encodedString);
                    const decodedUrl = atob(encodedString);
                    // console.log(`Decoded URL for ${base64ImageId}:`, decodedUrl);
                    const profileImage = document.getElementById(profileImageId);
                    if (profileImage) {
                        profileImage.src = decodedUrl;
                    } else {
                        console.error(`Profile image element not found: ${profileImageId}`);
                    }
                } else {
                    console.error(`No encoded string found in the URL for ${base64ImageId}`);
                }
            } else {
                console.error(`No dynamic URL found for ${base64ImageId}`);
            }
        } else {
            console.error(`Input element not found: ${base64ImageId}`);
        }
    }

    // Loop through each suggestion and set the profile image
    const base64Elements = document.querySelectorAll("[id^='base64Image']");
    base64Elements.forEach(element => {
        const postId = element.id.replace('base64Image', ''); // Extract post_id from the id
        setProfileImage(`base64Image${postId}`, `profileImage${postId}`);
    });
});

<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
    const videos = document.querySelectorAll('.othervideoduration');

    videos.forEach(video => {
        video.addEventListener('mouseenter', () => {
            video.play();
        });

        video.addEventListener('mouseleave', () => {
            video.pause();
            video.currentTime = 0;
        });
    });
<?php echo '</script'; ?>
><?php }
}

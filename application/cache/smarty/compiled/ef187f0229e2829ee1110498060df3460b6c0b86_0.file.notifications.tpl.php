<?php
/* Smarty version 3.1.28, created on 2024-06-25 05:31:38
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/notifications.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_667ab8aa388da9_90903531',
  'file_dependency' => 
  array (
    'ef187f0229e2829ee1110498060df3460b6c0b86' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/notifications.tpl',
      1 => 1719318623,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_667ab8aa388da9_90903531 ($_smarty_tpl) {
?>

<?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['notifications']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
<li id="notification_<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['notification_id'];?>
">
    <div class="notification-box">
        <div class="notification-user">
            <div class="notification-user-img">
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_id'],$_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
">
                    <img id="nprofileImage<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" src="" alt="Profile Image" width="100" height="100">
                </a>
                <input type="hidden" id="nbase64Image<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_profile_image'];?>
">
            </div>
            <?php $_smarty_tpl->tpl_vars["notification_link"] = new Smarty_Variable('', null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "notification_link", 0);?>
            <?php if ($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_type'] == 'Live' && $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'] > 0) {?>
                <?php $_smarty_tpl->tpl_vars["notification_link"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->setdiplayliveposturl($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "notification_link", 0);?>
            <?php } elseif ($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'] > 0) {?>
                <?php $_smarty_tpl->tpl_vars["notification_link"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'],"post"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "notification_link", 0);?>
            <?php }?>
            <div class="notification-user-content cmn-user-name" >
                <?php if ($_smarty_tpl->tpl_vars['notification_link']->value != '') {?><a href="<?php echo $_smarty_tpl->tpl_vars['notification_link']->value;?>
"><?php }?>
                <h6><span style="color: gray;"><?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_notification_text'];?>
</span></h6>
                <?php if ($_smarty_tpl->tpl_vars['notification_link']->value != '') {?></a><?php }?>
            </div>
        </div>
        <?php if ($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_type'] == 'Follow') {?>
            <div class="follow_block_<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pending_request_id'];?>
">
                <a href="javascript://" data-notificationid="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['notification_id'];?>
" data-follow_request_id="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pending_request_id'];?>
" class="btn btn-primary accept_frequest">Accept</a>
                <a href="javascript://" data-notificationid="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['notification_id'];?>
" data-follow_request_id="<?php echo $_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['pending_request_id'];?>
" class="btn btn-secondary reject_frequest">Reject</a>
            </div>
        <?php }?>
        <div class="notification-hour">
            <p class="notifi-time"><?php echo time_elapsed_string($_smarty_tpl->tpl_vars['notifications']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['un_added_date']);?>
</p>
        </div>
    </div>
</li>
<?php }} else {
 ?>
<p class="no_posts" style="text-align: center;padding: 20px;font-size: 15px;">No notifications at the moment</p>
<?php
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>

<?php echo '<script'; ?>
>
    
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
    function n_setProfileImage(base64ImageId, profileImageId) {
        console.log(`Setting profile image for ${profileImageId}`);
        const inputElement = document.getElementById(base64ImageId);
        const profileImage = document.getElementById(profileImageId);

        if (inputElement && profileImage) {
            const dynamicUrl = inputElement.value;
            if (dynamicUrl) {
                console.log(`Found dynamic URL: ${dynamicUrl}`);
                const encodedString = getParameterByName('pic', dynamicUrl);
                if (encodedString) {
                    console.log(`Encoded String: ${encodedString}`);
                    const decodedUrl = atob(encodedString);
                    console.log(`Decoded URL: ${decodedUrl}`);
                    profileImage.src = decodedUrl;
                } else {
                    console.error(`No encoded string found in the URL for ${base64ImageId}`);
                }
            } else {
                console.error(`No dynamic URL found for ${base64ImageId}`);
            }
        } else {
            if (!inputElement) {
                console.error(`Input element not found: ${base64ImageId}`);
            }
            if (!profileImage) {
                console.error(`Profile image element not found: ${profileImageId}`);
            }
        }
    }

    // Loop through each suggestion and set the profile image
    if (!window.n_base64Elements_newf) {
    // Declare the variable only if it's not already declared
    const n_base64Elements_newf = document.querySelectorAll("[id^='nbase64Image']");
    n_base64Elements_newf.forEach(element => {
        const postId = element.id.replace('nbase64Image', ''); // Extract post_id from the id
        console.log(`Processing postId: ${postId}`);
        n_setProfileImage(`nbase64Image${postId}`, `nprofileImage${postId}`);
    });
}


    function closeModal() {
        var modal = document.getElementById('createPost');
        modal.classList.remove('show');
        modal.style.display = 'none';
        var modalBackdrop = document.getElementsByClassName('modal-backdrop');
        document.body.removeChild(modalBackdrop[0]);
    }
<?php echo '</script'; ?>
>
<?php }
}

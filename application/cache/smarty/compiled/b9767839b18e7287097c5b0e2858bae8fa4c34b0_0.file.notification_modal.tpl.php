<?php
/* Smarty version 3.1.28, created on 2025-01-29 02:53:53
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/notification_modal.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_679a08c1e08fd3_41714547',
  'file_dependency' => 
  array (
    'b9767839b18e7287097c5b0e2858bae8fa4c34b0' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/notification_modal.tpl',
      1 => 1738148003,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_679a08c1e08fd3_41714547 ($_smarty_tpl) {
?>
<style>
    .modal-body {
    max-height: 400px; /* Set a max height */
    overflow-y: auto;  /* Adds vertical scrollbar when content exceeds the max height */
}
</style>

<div class="modal fade notification-popup" id="notificationNewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 54%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel"><?php echo $_smarty_tpl->tpl_vars['notification']->value;?>
</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div class="notification-inactive">
                    <ul>
                    <?php
$_from = $_smarty_tpl->tpl_vars['notifications']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
                    <?php $_smarty_tpl->tpl_vars['follow_request_id'] = new Smarty_Variable($_smarty_tpl->tpl_vars['row']->value['pending_request_id'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'follow_request_id', 0);?>
                    <!--<?php echo $_smarty_tpl->tpl_vars['follow_request_id']->value;?>
-->
                    <!--<?php echo print_r($_smarty_tpl->tpl_vars['row']->value);?>
-->
                        <li>
                            <div class="notification-box">
                                <div class="notification-user">
                                    <div class="notification-user-img">
                                        <img id="profileImage<?php echo $_smarty_tpl->tpl_vars['row']->value['notification_id'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_profile_image'];?>
" alt="">
                                        <input type="hidden" id="base64Image<?php echo $_smarty_tpl->tpl_vars['row']->value['notification_id'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['user_profile_image'];?>
">
                                    </div>
                                    <?php if ($_smarty_tpl->tpl_vars['row']->value['un_type'] == 'Post') {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['post_id'],$_smarty_tpl->tpl_vars['row']->value['un_notification_text']);?>
" style="color: black">
                                            <div class="notification-user-content">
                                                <h6><?php echo $_smarty_tpl->tpl_vars['row']->value['un_notification_text'];?>
</h6>
                                                
                                                <span><?php echo $_smarty_tpl->tpl_vars['row']->value['un_added_date'];?>
</span>
                                            </div>
                                        </a>
                                    <?php } else { ?>
                                        <div class="notification-user-content">
                                            <h6><?php echo $_smarty_tpl->tpl_vars['row']->value['un_notification_text'];?>
</h6>
                                            <span><?php echo $_smarty_tpl->tpl_vars['row']->value['un_added_date'];?>
</span>
                                        </div>
                                    <?php }?>
                                </div>
                                <!--<?php echo print_r($_smarty_tpl->tpl_vars['row']->value);?>
-->
                                <?php if ($_smarty_tpl->tpl_vars['row']->value['code'] == 'FR' || $_smarty_tpl->tpl_vars['row']->value['code'] == 'MR') {?>
                                    <div class="notification-hour" id="follower-buttons-<?php echo $_smarty_tpl->tpl_vars['follow_request_id']->value;?>
">
                                        <?php if ($_smarty_tpl->tpl_vars['row']->value['uf_status'] == 'Pending' || $_smarty_tpl->tpl_vars['row']->value['uf_status'] == '') {?>
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/movementjoin');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['un_movement_id'];?>
"><button class="btn btn-success">Accept</button></a>
                                            <button class="btn btn-danger" style="margin-left: 10px;" onclick="followerAction(<?php echo $_smarty_tpl->tpl_vars['follow_request_id']->value;?>
, 'Rejected')">Reject</button>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['uf_status'] == 'Accepted') {?>
                                            <button class="btn btn-success" style="margin-left: 10px;"><?php echo $_smarty_tpl->tpl_vars['accepted']->value;?>
</button>
                                        <?php } else { ?>
                                            <button class="btn btn-danger" style="margin-left: 10px;"><?php echo $_smarty_tpl->tpl_vars['rejected']->value;?>
</button>
                                        <?php }?>
                                    </div>
                                <?php }?>
                            </div>
                        </li>
                    <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Block User-->
<div class="modal fade" id="blockUserNewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="blockUserNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 36%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blockUserNewModalLabel"><?php echo $_smarty_tpl->tpl_vars['block_user_list']->value;?>
</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="notification-inactive">
                    <ul>
                        <!-- No blocked users content -->
                        <?php if (!empty($_smarty_tpl->tpl_vars['blockuser']->value)) {?>
                        <?php
$_from = $_smarty_tpl->tpl_vars['blockuser']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_1_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_1_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_1_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_1_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
                        <li>
                            <div class="notification-box">
                                <div class="notification-user">
                                    <div class="notification-user-img">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_profile_image'];?>
" alt="">
                                    </div>
                                    
                                        <div class="notification-user-content">
                                            <!--<?php echo print_r($_smarty_tpl->tpl_vars['notifications']->value);?>
-->
                                            <h6><?php echo $_smarty_tpl->tpl_vars['row']->value['u_name'];?>
</h6>
                                            <span><?php echo $_smarty_tpl->tpl_vars['row']->value['u_email'];?>
</span>
                                            <!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>-->
                                        </div>
                                </div>
                                
                                <div class="notification-hour">
                                    <?php if ($_smarty_tpl->tpl_vars['row']->value['bc_eStatus'] == 'block') {?>
                                        <button class="btn btn-success">Unblock</button>
                                    <?php } else { ?>
                                        <button class="btn btn-danger" style="margin-left: 10px;">Block</button>
                                    <?php }?>
                                </div>  
                            </div>
                        </li>
                        <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved_local_item;
}
}
if ($__foreach_row_1_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_1_saved_item;
}
?>
                        <?php } else { ?>
                        <li>
                            <div class="notification-box">
                                <div class="notification-user">
                                    
                                    <div class="notification-user-content">
                                        <span>No Result Found</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <!--<div class="notification-active">
                    <ul>
                        <li>
                            <div class="notification-box">
                                <div class="notification-user">
                                    <div class="notification-user-img">
                                        <img src="images/notify.png" alt="">
                                    </div>
                                    <div class="notification-user-content">
                                        <h4>George Jack</h4>
                                        <span>Commented on your photo</span>
                                    </div>
                                </div>
                                <div class="notification-hour">
                                    <p>26 min ago</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>-->
            </div>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
>
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
                    //console.log(`Decoded URL for ${base64ImageId}:`, decodedUrl);
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

<!-- For Notification Action-->

<?php echo '<script'; ?>
>
    function followerAction(follow_request_id, status){
    console.log('follow_request_id: ' + follow_request_id);
    console.log('status: ' + status);
    
    var url = "<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/home/followUser');?>
";

    $.ajax({
        url: url,
        type: "POST",
        data: { 
            follow_request_id: follow_request_id,
            status: status,
        },
        dataType: "json", // Expect JSON response
        success: function(response) {
            console.log("Parsed response:", response);
            var buttonContainer = $('#follower-buttons-' + follow_request_id);

            if (response.success) {
                if (response.set_btn === 'Accepted') {
                    buttonContainer.html('<button class="btn btn-success" style="margin-left: 10px;">Accepted</button>');
                } else if (response.set_btn === 'Rejected') {
                    buttonContainer.html('<button class="btn btn-danger" style="margin-left: 10px;">Rejected</button>');
                } else {
                    buttonContainer.html(
                        '<button class="btn btn-success" onclick="followerAction(' + follow_request_id + ', \'Accepted\')">Accept</button>' +
                        '<button class="btn btn-danger" style="margin-left: 10px;" onclick="followerAction(' + follow_request_id + ', \'Rejected\')">Reject</button>'
                    );
                }
            } else {
                console.error("Error processing follow request:", response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error:", textStatus, errorThrown);
            console.log("Full jqXHR object:", jqXHR);
            console.log("Response text:", jqXHR.responseText); // Log server response
        }
    });
}

<?php echo '</script'; ?>
><?php }
}

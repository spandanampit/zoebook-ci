<?php
/* Smarty version 3.1.28, created on 2024-08-14 08:00:24
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/golive/views/publishing.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_66bcc6882c8fe8_74437807',
  'file_dependency' => 
  array (
    '63ab710e335fd08a132bd8fdff13bff978ec82d7' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/golive/views/publishing.tpl',
      1 => 1723647547,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66bcc6882c8fe8_74437807 ($_smarty_tpl) {
?>

<style type="text/css">
    #videos {
    position: relative;
    width: 100%;
    height: 100%;
    margin-left: auto;
    margin-right: auto;
}

#publisher {
    position: absolute;
    width: 98%;
    height: calc(100vh - 306px) !important;
    top: 3%;
    bottom: 9%;
    left: 1%;
    left: 1%;
    z-index: 100;
    border: 3px solid white;
    border-radius: 14px;
}
h3{
    color: #fff;
    margin: 0 auto;
    padding: 9px;
    font-size: 21px;
}
.live-user-comment{
    z-index: 1111;
    height: auto;
}
.stream-msg-history{
    max-height: 500px;
    overflow: auto;
}
.btn{
    margin-bottom: 10px !important;
}

</style>
<div class="golive-page dashboard-sec">
    <div class="container">
        <div class="live-screen">
            <div class="live-streaming">
                <h3>&nbsp;You are live <?php echo $_smarty_tpl->tpl_vars['get_post_details']->value['user_name'];?>
</h3>
                <div id="videos">
                    <div id="publisher"></div>
                </div>
                <div class="live-timer">
                    <div class="impression" style="background-color: transparent !important;">
                    </div>
                </div>
                <div class="live-user-comment">
                    <ul class="msg-header">
                        <li class="frist-li">
                            <div class="cmn-user">
                                <i class="cmn-user-img">
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['get_post_details']->value['user_profile_image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['get_post_details']->value['user_name'];?>
">
                                </i>
                                <div class="cmn-user-name">
                                    <h6><a href="#"><?php echo $_smarty_tpl->tpl_vars['get_post_details']->value['user_name'];?>
</a></h6>
                                    <p><?php echo $_smarty_tpl->tpl_vars['get_post_details']->value['post_text'];?>
</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <ul class="stream-msg-history">
                    </ul>
                    <ul class="message-text">
                        <li class="type-live-msg">
                            <textarea rows="2" class="form-control stream-message-input" placeholder="Write your message" onkeypress="onTextChange();"></textarea>
                        </li>
                    </ul>
                </div>
                <div class="finish-btn-row">
                    <div class="live-timer">
                        <div class="timer">
                            <span><i class="fas fa-circle"></i> Live</span>
                            <span id="down_timer" style="color:#fff !important">00:00:00</span>
                        </div>
                    </div>
                    <button type="button" class="btn finish-stream" ><i class='fas fa-phone-slash' style='color:white'></i> Finish</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">
var apiKey = "<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('TOKBOX_PROJECT_API_KEY');?>
";
var sessionId = '<?php echo $_smarty_tpl->tpl_vars['session_id']->value;?>
';
var tokbox_session_id = '<?php echo $_smarty_tpl->tpl_vars['tokbox_session_id']->value;?>
';
var token = "<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
";
const live_token = "<?php echo $_smarty_tpl->tpl_vars['token']->value;?>
";
console.log('tokennnnnnnn'+ token);
var startStamp = '<?php echo $_smarty_tpl->tpl_vars['start_date_time']->value;?>
';
var profile_name = "<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vName');?>
" ;
var profile_image = "<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vProfileImage');?>
";

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

    $(document).ready(function() {
        // Initialize Emoji Picker
        $('.stream-message-input').emojiPicker({
            width: '300px',
            height: 'auto',
            button: false
        });

        // Emoji Picker Toggle on click
        $('.stream-message-input').click(function() {
            $(this).emojiPicker('toggle');
        });

        // Open GIF section
        $('.open_gif_section').click(function() {
            var postId = $(this).data('gif-post-id');
            $('.gif_section_' + postId).show();
        });

        // Close GIF section
        $('.close_gif_div_').click(function() {
            var postId = $(this).data('gif-post-id');
            $('.gif_section_' + postId).hide();
        });

        // Handle file upload (for stickers/GIFs)
        $('.btn_post_media_attach').click(function() {
            var postId = $(this).find('.btn_postmedia').data('postid');
            $('#input_media_' + postId).click();
        });

        // Handle sticker selection (example placeholder)
        $('.open_sticker_section').click(function() {
            var postId = $(this).data('sticker-post-id');
            alert('Sticker selected for post ID: ' + postId);
        });
    });
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/opentok/opentok.min.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/opentok/publish.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat-count.js");?>




<?php }
}

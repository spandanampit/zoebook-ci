<?php
/* Smarty version 3.1.28, created on 2024-02-08 12:04:10
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/golive/views/publishing.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c475e2dce767_05544339',
  'file_dependency' => 
  array (
    '89ade8a8aae4da9dba51ca170627c72b4d736a58' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/golive/views/publishing.tpl',
      1 => 1706090579,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65c475e2dce767_05544339 ($_smarty_tpl) {
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
    height: 83%;
    top: 3%;
    bottom: 5%;
    left: 1%;
    left: 1%;
    z-index: 100;
    border: 3px solid white;
    border-radius: 3px;
}
h3{
    color: #fff;
    margin: 0 auto;
}
.live-user-comment{
    z-index: 1111;
    height: auto;
}
.stream-msg-history{
    max-height: 500px;
    overflow: auto;
}
</style>
<div class="golive-page">
    <div class="container">
        <div class="live-screen">
            <div class="live-streaming">
                <h3>&nbsp;You are live @ "<?php echo $_smarty_tpl->tpl_vars['get_post_details']->value['post_text'];?>
"</h3>
            <div id="videos">
                <div id="publisher"></div>
            </div>

                <div class="live-timer">
                    <div class="timer">
                        <span><i class="fas fa-circle"></i> Live</span>
                        <span id="down_timer">00:00:00</span>
                    </div>
                    <div class="impression">
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
                            <textarea rows="2" class="form-control stream-message-input"  placeholder="Write your message" onkeypress="onTextChange();"></textarea>
                        </li>
                    </ul>
                </div>
                <div class="finish-btn-row">
                    <button type="button" class="btn finish-stream" ><i class="fas fa-video-slash"></i> Finish</button>
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
var startStamp = '<?php echo $_smarty_tpl->tpl_vars['start_date_time']->value;?>
';
var profile_name = "<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vName');?>
" ;
var profile_image = "<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vProfileImage');?>
";

<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/opentok/opentok.min.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/opentok/publish.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat-count.js");?>




<?php }
}

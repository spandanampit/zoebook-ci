<?php
/* Smarty version 3.1.28, created on 2024-03-27 14:57:33
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/chat.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_6603e6852dbfd4_06736528',
  'file_dependency' => 
  array (
    'f96c53f0612422222a97ecb8578b8d5371426899' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/content/views/chat.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6603e6852dbfd4_06736528 ($_smarty_tpl) {
?>
<style type="text/css">
    .chat-block{display: none;}
</style>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat.js");?>

<div class="post-pages chat-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="cmn-white-block left-panel online-people-block">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <input type="hidden" name="firebase_token" id="firebase_token" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('firebase_token');?>
">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId');?>
">
                            <input type="hidden" name="username" id="username" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vName');?>
">
                            <input type="hidden" name="email" id="email" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vEmail');?>
">
                            <input type="hidden" name="profile_image" id="profile_image" value="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vProfileImage');?>
">
                            <div>Friends</div>
                            <div class="search-friend">
                                <div class="ui-widget">
                                    <span class="fa fa-search"></span>
                                </div>
                            </div>
                            <input type="text" class="form-control" id="search" placeholder="Search">
                        </div>
                        <div class="inbox_chat_list">
                            <ul>
                                <span>Connecting.....! </span><br>
                                <span>Please wait while we fetch your chats..!</span>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="cmn-white-block">
                    <div class="message-user">

                    </div>
                    <div class="messaging">
                        <div class="inbox_msg">
                            <div class="mesgs">
                                <div class="msg_history">
                                <h3>Welcome to Zoebook Chat.</h3>
                                <h4>Lets Connect to the World.</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="message-type hide">
                        <div class="input_msg_write">
                            <input type="text" class="form-control message-input" id="message_input" placeholder="Type a message" autofocus/>
                            <button class="msg_send_btn" type="button"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php }
}

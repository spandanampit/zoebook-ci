<?php
/* Smarty version 3.1.28, created on 2024-09-25 13:56:55
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/comments_replies.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_66f47917187fd0_30508354',
  'file_dependency' => 
  array (
    'c7015655099c9d7f931728fcadb97c166acef1c9' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/common/comments_replies.tpl',
      1 => 1727297811,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66f47917187fd0_30508354 ($_smarty_tpl) {
$_from = $_smarty_tpl->tpl_vars['comment']->value['reply_details'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_reply_0_saved_item = isset($_smarty_tpl->tpl_vars['reply']) ? $_smarty_tpl->tpl_vars['reply'] : false;
$_smarty_tpl->tpl_vars['reply'] = new Smarty_Variable();
$__foreach_reply_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_reply_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['reply']->value) {
$__foreach_reply_0_saved_local_item = $_smarty_tpl->tpl_vars['reply'];
?>
                                <!--<?php echo print_r($_smarty_tpl->tpl_vars['reply']->value);?>
-->
                                <li id="showreplyloader" style="margin-right:25px;">
                                <div class="user-comments-row">
                                    <div class="comments-block">
                                        <div class="comments-user-row">
                                            <div class="comments-user-details">
                                                <i class="cmn-user-img" style="min-width: 37px !important; height: 39px !important; width: 0px !important;">
                                                    <a href="" class="name">
                                                        <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['reply']->value['profile_image'];?>
" alt="" class="img-fluid" style="height: 4rem !important;">
                                                    </a>
                                                </i>
                                                <h6 style="display: flex;">
                                                    <a href="" class="name"><?php echo $_smarty_tpl->tpl_vars['reply']->value['user_name'];?>
</a>
                            
                                                    <div class="comments-time"><?php echo time_elapsed_string($_smarty_tpl->tpl_vars['reply']->value['added_date']);?>
</div>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="user-comments">
                                            <p><?php echo $_smarty_tpl->tpl_vars['reply']->value['comment'];?>
</p>
                                                <!--<video controls height="auto" width="300px">
                                                    <source src="" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>-->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <?php
$_smarty_tpl->tpl_vars['reply'] = $__foreach_reply_0_saved_local_item;
}
}
if ($__foreach_reply_0_saved_item) {
$_smarty_tpl->tpl_vars['reply'] = $__foreach_reply_0_saved_item;
}
}
}

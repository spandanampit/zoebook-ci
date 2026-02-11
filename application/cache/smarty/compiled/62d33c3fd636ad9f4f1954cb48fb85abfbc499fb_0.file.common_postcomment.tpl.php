<?php
/* Smarty version 3.1.28, created on 2025-02-13 05:56:41
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_postcomment.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67adfa19cba748_13596636',
  'file_dependency' => 
  array (
    '62d33c3fd636ad9f4f1954cb48fb85abfbc499fb' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_postcomment.tpl',
      1 => 1739454996,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/common_replycomment.tpl' => 1,
  ),
),false)) {
function content_67adfa19cba748_13596636 ($_smarty_tpl) {
?>
<pre>
<?php echo print_r($_smarty_tpl->tpl_vars['postcomment']->value);?>

</pre>

<style>
.cmt-img {
    height: 50px !important;
    width: 50px !important;
    object-fit: cover;
    border-radius: 50px;
}
</style>

<?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['postcomment']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
<li class="child">
  <div class="comment">
    <div class="comment-pics">
      <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['profile_image'];?>
" alt="" style="height: 50px !important;" class="cmt-img"> 
    </div>
    <div class="comment-text">
      <div class="coment-heading">
        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_id'],$_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name']);?>
" class="name"><h5><?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_name'];?>
</h5></a>
        <p><?php echo time_elapsed_string($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['added_date']);?>
</p>
      </div>
      <?php if ($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['user_id'] == $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') || $_smarty_tpl->tpl_vars['postinfo']->value['posted_user_id'] == $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId')) {?>
        <div style="width:7%;">
          <a href="javascript:" class="deletepostcomment" data-postid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" title="Delete"><i class="fas fa-trash"></i></a>
        </div>
      <?php }?>
      <div class="comment-text-wrap">
          
          <?php $_smarty_tpl->tpl_vars['comment_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['comment']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'comment_text', 0);?>
          <?php $_smarty_tpl->tpl_vars['comment_text_format'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['comment_text']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'comment_text_format', 0);?>

          <!-- Display GIF below the comment text -->
          <?php if (strpos($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['comment'],'giphy.com') !== false) {?>
              <img src="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['comment'];?>
" height="auto" width="33% !important" alt="" style="width: 33% !important">
          <?php } else { ?>
              <?php if ($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['upload_file'] != '') {?>
                  <img src="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['upload_file'];?>
" class="upld_img" alt="">
                  <?php $_smarty_tpl->tpl_vars['fileExt'] = new Smarty_Variable(pathinfo($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['upload_file'],PATHINFO_EXTENSION), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'fileExt', 0);?>
                  <?php if ($_smarty_tpl->tpl_vars['fileExt']->value == 'mp4' || $_smarty_tpl->tpl_vars['fileExt']->value == 'avi' || $_smarty_tpl->tpl_vars['fileExt']->value == 'mkv' || $_smarty_tpl->tpl_vars['fileExt']->value == 'mov') {?>
                      <video controls height="auto" width="300px">
                          <source src="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['upload_file'];?>
" type="video/mp4">
                          Your browser does not support the video tag.
                      </video>
                  <?php } elseif ($_smarty_tpl->tpl_vars['fileExt']->value == 'png' || $_smarty_tpl->tpl_vars['fileExt']->value == 'jpg' || $_smarty_tpl->tpl_vars['fileExt']->value == 'jpeg' || $_smarty_tpl->tpl_vars['fileExt']->value == 'svg') {?>
                      <img src="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['upload_file'];?>
" class="upld_img" width="300px" alt="">
                  <?php }?>
              <?php }?>
              <p class="displayemoji_comment"><?php echo nl2br($_smarty_tpl->tpl_vars['comment_text_format']->value);?>
</p> 
          <?php }?>
      </div>

      <div class="comment-like-reply">
        <?php if ($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['count_comment_likes'] == '') {?>
          <?php $_smarty_tpl->tpl_vars['showpostlike'] = new Smarty_Variable(0, null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'showpostlike', 0);?>
        <?php } else { ?>
          <?php $_smarty_tpl->tpl_vars['showpostlike'] = new Smarty_Variable($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['count_comment_likes'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'showpostlike', 0);?>
        <?php }?>
        <ul class = "ul-comment-sec">
          <li>
            <a id="postlike_<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" href="javascript:void(0)" data-postid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" class="<?php if ($_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['is_comment_like'] == 1) {?>active <?php } else { ?>grey-link <?php }?> like-post act_likepostcomment" style="margin-right:7px;"><i class="fa-solid fa-thumbs-up"></i> 
              <a href="javascript:" class="disp_postcommentlikes" data-pageindex="" data-postid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" ><span data-commentlikescount="<?php echo $_smarty_tpl->tpl_vars['showpostlike']->value;?>
" id="commentlikes_count_<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['showpostlike']->value;?>
</span><?php if ($_smarty_tpl->tpl_vars['showpostlike']->value == 1) {
echo $_smarty_tpl->tpl_vars['like']->value;
} else {
echo $_smarty_tpl->tpl_vars['likes']->value;
}?></a>
            </a>
          </li>
          <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') != '') {?>     
          <div class="reply-comments">
            <a href="javascript:void(0);" class="postreply-link"><?php echo $_smarty_tpl->tpl_vars['reply']->value;?>
</a>
          </div>
          <?php }?>
              <div class="reply-comment-box" style="display:none; color:grey">
                <textarea class="form-control reply_postcomment" rows="1" placeholder="Reply Comment" data-postid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
" data-mediaid="<?php echo $_smarty_tpl->tpl_vars['mediaid']->value;?>
" name="replycommentad" id="replycommentad_<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
"></textarea>
                <span class="err_msg_<?php echo $_smarty_tpl->tpl_vars['posts']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_id'];?>
" style="font-size: 12px; color: #4e4c4c;"></span>
                <span style="font-size:15px;"><?php echo $_smarty_tpl->tpl_vars['press_enter_to_reply']->value;?>
</span>
              </div>
        </ul>
        <div class="feed-comments  scrollbarContent scrolldefineheight" style="width:97%">
          <ul id="replycommentshow_<?php echo $_smarty_tpl->tpl_vars['postcomment']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['post_comment_id'];?>
">
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/common_replycomment.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>

          </ul>
        </div> 
      </div>
    </div>
  </div>
</li>
<?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
}
}

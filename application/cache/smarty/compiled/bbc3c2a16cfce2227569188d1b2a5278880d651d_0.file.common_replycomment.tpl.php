<?php
/* Smarty version 3.1.28, created on 2024-12-10 03:04:39
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_replycomment.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67582047d28b47_73514191',
  'file_dependency' => 
  array (
    'bbc3c2a16cfce2227569188d1b2a5278880d651d' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_replycomment.tpl',
      1 => 1733828673,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67582047d28b47_73514191 ($_smarty_tpl) {
?>
<style>
.img-fluid {
    height: 50px !important;
    width: 50px !important;
    object-fit: cover;
    border-radius: 50px;
}
</style>

<?php
$__section_in_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_in']) ? $_smarty_tpl->tpl_vars['__section_in'] : false;
$__section_in_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['showpostreplyarr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_in_0_total = $__section_in_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_in'] = new Smarty_Variable(array());
if ($__section_in_0_total != 0) {
for ($__section_in_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] = 0; $__section_in_0_iteration <= $__section_in_0_total; $__section_in_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']++){
?>
<li id="showreplyloader_<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['reply_id'];?>
" style="margin-right:14rem;">
  <div class="user-comments-row">
    <div class="comments-block">
      <div class="comments-user-row">
          <div class="comments-user-details">
              <i class="cmn-user-img">
                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['profile_image'];?>
" alt="" class="img-fluid">
              </i>
              <h6>
                  <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['user_id'],$_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['user_name']);?>
" class="name"><?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['user_name'];?>
</a>

                  <div class="comments-time">
                    <?php echo time_elapsed_string($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['added_date']);?>

                </div>
              </h6>
          </div> 
          <?php if ($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['user_id'] == $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') || $_smarty_tpl->tpl_vars['postinfo']->value['posted_user_id'] == $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId')) {?>
          <div>
                <a href="javascript:" class="deletereplycomment" data-postid="<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['post_id'];?>
" data-postcommentid="<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['reply_id'];?>
" title="Delete"><i class="fas fa-trash"></i></a>
          </div>
          <?php }?>
      </div>
      <div class="user-comments">
        <?php $_smarty_tpl->tpl_vars['reply_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['comment']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'reply_text', 0);?>
        <?php $_smarty_tpl->tpl_vars['reply_text_format'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['reply_text']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'reply_text_format', 0);?>
        <p><?php echo nl2br($_smarty_tpl->tpl_vars['reply_text_format']->value);?>
</p>
      </div>
    </div>
  </div>
</li>
<?php
}
}
if ($__section_in_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_in'] = $__section_in_0_saved;
}
}
}

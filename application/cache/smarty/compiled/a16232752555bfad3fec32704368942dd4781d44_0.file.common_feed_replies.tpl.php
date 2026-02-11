<?php
/* Smarty version 3.1.28, created on 2024-05-24 03:55:04
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_feed_replies.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_66507208ebff24_97986038',
  'file_dependency' => 
  array (
    'a16232752555bfad3fec32704368942dd4781d44' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/common_feed_replies.tpl',
      1 => 1716548085,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_66507208ebff24_97986038 ($_smarty_tpl) {
$__section_in_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_in']) ? $_smarty_tpl->tpl_vars['__section_in'] : false;
$__section_in_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['showpostreplyarr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_in_0_total = $__section_in_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_in'] = new Smarty_Variable(array());
if ($__section_in_0_total != 0) {
for ($__section_in_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] = 0; $__section_in_0_iteration <= $__section_in_0_total; $__section_in_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']++){
?>
    <li id="showreplyloader_<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['reply_id'];?>
" style="margin-right:25px;">
        <div class="user-comments-row">
            <div class="comments-block">
                <div class="comments-user-row">
                    <div class="comments-user-details">
                        <i class="cmn-user-img">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['user_id'],$_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['user_name']);?>
" class="name">
                                <img src="https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['profile_image'];?>
" alt="" class="img-fluid">
                            </a>
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
                </div>
                <div class="user-comments">
                    <?php $_smarty_tpl->tpl_vars['reply_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->linkify($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['comment']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'reply_text', 0);?>
                    <?php $_smarty_tpl->tpl_vars['reply_text_format'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['reply_text']->value), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'reply_text_format', 0);?>

                    

                    <?php if (strpos($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['comment'],'giphy.com') !== false) {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['comment'];?>
" height="auto" width="100px" alt="">
                    <?php } else { ?>
                        
                        <?php if ($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['upload_file'] != '') {?>
                            
                            <?php $_smarty_tpl->tpl_vars['fileExt'] = new Smarty_Variable(pathinfo($_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['upload_file'],PATHINFO_EXTENSION), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'fileExt', 0);?>

                            <?php if ($_smarty_tpl->tpl_vars['fileExt']->value == 'mp4' || $_smarty_tpl->tpl_vars['fileExt']->value == 'avi' || $_smarty_tpl->tpl_vars['fileExt']->value == 'mkv' || $_smarty_tpl->tpl_vars['fileExt']->value == 'mov') {?>
                                <video controls height="auto" width="300px">
                                    <source src="<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['upload_file'];?>
" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            <?php } elseif ($_smarty_tpl->tpl_vars['fileExt']->value == 'png' || $_smarty_tpl->tpl_vars['fileExt']->value == 'jpg' || $_smarty_tpl->tpl_vars['fileExt']->value == 'jpeg' || $_smarty_tpl->tpl_vars['fileExt']->value == 'svg') {?>
                                <img src="<?php echo $_smarty_tpl->tpl_vars['showpostreplyarr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_in']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_in']->value['index'] : null)]['upload_file'];?>
" class="upld_img" width="300px" alt="">
                            <?php }?>

                        <?php }?>

                        <p><?php echo nl2br($_smarty_tpl->tpl_vars['reply_text_format']->value);?>
</p>
                        
                        
                    <?php }?>

                    
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

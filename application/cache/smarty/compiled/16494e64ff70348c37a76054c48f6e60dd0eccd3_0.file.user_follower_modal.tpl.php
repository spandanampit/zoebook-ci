<?php
/* Smarty version 3.1.28, created on 2024-12-12 02:33:05
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/user_follower_modal.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_675abbe15cedc4_41324824',
  'file_dependency' => 
  array (
    '16494e64ff70348c37a76054c48f6e60dd0eccd3' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/common/user_follower_modal.tpl',
      1 => 1733997654,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_675abbe15cedc4_41324824 ($_smarty_tpl) {
?>
<style>
.search-image {
    min-height: 12rem;
    max-height: 12rem; 
    object-fit: cover;
}
</style>

<ul> 
<?php if (count($_smarty_tpl->tpl_vars['followarr']->value) > 0) {
if ($_smarty_tpl->tpl_vars['isfromsearch']->value != '') {?>
    <li style="font-size: 20px;color: green;font-weight: 500;">Search result for : "<?php echo $_smarty_tpl->tpl_vars['isfromsearch']->value;?>
"</li>
<?php }?>
<!--<?php echo print_r($_smarty_tpl->tpl_vars['row']->value);?>
-->
        <section class="video-sec">
            <div class="container">
                <div class="row mb-40">
                    <div class="col-md-12">
                        <div class="video-grid">

                            <?php
$_from = $_smarty_tpl->tpl_vars['browseprofile']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$__foreach_row_0_saved_key = isset($_smarty_tpl->tpl_vars['i']) ? $_smarty_tpl->tpl_vars['i'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_0_total) {
$_smarty_tpl->tpl_vars['i'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['i']->value => $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
                                <?php if (isset($_smarty_tpl->tpl_vars['row']->value['iPostId'])) {?>
                                    <div class="video-item">
                                        <div class="video-box">
                                            <?php $_smarty_tpl->tpl_vars['jsonData'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->getSearchPostThumbnail($_smarty_tpl->tpl_vars['row']->value['iPostId']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'jsonData', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['vUploadFile'] = new Smarty_Variable(substr($_smarty_tpl->tpl_vars['jsonData']->value,strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vUploadFile":"')+strlen('"vUploadFile":"'),strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"',strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vUploadFile":"')+strlen('"vUploadFile":"'))-strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vUploadFile":"')-strlen('"vUploadFile":"')), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'vUploadFile', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['eMediaType'] = new Smarty_Variable(substr($_smarty_tpl->tpl_vars['jsonData']->value,strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"eMediaType":"')+strlen('"eMediaType":"'),strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"',strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"eMediaType":"')+strlen('"eMediaType":"'))-strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"eMediaType":"')-strlen('"eMediaType":"')), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'eMediaType', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['vVideoThumbnail'] = new Smarty_Variable(substr($_smarty_tpl->tpl_vars['jsonData']->value,strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vVideoThumbnail":"')+strlen('"vVideoThumbnail":"'),strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"',strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vVideoThumbnail":"')+strlen('"vVideoThumbnail":"'))-strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vVideoThumbnail":"')-strlen('"vVideoThumbnail":"')), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'vVideoThumbnail', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['vCloudinary'] = new Smarty_Variable(substr($_smarty_tpl->tpl_vars['jsonData']->value,strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vCloudinary":"')+strlen('"vCloudinary":"'),strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"',strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vCloudinary":"')+strlen('"vCloudinary":"'))-strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vCloudinary":"')-strlen('"vCloudinary":"')), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'vCloudinary', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['iUserId'] = new Smarty_Variable(substr($_smarty_tpl->tpl_vars['jsonData']->value,strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"iUserId":"')+strlen('"iUserId":"'),strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"',strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"iUserId":"')+strlen('"iUserId":"'))-strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"iUserId":"')-strlen('"iUserId":"')), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'iUserId', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['vSourceType'] = new Smarty_Variable(substr($_smarty_tpl->tpl_vars['jsonData']->value,strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vSourceType":"')+strlen('"vSourceType":"'),strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"',strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vSourceType":"')+strlen('"vSourceType":"'))-strpos($_smarty_tpl->tpl_vars['jsonData']->value,'"vSourceType":"')-strlen('"vSourceType":"')), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'vSourceType', 0);?>

                                            <div class="video-img-box">
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['iPostId'],$_smarty_tpl->tpl_vars['row']->value['tPostTextEmoji']);?>
">
                                                    <?php if ($_smarty_tpl->tpl_vars['eMediaType']->value == 'Image') {?>
                                                        <img class="search-image" src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['iUserId']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['vUploadFile']->value;?>
" alt="Image 1" >
                                                    <?php } elseif ($_smarty_tpl->tpl_vars['eMediaType']->value == 'Video') {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['vSourceType']->value == 'aws') {?>
                                                            <?php $_smarty_tpl->tpl_vars['vVideoThumbnailExtension'] = new Smarty_Variable(substr($_smarty_tpl->tpl_vars['vVideoThumbnail']->value,strrpos($_smarty_tpl->tpl_vars['vVideoThumbnail']->value,'.')+1), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'vVideoThumbnailExtension', 0);?>
                                                            <?php if ($_smarty_tpl->tpl_vars['vVideoThumbnailExtension']->value == 'mp4') {?>
                                                                <img class="search-image " src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture Image 2">
                                                            <?php } else { ?>
                                                                <img class="search-image " src="https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/<?php echo $_smarty_tpl->tpl_vars['iUserId']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['vVideoThumbnail']->value;?>
" alt="Image 2">
                                                            <?php }?>
                                                        <?php } elseif ($_smarty_tpl->tpl_vars['vSourceType']->value == 'cld') {?>
                                                            <img class="search-image" src="<?php echo $_smarty_tpl->tpl_vars['vCloudinary']->value;?>
" alt="">
                                                        <?php } else { ?>
                                                            <img class="search-image" src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture Image 3">
                                                        <?php }?>
                                                    <?php } else { ?>
                                                        <img class="search-image" src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture ">
                                                    <?php }?>
                                                </a>
                                            </div>
                                            <div class="video-content">
                                                <a style="line-height: 43px;" data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['iPostId'];?>
" data-loop="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayposturl($_smarty_tpl->tpl_vars['row']->value['iPostId'],$_smarty_tpl->tpl_vars['row']->value['tPostText']);?>
">
                                                    <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['tPostTextEmoji']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
                                                    <?php $_smarty_tpl->tpl_vars['posted_sub_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,30), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_sub_text', 0);?>
                                                    <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_sub_text']->value);?>
</p>
                                                </a>
                                                <div class="video-view">
                                                    <ul>
                                                    <li class="yellow-color"><?php echo $_smarty_tpl->tpl_vars['row']->value['iImpressionCount'];?>
 Views</li>
                                                    <li class="dot"></li>                                          
                                                    <li class="sub-color"><?php echo time_elapsed_string($_smarty_tpl->tpl_vars['row']->value['dAddedDate']);?>
</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="video-item">
                                        <div class="video-box">
                                            <div class="video-img-box" style="border-radius: 50%; height: 12rem; width: 88%">
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['row']->value['u_users_id'],$_smarty_tpl->tpl_vars['row']->value['u_name']);?>
">
                                                    <img class="search-image" src="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_profile_image'];?>
" alt="">
                                                </a>
                                            </div>
                                            <div class="video-content">
                                                <!--<div class="video-heading">
                                                    <h3>It is a long established</h3>
                                                    <a href="#"><i class="fa-solid fa-ellipsis-vertical"></i></a>
                                                </div>-->
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->general->setdiplayprofileurl($_smarty_tpl->tpl_vars['row']->value['u_users_id'],$_smarty_tpl->tpl_vars['row']->value['u_name']);?>
">
                                                    <p><strong><?php echo $_smarty_tpl->tpl_vars['row']->value['u_name'];?>
</strong></p>
                                                    <p class="follower-tilte"style="color:#e8790a"><strong>Followers: <?php echo $_smarty_tpl->tpl_vars['row']->value['follower_count'];?>
</strong></p>
                                                    <p class="follower-tilte"style="color:#e8790a"><strong>Following: <?php echo $_smarty_tpl->tpl_vars['row']->value['following_count'];?>
</strong></p>
                                                </a>
                                                <div class="follow-button">
                                                    <?php if ($_smarty_tpl->tpl_vars['row']->value['u_users_id'] != $_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId')) {?>
                                                        <?php if ($_smarty_tpl->tpl_vars['row']->value['pending_request_id'] != '' && $_smarty_tpl->tpl_vars['userinfo']->value['is_follwing'] == 'Pending') {?>
                                                            <a href="javascript:" class="btn btn-secondary act_cancelfollowrequest" data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_users_id'];?>
" data-pendingrequestid="<?php echo $_smarty_tpl->tpl_vars['row']->value['pending_request_id'];?>
">Cancel</a>
                                                        <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['pending_request_id'] != '') {?>
                                                            <a href="javascript:" class="btn btn-secondary act_unfollowuser" data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_users_id'];?>
" >Unfollow</a>
                                                        <?php } else { ?>
                                                            <a href="javascript:" class="btn btn-primary act_followuser" data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_users_id'];?>
" style="background-color: #e8790a; border-color:#e8790a;">Follow</a>
                                                        <?php }?>
                                                        <div id="followactionmsg_<?php echo $_smarty_tpl->tpl_vars['row']->value['u_users_id'];?>
"></div>
                                                    <?php } else { ?>
                                                        <span style="color:white;">Follow not needed</span>
                                                    <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }?>
                            <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
if ($__foreach_row_0_saved_key) {
$_smarty_tpl->tpl_vars['i'] = $__foreach_row_0_saved_key;
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
<?php if ($_smarty_tpl->tpl_vars['currentpage']->value == 1 && $_smarty_tpl->tpl_vars['nextpage']->value != 0) {?>
<li  style="padding-left:285px;padding-bottom:30px;" id="loadmoreresult" data-currentpage="<?php echo $_smarty_tpl->tpl_vars['getindex']->value;?>
">
    <!--<a href="javascript:" class="btn btn-secondary">Load More Results ..</a>-->
    <br>
</li>
<?php }
} else { ?>
<li>
    <div style="text-align:center;width:100%;color:green;">No user found in the list</div>
</li>
<?php }?>
</ul><?php }
}

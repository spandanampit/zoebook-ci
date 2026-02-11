<?php
/* Smarty version 3.1.28, created on 2025-01-29 05:00:47
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/mymovement.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_679a267f0100e4_72939445',
  'file_dependency' => 
  array (
    'c1911b50a71309a8e674577356f8cdaf58da1be5' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/mymovement.tpl',
      1 => 1738155643,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/navbar.tpl' => 1,
  ),
),false)) {
function content_679a267f0100e4_72939445 ($_smarty_tpl) {
?>

    <!-- dashboard section start -->
    <section class="dashboard-sec movement-sec">
        <div class="container customContainer">
            <div class="row">
                <div class="col-xl-3 col-md-12">
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                </div>
                <div class=" col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
                    <div class="main">
                        <div class="row">
                        <?php
$_from = $_smarty_tpl->tpl_vars['mymovement']->value;
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
                            
                            <!--<?php echo print_r($_smarty_tpl->tpl_vars['row']->value);?>
-->
                                <div class="col-lg-6 col-md-6">
                                    <div class="image-dash-post mb-3">
                                        <div class="image-dash-post-heading">
                                            <div class="image-dash-post-user">
                                                <div class="image-dash-post-img">
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['users_profile_image'];?>
" alt="">
                                                </div>
                                                <div class="image-post-content">
                                                    <!--<p>Initiated By Leader</p>-->
                                                    <h5><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['vName'];?>
</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="image-post-vid">
                                            <div class="image-wrapper">
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/movementdetails');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['movements_id'];?>
&user_id=<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['iUserId'];?>
">
                                                    <?php if ($_smarty_tpl->tpl_vars['row']->value['get_movement_file'] != '') {?>
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['get_movement_file'][0]['mi_upload_file'];?>
" alt="">
                                                    <?php } else { ?>
                                                    <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                                                    <?php }?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="img-post-title-view">
                                            <div class="title">
                                            <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['movement_name']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
                                                <h3><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>
</h3>
                                            </div>
                                            <!--<div class="total-view">
                                                630 Members
                                            </div> -->
                                        </div>
                                        <div class="image-post-content">
                                            <?php $_smarty_tpl->tpl_vars['posted_description_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['description']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description_withouemoji', 0);?>
                                            <?php $_smarty_tpl->tpl_vars['posted_description'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_description_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description', 0);?>
                                            <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_description']->value);?>
</p>
                                        </div>
                                        <?php if ($_smarty_tpl->tpl_vars['row']->value['users_id'] == $_smarty_tpl->tpl_vars['userinfo']->value['iUserId']) {?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/editmovement');?>
?movementId=<?php echo $_smarty_tpl->tpl_vars['row']->value['movements_id'];?>
"><button class="btn btn-leave btn-block" fdprocessedid="emi01m"><?php echo $_smarty_tpl->tpl_vars['edit']->value;?>
</button></a>
                                        <?php } else { ?>
                                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/leave');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['movements_id'];?>
"><button class="btn btn-leave btn-block" fdprocessedid="emi01m"><?php echo $_smarty_tpl->tpl_vars['leave']->value;?>
</button></a>
                                        <?php }?>
                                    </div>
                                </div>
                            
                        <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
?>       
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-4">
                            <button class="btn btn-leave btn-block" fdprocessedid="410sqc">
                                <?php echo $_smarty_tpl->tpl_vars['view_more']->value;?>

                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- dashboard section end -->
    <a href="https://mydevfactory.com/~sanjib7php/sakil/zoebook/zoebook-new/movement-post.html#" class="scrollToTop" style="display: none;"><i class="fa-solid fa-angle-up"></i></a>
<?php }
}

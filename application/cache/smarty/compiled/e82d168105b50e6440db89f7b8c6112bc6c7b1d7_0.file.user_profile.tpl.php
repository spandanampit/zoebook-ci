<?php
/* Smarty version 3.1.28, created on 2024-11-26 01:59:56
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/user_profile.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67459c1c14b392_46567069',
  'file_dependency' => 
  array (
    'e82d168105b50e6440db89f7b8c6112bc6c7b1d7' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/user_profile.tpl',
      1 => 1731678609,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/user_info.tpl' => 1,
    'file:common/profile_cover.tpl' => 1,
    'file:common/feed_list.tpl' => 1,
    'file:common/suggestions.tpl' => 1,
    'file:common/user_follower_modal.tpl' => 2,
    'file:common/common_editpost.tpl' => 1,
  ),
),false)) {
function content_67459c1c14b392_46567069 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<?php if ($_smarty_tpl->tpl_vars['errormsg']->value != '') {?>
<div>
  <div class="container">
    <div id="notfound">
      <div class="notfound">
        <div class="notfound-404">
          <h1>OOPS!</h1>
        </div>
        <h2><?php echo $_smarty_tpl->tpl_vars['errormsg']->value;?>
</h2>
        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/home/my_profile');?>
">Go To Homepage</a>
      </div>
    </div>
  </div>
</div>
<?php } else {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/userprofile.js");?>

<div class="post-pages dashboard-sec">
    <div class="container">
    <?php if (($_smarty_tpl->tpl_vars['this']->value->session->flashdata('error'))) {?>
    <div class="alert alert-danger">
        <?php echo $_smarty_tpl->tpl_vars['this']->value->session->flashdata('error');?>

    </div>
   <?php }?>
        <div class="row">
            <div class="col-lg-3 user-info-block">
                <div class="user-open" style="display:none;">
                    <i class="far fa-user"></i>
                </div>
                <!--User info start here-->
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/user_info.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                <!--User info End here-->
            </div>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-12">
                        <!--Profile cover block start here-->
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/profile_cover.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                        <!--Profile cover block End here-->
                    </div>
                    <div class="col-lg-8" style="margin-top: 35px !important;">
                        <input type="hidden" id="cr_pg" value="<?php echo $_smarty_tpl->tpl_vars['cr_pg']->value;?>
"/>
                        <input type="hidden" id="nx_pg" value="<?php echo $_smarty_tpl->tpl_vars['nx_pg']->value;?>
"/>
                        <input type="hidden" id="page_type" name="page_type" value="other_profile"/>
                        <input type="hidden" id="other_user_id" name="other_user_id" value="<?php echo $_smarty_tpl->tpl_vars['other_user_id']->value;?>
"/>
                        <!--Feed list start here-->
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/feed_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                        <!--Feed list End here-->
                    </div>
                    <div class="col-lg-4">
                        <div class="sugested-video-box right-panel" style="border-radius: 15px;">
                                <h3>Suggested </h3>              
                                <div class="suggested-wrapper user-listing">
                                    <!--suggestions start here-->
                                    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/suggestions.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                                    <!--suggestions End here-->
                                </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>
<?php }?>
<!-- Follower Modal Popup -->
<div class="modal fade cmn-modal" id="followModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Follower List</h5>
            </div>
            <div class="modal-body">
                <div class="follow-friend-block scrollbarContent">
                    <div class="follow-friend-list">
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/user_follower_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('followarr'=>$_smarty_tpl->tpl_vars['userfollower']->value), 0, false);
?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Following Modal Popup -->
<div class="modal fade cmn-modal" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="exampleModalLabel">Following List</h5>
            </div>
            <div class="modal-body">
                <div class="follow-friend-block scrollbarContent">
                    <div class="follow-friend-list">
                        <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/user_follower_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('followarr'=>$_smarty_tpl->tpl_vars['userfollowing']->value), 0, true);
?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/common_editpost.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/posts.js");
}
}

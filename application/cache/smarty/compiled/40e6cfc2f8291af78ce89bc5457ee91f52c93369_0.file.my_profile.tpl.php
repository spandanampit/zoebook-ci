<?php
/* Smarty version 3.1.28, created on 2025-01-26 22:46:13
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/my_profile.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67972bb5ccb143_72337542',
  'file_dependency' => 
  array (
    '40e6cfc2f8291af78ce89bc5457ee91f52c93369' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/home/views/my_profile.tpl',
      1 => 1737383488,
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
function content_67972bb5ccb143_72337542 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/myprofile.js");?>

<div class="post-pages dashboard-sec" >
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
               <div class="col-lg-8 col-md-7" style="margin-top:45px">
                  <input type="hidden" id="cr_pg" value="<?php echo $_smarty_tpl->tpl_vars['cr_pg']->value;?>
"/>
                  <input type="hidden" id="nx_pg" value="<?php echo $_smarty_tpl->tpl_vars['nx_pg']->value;?>
"/>
                  <input type="hidden" id="page_type" name="page_type" value="my_profile"/>
                  <!--Feed list start here-->
                  <div id="feed_list">
                     <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/feed_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                  </div>
                  <!--Feed list End here-->
               </div>
               <div class="col-lg-4 col-md-5" style="margin-top:14px">
                  <div class="sugested-video-box right-panel" style="border-radius: 15px;">
                        <h3><?php echo $_smarty_tpl->tpl_vars['suggested']->value;?>
 </h3>              
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

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/posts.js");?>


<?php echo '<script'; ?>
>
let loading = false;
let pageIndex = 2; // Start from page 2, assuming page 1 is already loaded.
const scrollThreshold = 5000;

window.addEventListener('scroll', function() {
   const scrollTop = window.scrollY;
   const windowHeight = window.innerHeight;
   const documentHeight = document.documentElement.scrollHeight;
   const scrolledHeight = scrollTop + windowHeight;
   
   // Check if the user is near the bottom of the page
   if ((documentHeight - scrolledHeight) <= scrollThreshold && !loading) {
      loading = true;
      console.log('User is near the bottom. Triggering AJAX call...');
      
      const params = {
         page_index: pageIndex,
         viral_feed: 1,
      };
      
      $.ajax({
         url: '/profile_posts',
         method: 'GET',
         dataType: 'json',
         data: params,
         success: function(response) {
            if (response.success) {
               $('#feed_list').append(response.html_content);
               $(document).trigger('newContentLoaded');
               pageIndex++;
            } else {
               console.log(response.message);
            }
         loading = false;

         },
         error: function(xhr, status, error) {
            console.error('Error loading data:', error);
         },
         complete: function() {
            loading = false;
         }
      });
   }
});
<?php echo '</script'; ?>
><?php }
}

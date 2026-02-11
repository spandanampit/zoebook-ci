<?php
/* Smarty version 3.1.28, created on 2025-01-23 04:03:32
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/editmovement.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67923014516392_10334411',
  'file_dependency' => 
  array (
    'ab352a6a7d43d540d90f1b20af8272c91145e774' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/editmovement.tpl',
      1 => 1737633749,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/navbar.tpl' => 1,
  ),
),false)) {
function content_67923014516392_10334411 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}
</style>
    <!-- dashboard section start -->
    <section class="dashboard-sec movement-sec">
      <div class="container customContainer">
        <div class="row">
          <div class="col-xl-3 col-md-12">
          <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

          </div>
          <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="main">
              <div class="movement-form"> 
                <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/deactivate');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
">               
                  <button class="btn btn-danger form-btn" fdprocessedid="z448m8" style="position: relative; width: 22%; float: right"><?php echo $_smarty_tpl->tpl_vars['deactivateMovement']->value;?>
</button>
                </a>
                <form method="POST" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/updatemovement');?>
" enctype="multipart/form-data">
                  <div class="movement-form-heading">
                    <h3><?php echo $_smarty_tpl->tpl_vars['editMovement']->value;?>
</h3>
                  </div>
                <div class="form-group">
                  <label><?php echo $_smarty_tpl->tpl_vars['movement_name']->value;?>
</label>
                  <input type="text" class="form-control" size="50" placeholder="<?php echo $_smarty_tpl->tpl_vars['movement_name']->value;?>
" name="movement_name" fdprocessedid="3wef0s" value="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movement_name'];?>
">
                </div>
                <div class="form-group">
                  <?php $_smarty_tpl->tpl_vars['movement_description_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['movement']->value['get_movements']['description']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'movement_description_withouemoji', 0);?>
                  <?php $_smarty_tpl->tpl_vars['movement_description'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['movement_description_withouemoji']->value,200), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'movement_description', 0);?>
                  <label><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
 <span>(<?php echo $_smarty_tpl->tpl_vars['goal_or_objective']->value;?>
)</span></label>
                  <textarea type="text" class="form-control" size="500" placeholder="Edit Movement" name="movement_description"><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['movement_description']->value);?>
</textarea>
                </div>
                <div class="form-group">
                  <label><?php echo $_smarty_tpl->tpl_vars['upload_cover_photo']->value;?>
 <span><?php echo $_smarty_tpl->tpl_vars['upto_five_photo']->value;?>
</span></label>
                  <div class="file-wrapper">
                  <input type="file" id="coverPhotoInput" class="form-control" placeholder="<?php echo $_smarty_tpl->tpl_vars['movement_name']->value;?>
" name="movement_image">                    
                  </div>
                  <img id="coverPhotoPreview" src="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements_file']['0']['mi_upload_file'];?>
" class="movement-image">
                </div>
                <div class="form-group">
                  <label><?php echo $_smarty_tpl->tpl_vars['Visibility']->value;?>
</label>  
                  <div class="radio-box">
                    <div class="form-check">
                    
                      <input class="form-check-input" type="radio" name="movement_visibility" id="flexRadioDefault1" value="Public" <?php if ($_smarty_tpl->tpl_vars['movement']->value['get_movements']['visibility'] == 'Public') {?> checked <?php }?>>
                      <label class="form-check-label" for="flexRadioDefault1">
                        <?php echo $_smarty_tpl->tpl_vars['public']->value;?>

                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="movement_visibility" id="flexRadioDefault2" value="Private" <?php if ($_smarty_tpl->tpl_vars['movement']->value['get_movements']['visibility'] == 'Private') {?> checked <?php }?>>
                      <label class="form-check-label" for="flexRadioDefault2">
                        <?php echo $_smarty_tpl->tpl_vars['private']->value;?>

                      </label>
                    </div>
                  </div>
                </div>  
                <input type="hidden" name="movement_id" value="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
">
                <input type="hidden" name="movement_image_id" value="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements_file'][0]['mi_movement_images_id'];?>
">
                <button type="submit" class="btn btn-primary form-btn" fdprocessedid="z448m8"><?php echo $_smarty_tpl->tpl_vars['save']->value;?>
</button>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>    
    <!-- dashboard section end -->

    <?php echo '<script'; ?>
>
      document.getElementById('coverPhotoInput').addEventListener('change', function(event) {
          const file = event.target.files[0];
          if (file) {
              const reader = new FileReader();
              reader.onload = function(e) {
                  const preview = document.getElementById('coverPhotoPreview');
                  console.log(preview);
                  preview.src = e.target.result;
                  preview.style.display = 'block';
              };
              reader.readAsDataURL(file);
          }
      });

      $(document).ready(function() {
        $('.movement-link').on('click', function() {
            var movementId = $(this).data('id');
            
            // Show the data you want
            console.log('Movement ID:', movementId);

            // Deactivate an alert message (if an alert is shown somewhere)
            alertMessage = ''; // Or set the alert message visibility to hidden, depending on your logic

            // Example to hide an alert
            $('#alertMessage').hide(); // Assuming your alert has an id of 'alertMessage'
        });
      });
    <?php echo '</script'; ?>
>

<?php }
}

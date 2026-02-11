<?php
/* Smarty version 3.1.28, created on 2025-01-23 02:44:09
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/addmovement.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67921d79a12cd9_43881314',
  'file_dependency' => 
  array (
    '6da97667e41b1113959f8fba40c209d3203c4cc4' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/addmovement.tpl',
      1 => 1737628977,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/navbar.tpl' => 1,
  ),
),false)) {
function content_67921d79a12cd9_43881314 ($_smarty_tpl) {
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
                <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/savemovement');?>
" enctype="multipart/form-data">
                  <div class="movement-form-heading">
                  <h3><?php echo $_smarty_tpl->tpl_vars['create_movement']->value;?>
</h3>
                </div>
                <div class="form-group">
                  <label><?php echo $_smarty_tpl->tpl_vars['movement_name']->value;?>
</label>
                  <input type="text" class="form-control" size="50" placeholder="<?php echo $_smarty_tpl->tpl_vars['movement_name']->value;?>
" name="movement_name" fdprocessedid="3wef0s">
                </div>
                <div class="form-group">
                  <label><?php echo $_smarty_tpl->tpl_vars['description']->value;?>
 <span>(<?php echo $_smarty_tpl->tpl_vars['goal_or_objective']->value;?>
)</span></label>
                  <textarea type="text" class="form-control" size="500" placeholder="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" name="movement_description"></textarea>
                </div>
                <div class="form-group">
                  <label><?php echo $_smarty_tpl->tpl_vars['upload_cover_photo']->value;?>
</label>
                  <div class="file-wrapper">
                    <input type="file" class="form-control" id="coverPhotoInput" name="upload_file" placeholder="<?php echo $_smarty_tpl->tpl_vars['movement_name']->value;?>
">                    
                  </div>
                  <img id="coverPhotoPreview" src="" class="movement-image">
                </div>
                <div class="form-group">
                  <label><?php echo $_smarty_tpl->tpl_vars['Visibility']->value;?>
</label>  
                  <div class="radio-box">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="movement_visibility" id="movement_visibility" value="Public" checked="">
                      <label class="form-check-label" for="flexRadioDefault1">
                        <?php echo $_smarty_tpl->tpl_vars['public']->value;?>

                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="movement_visibility" value="Private" id="movement_visibility">
                      <label class="form-check-label" for="flexRadioDefault2">
                        <?php echo $_smarty_tpl->tpl_vars['private']->value;?>

                      </label>
                    </div>
                  </div>
                </div>  
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
                  preview.src = e.target.result;
                  preview.style.display = 'block';
              };
              reader.readAsDataURL(file);
          }
      });
    <?php echo '</script'; ?>
><?php }
}

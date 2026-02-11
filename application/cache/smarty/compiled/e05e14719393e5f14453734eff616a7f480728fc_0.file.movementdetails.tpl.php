<?php
/* Smarty version 3.1.28, created on 2025-01-23 06:07:00
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/movementdetails.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67924d04dc2873_09438729',
  'file_dependency' => 
  array (
    'e05e14719393e5f14453734eff616a7f480728fc' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/movementdetails.tpl',
      1 => 1737641210,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/navbar.tpl' => 1,
    'file:common/movement_action_info.tpl' => 1,
    'file:common/movement_feedlist.tpl' => 1,
    'file:common/movement_description_box.tpl' => 1,
    'file:common/create_post_modal.tpl' => 1,
  ),
),false)) {
function content_67924d04dc2873_09438729 ($_smarty_tpl) {
?>
<!--<?php echo print_r($_smarty_tpl->tpl_vars['movement']->value);?>
-->
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<style>
.preview-container {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 10px;
}

.preview-item {
    position: relative;
    width: 100px;
    height: 100px;
}

.preview-item img,
.preview-item video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.preview-item .remove-btn {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #ff0000;
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}



.video-post-vid {
    width: 100%;
    overflow: hidden;
}

.video-wrapper {
    width: 100%;
    overflow: hidden;
}

.swiper-container {
    width: 100%;
    height: auto;
    overflow: hidden;
}

.swiper-wrapper {
    display: flex;
}

.swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
    height: auto;
}

.video-container-2 {
    position: relative;
    width: 100%;
    height: auto;
    overflow: hidden;
}

img, video {
    width: 100%;
    height: auto;
    display: block;
}




</style>

  <section class="dashboard-sec movement-sec">
    <div class="container customContainer">
      <div class="row">
        <div class="col-xl-3 col-md-12">
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  
        </div>
        <div class=" col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
          <div class="main">
            <div class="comment-img-box">
              <img src="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements_file'][0]['mi_upload_file'];?>
" alt="">
            </div>
            
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/movement_action_info.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  


          </div>
          <div class="row">
            <div class="col-lg-2 col-md-1 text-end">
              <button class="btn addnew-btn mt-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                <i class="fa-solid fa-plus"></i>
              </button>
            </div>
            <div class="col-lg-6 col-md-11">
              

            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/movement_feedlist.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  

            </div>
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/movement_description_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/create_post_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="myModalLabel"><?php echo $_smarty_tpl->tpl_vars['share_movement']->value;?>
</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <p><?php echo $_smarty_tpl->tpl_vars['copy_movement']->value;?>
</p>
              <div class="field d-flex align-items-center justify-content-between">
                  <span class="fas fa-link text-center"></span>
                  <input type="text" id="share-url" value="some.com/share" readonly>
                  <button onclick="copyToClipboard()"><?php echo $_smarty_tpl->tpl_vars['copy']->value;?>
</button>
              </div>
          </div>
      </div>
    </div>
</div>

<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<?php echo '<script'; ?>
 src="https://unpkg.com/swiper/swiper-bundle.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.0.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/emoji-button@latest/dist/index.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/vue@2"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
new Vue({
    el: '#app',
    data: {
        userProfileImage: '<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
',
        postText: '',
        files: [],
        movementId: '<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
',
        submitUrl: '<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/add_post');?>
',
    },
    methods: {
        previewFiles(event) {
            const selectedFiles = event.target.files;
            this.files = []; 
            Array.from(selectedFiles).forEach((file) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.files.push({
                        src: e.target.result,
                        type: file.type,
                        file: file
                    });
                };
                reader.readAsDataURL(file);
            });
        },
        removeFile(index) {
            this.files.splice(index, 1);
        },
        submitPost() {
    const formData = new FormData();
    formData.append('movement_post_text', this.postText);
    formData.append('movement_id', this.movementId);

    if (this.files.length > 0) {
        this.files.forEach((fileObj, index) => {
            formData.append(`upload_file[]`, fileObj.file);
        });
    }

    fetch(this.submitUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        
        const contentType = response.headers.get("content-type");
        if (contentType && contentType.includes("application/json")) {
            return response.json();
        } else {
            return response.text(); 
        }
    })
    .then(data => {
        if (typeof data === 'object' && data.settings && data.settings.success == 1) {
            console.log('Success:', data);

            const modalElement = document.getElementById('staticBackdrop');
            const modal = bootstrap.Modal.getInstance(modalElement);
            
            if (modal) {
                console.log("Modal instance found, attempting to hide...");
                modal.hide();
            } else {
                console.error("Modal instance not found!");
            }

            setTimeout(() => {
                location.reload();
            }, 500);
        } else {
            setTimeout(() => {
                location.reload();
            }, 500); 
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
    });
}

    }
});
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="public/js/front/movement-js/posts.js"><?php echo '</script'; ?>
>
  
<?php }
}

<?php
/* Smarty version 3.1.28, created on 2025-01-22 06:57:33
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/popularmovement.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_6791075d214cc7_85572403',
  'file_dependency' => 
  array (
    '1be5f7ec55fd002c17608e90c10aecde2937f8d9' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/popularmovement.tpl',
      1 => 1737557848,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/navbar.tpl' => 1,
  ),
),false)) {
function content_6791075d214cc7_85572403 ($_smarty_tpl) {
?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/plyr.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("front/plyr.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->css->css_src();?>

<style>
.emoji_postinfo .emoji-wysiwyg-editor { height : 130px !important;} 
.emoji_postinfo .emoji-menu {top:35px !important;}
.emoji_postinfo .emoji-wysiwyg-editor:empty:before { color: #b2b2b2 !important; font-size : 16px !important; font-weight: 500 !important}
.displayemoji_comment {margin-bottom:0px;}

    .fade-in {
      animation: fadeIn 3s;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    .swiper-container {
    width: 100%;
    height: auto;
    overflow: hidden;
    }

    .image-wrapper {
    width: 100%;
    height: 0;
    padding-bottom: 100%; /* Creates a square aspect ratio */
    position: relative;
    overflow: hidden;
    }

    .image-wrapper img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    }

    .swiper-button-next, .swiper-button-prev {
    width: 30px; /* Adjust width */
    height: 30px; /* Adjust height */
    background-size: 20px 20px; 
    color:black;
}

.swiper-button-next::after, .swiper-button-prev::after {
    font-size: 16px; /* Adjust the icon font size */
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
                    <div class="row">
                    <?php
$_from = $_smarty_tpl->tpl_vars['popularmovement']->value;
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

                        <div class="col-lg-4 col-md-6">
                            <div class="image-dash-post mb-3">
                                <div class="image-dash-post-heading">
                                    <div class="image-dash-post-user">
                                        <div class="image-dash-post-img">
                                            <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['users_profile_image'];?>
" alt="">
                                        </div>
                                        <div class="image-post-content">
                                            <p><?php echo $_smarty_tpl->tpl_vars['initiated_by_leader']->value;?>
</p>
                                            <h5><?php echo $_smarty_tpl->tpl_vars['row']->value['users_name'];?>
</h5>
                                        </div>
                                    </div>

                                </div>

                                <div class="image-post-vid">
                                    <div class="swiper-container">
                                        <div class="swiper-wrapper">
                                            <?php if (!empty($_smarty_tpl->tpl_vars['row']->value['get_movement_file'])) {?>
                                                <?php
$_from = $_smarty_tpl->tpl_vars['row']->value['get_movement_file'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_file_1_saved_item = isset($_smarty_tpl->tpl_vars['file']) ? $_smarty_tpl->tpl_vars['file'] : false;
$_smarty_tpl->tpl_vars['file'] = new Smarty_Variable();
$__foreach_file_1_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_file_1_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['file']->value) {
$__foreach_file_1_saved_local_item = $_smarty_tpl->tpl_vars['file'];
?>
                                                <div class="swiper-slide">
                                                    <div class="image-wrapper">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/movementjoin');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['movements_id'];?>
">
                                                        <?php if (!empty($_smarty_tpl->tpl_vars['file']->value)) {?>
                                                            <img src="<?php echo $_smarty_tpl->tpl_vars['file']->value['mi_upload_file'];?>
" alt="">
                                                        <?php } else { ?>
                                                            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                                                        <?php }?>
                                                    </a>
                                                    </div>
                                                </div>
                                                <?php
$_smarty_tpl->tpl_vars['file'] = $__foreach_file_1_saved_local_item;
}
}
if ($__foreach_file_1_saved_item) {
$_smarty_tpl->tpl_vars['file'] = $__foreach_file_1_saved_item;
}
?>
                                            <?php } else { ?>
                                                <div class="swiper-slide">
                                                    <div class="image-wrapper">
                                                            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                
                                        <!-- Add Pagination -->
                                        <div class="swiper-pagination"></div>
                                    
                                        <!-- Add Navigation -->
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>
                                </div>
                                <div class="img-post-title-view">
                                    <div class="title">
                                    <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['movement_name']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
                                        <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
                                        <h3>
                                        <?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>

                                        </h3>
                                    </div>
                                    <div class="total-view">
                                        <?php echo $_smarty_tpl->tpl_vars['row']->value['total_members'];?>
 <?php echo $_smarty_tpl->tpl_vars['members']->value;?>

                                    </div>
                                </div>
                                <div class="image-post-content">
                                    <?php $_smarty_tpl->tpl_vars['posted_description_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['row']->value['description']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description_withouemoji', 0);?>
                                    <?php $_smarty_tpl->tpl_vars['posted_description'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_description_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description', 0);?>
                                    <p><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_description']->value);?>
</p>
                                </div>

                                <?php if ($_smarty_tpl->tpl_vars['row']->value['join_status'] != 'Inactive') {?>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/leave');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['movements_id'];?>
"><button class="btn btn-leave btn-block"><?php echo $_smarty_tpl->tpl_vars['leave']->value;?>
</button></a>
                                <?php } else { ?>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/join');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['row']->value['movements_id'];?>
"><button class="btn btn-join btn-block"><?php echo $_smarty_tpl->tpl_vars['join']->value;?>
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
                    <button class="btn btn-leave btn-block" id="view-more" data-page="1">
                        <?php echo $_smarty_tpl->tpl_vars['view_more']->value;?>

                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
    <?php echo '<script'; ?>
 src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="https://unpkg.com/swiper/swiper-bundle.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1,
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            // pagination: {
            //     el: '.swiper-pagination',
            //     clickable: false,
            // },
        });

        $(document).ready(function() {
            $('#view-more').on('click', function() {
                var pageIndex = $(this).data('page'); // Get the current page index
                var nextPage = pageIndex + 1; // Increment page index for next page

                $.ajax({
                    url: '<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make("movement/movement/popularmovement");?>
', // Replace with your actual controller path
                    type: 'POST',
                    data: { page_index: nextPage },
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);

                        // Assuming the response contains 'popularMovements.popularmovement'
                        if (response.success && response.popularMovements.popularmovement.length > 0) {
                            var movements = response.popularMovements.popularmovement;

                            // Select the container where you want to append the movements
                            var container = $('.main .row').first(); // Target the existing row

                            // Loop through each movement and append the data
                            movements.forEach(function(row) {
                                var displayedText = displayPostText(row.description);
                                var movementHtml = `
                                    <div class="col-lg-4 col-md-6">
                                        <div class="image-dash-post mb-3">
                                            <div class="image-dash-post-heading">
                                                <div class="image-dash-post-user">
                                                    <div class="image-dash-post-img">
                                                        <img src="${row.users_profile_image}" alt="">
                                                    </div>
                                                    <div class="image-post-content">
                                                        <p><?php echo $_smarty_tpl->tpl_vars['initiated_by_leader']->value;?>
</p>
                                                        <h5>${row.users_name}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="image-post-vid">
                                                <div class="swiper-container">
                                                    <div class="swiper-wrapper">`;

                                if (row.get_movement_file.length > 0) {
                                    row.get_movement_file.forEach(function(file) {
                                        movementHtml += `
                                            <div class="swiper-slide">
                                                <div class="image-wrapper">
                                                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/movementjoin');?>
?movement_id=${row.movements_id}">
                                                        <img src="${file.mi_upload_file}" alt="">
                                                    </a>
                                                </div>
                                            </div>`;
                                    });
                                } else {
                                    movementHtml += `
                                        <div class="swiper-slide">
                                            <div class="image-wrapper">
                                                <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
noimage.gif" alt="Default profile picture">
                                            </div>
                                        </div>`;
                                }

                                movementHtml += `
                                                    </div>
                                                    <div class="swiper-pagination"></div>
                                                    <div class="swiper-button-next"></div>
                                                    <div class="swiper-button-prev"></div>
                                                </div>
                                            </div>
                                            <div class="img-post-title-view">
                                                <div class="title">
                                                    <h3>${row.movement_name}</h3>
                                                </div>
                                                <div class="total-view">
                                                    ${row.total_members} <?php echo $_smarty_tpl->tpl_vars['members']->value;?>

                                                </div>
                                            </div>
                                            <div class="image-post-content">
                                                <p>${displayedText}</p>
                                            </div>`;

                                if (row.join_status !== 'Inactive') {
                                    movementHtml += `
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/leave');?>
?movement_id=${row.movements_id}">
                                                <button class="btn btn-leave btn-block"><?php echo $_smarty_tpl->tpl_vars['leave']->value;?>
</button>
                                            </a>`;
                                } else {
                                    movementHtml += `
                                            <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/join');?>
?movement_id=${row.movements_id}">
                                                <button class="btn btn-join btn-block"><?php echo $_smarty_tpl->tpl_vars['join']->value;?>
</button>
                                            </a>`;
                                }

                                movementHtml += `
                                        </div>
                                    </div>
                                `;

                                // Append the newly created HTML to the container
                                container.append(movementHtml);
                            });

                            // Update the page index data attribute for the next load
                            $('#view-more').data('page', nextPage);
                        } else {
                            // No more data or some error occurred
                            alert('No more movements to load.');
                        }
                    },
                    error: function(error) {
                        console.error('Error loading movements:', error);
                    }
                });
            });
        });


    function removeEmoji(text) {
        return text.replace(/[\u{1F600}-\u{1F64F}]/gu, ''); 
    }

    function truncateText(text, limit) {
        return text.length > limit ? text.substring(0, limit) + '...' : text;
    }

    function displayPostText(text) {
        var cleanText = removeEmoji(text);
        return truncateText(cleanText, 40); // Adjust 40 based on your PHP function
    }

    <?php echo '</script'; ?>
>
<?php }
}

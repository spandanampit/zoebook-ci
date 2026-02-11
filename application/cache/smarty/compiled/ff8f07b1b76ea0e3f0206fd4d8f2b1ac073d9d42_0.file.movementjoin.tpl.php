<?php
/* Smarty version 3.1.28, created on 2024-10-04 05:47:23
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/movementjoin.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_66ffe3db5d0355_99636229',
  'file_dependency' => 
  array (
    'ff8f07b1b76ea0e3f0206fd4d8f2b1ac073d9d42' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/movementjoin.tpl',
      1 => 1728046038,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/navbar.tpl' => 1,
  ),
),false)) {
function content_66ffe3db5d0355_99636229 ($_smarty_tpl) {
?>
<!-- dashboard section start -->
<section class="dashboard-sec movement-sec" style="min-height: 53rem;">
<div class="container customContainer">
  <div class="row">
    <div class="col-xl-3 col-md-12">
    <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    </div>
    <div class=" col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
      <div class="main">
        <div class="comment-img-box movement-banner-cont">
          <img src="<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements_file'][0]['mi_upload_file'];?>
" alt="">
          <div class="conten">
            <div class="conten-dis">
              <?php $_smarty_tpl->tpl_vars['posted_text_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['movement']->value['get_movements']['movement_name']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text_withouemoji', 0);?>
              <?php $_smarty_tpl->tpl_vars['posted_text'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_text_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_text', 0);?>
              <h3><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_text']->value);?>
</h3>

              <?php $_smarty_tpl->tpl_vars['posted_description_withouemoji'] = new Smarty_Variable(removeEmoji($_smarty_tpl->tpl_vars['movement']->value['get_movements']['description']), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description_withouemoji', 0);?>
              <?php $_smarty_tpl->tpl_vars['posted_description'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['posted_description_withouemoji']->value,40), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'posted_description', 0);?>
              <p class="mb-3"><?php echo $_smarty_tpl->tpl_vars['this']->value->general->displayposttext($_smarty_tpl->tpl_vars['posted_description']->value);?>
</p>
              <p class="mb-0 green-text">
                Created: January 23, 2024
              </p>
              <p class="mb-0 yellow-text"><?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['total_members'];?>
 Members </p>
            </div>
            <!--<?php echo print_r($_smarty_tpl->tpl_vars['movement']->value);?>
-->
            <div class="conten-btn">
              <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/join');?>
?movement_id=<?php echo $_smarty_tpl->tpl_vars['movement']->value['get_movements']['movements_id'];?>
"><button class="yellow-btn join-btn btn">Join</button></a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</section>
<!-- dashboard section end -->
<?php }
}

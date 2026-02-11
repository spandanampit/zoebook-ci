<?php
/* Smarty version 3.1.28, created on 2025-01-30 04:51:50
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/golive/views/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_679b75e6eaf9a4_54225106',
  'file_dependency' => 
  array (
    'a31ba45d23b443a74d01474601542af659e2b0a5' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/golive/views/index.tpl',
      1 => 1738241480,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_679b75e6eaf9a4_54225106 ($_smarty_tpl) {
?>
<style type="text/css">
    .live-screen{
    position:relative;
}

#video-bg {
    position:absolute;
    top: 0;
    left: 0;
    right: 0;
}
.bg-live {
    height: 76vh !important;
}
</style>
<section class="live-sec">
    <div class="container container-2">
        <div class="bg-live">
            <div class="row justify-content-center">
                <div class="col-md-7 col-11">
                    <div class="live-content-box">
                        <form id="frm_golive_start" method="post" action="golive-start-action.html" name="golive_start">
                            <input type="hidden" name="preview_thumb" id="preview_thumb" value=""/>
                            <div class="live-message">
                                <textarea class="form-control" id="post_text" name="post_text" rows="3" placeholder="Describe your live streaming....."></textarea>
                            </div>
                            <button type="submit" class="btn btn-denger go-live-btn" id="btn_golive_start"><i class="fa-solid fa-video"></i> <?php echo $_smarty_tpl->tpl_vars['go_live']->value;?>
</button>
                        </form>
                    </div>
                    <div class="live-content">
                        <a href="#"><?php echo $_smarty_tpl->tpl_vars['go_live_with_zoebook']->value;?>
</a>
                        <p><?php echo $_smarty_tpl->tpl_vars['live_text']->value;?>
</p>
                        <canvas id="canvas" width="640" height="480"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/opentok/golive_start.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat-count.js");?>


<?php }
}

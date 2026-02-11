<?php
/* Smarty version 3.1.28, created on 2024-01-31 17:12:25
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/golive/views/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65ba322159cda9_88183120',
  'file_dependency' => 
  array (
    'e5786924a671be22de85de24a15b939743c8936e' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/front/golive/views/index.tpl',
      1 => 1706090579,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65ba322159cda9_88183120 ($_smarty_tpl) {
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
</style>
<div class="golive-page">
    <div class="container">
        <div class="live-screen">
            <div class="live-content">
            <video id="video-bg"></video>
                <form id="frm_golive_start" method="post" action="golive-start-action.html" name="golive_start">
                    <input type="hidden" name="preview_thumb" id="preview_thumb" value=""/>
                <div class="live-message">
                    <textarea rows="2" class="form-control" id="post_text" name="post_text" placeholder="Describe your Live Streming..." required></textarea>
                </div>
                <div class="link-button text-center">
                    <button type="button" class="btn go-live-btn" id="btn_golive_start">
                        <i class="fas fa-video"></i> Go live
                    </button>
                    <p>Go Live with <b>Zoebook</b></p>
                    <p>Capture and store the moment as its happening. After you are finished your video will stay in the post timeline.</p>
                    <canvas id="canvas" width="640" height="480"></canvas>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/opentok/golive_start.js");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat-count.js");?>


<?php }
}

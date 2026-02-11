<?php
/* Smarty version 3.1.28, created on 2024-02-29 16:10:01
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/admin/views/bottom/bottom.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65e05f015807c4_33717063',
  'file_dependency' => 
  array (
    '47932977be0eafe06cd96a182f8e8c962e10fe16' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/admin/views/bottom/bottom.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65e05f015807c4_33717063 ($_smarty_tpl) {
?>
<div class="copyright" id="bot_copyright">
    <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iAdminId') != '') {?>
        <div class="nvqc-show-hide-log">
            <?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('__CACHE_PREFERENCES') == '1') {?>
                <a href="javascript://"  title="Clear Cache" class="qc-show-hide-log bottom-log-icons">
                    <span class="icon20 icomoon-icon-recycle"></span>
                </a>
            <?php }?>
            <?php if (strtolower($_smarty_tpl->tpl_vars['this']->value->config->item('NAVIGATION_LOG_REQ')) == 'y') {?>
                <a href="javascript://"  title="Show Navigation Log" class="nv-show-hide-log bottom-log-icons">
                    <span class="icon20 icomoon-icon-cogs"></span>
                </a>
            <?php }?>
        </div>
        <div class="dbfc-show-hide-log">
            <?php if ($_ENV['debug_action'] == '1') {?>
                <a href="javascript://"  title="Show DB Queries Log" class="db-show-hide-log bottom-log-icons">
                    <span class="icon20 icomoon-icon-fire-2"></span>
                </a>
            <?php }?>
            <a href="javascript://"  title="Show Full Screen" id="show_full_screen_bottom" class="show-full-screen-bottom bottom-log-icons">
                <span class="icon20 iconic-icon-fullscreen"></span>
            </a>
            <a href="javascript://"  style="display:none;" title="Cancel Full Screen" id="cancel_full_screen_bottom" class="cancel-full-screen-bottom bottom-log-icons">
                <span class="icon20 iconic-icon-fullscreen-exit"></span>
            </a>
        </div>  
    <?php }?>
    <?php echo $_smarty_tpl->tpl_vars['this']->value->general->getcopyrighttext();?>

</div>


<?php }
}

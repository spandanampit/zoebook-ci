<?php
/* Smarty version 3.1.28, created on 2024-02-29 18:34:45
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/webservice/wsengine/views/listWSMethods.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65e080edad98b9_39217294',
  'file_dependency' => 
  array (
    '7041f4644d12fb460439a1f6c357e143e06b4529' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/webservice/wsengine/views/listWSMethods.tpl',
      1 => 1708493955,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_65e080edad98b9_39217294 ($_smarty_tpl) {
echo $_smarty_tpl->tpl_vars['this']->value->css->add_css("ws_validate.css");?>

<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("crypto-md5.js","application_ws.js");?>


<?php echo '<script'; ?>
 type="text/javascript">
    var api_key = '<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item("API_KEY");?>
';
    var api_secret = '<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item("API_SECRET");?>
';
    var ws_base = "<?php echo $_smarty_tpl->tpl_vars['ws_url']->value;?>
";
<?php echo '</script'; ?>
>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Welcome to API Console</div>
    </div>
    <div class="panel-body">
        <?php
$_from = $_smarty_tpl->tpl_vars['all_methods']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_j_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_foreach_j']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_j'] : false;
$__foreach_j_0_saved_item = isset($_smarty_tpl->tpl_vars['item']) ? $_smarty_tpl->tpl_vars['item'] : false;
$__foreach_j_0_saved_key = isset($_smarty_tpl->tpl_vars['key']) ? $_smarty_tpl->tpl_vars['key'] : false;
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable();
$__foreach_j_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
$_smarty_tpl->tpl_vars['__smarty_foreach_j'] = new Smarty_Variable(array('iteration' => 0));
if ($__foreach_j_0_total) {
$_smarty_tpl->tpl_vars['key'] = new Smarty_Variable();
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['__smarty_foreach_j']->value['iteration']++;
$__foreach_j_0_saved_local_item = $_smarty_tpl->tpl_vars['item'];
?>    
            <div class="col-md-12 api-block">
                <div class="method-name">
                    <?php echo (isset($_smarty_tpl->tpl_vars['__smarty_foreach_j']->value['iteration']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_j']->value['iteration'] : null);?>
. <?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>

                </div>
                <div class="inputparams">
                    <form action="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
?ws_debug=1" method="post" class="form-horizontal ws">
                        <?php $_smarty_tpl->tpl_vars["ws_params"] = new Smarty_Variable($_smarty_tpl->tpl_vars['item']->value['params'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "ws_params", 0);?>
                        <?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['ws_params']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
                            <?php if ($_smarty_tpl->tpl_vars['ws_params']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)] != '') {?>
                                <div class="form-group">
                                    <label class="col-xs-1 control-label">
                                        <?php echo $_smarty_tpl->tpl_vars['ws_params']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)];?>

                                    </label>
                                    <div class="col-xs-4">
                                        <input class="form-control" id="<?php echo $_smarty_tpl->tpl_vars['ws_params']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)];?>
" name="<?php echo $_smarty_tpl->tpl_vars['ws_params']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)];?>
" value="">          
                                    </div>
                                </div>
                            <?php }?>
                        <?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>  
                        <div class="form-group">
                            <label class="col-xs-1 control-label"></label>
                            <div class="col-xs-10">
                                <button type="submit" class="btn btn-default">Send Request</button>
                            </div>
                        </div>
                    </form>
                    <pre class="code"></pre>
                    <iframe class="text"></iframe>
                </div>
            </div>
        <?php
$_smarty_tpl->tpl_vars['item'] = $__foreach_j_0_saved_local_item;
}
}
if ($__foreach_j_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_foreach_j'] = $__foreach_j_0_saved;
}
if ($__foreach_j_0_saved_item) {
$_smarty_tpl->tpl_vars['item'] = $__foreach_j_0_saved_item;
}
if ($__foreach_j_0_saved_key) {
$_smarty_tpl->tpl_vars['key'] = $__foreach_j_0_saved_key;
}
?>
    </div>
</div>


<?php }
}

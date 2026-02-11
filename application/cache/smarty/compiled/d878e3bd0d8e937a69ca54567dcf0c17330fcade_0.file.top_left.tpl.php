<?php
/* Smarty version 3.1.28, created on 2024-02-08 09:52:41
  from "/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/top/top_left.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_65c45711ad4ee6_68765155',
  'file_dependency' => 
  array (
    'd878e3bd0d8e937a69ca54567dcf0c17330fcade' => 
    array (
      0 => '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/admin/views/top/top_left.tpl',
      1 => 1706090560,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin_page_translate.tpl' => 1,
  ),
),false)) {
function content_65c45711ad4ee6_68765155 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/bit73.mydevfactory.com/abhisek/zoebook/application/third_party/Smarty/plugins/modifier.date_format.php';
$_smarty_tpl->tpl_vars["logo_file_url"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->general->getCompanyLogoURL(), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "logo_file_url", 0);
$_smarty_tpl->tpl_vars["total_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->systemsettings->getMenuArray("Left"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "total_arr", 0);
$_smarty_tpl->tpl_vars["menu_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['total_arr']->value['menu'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "menu_arr", 0);
$_smarty_tpl->tpl_vars["home_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['total_arr']->value['home'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "home_arr", 0);
$_smarty_tpl->tpl_vars["profile_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['total_arr']->value['profile'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "profile_arr", 0);
$_smarty_tpl->tpl_vars["password_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['total_arr']->value['password'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "password_arr", 0);
$_smarty_tpl->tpl_vars["logout_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['total_arr']->value['logout'], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "logout_arr", 0);
$_smarty_tpl->tpl_vars["parent_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['menu_arr']->value[0], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "parent_arr", 0);?>

<div class="top-bg left-model-view <?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN_HEAD');?>
" id="logo_template">
    <div class="logo container-fluid navbar">
        <a hijacked="yes" href="<?php echo $_smarty_tpl->tpl_vars['home_arr']->value['url'];?>
" class="brand">
            <?php if ($_smarty_tpl->tpl_vars['logo_file_url']->value != '') {?>
                <img alt="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('COMPANY_NAME');?>
" class="admin-logo-top" src="<?php echo $_smarty_tpl->tpl_vars['logo_file_url']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('COMPANY_NAME');?>
">
            <?php } else { ?>
                <div class='brand-logo-icon'></div>
            <?php }?>
        </a>
    </div>
    <div class="toprightarea">
        <div class="date-right">
            <?php $_smarty_tpl->tpl_vars["now_date_time"] = new Smarty_Variable(smarty_modifier_date_format(time(),"%Y-%m-%d %H:%M:%S"), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "now_date_time", 0);?>
            <span><?php echo $_smarty_tpl->tpl_vars['this']->value->general->dateTimeSystemFormat($_smarty_tpl->tpl_vars['now_date_time']->value);?>
</span>
        </div>
        <div class="btn-logout">
            <a hijacked="yes" href="javascript:;" class="gray-bg admin-link-logout"><span class="icon16 icomoon-icon-exit"></span> <?php echo $_smarty_tpl->tpl_vars['logout_arr']->value['label_lang'];?>
</a>
        </div>
        <span class="loggedname gray-bg right">
            <span class="icon16 icomoon-icon-user-2"></span>
            <span id="logged_name" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->session->userdata('vName');?>
"><?php echo $_smarty_tpl->tpl_vars['this']->value->general->truncateChars($_smarty_tpl->tpl_vars['this']->value->session->userdata("vName"),21);?>
</span>
        </span>
        <?php if ($_smarty_tpl->tpl_vars['this']->value->config->item('MULTI_LINGUAL_PROJECT') == 'Yes') {?>
            <?php $_smarty_tpl->tpl_vars['topDefLang'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->config->item('DEFAULT_LANG'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'topDefLang', 0);?>
            <?php $_smarty_tpl->tpl_vars['topPrimeLang'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->config->item('PRIME_LANG'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'topPrimeLang', 0);?>
            <?php $_smarty_tpl->tpl_vars['topOtherLang'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->config->item('OTHER_LANG'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'topOtherLang', 0);?>
            <?php $_smarty_tpl->tpl_vars['top_lang_data'] = new Smarty_Variable($_smarty_tpl->tpl_vars['this']->value->config->item('LANG_INFO'), null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, 'top_lang_data', 0);?>
           <span class="lang-box gray-bg right">
                 <div class="lang-label"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_LANGUAGE');?>
 &nbsp;</div>
                 <div class="lang-drop">
                    <select name="topLangCombo" id="topLangCombo" class="chosen-select lang-combo">
                        <option value="<?php echo $_smarty_tpl->tpl_vars['topPrimeLang']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['topDefLang']->value == $_smarty_tpl->tpl_vars['topPrimeLang']->value) {?> selected= true <?php }?>>
                            <?php echo $_smarty_tpl->tpl_vars['top_lang_data']->value[$_smarty_tpl->tpl_vars['topPrimeLang']->value]['vLangTitle'];?>

                        </option>
                        <?php if ((is_array($_smarty_tpl->tpl_vars['topOtherLang']->value)) && (count($_smarty_tpl->tpl_vars['topOtherLang']->value) > 0)) {?>
                            <?php
$__section_i_0_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_0_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['topOtherLang']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_0_total = $__section_i_0_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_0_total != 0) {
for ($__section_i_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_0_iteration <= $__section_i_0_total; $__section_i_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['topOtherLang']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)];?>
" <?php if ($_smarty_tpl->tpl_vars['topDefLang']->value == $_smarty_tpl->tpl_vars['topOtherLang']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]) {?> selected=true <?php }?>>
                                <?php echo $_smarty_tpl->tpl_vars['top_lang_data']->value[$_smarty_tpl->tpl_vars['topOtherLang']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]]['vLangTitle'];?>
 
                            </option>
                            <?php
}
}
if ($__section_i_0_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_0_saved;
}
?>
                        <?php }?>
                    </select>
                </div>
            </span>
        <?php }?>
        <div class="translate-box-left-menu">
            <?php if ($_smarty_tpl->tpl_vars['this']->value->config->item("ENABLE_PAGE_TRANSLATION") == 1) {?>
                <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:admin_page_translate.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <?php }?>
        </div>
    </div>
</div>
<div class="clear"></div>

<div class="collapseBtn leftbar" id="collapse_btn">
    <a class="left-menu-hide tipR" href="javascript://" title="<?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_HIDE_SIDEBAR');?>
"><span class="icon14 minia-icon-list-3"></span></a>
</div>

<div id="sidebarbg" class="sidebarbg-main <?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('ADMIN_THEME_PATTERN_LEFT');?>
"></div>
<div id="sidebar" class="sidebar-main">
    <div class="sidenav">
        <?php if (is_array($_smarty_tpl->tpl_vars['menu_arr']->value) && count($_smarty_tpl->tpl_vars['menu_arr']->value) > 0) {?>
            <div id="sidebar_widget" class="sidebar-widget">
                <h5 class="title"><span class="sidebar-navigation"><?php echo $_smarty_tpl->tpl_vars['this']->value->lang->line('GENERIC_NAVIGATION');?>
</span></h5>
            </div>
            <div class="clear"></div>
            <div id="left_mainnav" class="mainnav">
                <ul>
                    <?php
$__section_i_1_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_i']) ? $_smarty_tpl->tpl_vars['__section_i'] : false;
$__section_i_1_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['parent_arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_i_1_total = $__section_i_1_loop;
$_smarty_tpl->tpl_vars['__smarty_section_i'] = new Smarty_Variable(array());
if ($__section_i_1_total != 0) {
for ($__section_i_1_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] = 0; $__section_i_1_iteration <= $__section_i_1_total; $__section_i_1_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']++){
?>
                        <?php $_smarty_tpl->tpl_vars["child_arr"] = new Smarty_Variable($_smarty_tpl->tpl_vars['menu_arr']->value[$_smarty_tpl->tpl_vars['parent_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['id']], null);
$_smarty_tpl->ext->_updateScope->updateScope($_smarty_tpl, "child_arr", 0);?>
                        <li id="parent_menu_<?php echo $_smarty_tpl->tpl_vars['parent_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['id'];?>
" class="parent-menu-li">
                            <a class="menu-parent-anchor" href="javascript://" title="<?php echo $_smarty_tpl->tpl_vars['parent_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['label_lang'];?>
" >
                                <span class="menu-parent-anchor-span icon16 <?php echo $_smarty_tpl->tpl_vars['parent_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['icon'];?>
"></span>
                                <?php echo $_smarty_tpl->tpl_vars['parent_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['label_lang'];?>

                            </a>
                            <?php if (is_array($_smarty_tpl->tpl_vars['child_arr']->value) && count($_smarty_tpl->tpl_vars['child_arr']->value) > 0) {?>
                                <ul class="sub">
                                    <?php
$__section_j_2_saved = isset($_smarty_tpl->tpl_vars['__smarty_section_j']) ? $_smarty_tpl->tpl_vars['__section_j'] : false;
$__section_j_2_loop = (is_array(@$_loop=$_smarty_tpl->tpl_vars['child_arr']->value) ? count($_loop) : max(0, (int) $_loop));
$__section_j_2_total = $__section_j_2_loop;
$_smarty_tpl->tpl_vars['__smarty_section_j'] = new Smarty_Variable(array());
if ($__section_j_2_total != 0) {
for ($__section_j_2_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] = 0; $__section_j_2_iteration <= $__section_j_2_total; $__section_j_2_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']++){
?>
                                        <li class="child-menu-li">
                                            <a hijacked="yes" class="menu-child-anchor <?php echo $_smarty_tpl->tpl_vars['child_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['class'];?>
" aria-nav-code="<?php echo $_smarty_tpl->tpl_vars['child_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['code'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['child_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['url'];?>
" 
                                               target="<?php echo $_smarty_tpl->tpl_vars['child_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['target'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['child_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['label_lang'];?>
">
                                                <span class="menu-child-anchor-span icon14 <?php echo $_smarty_tpl->tpl_vars['child_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['icon'];?>
"></span> 
                                                <?php echo $_smarty_tpl->tpl_vars['child_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_j']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_j']->value['index'] : null)]['label_lang'];?>

                                            </a>
                                        </li>
                                    <?php
}
}
if ($__section_j_2_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_j'] = $__section_j_2_saved;
}
?>
                                    <?php if ($_smarty_tpl->tpl_vars['parent_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['code'] == 'home') {?>
                                        <li class="child-menu-li">
                                            <a hijacked="yes" class="menu-child-anchor" aria-nav-code="<?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['code'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['label_lang'];?>
">
                                                <span class="menu-child-anchor-span icon14 <?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['icon'];?>
"></span>
                                                <?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['label_lang'];?>

                                            </a>
                                        </li>
                                        <li class="child-menu-li">
                                            <a hijacked="yes" class="menu-child-anchor fancybox-popup" aria-nav-code="<?php echo $_smarty_tpl->tpl_vars['password_arr']->value['code'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['password_arr']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['password_arr']->value['label_lang'];?>
">
                                                <span class="menu-child-anchor-span icon14 <?php echo $_smarty_tpl->tpl_vars['password_arr']->value['icon'];?>
"></span>
                                                <?php echo $_smarty_tpl->tpl_vars['password_arr']->value['label_lang'];?>

                                            </a>
                                        </li>
                                    <?php }?>
                                </ul>
                            <?php } elseif ($_smarty_tpl->tpl_vars['parent_arr']->value[(isset($_smarty_tpl->tpl_vars['__smarty_section_i']->value['index']) ? $_smarty_tpl->tpl_vars['__smarty_section_i']->value['index'] : null)]['code'] == 'home') {?>
                                <ul class="sub">
                                    <li class="child-menu-li">
                                        <a hijacked="yes" class="menu-child-anchor" href="<?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['label_lang'];?>
">
                                            <span class="menu-child-anchor-span icon14 <?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['icon'];?>
"></span>
                                            <?php echo $_smarty_tpl->tpl_vars['profile_arr']->value['label_lang'];?>

                                        </a>
                                    </li>
                                    <li class="child-menu-li">
                                        <a hijacked="yes" aria-nav-code="<?php echo $_smarty_tpl->tpl_vars['password_arr']->value['code'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['password_arr']->value['url'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['password_arr']->value['label_lang'];?>
" class="menu-child-anchor fancybox-popup">
                                            <span class="menu-child-anchor-span icon14 <?php echo $_smarty_tpl->tpl_vars['password_arr']->value['icon'];?>
"></span>
                                            <?php echo $_smarty_tpl->tpl_vars['password_arr']->value['label_lang'];?>

                                        </a>
                                    </li>
                                </ul>
                            <?php }?>
                        </li>
                    <?php
}
}
if ($__section_i_1_saved) {
$_smarty_tpl->tpl_vars['__smarty_section_i'] = $__section_i_1_saved;
}
?>
                </ul>
            </div>
        </div>
    <?php }?>         
</div><?php }
}

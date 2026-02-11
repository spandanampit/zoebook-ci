<?php
/* Smarty version 3.1.28, created on 2025-02-06 06:43:24
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/views/top/top.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_67a4ca8c44c144_09011499',
  'file_dependency' => 
  array (
    'cfa5ce524f1649a71571e1f533739633f096f766' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/views/top/top.tpl',
      1 => 1738852992,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_67a4ca8c44c144_09011499 ($_smarty_tpl) {
?>
<style>
.bg-violet {
    background: #8e65a1;
    color: white;
}

.bg-violet:hover {
    color: #8e65a1;
    background-color: white;
    border: 1px solid;
}

.dropdown{
    margin-left: 18px;
}
</style>
<?php echo $_smarty_tpl->tpl_vars['this']->value->js->add_js("front/chat-count.js");?>

<div class="new_loader" style="display:none;"></div>
<header class="second-header fixed-top dashboard-header">
    <nav class="navbar navbar-expand-lg" aria-label="Eighth navbar example">
    <div class="container-fluid container-2">
        <div class="mobile-dash">
            <i class="fa-regular fa-chart-bar"></i>
        </div>
        <a class="navbar-brand" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/homepage');?>
">
            <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') > 0) {?>
                <div class="logo-2">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-logo.png" alt="">
                </div>
            <?php } else { ?>
                <div class="logo-2">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-logo.png" alt="" style="border-radius: 0px !important;">
                </div>
            <?php }?>
        </a>
        <button class="navbar-toggler" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon">
            <i class="fa-solid fa-bars-staggered"></i>
            </span>
        </button>

        <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') >= 0) {?>
            <div class="header-search-2">
                <div class="mobile-search">
                    <div class="search-toggle">
                        <button class="search-icon icon-search"><i class="fa-solid fa-magnifying-glass"></i></button>
                        <button class="search-icon icon-close"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    
                    <div class="search-container">
                        <form>
                        <input type="text" name="q" id="search-terms" placeholder="Search terms..." />
                        <button type="submit" name="submit" value="Go" class="search-icon"><i class="fa fa-fw fa-search"></i></button>
                        </form>
                    </div>
                </div> 
                <div class="desktop-search">
                  <div class="form-group">
                    <input type="text" class="form-control" id="searchfriends" name="searchfriends" aria-describedby="emailHelp" >
                  </div>
                  <button type="submit" class=" header-search-btn"><i class="fa fa-search" style="color: grey"></i></button>
              </div>               
            </div>
       
        <?php }?>

        <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') > 0) {?>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                <ul class="navbar-nav mx-auto mb-lg-0">
                    <li class="nav-item">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
home.html"><?php echo $_smarty_tpl->tpl_vars['home']->value;?>
</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/home/my_profile');?>
" title="My Dashboard"><?php echo $_smarty_tpl->tpl_vars['profile']->value;?>
</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
viral-posts.html" title="My Dashboard"><?php echo $_smarty_tpl->tpl_vars['viral_post']->value;?>
</a>
                    </li>   
                    <li class="nav-item">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/watchvideo');?>
" title="My Dashboard"><?php echo $_smarty_tpl->tpl_vars['viral_post_plus']->value;?>
</a>
                    </li>        
                    <li class="nav-item vid-yellow-bg">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/index');?>
" title="My Dashboard"><?php echo $_smarty_tpl->tpl_vars['movement']->value;?>
</a>
                    </li>      
                </ul>

            </div>
        <?php }?>

        <div class="header-right">
        <?php if ($_smarty_tpl->tpl_vars['this']->value->session->userdata('iUserId') > 0) {?>
            <ul>
                <li>
                    <div class="live-btn-box">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('site_url');?>
golive-start.html" class="live-btn"><?php echo $_smarty_tpl->tpl_vars['go_live']->value;?>
</a>
                    </div>
                </li>
                <li class="nav-item">
                    <?php echo $_smarty_tpl->tpl_vars['mode']->value;?>

                    <div class="box-switch">
                    <div class="switch"></div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="account-box">
                    <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'] != '') {?>
                        <img id="imagePreviewProfile" src="<?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_profile_image'];?>
" alt="User profile picture">
                    <?php } else { ?>
                        <img id="imagePreviewProfile" src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/user.png" alt="Default profile picture">
                    <?php }?>
                    <div class="dropdown"><a href="#"><em><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['u_name'];?>
</em> <span><i class='fas fa-angle-down'></i></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('home/home/my_profile');?>
" title="My Dashboard"><i class="fa-regular fa-user"></i> <?php echo $_smarty_tpl->tpl_vars['profile']->value;?>
</a></li>
                            <li><a href="javascript:;"><i class="fa-regular fa-comment-dots chat-link"></i> <?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</a></li>
                            <li><a id="logout_btn" href="javascript:;" data-href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/user/logout');?>
" title="Logout"><?php echo $_smarty_tpl->tpl_vars['logout']->value;?>
</a></li>
                        </ul>
                    </div>
                    </div>
                </li>
                <div class="dropdown">
                    <button class="btn bg-violet dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_smarty_tpl->tpl_vars['language']->value;?>

                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="setLanguage('english')">English (Default)</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('Haitian_creole')">Haitian Creole</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('spanish')">Spanish</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('bengali')">Bengali</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('french')">French</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('hindi')">Hindi</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('chinese')">中国人</a>
                    </div>
                </div>
            </ul>
        <?php } else { ?>
            <nav class="navbar navbar-expand" aria-label="Eighth navbar example">
                <div class="container-fluid">
                <div class="header-box" >
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">              
                    <ul class="navbar-nav ms-auto mb-lg-0">
                        <li class="nav-item">
                        <?php echo $_smarty_tpl->tpl_vars['mode']->value;?>

                        <div class="box-switch">
                            <div class="switch"></div>
                        </div>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/index');?>
">
                            <span class="login-box">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['this']->value->config->item('images_url');?>
front/new-front-image/circle-arrow.png " alt="" />
                            </span>
                        <?php echo $_smarty_tpl->tpl_vars['login']->value;?>
 
                        </a>
                        </li>
                    </ul>              
                    </div>
                    <div class="header-btn-box">
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('user/user/signup');?>
" class="sign-btn"><?php echo $_smarty_tpl->tpl_vars['register']->value;?>
</a>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('content/content/watchvideo');?>
" class="watch-btn"><?php echo $_smarty_tpl->tpl_vars['watchnow']->value;?>
</a>
                    </div>
                    <div class="dropdown">
                        <button class="btn bg-violet dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo $_smarty_tpl->tpl_vars['language']->value;?>

                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="setLanguage('english')">English (Default)</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('Haitian_creole')">Haitian Creole</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('spanish')">Spanish</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('hindi')">Hindi</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('bengali')">Bengali</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('chinese')">中国人</a>
                        <a class="dropdown-item" href="#" onclick="setLanguage('french')">French</a>
                        </div>
                    </div>
                </div>          
                </div>
            </nav>
        <?php }?>
        </div>
    </div>
    </nav>
</header>
<?php echo '<script'; ?>
>
    // Function to set the dark mode cookie
function setDarkModeCookie(value) {
    // Calculate expiration date for the cookie (one year from now)
    const expirationDate = new Date();
    expirationDate.setFullYear(expirationDate.getFullYear() + 1);

    // Format the expiration date as a UTC string
    const expires = expirationDate.toUTCString();

    // Set the darkmode cookie with the specified value and expiration
    document.cookie = `darkmode=${value}; expires=${expires}; path=/;`;
}

// Function to check if dark mode is enabled based on cookie
function checkDarkModeCookie() {
    return document.cookie.replace(/(?:(?:^|.*;\s*)darkmode\s*\=\s*([^;]*).*$)|^.*$/, "$1") === "1";
}

// Function to toggle dark mode
function toggleDarkMode() {
    const body = document.querySelector("body");
    if (checkDarkModeCookie()) {
        body.classList.add("dark");
    } else {
        body.classList.remove("dark");
    }
}

// Event listener for mode switch (toggle button)
const switchElement = document.querySelector(".switch");

switchElement.addEventListener("click", () => {
    const isDarkMode = checkDarkModeCookie();
    setDarkModeCookie(isDarkMode ? "0" : "1");
    toggleDarkMode();
});

// Initial toggle based on cookie value when the page loads
toggleDarkMode();

<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>
function setLanguage(lang) {
    $.ajax({
        url: 'home/language',
        method: 'POST',
        data: { language: lang },
        success: function(response) {
            location.reload();
        }
    });
}
<?php echo '</script'; ?>
>
<?php }
}

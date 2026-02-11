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

@media (max-width: 576px){
    .watch-btn {
        width: 135px;
    }
}

.pb-10 {
      padding-bottom: 10px;
}
</style>
<%$this->js->add_js("front/chat-count.js")%>

<div class="new_loader" style="display:none;"></div>
<header class="second-header fixed-top dashboard-header">
    <nav class="navbar navbar-expand-lg" aria-label="Eighth navbar example">
    <div class="container-fluid container-2">
        <div class="mobile-dash">
            <i class="fa-regular fa-chart-bar"></i>
        </div>
        <a class="navbar-brand" href="<%$this->url->make('content/content/homepage')%>">
            <%if $this->session->userdata('iUserId') gt 0%>
                <div class="logo-2">
                    <img src="<%$this->config->item('images_url')%>front/new-logo.png" alt="">
                </div>
            <%else%>
                <div class="logo-2">
                    <img src="<%$this->config->item('images_url')%>front/new-logo.png" alt="" style="border-radius: 0px !important;">
                </div>
            <%/if%>
        </a>
        
        <button class="navbar-toggler" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon">
            <i class="fa-solid fa-bars-staggered"></i>
            </span>
        </button>

        <%if $this->session->userdata('iUserId') ge 0%>
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
       
        <%/if%>

        <%if $this->session->userdata('iUserId') gt 0%>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                <ul class="navbar-nav mx-auto mb-lg-0">
                    <li class="nav-item">
                        <a href="<%$this->config->item('site_url')%>home.html"><%$home%></a>
                    </li>
                    <li class="nav-item">
                        <a href="<%$this->url->make('home/home/my_profile')%>" title="My Dashboard"><%$profile%></a>
                    </li>
                    <li class="nav-item">
                        <a href="<%$this->config->item('site_url')%>viral-posts.html" title="My Dashboard"><%$viral_post%></a>
                    </li>   
                    <li class="nav-item">
                        <a href="<%$this->url->make('content/content/watchvideo')%>" title="My Dashboard"><%$viral_post_plus%></a>
                    </li>
                    <li class="nav-item vid-yellow-bg">
                        <a href="<%$this->url->make('movement/movement/index')%>" title="My Dashboard"><%$movement%></a>
                    </li>      
                </ul>

            </div>
        <%/if%>

        <div class="header-right">
        <%if $this->session->userdata('iUserId') gt 0%>
            <ul>
                <li>
                    <div class="live-btn-box">
                    <a href="<%$this->config->item('site_url')%>golive-start.html" class="live-btn"><%$go_live%></a>
                    </div>
                </li>
                <li class="nav-item">
                    <%$mode%>
                    <div class="box-switch">
                    <div class="switch"></div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="account-box">
                    <%if $userinfo.u_profile_image neq ''%>
                        <img id="imagePreviewProfile" src="<%$userinfo.u_profile_image%>" alt="User profile picture">
                    <%else%>
                        <img id="imagePreviewProfile" src="<%$this->config->item('images_url')%>front/new-front-image/user.png" alt="Default profile picture">
                    <%/if%>
                    <div class="dropdown"><a href="#"><em><%$userinfo.u_name%></em> <span><i class='fas fa-angle-down'></i></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<%$this->url->make('home/home/my_profile')%>" title="My Dashboard"><i class="fa-regular fa-user"></i> <%$profile%></a></li>
                            <li><a href="javascript:;"><i class="fa-regular fa-comment-dots chat-link"></i> <%$message%></a></li>
                            <li><a id="logout_btn" href="javascript:;" data-href="<%$this->url->make('user/user/logout')%>" title="Logout"><%$logout%></a></li>
                        </ul>
                    </div>
                    </div>
                </li>
                <div class="dropdown">
                    <button class="btn bg-violet dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <%$language%>
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
        <%else%>
            <nav class="navbar navbar-expand" aria-label="Eighth navbar example">
                <div class="container-fluid">
                <div class="header-box" >
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">              
                    <ul class="navbar-nav ms-auto mb-lg-0 pb-10">
                        <li class="nav-item">
                        <%$mode%>
                        <div class="box-switch">
                            <div class="switch"></div>
                        </div>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="<%$this->url->make('content/content/index')%>">
                            <span class="login-box">
                            <img src="<%$this->config->item('images_url')%>front/new-front-image/circle-arrow.png " alt="" />
                            </span>
                        <%$login%> 
                        </a>
                        </li>
                    </ul>              
                    </div>
                    <div class="header-btn-box">
                        <a href="<%$this->url->make('user/user/signup')%>" class="sign-btn"><%$register%></a>
                        <a href="<%$this->url->make('content/content/watchvideo')%>" class="watch-btn"><%$watchnow%></a>
                    </div>
                    <div class="dropdown">
                        <button class="btn bg-violet dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <%$language%>
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
        <%/if%>
        </div>
    </div>
    </nav>
</header>
<script>
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

</script>

<script>
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
</script>

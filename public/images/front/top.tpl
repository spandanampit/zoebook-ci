<div class="new_loader" style="display:none;"></div>
<header class="second-header fixed-top dashboard-header">
    <nav class="navbar navbar-expand-lg" aria-label="Eighth navbar example">
    <div class="container-fluid container-2">
        <div class="mobile-dash">
            <i class="fa-regular fa-chart-bar"></i>
        </div>
        <a class="navbar-brand" href="<%$this->config->item('site_url')%>">
            <div class="logo-2">
            <%if $this->session->userdata('iUserId') gt 0%>
                <img src="<%$this->config->item('images_url')%>front/new-logo.png" alt="">
            <%else%>
                <img src="<%$this->config->item('images_url')%>front/logo.png" alt="">
            <%/if%>
            </div>
        </a>
        <button class="navbar-toggler" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
            <span class="navbar-toggler-icon">
            <i class="fa-solid fa-bars-staggered"></i>
            </span>
        </button>

        
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
            <form>
                <div class="form-group">
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <button type="submit" class="btn btn-primary header-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            </div>               
        </div>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            <ul class="navbar-nav mx-auto mb-lg-0">
            <li class="nav-item">
                <a href="#">Home</a>
            </li>
            <li class="nav-item">
                <a href="#">Viral Post</a>
            </li>
            <li class="nav-item">
                <a href="#">Viral Plus</a>
            </li>
            <li class="nav-item">
                <a href="#">Profile</a>
            </li>                
            </ul>
        </div>
        <div class="header-right">
        <ul>
            <li>
                <div class="live-btn-box">
                <a href="#" class="live-btn">Go live</a>
                </div>
            </li>
            <li class="nav-item">
                Mode
                <div class="box-switch">
                <div class="switch"></div>
                </div>
            </li>
            <li class="nav-item">
                <div class="account-box">
                <img src="images/account.png" alt="">
                <div class="dropdown"><a href="#"><em>John Doe</em> <span><i class="fa-solid fa-chevron-down"></i></span></a>
                    <ul class="dropdown-menu">
                    <li><a href="#"><i class="fa-regular fa-user"></i> Profile</a></li>
                    <li><a href="#"><i class="fa-regular fa-comment-dots"></i> Message</a></li>
                    <li><a href="#"><i class="fa-solid fa-gear"></i> Setting</a></li>
                    </ul>
                </div>
                </div>
            </li>
        </ul>
        </div>
    </div>
    </nav>
</header>

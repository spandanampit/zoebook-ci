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

/* Color Variables */
:root {
  --primary-color: #2c3e50;
  --secondary-color: #3498db;
  --background-color: #ecf0f1;
  --text-color: #333;
  --hover-color: #2980b9;
}

/* Base Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

body {
  font-family: "Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
    Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
  background-color: var(--background-color);
  color: var(--text-color);
  line-height: 1.6;
}

/* Responsive Adjustments */
@media (min-width: 768px) {
  .nav-menu {
    width: 750px;
  }
}
/*Medium Screens */
@media (min-width: 922px) {
  .nav-menu {
    width: 970px;
  }
}
/*Large Screens */
@media (min-width: 1200px) {
  .nav-menu {
    width: 1170px;
  }
}

/* Burger Icon Container */
.burger-container {
  position: fixed;
  top: 20px;
  right: 30px;
  z-index: 1000;
  cursor: pointer;
  width: 40px;
  height: 30px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 5px;
  border-radius: 5px;
  background: hwb(0 100% 0% / 0.1);
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 6px #0000001a;
}

/* Burger Icon Lines */
.burger-line {
  width: 100%;
  height: 3px;
  background-color: var(--primary-color);
  border-radius: 2px;
  transform-origin: center;
  transition: all 0.4s ease-in-out;
}

#burger-toggle {
  display: none;
}

/* Navigation Styles */
.nav-menu {
  position: fixed;
  top: 0;
  right: -300px;
  width: 100%;
  height: 100%;
  transition: right 0.4s cubic-bezier(0.77, 0.2, 0.05, 1);
  box-shadow: -4px 0 15px #00000033;
  overflow-y: hidden;
  padding-top: 100px;
  border: 2px solid #8e65a1;
  border-radius: 10px;
}

.nav-menu::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 80px;
  background: #ffffff0d;
  backdrop-filter: blur(10px);
}

.nav-menu ul {
  list-style-type: none;
}

.nav-menu ul li {
  margin: 0 15px;
  border-bottom: 1px solid #ffffff1a;
}

.nav-menu ul li a {
  color: #8e65a1;
  text-decoration: none;
  display: block;
  padding: 15px;
  font-weight: 500;
  position: relative;
  overflow: hidden;
}

.nav-menu ul li a::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background-color: var(--secondary-color);
  transition: left 0.3s ease;
}

.nav-menu ul li a:hover::after {
  left: 0;
}

/* Burger Icon Animation on Checkbox Checked */
#burger-toggle:checked ~ .burger-container .burger-line:nth-child(1) {
  transform: rotate(45deg) translate(5px, 5px);
}

#burger-toggle:checked ~ .burger-container .burger-line:nth-child(2) {
  opacity: 0;
}

#burger-toggle:checked ~ .burger-container .burger-line:nth-child(3) {
  transform: rotate(-45deg) translate(5px, -5px);
}

/* Navigation Slide In */
#burger-toggle:checked ~ .nav-menu {
  right: 0;
}

.custom-search-bar {
    display: flex;
    align-items: center;
    border: 1px solid #ccc;
    border-radius: 25px;
    padding: 5px 15px;
    width: 100%;
    max-width: 300px;
    background: #f8f8f8;
    margin-left: auto;
    margin-right: auto;
    width: 100%;
}

.custom-search-bar input {
    border: none;
    outline: none;
    flex: 1;
    padding: 8px;
    background: transparent;
    font-size: 14px;
}

.custom-search-bar button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
}

.custom-search-bar button i {
    font-size: 18px;
    color: grey;
}

.new-seacrh-bar {
      width: 100%;
      margin-top: 10px;
}

@media(max-width: 786px) {
      .burger-menu {
            display: block !important;
      }

      .main-menu{
            display: none !important;
      }

      .new-seacrh-bar {
            display: block !important;
      }

      .desktop-search {
            display: none !important;
      }

      .language {
            display: none !important;
      }

      .mobile-language {
            display: block !important;
      }

      .dropdown {
            margin-left: 0px !important;
            margin-right: 25px;
      }

      .watch-btn{
            padding: 9px 25px !important;
            color: white !important;
      }

      .nav-menu {
            margin-left: 5px !important;
      }

      .custom-nav {
            margin-left: 0px !important;
      }
}

@media(max-width: 410px) {
      .dropdown {
            margin-right: 50px;
      }

      .nav-menu ul li {
            margin: 0 6px !important;
      }
}

#searchResults {
      padding-left: 12px;
      max-height: 500px;
      overflow-y: scroll;
      position: absolute;
      background: #ffffff;
      border: 5px solid #dedede;
      border-radius: 15px;
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
        
      <div class="burger-menu" style="display: none;">
            <input type="checkbox" id="burger-toggle">
            <label for="burger-toggle" class="burger-container">
                  <div class="burger-line"></div>
                  <div class="burger-line"></div>
                  <div class="burger-line"></div>
            </label>
      </div>

      <div class="dropdown mobile-language" style="display: none;">
            <i class="fa fa-language lang-logo" style="font-size:36px; cursor: pointer; color:#8e65a1;padding-top: 8px;" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
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
                        <div id="searchResults"></div>

                  </div>               
            </div>

            <div class="new-seacrh-bar" style="display: none;">
                  <div class="custom-search-bar">
                        <input type="text" class="form-control" id="searchfriends" name="searchfriends" placeholder="Search friends...">
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
                        <a href="<%$this->url->make('movement/movement/index')%>" title="My Dashboard"><%$movement_name_menu%></a>
                    </li>
                </ul>

            </div>

            <nav class="nav-menu  custom-nav" style="display: none;">
                  <ul>  
                        <li><a href="<%$this->config->item('site_url')%>home.html"><%$home%></a></li>
                        <li><a href="<%$this->url->make('home/home/my_profile')%>" title="My Dashboard"><%$profile%></a></li>
                        <li><a href="<%$this->config->item('site_url')%>viral-posts.html" title="My Dashboard"><%$viral_post%></a></li>
                        <li><a href="<%$this->url->make('content/content/watchvideo')%>" title="My Dashboard"><%$viral_post_plus%></a></li>
                        <li><a href="<%$this->url->make('movement/movement/index')%>" title="My Dashboard"><%$movement%></a></li>
                        <li><a href="<%$this->config->item('site_url')%>golive-start.html"> <%$go_live%></a></li>
                        <li><a href="javascript:;"> <%$message%></a></li>
                        <li><a id="logout_btn" href="<%$this->url->make('user/user/logout')%>" data-href="<%$this->url->make('user/user/logout')%>" title="Logout"><%$logout%></a></li>
                  </ul>
            </nav>
            
        <%/if%>

        <div class="header-right">
        <%if $this->session->userdata('iUserId') gt 0%>
            <ul class="main-menu">
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
                            <li><a id="logout_btn" href="<%$this->url->make('user/user/logout')%>" data-href="<%$this->url->make('user/user/logout')%>" title="Logout"><i class="fa-solid fa-arrow-right-to-bracket"></i><%$logout%></a></li>
                        </ul>
                    </div>
                    </div>
                </li>
                <div class="dropdown language">
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
            <nav class="navbar navbar-expand main-menu" aria-label="Eighth navbar example">
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
                        <div class="dropdown language">
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

            <nav class="nav-menu" style="display: none;">
                  <ul>  
                        <li>
                              <a class="nav-link" href="<%$this->url->make('content/content/index')%>">
                                    <%$login%> 
                              </a>
                        </li>
                        <li><a href="<%$this->url->make('user/user/signup')%>"><%$register%></a></li>
                        <li><a href="<%$this->url->make('content/content/watchvideo')%> " class="watch-btn"><%$watchnow%></a></li>
                  </ul>
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
<script>
const input = document.getElementById('searchfriends');
const resultsContainer = document.getElementById('searchResults');

input.addEventListener('input', function() {
  console.log('Input changed:', this.value);

  if (this.value.length >= 3) {
    console.log('trigger ajax');

    $.ajax({
      url: 'content/search_peoples',
      method: 'POST',
      data: { keyword: this.value },
      dataType: 'json',
      success: function(response) {
        console.log('Raw Response:', response);

        if (!response || !response.data) {
          console.error('Invalid response structure');
          resultsContainer.innerHTML = '<div>Invalid response structure</div>';
          return;
        }

        const users = response.data.data || [];
        const posts = response.posts || [];
        console.log('Users Array:', users);
        console.log('Posts Array:', posts);

        resultsContainer.innerHTML = ''; // Clear old results

        // Display Users Section
        if (users.length > 0) {
          resultsContainer.insertAdjacentHTML('beforeend', '<h3 style="font-size: 18px; font-weight: 600; color: #333; margin: 20px 10px 10px;">Users</h3>');
          users.forEach(user => {
            const profileImage = user.u_profile_image || 'https://via.placeholder.com/50';
            const userName = user.u_name || 'No Name';
            const userEmail = user.u_email || 'No email available';
            const userLink = user.profile_url || '#';

            const userHTML = `
              <div style="
                display: flex; 
                align-items: center; 
                margin-bottom: 10px; 
                padding: 12px; 
                border: 1px solid #ddd; 
                border-radius: 10px; 
                background-color: #fff; 
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                transition: background-color 0.3s;
              " 
              onmouseover="this.style.backgroundColor='#f9f9f9'" 
              onmouseout="this.style.backgroundColor='#fff'">
                <a href="${userLink}" style="display: flex; align-items: center; text-decoration: none; width: 100%;">
                  <img src="${profileImage}" alt="${userName}" style="
                    width: 50px; 
                    height: 50px; 
                    object-fit: cover; 
                    border-radius: 50%; 
                    margin-right: 15px; 
                    border: 2px solid #eee;
                  ">
                  <div style="flex-grow: 1;">
                    <div style="
                      font-weight: 600; 
                      font-size: 16px; 
                      color: #333; 
                      margin-bottom: 4px;
                    ">${userName}</div>
                    <div style="
                      font-size: 13px; 
                      color: #777;
                    ">${userEmail}</div>
                  </div>
                </a>
              </div>
            `;
            resultsContainer.insertAdjacentHTML('beforeend', userHTML);
          });
        } else {
          resultsContainer.insertAdjacentHTML('beforeend', '<div style="margin: 10px 0; color: #777;">No users found.</div>');
        }

        if (posts.length > 0) {
            resultsContainer.insertAdjacentHTML('beforeend', '<h3 style="font-size: 18px; font-weight: 600; color: #333; margin: 20px 10px 10px;">Posts</h3>');
            posts.forEach(post => {
            const postText = decodeUnicode(post.tPostTextEmoji || 'No content available');
            const postLink = post.post_url || '#';
            const postAuthor = post.vName || 'Unknown Author';
            const postFileUrl = post.file_url || 'https://via.placeholder.com/100';

            // Check if the file is a video (e.g., MP4)
            const isVideo = postFileUrl.toLowerCase().endsWith('.mp4');

            // Define media HTML based on file type
            const mediaHTML = isVideo
                  ? `
                  <video controls style="
                  width: 100px; 
                  height: 100px; 
                  object-fit: cover; 
                  border-radius: 8px; 
                  margin-right: 15px;
                  ">
                  <source src="${postFileUrl}" type="video/mp4">
                  Your browser does not support the video tag.
                  </video>
                  `
                  : `
                  <img src="${postFileUrl}" alt="Post Image" style="
                  width: 100px; 
                  height: 100px; 
                  object-fit: cover; 
                  border-radius: 8px; 
                  margin-right: 15px;
                  ">
                  `;

            const postHTML = `
                  <div style="
                  margin-bottom: 15px; 
                  padding: 15px; 
                  border: 1px solid #ddd; 
                  border-radius: 10px; 
                  background-color: #fff; 
                  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
                  transition: background-color 0.3s;
                  " 
                  onmouseover="this.style.backgroundColor='#f9f9f9'" 
                  onmouseout="this.style.backgroundColor='#fff'">
                  <a href="${postLink}" style="text-decoration: none; color: inherit; display: block;">
                  <div style="display: flex; align-items: flex-start;">
                        ${mediaHTML}
                        <div style="flex-grow: 1;">
                        <div style="
                        font-weight: 600; 
                        font-size: 15px; 
                        color: #333; 
                        margin-bottom: 5px;
                        ">Posted by ${postAuthor}</div>
                        <div style="
                        font-size: 14px; 
                        color: #555; 
                        margin-bottom: 8px;
                        max-height: 60px; 
                        overflow: hidden; 
                        text-overflow: ellipsis;
                        ">${postText}</div>
                        <div style="
                        font-size: 12px; 
                        color: #007bff; 
                        text-decoration: underline;
                        ">View Post</div>
                        </div>
                  </div>
                  </a>
                  </div>
            `;
            resultsContainer.insertAdjacentHTML('beforeend', postHTML);
            });
            } else {
            resultsContainer.insertAdjacentHTML('beforeend', '<div style="margin: 10px 0; color: #777;">No posts found.</div>');
            }
      },
      error: function(xhr, status, error) {
        console.error('AJAX Error:', status, error);
        resultsContainer.innerHTML = '<div style="color: #d32f2f;">Error fetching results. Please try again.</div>';
      }
    });
  } else {
    resultsContainer.innerHTML = '';
  }
});

function decodeUnicode(str) {
  try {
    return str.replace(/\\u\{([0-9A-Fa-f]+)\}|\\u([0-9A-Fa-f]{4})/g, (_, hex1, hex2) => {
      const codePoint = parseInt(hex1 || hex2, 16);
      return String.fromCodePoint(codePoint);
    });
  } catch (e) {
    console.error('Error decoding Unicode:', e);
    return str; 
  }
}
</script>



<script>
document.addEventListener("DOMContentLoaded", function () {
    const burgerToggle = document.getElementById("burger-toggle");
    const navMenu = document.querySelector(".nav-menu");

    burgerToggle.addEventListener("click", function () {
        if (navMenu.style.position === "sticky") {
            navMenu.style.position = "";
            navMenu.style.marginLeft = "";
            navMenu.style.display = "none";
        } else {
            navMenu.style.position = "sticky";
            navMenu.style.top = "0"; // Ensures it sticks at the top
            navMenu.style.marginLeft = "50px";
            navMenu.style.display = "block";
        }
    });
});


</script>

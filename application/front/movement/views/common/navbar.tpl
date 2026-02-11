<div class="sidebar">              
<div class="sidebar-user">
  <div class="sidebar-close">
    <i class="fa-solid fa-xmark"></i>
  </div>
  <div class="sidebar-user-img">
    <%if $page neq 'movementDetails'%>
    <img src="<%$userinfo['u_profile_image']%>" alt="">
    <%else%>
    <img src="<%$movement['get_movements']['users_profile_image']%>" alt="">
    <%/if%>
  </div>
  <div class="sidebar-user-title">
    <%if $page neq 'movementDetails'%>
      <h3><%$userinfo['u_name']%></h3>
    <%else%>
    <h3><%$movement['get_movements']['users_name']%></h3>
    <%/if%>
    <!--<p>15k Followers</p>-->
  </div>
</div>
<div class="sidebar-nav">
  <div class="scroll-content-button">
    <ul>
      <li class="sidebar-nav-item">
        <a class="vid-yellow-bg" href="<%$this->url->make('movement/movement/popularmovement')%>"><%$popular_movements%></a>
      </li>
      <li class="sidebar-nav-item">
        <a class="vid-green-bg" href="<%$this->url->make('movement/movement/mymovement')%>"><%$my_movements%></a>
      </li>
      <li class="sidebar-nav-item">
        <a class="vid-purple-bg" href="<%$this->url->make('movement/movement/addmovement')%>"><%$create%></a>
      </li>
    </ul>
  </div>
</div>
</div>
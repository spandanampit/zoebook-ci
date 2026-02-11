<div class="group-box">
  <div class="group-content-box">
  <%assign var=movement_name_withouemoji value=removeEmoji($movement['get_movements']['movement_name'])%>
  <%assign var=movement_name value=$this->general->truncateChars($movement_name_withouemoji,100)%>
    <h3><%$this->general->displayposttext($movement_name)%></h3>
    <div class="harmony-box">
      <p><%$movement['get_movements']['total_members']%> <%$members%></p>
      <ul class="friends-harmonic">
        <%foreach item=row from=$movement_follower%>
        <li>
          <a href="<%$this->general->setdiplayprofileurl($row['user_details']['iUserId'],$row['user_details']['u_name'])%>">
            <img src="<%$row['user_details']['u_profile_image']%>" alt="friend">
          </a>
        </li>
        <%/foreach%>
        
      </ul>
    </div>
  </div>
  <div class="group-btn-box">
    <ul>
    <%if $userinfo['iUserId'] neq $movement['get_movements']['users_id'] %>
    <li><a href="<%$this->url->make('movement/movement/leave')%>?movement_id=<%$movement['get_movements']['movements_id']%>" class="yellow-text"><%$leave%></a></li>
    <%/if%>
      <li><a href="<%$this->url->make('movement/movement/invitefriends')%>?movementId=<%$movement['get_movements']['movements_id']%>" class="purple-text"><%$invite%></a></li>
      <li><a href="javascript:void(0)" class="orange-text" onclick="openShareModal(<%$movement['get_movements']['movements_id']%>, <%$userinfo['iUserId']%>)"><%$share%></a></li>
    </ul>
  </div>
</div>
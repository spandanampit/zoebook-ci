<style>
.new-form{
   z-index: 1;
   margin-right: -23px;
   height: 100px;
}

.new-icon{
   font-size: 24px;
   color: #ff8d00;
   margin-bottom: 0px;
   margin-top: 82px;
   position: relative;
   left: 92px;
}

#save-button {
   background-color: transparent;
   border: none;
}

.p-top-20 {
      padding-top: 20px;
}
</style>

<div class="view-post-banner">
   <div class="back-button">
      <a href="#" class="back-button"><i class="fa-solid fa-arrow-left-long"></i></a>                    
   </div>
   <div class="view-profile-banner">
      <form class="cmn-form" name="frmcover" id="frmcover" method="post" action="<%$this->url->make('home/myprofile_action')%>" enctype="multipart/form-data">
         <input type="hidden" name="topcover" id="topcover" value="">
         <input type="hidden" name="loadedtopcover" id="loadedtopcover" value="<%$coverydimention%>"> 
         <%if $profile_type eq 'my_profile'%>  
            <div class="edit-box avatar-edit" id="changephoto_block" style="z-index: 1;">
               <div id="form-image">
               <input type='file' id="cover_photo" name="cover_photo" style="display:none;" accept=".png, .jpg, .jpeg,.mp4" />
                  <label for="cover_photo">
                     <span id="changephoto"><i class="fa-solid fa-pen"></i></span>
                  </label>
               </div>
            </div>
            <div class="edit-box avatar-edit" id="savephoto_block" style="display:none; z-index: 1;">
               <div id="form-image">
                  <input type='hidden' id="saved_cover_photo" name="saved_cover_photo" />
                  <label>
                     <div id="savephoto"><i class="fa fa-save"></i></div>
                  </label>
               </div>
            </div>
         <%/if%>
         <input type='hidden' id="coverphoto_type" name="coverphoto_type" value="<%$userinfo.coverphoto_type%>"/>

         <div style="display:none;" class="dragimagetext"><%$dragDesc%></div>
         <div id="loadingcover" class="row text-center"><span style="text-align:center;width:20%;padding:10px;background:lightgray"><%$loadCover%></span></div>
         <div class="avatar-preview" id="loaddraggable">
            <%assign var=covernoimage1 value=<%$this->config->item('site_url')%>|cat:'public/images/noimage.gif'%>
            <%assign var=covernoimage2 value=<%$this->config->item('site_url')%>|cat:'public/images/noimage_1000x320.png'%>
            <input type="hidden" name="coversrc" id="coversrc" value="<%if $getuserid neq $followuserid%><%$userinfo.u_cover_photo|replace:$covernoimage1:$covernoimage2%><%else%><%$userinfo.u_cover_photo|replace:$covernoimage1:$covernoimage2%><%/if%>">
            <div id="displaycover"></div>
         </div>
      </form>  
   </div>
   <div class="profile-detail-box">
      <div class="profile-detail-user">
         <div class="profile-detail-img">

         <!--//new fixes-->
         <form enctype="multipart/form-data" method="post" action="<%$this->url->make('home/myprofile_action')%> " class="new-form">
            <input type="hidden" name="selprofilepic" id="selprofilepic" value="profilepic">
            <div id="input-container">
               <label for="profile_image" style="cursor: pointer;">
                     <i class="fa fa-plus-circle new-icon" style="font-size: 24px;"></i>
               </label>
               <input type="file" name="profile_image" id="profile_image" style="display: none;" />
            </div>
            <button type="submit" id="save-button" style="display: none;">
               <i class="fa fa-save new-icon" style="font-size: 24px; cursor: pointer;"></i>
            </button>
         </form>

            <form class="cmn-form" name="frmprofilepic" id="frmprofilepic" method="post" action="<%$this->url->make('home/myprofile_action')%>" enctype="multipart/form-data">
               <%if $profile_type eq 'my_profile'%>   
                  <div class="edit-box-2 avatar-edit" id="changeprofilepic_block" style="display:none;">
                     <div id="form-image">
                        <input type='file' id="profile_image" name="profile_image" style="display:none;" accept=".png, .jpg, .jpeg,.mp4" />
                        <label for="profile_image">
                        <span id="changeprofilepic"><i class="fa-solid fa-pen"></i></span>
                        </label>
                     </div>
                  </div> 
                  <div class="edit-box-2 avatar-edit" id="saveprofilepic_block" style="display:none;">
                     <div id="form-image">
                        <input type='file' id="profile_image" name="profile_image" style="display:none;" accept=".png, .jpg, .jpeg,.mp4" />
                        <input type='hidden' id="saved_profile_photo" name="saved_profile_photo" />
                        <label>
                           <div id="saveprofilepic" style="display:none;cursor:pointer;"><i class="fas fa-save"></i></div>
                        </label>
                     </div>
                  </div>                  
                  <input type="hidden" name="profile_pic" id="profile_pic" value="<%if $getuserid neq $followuserid%><%$userinfo.u_profile_image|replace:$covernoimage1:$covernoimage2%><%else%><%$userinfo.u_profile_image|replace:$covernoimage1:$covernoimage2%><%/if%>"/>
               <%/if%>   

               <!--<%if $userinfo.u_profile_image neq ''%>
                  <img id="imagePreviewProfile" src="<%$userinfo.u_profile_image%>" alt="User profile picture">
               <%else%>
                  <img id="imagePreviewProfile" src="<%$this->config->item('images_url')%>front/new-front-image/user.png" alt="Default profile picture">
               <%/if%>-->
               <%if $profile_type eq 'my_profile'%>
                  <!--<%$userinfo.u_profile_image%>-->
                  <input type="hidden" name="profilepicsrc" id="profilepicsrc" value="<%$userinfo.u_profile_image%>" />
                  <div class="avatar-preview">
                     <div id="profilepic_inner"></div>
                  </div>
               <%else%>
                  <div class="avatar-preview">
                     <img id="imagePreviewProfile" src="<%$userinfo.u_profile_image%>" alt="User profile picture">
                  </div>
               <%/if%>
                  <input type="hidden" name="profilepicsrc" id="profilepicsrc" value="<%if $getuserid neq $followuserid%><%$userinfo.u_profile_image|replace:$covernoimage1:$covernoimage2%><%else%><%$userinfo.u_profile_image|replace:$covernoimage1:$covernoimage2%><%/if%>" />
                  <div id="profilepic_inner"></div>
                  <%assign var=profileImage1 value=<%$this->config->item('site_url')%>|cat:'public/images/noimage.gif'%>
                  <%assign var=profileImage2 value=<%$this->config->item('site_url')%>|cat:'public/images/noimage_1000x320.png'%>
                  <input type="hidden" name="profilesrc" id="profilesrc" value="<%if $getuserid neq $followuserid%><%$userinfo.u_profile_image|replace:$profileImage1:$profileImage2%><%else%><%$userinfo.u_profile_image|replace:$profileImage1:$profileImage2%><%/if%>">
            </form>
         </div>
         <div class="profile-detail-content">
         <h3><%$userinfo.u_name%></h3>
         <ul>
            <li><%$post%> <%$userinfo.post_count%></li>
            <li><%$follower%>
               <input type="hidden" id="totfollowercount" name="totfollowercount" value="<%$userinfo.follower_count%>" />
               <a href="javascript:" data-toggle="modal" <%if $userinfo.follower_count gt 0%> data-target="#followModal" <%/if%> id="showfollowercount">
               <%$userinfo.follower_count%>
            </a>
            </li>
            <li style="display:flex"><%$following%>&nbsp; <input type="hidden" id="totfollowingcount" name="totfollowingcount" value="<%$userinfo.following_count%>">
            <div class="follower-count"><a href="javascript:" data-toggle="modal" <%if $userinfo.following_count gt 0%>data-target="#followingModal"<%/if%> id="showfollowingcount"><%$userinfo.following_count%></a></div>
            </li>
         </ul>
         </div>
      </div>
      <div class="profile-detail-btn-box p-top-20">
         <input type="hidden" name="getuser_id" id="getuser_id" value="<%$getuserid%>">
         <input type="hidden" name="userfollow_id" id="userfollow_id" value="<%$followuserid%>">
         <%if $profile_type eq 'user_profile'%>
            <%if $getuserid neq $followuserid%>
               <form class="cmn-form" name="frmfollowuser" id="frmfollowuser" method="post" action="" >
                  <input type="hidden" name="pending_request_id" id="pending_request_id" value="<%$userinfo.pending_request_id%>">
                  <input type="hidden" name="pending_request_id_1" id="pending_request_id_1" value="<%$pendingrequestid%>">
                  <%if $userinfo.is_follwing eq 'Pending'%>
                  <%assign var=follow_class value='btn-secondary'%>
                  <%assign var=followid value='cancelfollowrequest'%>
                  <%assign var=followname value='Cancel Request'%>
                  <%assign var=actbtn value='Deleted'%>
                  <%elseif $userinfo.is_follwing eq 'Yes'%>
                  <%assign var=follow_class value='btn-secondary'%>
                  <%assign var=followid value='unfollowrequest'%>
                  <%assign var=followname value='Unfollow'%>
                  <%assign var=actbtn value='Deleted'%>
                  <%else%>
                  <%assign var=follow_class value='profile-btn bg-green'%>
                  <%assign var=followid value='savefollowuser'%>
                  <%assign var=followname value='Follow'%>
                  <%assign var=actbtn value='follow'%>
                  <%/if%>
                  <input type="hidden" name="actbtn" id="actbtn" value="<%$actbtn%>">
                  <div class="profile-detail-btn-box p-top-20">
                     <a class="btn <%$follow_class%> followuser_act" href="javascript:void(0)" id="<%$followid%>"><%$followname%></a>
                     <%if $acceptrejectfollow eq 'yes'%>
                     <span id="acceptrejectblock">
                     <a class="profile-btn bg-yellow followuser_act" href="javascript:void(0)" id="acceptrequestid"><%$accept%></a>
                     <a class="profile-btn bg-red followuser_act" href="javascript:void(0)" id="rejectrequestid"><%$reject%></a>
                     </span>
                     <%/if%>
                     <!--<span id="followerrornote"></span>-->
                     <a class="profile-btn bg-yellow" href="javascript:void(0)" onclick="openChatBox(<%$getuserid%>,<%$followuserid%>,
                        '<%$userinfo['u_name']%>','<%$userinfo['u_email']%>','<%$userinfo['u_profile_image_firebase']%>');" ><%$message%><i class="fas fa-mail ml-1"></i></a>            
                     <a class="profile-btn bg-red block_user" data-userid="<%$followuserid%>" href="javascript://"><%$block%></a>
                        <a href="<%$this->url->make('content/content/about')%>?user_id=<%$userinfo['u_users_id']%>&page_type=user_profile" class="profile-btn-2 bg-lt-green">About <%$userinfo['u_name']%></a>
                  </div>
               </form>
            <%/if%>
         <%elseif $profile_type eq 'my_profile'%>
         <%assign var=user_id value=$userinfo.u_users_id %>
          <!--<pre><%$userinfo|print_r%></pre>-->
            <a href="javascript:void(0)" class="profile-btn-2 bg-lt-green" data-toggle="modal" data-target="#editProfile"><%$edit_profile%></a>
            <a href="javascript:void(0)" class="profile-btn-2 bg-lt-green" data-toggle="modal" data-target="#changePassword"><%$change_password%></a>
            <a href="<%$this->url->make('content/content/about')%>?user_id=<%$userinfo.u_users_id%>&page_type=my_profile" class="profile-btn-2 bg-lt-green">About Me</a>
         <%/if%>
      </div>
   </div>
</div>



<!-- editProfile Modal Popup <%$this->url->make('content/content/playlist')%>?user_id=<%$userinfo.u_users_id%>&profile_type=user_profile -->
<form class="cmn-form" name="frmeditprofile" id="frmeditprofile" method="post" action="<%$this->url->make('home/edit_profile_action')%>">
   <div class="modal fade cmn-modal" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title text-center" id="exampleModalLabel"><%$edit_profile%></h5>
            </div>
            <div class="modal-body">
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="far fa-envelope"></i></span>
                  </div>
                  <input type="text" value="<%$userinfo.u_email%>" class="form-control email-input" aria-describedby="emailHelp" id="vEditEmail" name="vEditEmail" placeholder="john@zoebook.com" readonly>
               </div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="far fa-user"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<%$userinfo.u_name%>" id="vEditName" name="vEditName" placeholder="name">
               </div>
               <div class="error-msg-form" id='vNameErr'></div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                  </div>
                  <input type="text" class="form-control" value="<%$userinfo.u_phone%>" id="vEditPhone" name="vEditPhone" placeholder="Mobile Number">
               </div>
               <div class="error-msg-form" id='vPhoneErr'></div>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" id="canceleditprofile"><%$cancel%></button>
               <button type="submit" class="btn btn-primary" id="saveeditprofile"><%$save%></button>
            </div>
         </div>
      </div>
   </div>
</form>
<!-- changePassword Modal Popup -->
<form class="cmn-form" name="frmchangepassword" id="frmchangepassword" method="post" action="<%$this->url->make('home/changepassword_action')%>">
   <div class="modal fade cmn-modal" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title text-center" id="exampleModalLabel"><%$change_password%></h5>
            </div>
            <div class="modal-body">
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="vOldPassword" id="vOldPassword" placeholder="Old Password">
               </div>
               <div class="error-msg-form" id='vOldPasswordErr'></div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" name="vNewPassword" id="vNewPassword" placeholder="New Password">
               </div>
               <div class="error-msg-form" id='vNewPasswordErr'></div>
               <div class="form-group input-group">
                  <div class="input-group-append">
                     <span class="input-group-text"><i class="fas fa-lock"></i></span>
                  </div>
                  <input type="password" class="form-control" id="vRePassword" name="vRePassword" placeholder="Retype New Password">
               </div>
               <div class="error-msg-form" id='vRePasswordErr'></div>
            </div>
            <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelchangepassword"><%$cancel%></button>
               <button type="submit" class="btn btn-primary" id="savechangepassword"><%$save%></button>
            </div>
         </div>
      </div>
   </div>
</form>

<script>
   const inputField = document.getElementById('profile_image');
   const inputContainer = document.getElementById('input-container');
   const saveButton = document.getElementById('save-button');

   inputField.addEventListener('change', function () {
      if (this.files.length > 0) {
         inputContainer.style.display = 'none';
         saveButton.style.display = 'inline-block';
      }
   });
</script>
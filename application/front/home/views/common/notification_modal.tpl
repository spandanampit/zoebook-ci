<style>
    .modal-body {
    max-height: 400px; 
    overflow-y: auto;
}
</style>

<div class="modal fade notification-popup" id="notificationNewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 54%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel"><%$notification%></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="updateNotificationCount()">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <div class="notification-inactive">
                        <ul>
                              <%if count($notifications) > 0%>
                                    <%foreach item=row from=$notifications%>
                                          <%assign var=follow_request_id value=$row['pending_request_id']%>
                                    
                                          <%if $row['is_read'] eq 'Yes'%>
                                                <li>
                                                      <div class="notification-box">
                                                            <div class="notification-user">
                                                                  <div class="notification-user-img">
                                                                  <img id="profileImage<%$row['notification_id']%>" src="<%$row['user_profile_image']%>" alt="">
                                                                  <input type="hidden" id="base64Image<%$row['notification_id']%>" value="<%$row['user_profile_image']%>">
                                                                  </div>
                                                                  <%if $row['un_type'] eq 'Post'%>
                                                                  <a href="<%$this->general->setdiplayposturl($row['post_id'],$row['un_notification_text'])%>" style="color: black">
                                                                        <div class="notification-user-content">
                                                                              <h6><%$row['un_notification_text']%></h6>
                                                                              
                                                                              <span><%$row['un_added_date']%></span>
                                                                        </div>
                                                                  </a>
                                                                  <%else%>
                                                                  <div class="notification-user-content">
                                                                        <h6><%$row['un_notification_text']%></h6>
                                                                        <span><%$row['un_added_date']%></span>
                                                                  </div>
                                                                  <%/if%>
                                                            </div>
                                                            
                                                            <%if $row['code'] eq 'FR' || $row['code'] eq 'MR'%>
                                                                  <div class="notification-hour" id="follower-buttons-<%$follow_request_id%>">
                                                                  <%if $row['uf_status'] eq 'Pending' || $row['uf_status'] eq ''%>
                                                                        <%if $row['un_type'] eq 'MovementFollower'%>
                                                                        <a href="<%$this->url->make('movement/movement/movementjoin')%>?movement_id=<%$row['un_movement_id']%>"><button class="btn btn-success">Accept</button></a>
                                                                        <button class="btn btn-danger" style="margin-left: 10px;" onclick="followerAction(<%$follow_request_id%>, 'Rejected')">Reject</button>
                                                                  <%else%>
                                                                        <button class="btn btn-success" onclick="followerAction(<%$follow_request_id%>, 'Accepted')">Accept</button>
                                                                        <button class="btn btn-danger" style="margin-left: 10px;" onclick="followerAction(<%$follow_request_id%>, 'Rejected')">Reject</button>
                                                                  <%/if%>

                                                                  <%elseif $row['uf_status'] eq 'Accepted'%>
                                                                        <button class="btn btn-success" style="margin-left: 10px;"><%$accepted%></button>
                                                                  <%else%>
                                                                        <button class="btn btn-danger" style="margin-left: 10px;"><%$rejected%></button>
                                                                  <%/if%>
                                                                  </div>
                                                            <%/if%>
                                                      </div>
                                                </li>
                                          
                                          <%/if%>

                                    <%/foreach%>
                              <%else%>
                                    <li>No notifications available</li>
                              <%/if%>
                        </ul>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Block User-->
<div class="modal fade" id="blockUserNewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="blockUserNewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 36%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blockUserNewModalLabel"><%$block_user_list%></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="notification-inactive">
                    <ul>
                        <%if !empty($blockuser)%>
                        <%foreach item=row from=$blockuser%>
                        <li>
                            <div class="notification-box">
                                <div class="notification-user">
                                    <div class="notification-user-img">
                                        <img src="<%$row['u_profile_image']%>" alt="">
                                    </div>
                                    
                                        <div class="notification-user-content">
                                            <h6><%$row['u_name']%></h6>
                                            <span><%$row['u_email']%></span>
                                        </div>
                                </div>
                                
                                <div class="notification-hour">
                                    <%if $row['bc_eStatus'] eq 'block'%>
                                        <button class="btn btn-success">Unblock</button>
                                    <%else%>
                                        <button class="btn btn-danger" style="margin-left: 10px;">Block</button>
                                    <%/if%>
                                </div>  
                            </div>
                        </li>
                        <%/foreach%>
                        <%else%>
                        <li>
                            <div class="notification-box">
                                <div class="notification-user">
                                    
                                    <div class="notification-user-content">
                                        <span>No Result Found</span>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <%/if%>
                    </ul>
                </div>
                <!--<div class="notification-active">
                    <ul>
                        <li>
                            <div class="notification-box">
                                <div class="notification-user">
                                    <div class="notification-user-img">
                                        <img src="images/notify.png" alt="">
                                    </div>
                                    <div class="notification-user-content">
                                        <h4>George Jack</h4>
                                        <span>Commented on your photo</span>
                                    </div>
                                </div>
                                <div class="notification-hour">
                                    <p>26 min ago</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>-->
            </div>
        </div>
    </div>
</div>


<script>
function updateNotificationCount() {
      let countPlace = document.querySelectorAll('.badge');
      countPlace.forEach(function(span) {
            span.textContent = 0;
      });
      
      
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    function getParameterByName(name, url) {
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
        const results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    function setProfileImage(base64ImageId, profileImageId) {
        const inputElement = document.getElementById(base64ImageId);

        if (inputElement) {
            const dynamicUrl = inputElement.value;
            if (dynamicUrl) {
                const encodedString = getParameterByName('pic', dynamicUrl);
                if (encodedString) {
                    const decodedUrl = atob(encodedString);
                    const profileImage = document.getElementById(profileImageId);
                    if (profileImage) {
                        profileImage.src = decodedUrl;
                    } else {
                        console.error(`Profile image element not found: ${profileImageId}`);
                    }
                } else {
                    console.error(`No encoded string found in the URL for ${base64ImageId}`);
                }
            } else {
                console.error(`No dynamic URL found for ${base64ImageId}`);
            }
        } else {
            console.error(`Input element not found: ${base64ImageId}`);
        }
    }

    const base64Elements = document.querySelectorAll("[id^='base64Image']");
    base64Elements.forEach(element => {
        const postId = element.id.replace('base64Image', '');
        setProfileImage(`base64Image${postId}`, `profileImage${postId}`);
    });
});
</script>


<script>
    function followerAction(follow_request_id, status){
    console.log('follow_request_id: ' + follow_request_id);
    console.log('status: ' + status);
    
    var url = "<%$this->url->make('home/home/followUser')%>";

    $.ajax({
        url: url,
        type: "POST",
        data: { 
            follow_request_id: follow_request_id,
            status: status,
        },
        dataType: "json", 
        success: function(response) {
            console.log("Parsed response:", response);
            var buttonContainer = $('#follower-buttons-' + follow_request_id);

            if (response.success) {
                if (response.set_btn === 'Accepted') {
                    buttonContainer.html('<button class="btn btn-success" style="margin-left: 10px;">Accepted</button>');
                } else if (response.set_btn === 'Rejected') {
                    buttonContainer.html('<button class="btn btn-danger" style="margin-left: 10px;">Rejected</button>');
                } else {
                    buttonContainer.html(
                        '<button class="btn btn-success" onclick="followerAction(' + follow_request_id + ', \'Accepted\')">Accept</button>' +
                        '<button class="btn btn-danger" style="margin-left: 10px;" onclick="followerAction(' + follow_request_id + ', \'Rejected\')">Reject</button>'
                    );
                }
            } else {
                console.error("Error processing follow request:", response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("AJAX error:", textStatus, errorThrown);
            console.log("Full jqXHR object:", jqXHR);
            console.log("Response text:", jqXHR.responseText);
        }
    });
}

</script>


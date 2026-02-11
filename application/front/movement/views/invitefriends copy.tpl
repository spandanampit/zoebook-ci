
    <style>
    .selected {
      color: green !important;
      font-weight: bold !important;
    }
    </style>
    <!-- dashboard section start -->
    <section class="dashboard-sec movement-sec" style="min-height: 47rem;">
      <div class="container customContainer">
        <div class="row">
          <div class="col-xl-3 col-md-12">
            <%include file="common/navbar.tpl"%>  
          </div>
          <div class="col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="main">
              <div class="ui-block">
                <div class="ui-block-widget">
                  <div class="ui-block-title">
                    <h3><%$invite_friends%></h3>
                    <p><%$search_and_add_friends%></p>
                  </div>
                  <div class="ui-block-notification">
                    <ul>
                    <li><a href="#" id="selected-count"><%$friends_selected%></a></li>
                      <li><a href="#" id="select-all"><%$select_all%></a></li>
                      <li><a href="#" class="invite-all"><%$invite%></a></li>
                    </ul>
                  </div>
                </div> 
                <div class="ui-block-search">
                  <form id="emailForm">
                    <div class="form-group">
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <input type="hidden" id="movementid" value="<%$movementId%>">
                    <button type="submit" class="header-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </form>
                </div>  
                <hr>
                <div class="ui-result-box">
                  <div class="ui-search-heading">
                    <p><%$search_results%></p>
                  </div>
                  <div class="ui-notification-list">
                    <ul>
                      <%foreach item=row from=$friends%>
                      <li>
                        <div class="ui-notification-box">
                          <div class="ui-author-thumb">
                            <img src="<%$row['u_profile_image']%>" alt="">
                          </div>
                          <div class="ui-notification-event">
                            <!-- Add data-id attribute to track the user -->
                            <!--<%$row|print_r%>-->
                            <a href="#" class="notification-friend" data-id="<%$row['u_users_id']%>"><%$row['u_name']%></a>
                            <span class="notification-follower"><%$row['follower_count']%> followers</span>
                          </div>
                        </div>                        
                        <span class="ui-notification-icon">
                          <%if $row['movement_join_status'] eq 1%>
                          <a href="javascript:;">Already joined</a>
                          <%else%>
                          <a href="javascript:;" onclick="sendFriendRequest(<%$row['u_users_id']%>)"><i class="fa-solid fa-user-plus"></i> <%$add_friend%></a>
                          <%/if%>
                        </span>
                      </li>
                      <%/foreach%>
                    </ul>
                  </div>
                </div>             
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- dashboard section end -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      function sendFriendRequest(friendId) {
            console.log('friendId', friendId);
            $.ajax({
                  url: '/followRequest',
                  method: 'POST',
                  data: { following_user_id: friendId },
                  success: function (response) {
                        if (response.success) {
                              console.log("GIF URL submitted successfully:", response);
                        } else {
                              console.error("Error submitting GIF:", response);
                        }
                  },
                  error: function (jqXHR, textStatus, errorThrown) {
                        console.error("AJAX error:", textStatus, errorThrown);
                  }

            })
      }
    </script>
    <script>
    $(document).ready(function() {
    let selectedUserIds = [];

    $('#emailForm').on('submit', function(event) {
      event.preventDefault();

      var keyword = $('#exampleInputEmail1').val();
      var movementid = $('#movementid').val();

      $.ajax({
        url: '<%$this->url->make("movement/movement/searchmovement")%>',
        method: 'POST',
        data: { 
          keyword: keyword,
          movementId: movementid,
        },
        success: function(response) {
          if (typeof response === 'string') {
              response = JSON.parse(response);
          }

          var friends = response.search_result;
          $('.ui-notification-list ul').empty(); 

          friends.forEach(function(row) {
            var isMovementJoin = row.movement_join_status == 1 ? 'Already joined' : '<i class="fa-solid fa-user-plus"></i> Add friend';

            var listItem = `
              <li>
                <div class="ui-notification-box">
                  <div class="ui-author-thumb">
                    <img src="${row.u_profile_image}" alt="">
                  </div>
                  <div class="ui-notification-event">
                    <a href="#" class="notification-friend" data-id="${row.u_users_id}">${row.u_name}</a>
                    <span class="notification-follower">${row.follower_count} <%$followers%></span>
                  </div>
                </div>
                <span class="ui-notification-icon">
            `;

            // If not already joined, make the link clickable
            if (isMovementJoin !== 'Already joined') {
              var actionUrl = `<%$this->url->make('movement/movement/invitemovement')%>?movementId=${movementid}&inviteId=${row.u_users_id}`;
              listItem += `<a href="${actionUrl}">${isMovementJoin}</a>`;
            } else {
              listItem += `<a href="#">${isMovementJoin}</a>`;
            }

            listItem += `
                </span>
              </li>
            `;
            
            $('.ui-notification-list ul').append(listItem);
          });

          // Add click event listener to the newly added search result items
          $('.notification-friend').on('click', function(event) {
            event.preventDefault();
            const userId = $(this).data('id');
            const parentLi = $(this).closest('li');
            const notificationBox = parentLi.find('.ui-notification-box');

            // Check if the user is already selected
            if (!selectedUserIds.includes(userId)) {
              selectedUserIds.push(userId);
              parentLi.css('background', '#bee6be');
              parentLi.css('border-radius', '24px');
              notificationBox.css('padding', '8px');
            } else {
              selectedUserIds = selectedUserIds.filter(id => id !== userId);
              parentLi.css('background', '');
              parentLi.css('border-radius', '');
              notificationBox.css('padding', '');
            }

            console.log('Selected User IDs:', selectedUserIds);
          });
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    });
  });



  $(document).ready(function() {
  let selectedUserIds = []; // Use a single array for selected user IDs

  $('#select-all').on('click', function(e) {
    e.preventDefault();
    selectedUserIds = []; // Reset the selected IDs

    $('.notification-friend').each(function() {
      var userId = $(this).data('id');
      selectedUserIds.push(userId); // Populate the selectedUserIds array
      
      var parentLi = $(this).closest('li');
      var notificationBox = $(this).closest('.ui-notification-box');

      parentLi.css({
        'background': '#bee6be',
        'border-radius': '24px'
      });
      notificationBox.css('padding', '8px');
      $(this).addClass('selected');  
    });

    console.log(selectedUserIds);
    console.log('Count: ' + selectedUserIds.length);
    $('#selected-count').text(selectedUserIds.length + ' <%$friends_selected%>');
  });

  // Attach invite click event using jQuery only
  $('.invite-all').on('click', function(e) {
    e.preventDefault();
    
    inviteFriends(selectedUserIds, 'select_all'); // Call inviteFriends with the selected IDs
  });

  // For each individual user selection
  const userNameElements = document.querySelectorAll('.notification-friend');

  userNameElements.forEach(user => {
    user.addEventListener('click', function(event) {
      event.preventDefault();

      const userId = this.getAttribute('data-id');
      const parentLi = this.closest('li');  
      const notificationBox = parentLi.querySelector('.ui-notification-box');  

      const userIndex = selectedUserIds.indexOf(userId);
      if (userIndex === -1) {
        selectedUserIds.push(userId); // Add userId to the selected array
        parentLi.style.background = '#bee6be';  
        parentLi.style.borderRadius = '24px';   
        notificationBox.style.padding = '8px';  
        this.classList.add('selected');         
      } else {
        selectedUserIds.splice(userIndex, 1); // Remove userId from the selected array
        parentLi.style.background = '';         
        parentLi.style.borderRadius = '';       
        notificationBox.style.padding = '';     
        this.classList.remove('selected');      
      }

      // Update the selected friend count
      document.getElementById('selected-count').textContent = selectedUserIds.length + ' <%$friends_selected%>';

      console.log('Selected User IDs:', selectedUserIds);
    });
  });
});

// Example invite function
function inviteFriends(userIds, selectionType) {
  if (userIds.length === 0) {
    alert('No friends selected to invite.');
    return;
  }
  
  let movementid = document.getElementById('movementid').value;
  let url = '<%$this->url->make("movement/movement/invitemovement")%>';
  console.log('Inviting friends with User IDs:', userIds);
  console.log('Movement Id:', movementid);

  // Implement your AJAX submit logic here, which will run once
  $.ajax({
    url: url,
    type: 'POST',
    data: { userIds: userIds, movementId: movementid },
    success: function(response) {
      console.log('Success:', response);

      var parsedResponse = typeof response === 'string' ? JSON.parse(response) : response;
      console.log('Parsed Response:', parsedResponse.success);
        var successMessage = document.createElement('div');
        successMessage.textContent = parsedResponse.message;
        successMessage.style.position = 'fixed';
        successMessage.style.top = '20px';
        successMessage.style.left = '50%';
        successMessage.style.transform = 'translateX(-50%)';
      if (parsedResponse.success == 1) {
        successMessage.style.backgroundColor = '#dff0d8';
        successMessage.style.color = '#3c763d';
      } else {
        successMessage.style.color = '#ffffff';
        successMessage.style.backgroundColor = '#FF5050';
      }
        successMessage.style.padding = '10px';
        successMessage.style.border = '1px solid #3c763d';
        successMessage.style.borderRadius = '5px';
        successMessage.style.zIndex = '9999';
        successMessage.style.fontSize = '16px';

        document.body.appendChild(successMessage);

        setTimeout(function() {
          document.body.removeChild(successMessage);
        }, 5000);
    },
    error: function(error) {
      console.log('Error:', error);
    }
});

}


</script>

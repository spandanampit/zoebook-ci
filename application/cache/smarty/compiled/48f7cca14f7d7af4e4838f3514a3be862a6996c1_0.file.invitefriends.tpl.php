<?php
/* Smarty version 3.1.28, created on 2024-09-30 05:19:46
  from "/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/invitefriends.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28',
  'unifunc' => 'content_66fa976208f7c1_40811648',
  'file_dependency' => 
  array (
    '48f7cca14f7d7af4e4838f3514a3be862a6996c1' => 
    array (
      0 => '/var/www/zoebook.mydevfactory.com/public_html/provatext/zoebook/application/front/movement/views/invitefriends.tpl',
      1 => 1727698753,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:common/navbar.tpl' => 1,
  ),
),false)) {
function content_66fa976208f7c1_40811648 ($_smarty_tpl) {
?>

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
            <?php $_smarty_tpl->smarty->ext->_subtemplate->render($_smarty_tpl, "file:common/navbar.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
  
          </div>
          <div class="col-xl-9 order-xl-2 col-lg-9 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
            <div class="main">
              <div class="ui-block">
                <div class="ui-block-widget">
                  <div class="ui-block-title">
                    <h3>Invite friends</h3>
                    <p>Search and add friends</p>
                  </div>
                  <div class="ui-block-notification">
                    <ul>
                    <li><a href="#" id="selected-count">Friends Selected</a></li>
                      <li><a href="#" id="select-all">Select All</a></li>
                      <li><a href="#" class="invite-all">Invite</a></li>
                    </ul>
                  </div>
                </div> 
                <div class="ui-block-search">
                  <form id="emailForm">
                    <div class="form-group">
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <input type="hidden" id="movementid" value="<?php echo $_smarty_tpl->tpl_vars['movementId']->value;?>
">
                    <button type="submit" class="header-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                  </form>
                </div>  
                <hr>
                <div class="ui-result-box">
                  <div class="ui-search-heading">
                    <p>Search results</p>
                  </div>
                  <div class="ui-notification-list">
                    <ul>
                      <?php
$_from = $_smarty_tpl->tpl_vars['friends']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_row_0_saved_item = isset($_smarty_tpl->tpl_vars['row']) ? $_smarty_tpl->tpl_vars['row'] : false;
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable();
$__foreach_row_0_total = $_smarty_tpl->smarty->ext->_foreach->count($_from);
if ($__foreach_row_0_total) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$__foreach_row_0_saved_local_item = $_smarty_tpl->tpl_vars['row'];
?>
                      <li>
                        <div class="ui-notification-box">
                          <div class="ui-author-thumb">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_profile_image'];?>
" alt="">
                          </div>
                          <div class="ui-notification-event">
                            <!-- Add data-id attribute to track the user -->
                            <!--<?php echo print_r($_smarty_tpl->tpl_vars['row']->value);?>
-->
                            <a href="#" class="notification-friend" data-id="<?php echo $_smarty_tpl->tpl_vars['row']->value['u_users_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['u_name'];?>
</a>
                            <span class="notification-follower"><?php echo $_smarty_tpl->tpl_vars['row']->value['follower_count'];?>
 followers</span>
                          </div>
                        </div>                        
                        <span class="ui-notification-icon">
                          <?php if ($_smarty_tpl->tpl_vars['row']->value['movement_join_status'] == 1) {?>
                          <a href="#">Already joined</a>
                          <?php } else { ?>
                          <a href="#"><i class="fa-solid fa-user-plus"></i> Add friend</a>
                          <?php }?>
                        </span>
                      </li>
                      <?php
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_local_item;
}
}
if ($__foreach_row_0_saved_item) {
$_smarty_tpl->tpl_vars['row'] = $__foreach_row_0_saved_item;
}
?>
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

    <?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.6.0.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
    $(document).ready(function() {
    let selectedUserIds = [];

    $('#emailForm').on('submit', function(event) {
      event.preventDefault();

      var keyword = $('#exampleInputEmail1').val();
      var movementid = $('#movementid').val();

      $.ajax({
        url: '<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make("movement/movement/searchmovement");?>
',
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
                    <span class="notification-follower">${row.follower_count} followers</span>
                  </div>
                </div>
                <span class="ui-notification-icon">
            `;

            // If not already joined, make the link clickable
            if (isMovementJoin !== 'Already joined') {
              var actionUrl = `<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make('movement/movement/invitemovement');?>
?movementId=${movementid}&inviteId=${row.u_users_id}`;
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
    $('#selected-count').text(selectedUserIds.length + ' friends selected');
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
      document.getElementById('selected-count').textContent = selectedUserIds.length + ' friends selected';

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
  let url = '<?php echo $_smarty_tpl->tpl_vars['this']->value->url->make("movement/movement/invitemovement");?>
';
  console.log('Inviting friends with User IDs:', userIds);
  console.log('Movement Id:', movementid);

  // Implement your AJAX submit logic here, which will run once
  $.ajax({
    url: url,
    type: 'POST',
    data: { userIds: userIds, movementId: movementid },
    success: function(response) {
      console.log('Success:', response);
      // console.log(response.success);

      var parsedResponse = typeof response === 'string' ? JSON.parse(response) : response;
      console.log('Parsed Response:', parsedResponse.success);
        var successMessage = document.createElement('div'); // Changed '-' to 'div'
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


<?php echo '</script'; ?>
>
<?php }
}

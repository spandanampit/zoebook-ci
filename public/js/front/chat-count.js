var token = $('#firebase_token').val();
//console.log("token",token);
if(window.location.hostname!='localhost' && window.location.hostname!='zoebook.projectspreview.net'){
  var rootNode = "/";
}else{
  var rootNode = "/test";
}
if(token){
  firebase.auth().signInWithCustomToken(token).catch(function(error) {
    var errorCode = error.code;
    var errorMessage = error.message;
    // window.location.href = site_url+'logout.html';
    $.ajax({
          url: "firebaseTokenGeneration",
          success:function (out){
              $("#firebase_token").val(out);
              token = out;
              // window.location.reload();
          }
      });
  }).then(function(data){
    console.log(data);
    if (data.user.uid && data.user.uid != "") {
        firebase.database().ref().child(rootNode+'/users/'+data.user.uid+'/activeChatRoom/').set('');
        getUnreadTotalCount(data.user.uid);
        realTime(data.user.uid);
        return true;
    }else{
      // console.log('Something went wrong');
      // window.location.href = site_url+'logout.html';
    }
  });
}

function realTime(logged_in_user_id){
  var contacts_ref = firebase.database().ref(rootNode+'/contacts_new/'+logged_in_user_id+'/');
  contacts_ref.on('child_added', function(data) {
    getUnreadTotalCount(logged_in_user_id);
  });
}
function getUnreadTotalCount(logged_in_user_id) {
  var contacts_new_ref = firebase.database().ref(rootNode+'/contacts_new/'+logged_in_user_id+'/');
    contacts_new_ref.once('value').then(function(querySnapshot) {
      if(querySnapshot.numChildren() > 0){
      var unreadTotal = 0;
        querySnapshot.forEach(function(doc){
          var friend_data = doc.val();
          // console.log(friend_data,'getUnreadTotalCount');
              var unreadCountRef = firebase.database().ref(rootNode+'contacts_new/'+logged_in_user_id+'/'+doc.key+'/unReadMessageCount/');
              // unreadCountRef.on('value',function(snapshot) {
              unreadCountRef.on('value',function(snapshot) {
                
                if(snapshot.val() > 0){
                  //console.log('Message Count',snapshot.val());
                  unreadTotal = unreadTotal+snapshot.val();

                }
                if(unreadTotal > 0){
                  //console.log('Message Count',unreadTotal);
                  $('.show-chat-count').html('<span class="badge">'+unreadTotal+'</span>');
                }
              });
              if(doc.val().unReadMessageCount > 0){
                // console.log('Message Count',doc.val().unReadMessageCount);
                unreadTotal = unreadTotal+doc.val().unReadMessageCount;
                var badgeHtml ='<span class="badge badge-system badge-pill">'+snapshot.val() +'</span>';
                $("div[uuid='" + doc.val().BasicDetails.chatRoom +"']").find('div.badge-div').html(badgeHtml);
              }
              if(unreadTotal > 0){
                //console.log('Message Count',unreadTotal);
                $('.show-chat-count').html('<span class="badge badge-system badge-pill">'+unreadTotal+'</span>');
              }
        });
      }
    });
}




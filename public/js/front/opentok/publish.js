// (optional) add server code here
initializeSession();

// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

function initializeSession() {

  $(".live-screen").css("width","75%");
  
  session = OT.initSession(apiKey, sessionId);
  console.log(session,'opentok');
  // Create a publisher
  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);
  // Connect to the session
  session.connect(live_token, function(error) {
    // If the connection is successful, publish to the session
    if (error) {
        console.log(error);
        console.log("Failed to connect: ", error.message);
        if (error.name === "OT_NOT_CONNECTED") {
          Project.setMessage("You are not connected to the internet. Check your network connection.");
        }else{
            handleError(error);
        }
        console.log(error,'opentok connect error');
    } else {
      session.publish(publisher, handleError);
      console.log(publisher,'opentok publisher');
    }
  });


  publisher.on('streamCreated', function (event) {
    console.log('The publisher started streaming.');
    session.signal(
    {
      data:"Your Video Stream Started"
    },
    function(error) {
      if (error) {
        console.log("signal error ("
                     + error.name
                     + "): " + error.message);
      }
    });

    var params = {};
    params['tokbox_session_id'] = tokbox_session_id;

    $.ajax({
      type: "post",
      beforeSend:function(xhr){
        console.log("Start Archive ajax in publish.js");
      },
      url: site_url + "golive/golive/start_archive",
      data: params,
      dataType: 'json',
      success: function (response) {
        console.log('Start Archive',response);
      }
    });

  });
  session.on('archiveStarted', function(event) {
      archiveID = event.id;
      console.log('ARCHIVE STARTED');
      
    });

  session.on('archiveStopped', function(event) {
    archiveID = null;
    console.log('ARCHIVE STOPPED');
  });
  
  session.on("signal", function(event) {
    console.log(event);
    var from_arr = event.from.data.split('@@');
    var className = event.from.connectionId === session.connection.connectionId ? 'mine' : 'theirs';
    if(event.type=="signal" || event.type=="signal:1"){
      if(isJson(event.data)){
        var message_text_arr = JSON.parse(event.data);
        event.data = message_text_arr.message;
      }
      var newMessage = '<li class="'+className+'"><div class="cmn-user">'+
                              '<i class="cmn-user-img">'+
                                 '<img src="'+from_arr[2]+'" alt="">'+
                              '</i>'+
                              '<div class="cmn-user-name">'+
                                  '<h6><a href="jaavascript:;">'+from_arr[1]+'</a></h6>'+
                              '</div>'+
                          '</div>'+
                          '<p>'+event.data+'</p></li>';
    }else if(event.type=="signal:joined"){
      var newMessage = '<li class="'+className+'">'+
                           '<p><i>'+(className == 'mine' ? 'You' : from_arr[1])+' '+event.data+'</i></p></li>';
    }else if(event.type=="signal:left"){
      var newMessage = '<li class="'+className+'">'+
                          '<p><i>'+event.data+'</i></p></li>';
    }
    $('.stream-msg-history').append(newMessage);
    $(".stream-msg-history").scrollTop($(".stream-msg-history")[0].scrollHeight);
  });
  var publishers_count = 0,subscribers_count = 0;
  session.on("connectionCreated", function(evt) {
   // Check if connection is from a publisher or subscriber
    if (evt.connection.permissions.publish) {
        publishers_count++;
    } else {
        subscribers_count++;
    }
    $('.impression').html('<i class="far fa-eye"></i> '+(publishers_count-1)+' Impression’s');
  });
  session.on("connectionDestroyed", function(evt) {
   // Check if connection is from a publisher or subscriber
    if (evt.connection.permissions.publish) {
       console.log('Publisher disconnected');
        publishers_count--;
    } else {
      console.log('Subscriber disconnected');
        subscribers_count--;
    }
    console.log(evt);
    var event_user_arr = evt.connection.data.split('@@');
    session.signal(
      {
        data:event_user_arr[1]+" Left Live Stream",
        type:"left"
      },
      function(error) {
        if (error) {
          console.log("signal error ("
                       + error.name
                       + "): " + error.message);
        }
      });
    $('.impression').html('<i class="far fa-eye"></i> '+(publishers_count-1)+' Impression’s');
  });

}

function onTextChange() {
  var key = window.event.keyCode;
  if (key === 13) {
      var message_text_arr = {};
      message_text_arr.name = profile_name;
      message_text_arr.image = profile_image;
      message_text_arr.message = $(".stream-message-input").val();
      console.log(message_text_arr);
      console.log(JSON.stringify(message_text_arr));
    session.signal({
        data: JSON.stringify(message_text_arr),
        type:"1"
      }, function(error) {
      if (error) {
        console.log('Error sending signal:', error.name, error.message);
      } else {
        $(".stream-message-input").val('');
      }
    });
  }
  else {
    return true;
  }
}

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}



var newDate = new Date();
var newStamp = newDate.getTime();
var timer;
function updateClock() {
    newDate = new Date();
    newStamp = newDate.getTime();
    var diff = Math.round((newStamp-startStamp)/1000);

    var d = Math.floor(diff/(24*60*60));
    diff = diff-(d*24*60*60);
    var h = Math.floor(diff/(60*60));
    diff = diff-(h*60*60);
    var m = Math.floor(diff/(60));
    diff = diff-(m*60);
    var s = diff;
    document.getElementById("down_timer").innerHTML = ( h < 10 ? "0"+h : h)+":"+( m < 10 ? "0"+m : m)+":"+( s < 10 ? "0"+s : s);
}
timer = setInterval(updateClock, 1000);

$('.finish-stream').on('click',function(){
  swal({
    title: "Are you sure?",
    text: "You want to end Live Stream ?",
    icon: "warning",
    buttons: ["Continue Live", "End"],
    dangerMode: true,
  })
  .then((done) => {
    if (done) {
      swal({
        title: "Share Live",
        text: "Do you wish to share the stream video on your timeline ?",
        icon: "info",
        buttons: {
          cancel: {
            text: "No",
            visible: true,
            closeModal: false,
          },
          confirm: {
            text: "Share",
            visible: true,
            closeModal: false
          }
        },
        dangerMode: false,
      })
      .then((share) => {
          var params = {};
          params['session_id'] = sessionId;
          params['tokbox_session_id'] = tokbox_session_id;
          if (share) {
            params['is_share'] = "Yes";
          } else {
            params['is_share'] = "No";
          }
          $.ajax({
            type: "post",
            url: site_url + "golive/golive/end_stream",
            data: params,
            dataType: 'json',
            success: function (response) {
              console.log(response);
                swal("Thanks!",response['settings']['message'], "success").then((value) => {
                  window.location.href = site_url;
                });
            }
          });
      });
    } else {
      return false;
    }
  });
});

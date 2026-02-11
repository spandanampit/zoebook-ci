initializeSession();

// Handling all of our errors here by alerting them
function handleError(error) {
  if (error) {
    alert(error.message);
  }
}

function initializeSession() {
    session = OT.initSession(apiKey, sessionId);
    // Subscribe to a newly created stream
    session.connect(token, function (error) {
      if (error) {
        console.log("Failed to connect: ", error.message);
        if (error.name === "OT_NOT_CONNECTED") {
          Project.setMessage("You are not connected to the internet. Check your network connection.");
        }
      } else {
        console.log("Connected");
      }
    });
    session.on('streamCreated', function(event) {
      var subscriberProperties = {insertMode: 'append',width: '100%',
      height: '100%'};
      var subscriber = session.subscribe(event.stream,
        'subscriber',
        subscriberProperties,
        function (error) {
          if (error) {
            console.log(error);
          } else {
            console.log('Subscriber added.');
            session.signal(
            {
              data:"Joined Live Streaming",
              type:"joined"
            },
            function(error) {
              if (error) {
                console.log("signal error ("
                             + error.name
                             + "): " + error.message);
              }
            });

          }
      });
    });
    session.on("streamDestroyed", function(event) {
      swal("Thanks for watching!","Live Stream " + event.stream.name + " was ended.", "success").then((value) => {
         window.location.href = site_url;
      });
    }).connect(token);
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
      /*
      session.signal(
      {
        data:"Left Live Stream",
        type:"left"
      },
      function(error) {
        if (error) {
          console.log("signal error ("
                       + error.name
                       + "): " + error.message);
        }
      });
      */
      $('.impression').html('<i class="far fa-eye"></i> '+(publishers_count-1)+' Impression’s');
    });
    session.on('archiveStarted', function(event) {
      archiveID = event.id;
      console.log('ARCHIVE STARTED');
      
    });

    session.on('archiveStopped', function(event) {
      archiveID = null;
      console.log('ARCHIVE STOPPED');
    });

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
                          '<p></i>'+(className == 'mine' ? 'You' : from_arr[1])+' '+event.data+'</i></p></li>';
    }else if(event.type=="signal:left"){
      var newMessage = '<li class="'+className+'">'+
                          '<p><i>'+event.data+'</i></p></li>';
    }
      $('.stream-msg-history').append(newMessage);
      $(".stream-msg-history").scrollTop($(".stream-msg-history")[0].scrollHeight);
    });
}

function onTextChange() {
  var key = window.event.keyCode;
  if (key === 13) {
      var message_text_arr = {};
      message_text_arr.name = profile_name;
      message_text_arr.image = profile_image;
      message_text_arr.message = $(".stream-message-input").val();
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

$('.leave-stream').on('click',function(){
  swal({
    title: "Are you sure?",
    text: "You want to Leave Live Stream ?",
    icon: "warning",
    buttons: ["No", "Leave"],
    dangerMode: true,
  })
  .then((done) => {
    if (done) {
      swal("Thanks!","For Watching Live Stream", "success").then((value) => {
        window.location.href = site_url;
      });

    } else {
      return false;
    }
  });
});

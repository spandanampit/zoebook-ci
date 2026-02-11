var video = document.querySelector('video');
var canvas = document.querySelector('canvas');
var context = canvas.getContext('2d');
var myWidth, myHeight, ratio;
if (typeof navigator.getUserMedia === 'function') {
    navigator.getUserMedia({ audio: false, video: { width: 1280, height: 720 } },
        function(stream) {
          var video = document.querySelector('video');
          video.srcObject=stream;
          video.onloadedmetadata = function(e) {
          video.play();
        };
      },
      function(err) {
        console.log("The following error occured: " + err.name);
      }
    );
}else{
  navigator.mediaDevices.getUserMedia({ audio: false, video: { width: 1280, height: 720 } },
      function(stream) {
        var video = document.querySelector('video');
        video.srcObject=stream;
        video.onloadedmetadata = function(e) {
        video.play();
      };
    },
    function(err) {
      console.log("The following error occured: " + err.name);
    }
  );
}
video.addEventListener('loadedmetadata', function() {
    ratio = video.videoWidth/video.videoHeight;
    myWidth = video.videoWidth-100;
    myHeight = parseInt(myWidth/ratio,10);
    canvas.width = myWidth;
    canvas.height = myHeight;
},false);
$( document ).ready(function() {
    $(document).on("click", "#btn_golive_start", function () {
        var text = $("#post_text").val();
        console.log(text,'clicked');
        if($.trim(text) == ""){
            $("#post_text").css('border', '1px solid red'); 
            return false;
        }else{
            $("#post_text").css('border', 'none'); 
        }
        context.fillRect(0,0,myWidth,myHeight);
        context.drawImage(video,0,0,myWidth,myHeight);
        //$("#canvas").show();
        var photo = canvas.toDataURL('image/jpeg');                
        $("#preview_thumb").val(photo);
        
        $("#frm_golive_start").submit();
    });
});



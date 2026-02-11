Project.modules.savefollowuser = (function () {
    var objReturn = {};
    
    function init() {
        Common.initValidator(); 

        $('.followuser_act').bind('click', function () {

            var getid = $(this).attr('id');

            if(getid == 'unfollowrequest') {
                $('#unfollowrequest').css('opacity','0.4');
                $('#followerrornote').html('&nbsp;<img src="public/images/front/loading.gif">');

                $.ajax( {
                  url: site_url + "home/unfollowuser_action",
                  method:"POST",
                  data: {
                    userid : $('#getuser_id').val(),
                    followid : $('#userfollow_id').val()
                  },
                  success: function(data) {
                    var parsed = data;
                    $('#unfollowrequest').css('opacity','1');
                    if(parsed.success == 1) {
                        var totfollower = parseInt($('#totfollowercount').val());
                        var getcount = totfollower-1;
                        $('#showfollowercount').html(getcount);

                        $('#unfollowrequest').html('Follow');
                        $('#unfollowrequest').attr('class','btn btn-primary followuser_act');
                        $('#unfollowrequest').attr('id','savefollowuser');
                    }
                    $('#followerrornote').html("<span style='color:"+parsed.notecolor+"'>"+parsed.dispmsg+"</span>");

                    location.reload();
                  }
                });
            } else {
                $('#'+getid).css('opacity','0.4');

                var setbtn = $('#actbtn').val();
                if(getid == 'acceptrequestid') {
                    setbtn = 'Accepted';
                    $('#rejectrequestid').css('opacity','0.4');
                } else if(getid == 'rejectrequestid') {
                    setbtn = 'Rejected';
                    $('#acceptrequestid').css('opacity','0.4');
                } 

                $('#followerrornote').html('&nbsp;<img src="public/images/front/loading.gif">');

                $.ajax( {
                  url: site_url + "home/followuser_action",
                  method:"POST",
                  data: {
                    userid : $('#getuser_id').val(),
                    followid : $('#userfollow_id').val(),
                    pendingrequestid : $('#pending_request_id').val(),
                    pendingrequestid_ar : $('#pending_request_id_1').val(),
                    btnactval : setbtn
                  },
                  success: function(data) {
                    console.log('followuser');
                    console.log('Follow Response:', data);
                    console.log('success');
                    // var parsed = JSON.parse(data);
                    var parsed = data;

                    if(getid == 'acceptrequestid') {
                        btnclass = 'btn btn-secondary followuser_act';
                        btnactval = 'Accepted'
                    }else if (getid == 'rejectrequestid') {
                        btnclass = 'btn btn-secondary followuser_act';
                        btnactval = 'Rejected'
                    } else {
                        if(getid == 'savefollowuser') {
                            btnname = 'Cancel Request';
                            btnclass = 'btn btn-secondary followuser_act';
                            btnchangeid = 'cancelfollowrequest';
                            btnactval = 'Deleted'
                        } else {
                            btnname = 'Follow';
                            btnclass = 'btn btn-primary followuser_act';
                            btnchangeid = 'savefollowuser';
                            btnactval = 'follow';
                        }
                    }
                    $('#'+getid).css('opacity','1');

                    if(parsed.success == 1) {

                        if(getid == 'acceptrequestid') {
                            $('#acceptrejectblock').hide();

                            var totfollower = parseInt($('#totfollowingcount').val());
                            var getcount = totfollower+1;
                            $('#showfollowingcount').html(getcount);
                        } else {
                            $('#'+getid).html(btnname);
                            $('#'+getid).attr('class',btnclass);
                            $('#'+getid).attr('id',btnchangeid);
                            $('#actbtn').val(btnactval);
                            $('#pending_request_id').val(parsed.pendingrequestid);
                        }
                        
                    }
                    $('#followerrornote').html("<span style='color:"+parsed.notecolor+"'>"+parsed.dispmsg+"</span>");
                    location.reload();
                  }
                });
            }
            
            

        });

    }
    
    
    objReturn.init = init;
    return objReturn;
})();

$(function(){

        var videotype = $("#coverphoto_type").val();

        if(videotype == "Video") {
            var video = $('<video />', {
                id: 'imagePreviewCover',
                src: $('#coversrc').val(),
                type: 'video/mp4',
                controls: true
            });
            video.appendTo($('#displaycover'));
        } else {
            var img_1 = $('<img id="imagePreviewCover">'); //Equivalent: $(document.createElement('img'))
            $(img_1).attr('src', $('#coversrc').val());
            $(img_1).attr('class','profile-user-img');
            $('#displaycover').html($(img_1));
        }
        

        $('#loadingcover').hide();

        $('.avatar-preview').css({'top': parseInt($('#loadedtopcover').val())});
        $('#loaddraggable').css({'position': 'relative'});
        $('#loaddraggable').css('overflow', 'unset');
});
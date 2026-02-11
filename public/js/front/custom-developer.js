var notify_interval = null;
$(document).ready(function () {  

    $('video').attr('controlsList', 'nodownload');

    /*let playAfterThisHeight = 200
    $(document).scroll(function() {
        if ($(document).scrollTop()> playAfterThisHeight) {
              $('.playerembed').trigger('play');

        } else {
          $('.playerembed').trigger('pause');
        }
    })*/
    
    $(function () {
        $('.othervideoduration').each(function(i,e){
                $(e).on("loadedmetadata", function() {
                    var duration = this.duration;
                    duration = Number(duration);
                    var h = Math.floor(duration / 3600);
                    var m = Math.floor(duration % 3600 / 60);
                    var s = Math.floor(duration % 3600 % 60);

                    var d = '';

                    var hStr = '00' + h;
                    var mStr = '00' + m;
                    var sStr = '00' + s;

                    if(h > 0)
                        d = hStr.substring(hStr.length - 2) + ':' + mStr.substring(mStr.length - 2) + ':' + sStr.substring(sStr.length - 2);    
                    else
                        d = mStr.substring(mStr.length - 2) + ':' + sStr.substring(sStr.length - 2);    

                      $(e).parent().siblings().css('display','block').html(d);
                });
            });
        
      // Initializes and creates emoji set from sprite sheet
      window.emojiPicker = new EmojiPicker({
        emojiable_selector: '[data-emojiable=true]',
        assetsPath: site_url+'public/styles/libraries/emoji_picker/img',//'http://onesignal.github.io/emoji-picker/lib/img/',
        popupButtonClasses: 'fa fa-smile-o' });

      // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
      // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
      // It can be called as many times as necessary; previously converted input fields will not be converted again
      window.emojiPicker.discover();
    });

    
    $(document).on('click', '.reply-link', function () {
        $(this).parent().find('.reply-comment-box').slideToggle();
    });

    /* display liked user popup for post */
    $(document).on("click",".disp_postlikes", function () {
        $('#browseprofile').attr('data-postid',$(this).attr('data-postid'));
        $('#browseprofile').attr('data-mediaid',$(this).attr('data-mediaid'));
        $('#browseprofile').attr('data-pageindex',1);
        $('#browseprofile').attr('data-keyword','');
        $('#browseprofile').attr('data-postcommentid','');
        $('#browseprofile').modal('show');
    });
    /* end code */

    
    /* display liked user popup for post comment */
    $(document).on("click",".disp_postcommentlikes", function () {
        $('#browseprofile').attr('data-postid',$(this).attr('data-postid'));
        $('#browseprofile').attr('data-postcommentid',$(this).attr('data-postcommentid'));
        $('#browseprofile').attr('data-pageindex',1);
        $('#browseprofile').attr('data-keyword','');
        $('#browseprofile').attr('data-mediaid','');
        $('#browseprofile').modal('show');
    });
    /* end code */


    // show browse profile : on search keyword
    $(document).on('keypress', '#searchfriends', function () {

        var key = window.event.keyCode;
        if (key == 13 && $(this).val().length >= 3)
        {
            $('#browseprofile').attr('data-keyword', $(this).val());
            $('#browseprofile').attr('data-pageindex', 1);
            $('#browseprofile').modal('show');

            $(this).val(''); // setting keyword back to normal
        }
    });

    $(document).on('click', '#browseuserprofiles', function () {

        $('#browseprofile').attr('data-keyword', '');
        $('#browseprofile').attr('data-pageindex', 1);
        $('#browseprofile').modal('show');

    });

    $(document).on('click', '#loadmoreresult', function () {

        var pageindex = $(this).attr('data-currentpage');
        var postid = $('#browseprofile').attr('data-postid');
        var postcommentid = $('#browseprofile').attr('data-postcommentid');
        var mediaid = $('#browseprofile').attr('data-mediaid');
        var settype = '';
        if(postcommentid != '' && typeof(postcommentid) != 'undefined') {
            settype = 'likepostcomment';
        } else if(mediaid != '0' && mediaid != '' && typeof(mediaid) != 'undefined') {
            settype = 'likemediapost';
        } else if(postid != '' && typeof(postid) != 'undefined') {
            settype = 'likepost';
        }


        Project.showUILoader($("#listbrowseprofile"), {style: 'black', message: 'Loading ..'});
        $.ajax( {
              url: site_url + "user/getbrowseuserprofile",
              method:"POST",
              data: {
                pageindex : pageindex,
                postid:postid,
                type:settype,
                postcommentid:postcommentid,
                mediaid:mediaid,
                isfrom : 'loadmore'
              },
              success: function(response) {
                var parsed = JSON.parse(response);

                Project.hideUILoader($("#listbrowseprofile"));

                var strdata = parsed.posts_data;
                strdata = strdata.replace("<ul>", "");
                strdata = strdata.replace("</ul>", "");

                $(strdata).insertBefore("#listbrowseprofile ul li:last");

                if (parsed.nx_pg == 0) {
                    $('#loadmoreresult').hide();
                } else {
                    var datacurpage = parseInt(parsed.cr_pg) + 1;
                    $("#loadmoreresult").attr('data-currentpage', datacurpage);
                }

            }
        });

    });

    $("#browseprofile").on('hide.bs.modal', function(){
        $('#browseprofile').attr('data-postid','');
        $('#browseprofile').attr('data-keyword','');
        $('#browseprofile').attr('data-pageindex','1');
        $('#browseprofile').attr('data-postcommentid','');
        $('#browseprofile').attr('data-mediaid','');
        $("#listbrowseprofile").html('');
    });

    // browse profile on load
    $('#browseprofile').on('shown.bs.modal', function () {
        console.log('Dynamic Search Function');
        $("#listbrowseprofile").html('<i class="fas fa-spinner mr-2"></i> Loading Please Wait ..');

        var getkeyword = $(this).attr('data-keyword');
        var getpageindex = $(this).attr('data-pageindex');
        console.log('getkeyword :' + getkeyword);
        console.log('getpageindex :' + getpageindex);
        var getpostid = $(this).attr('data-postid');
        var getmediaid = $(this).attr('data-mediaid');
        var getpostcommentid = $(this).attr('data-postcommentid');

        if(getpostid != '' && typeof(getpostid) != 'undefined')
            $('#browseprofileLabel').html('User List');
        else 
            $('#browseprofileLabel').html('');

        var setsubstr = '';
        setsubstr += '?pageindex='+getpageindex;
        setsubstr += '&keyword='+getkeyword;
        setsubstr += '&postid='+getpostid;
        setsubstr += '&postcommentid='+getpostcommentid;
        setsubstr += '&mediaid='+getmediaid;
        if(getpostcommentid != '' && typeof(getpostcommentid) != 'undefined') {
            setsubstr += '&type=likepostcomment';
        } else if(getmediaid != '' && getmediaid != 0 && typeof(getmediaid) != 'undefined') {
            setsubstr += '&type=likemediapost';
        } else if(getpostid != '' && typeof(getpostid) != 'undefined') {
            setsubstr += '&type=likepost';
        }

        $("#listbrowseprofile").load(site_url + "user/getbrowseuserprofile"+encodeURI(setsubstr));
    });

    $(document).on('click', '.act_followuser', function () {
        if($('#setuserid').val() != '' && typeof($('#setuserid').val()) != 'undefined') {   
            var fetchid = $(this);
            $(this).css('opacity', '0.4');
            var getid = $(this).attr('data-id');
            var getmsg = 'followactionmsg_' + getid;
            $('#' + getmsg).html('&nbsp;<img src="public/images/front/loading.gif">');
            $.ajax({
                url: site_url + "home/followuser_action",
                method: "POST",
                data: {
                    userid: $('#setuserid').val(),
                    followid: getid
                },
                success: function (data) {
                    var parsed = JSON.parse(data);

                    $(fetchid).css('opacity', '1');
                    var dispmsg = '';
                    if (parsed.success == 1) {
                        $(fetchid).html('Unfollow');
                        $(fetchid).attr('class', 'btn btn-secondary act_unfollowuser');
                        var dispmsg = 'Request sent';
                    }
                    $('#' + getmsg).html("<span style='color:" + parsed.notecolor + "'>" + dispmsg + "</span>");
                }
            });
        } else {
            window.location = site_url;
        }
    });

    $(document).on('click', '.act_unfollowuser', function () {
        var fetchid = $(this);
        $(this).css('opacity', '0.4');
        var getid = $(this).attr('data-id');
        var getmsg = 'followactionmsg_' + getid;
        $('#' + getmsg).html('&nbsp;<img src="public/images/front/loading.gif">');
        $.ajax({
            url: site_url + "home/unfollowuser_action",
            method: "POST",
            data: {
                userid: $('#setuserid').val(),
                followid: getid
            },
            success: function (data) {
                console.log('Unfollow User');
                var parsed = JSON.parse(data);
                $(fetchid).css('opacity', '1');
                var dispmsg = '';
                if (parsed.success == 1) {
                    $(fetchid).html('Follow');
                    $(fetchid).attr('class', 'btn btn-primary act_followuser');
                    //var dispmsg = 'Request sent';
                }
                $('#' + getmsg).html("<span style='color:" + parsed.notecolor + "'>" + dispmsg + "</span>");
            }
        });
    });

    $(document).on('click', '.act_cancelfollowrequest', function () {
        var fetchid = $(this);
        $(this).css('opacity', '0.4');
        var getid = $(this).attr('data-id');
        var getmsg = 'followactionmsg_' + getid;
        $('#' + getmsg).html('&nbsp;<img src="public/images/front/loading.gif">');
        $.ajax({
            url: site_url + "home/followuser_action",
            method: "POST",
            data: {
                userid: $('#setuserid').val(),
                followid: getid,
                pendingrequestid: $(this).attr('data-pendingrequestid'),
                btnactval: 'Deleted'
            },
            success: function (data) {
                var parsed = JSON.parse(data);

                var dispmsg = '';
                $(fetchid).css('opacity', '1');
                if (parsed.success == 1) {
                    $(fetchid).html('Follow');
                    $(fetchid).attr('class', 'btn btn-primary act_followuser');
                }
                $('#' + getmsg).html("<span style='color:" + parsed.notecolor + "'>" + dispmsg + "</span>");
            }
        });
    });
    /*$(document).on('click', '.like-post', function () {
     $(".like-post i").removeClass("far");
     $(".like-post i").addClass("fas");
     $(this).addClass("active");
     });*/
    
    if(is_logged == "Yes"){
        notify_interval = setInterval(update_notifications,60000);
    }

});

function update_notifications() {
    var notification_count = "";
    
    $.ajax({
        type: "get",
        url: site_url + "user/notification_count",
        dataType: 'json',
        success: function (response) {
            if (response.status == "Success") {
                notification_count = response.notification_count;
                if (parseInt(notification_count) > 0) {
                    $(".notify_display").html('<span class="badge">' + notification_count + '</span>');
                } else {
                    $(".notify_display").html('');
                }
            } else {
                //console.log("User session out")
                clearInterval(notify_interval);
            }
        }
    });
}

function media_slider_init() {
    // Media slider
    $('.media_slider').owlCarousel({
        loop: true,
        margin: 10,
        items: 1,
        dots: false,
        nav: true,
        video: true,
        autoHeight:true,
        navText: [
            '<i class="fas fa-angle-left"></i>',
            '<i class="fas fa-angle-right"></i>'
        ],
    });

    (function ($) {
        $('.post-circle').circleProgress({
            size: 50,
            fill: '#f27373',
            startAngle: -Math.PI / 4 * 0,
        });
    })(jQuery);
}


$('#logout_btn').on('click', function () {
    var href = $(this).attr('data-href');
    firebase.auth().signOut().then(function () {
        console.log('Logout');
        window.location.href = href;
    }).catch(function (error) {
        console.log('Logout Fail');
    });
});

$('.suggestion-post-detail').on('click', function () {
    var post_id = $(this).attr('data-id');
    if(post_id > 0){
        window.location.href = $(this).attr('data-href');
    }else{
        return false;
    }
});


// Custom Scrollbar
$(".scrollbarContent").mCustomScrollbar({
    theme:"minimal",
    scrollbarPosition:"outside",
});


// For Video search when user logout

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchvideo');
    var searchIcon = document.getElementById('searchIcon');

    searchInput.addEventListener('input', function() {
        searchIcon.style.display = 'none';
    });

    searchInput.addEventListener('blur', function() {
        if (this.value === '') {
            searchIcon.style.display = 'inline-block';
        }
    });

    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form submission
            handleSearch(); // Call your search function
        }
    });
});

function handleSearch() {
    var searchValue = document.getElementById('searchvideo').value;
    console.log("Search Value:", searchValue);
    // Trigger an AJAX request or any other search function here

    $.ajax( {
        url: site_url + "user/videosearch",
        method:"POST",
        data: {
            //   postid:postid,
            //   type:settype,
            //   postcommentid:postcommentid,
            //   mediaid:mediaid,
            //   isfrom : 'loadmore'
            pageindex : 1,
            keyword : searchValue,
        },
        success: function(response) {
            var parsed = JSON.parse(response);
            console.log(parsed);
            Project.hideUILoader($("#listbrowseprofile"));

            var strdata = parsed.keyword;
            console.log('strdata'+ strdata);
            //   strdata = strdata.replace("<ul>", "");
            //   strdata = strdata.replace("</ul>", "");
            // Check if strdata is not empty
            if (strdata !== '') {
                // Open the modal
                $('#browseprofile').modal('show');

                // Clear existing content in the modal (optional)
                $("#listbrowseprofile").empty();

                // Assuming strdata is an array of objects, loop through the data
                // parsed.resultarr.forEach(function(row) {
                //     var html = `
                //         <div class="video-item">
                //             <div class="video-box">
                //                 <div class="video-img-box" style="border-radius: 50%; height: 12rem; width: 88%">
                //                     <img class="search-image" src="${row.u_profile_image}" alt="">
                //                 </div>
                //                 <div class="video-content">
                //                     <a href="${row.profile_url}">
                //                         <p><strong>${row.u_name}</strong></p>
                //                         <p class="follower-tilte">Followers: ${row.follower_count}</p>
                //                         <p class="follower-tilte">Following: ${row.following_count}</p>
                //                     </a>
                                    
                //                 </div>
                //             </div>
                //         </div>
                //     `;

                //     // Append the HTML to the modal content
                //     $("#listbrowseprofile").append(html);
                // });
            }

            if (parsed.nx_pg == 0) {
                $('#loadmoreresult').hide();
            } else {
                var datacurpage = parseInt(parsed.cr_pg) + 1;
                $("#loadmoreresult").attr('data-currentpage', datacurpage);
            }
        }
  });
}







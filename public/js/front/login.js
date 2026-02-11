Project.modules.submitlogin = (function () {
    var objReturn = {};
    
    function init() {
        var timezoneval = Intl.DateTimeFormat().resolvedOptions().timeZone;
        if ($.trim(timezoneval) != "") {
            $.ajax({
                type: "post",
                url: site_url + "content/setUserTimezone",
                data: {timezoneval:timezoneval},
                success: function (response) {
                    console.log('NewData',response);
                }
            });
        }
        
        Common.initValidator();
        //setLoginValidate();

        $('#submitlogin').click(function(e) {
            setLoginValidate();
        });

       

        // php version call
        $('.fblogin').click(function(e) {
            e.preventDefault();
            window.open($(this).attr('href'), 'fbloginwindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
            return false;
        });

        /*var fbappId = $(".fblogin_js").data('id');
        window.fbAsyncInit = function() {
            FB.init({
                appId: fbappId, // replace your app id here
                cookie: true,
                version: 'v2.9'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        $(".fblogin_js").click(function() {
            FB.login(function(response) {
                if (response.authResponse) {
                    window.location.href = "index.php?file=m-facebook_login";
                }
            }, {
                scope: 'email,user_likes'
            });
        });*/


        $('.googlelogin').click(function(e) {
            e.preventDefault();
            window.open($(this).attr('href'), 'googleloginwindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
            return false;
        });

        //Project.showUILoader($("#main-container"), {style: 'black'});
    }
    function setLoginValidate() {
        $('#frmlogin').validate({
            rules: {
                'User[vLoginEmail]': {
                    required: true,
                    email:true
                },
                'User[vLoginPassword]': {
                    required: true
                }
            },
            messages: {
                'User[vLoginEmail]': {
                    required: 'Please enter Email',
                    email : 'Please enter valid Email'
                },
                'User[vLoginPassword]': {
                    required: 'Please enter Password'
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr('name')) {
                    $('#' + element.attr('id') + 'Err').html(error);
                } 
            }, submitHandler: function(form) {
                
               $("#submitlogin").html("Processing..").css("opacity","0.4");
               form.submit();
            }
        });
    }
    
    objReturn.init = init;
    return objReturn;
})();
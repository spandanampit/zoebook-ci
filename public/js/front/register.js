Project.modules.signup = (function () {
    var objReturn = {}
    
    function init() {

        Common.initValidator();

        jQuery.validator.addMethod("strictphone", function(value, element) {
          return this.optional(element) || /^[\d ()+-]+$/.test(value);
        }, "Please enter valid Phone Number");
         jQuery.validator.addMethod("validemail", function(value, element) {
          return this.optional(element) || /^([\w-\.+]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/.test(value);
        }, "Please enter valid email");
        
        $(document).on('keypress', '#vPhone', function (evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            console.log(charCode)
             if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                if(charCode  == '32' || charCode  == '43') {
                    return true;
                }
                return false;
            }
             return true;
        });

        $("#signup").click(function () {
            setSignupValidate();
            submit_customerdata();
        });

        $("#cancelsignup").click(function () {
            $('#frmregister')[0].reset();
        });

        $("#signupModal").on('hide.bs.modal', function(){
            $('#frmregister')[0].reset();
        });

        $("#profile_image").change(function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = $("#imagePreview");
                dvPreview.html("");            
                $($(this)[0].files).each(function () {
                    var file = $(this);                
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            dvPreview.attr("src", e.target.result);
                        }
                        reader.readAsDataURL(file[0]);                
                });
            } else {
                console.log("This browser does not support HTML5 FileReader.");
            }
        });
    }
    function submit_customerdata() {
        var vld = $('#frmregister').valid();
        var cont_frm_handler = $('#frmregister');
        if (!vld) {
            return false;
        } else {
            //Project.showUILoader($("#main-container"), {style: 'black'});
            Project.showUILoader($("#signupModal"), {style: 'black', message:'Processing Please wait ..'});
            //$('#signup').html('Processing').css('opacity','0.4');
            cont_frm_handler.submit();
        }
    }
    function setSignupValidate() {
        $('#frmregister').validate({
            rules: {
                'User[vName]': {
                    required: true,
                  //  lettersonly:true
                },
                'User[vEmail]': {
                    required: true,
                    email: true,
                    validemail: true,
                    remote:{
                        url: site_url + "user/user/check_user_email",
                        type: "post"
                    }
                },
                'User[vPassword]': {
                    required: true,
                    minlength:6
                },
                'User[vConfirmPassword]': {
                    required: false,
                    equalTo: '#vPassword'
                },
                'User[vPhone]': {
                    required: false,
                    strictphone:true,
                    minlength : 6,
                    maxlength:15
                }
            },
            messages: {
                'User[vName]': {
                    required: 'Please enter Name',
                   // lettersonly: 'Please enter valid Name'
                },
                'User[vEmail]': {
                    required: 'Please enter Email',
                    email: 'Please enter valid Email',
                    validemail: '',
                    remote: "Email already exists"
                },
                'User[vPassword]': {
                    required: 'Please enter Password',
                    minlength: 'Password should contain atleast 6 characters'
                },
                'User[vConfirmPassword]': {
                    required: 'Please confirm Password',
                    equalTo: 'Password does not match'
                },
                'User[vPhone]': {
                    required: 'Please enter Phone Number',
                    strictphone: 'Please enter valid Mobile Number',
                    minlength: "Minimum 6 digits required for Mobile Number",
                    maxlength: "Mobile Number should not exceed 15 digits"
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr('name')) {
                    $('#' + element.attr('id') + 'Err').html(error);

                    Project.hideUILoader($("#signupModal"));
                }
            },
            ignore: '.ignore'
        });
    }
    
    objReturn.init = init;
    return objReturn;
})();

$("#dDOB").datepicker({ 
        defaultViewDate: 'Birthday',
        endDate:"0d",
        autoclose: true, 
        todayHighlight: true,
        format : "yyyy-mm-dd",
  }).datepicker('update', new Date()).on('hide', function(e) {
    e.stopPropagation();
  });
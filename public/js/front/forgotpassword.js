Project.modules.submitforgot = (function () {
    var objReturn = {};
    
    function init() {
        Common.initValidator();
        setForgotPasswordValidate();

        //Project.showUILoader($("#main-container"), {style: 'black'});
    }
    function setForgotPasswordValidate() {
        $('#frmforgotpassword').validate({
            rules: {
                'User[vForgotEmail]': {
                    required: true,
                    email:true
                }
            },
            messages: {
                'User[vForgotEmail]': {
                    required: 'Please enter Email',
                    email : 'Please enter valid Email'
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr('name')) {
                    $('#' + element.attr('id') + 'Err').html(error);
                } 
            }, submitHandler: function(form) {
               $("#submitforgot").html("Processing..").css("opacity","0.4");
               form.submit();
            }
        });
    }
    
    objReturn.init = init;
    return objReturn;
})();
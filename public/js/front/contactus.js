Project.modules.submitcontact = (function () {
    var objReturn = {};
    
    function init() {
        Common.initValidator();
        setContactValidate();

        //Project.showUILoader($("#main-container"), {style: 'black'});
    }
    function setContactValidate() {
        $('#frmcontact').validate({
            rules: {
                'vContactName': {
                    required: true
                },
                'vContactEmail': {
                    required: true,
                    email : true
                },
                'vContactMessage': {
                    required: true
                }
            },
            messages: {
                'vContactName': {
                    required: 'Please enter name'
                },
                'vContactEmail': {
                    required: 'Please enter email',
                    email : 'Please enter valid email'
                },
                'vContactMessage' : {
                    required : 'Please enter message'
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr('name')) {
                    $('#' + element.attr('id') + 'Err').html(error);
                } 
            }, submitHandler: function(form) {
                $.blockUI({ 
                      message: 'Processing Please wait..',
                      css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-webkit-border-radius': '10px', 
                        '-moz-border-radius': '10px', 
                        opacity: '.5', 
                        color: '#fff',
                        fontSize: '18px',
                        fontFamily: 'Verdana,Arial',
                        fontWeight: 200,
                    } }); 
               form.submit();
            }
        });
    }
    
    objReturn.init = init;
    return objReturn;
})();
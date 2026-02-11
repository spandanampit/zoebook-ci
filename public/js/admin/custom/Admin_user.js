 
function Unsubscribe(){
    //var logisticType = $('#logistic_partner').val();
    if(confirm('Are you sure you want to Unsubscribe All users?')) {
        $.ajax({
            url: "user/users/Unsubscribe_user",
            type: "POST",
            data: {'user_id': 'All'},
            dataType : 'JSON',
            beforeSend: function (){
            //$('#script_download').show();
            $('#custom_btn_2_list2_top').prop('disabled',true);
            $('#custom_btn_2_list2_top').html('<div class="btn"><span class="ui-icon ico-cutom-btn silk-icon-popout"></span><i class="fa fa-spin fa-spinner"></i> Processing...</div>'); 
            },
            
            success: function(response) {
                console.log(response);
                if(response.status=1){
                    Project.setMessage(response.message, 1);
                    $('#custom_btn_2_list2_top').prop('disabled',false);
                    $('#custom_btn_2_list2_top').html('<div class="btn"><span class="ui-icon ico-cutom-btn silk-icon-popout"></span>Unsubscribe All Users</div>');
                    setTimeout(function() {
                        location.reload();
                    }, 5000);
                }else{
                    Project.setMessage(response.message, 1);
                    $('#custom_btn_2_list2_top').prop('disabled',false);
                    $('#custom_btn_2_list2_top').html('<div class="btn"><span class="ui-icon ico-cutom-btn silk-icon-popout"></span>Unsubscribe All Users</div>');
                }
            }
        })
    }
    return false;
    //alert(user_ids);
 }
 
 
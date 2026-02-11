$(document).ready(function() {
    $('#frmbtn_add').hide();
});

function SendNow(){
     $('#mlh_useridErr').append(' ');
     $('#selectusersErr').append(' ');
     $('#mlh_email_template_idErr').append(' ');
     
     var selectType = ($("input[name='selectusers']:checked").val());
     var users = $("input[name='mlh_userid']").val();
     var template_id = $('#mlh_email_template_id :selected').text();
    
    
     if(selectType == 'Select'){
       if(!users){
         $('#mlh_useridErr').append('<div for="mlh_userid" generated="true" class="err" style="padding-left: 0px;">Please enter a value for the select users field.</div>');
       }
     }else if(selectType == 'All'){
         users ="All";
     }else{
         $("#selectusersErr").append('<div for="selectusers" generated="true" class="err" style="padding-left: 0px;">Please enter a value for the select field.</div>');
     }
     if(!template_id){
         $("#mlh_email_template_idErr").append('<div for="mlh_email_template_id" generated="true" class="err" style="padding-left: 0px;">Please enter a value for the email template field.</div>');
     }
     
     
     if(selectType && users && template_id){
     if(confirm("Are you sure you want to send mail")){
        $.ajax({
               type: 'post',
               url: 'user/bulk_mailer/SendNow',
               data: new FormData($('#frmaddupdate')[0]),
               dataType : 'JSON',
               contentType: false,
                    cache: false,
               processData:false,
               dataType : 'JSON',
               beforeSend: function (){
                if(users=="All"){
                    Project.setMessage('Please wait... sending email to all will take sometime!!!', 1);
                }
                $('#script_download').show();
                $('#frmbtn_custom_custom_btn_add_1').prop('disabled',true);
                $('#frmbtn_custom_custom_btn_add_1').html('<i class="fa fa-spin fa-spinner"></i> Processing...'); 
               },
               success:function(resp){
               console.log(resp);
                if(resp.status==1){
                    $('#script_download').hide();
                    $('#frmbtn_custom_custom_btn_add_1').prop('disabled',false);
                    $('#frmbtn_custom_custom_btn_add_1').html('Send Now');
                    $('#script_download').hide();
                    Project.setMessage(resp.massage, 1);
                    $("#frmaddupdate")[0].reset();
                    $('#frmbtn_discard').trigger("click");
                    //Project.setMessage(resp.massage, 1);
                }else{
                   $('#frmbtn_custom_custom_btn_add_1').prop('disabled',false);
                   $('#frmbtn_custom_custom_btn_add_1').html('Send Now'); 
                   $('#script_download').hide();
                   Project.setMessage(resp.massage, 0);
                }
             }
         });
         }
        }
     return false;
}


function SaveNow(){
     $('#mlh_useridErr').append(' ');
     $('#selectusersErr').append(' ');
     $('#mlh_email_template_idErr').append(' ');
     
     var selectType = ($("input[name='selectusers']:checked").val());
     var users = $("input[name='mlh_userid']").val();
     var template_id = $('#mlh_email_template_id :selected').text();
     //alert(template_id);
     
     if(selectType == 'Select'){
       if(!users){
         $('#mlh_useridErr').append('<div for="mlh_userid" generated="true" class="err" style="padding-left: 0px;">Please enter a value for the select users field.</div>');
       }
     }else if(selectType == 'All'){
         users ="All";
     }else{
         $("#selectusersErr").append('<div for="selectusers" generated="true" class="err" style="padding-left: 0px;">Please enter a value for the select field.</div>');
     }
     if(!template_id){
         $("#mlh_email_template_idErr").append('<div for="mlh_email_template_id" generated="true" class="err" style="padding-left: 0px;">Please enter a value for the email template field.</div>');
     }
     
     if(selectType && users && template_id){
     if(confirm("Are you sure you want to add sent mail")){
      $.ajax({
           type: 'post',
           url: 'user/bulk_mailer/SaveNow',
           data: new FormData($('#frmaddupdate')[0]),
           dataType : 'JSON',
           contentType: false,
                cache: false,
           processData:false,
           dataType : 'JSON',
           beforeSend: function (){
            $('#script_download').show();
            $('#frmbtn_custom_custom_btn_add_2').prop('disabled',true);
            $('#frmbtn_custom_custom_btn_add_2').html('<i class="fa fa-spin fa-spinner"></i> Processing...'); 
            },
           success:function(resp){
            console.log(resp);
            if(resp.status==1){
              $('#script_download').hide();
              $('#frmbtn_custom_custom_btn_add_2').prop('disabled',false);
              $('#frmbtn_custom_custom_btn_add_2').html('Save Now');
              $('#script_download').hide();
              $("#frmaddupdate")[0].reset();
              Project.setMessage(resp.massage, 1);
              $('#frmbtn_discard').trigger("click");
            }else{
             $('#frmbtn_custom_custom_btn_add_2').prop('disabled',false);
             $('#frmbtn_custom_custom_btn_add_2').html('Save Now'); 
             $('#script_download').hide();
             Project.setMessage(resp.massage, 0);
            }
         } 
     });
      }
    }
    return false;
}


function EditPosttSubmit(){
     $.ajax({
           type: 'post',
           url: site_url+'Timeline/edit_post',
           data: new FormData($('#edit_form_post')[0]),
           dataType : 'JSON',
           contentType: false,
                cache: false,
           processData:false,
           dataType : 'JSON',
     beforeSend: function (){
          $('.postedit_btn').prop('disabled',true);
          $('.postedit_btn').html('<i class="fa fa-spin fa-spinner"></i> Processing...'); 
         },
        success:function(resp){

            if(resp.status==1){
               location.reload();
               toastr.success(resp.msg);
            }

            if(resp.status==0){
              $('.postedit_btn').prop('disabled',false);
              $('.postedit_btn').html('Kick it');
              toastr.error(resp.msg);
            }
         }
     });
    return false;
}

/*$(document).ready(function(){
  $("#frmbtn_custom_custom_btn_add_1").click(function(){
    alert("The paragraph was clicked.");
  });
});*/
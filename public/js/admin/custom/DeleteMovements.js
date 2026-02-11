function DeleteMovements(){
    //var logisticType = $('#logistic_partner').val();
    var item_id_arr = [];
    var checked_elements = $("body").find("[aria-selected='true']");
    checked_elements.each(function() {
         item_id_arr.push($(this).attr('id'));
    });
    
    var item_ids = item_id_arr.join();
    
    if(checked_elements.length > 0){
        var mess = "Are you sure you want to Delete Movement and mevement Post.";
        if(checked_elements.length > 1){
        var mess = "Are you sure you want to Delete Movements and mevements related Post.";
        }
        
        if(confirm(mess)){
            $.ajax({
                type: 'post',
                url: 'post/Movements/DeleteMovements',
                data: {movements_id:item_ids},
                dataType : 'JSON',
                beforeSend: function (){
                  //Project.setMessage('Please wait... deleleting All information in movement related to will take sometime!!!', 1);
                    $('#custom_btn_1_list2_top').prop('disabled',true);
                    $('#custom_btn_1_list2_top').html('<div class="btn"><span class="ui-icon ico-cutom-btn silk-icon-popout"></span><i class="fa fa-spin fa-spinner"></i> Processing...</div>'); 
                },
                success:function(resp){
                    console.log(resp);
                    if(resp.status==1){
                        $('#custom_btn_1_list2_top').prop('disabled',false);
                        $('#custom_btn_1_list2_top').html('<div class="btn"><span class="ui-icon ico-cutom-btn icomoon-icon-remove-6"></span>Delete</div>');
                        Project.setMessage(resp.massage, 1);
                        
                        setTimeout(function() {
                            location.reload();
                        }, 4000);
                    }else{
                       $('#custom_btn_1_list2_top').prop('disabled',false);
                       $('#custom_btn_1_list2_top').html('<div class="btn"><span class="ui-icon ico-cutom-btn icomoon-icon-remove-6"></span>Delete</div>'); 
                       Project.setMessage(resp.massage, 0);
                    }
                }
            });
        }    
    }else{
        alert("Please select movement");
    }
}

/*$(document).on('click',".delete_custom_order",function(){
    var movementImageId = $(this).data('movement-id');
    //alert(movementImageId);
        if(confirm("Are you sure you want to Delete Movement image")){
            $.ajax({
                type: 'post',
                url: 'post/Movements_image/delete_movement_image',
                data: {movementImageId:movementImageId},
                dataType : 'JSON',
                beforeSend: function (){
                $('.delete_movement_id-'+movementImageId).prop('disabled',true);
                },
                success:function(resp){
                    if(resp.status==1){
                        $('.delete_movement_id-'+movementImageId).prop('disabled',false);
                        Project.setMessage(resp.massage, 1);
                        setTimeout(function() {
                            location.reload();
                        }, 4000);
                    }else{
                        $('.delete_movement_id-'+movementImageId).prop('disabled',false);
                       // //Project.setMessage(resp.massage, 0);
                    }
                }
            });
        } 
  });*/
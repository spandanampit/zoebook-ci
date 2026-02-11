
  $(document).on('click',".delete_custom_order",function(){
    var movementImageId = $(this).data('movement-id');
    alert(movementImageId);
        if(confirm("Are you sure you want to Delete Movements image")){
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
  });

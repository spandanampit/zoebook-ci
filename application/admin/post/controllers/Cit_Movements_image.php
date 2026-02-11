<?php


/**
 * Description of Movements Image Extended Controller
 * 
 * @module Extended Movements Image
 * 
 * @class Cit_Movements_image.php
 * 
 * @path application\admin\post\controllers\Cit_Movements_image.php
 * 
 * @author CIT Dev Team
 * 
 * @date 22.11.2021
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

Class Cit_Movements_image extends Movements_image {
        public function __construct()
{
    parent::__construct();
}

public function get_delete_movement_image_lik($value = '',$id = '',$data = array()){
     $ret_val = '<a href="javascript:void(0);" title="Delete Movement image" data-movement-id = '.$data['mi_movement_images_id'].' class="fa fa-trash fa-2x delete_custom_order delete_movement_id-'.$data['mi_movement_images_id'].'" style="color:#ff531a;cursor: pointer"></a>';
     return $ret_val; 
}

public function delete_movement_image(){
    $PostData=$this->input->post('movementImageId');
    $jsonData['status']=0;
    $JsonReturn['massage'] = 'Something went wrong please try again later';
    if(!empty($PostData)){
        $this->db->where('iMovementImagesId',$PostData);
        $this->db->delete('movement_images');
        $jsonData['status']=1;
        $jsonData['massage']='Movement image has been deleted successfully.';
    }
    echo json_encode($jsonData);
}
}

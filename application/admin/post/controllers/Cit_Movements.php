<?php


/**
 * Description of Movements Extended Controller
 * 
 * @module Extended Movements
 * 
 * @class Cit_Movements.php
 * 
 * @path application\admin\post\controllers\Cit_Movements.php
 * 
 * @author CIT Dev Team
 * 
 * @date 24.11.2021
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

Class Cit_Movements extends Movements {
        public function __construct()
{
    parent::__construct();
}

public function DeleteMovements(){
    $movements_id=$this->input->post('movements_id');
    $JsonReturn['status'] = 0;
    $JsonReturn['massage'] = 'Please Select Movement';
    if(!empty($movements_id)){
       $JsonReturn['massage'] = 'Something went wrong please try again later';
       
       $movement_id = explode(' ',$movements_id);
       if(strlen(trim($movements_id)) > 2){
       $movement_id = explode(',',$movements_id);
       }
       
       $movementId=implode("','",$movement_id);
       if(!empty($movementId)){
           $where = "iMovementsId IN ('".$movementId."')";
           $this->db->where($where);
           $this->db->delete('movements');
           
           $JsonReturn['status'] = 1;
           $JsonReturn['massage'] = 'Movement has been delete succesfully';
       }
    }
    echo json_encode($JsonReturn);
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

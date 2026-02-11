<?php

   
/**
 * Description of Delete movement cron job Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Delete movement cron job
 *
 * @class Cit_Delete_movement_cron_job.php
 *
 * @path application\webservice\post\controllers\Cit_Delete_movement_cron_job.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 21.07.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Delete_movement_cron_job extends Delete_movement_cron_job {
        public function __construct()
{
    parent::__construct();
}


public function DeleteDataPhysically($input_params = array()){
    $this->load->library('general');
    $this->db->select('iMovementsId,iSysRecDeleted');
    $this->db->where('iSysRecDeleted',1);
    $movements = $this->db->get('movements')->result_array();
    if(!empty($movements)){
        foreach($movements as $key => $MovementValue){
          
            /*Delete movements posts*/
            $this->db->select('iPostId,iUserId');
            $this->db->where('iMovementsId',$MovementValue['iMovementsId']);
            $postData = $this->db->get('post')->result_array();
           
            if(!empty($postData)){
                foreach ($postData as $key => $PostValue){
                    /*Post media file unlink*/
                    $this->db->select('iPostId,iUserId,eMediaType,vUploadFile,vVideoThumbnail');
                    $this->db->where('iPostId',$PostValue['iPostId']);
                    $PostMediaData = $this->db->get('post_media')->result_array();
                    if($PostMediaData){
                        foreach ($PostMediaData as $key => $PostMediaValue){
                            if(!empty($PostMediaValue['vUploadFile'])){
                                $Folder = 'compress_post_media/'.$PostMediaValue['iUserId'];
                                $FileName = $PostMediaValue['vUploadFile'];
                                $dataresult=$this->general->deleteAWSFileData($Folder,$FileName);   
                            }  
                        }
                    }
                    $where = "ipost = '".$PostValue['iPostId']."'";                  
                    $where_p = "ipost = ".$PostValue['iPostId']." or iActualPostId = ".$PostValue['iPostId']."";                  
                    $this->db->where($where);
                    $this->db->delete('post_media');
                    $this->db->where($where_p);
                    $this->db->delete('post');
                }
            }
            
           
            /*delete movements image*/
            $this->db->select('iMovementsId,vUploadFile,vVideoTumbnail');
            $this->db->where('iMovementsId',$MovementValue['iMovementsId']);
            $MovementImage = $this->db->get('movement_images')->result_array();
            
            if(!empty($MovementImage)){
               foreach ($MovementImage as $key => $ImageMoveValue){
                   if(!empty($ImageMoveValue['vUploadFile'])){
                      $Folder = 'compress_movements_files/'.$ImageMoveValue['iMovementsId'];
                      $FileName = $ImageMoveValue['vUploadFile'];
                      $dataresult=$this->general->deleteAWSFileData($Folder,$FileName);
                   }
               }
            }
            $this->db->where('iMovementId',$MovementValue['iMovementsId']);
            $this->db->delete('user_notifications');
            $this->db->where('iMovementId',$MovementValue['iMovementsId']);
            $this->db->delete('movement_users');
            $this->db->where('iMovementsId',$MovementValue['iMovementsId']);
            $this->db->delete('movement_images');
            $this->db->where('iMovementsId',$MovementValue['iMovementsId']);
            $this->db->delete('movements');
        }
    }
  
}
}

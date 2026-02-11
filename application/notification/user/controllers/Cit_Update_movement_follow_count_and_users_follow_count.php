<?php
  

/**
 * Description of Update movement follow count And Users Follow count Extended Controller
 * 
 * @module Extended Update movement follow count And Users Follow count
 * 
 * @class Cit_Update_movement_follow_count_and_users_follow_count.php
 * 
 * @path application
otification\user\controllers\Cit_Update_movement_follow_count_and_users_follow_count.php
 * 
 * @author CIT Dev Team
 * 
 * @date 25.04.2022
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Update_movement_follow_count_and_users_follow_count extends Update_movement_follow_count_and_users_follow_count {
        public function __construct()
{
    parent::__construct();
}

/*this function use to update movement count follower count and */
public function AddedCustumQuery(){
    
   /*truncate table movement_user_count*/
   $this->db->query("delete from movement_user_count where iMovementId>0");
   
   //echo $this->db->last_query(); die();
   
   /*insert movement count in movement_user_count table*/
   $this->db->query("insert into movement_user_count(iMovementId,iTotal)
SELECT m.iMovementsId,IFNULL(count(DISTINCT(mu.iMovementUsersId)),0) FROM movements as m left join movement_users as mu on mu.iMovementId = m.iMovementsId and mu.eStatus = 'Active'  AND mu.eAdminStatus = 'No' group by m.iMovementsId");
   
   /*truncate table user_followers2*/
  $this->db->query('delete from user_followers2 where iUserId>0');
   
   /*insert data in user_followers2 table*/
   $this->db->query("insert into user_followers2(iUserId,iFollowerId) select iUserId,iFollowerId from user_followers where eStatus = 'Accepted'");
   
   /*insert data count in user_followers2 table*/
  $this->db->query("insert into user_followers2(iUserId,iFollowerId) select iFollowerId,iUserId from user_followers where eStatus = 'Accepted'");
   
}
}

<?php
/**
 * Cron Controller
 * Handles scheduled tasks like clearing cached query directories.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends Cit_Controller {

      public function __construct() {
            parent::__construct();
      }

      /**
       * Clears all subdirectories inside the queries cache directory
       */
      public function clear_queries() {
            $queries_path = APPPATH . 'cache/queries';
        
            if (!is_dir($queries_path)) {
                log_message('error', "Queries directory does not exist: $queries_path");
                echo json_encode([
                    'status' => 'failed',
                    'message' => "Queries directory does not exist."
                ]);
                exit;
            }
        
            $items = scandir($queries_path);
            $deleted = 0;
            $failed = 0;
        
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }
        
                $item_path = $queries_path . DIRECTORY_SEPARATOR . $item;
        
                if (is_dir($item_path)) {
                    if ($this->delete_directory($item_path)) {
                        log_message('info', "Deleted directory: $item_path");
                        $deleted++;
                    } else {
                        log_message('error', "Failed to delete directory: $item_path");
                        $failed++;
                    }
                }
            }
        
            $message = "Deleted: $deleted, Failed: $failed.";
            echo json_encode([
                'status' => 'success',
                'message' => "Cleanup completed. $message"
            ]);
            exit;
        }
        

      /**
       * Recursively deletes a directory and its contents
       *
       * @param string $dir Directory path
       * @return bool True on success, false on failure
       */
      private function delete_directory($dir) {
            if (!is_dir($dir)) {
                  return false;
            }

            $items = scandir($dir);
            foreach ($items as $item) {
                  if ($item === '.' || $item === '..') {
                        continue;
                  }

                  $item_path = $dir . DIRECTORY_SEPARATOR . $item;
                  if (is_dir($item_path)) {
                        if (!$this->delete_directory($item_path)) {
                              return false;
                        }
                  } else {
                        if (!unlink($item_path)) {
                              return false;
                        }
                  }
            }

            return rmdir($dir);
      }

      /**
       * Send notifications to Inactive users
       */
      public function notifyInactiveUser() {
            $fiveHoursAgo = date('Y-m-d H:i:s', strtotime('-5 hours'));
            $threeDaysAgo = date('Y-m-d H:i:s', strtotime('-5 days'));

            $this->db->select('iUsersId, vDeviceToken, vName, dLastLogin, eDeviceType');
            $this->db->from('users');
            $this->db->where('eDeviceType !=', 'Website');
            $this->db->where('eStatus', 'Active');
            $this->db->where('vDeviceToken IS NOT NULL', null, false);
            $this->db->where('vDeviceToken !=', '');
            $this->db->where("dLastLogin BETWEEN '{$threeDaysAgo}' AND '{$fiveHoursAgo}'", null, false);

            $users = $this->db->get()->result();
            $notify_arr['message'] = "You haven't opened the app in a while. Come check what's new!";
            $notify_arr['badge'] = intval(1);
            foreach($users as $data) 
            {
                  $notify_arr['title'] = "We miss you $data->vName !";
                  $token = $data->vDeviceToken;
                  $type  = $data->eDeviceType;
                  $this->general->pushTestNotification($token, $notify_arr, $type);
            }
            $message =  count($users) . " notifications sent.";
            echo json_encode([
                'status' => 'success',
                'message' => $message
            ]);
            exit;
      }
      


}

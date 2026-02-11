<?php
defined('BASEPATH') || exit('No direct script access allowed');

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


/**
 * Description of Firebase Library
 *
 * @category libraries
 *
 * @package libraries
 *
 * @module Firebase
 *
 * @class Firebase.php
 *
 * @path application\libraries\Firebase.php
 *
 * @version 4.0
 *
 * @author Vamsi Ippe
 *
 * @since 01.11.2019
 */
class Firebase
{

    protected $CI;
    protected $serviceAccount;
    protected $database;

    public function __construct()
    {
        $this->CI = & get_instance();
        require_once($this->CI->config->item('third_party') . "firebase/vendor/autoload.php");
        
        /*if(stristr($_SERVER['REMOTE_ADDR'], '192.168') || $_SERVER['SERVER_NAME']=='localhost' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['SERVER_NAME']=='zoebook.projectspreview.net' || $_SERVER['HTTP_HOST']=='zoebook.projectspreview.net')
        {*/
            $serviceAccount = ServiceAccount::fromJsonFile($this->CI->config->item('third_party') . '/firebase/zoebook-c4e95-firebase-adminsdk-8bf7i-647da9b09e.json');
            $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://zoebook-c4e95.firebaseio.com')->create();
        /*}else{ 
            $serviceAccount = ServiceAccount::fromJsonFile($this->CI->config->item('third_party') . 'firebase/zoebook-pp-firebase-adminsdk-li2bz-be8e7e89a6.json');
            $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://zoebook-pp.firebaseio.com')->create();
        }*/
        
        /*
        $serviceAccount = ServiceAccount::fromJsonFile($this->CI->config->item('third_party') . 'firebase/zoebook-pp-firebase-adminsdk-li2bz-be8e7e89a6.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://zoebook-pp.firebaseio.com')->create();
        */
        $this->database = $firebase->getDatabase();
    }

    public function get($collection,$matchID = NULL){
        if (empty($matchID) || !isset($matchID)) { return FALSE; }
        if ($this->database->getReference($collection)->getSnapshot()->hasChild($matchID)){
            return $this->database->getReference($collection)->getChild($matchID)->getValue();
        } else {
            return FALSE;
        }
    }

    public function insert($collection,array $data) {
        if (empty($data) || !isset($data)) { return FALSE; }
        foreach ($data as $key => $value){
            $this->database->getReference()->getChild($collection)->getChild($key)->set($value);
        }
        return TRUE;
    }

    public function update($collection,array $data) {
        if (empty($data) || !isset($data)) { return FALSE; }
        $return = $this->database->getReference()->getChild($collection)->update($data);
        return TRUE;
    }


    public function delete($collection,int $matchID) {
        if (empty($matchID) || !isset($matchID)) { return FALSE; }
        if ($this->database->getReference($collection)->getSnapshot()->hasChild($matchID)){
            $this->database->getReference($collection)->getChild($matchID)->remove();
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function push($collection,array $data) {
        if (empty($data) || !isset($data)) { return FALSE; }
        $return = $this->database->getReference($collection)->push($data);
        return TRUE;
    }

}

/* End of file Nexmo.php */
/* Location: ./application/libraries/Nexmo.php */
